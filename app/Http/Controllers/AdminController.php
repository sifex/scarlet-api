<?php

namespace Scarlet\Http\Controllers;

use Illuminate\Http\Request;

use Scarlet\Http\Requests, Scarlet\Http\Responses;
use Curl;

class AdminController extends Controller
{
    public function admin() {

        if(session()->has('username')) {

            // Redirect if not Authed
            return view('missionPush.index');
            
        } else {
            return redirect('/');
        }
    }
}
