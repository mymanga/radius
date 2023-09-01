<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPlanAndVoucherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Modify the plans table
        Schema::table('plans', function (Blueprint $table) {
            $table->integer('duration')->nullable()->change(); // make duration nullable
            $table->bigInteger('data_limit')->unsigned()->nullable()->after('duration'); // add the data_limit column after duration

            // New columns based on the form
            $table->time('valid_from')->nullable()->after('public'); // Valid From
            $table->time('valid_to')->nullable()->after('public'); // Valid To
            $table->json('valid_days')->nullable()->after('public'); // Valid Days
            $table->boolean('offer')->default(false)->after('public'); // Offer flag
            $table->text('offer_details')->nullable()->after('public'); // Offer details
            $table->decimal('discount_rate', 5, 2)->nullable()->after('public'); // Discount rate
        });

        // Modify the vouchers table
        Schema::table('vouchers', function (Blueprint $table) {
            $table->bigInteger('data_limit')->unsigned()->nullable()->after('speed_limit'); // add the data_limit column after speed_limit
            $table->unsignedInteger('time')->nullable()->default(null)->change(); // make time nullable and set default to null

            // New columns based on the form
            $table->time('valid_from')->nullable()->after('data_limit'); // Valid From
            $table->time('valid_to')->nullable()->after('data_limit'); // Valid To
            $table->json('valid_days')->nullable()->after('data_limit'); // Valid Days
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Reverse modifications to the plans table
        Schema::table('plans', function (Blueprint $table) {
            $table->integer('duration')->nullable(false)->change(); // make duration not nullable
            $table->dropColumn('data_limit'); // remove the data_limit column

            // Remove new columns
            $table->dropColumn('valid_from');
            $table->dropColumn('valid_to');
            $table->dropColumn('valid_days');
            $table->dropColumn('offer');
            $table->dropColumn('offer_details');
            $table->dropColumn('discount_rate');
        });

        // Reverse modifications to the vouchers table
        Schema::table('vouchers', function (Blueprint $table) {
            $table->dropColumn('data_limit'); // remove the data_limit column
            $table->time('time')->nullable(false)->change(); // make time not nullable

            // Remove new columns
            $table->dropColumn('valid_from');
            $table->dropColumn('valid_to');
            $table->dropColumn('valid_days');
            $table->dropSoftDeletes();
        });
    }
}
