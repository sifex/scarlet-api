import {EventEmitter} from "@billjs/event-emitter";
import {backOff} from "exponential-backoff";

export interface User {
    clanID?: string
    comment?: string
    installDir?: string
    key?: string
    remark?: string
    steamID: string
    'type'?: string
    username: string
}

type ScarletClient = {
    status: Status,
    currentFile: string
    currentPercentage: Number
}

export enum Status {
    Disconnected,
    Connected,
    Ready,
    Downloading,
    Error
}

/**
 *
 * Scarlet Downloader Class – in charge of
 * - Holding the current state of the Agent
 * - Providing an abstraction layer to communicate with the Agent
 *
 *
 */

export default class ScarletDownloader extends EventEmitter {
    public client: ScarletClient

    public user: User

    // @ts-ignore
    public websocket: WebSocket | null

    private websocket_endpoint: string = 'ws://127.0.0.1:2074'
    // private websocket_endpoint: string = 'ws://10.211.55.2:2074'

    constructor(user: User) {
        super()

        this.user = user
        this.client = {
            status: Status.Disconnected,
            currentFile: '',
            currentPercentage: 0
        }
    }

    init() {
        this.initialiseWebsockets(this.websocket_endpoint)
    }

    initialiseWebsockets(websocket_endpoint: string) {
        this.websocket = new WebSocket(websocket_endpoint)
        // @ts-ignore
        this.websocket.addEventListener('open', (evt) => this.onWebsocketOpen(evt))
        // @ts-ignore
        this.websocket.addEventListener('message', (evt) => this.onWebsocketMsg(evt))
        // @ts-ignore
        this.websocket.addEventListener('error', (evt) => this.onWebsocketError(evt))

        // Retry Logic
        this.websocket.addEventListener('close', (evt) => {
            // @ts-ignore
            this.onWebsocketClose(evt)
            // @ts-ignore
            backOff(() => this.initialiseWebsockets(websocket_endpoint), {
                startingDelay: 2000
            })
        })
    }

    onWebsocketOpen(evt: MessageEvent) {
        this.client.status = Status.Connected
        this.send('browserConnect', 'free')
    }

    onWebsocketClose(evt: MessageEvent) {
        this.client.status = Status.Disconnected
        this.fire('disconnected')
    }

    reset() {
        this.client = {
            status: this.client.status,
            currentFile: '',
            currentPercentage: 0
        }
    }

    onWebsocketMsg(evt: MessageEvent) {
        let {who, command, attribute} = this.parse(evt.data)
        // console.log('New Message')
        console.log({who, command, attribute})
        switch(command) {
            case 'browserConfirmation':
                this.send('browserConfirmation')
                this.fire('ready')
                this.client.status = Status.Ready
                break;
            case 'UpdateInstallLocation':
                this.fire('updateInstallerLocation', attribute)
                this.reset()
                break;
            case 'UpdateStatus':
                this.fire('statusUpdate', attribute)
                break;
            case 'UpdateFile':
                this.client.currentFile = attribute
                this.fire('fileUpdate', attribute)
                break;
            case 'UpdateProgress':
                this.client.currentPercentage = Number.parseFloat(attribute)
                this.fire('progressUpdate', attribute)
                break;
            case 'Completed':
                this.client.status = Status.Ready
                this.fire('complete')
                break;
        }
    }

    onWebsocketError(evt: MessageEvent) {
        this.client.status = Status.Error
    }

    send(command: string, attribute: string = '') {
        // @ts-ignore
        return this.websocket.send('Updater|' + command + (attribute ? '|' + attribute : ''))
    }

    parse(string: string) {
        console.log(string)
        let [who, command, attribute, ...other]: string[] = string.split('|')
        return {who, command, attribute, other: other.join(' ')}
    }

    /**
     * Scarlet Methods
     */

    showLocationDialog() {
        this.send('locationChange', ' 123')
    }

    startDownload() {
        this.reset()
        this.client.status = Status.Downloading
        this.send('startDownload', this.user.installDir ?? '')
        this.fire('downloading')
    }

    stopDownload() {
        this.client.status = Status.Ready
        this.send('stopDownload', this.user.installDir ?? '')
        this.fire('ready')
        this.reset()
    }
}
