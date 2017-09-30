<?php

namespace Scarlet\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
use Scarlet\User;

use Scarlet\Http\Requests;

class WebsiteController extends Controller
{
    public function login(Request $request) {
        $username = $request->input('username');
        $password = $request->input('password');

        $user = User::where(['username' => $username])->first();
        if($user != null && Hash::check($password, $user->password)) {
            return response()->json(['response' => true]);
        }

        return response()->json(['response' => false]);

    }

    public function changeRole(Request $request) {
        $allRequestData = ($request->all());
        $user = \Scarlet\User::where(['id' => $allRequestData["id"]])->first();

        if($user->exists) {
            foreach($allRequestData as $key=>$value) {
                if($key != 'authKey') {
                    $user[$key] = $value;
                }
            }

            $user->save();
            return response()->json($user);
        }
        return response()->json(['response' => false]);
    }


}
