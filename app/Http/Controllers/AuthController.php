<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use UserController;
use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Log, DB;

class AuthController extends Controller
{
    public function displayLogin() {

        return view('key.index');

    }

    public function login(Request $request) {

        $key = $request->input('key');

        if (DB::table('scar_users')->where('key', $var)->first() != NULL) {
            return redirect('/download/');
        } else {
            echo $key;
            var_dump(DB::table('scar_users')->where('key', $var)->first());
            // return redirect('/key/');
        }


    }
}
