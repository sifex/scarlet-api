<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request, Illuminate\Http\Response;
use Log, DB;

class UserController extends Controller
{
    public function add($username, $clanID) {

        $user = DB::table('scar_users')->where('username', $username)->get();
        $key = md5(strtolower($username) . "E6hJ9X2AptWH6bqU32");

        if($user != null) {
            echo "User " . $username . " already in database";
        }
        elseif(DB::table('scar_users')->insert(
        [
            'username' => $username,
            'key' => $key,
            'clanid' => $clanID
        ]))
        {
            return response()->json(['username' =>  $username, 'key' => $key, 'clan' => $clanID])->header('Access-Control-Allow-Origin', '*');

            // Log
            Log::info('Created User: ' . $username . " (" . $key . ") - " . $clanID);

        }
    }

    public function info($var)
    {
        // Log
        Log::info('Fetching info(' . $var . ')');

        if(DB::table('scar_users')->where('key', $var)->first())
        {
            $content = DB::table('scar_users')->where('key', $var)->first();
            return response()->json(['username' =>  $content->username, 'key' => $content->key, 'clan' => $content->clanid])->header('Access-Control-Allow-Origin', '*');
        }
        elseif(DB::table('scar_users')->where('username', $var)->first())
        {
            $content = DB::table('scar_users')->where('username', $var)->first();
            return response()->json(['username' =>  $content->username, 'key' => $content->key, 'clan' => $content->clanid])->header('Access-Control-Allow-Origin', '*');
        }
    }

    public function install(Request $request, $key)
    {
        // Log
        Log::info('Installing Directory for ' . $key . ': ' . $request->installDir);

        if(DB::table('scar_users')->where('key', $key)->first())
        {
            DB::table('scar_users')->where('key', $key)->update(['installDir'=>$request->installDir]);
            return response('')->header('Access-Control-Allow-Origin', '*');
        }
    }

    public function post(Request $request) {
        echo $request->name;
    }
}
