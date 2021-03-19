<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('customer_id');
            $table->string('address_type');
            $table->string('receiver_name');
            $table->string('receiver_phone');
            $table->unsignedBigInteger('district_id');
            $table->unsignedBigInteger('province_id')->default(0);
            $table->unsignedBigInteger('city_id')->default(0);
            $table->string('postal_code');
            $table->string('address');
            $table->boolean('is_main')->default(false);
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
        Schema::dropIfExists('addresses');
    }
}
