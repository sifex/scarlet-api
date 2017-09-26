<?php

namespace App\Http\Controllers\V2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\InviteCode;

class InviteController extends Controller
{

    public function index(Request $request) {
        dd(self::checkInviteCode('EY86QP6'));
        return view('V2/index');
    }

    /**
     * Checks if the Invite Code is good or not
     * @param $invite
     * @return bool
     */
    public static function checkInviteCode($invite_to_check) {

        $invite_row = \App\InviteCode::where('invite_code', $invite_to_check)->first();
        if(!is_object($invite_row)) {
            return false;
        }
        if($invite_row->user !== null) {
            return false;
        }
        return true;
    }

    /**
     * Assign User to an Invite Code, hereby using the invite code up.
     * @param $invite_code
     * @param $user
     * @return bool
     */
    public function assignInviteCode($invite_code, $user) {

        $invite_row = \App\InviteCode::where('invite_code', $invite_code)->first();

        if(!$invite_row || !$user) {
            return false;
        }

        if(!$user->id) {
            return false;
        }

        $invite_row->userID = $user->id;

        if(!$invite_row->save()) {
            return false;
        }

        return true;
    }
}
