<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateBusinessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('business', function (Blueprint $table) {
            $table->renameColumn('name','first_name');
            $table->string('last_name')->after('name');
            $table->string('cnpj')->after('name');
            $table->string('ie')->after('name');
            $table->string('im')->after('name');
            $table->timestamp('open_date')->after('name');
            $table->string('ad_street')->after('name');
            $table->string('ad_number')->after('name');
            $table->string('ad_neighborhood')->after('name');
            $table->string('ad_complement')->after('name');
            $table->string('ad_zip_code')->after('name');
            $table->string('ad_state')->after('name');
            $table->string('ad_city')->after('name');
            $table->string('mobile_office')->after('name');
            $table->string('mobile_number')->after('name');
            $table->string('contactor_name_01')->after('name');
            $table->string('contactor_phone_01')->after('name');
            $table->string('contactor_email_01')->after('name');
            $table->string('contactor_name_02')->after('name');
            $table->string('contactor_phone_02')->after('name');
            $table->string('contactor_email_02')->after('name');
            $table->string('alert_email_01')->after('name');
            $table->string('alert_email_02')->after('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('business', function (Blueprint $table) {
            //
        });
    }
}
