<?php

use App\Enum\UserRole;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

uses(RefreshDatabase::class);


test("it can updates the user's installation directory", function () {
    $user = User::factory()->create();
    $new_install_dir = 'C:\Users\Scarlet';

    actingAs($user)
        ->postJson(route('api.user.update', [
            'user' => $user->uuid
        ]), [
            'installDir' => $new_install_dir
        ])
        ->assertStatus(200)
        ->assertJson([
            'success' => true,
            'data' => [
                'installDir' => $new_install_dir
            ]
        ]);

    expect($user->refresh()->installDir)->toEqual($new_install_dir);
});

test("it makes sure installation directory cannot be empty", function () {
    $user = User::factory()->create();

    actingAs($user)
        ->postJson(route('api.user.update', [
            'user' => $user->uuid
        ]), [
            'installDir' => ''
        ])
        ->assertStatus(422);
});

test("it cannot update another user's installation directory", function () {
    $regular_user = User::factory()->create();
    $a_totally_different_user = User::factory()->create();

    actingAs($regular_user)
        ->postJson(route('api.user.update', [
            'user' => $a_totally_different_user->uuid
        ]), [
            'install_dir' => 'C:\Users\Scarlet'
        ])
        ->assertStatus(403);
});
