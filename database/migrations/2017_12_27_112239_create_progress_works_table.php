<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgressWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('progress_works', function (Blueprint $table) {
            $table->increments('id');
            $table->string('zone');
            $table->double('piloting');
            $table->double('foundation');
            $table->double('structure');
            $table->double('masonry');

            $table->unsignedInteger('project_id');
            $table->foreign('project_id')
                ->references('id')
                ->on('projects');

            $table->softDeletes();
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
        Schema::dropIfExists('progress_works');
    }
}
