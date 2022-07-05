<?php

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;

uses(RefreshDatabase::class);

test('it has a homepage', function () {
    $this->actingAs(User::factory()->admin()->create())
        ->get('/')
        ->assertStatus(200);
});
