<?php

namespace App\Enum;

enum UserRole:string
{
    case LEADER = 'LEADER';
    case STAFF = 'STAFF';
    case MEMBER = 'MEMBER';
    case RECRUIT = 'RECRUIT';
    case APPLICANT = 'APPLICANT';
    case SPECIAL = 'SPECIAL';
    case ZSU = 'ZSU';
}
