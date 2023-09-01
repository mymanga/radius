<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('code')->unique();
            $table->dateTime('expiration_time')->nullable();
            $table->string('status')->default('active');
            $table->unsignedInteger('simultaneous_usage_limit')->nullable();
            $table->unsignedInteger('speed_limit')->nullable();
            $table->string('phone')->nullable();
            $table->unsignedInteger('time')->default(null);
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
        Schema::dropIfExists('vouchers');
    }
}
