<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class ExistingScarletDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::unprepared(file_get_contents(__DIR__.'/../db_2022_06_26.sql'));
    }
}
