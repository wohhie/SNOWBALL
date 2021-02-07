<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailDownloadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('email_downloaders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('messageID')->unique();
            $table->dateTime('messageDateTime');
            $table->string('imei');
            $table->string('transmission_no');
            $table->date('rmcDate');
            $table->time('rmcTime');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('filename');;
            $table->string('email_no');
            $table->text('email');
            $table->integer('trackingID');
            $table->bigInteger('buoy_id');
            $table->foreign('buoy_id')->references('imei')->on('buoys');
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
        Schema::dropIfExists('email_downloaders');
    }
}
