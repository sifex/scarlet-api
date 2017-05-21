<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

Route::group(['middleware' => 'web'], function () {

	Route::get('/', 'DownloadController@download');

	Route::get('/key/electron/', 'AuthController@displayElectronLogin');
	Route::get('/key/', 'AuthController@displayLogin');

	Route::match(['get','post'], "/auth/electron/", 'AuthController@loginToElectron');
	Route::post("/auth/", 'AuthController@login');

	Route::get("/logout/electron/", 'AuthController@logoutElectron');
	Route::get("/logout/", 'AuthController@logout');

	Route::get('/admin/', 'AdminController@admin');

	Route::get('/session', function() { return Session::all(); });

    // your routes here

	/* ------------- API --------------- */

	// Scarlet Test API
	Route::match(['get', 'post'], '/api/', 'APIController@index');

	/* Get IP */
	/* Previously this was done using ipify, but this caused some problems with AdBlockers in Browsers */
	Route::match(['get', 'post'], '/api/ip/', 'APIController@ip');

	/* ARMA Server Ping */
	Route::match(['get', 'post'], '/api/armaserver/', 'APIController@armaServer');

	/* Teamspeak Ping */
	Route::match(['get', 'post'], '/api/teamspeak/', 'APIController@teamspeakServer');

	/* Discord Rally Up */
	Route::post('/api/rally/', 'APIController@rallyUp');

	// ADD
	Route::match(['get', 'post'], '/api/user/add/{username}/{clanID}/{type}', 'APIController@add');

	// INFO
	Route::match(['get', 'post'], '/api/user/info/{var}/', 'APIController@info');

	// SET INSTALL
	Route::post('/api/user/install/{key}/', 'APIController@install');

	Route::get('/api/build-badge/', 'APIController@badge');


	/**
     * Website Login
     */

	Route::match(['get', 'post'], '/api/website/login', 'WebsiteController@login');

    Route::match(['post'], '/api/website/changerole', 'WebsiteController@changerole');
});
