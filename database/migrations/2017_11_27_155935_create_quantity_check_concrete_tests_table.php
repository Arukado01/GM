<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuantityCheckConcreteTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quantity_check_concrete_tests', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->string('destination');
            $table->double('m3_fused');
            $table->integer('cant_theoretical_samples')->default(0);
            $table->integer('cant_samples_taken')->default(0);
            $table->text('observation')->nullable();

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
        Schema::dropIfExists('quantity_check_concrete_tests');
    }
}
