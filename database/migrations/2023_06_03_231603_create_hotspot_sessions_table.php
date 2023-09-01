<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotspotSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotspot_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('mac')->nullable();
            $table->string('link_login_only')->nullable();
            $table->string('payment_id')->nullable();
            $table->string('requestid')->nullable();
            $table->string('voucher')->nullable();
            $table->string('plan')->nullable();
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
        Schema::dropIfExists('hotspot_sessions');
    }
}
