<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('services', function (Blueprint $table) {
            // Make 'username', 'cleartextpassword', and 'ipaddress' columns nullable
            $table->string('username')->nullable()->change();
            $table->string('cleartextpassword')->nullable()->change();
            $table->string('ipaddress')->nullable()->change();

            // Add a new column 'type'
            $table->string('type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('services', function (Blueprint $table) {
            // Reverse changes for 'username', 'cleartextpassword', and 'ipaddress' columns
            $table->string('username')->nullable(false)->change();
            $table->string('cleartextpassword')->nullable(false)->change();
            $table->string('ipaddress')->nullable(false)->change();

            // Drop the 'type' column
            $table->dropColumn('type');
        });
    }
}
