<?php

use App\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->uuid()->nullable();
            $table->index(['uuid']);
        });

        /**
         * This is horribly inefficient but works...
         */
        User::without('notes')->chunk(20, function ($users) {
            /** @var User $user */
            foreach ($users as $user) {
                if ($user->uuid === null || $user->uuid === '') {
                    $user->uuid = (string) Uuid::generate(4);
                    $user->save();
                }
            }
        });
        Schema::table('users', function (Blueprint $table) {
            $table->uuid()->nullable(false)->change();
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
            $table->dropIndex(['uuid']);
            $table->dropColumn('uuid');
        });
    }
};
