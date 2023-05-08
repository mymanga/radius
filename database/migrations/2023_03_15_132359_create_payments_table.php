<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('transaction_type')->nullable();
            $table->string('transaction_id')->nullable();
            $table->dateTime('transaction_time')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->string('business_short_code')->nullable();
            $table->string('bill_reference')->nullable();
            $table->string('invoice_number')->nullable();
            $table->decimal('org_account_balance', 10, 2)->nullable();
            $table->string('third_party_trans_id')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('status')->default('validated');
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
        Schema::dropIfExists('payments');
    }
}
