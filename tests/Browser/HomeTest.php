<?php /** @noinspection PhpUnhandledExceptionInspection */

use App\User;
use Laravel\Dusk\Browser;

it('has homepage', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/')
            ->assertSee('Scarlet')
            ->assertSee('Steam');
    });
});

it('shows username of regular user', function () {
    $user = User::factory()->create([
        'type' => 'member'
    ]);
    $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)->visit('/')
                ->screenshot('test')
                ->assertSee($user->username)->assertDontSee('Admin');
        });
});

it('shows admin button', function () {
    $user = User::factory()->admin()->create();
    $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)->visit('/')
                ->assertSee('Admin');
        });
});
