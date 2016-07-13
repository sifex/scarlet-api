<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests, App\Http\Responses;

class DownloadController extends Controller
{
    public function download() {
        return response(file_get_contents('http://127.0.0.1:8080/api/user/info/omega'))->header('Access-Control-Allow-Origin', '*');
    }
}
