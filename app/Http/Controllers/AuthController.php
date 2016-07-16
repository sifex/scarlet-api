<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Log, DB;

class AuthController extends Controller
{
    public function displayLogin() {
        return view('key.index');
    }

    public function login(Request $request) {

        $key = $request->input('key');

        if (DB::table('scar_users')->where('key', $key)->first() != NULL) {
            $request->session()->put('key', $key);
            var_dump($request->session()->all());
            return redirect('/download/');
        } else {
            return redirect('/key/?');
        }
    }
}
