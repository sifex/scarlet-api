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
        $user = User::where('playerID', $steamUser->steamId)->first();

        if (!$user) {
            $steamUser->getUserInfo();

            dd($steamUser);

            $user = User::create([
                'username' => $steamUser->name,
                'playerID' => $steamUser->steamId,
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
