<?php

namespace App\Http\Controllers;

use Exception;
use GameQ\GameQ;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;

class GeneralController extends Controller
{
    /**
     * Version
     * @var string
     */
    private $version = 'v1.3';

    /**
     * Scarlet Updater
     * @var string
     */
    private $name = 'Scarlet Updater API';

    /**
     * General API Endpoint
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'name' => $this->name,
            'version' => $this->version,
            'ip' => $this->getIP()
        ]);
    }

    /**
     * Gets the user's IP
     * @return string
     */
    private function getIP(): string
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        } else {
            $ip = '';
        }

        return $ip;
    }

    /**
     * Get's the ARMA Server's Status
     * @return JsonResponse
     * @throws Exception
     */
    public function armaServer(): JsonResponse
    {
        return response()->json(
            $this->getGameQDetails(
                Config::get('scarlet.armaserver'),
                'arma3'
            )
        );
    }

    /**
     * Get's the Teamspeak Server Status
     * @return JsonResponse
     * @throws Exception
     */
    public function teamspeakServer(): JsonResponse
    {
        return response()->json(
            $this->getGameQDetails(
                Config::get('scarlet.teamspeak'),
                'teamspeak3',
                [
                    'options' => [
                        'query_port' => 9987,
                    ]
                ]
            )
        );
    }

    /**
     * @param string $server
     * @param string $game
     * @param array $options
     * @return array
     * @throws Exception
     */
    private function getGameQDetails(string $server, string $game, array $options = []) : array
    {
        $servers = [
            'type'    => $game,
            'host'    => $server,
        ];

        $servers = array_merge($servers, $options);

        $GameQ = new GameQ();
        $GameQ->addServer($servers);
        $GameQ->setOption('timeout', 5); // seconds

        return $GameQ->process();
    }
}
