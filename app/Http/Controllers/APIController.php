<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Log, DB;
use App\User;
use Image;
use AustinB\GameQ;
use GuzzleHttp\Client;

class APIController extends Controller
{

    // 1.0.1 | Maintenance Mode
    public $version = "1.0.1";

    public function index() {
        return response()->json(['name' => 'Scarlet API', 'Version' => $this->version]);
    }

    public function ip() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        return response()->json(['ip' => $ip]);
    }

    public function armaserver() {
        $servers = [
            [
                'type'    => 'armedassault3',
                'host'    => '58.162.184.102:2302',
            ]
        ];

        $GameQ = new \GameQ\GameQ(); // or $GameQ = \GameQ\GameQ::factory();
        $GameQ->addServers($servers);
        $GameQ->setOption('timeout', 5); // seconds

        $results = $GameQ->process();

        return response(json_encode(($results), JSON_PARTIAL_OUTPUT_ON_ERROR))->header('Content-Type', 'application/json');
    }

    public function rallyUp(Request $request) {

        // Check AuthKey
        if($request->authKey == "4f64MC76YMLsC8rW89QZaMDVTdYZN4C2") {
            if($request->has("customMessage")) {
                $meessage = "@everyone " . $request->customMessage;
            } else {
                $message = "@everyone Mission Notification. Rally Up.";
            }

            $client = new Client();
            $res = $client->request('POST', 'https://api.buddy.works/workspaces/chess2ryme/projects/aaf-website/pipelines/35631/executions?access_token=a6dc5887-ba50-464a-ba46-f91a18330f42', [
                'json' => [
                    'to_revision' => [
                        'revision' => 'HEAD'
                    ],
                    'comment' => 'hotfix'
                ]
            ]);
            echo $res->getStatusCode();
            // "200"
            echo $res->getHeader('content-type');
            // 'application/json; charset=utf8'
            echo $res->getBody();
            // {"type":"User"...'
        } else {
            return abort(401);
        }
    }


    public function add($username, $clanID) {

        $user = User::where('username', $username)->first();
        $key = md5(strtolower($username) . "E6hJ9X2AptWH6bqU32");

        if($user) {
            echo "User " . $username . " already in database";
        }
        elseif(DB::table('scar_users')->insert(
        [
            'username' => $username,
            'key' => $key,
            'clanid' => $clanID
        ]))
        {
            return response()->json(['username' =>  $username, 'key' => $key, 'clan' => $clanID]);

            // Log
            Log::info('Created User: ' . $username . " (" . $key . ") - " . $clanID);

        }
    }

    public function info($var)
    {
        // Log
        Log::info('Fetching info(' . $var . ')');

        if($var == "*")
        {
            return response()->json(User::all()->toArray());
        }
        elseif(User::where('key', $var)->first())
        {
            return response()->json(User::where('key', $var)->first()->toArray());
        }
        elseif(User::where('username', $var)->first())
        {
            return response()->json(User::where('username', $var)->first()->toArray());
        }
    }

    public function install(Request $request, $key)
    {
        // Log
        Log::info('Installing Directory for ' . $key . ': ' . $request->installDir);

        if(DB::table('scar_users')->where('key', $key)->first())
        {
            DB::table('scar_users')->where('key', $key)->update(['installDir'=>$request->installDir]);
            return response('');
        }
    }

    public function badge() {
        $img = Image::make(file_get_contents('https://img.shields.io/badge/Scarlet Version-' . $this->version . '-red.png?style=flat'));

        // create response and add encoded image data
        $response = response(($img->encode('png')));

        // set content-type
        $response->header('Content-Type', 'image/png');

        // output
        return $response;
    }
}
