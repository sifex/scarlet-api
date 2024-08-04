<?php

use App\Http\Controllers\Admin\SettingsAdminController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\UserNoteController;
use App\Http\Controllers\Admin\XMLAdminController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\Auth\SteamLoginController;
use App\Http\Controllers\ModsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\XMLController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AppController::class, 'home'])
    ->name('home');

Route::get('/error', [AppController::class, 'error'])
    ->name('error');

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

    Route::patch('user', [UserController::class, 'update'])->name('user.update');

    Route::get('/mods', [ModsController::class, 'get_mods'])
        ->name('mods');

    Route::get('/mods/regenerate', [ModsController::class, 'regenerate_mods'])
        ->name('mods.regenerate');


    Route::prefix('admin')->middleware('admin')->group(function () {
        Route::get('/', [UserManagementController::class, 'redirect_to_user_management'])
            ->name('admin');

        /**
         * User Resource
         */
        Route::resource('user', UserManagementController::class)->names([
            'index' => 'admin.user.index',
            'create' => 'admin.user.create',
            'store' => 'admin.user.store',
            'show' => 'admin.user.show',
            'edit' => 'admin.user.edit',
            'update' => 'admin.user.update',
            'destroy' => 'admin.user.destroy',
        ]);

        /**
         * User Note
         */
        Route::post('user/{user}/note', [UserNoteController::class, 'create'])
            ->name('admin.user.note.store');

        Route::delete('user/{user}/note/{note}', [UserNoteController::class, 'destroy'])
            ->name('admin.user.note.destroy');

        Route::get('xml', [XMLAdminController::class, 'index'])->name('admin.xml.index');

        Route::get('settings', [SettingsAdminController::class, 'index'])->name('admin.settings.index');
        Route::patch('settings', [SettingsAdminController::class, 'update'])->name('admin.settings.update');
    });
});

Route::match(['get', 'post'], 'logout', [SteamLoginController::class, 'logout'])
    ->name('logout');

Route::get('/xml/', [XMLController::class, 'display'])->name('xml');


/**
 * Legacy Routes
 */
Route::group(['name'=>'legacy_routes'], function () {
    Route::get('/key/electron/', fn () => redirect()->route('electron.intro'));
    Route::get('/key/', fn () => redirect()->route('electron.intro'));
    Route::get("/auth/electron", fn () => redirect()->route('electron.intro'));
    Route::get("/auth", fn () => redirect()->route('electron.intro'));
});


Route::get('/debug-sentry', function () {
    throw new Exception('My first Sentry error!');
});
