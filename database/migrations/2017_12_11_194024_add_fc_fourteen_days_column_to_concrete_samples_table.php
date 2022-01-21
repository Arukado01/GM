<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFcFourteenDaysColumnToConcreteSamplesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('concrete_samples', function (Blueprint $table) {
            $table->integer('fc_fourteen_days')->nullable()->default(0)->after('fc_seven_days');


            if(Schema::hasColumn('users', 'observations'))
            {
                $table->dropColumn('observations');
            }

            $table->text('sclerometry')->nullable()->after('fc_fifty_six_days');
            $table->text('provider')->nullable()->after('sclerometry');
            $table->text('cores')->nullable()->after('provider');
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
            $table->dropColumn('fc_fourteen_days');
            $table->dropColumn('sclerometry');
            $table->dropColumn('provider');
            $table->dropColumn('cores');
        });
    }
}
