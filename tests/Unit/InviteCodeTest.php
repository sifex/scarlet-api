<?php

namespace Tests\Unit;

use Scarlet\InviteCode;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Scarlet\Http\Controllers\InviteController;
use Scarlet\User;
use Hash;

class InviteCodeTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Check to see if adding an Invite Code and the checking it against the Check Invite Code
     *
     * @return void
     */
    public function testCheckInviteCode()
    {
        $ic = new InviteCode();
        $ic->save();

        $this->assertTrue(InviteController::checkInviteCode($ic->invite_code));
    }

    /**
     * Checking to see if the Invite Code returns false upon an invite code being incorrect
     *
     * @return void
     */
    public function testIncorrectCheckInviteCode()
    {
        $this->assertFalse(InviteController::checkInviteCode('123456'));
    }


    /**
     * Checking to see if the Invite Code returns false upon an invite code being incorrect
     *
     * @return void
     */
    public function testUserTakenInviteCode()
    {
        $user = new User([
            'email' => 'chess2ryme@gmail.com',
            'password' => Hash::make('1827129361'),
            'username' => 'TestingInviteCodeUser'
        ]);
        $user->save();

        $ic = new InviteCode();
        $ic->save();

        $invite_controller = new InviteController();

        $this->assertTrue($invite_controller->assignInviteCode($ic->invite_code, $user));
    }
}
