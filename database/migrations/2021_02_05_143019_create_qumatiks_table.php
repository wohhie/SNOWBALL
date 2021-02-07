<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQumatiksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qumatiks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("imei")->unique();
            $table->decimal("latitude", 9, 6)->nullable();
            $table->decimal("longitude", 9, 6)->nullable();
            $table->boolean("status")->default(0);
            $table->string("dropbox_dir");
            $table->unsignedBigInteger('community_id');
            $table->unsignedBigInteger('user_id');

            $table->foreign('community_id')->references('id')->on('communities');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('qumatiks');
    }
}
