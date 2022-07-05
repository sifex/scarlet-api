<?php

use App\User;
use App\UserNote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\Assert;
use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);


test('it can view a users notes', function () {
    $note = UserNote::factory()->create();

    actingAs(User::factory()->admin()->create())
        ->get(route('admin.user.show', [
            'user' => $note->user->uuid
        ]))
        ->assertStatus(200)
        ->assertSee($note->contents);
});

test('it can create a new user note', function () {
    $user = User::factory()->create();

    actingAs(User::factory()->admin()->create())
        ->post(route('admin.user.note.store', [
            'user' => $user->uuid
        ]), [
            'contents' => 'asd'
        ])->assertStatus(302);

    expect($user->notes()->count())
        ->toBe(1)
        ->and($user->notes()->first()->contents)
        ->toBe('asd');
});

test("it can't create a new user note as a regular user", function () {
    $user = User::factory()->create();

    actingAs(User::factory()->create())
        ->post(route('admin.user.note.store', [
            'user' => $user->uuid
        ]), [
            'contents' => 'asd'
        ])
        ->assertStatus(403);

});

test('it can delete a user note', function () {
    $note = UserNote::factory()->create();

    expect($note->author->isAdministrator())->toBeTrue();

    actingAs($note->author)
        ->delete(route('admin.user.note.destroy', [
            'user' => $note->user->uuid,
            'note' => $note->id
        ]))
        ->assertStatus(302);

    expect($note->refresh()->deleted_at)->not()->toBeNull();
});
