<?php

//use Database\Seeders\UserSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
//            \Database\Seeders\ExistingScarletDatabaseSeeder::class,
            UserSeeder::class,
        ]);
    }
}
