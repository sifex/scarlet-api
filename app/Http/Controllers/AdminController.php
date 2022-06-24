<?php

namespace App\Http\Controllers;

class AdminController extends Controller
{
    public function admin()
    {
        if (session()->has('username')) {

            // Redirect if not Authed
            return view('missionPush.index');
        } else {
            return redirect('/');
        }
    }
}
