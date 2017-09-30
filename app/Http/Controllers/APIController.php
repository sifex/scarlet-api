<?php

namespace Scarlet\Http\Controllers;

use \GameQ\GameQ;

class APIController extends Controller
{

    /**
     * API Version
     * @var string
     */
    public $version = '1.2.1';

    /**
     * API Root
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() {
        return response()->json(['name' => 'Scarlet API', 'Version' => $this->version]);
    }

    /**
     * API IP Return's the IP of the Client
     * @return \Illuminate\Http\JsonResponse
     */
    public function ReturnIP() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        return response()->json(['ip' => $ip]);
    }

    /**
     * Arma Public Server API
     * @return \Illuminate\Http\JsonResponse
     */
    public function ArmaServer() {

        $servers = [
            [
                'type'    => 'armedassault3',
                'host'    => '58.162.184.102:2302',
            ]
        ];

        $results = $this->processGameQuery($servers);

        return response()->json($results);
    }

    /**
     * Teamspeak API Query
     * @return \Illuminate\Http\JsonResponse
     */
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

        $results = $this->processGameQuery($servers);

        return response()->json($results);
    }

    public function processGameQuery($servers) {

        $GameQ = new GameQ(); // or $GameQ = \GameQ\GameQ::factory();
        $GameQ->addServers($servers);
        $GameQ->setOption('timeout', 5); // seconds

        try {
            $results = $GameQ->process();
        } catch(\Exception $exception) {
            $results = $exception;
        }

        return $results;
    }

    /**
     * Adds Badge for
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function badge() {
        $img = file_get_contents('https://img.shields.io/badge/Scarlet Version-' . $this->version . '-red.svg?style=flat&colorB=e12f32');

        // create response & sets content type
        return response($img)->header('Content-Type', 'image/svg+xml');
    }

}
