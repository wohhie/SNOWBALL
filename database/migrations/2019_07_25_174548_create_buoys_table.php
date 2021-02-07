<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuoysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buoys', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('imei');
            $table->string('communityID');
            $table->string('serialNo');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('plan');
            $table->string('back_office');
            $table->string('status');
            $table->string('user_id');
            $table->unique('imei');
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
        Schema::dropIfExists('buoys');
    }
}
