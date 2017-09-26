<?php

use Illuminate\Database\Seeder;
use Scarlet\InviteCode;

class InviteCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        InviteCode::create();
    }
}
