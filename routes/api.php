<?php

use App\Http\Controllers\APIController;

/**
 * Old API
 */

Route::get('/', [APIController::class, 'api_root'])->name('api.index');
Route::get('/arma/', [APIController::class, 'arma_server'])->name('api.armaserver');
Route::get('/teamspeak/', [APIController::class, 'teamspeak'])->name('api.teamspeak');
Route::get('/users/', [APIController::class, 'users'])->name('api.users');

Route::get('/ip/', 'GeneralController@index'); // TODO LEGACY

/**
 * ARMA Server Ping
 */


/**
 * Teamspeak Ping
 */

//Route::match(['get', 'post'], '/user/info/{user}/', 'UserController@get'); // TODO LEGACY
//
//Route::middleware(['electron-only'])->prefix('/users/')->group(function() {
//    /**
//     * Get all Users
//     */
//    Route::get('/', 'UserController@getAll')
//        ->name('api/user/getAll');
//
//    /**
//     * Create User
//     */
//    Route::post('/', 'UserController@add')
//        ->name('api/user/create');
//
//    Route::group(['prefix' => '/{user}/'], static function() {
//        /**
//         * Get User
//         */
//        Route::get('/', 'UserController@get')
//            ->name('api/user/get');
//
//        /**
//         * Update User
//         */
//        Route::post('/', 'UserController@update')
//            ->name('api/user/update');
//
//        /**
//         * Remove User
//         */
//        Route::delete('/', 'UserController@remove')
//            ->name('api/user/remove');
//    });
//});
//
///**
// * Website Login
// */
//
//Route::post('/website/login', 'WebsiteController@login');
//
//Route::post('/website/changerole', 'WebsiteController@changerole');
