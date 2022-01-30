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
    status: ClientStatus,
    attemptNo: number,
    currentFile: string
}

export enum ClientStatus {
    Disconnected,
    Connected,
    Ready,
    Downloading,
    Error
}

export default class ScarletDownloader {
    public client: ScarletClient

    public user: User

    public websocket: WebSocket

    constructor(user: User, websocket_endpoint = 'ws://127.0.0.1:2074') {
        this.user = user
        this.client = {
            status: ClientStatus.Disconnected,
            attemptNo: 0,
            currentFile: ''
        }
        this.websocket = new WebSocket(websocket_endpoint)
        this.websocket.addEventListener('open', (evt) => this.onWebsocketOpen(evt))
        this.websocket.addEventListener('close', (evt) => this.onWebsocketClose(evt))
        this.websocket.addEventListener('message', (evt) => this.onWebsocketMsg(evt))
        this.websocket.addEventListener('error', (evt) => this.onWebsocketError(evt))
    }

    onWebsocketOpen(evt: Event) {
        this.client.status = ClientStatus.Connected
        this.send('test')
        console.log("connected")
    }

    onWebsocketClose(evt: Event) {
        this.client.status = ClientStatus.Disconnected
        // console.log(this)
    }

    onWebsocketMsg(evt: Event) {
        // let { abc } = evt.data
        console.log(evt)
    }

    onWebsocketError(evt: Event) {
        this.client.status = ClientStatus.Error
    }

    send(command: string, attribute: string = '') {
        return this.websocket.send('Updater|' + command + (attribute ? '|' + attribute : ''))
    }

    /**
     * Scarlet Methods
     * @param location
     */

    updateInstallLocation(location: string) {
        return this.send('locationChange', location)
    }

    startDownload() {
        this.send('startDownload', this.user.installDir ?? '')
        this.client.status = ClientStatus.Downloading
    }

    stopDownload() {
        this.send('stopDownload', this.user.installDir ?? '')
        this.client.status = ClientStatus.Ready
    }
}
