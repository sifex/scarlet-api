<?php

use App\Enum\UserRole;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

uses(RefreshDatabase::class);


test('it ensures new users have a role by default', function () {
    $user = User::create([
        'username' => 'test',
        'playerID' => '12345'
    ]);

    expect($user->type)->toBeTruthy();
});
