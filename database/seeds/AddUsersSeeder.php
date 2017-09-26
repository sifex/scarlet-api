<?php

use Illuminate\Database\Seeder;
use Scarlet\User;

class AddUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 5)->create();

        User::create([
            'username' => 'omega',
            'password' => Hash::make('1827129361'),
            'email' => 'chess2ryme@gmail.com'
        ]);

        User::create([
            'username' => 'test',
            'password' => Hash::make('test'),
            'email' => 'test@test.com'
        ]);
    }
}
