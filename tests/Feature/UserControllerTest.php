<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests getting all users
     * @test
     */
    public function getAllUsers()
    {
        User::factory()->count(4)->create();

        $response = $this->get(
            route('api/user/getAll')
        );

        $response->assertStatus(200)->assertJsonCount(4);
    }

    /**
     * Tests getting a specific user
     * @test
     */
    public function getUser()
    {
        $user = User::factory()->create();

        $response = $this->get(
            route('api/user/get', [
                'user' => $user->key
            ])
        );

        $response->assertStatus(200)->assertJson([
            'username' => $user->username,
            'clanID' => $user->clanID,
            'type' => $user->type
        ]);
    }

    /**
     * Tests creating a new user
     * @test
     */
    public function createUser()
    {
        $response = $this->post(
            route('api/user/create'),
            [
                'username' => 'Omega',
                'clanID' => 2,
                'type' => 'Member'
            ]
        );

        $response->assertStatus(200)->assertJson([
            'username' => 'Omega',
            'clanID' => 2,
            'type' => 'Member'
        ]);
    }

    /**
     * Tests updating an existing user
     * @test
     */
    public function updateUser()
    {
        $user = User::factory()->create([
            'installDir' => 'old_install_dir'
        ]);

        $response = $this->post(
            route('api/user/update', [
                'user' => $user->key
            ]),
            [
                'username' => 'Omega',
                'clanID' => 2,
                'type' => 'Member',
                'installDir' => 'new_install_dir'
            ]
        );

        $response->assertStatus(200)->assertJson([
            'installDir' => 'new_install_dir'
        ]);
    }

    /**
     * Tests updating an existing user
     * @test
     */
    public function deleteUser()
    {
        $user = User::factory()->create();

        $response = $this->delete(
            route('api/user/remove', [
                'user' => $user->key
            ])
        );

        $response->assertStatus(200)->assertJson([
            'status' => 'deleted'
        ]);
    }
}
