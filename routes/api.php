<?php






/**
 * Old API
 */

//Route::get( '/', 'GeneralController@index')
//    ->name('api/index');
//
//Route::get('/ip/', 'GeneralController@index'); // TODO LEGACY
//
///**
// * ARMA Server Ping
// */
//Route::get( '/arma/', 'GeneralController@armaServer')
//    ->name('api/armaserver');
//
///**
// * Teamspeak Ping
// */
//Route::get('/teamspeak/', 'GeneralController@teamspeakServer')
//    ->name('api/teamspeak');
//
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
