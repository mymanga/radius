<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMpesaStksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mpesa_stks', function (Blueprint $table) {
            $table->id();
            $table->string('CheckoutRequestID')->unique()->nullable();
            $table->string('MerchantRequestID')->nullable();
            $table->string('Account')->nullable();
            $table->string('BusinessShortCode')->nullable();
            $table->decimal('Amount', 10, 2)->nullable();
            $table->string('ReceiptNumber')->nullable();
            $table->string('PhoneNumber')->nullable();
            $table->string('ResultDesc')->nullable();
            $table->string('ResultCode')->nullable();
            $table->enum('Type', ['client', 'hotspot','invoice','others'])->nullable();
            $table->integer('PlanId')->nullable();
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
        Schema::dropIfExists('mpesa_stks');
    }
}
