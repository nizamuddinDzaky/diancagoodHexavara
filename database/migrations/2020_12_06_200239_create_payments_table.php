<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id');
            $table->string('name')->nullable();
            $table->string('transfer_to');
            $table->string('method');
            $table->string('transfer_from_bank')->nullable();
            $table->string('transfer_from_account')->nullable();
            $table->date('transfer_date')->nullable();
            $table->bigInteger('amount')->nullable();
            $table->integer('status')->default(0);
            $table->string('proof')->nullable();
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
        Schema::dropIfExists('payments');
    }
}
