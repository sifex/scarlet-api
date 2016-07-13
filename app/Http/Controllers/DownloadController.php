<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests, App\Http\Responses;
use Curl;

class DownloadController extends Controller
{
    public function download() {
        $data = Curl::to('http://127.0.0.1:8080/api/user/info/omega')->get();
        return response($data);
    }
}
