<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests, App\Http\Responses;

class DownloadController extends Controller
{
    public function download() {
        $url = 'http://xx.xxx.xx.xx:xxxx/apps/index.php';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        $data = curl_exec($curl);
        curl_close($curl);
        return response($data)->header('Access-Control-Allow-Origin', '*');
    }
}
