<?php

namespace Scarlet\Http\Controllers;

use Illuminate\Http\Request;
use Scarlet\Http\Controllers\Controller;
use Scarlet\Events\SteamConnect;
use Scarlet\User;
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

    public static function callback() {
        $login = new SteamLogin();
        try {
            $steamID = $login->validate();
        } catch(\Exception $exception) {
            $steamID = false;
        }

        return $steamID;

    }
}
