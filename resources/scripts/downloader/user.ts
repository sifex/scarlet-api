import {MemberType} from "@/scripts/aaf/membertypes";

export interface UserInterface {
    id?: string
    uuid?: string
    username: string
    'type'?: keyof MemberType
    playerID: string
    comment?: string
    installDir?: string
    remark?: string
    deleted_at?: string
    last_download_time?: string
    last_login_time?: string
}

export class User implements UserInterface {
    public id?: string;
    public uuid?: string;
    public username: string;
    public 'type': keyof MemberType;
    public playerID: string;
    public comment?: string;
    public installDir?: string | null;
    public remark?: string;
    public deleted_at?: string;
    public last_download_time?: string;
    public last_login_time?: string

    constructor(username: string, playerID: string) {
        this.username = username
        this.playerID = playerID
    }

    public isAdmin() {
        // console.warn(this.type)
        return ([
            MemberType.leader,
            MemberType.staff,
            // MemberType.veteran,
            // @ts-ignore
        ].includes(MemberType[this.type]))
    }
}
