<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeshSamplesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mesh_samples', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->string('use');
            $table->string('diameter');
            $table->integer('fy_mpa')->default(0);
            $table->integer('fu_mpa')->default(0);
            $table->integer('p_sold_min')->default(0);
            $table->integer('p_sold')->default(0);
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
        Schema::dropIfExists('mesh_samples');
    }
}
