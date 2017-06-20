<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Log, DB;
use App\User;
use Image;
use AustinB\GameQ;
use GuzzleHttp\Client;
use Exception;

class APIController extends Controller
{

    // 1.0.1 | Maintenance Mode
    public $version = "1.2.1";

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

    public function armaServer() {

		return response()->json("Awesome");
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

    public function teamspeakServer() {
        $servers = [
            [
                'type'    => 'teamspeak3',
                'host'    => 'ts.australianarmedforces.org:9987',
                'options' => [
                    'query_port' => 10011,
                ],
            ]
        ];

        $GameQ = new \GameQ\GameQ(); // or $GameQ = \GameQ\GameQ::factory();
        $GameQ->addServers($servers);
        $GameQ->setOption('timeout', 5); // seconds

        $results = $GameQ->process();

        return response(json_encode(($results), JSON_PARTIAL_OUTPUT_ON_ERROR))->header('Content-Type', 'application/json');
    }

    public function add($username, $clanID, $type) {

        /**
         * Add User to Eloquent Model
         */
        $user = new User();
        $user->username = $username;
		$user->installDir = "";
        $user->key = md5(strtolower($username) . "E6hJ9X2AptWH6bqU32");
        $user->clanID = $clanID;
        $user->type = $type;

        /**
         * Try and add it,
         */
        try {
            $user->save();
        } catch(Exception $exception) {
            /**
             * Catch duplicate entry exception
             */
            return response()->json(['error' => true, 'message' => 'User already exists']);
        }

        // Log
        Log::info('Created User: ' . $user->username . " (" . $user->key . ") - " . $user->clanID);
        return response()->json($user);
    }

    public function remove($id) {

        $user = User::find($id);

        if($user) {
            $user->delete();
            Log::info('Removed user ' . $user->username);
            return response()->json(["status" => "deleted"]);
        } else {
            return response()->json(["status" => "User not found: " . $id]);
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
		return response()->json("Awesome");
    }

    public function install(Request $request, $key)
    {
        // Log
        Log::info('Installing Directory for ' . $key . ': ' . $request->installDir);

		$user = User::where('key', $key)->first();

        if($user)
        {
            $user->installDir = $request->installDir;

			try {
				$user->save();
			} catch(Exception $exception) {
				/**
				 * This should return a json value, but this means pushing another scarlet updater update. TODO
				 * @return {[type] [description]
				 */
            	return response('');
			}
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
