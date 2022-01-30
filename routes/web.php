<?php

use App\Http\Controllers\Auth\SteamLoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\SteamController;
use App\Http\Controllers\XMLController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', [AppController::class, 'home'])
    ->name('home');

Route::get('login/steam', [SteamLoginController::class, 'login'])
    ->name('login');

Route::get('auth/steam', [SteamLoginController::class, 'authenticate'])
    ->name('auth.steam'); // callback route when returning from steam


Route::get('/electron/intro', [AppController::class, 'electron_intro_screen'])
    ->name('electron.intro');

Route::get('/browser/steam/verify', [AppController::class, 'browser_electron_steam_verify_page'])
    ->name('browser.steam.verify');

Route::get('/electron/steam/verify', [AppController::class, 'electron_call_home'])
    ->name('electron.steam.verify');

Route::middleware('auth')->group(function() {

    Route::get('/about', [AppController::class, 'about'])
        ->name('about');
    Route::get('/electron', [AppController::class, 'electron'])
        ->name('electron');

});


Route::match(['get', 'post'], 'logout', [SteamLoginController::class, 'logout'])

    ->name('logout');

