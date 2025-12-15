<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('receipts', function (Blueprint $table) {
            $table->string('customer_name')->after('user_id')->nullable();
            $table->string('phone_number')->after('customer_name')->nullable();
            $table->string('dining_option')->after('phone_number')->default('dine_in');
            $table->integer('table_number')->after('dining_option')->nullable();
            $table->string('payment_method')->after('table_number')->default('cash');
            $table->text('notes')->after('payment_method')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('receipts', function (Blueprint $table) {
            //
        });
    }
};
