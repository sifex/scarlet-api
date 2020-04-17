<?php


/** General Information */
Route::get( '/', 'GeneralController@index')
    ->name('api/index');

/** ARMA Server Ping */
Route::get( '/arma/', 'GeneralController@armaServer')
    ->name('api/armaserver');

/** Teamspeak Ping */
Route::get('/teamspeak/', 'GeneralController@teamspeakServer')
    ->name('api/teamspeak');


Route::group(['prefix' => '/users/'], static function() {
    /** Get all users */
    Route::get('/', 'UserController@getAll')
        ->name('api/user/getAll');

    /** Create User */
    Route::post('/', 'UserController@add')
        ->name('api/user/create');

    Route::group(['prefix' => '/{user}/'], static function() {
        /** Get User */
        Route::get('/', 'UserController@get')
            ->name('api/user/get');

        /** Update User */
        Route::post('/', 'UserController@update')
            ->name('api/user/update');

        /** Remove User */
        Route::delete('/', 'UserController@remove')
            ->name('api/user/remove');
    });
});

/**
 * Website Login
 */

Route::get('/website/login', 'WebsiteController@login');

Route::match(['post'], '/website/changerole', 'WebsiteController@changerole');
