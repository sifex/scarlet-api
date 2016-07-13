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

Route::get('/', function () {
	return view('index');
});

Route::get('/auth/{key}', 'AuthController@login');

Route::get('/download/', 'DownloadController@download');

/* ------------- API --------------- */

// Scarlet Test API
Route::get('/api/', function() {
	return response()->json(['name' => 'Scarlet API', 'Version' => '1.0']);
});

// ADD
Route::get('/api/user/add/{username}/{clanID}/', 'UserController@add');

// INFO
Route::get('/api/user/info/{var}/', 'UserController@info');

// SET INSTALL
Route::post('/api/user/install/{key}/', 'UserController@install');
