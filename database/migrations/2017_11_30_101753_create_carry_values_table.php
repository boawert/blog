<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarryValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carry_values', function (Blueprint $table) {
            $table->increments('id');
            $table->string('carry_id');
            $table->string('year_month');
            $table->string('carry_price')->nullable();
            $table->string('notcarry_price')->nullable();
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
        Schema::drop('carry_values');
    }
}
