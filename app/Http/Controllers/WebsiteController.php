<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use DB;
use Hash;
use App\User;

use App\Http\Requests;

class WebsiteController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        $user = User::where(['username' => $username])->first();
        if ($user !== null && Hash::check($password, $user->password)) {
            return response()->json(['response' => true]);
        }

        return response()->json(['response' => false]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function changeRole(Request $request)
    {
        $allRequestData = ($request->all());
        $user = User::where(['key' => $allRequestData['key']])->first();

        if ($user->exists) {
            foreach ($allRequestData as $key => $value) {
                if ($key != 'authKey') {
                    $user[$key] = $value;
                }
            }

            $user->save();
            return response()->json($user);
        }
        return response()->json(['response' => false]);
    }


}
