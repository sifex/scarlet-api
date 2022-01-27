<?php

use App\Http\Controllers\Auth\SteamLoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SteamController;
use App\Http\Controllers\XMLController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
// use kanalumaddela\LaravelSteamLogin\Http\Controllers\SteamLoginController;


//Route::get('/', [DownloadController::class, 'download']);
//
//Route::get('/key/electron/', [AuthController::class, 'displayElectronLogin']);
//Route::get('/key/', [AuthController::class, 'displayLogin']);
//
//Route::match(['get', 'post'], "/auth/electron/", [AuthController::class, 'loginToElectron']);
//Route::post("/auth/", [AuthController::class, 'login']);
//
//Route::get("/logout/electron/", [AuthController::class, 'logoutElectron']);
//Route::get("/logout/", [AuthController::class, 'logout']);
//
//// Route::get('/admin/',['AdminController::lass', 'admin']);
//
//Route::get('/xml/', [XMLController::class, 'display']);


//Route::get('/steam/login', [SteamController::class, 'redirectToLoginToSteam'])
//    ->name('steam_login');
//
//Route::get('/steam/verify/{username}', [SteamController::class, 'verifySteamUserResponse'])
//    ->name('steam_verify');

//Route::get('fire', function (Request $request) {
//    // this fires the event
//    $user = App\User::where('id', $request->input('user_id'))->first();
//
//    if($user) {
//        event(new SteamConnect($user));
//    }
//    return "event fired";
//});

// use App\Http\Controllers\Auth\SteamLoginController;
use kanalumaddela\LaravelSteamLogin\Facades\SteamLogin;

Route::get('/', [HomeController::class, 'home'])->name('home');

Route::middleware('auth')->group(function() {
    Route::get('/about', [HomeController::class, 'about'])->name('about');
});


Route::get('login/steam', [SteamLoginController::class, 'login'])
    ->name('login');

Route::get('auth/steam', [SteamLoginController::class, 'authenticate'])
    ->name('auth.steam'); // callback route when returning from steam


Route::match(['get', 'post'], 'logout', [SteamLoginController::class, 'logout'])
    ->name('logout');

