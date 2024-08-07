<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataUsageByPeriodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_usage_by_period', function (Blueprint $table) {
            $table->string('username');
            $table->dateTime('period_start');
            $table->dateTime('period_end')->nullable();
            $table->bigInteger('acctinputoctets');
            $table->bigInteger('acctoutputoctets');
            $table->primary(['username', 'period_start']);
        });

        // Create indexes
        Schema::table('data_usage_by_period', function (Blueprint $table) {
            $table->index('period_start', 'idx_data_usage_by_period_period_start');
            $table->index('period_end', 'idx_data_usage_by_period_period_end');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_usage_by_period');
    }
}
