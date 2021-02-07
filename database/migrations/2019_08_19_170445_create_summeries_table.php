<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSummeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('summeries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('imei');
            $table->string('operationID');
            $table->string('filename');
            $table->integer('rmcDate');
            $table->integer('rmcTime');
            $table->boolean('dataUsed');
            $table->string('latitude');
            $table->string('longitude');
            $table->integer('depth_of_snow');
            $table->integer('ice_thickness');
            $table->integer('top_ice');
            $table->integer('top_snow');
            $table->integer('bottom_ice');
            $table->boolean('status');
            $table->integer('user_id');
            $table->foreign('imei')->references('imei')->on('buoys');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down(){
        Schema::dropIfExists('summeries');
    }
}
