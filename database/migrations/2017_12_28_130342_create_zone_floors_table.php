<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateZoneFloorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zone_floors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number');
            $table->boolean('checked');

            $table->unsignedInteger('zone_id');
            $table->foreign('zone_id')
                ->references('id')
                ->on('zones');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('zone_floors');
    }
}
