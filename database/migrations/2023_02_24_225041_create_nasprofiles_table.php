<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNasprofilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nasprofiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('nas_id');
            $table->string('username');
            $table->string('password');
            $table->boolean('api')->default(0);
            $table->boolean('config')->default(0);
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
        Schema::dropIfExists('nasprofiles');
    }
}
