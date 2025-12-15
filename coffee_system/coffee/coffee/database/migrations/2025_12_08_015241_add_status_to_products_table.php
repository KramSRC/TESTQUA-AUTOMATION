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
        Schema::table('products', function (Blueprint $table) {
            // Adds the column as a boolean (true/false)
            // Default is 1 (Enabled) so your current products don't disappear
            $table->boolean('status')->default(1)->after('price');
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            
        });
    }
};
