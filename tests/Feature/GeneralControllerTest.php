<?php

namespace Tests\Feature;

use Tests\TestCase;

class GeneralControllerTest extends TestCase
{
    /**
     * Tests the index route
     * @test
     * @return void
     */
    public function indexRoute()
    {
        $response = $this->get(
            route('api/index')
        );

        $response->assertStatus(200)->assertJsonStructure([
            'name',
            'version',
            'ip'
        ]);
    }

    /**
     * Tests the Arma Server route
     * @test
     * @return void
     */
    public function armaServerRoute()
    {
        $response = $this->get(
            route('api/armaserver')
        );

        $response->assertStatus(200);
    }

    /**
     * Tests the Teamspeak Server route
     * @test
     * @return void
     */
    public function teamspeakServerRoute()
    {
        $response = $this->get(
            route('api/teamspeak')
        );

        $response->assertStatus(200);
    }
}
