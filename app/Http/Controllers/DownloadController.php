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
use Session;

class DownloadController extends Controller
{
    public function download() {
        if(session()->has('key')) {
            $userInfo = User::where('key', session()->get('key'))->first();
            return view('download.index', ['userInfo' => $userInfo]);
        } else {
            return redirect('/key/');
        }

    }
}
