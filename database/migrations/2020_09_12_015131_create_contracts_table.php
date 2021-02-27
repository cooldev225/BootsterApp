<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('type');
            $table->string('description');
            $table->double('payment_amount');
            $table->integer('payment_plan');
            $table->integer('payment_status');
            $table->timestamp('start')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('end')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('contracts');
    }
}
