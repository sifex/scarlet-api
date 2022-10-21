<?php

namespace App\Http\Controllers;

use App\User;
use FluidXml\FluidXml;

class XMLController extends Controller
{
    public function display(): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        return response(self::generateXML())->header('Content-type', 'text/xml');
    }

    public static function generateXML(): string
    {
        /**
         * Start new XML class
         */
        $book = new FluidXml('squad');

        /**
         * Begin XML with the standard ARMA 3 Variables
         */
        $book->setAttribute('nick', 'AAF')
            ->addChild('name', 'Australian Armed Forces')
            ->addChild('email', 'australianarmedforces@gmail.com')
            ->addChild('web', 'https://australianarmedforces.org/')
            ->addChild('picture', 'aaf_logo.paa')
            ->addChild('title', 'Aust. Armed Forces');

        /**
         * Fetch all users
         */
        $userList = User::all();

        foreach ($userList as $user) {

            /**
             * If user doesn't have a player ID assigned to them, then don't add them to the list
             */
            if ($user->playerID !== null && $user->playerID !== '') {
                $book->addChild('member', true, [
                    'id' => $user->playerID,
                    'nick' => ucwords($user->username)
                ])->addChild([
                    'name' => ucwords($user->username),
                    'email' => 'N/A',
                    'icq' => 'N/A',
                    'remark' => ucwords($user->remark)
                ]);
            }
        }

        return $book->html();
    }
}
