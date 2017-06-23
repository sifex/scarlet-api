<?php

namespace App\Http\Controllers;

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

		$user = \App\User::where('username', $username)->first();
		$user->playerID = $steamID;
		if($user->save()) {
			return redirect($request->session()->get('returnURL'));
		} else {
			return response()->json('Error saving steam ID into scarlet');
		}


	}
}
