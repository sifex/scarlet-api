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
}

export class User implements UserInterface {
    public id?: string;
    public uuid?: string;
    public username: string;
    public 'type': keyof MemberType;
    public playerID: string;
    public comment?: string;
    public installDir?: string;
    public remark?: string;
    public deleted_at?: string;

    constructor(username: string, playerID: string) {
        this.username = username
        this.playerID = playerID
    }

    public isAdminEnough() {
        // console.warn(this.type)
        return ([
            MemberType.leader,
            MemberType.staff,
            // MemberType.veteran,
            // @ts-ignore
        ].includes(MemberType[this.type]))
    }
}
