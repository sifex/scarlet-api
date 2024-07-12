import {EventEmitter} from "@billjs/event-emitter";

// Define the ScarletIPC interface for type-checking window.scarlet methods
interface ScarletIPC {
    start_download: (destination_folder: string) => Promise<any>;
    stop_download: () => Promise<any>;
    ping: () => Promise<string>;
    get_progress: () => Promise<ScarletUpdateProgress>;

    open_admin_page_in_browser(): void;

    open_choose_install_dir(installDir: string | undefined): void;

    on_select_install_dir(param: (event: any, directory: string) => void): void;
}

// Extend the global Window interface to include the scarlet property
declare global {
    interface Window {
        scarlet: ScarletIPC;
    }
}

// Define the possible status values as a const object
export const Status = {
    NotReady: 'NotReady',
    Ready: 'Ready',
    InitialCheck: 'InitialCheck',
    Downloading: 'Downloading',
    Verifying: "Verifying",
    Done: 'Done',
    Error: 'Error',
} as const;

// Create a type from the Status object keys
export type Status = typeof Status[keyof typeof Status];

// Define the structure for the update progress
export interface ScarletUpdateProgress {
    status: Status;
    filesTotal: number;
    filesTotalCompleted: number;
    verificationTotalCompleted: number;
    currentFileDownloaded: number;
    currentFileTotalSize: number;
    currentFilePath: string;
    readonly completionPercentage: number;
}

// Main ScarletDownloader class
export default class ScarletDownloader {
    public state: ScarletUpdateProgress;
    private pollingInterval: number = 100; // ms

    constructor() {
        this.state = {
            status: Status.NotReady,
            filesTotal: 0,
            filesTotalCompleted: 0,
            verificationTotalCompleted: 0,
            currentFileDownloaded: 0,
            currentFileTotalSize: 0,
            currentFilePath: '',
            get completionPercentage() {
                return this.filesTotal === 0 ? 0 : (this.filesTotalCompleted / this.filesTotal) * 100;
            }
        };
    }

    public ping(): void {
        if (window.scarlet) {
            console.debug('Pinging Scarlet');
            window.scarlet.ping().then((res: string) => {
                console.debug('Ping response:', res);
                if (res === 'pong') {
                    this.updateStatus(Status.Ready);
                }
            }).catch((error) => {
                console.error('Ping failed:', error);
                this.updateStatus(Status.Error);
            });
        } else {
            console.error('Scarlet IPC not available');
            this.updateStatus(Status.Error);
        }
    }

    private updateStatus(newStatus: Status): void {
        this.state.status = newStatus;
    }

    private reset(): void {
        this.state.status = Status.NotReady;
        this.state.filesTotal = 0;
        this.state.filesTotalCompleted = 0;
        this.state.verificationTotalCompleted = 0;
        this.state.currentFileDownloaded = 0;
        this.state.currentFileTotalSize = 0;
        this.state.currentFilePath = '';
    }

    public async startDownload(destination_folder: string): Promise<void> {
        try {
            this.reset();
            this.updateStatus(Status.Downloading);
            await window.scarlet.start_download(destination_folder).then((test) => {
                console.log('test', test);
                return this.checkProgressAndContinue();
            });
        } catch (error) {
            console.error('Failed to start download:', error);
            this.updateStatus(Status.Error);
        }
    }

    private async checkProgressAndContinue(): Promise<void> {

        await new Promise(resolve => setTimeout(resolve, 100));
        while (this.state.status === Status.Downloading || this.state.status === Status.Verifying) {
            try {
                const progress: ScarletUpdateProgress = await window.scarlet.get_progress();
                this.updateProgress(progress);

                if (progress.status === Status.Done) {
                    this.updateStatus(Status.Ready);
                    break;
                }
            } catch (error) {
                console.error('Error checking progress:', error);
                this.updateStatus(Status.Error);
                break;
            }
            await new Promise(resolve => setTimeout(resolve, this.pollingInterval));
        }
    }

    private updateProgress(progress: ScarletUpdateProgress): void {
        this.state.status = progress.status;
        this.state.filesTotal = progress.filesTotal;
        this.state.filesTotalCompleted = progress.filesTotalCompleted;
        this.state.verificationTotalCompleted = progress.verificationTotalCompleted;
        this.state.currentFileDownloaded = progress.currentFileDownloaded;
        this.state.currentFileTotalSize = progress.currentFileTotalSize;
        this.state.currentFilePath = progress.currentFilePath;
    }

    public async stopDownload(): Promise<void> {
        try {
            await window.scarlet.stop_download();
            this.reset();
            this.updateStatus(Status.Ready);
        } catch (error) {
            console.error('Failed to stop download:', error);
            this.updateStatus(Status.Error);
        }
    }

    public openAdminPageInBrowser(): void {
        if (window.scarlet) {
            window.scarlet.open_admin_page_in_browser();
        } else {
            console.error('Scarlet IPC not available');
        }
    }
}
