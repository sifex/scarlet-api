<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request, Illuminate\Http\Reponse;
use App\Http\Controllers\Controller;
use Log, DB;
use App\User;

class AuthController extends Controller
{
    public function displayLogin(Request $request) {
        if(!session()->has('username')) {
            return view('key.index');
        } else {
            return redirect('/');
        }
    }

    public function displayElectronLogin(Request $request) {
        if(!session()->has('username')) {
                return view('keye.index');
        } else {
            return response()->make( '', 302 )->header( 'Location', "http://australianarmedforces.org/mods/electron/" . "?username=" . session()->get('username') );
        }
    }

    public function login(Request $request) {

        $username = $request->input('username');

        if (User::where('username', $username)->first() != NULL) {
            $request->session()->put('username', $username);
            $request->session()->save();
            return redirect('/');
        } else {
            return redirect()->route('login');
        }
    }

    public function loginToElectron(Request $request) {

        $username = $request->input('username');

        if (User::where('username', $username)->first() != NULL) {
            $request->session()->put('username', $username);
            $request->session()->save();
            return response()->make( '', 302 )->header( 'Location', "http://australianarmedforces.org/mods/electron/" . "?username=" . $username );

        } else {
            return redirect()->route('login-electrion');
        }
    }

    public function logout(Request $request) {
        $request->session()->flush();
        return redirect()->route('login');
    }

    public function logoutElectron(Request $request) {
        $request->session()->flush();
        return redirect()->route('login-electrion');
    }
}
