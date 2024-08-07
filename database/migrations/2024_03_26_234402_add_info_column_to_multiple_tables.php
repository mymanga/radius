<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInfoColumnToMultipleTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add 'info' column to 'services' table
        Schema::table('services', function (Blueprint $table) {
            $table->json('info')->nullable()->after('type');
        });

        // Add 'info' column to 'users' table
        Schema::table('users', function (Blueprint $table) {
            $table->json('info')->nullable()->after('text_pass');
        });

        // Add 'info' column to 'vouchers' table
        Schema::table('vouchers', function (Blueprint $table) {
            $table->json('info')->nullable()->after('time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Remove 'info' column from 'services' table
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('info');
        });

        // Remove 'info' column from 'users' table
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('info');
        });

        // Remove 'info' column from 'vouchers' table
        Schema::table('vouchers', function (Blueprint $table) {
            $table->dropColumn('info');
        });
    }
}
