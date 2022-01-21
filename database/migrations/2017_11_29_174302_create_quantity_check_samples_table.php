<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuantityCheckSamplesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quantity_check_samples', function (Blueprint $table) {
            $table->increments('id');
            $table->string('zone');
            $table->double('approx_area')->default(0);
            $table->double('approx_intake')->defailt(0);
            $table->integer('cant_theoretical_sample')->default(0);
            $table->string('percent_approx_advance')->default(0);
            $table->integer('test_performed')->default(0);
            $table->integer('pending_test_validation')->default(0);
            $table->enum('quantity_check_type', ['mesh', 'steel']);

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
        Schema::dropIfExists('quantity_check_samples');
    }
}
