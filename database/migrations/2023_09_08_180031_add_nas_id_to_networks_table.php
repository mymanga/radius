<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNasIdToNetworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('networks', function (Blueprint $table) {
            // Adding the nas_id column
            $table->integer('nas_id')->nullable()->after('subnet');

            // Adding the foreign key relationship
            $table->foreign('nas_id')->references('id')->on('nas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('networks', function (Blueprint $table) {
            // Dropping the foreign key constraint
            $table->dropForeign(['nas_id']);
            
            // Dropping the nas_id column
            $table->dropColumn('nas_id');
        });
    }

}
