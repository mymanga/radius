<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRadacctLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('radacct_logs', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->bigInteger('acct_input_octets');
            $table->bigInteger('acct_output_octets');
            $table->timestamp('event_timestamp')->nullable();
            $table->string('event_timestamp_raw')->nullable();
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
        Schema::dropIfExists('radacct_logs');
    }
}
