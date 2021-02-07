<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uniqueID');
            $table->boolean('status');
            $table->string('filename');
            $table->bigInteger('buoy_id');
            $table->integer("messageID");
            $table->integer("deviceID");
            $table->integer("bootID");
            $table->integer("battery");
            $table->string("rmcTime");
            $table->string("rmcDate");
            $table->string('lat1');
            $table->char('lat2', 2);
            $table->string('lon1');
            $table->char('lon2', 2);
            $table->integer('gotfix');
            $table->integer('gps2');
            $table->char('xxx', 5);
            $table->integer('yyy');
            $table->integer('zzz');
            $table->integer('numBoardFound');
            $table->string('data1');
            $table->string('data2');
            $table->string('data3');
            $table->string('data4');
            $table->string('data5');
            $table->string('data6');
            $table->string('data7');
            $table->string('data8');
            $table->string('data9');
            $table->string('data10');
            $table->string('data11');
            $table->string('data12');
            $table->string('data13');
            $table->string('data14');
            $table->string('data15');
            $table->string('data16');
            $table->string('data17');
            $table->string('data18');
            $table->string('data19');
            $table->string('data20');
            $table->string('data21');
            $table->string('data22');
            $table->string('data23');
            $table->string('data24');
            $table->string('data25');
            $table->string('data26');
            $table->string('data27');
            $table->string('data28');
            $table->string('data29');
            $table->string('data30');
            $table->string('data31');
            $table->string('data32');
            $table->string('data33');
            $table->string('data34');
            $table->string('data35');
            $table->string('data36');
            $table->string('data37');
            $table->string('data38');
            $table->string('data39');
            $table->string('data40');
            $table->string('data41');
            $table->string('data42');
            $table->string('data43');
            $table->string('data44');
            $table->string('data45');
            $table->string('data46');
            $table->string('data47');
            $table->string('data48');
            $table->string('data49');
            $table->string('data50');
            $table->string('data51');
            $table->string('data52');
            $table->string('data53');
            $table->string('data54');
            $table->string('data55');
            $table->string('data56');
            $table->string('data57');
            $table->string('data58');
            $table->string('data59');
            $table->string('data60');
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
        Schema::dropIfExists('data');
    }
}
