<?php



    Route::get('/', 'InviteController@index')->name('v2index');
    Route::get('/invite/', function () {
        return redirect()->route('v2index');
    });
    Route::get('/invite/{invite_code}', 'InviteController@invite');

    Route::get('/steam/verify/123456789/', 'InviteController@steamverify')->name('v2steamverify');
    Route::get('/steam/verify/{invite_code}/', 'InviteController@steamverify')->name('v2steamverify');
