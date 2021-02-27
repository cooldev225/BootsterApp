<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotifyEmailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notify_states', function (Blueprint $table) {
            $table->id();
            $table->integer('business_id')->default(0);
            $table->integer('project_id')->default(0);
            $table->integer('document_id')->default(0);
            $table->integer('group_id')->default(0);
            $table->integer('sub_group_id')->default(0);
            $table->timestamp('alert_01')->nullable();
            $table->timestamp('alert_02')->nullable();
            $table->integer('alert_01_read')->default(0);
            $table->integer('alert_02_read')->default(0);
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
        Schema::dropIfExists('notify_states');
    }
}
