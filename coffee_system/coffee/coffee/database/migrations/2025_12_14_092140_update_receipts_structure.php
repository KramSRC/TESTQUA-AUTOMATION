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
            // Drop old columns
            $table->dropColumn(['dining_option', 'table_number']);

            // Add new address column
            $table->text('address')->after('phone_number')->nullable();
        });
    }

    public function down()
    {
        Schema::table('receipts', function (Blueprint $table) {
            $table->string('dining_option')->default('dine_in');
            $table->integer('table_number')->nullable();
            $table->dropColumn('address');
        });
    }
};
