<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Ehesp\SteamLogin\SteamLogin;

class SteamController extends Controller
{
    public function showSteamURL(Request $request) {
		if(session('username')) {
			$request->session()->put('returnURL', request()->headers->get('referer'));

			$login = new SteamLogin();
			return redirect($login->url(url('steam/verify/' . session('username'))));
		} else {
			return redirect(url('/'));
		}
	}

	public function steamVerify($username, Request $request) {
		$login = new SteamLogin();
		try {
			$steamID = $login->validate();
		} catch(\Exception $exception) {
			return redirect('/');
		}

		$user = User::where('username', $username)->first();
		$user->steamID = $steamID;

		if($user->save()) {
			// event(new \App\Events\SteamConnect(array("data" => "124", "key" => "124")));
			$returnURL = $request->session()->get('returnURL');
			if(is_string($returnURL)) {
                return redirect($request->session()->get('returnURL'));
            } else {
                return redirect(url('/'));
            }

		} else {
			return response()->json('Error saving steam ID into scarlet');
		}


	}
}
