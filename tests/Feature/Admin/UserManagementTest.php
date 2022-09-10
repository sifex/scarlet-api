<?php

use App\Enum\UserRole;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

uses(RefreshDatabase::class);

test("it can't see view users as non-admin", function () {
    $regular_user = User::factory()->member()->create();

    actingAs($regular_user)
        ->get(route('admin.user.index'))
        ->assertStatus(403);
});

test("it can't see a user as non-admin", function () {
    $regular_user = User::factory()->create();
    $other_users = User::factory()->member()->count(5)->create();

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

test("it can't set a custom role", function () {
    actingAs(User::factory()->admin()->create())
        ->post(route('admin.user.store'), [
            'username' => 'Omega',
            'type' => 'member123'
        ])
        ->assertSessionHasErrors(['type']);
});

test('it can create a user as an admin', function () {
    $admin = User::factory()->admin()->create();

    actingAs($admin)
        ->post(route('admin.user.store'), [
            'username' => 'Shadow',
            'type' => 'member'
        ])
        ->assertSessionHasNoErrors()
        ->assertStatus(302);

    expect(User::where('username', 'Shadow')->first()->exists())
        ->toBeTrue();
});

test('it can update a user as an admin', function () {
    $admin = User::factory()->admin()->create();

    $other_user = User::factory()->member()->create([
        'username' => 'Omega123'
    ]);

    actingAs($admin)
        ->patch(route('admin.user.update', [
            'user' => $other_user->uuid
        ]), [
            'username' => 'Testing 1827'
        ])
        ->assertSessionHasNoErrors()
        ->assertStatus(302);

    expect($other_user->refresh()->username)
        ->toBe('Testing 1827');
});


test('it can update a user role as an admin', function () {
    $admin = User::factory()->admin()->create();

    $other_user = User::factory()->member()->create();

    actingAs($admin)
        ->patch(route('admin.user.update', [
            'user' => $other_user->uuid
        ]), [
            'type' => 'leader'
        ])
        ->assertSessionHasNoErrors()
        ->assertStatus(302);

    expect($other_user->refresh()->type)
        ->toEqual(UserRole::LEADER);

    actingAs($admin)
        ->patch(route('admin.user.update', [
            'user' => $other_user->uuid
        ]), [
            'type' => UserRole::VETERAN->value
        ])
        ->assertSessionHasNoErrors()
        ->assertStatus(302);

    expect($other_user->refresh()->type)
        ->toEqual(UserRole::VETERAN);
});



test('it ensures an admin cannot change their own role', function () {
    $admin = User::factory()->admin()->create([
        'type' => UserRole::STAFF->value
    ]);

    actingAs($admin)
        ->patch(route('admin.user.update', [
            'user' => $admin->uuid
        ]), [
            'type' => UserRole::LEADER->value
        ])
        ->assertSessionHasErrors()
        ->assertStatus(302);
});




test('it ensures an admin can archive a user', function () {
    $admin = User::factory()->admin()->create();
    $other_user = User::factory()->member()->create();

    actingAs($admin)
        ->patch(route('admin.user.update', [
            'user' => $other_user->uuid
        ]), [
            'archived_at' => Carbon::now()
        ])
        ->assertStatus(302);

    expect($other_user->fresh()->archived_at)->not->toBeNull();
});

test('it ensures an admin can recover a user', function () {
    $admin = User::factory()->admin()->create();
    $other_user = User::factory()->member()->create();

    actingAs($admin)
        ->patch(route('admin.user.update', [
            'user' => $other_user->uuid
        ]), [
            'archived_at' => null
        ])
        ->assertStatus(302);

    expect($other_user->fresh()->archived_at)->toBeNull();
});
