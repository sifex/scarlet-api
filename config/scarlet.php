<?php

return [


    /**
     * Arma Server IP & Port
     */
    'armaserver' => env('ARMA_SERVER', '110.145.200.30:2302'),

    /**
     * Teamspeak IP & Port
     */
    'teamspeak' => env('TEAMSPEAK_SERVER', 'ts.australianarmedforces.org:9987'),

    /**
     * Redirect to do go after login
     */
    'redirect_electron' => env('REDIRECT_ELECTRON', 'https://australianarmedforces.org/mods/electron/')
];
