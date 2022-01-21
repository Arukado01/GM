<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConcreteSamplesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('concrete_samples', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->string('destination');
            $table->string('type');
            $table->string('sample');
            $table->integer('fc_seven_days')->nullable()->default(0);
            $table->integer('fc_twenty_eight_days')->nullable()->default(0);
            $table->integer('fc_fifty_six_days')->nullable()->default(0);
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
        Schema::dropIfExists('concrete_samples');
    }
}
