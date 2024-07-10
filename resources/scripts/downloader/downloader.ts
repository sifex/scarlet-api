import {EventEmitter} from "@billjs/event-emitter";
import {backOff} from "exponential-backoff";
import type {User} from "@/scripts/downloader/user";

// Define an interface for your custom IPC bindings
interface ScarletIPC {
    start_download: (destination_folder: string) => void;
    stop_download: () => void;
    ping: () => Promise<string>;

    on_status_update: (callback: (event: any, status: string, num: number, max: number, message: string) => void) => void;
}

// Extend the global Window interface
declare global {
    interface Window {
        scarlet: ScarletIPC;
    }
}

type ScarletClient = {
    status: Status,
    currentFile: string
    currentPercentage: Number
}

export enum Status {
    NotReady,
    Ready,
    Verifying,
    Downloading,
    Error
}

export default class ScarletDownloader extends EventEmitter {
    public client: ScarletClient

    constructor() {
        super()

        this.client = {
            status: Status.NotReady,
            currentFile: '',
            currentPercentage: 0
        }

        this.register_event_listeners()

        // Start with a ping to check if the agent is ready
        this.ping()
    }

    register_event_listeners() {
        window.scarlet.on_status_update((event: any, status: string, num: number, max: number, message: any) => {
            if (status === 'done') {
                this.client.status = Status.Ready
                this.fire('statusUpdate', {data: "Done"})
                this.fire('ready')
            } else if (status === 'downloading') {
                this.fire('statusUpdate', {data: "Downloading..."})
                this.client.currentFile = message
                this.client.currentPercentage = Math.floor((num / max)) * 100
            }
            this.fire('fileUpdate', {data: message})
            console.log('Status update:', status, num, max, message)
            // this.client.status = Status[status as keyof typeof Status]
            // this.fire('status_update', status)
        })
    }

    ping() {
        if (window.scarlet) {
            console.debug('Pinging Scarlet')
            window.scarlet.ping().then((res: string) => {
                console.debug('Ping response:', res)
                if (res === 'pong') {
                    this.client.status = Status.Ready
                    this.fire('ready')
                }
            })
        }
    }

    reset() {
        this.client = {
            status: this.client.status,
            currentFile: '',
            currentPercentage: 0
        }
    }

    startDownload(destination_folder: string) {
        window.scarlet.start_download(
            destination_folder
        )
        this.reset()
        this.client.status = Status.Downloading
        this.fire('downloading')
    }

    stopDownload() {
        window.scarlet.stop_download()
        this.client.status = Status.Ready
        this.reset()
        this.fire('ready')
    }
}
