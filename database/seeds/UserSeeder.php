<?php

namespace Database\Seeders;

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
//            'clanID' => 2,
            'type' => 'member',
        ]);

        User::factory()
            ->member()
            ->count(50)
            ->create();

        User::factory()
            ->admin()
            ->count(2)
            ->create();
    }
}
