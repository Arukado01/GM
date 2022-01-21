<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLastDateUpdatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('last_date_updates', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('last_update');
            $table->enum('type', [
                'sample_concrete',
                'verify_concrete',
                'sample_steel',
                'verify_steel',
                'sample_mesh',
                'verify_mesh'
            ]);

            $table->unsignedInteger('project_id');
            $table->foreign('project_id')
                ->references('id')
                ->on('projects');

            $table->unique(['project_id', 'type']);
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
        Schema::dropIfExists('last_date_updates');
    }
}
