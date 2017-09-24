<?php

use App\Events\SteamConnect;
use Illuminate\Http\Request;

Route::get('/', 'DownloadController@download');

Route::get('/login/electron/', 'AuthController@displayElectronLogin')->name('login-electron');
Route::get('/login/', 'AuthController@displayLogin')->name('login');

Route::match(['get','post'], "/auth/electron/", 'AuthController@loginToElectron');
Route::post("/auth/", 'AuthController@login');

Route::get("/logout/electron/", 'AuthController@logoutElectron');
Route::get("/logout/", 'AuthController@logout');

Route::get('/admin/', 'AdminController@admin');

Route::get('/xml/', 'XMLController@display');


Route::get('/steam/login', 'SteamController@showSteamURL');
Route::get('/steam/verify/{username}', 'SteamController@steamVerify');

Route::get('fire', function (Request $request) {
    // this fires the event
    $user = App\User::where('id', $request->input('user_id'))->first();

	if($user) {
    	event(new SteamConnect($user));
	}
    return "event fired";
});
