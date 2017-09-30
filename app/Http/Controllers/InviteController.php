<?php

namespace Scarlet\Http\Controllers;

use Illuminate\Http\Request;
use Scarlet\Steam\SteamUser;
use Scarlet\User;
use Scarlet\InviteCode;

class InviteController extends Controller
{
    /**
     * Route name for verify Steam Route
     * @var string
     */
    public $steamOutRouteName = 'v2steamverify';

    /**
     * Index Method
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request) {
        return view('index');
    }

    /**
     * @param $invite_code
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function invite($invite_code, Request $request) {
        if(!self::checkInviteCode($invite_code)) {
            return redirect()->route('v2index');
        }

        $request->session()->put('invite_code', $invite_code);
        return redirect(SteamController::url(route($this->steamOutRouteName, ['invite_code' => $invite_code])));
    }

    public function steamverify() {
        $steamID = SteamController::callback();

        if(!$steamID) {
            return redirect()->route('v2index');
        }

        $steamUser = new SteamUser($steamID, env('STEAM_API_KEY'));
        dd($steamUser);

        return response()->json($steamUser);
    }

    public function createUserWithSteamInfo($steamInfo) {
        $user = User::create([
            'username' => $steamInfo->steamID,
            'steamID' => $steamInfo->steamID64,
            'avatar' => $steamInfo->avatarFull,

        ]);
    }

    /**
     * Checks if the Invite Code is good or not
     * @param $invite
     * @return bool
     */
    public static function checkInviteCode($invite_to_check) {
        $invite_row = InviteCode::where('invite_code', $invite_to_check)->first();

        if(!is_object($invite_row) || $invite_row->user !== null) {
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

        $invite_row = \Scarlet\InviteCode::where('invite_code', $invite_code)->first();

        if(!$invite_row || !$user->id) {
            return false;
        }

        $invite_row->userID = $user->id;

        if(!$invite_row->save()) {
            return false;
        }

        return true;
    }
}
