<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSteelSampleObservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('steel_sample_observations', function (Blueprint $table) {
            $table->increments('id');
            $table->text('observations')->nullable();

            $table->unsignedInteger('project_id');
            $table->foreign('project_id')
                ->references('id')
                ->on('projects');

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
        Schema::dropIfExists('steel_sample_observations');
    }
}
