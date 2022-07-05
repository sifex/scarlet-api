<?php

use App\Enum\UserRole;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

uses(RefreshDatabase::class);


test('it can visit the homepage', function () {
    get('/')->assertStatus(200);
});

test("it can't see view users as non-admin", function () {
    $regular_user = User::factory()->create();

    actingAs($regular_user)
        ->get(route('admin.user.index'))
        ->assertStatus(403);
});

test('it can see self as non-admin', function () {
    $regular_user = User::factory()->create();

    actingAs($regular_user)
        ->get(route('admin.user.show', [
            'user' => $regular_user->uuid
        ]))
        ->assertStatus(200);
});

test("it can't see a user as non-admin", function () {
    $regular_user = User::factory()->create();
    $other_users = User::factory()->count(5)->create();

    actingAs($regular_user)
        ->get(route('admin.user.show', [
            'user' => collect($other_users)->random(1)->first()->uuid
        ]))
        ->assertStatus(403);
});

/**
 * Admins
 */

test("it can view users as admin", function () {
    $admin = User::factory()->admin()->create();

    actingAs($admin)
        ->get(route('admin.user.index'))
        ->assertStatus(200);
});

test('it can create a user as an admin', function () {
    $admin = User::factory()->admin()->create();

    actingAs($admin)
        ->post(route('admin.user.store'), [
            'username' => 'Omega123',
            'type' => 'member'
        ])
        ->assertStatus(302);

    expect(User::where('username', 'Omega123')->first()->exists())
        ->toBeTrue();
});

test('it can update a user as an admin', function () {
    $admin = User::factory()->admin()->create();

    $other_user = User::factory()->create([
        'username' => 'Omega123',
        'type' => 'member'
    ]);

    actingAs($admin)
        ->patch(route('admin.user.update', [
            'user' => $other_user->uuid
        ]), [
            'username' => 'Testing 1827'
        ])
        ->assertStatus(302);

    expect($other_user->refresh()->username)
        ->toBe('Testing 1827');
});


test('it can update a user role as an admin', function () {
    $admin = User::factory()->admin()->create();

    $other_user = User::factory()->create([
        'type' => 'member'
    ]);

    actingAs($admin)
        ->patch(route('admin.user.update', [
            'user' => $other_user->uuid
        ]), [
            'type' => 'leader'
        ])
        ->assertStatus(302);

    expect($other_user->refresh()->type)
        ->toEqual(UserRole::LEADER);

    actingAs($admin)
        ->patch(route('admin.user.update', [
            'user' => $other_user->uuid
        ]), [
            'type' => UserRole::VETERAN->value
        ])
        ->assertStatus(302);

    expect($other_user->refresh()->type)
        ->toEqual(UserRole::VETERAN);
});
