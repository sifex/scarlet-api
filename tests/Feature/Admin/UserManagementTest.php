<?php

use App\Enum\UserRole;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;

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
        ->assertStatus(200)
        ->assertSessionHasNoErrors();
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




test('it ensures an admin can delete a user', function () {
    $admin = User::factory()->admin()->create();
    $user = User::factory()->member()->create();

    actingAs($admin)
        ->delete(route('admin.user.destroy', [
            'user' => $user->uuid
        ]))
        ->assertStatus(302)
        ->assertSessionHasNoErrors();

    expect($user->fresh()->deleted_at)->not->toBeNull()->and(
        expect($user->fresh()->trashed())->toBeTrue()
    );
});

test('it ensures an admin can recover a user', function () {
    $admin = User::factory()->admin()->create();
    $user = User::factory()->member()->create();

    // Delete the user
    $user->delete();

    expect($user->trashed())->toBeTrue();

    actingAs($admin)
        ->delete(route('admin.user.destroy', [
            'user' => $user->uuid,
        ]), [
            'restore' => true
        ])
        ->assertStatus(302)
        ->assertSessionHasNoErrors();

    expect($user->fresh()->deleted_at)->toBeNull()->and(
        expect($user->fresh()->trashed())->toBeFalse()
    );
});

test('it ensures an admin can\'t delete themselves', function () {
    $admin = User::factory()->admin()->create();

    actingAs($admin)
        ->delete(route('admin.user.destroy', [
            'user' => $admin->uuid,
        ]), [
            'restore' => true
        ])
        ->assertSessionHasErrors()
        ->assertStatus(302);

    expect($admin->fresh()->deleted_at)->toBeNull()->and(
        expect($admin->fresh()->trashed())->toBeFalse()
    );
});
