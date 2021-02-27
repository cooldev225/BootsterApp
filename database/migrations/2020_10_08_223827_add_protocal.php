<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProtocal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->text('protocal')->after('license');
            $table->text('protocal_date')->after('protocal');
            $table->text('responsible_user_id')->after('protocal_date');
            $table->text('state')->after('responsible_user_id');
            $table->text('city')->after('state');
            $table->text('municipio_cnum')->after('city');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('documents', function (Blueprint $table) {
            //
        });
    }
}
