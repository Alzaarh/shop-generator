<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_addresses', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->string('country')->nullable();

            $table->string('state')->nullable();

            $table->string('city')->nullable();

            $table->text('address');

            $table->string('zip_code')->nullable();
            
            $table->string('receiver_name')->nullable();

            $table->string('receiver_phone')->nullable();

            $table->json('geo_location')->nullable();

            $table->unsignedBigInteger('user_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('user_addresses');
    }
}
