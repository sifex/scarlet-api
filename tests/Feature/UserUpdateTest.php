<?php

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('it allows users to update their own user', function () {
    $user = User::factory()->create();
    $this->actingAs($user)
        ->patch(route('user.update', $user), [
            'username' => 'new-username',
            'remark' => 'new-remark',
            'installDir' => 'new-installDir',
        ])
        ->assertStatus(302);

    $this->assertDatabaseHas('users', [
        'username' => 'new-username',
        'remark' => 'new-remark',
        'installDir' => 'new-installDir',
    ]);
});

test('it checks the mods suffix protection feature', function ($installDir, $expected) {
    $user = User::factory()->create();
    $this->actingAs($user)
        ->patch(route('user.update', $user), [
            'username' => 'new-username',
            'remark' => 'new-remark',
            'installDir' => $installDir,
        ])
        ->assertStatus(302);

    $this->assertEquals($expected, $user->installDir);
})->with([
    ['/Users/alex/Desktop/Test', '/Users/alex/Desktop/Test'],
    ['/Users/alex/Desktop/Test/', '/Users/alex/Desktop/Test'],
    ['/Users/alex/Desktop/Test/@Mods_AAF', '/Users/alex/Desktop/Test'],
    ['/Users/alex/Desktop/Test/@Mods_AAF/', '/Users/alex/Desktop/Test'],
    ['C:\Users\alex\Arma 3\Test', 'C:\Users\alex\Arma 3\Test'],
    ['C:\Users\alex\Arma 3\Test\\', 'C:\Users\alex\Arma 3\Test'],
    ['C:\Users\alex\Arma 3\Test\\@Mods_AAF', 'C:\Users\alex\Arma 3\Test'],
    ['C:\Users\alex\Arma 3\Test\\@Mods_AAF\\', 'C:\Users\alex\Arma 3\Test'],
]);
