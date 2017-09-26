<?php

use App\Events\SteamConnect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



Route::prefix('v2')->middleware('auth.basic.once')->group(function() {
    Route::get('/', 'V2\InviteController@index')->name('v2index');
    Route::get('/invite/{invite_code}', 'V2\InviteController@invite');

    Route::get('/steam/verify/{invite_code}/', 'V2\InviteController@steamverify')->name('v2steamverify');
});

Route::get('/', 'DownloadController@download');

Route::get('/login/electron/', 'AuthController@displayElectronLogin')->name('login-electron');
Route::get('/login/', 'AuthController@displayLogin')->name('login');

Route::match(['get','post'], '/auth/electron/', 'AuthController@loginToElectron');
Route::post('/auth/', 'AuthController@login');

Route::get('/logout/electron/', 'AuthController@logoutElectron');
Route::get('/logout/', 'AuthController@logout');

Route::get('/admin/', 'AdminController@admin');

Route::get('/xml/', 'XMLController@display');


Route::get('/steam/login', 'SteamController@showSteamURL');
Route::get('/steam/verify/{username}', 'SteamController@steamVerify');

Route::get('fire', function (Request $request) {
    // this fires the event
    $user = App\User::where('id', $request->input('user_id'))->first();

	if($user) {
    	event(new SteamConnect($user));
	}
    return 'event fired';
});
