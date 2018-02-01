<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->string('transaction_id')->unique();
            $table->string('license_plate');
            $table->string('date');
            $table->string('time');
            $table->string('customer');
            $table->string('product');
            $table->string('car_weight');
            $table->string('all_weight');
            $table->string('total_weight');
            $table->boolean('is_carry');
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
        Schema::drop('transactions');
    }
}
