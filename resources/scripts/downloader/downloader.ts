export interface FileDownload {
    url: string;
    path: string;
    sha256_hash: string;
}

// Define the ScarletIPC interface for type-checking window.scarlet methods
interface ScarletIPC {
    start_download: (destination_folder: string, files: Array<FileDownload>) => Promise<any>;
    stop_download: () => Promise<any>;
    ping: () => Promise<string>;
    get_progress: () => Promise<ScarletUpdateProgress>;

    open_admin_page_in_browser(): void;

    open_choose_install_dir(installDir: string | undefined): void;

    on_select_install_dir(param: (event: any, directory: string) => void): void;

    open_install_dir_in_explorer(installDir: string | undefined): void;

    update_available(param: (event: any, test: string) => void): void;

    update_downloaded(param: (event: any, test: string) => void): void;
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
    Initiating: 'Initiating',
    Downloading: 'Downloading',
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
    failedFiles: { [key: string]: string }; // New field for failed files
    readonly completionPercentage: number;
}

// Main ScarletDownloader class
export default class ScarletDownloader {
    public state: ScarletUpdateProgress;
    public pollingInterval: number = 100; // ms

    constructor() {
        this.state = {
            status: Status.Ready,
            filesTotal: 0,
            filesTotalCompleted: 0,
            verificationTotalCompleted: 0,
            currentFileDownloaded: 0,
            currentFileTotalSize: 0,
            currentFilePath: '',
            failedFiles: {},
            get completionPercentage() {
                if(this.filesTotal == 0) {
                    return 0;
                }

                let files_percentage = (this.filesTotalCompleted / this.filesTotal) * 100;

                if(this.currentFileTotalSize == 0) {
                    return files_percentage;
                }

                let current_file_percentage = (this.currentFileDownloaded / this.currentFileTotalSize) * 100;

                return files_percentage + (current_file_percentage / this.filesTotal);
            }
        };
    }

    public ping(): void {
        if (window.scarlet) {
            window.scarlet.ping().then((res: string) => {
                console.debug('Ping response:', res);
            }).catch((error) => {
                console.error('Ping failed:', error);
            });
        } else {
            console.error('Scarlet IPC not available');
        }
    }

    public async startDownload(destination_folder: string): Promise<void> {
        try {
            let response = await fetch('/mods');
            let data: any = await response.json();
            let test: any = await window.scarlet.start_download(destination_folder, data);
            console.log('test', test);
        } catch (error) {
            console.error('Failed to start download:', error);
        }
    }

    public async checkProgressAndContinue(): Promise<void> {
        while (true) {
            this.pollingInterval = 50
            try {
                const progress: ScarletUpdateProgress = await window.scarlet.get_progress();
                // console.debug('Progress:', progress);
                this.updateProgress(progress);

                // if (progress.status === Status.Done) {
                //     this.pollingInterval = 500;
                // }
            } catch (error) {
                this.failure(error);
                break;
            }
            await new Promise(resolve => setTimeout(resolve, this.pollingInterval));
        }
    }

    private failure(error: any): void {
        console.error('Failed to download' + (error ? ': ' + error : ''), error);
    }

    private updateProgress(progress: ScarletUpdateProgress): void {
        this.state.status = progress.status;
        this.state.filesTotal = progress.filesTotal;
        this.state.filesTotalCompleted = progress.filesTotalCompleted;
        this.state.verificationTotalCompleted = progress.verificationTotalCompleted;
        this.state.currentFileDownloaded = progress.currentFileDownloaded;
        this.state.currentFileTotalSize = progress.currentFileTotalSize;
        this.state.currentFilePath = progress.currentFilePath;
        this.state.failedFiles = progress.failedFiles; // Update the failedFiles object
    }

    public async stopDownload(): Promise<void> {
        try {
            await window.scarlet.stop_download();
        } catch (error) {
            this.failure(error);
        }
    }
}

const formatFileSize = (bytes: number): string => {
    const units = ['B', 'KB', 'MB', 'GB'];
    let size = bytes;
    let unitIndex = 0;

    while (size >= 1024 && unitIndex < units.length - 1) {
        size /= 1024;
        unitIndex++;
    }

    return `${size.toFixed(1)}${units[unitIndex]}`;
};

export const formatDownloadProgress = (downloaded: number, total: number): string => {
    const downloadedStr = formatFileSize(downloaded);
    const totalStr = formatFileSize(total);
    return `${downloadedStr} / ${totalStr}`;
};

export const calculateDownloadSpeed = (
    bytesDownloaded: number,
    elapsedTimeInSeconds: number
): string => {
    const speedBytesPerSecond = bytesDownloaded / elapsedTimeInSeconds;
    return `${formatFileSize(speedBytesPerSecond)}/s`;
};
