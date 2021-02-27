<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateNullableFieldsBusinessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('business', function (Blueprint $table) {
            $table->string('alert_email_01')->nullable()->change();
            $table->string('alert_email_02')->nullable()->change();
            $table->string('contactor_email_01')->nullable()->change();
            $table->string('contactor_email_02')->nullable()->change();
            $table->string('contactor_phone_01')->nullable()->change();
            $table->string('contactor_phone_02')->nullable()->change();
            $table->string('contactor_name_01')->nullable()->change();
            $table->string('contactor_name_02')->nullable()->change();
            $table->string('mobile_phone')->nullable()->change();
            $table->string('mobile_office')->nullable()->change();
            $table->string('ad_city')->nullable()->change();
            $table->string('ad_state')->nullable()->change();
            $table->string('ad_zip_code')->nullable()->change();
            $table->string('ad_complement')->nullable()->change();
            $table->string('ad_neighborhood')->nullable()->change();
            $table->string('ad_number')->nullable()->change();
            $table->string('ad_street')->nullable()->change();
            $table->string('im')->nullable()->change();
            $table->string('ie')->nullable()->change();
            $table->string('cnpj')->nullable()->change();
            $table->string('last_name')->nullable()->change();
            $table->string('description')->nullable()->change();
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
