<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFinishTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->integer('finished_status')->default(0)->after('municipio_cnum');
            $table->integer('finished_by')->default(0)->after('finished_status');
            $table->timestamp('finished_at')->after('finished_by')->default(\DB::raw('CURRENT_TIMESTAMP'))->after('finished_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            //
        });
    }
}
