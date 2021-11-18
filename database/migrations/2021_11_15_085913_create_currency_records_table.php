<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrencyRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currency_records', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id');
            $table->integer('project_salary');
            $table->integer('currency_id');
            $table->float('bank_rate');
            $table->float('tex_rate');
            $table->tinyInteger('net');
            $table->tinyInteger('month');
            $table->timestamp('operation_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currency_records');
    }
}
