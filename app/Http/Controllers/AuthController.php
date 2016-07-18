<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Log, DB;

class AuthController extends Controller
{
    public function displayLogin() {
        if(!session()->has('key')) {
            return view('key.index');
        } else {
            return redirect('/download/');
        }
    }

    public function login(Request $request) {

        $key = $request->input('key');

        if (DB::table('scar_users')->where('key', $key)->first() != NULL) {
            $request->session()->put('key', $key);
            var_dump($request->session()->all());
            return redirect('/');
        } else {
            return redirect('/key/?');
        }
    }

    public function logout(Request $request) {
        $request->session()->flush();
        return redirect('/key/?');
    }
}
