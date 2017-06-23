<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'DownloadController@download');

Route::get('/key/electron/', 'AuthController@displayElectronLogin');
Route::get('/key/', 'AuthController@displayLogin');

Route::match(['get','post'], "/auth/electron/", 'AuthController@loginToElectron');
Route::post("/auth/", 'AuthController@login');

Route::get("/logout/electron/", 'AuthController@logoutElectron');
Route::get("/logout/", 'AuthController@logout');

Route::get('/admin/', 'AdminController@admin');

Route::get('/xml/', 'XMLController@display');


Route::get('/steam/login', 'SteamController@showSteamURL');
Route::get('/steam/verify/{username}', 'SteamController@steamVerify');
