<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdditionalReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('additionalreports', function (Blueprint $table) {
            $table->increments('id');
            $table->string('license_plate')->nullable();
            $table->string('checkout_id')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('product_name')->nullable();
            $table->string('customer_name')->nullable();
            $table->dateTime('date_time')->nullable();

            $table->string('car_weight')->nullable();
            $table->string('all_weight')->nullable();
            $table->string('total_weight')->nullable();

            $table->string('unit')->nullable();
            $table->string('price')->nullable();

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
        Schema::drop('additionalreports');
    }
}
