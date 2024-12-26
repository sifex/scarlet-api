<?php

namespace App\Http\Controllers;

use App\User;

class APIController extends Controller
{
    public function api_root()
    {
        return response()->json([
            'version' => '1.0',
            'framework_version' => app()->version(),
        ]);
    }

    public function arma_server()
    {
        $servers = [
            [
                'type' => 'armedassault3',
                'host' => '58.162.184.102:2302',
            ],
        ];

        $GameQ = new \GameQ\GameQ; // or $GameQ = \GameQ\GameQ::factory();
        $GameQ->addServers($servers);
        $GameQ->setOption('timeout', 5); // seconds

        return response()->json(
            $GameQ->process()
        );
    }

    public function teamspeak()
    {
        $servers = [
            [
                'type' => 'teamspeak3',
                'host' => 'ts.australianarmedforces.org:9987',
                'options' => [
                    'query_port' => 10011,
                ],
            ],
        ];

        $GameQ = new \GameQ\GameQ; // or $GameQ = \GameQ\GameQ::factory();
        $GameQ->addServers($servers);
        $GameQ->setOption('timeout', 5); // seconds

        $results = $GameQ->process();

        return response()->json(
            $results
        );
    }

    public function users()
    {
        return response()->json(
            User::get([
                'username', 'remark', 'type',
            ])
        );
    }
}
