<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('invoice')->unique();
            $table->string('customer_id');
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->integer('unique');
            $table->unsignedBigInteger('address_id');
            $table->integer('subtotal');
            $table->integer('shipping_cost')->default(0);
            $table->date('shipping_date')->nullable();
            $table->integer('total_cost')->default(0);
            $table->string('shipping');
            $table->integer('status')->default(0);
            $table->string('tracking_number')->nullable();
            $table->timestamp('invalid_at')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
