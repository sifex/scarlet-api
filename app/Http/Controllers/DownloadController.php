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
        var_dump(Session::all('key'));
        /*
        if(Session::has('key')) {
            $downloadLocation = DB::table('scar_users')->where('key', $var)->get()->installDir;
            return view('download.index', ['installDir' => $downloadLocation]);
        } else {
            return redirect('/key/');
        }
        */

    }
}
