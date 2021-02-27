<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateNotifyStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notify_states', function (Blueprint $table) {
            $table->dropColumn('alert_01');
            $table->dropColumn('alert_02');
            $table->dropColumn('alert_01_read');
            $table->dropColumn('alert_02_read');
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notify_states', function (Blueprint $table) {
            //
        });
    }
}
