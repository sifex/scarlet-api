import {MemberType} from "@/scripts/aaf/membertypes";

export interface UserInterface {
    username: string
    'type'?: MemberType
    playerID: string
    comment?: string
    installDir?: string
    remark?: string
}

export class User implements UserInterface {
    public username: string;
    public 'type': MemberType;
    public playerID: string;
    public comment?: string;
    public installDir?: string;
    public remark?: string;

    constructor(username: string, playerID: string) {
        this.username = username
        this.playerID = playerID
    }

    public isAdminEnough() {
        return this.type in [
            MemberType.leader,
            MemberType.staff,
        ]
    }
}
