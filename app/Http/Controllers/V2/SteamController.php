<?php

namespace App\Http\Controllers\V2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Events\SteamConnect;
use App\User;
use Ehesp\SteamLogin\SteamLogin;

class SteamController extends Controller
{

    /**
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public static function url($callbackURL) {
        // New Steam Login
        $login = new SteamLogin();
        return $login->url($callbackURL);
    }

    public function callback($username, Request $request) {
        $login = new SteamLogin();
        try {
            $steamID = $login->validate();
        } catch(\Exception $exception) {

        }

        dd($steamID);

    }
}
