<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStateObservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('state_observations', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->integer('total_pending')->default(0);
            $table->integer('previous_open')->default(0);
            $table->integer('total_in_period')->default(0);
            $table->integer('closed_in_period')->default(0);
            $table->integer('planning')->default(0);
            $table->integer('plans')->default(0);
            $table->integer('specifications')->default(0);
            $table->integer('materials')->default(0);
            $table->integer('foundation')->default(0);
            $table->integer('vertical_elem')->default(0);
            $table->integer('mezzanines')->default(0);
            $table->integer('tank_pool')->default(0);
            $table->integer('metallic')->default(0);
            $table->integer('non_structural')->default(0);

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
        Schema::dropIfExists('state_observations');
    }
}
