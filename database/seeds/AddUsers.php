<?php

use Illuminate\Database\Seeder;

class AddUsers extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\User', 5)->create();

        App\User::create([
            'username' => 'omega',
            'password' => Hash::make('1827129361'),
            'email' => 'chess2ryme@gmail.com'
        ]);

        App\User::create([
            'username' => 'test',
            'password' => Hash::make('test'),
            'email' => 'test@test.com'
        ]);
    }
}
