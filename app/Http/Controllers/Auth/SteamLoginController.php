<?php

namespace App\Http\Controllers\Auth;

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
        $user = User::withTrashed()->where('playerID', $steamUser->steamId)->first();

        if($user && $user->trashed()) {
            return redirect()->route('error')->withErrors([
                "This error usually appears when you're trying to login to a Scarlet account but an administrator has deleted your user previously.",
                "Please contact an administrator to have your account re-instated."
            ]);
        }

        if (!$user) {
            $steamUser->getUserInfo();

            $user = User::create([
                'username' => $steamUser->name,
                'playerID' => $steamUser->steamId
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
