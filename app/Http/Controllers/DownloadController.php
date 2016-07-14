<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests, App\Http\Responses;
use Curl;

class DownloadController extends Controller
{
    public function download() {

        // Redirect if not Authed
        return view('download.index');
    }
}
