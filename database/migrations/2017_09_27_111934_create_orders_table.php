<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('license_plate');
            $table->string('checkout_id');
            $table->string('transaction_id');
            $table->string('product_id');
            $table->string('customer_id');
            $table->string('date');
            $table->string('time');

            $table->string('car_weight');
            $table->string('all_weight');
            $table->string('total_weight');

            $table->string('unit')->nullable();
            $table->boolean('is_carry');

            $table->string('distance')->nullable();
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
        Schema::drop('orders');
    }
}
