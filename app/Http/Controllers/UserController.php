<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user();

//        $this->validate($request, $this->rules($user), $this->messages());

//        Log::info('Updating User ' . $user->username);

        $user->fill(
            $request->only([
                'installDir',
                'remark',
                'steamID',
                'comment',
                'type'
            ])
        )->save();

        return redirect()->route('electron');
    }
}
