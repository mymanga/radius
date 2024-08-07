<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNetworksTable extends Migration
{
    public function up()
    {
        Schema::create('networks', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('comment')->nullable();
            $table->string('network');
            $table->integer('subnet');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('networks');
    }
}