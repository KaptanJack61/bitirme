<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHelpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('helps', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('person_id')->unsigned();
            $table->Integer('help_types_id')->unsigned();
            $table->bigInteger('quantity');
            $table->Integer('status_id')->unsigned();
            $table->timestamps();

            $table->foreign('help_types_id')->references('id')
                ->on('help_types')->onDelete('cascade');

            $table->foreign('status_id')->references('id')
                ->on('statuses')->onDelete('cascade');

            $table->foreign('person_id')->references('id')
                ->on('people')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('helps');
    }
}
