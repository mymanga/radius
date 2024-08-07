<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPhoneToHotspotSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hotspot_sessions', function (Blueprint $table) {
            // Add the new 'phone' column
            $table->string('phone')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hotspot_sessions', function (Blueprint $table) {
            // Reverse the change (drop the 'phone' column)
            $table->dropColumn('phone');
        });
    }
}
