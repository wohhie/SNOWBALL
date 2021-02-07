<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQumatikData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qumatik_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('filename', 255)->nullable()->unique();
            $table->longText('filepath')->nullable()->unique();
            $table->decimal('rho0', 8, 4)->nullable()->default('0.0');
            $table->decimal('rho1', 8, 4)->nullable()->default('0.0');
            $table->decimal('rho2', 8, 4)->nullable()->default('0.0');
            $table->decimal('em31Height', 8, 4)->nullable()->default('0.0');
            $table->decimal('avg_ice_thickness', 8, 4)->nullable()->default('0.0');
            $table->decimal('min_ice_thickness', 8, 4)->nullable()->default('0.0');
            $table->decimal('max_ice_thickness', 8, 4)->nullable()->default('0.0');
            $table->json('datas');
            $table->string('start_time');
            $table->string('end_time');
            $table->unsignedBigInteger('qumatik_id');
            $table->foreign('qumatik_id')->references('id')->on('qumatiks');
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
        Schema::dropIfExists('qumatik_data');
    }
}
