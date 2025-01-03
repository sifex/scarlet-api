<?php

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
        Schema::dropIfExists('clans');
        Schema::dropIfExists('tokens');
        Schema::dropIfExists('password_resets');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('clans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('shortName')->nullable();
        });

        Schema::create('tokens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('token')->index();
            $table->timestamp('expired_at')->nullable();
            $table->integer('usage_count')->default(0);
            $table->integer('max_usage_limit')->default(1);
            $table->mediumText('data')->nullable();
            $table->string('type')->nullable();
            $table->nullableMorphs('tokenable');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }
};
