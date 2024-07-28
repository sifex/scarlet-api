<?php

namespace App\Http\Middleware;

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
