<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddT56DaysToConcreteSamplesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('concrete_samples', function (Blueprint $table) {
            $table->string('t_56_days')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('concrete_samples', function (Blueprint $table) {
            $table->dropColumn('t_56_days');
        });
    }
}
