<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('person_slug');
            $table->string('email')->nullable();
            $table->bigInteger('phone');
            $table->bigInteger('tc_no')->nullable();
            $table->Integer('neighborhood_id')->unsigned();
            $table->string('street');
            $table->string('city_name')->nullable();
            $table->string('gate_no')->nullable();
            $table->timestamps();

            $table->foreign('neighborhood_id')->references('id')
                ->on('neighborhoods')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('people');
    }
}
