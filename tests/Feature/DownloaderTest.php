<?php

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);


test('it can visit the electron updater page', function () {
    $regular_user = User::factory()->create();

    actingAs($regular_user)
        ->get(route('electron'))
//        ->assertSee('Settings')
        ->assertViewHas('page.props.current_user.username', function($username) use ($regular_user) {
            return $username === $regular_user->username;
        })
        ->assertStatus(200);
});
