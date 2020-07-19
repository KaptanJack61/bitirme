<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDemandHelpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demand_help', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('demand_id')->unsigned();
            $table->Integer('help_id')->unsigned();
            $table->timestamps();

            $table->foreign('demand_id')->references('id')
                ->on('demands')->onDelete('cascade');
            $table->foreign('help_id')->references('id')
                ->on('helps')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('demand_help');
    }
}
