<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;

use App\Http\Requests;

class WebsiteController extends Controller
{
    public function login(Request $request) {
        $username = $request->input('username');
        $password = $request->input('password');

        $user = DB::table('scar_users')->where(['username' => $username])->first();
        if($user != null && Hash::check($password, $user->password)) {
            return response()->json(['response' => true]);
        } else {
            return response()->json(['response' => false]);
        }
    }


}
