<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->string('first_name')->nullable();

            $table->string('last_name')->nullable();

            $table->string('username')->unique()->nullable();

            $table->string('name')->nullable();

            $table->string('email')->unique()->nullable();

            $table->string('password');

            $table->string('phone')->unique()->nullable();

            $table->string('profile_picture')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
