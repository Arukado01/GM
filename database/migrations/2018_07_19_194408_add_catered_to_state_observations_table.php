<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCateredToStateObservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('state_observations', function (Blueprint $table) {
            $table->integer('catered')->default(0)->after('non_structural');
            $table->integer('unattended')->default(0)->after('catered');
            $table->integer('total_attended')->default(0)->after('unattended');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('state_observations', function (Blueprint $table) {
            $table->dropColumn(['catered', 'unattended', 'total_attended']);
        });
    }
}
