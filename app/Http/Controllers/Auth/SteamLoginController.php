<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use kanalumaddela\LaravelSteamLogin\Http\Controllers\AbstractSteamLoginController;
use kanalumaddela\LaravelSteamLogin\SteamUser;

class SteamLoginController extends AbstractSteamLoginController
{
    /**
     * {@inheritdoc}
     */
    public function authenticated(Request $request, SteamUser $steamUser)
    {
        // find user by their steam account id, example assumes `steam_account_id` on `users` table
        $user = User::where('steamID', $steamUser->steamId)->first();

        // if the user doesn't exist, create them
        if (!$user) {
            $steamUser->getUserInfo(); // retrieve and set user info pulled from steam

            $user = User::create([
                'username' => $steamUser->name,
                'steamID' => $steamUser->steamId,
            ]);
        }

        // login the user using the Auth facade
        Auth::login($user);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return redirect()->back();
    }
}
