<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\Auth\SteamLoginController;
use App\Http\Controllers\Auth\UserController2;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserNoteController;
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

//Route::post('@me', [UserController2::class, 'update']);

Route::middleware('auth')->group(function () {
    Route::get('/electron', [AppController::class, 'electron'])
        ->name('electron');

    Route::prefix('admin')->group(function() {
        Route::get('/', [UserController::class, 'redirect_to_user_management'])
            ->name('admin');

        /**
         * User Resource
         */
        Route::resource('user', UserController::class)->names([
            'index' => 'admin.user.index',
            'create' => 'admin.user.create',
            'store' => 'admin.user.store',
            'show' => 'admin.user.show',
            'edit' => 'admin.user.edit',
            'update' => 'admin.user.update',
            'destroy' => 'admin.user.destroy',
        ]);

        Route::post('user/{user}/note', [UserNoteController::class, 'create'])
            ->name('admin.user.note.store');

        Route::delete('user/{user}/note/{note}', [UserNoteController::class, 'destroy'])
            ->name('admin.user.note.destroy');
    });
});

Route::match(['get', 'post'], 'logout', [SteamLoginController::class, 'logout'])
    ->name('logout');
