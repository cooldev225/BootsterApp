<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id');
            $table->integer('parent_id');
            $table->string('title');
            $table->string('description');
            $table->timestamp('due_date')->default(\DB::raw('CURRENT_TIMESTAMP'));//->nullable();
            $table->timestamp('alert_date_01')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('alert_date_02')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
}
