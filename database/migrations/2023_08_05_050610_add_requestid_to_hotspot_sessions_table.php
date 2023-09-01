<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRequestidToHotspotSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hotspot_sessions', function (Blueprint $table) {
            $table->string('requestid')->nullable()->after('payment_id'); // Add the new column after 'payment_id'
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
            $table->dropColumn('requestid');
        });
    }
}
