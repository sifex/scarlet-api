<?php

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);


test('it ensures new users have a role by default', function () {
    $user = User::create([
        'username' => 'test',
        'playerID' => '12345'
    ]);

    expect($user->type)->toBeTruthy();
});
