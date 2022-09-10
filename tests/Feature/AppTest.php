<?php

use App\Enum\UserRole;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

uses(RefreshDatabase::class);


test('it can visit the homepage', function () {
    get('/')
        ->assertSessionHasNoErrors()
        ->assertStatus(200);
});

test('it can see self as non-admin', function () {
    $regular_user = User::factory()->create();

    actingAs($regular_user)
        ->get(route('home'))
        ->assertSessionHasNoErrors()
        ->assertViewHas('page.props.current_user.username', function($username) use ($regular_user) {
            return $username === $regular_user->username;
        })
        ->assertStatus(200);
});


test('it can see the homepage not logged in', function () {
    get(route('home'))
        ->assertSessionHasNoErrors()
        ->assertViewHas('page.props.current_user', function($username) {
            return $username === null;
        })
        ->assertStatus(200);
});
