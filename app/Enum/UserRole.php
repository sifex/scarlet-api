<?php

namespace App\Enum;

enum UserRole:string
{
    case LEADER = 'leader';
    case STAFF = 'staff';
    case MEMBER = 'member';
    case RECRUIT = 'recruit';
    case APPLICANT = 'applicant';
    case SPECIAL = 'special';
    case ZSU = 'zsu';
    case VETERAN = 'veteran';
}
