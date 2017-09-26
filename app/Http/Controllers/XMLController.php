<?php

namespace Scarlet\Http\Controllers;

use Illuminate\Http\Request;
use \FluidXml\FluidXml;
use \FluidXml\FluidNamespace;
use Scarlet\User;

class XMLController extends Controller
{
	public function display() {

		/**
		 * Start new XML class
		 * @var FluidXml
		 */
		$book = new FluidXml('squad');

		/**
		 * Begin XML with the standard ARMA 3 Variables
		 */
		$book->setAttribute('nick', 'AAF')
			->addChild('name', 'Australian Armed Forces')
			->addChild('email', 'australianarmedforces@gmail.com')
			->addChild('web', "https://australianarmedforces.org/")
			->addChild('picture', "aaf_logo.paa")
			->addChild('title', "Aust. Armed Forces");

		/**
		 * Fetch all users
		 */
		$userList = User::all();

		foreach ($userList as $user) {

			/**
			 * If user doesn't have a player ID assigned to them, then don't add them to the list
			 */
			if($user->playerID != null && $user->playerID != "") {
				$book->addChild('member', true , ['id' => '76561198132980843', 'nick' => ucwords($user->username)])->addChild([
					'name' => ucwords($user->username),
					'email' => 'N/A',
					'icq' => 'N/A',
					'remark' => ucwords($user->remark)
				]);
			}
		}


		return response($book)->header("Content-type", "text/xml");
	}
}
