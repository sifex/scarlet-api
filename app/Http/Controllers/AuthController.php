<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Reponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function displayLogin(Request $request)
    {
        // if(!session()->has('username')) {
        // dd('test');
        return view('key.index');
        // }

        // return redirect('/');
    }

    public function displayElectronLogin(Request $request)
    {
        if (!session()->has('username')) {
            return view('keye.index');
        }

        return response()->make('', 302)->header('Location', config('scarlet.redirect_electron') . '?username=' . session()->get('username'));
    }

    public function login(Request $request)
    {

        $username = $request->input('username');

        if (User::where('username', $username)->first() != NULL) {
            $request->session()->put('username', $username);
            $request->session()->save();
            return redirect('/');
        } else {
            return redirect('/key/?');
        }
    }

    public function loginToElectron(Request $request)
    {

        $username = $request->input('username');

        if (User::where('username', $username)->first() != NULL) {
            $request->session()->put('username', $username);
            $request->session()->save();
            return response()->make('', 302)->header('Location', 'http://australianarmedforces.org/mods/electron/' . '?username=' . $username);

        } else {
            return redirect('/key/electron/');
        }
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/key/');
    }

    public function logoutElectron(Request $request)
    {
        $request->session()->flush();
        return redirect('/key/electron/');
    }
}
