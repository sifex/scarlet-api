<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Scarlet Test API
Route::match(['get', 'post'], '/', 'APIController@index');

/* Get IP */
/* Previously this was done using ipify, but this caused some problems with AdBlockers in Browsers */
Route::match(['get', 'post'], '/ip/', 'APIController@ArmaServer');

/* ARMA Server Ping */
Route::match(['get', 'post'], '/armaserver/', 'APIController@armaServer');

/* Teamspeak Ping */
Route::match(['get', 'post'], '/teamspeak/', 'APIController@teamspeakServer');

Route::get('/build-badge/', 'APIController@badge');

