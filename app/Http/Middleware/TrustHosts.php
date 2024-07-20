<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;

class TrustHosts extends \Illuminate\Http\Middleware\TrustHosts
{
    public function hosts()
    {
        return [
            '*.orb.local',
            'laravel.test.scarletaustralianarmedforcesorg.orb.local:5173'
        ];
    }
}
