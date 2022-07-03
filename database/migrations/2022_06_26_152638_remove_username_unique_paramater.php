<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * This is a Dev only migration that imports the existing DB as a test run
         */
        $db_path = __DIR__.'/../db_2022_06_26.sql';

        if(file_exists($db_path) && env('APP_ENV') === 'local') {
            print_r("Imported old DB\r\n");
            DB::unprepared(file_get_contents($db_path));
        }

        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['username']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unique(['username']);
        });
    }
};
