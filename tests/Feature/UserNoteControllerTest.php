<?php

use App\User;
use App\UserNote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

uses(RefreshDatabase::class);


test('it can create a new user note', function () {
    $user = User::factory()->create();

    actingAs(User::factory()->admin()->create())
        ->post(route('admin.user.add_note', [
            'user' => $user->uuid
        ]), [
            'contents' => 'asd'
        ])->assertStatus(302);

    expect($user->notes()->count())
        ->toBe(1)
        ->and($user->notes()->first()->contents)
        ->toBe('asd');
});

test('it can\'t create a new user note as a regular user', function () {
    $user = User::factory()->create();

    actingAs(User::factory()->create())
        ->post(route('admin.user.add_note', [
            'user' => $user->uuid
        ]), [
            'contents' => 'asd'
        ])
        ->assertStatus(403);

});
