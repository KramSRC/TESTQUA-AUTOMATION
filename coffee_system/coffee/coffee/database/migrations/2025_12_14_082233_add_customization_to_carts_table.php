<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('carts', function (Blueprint $table) {
            // Add these columns if they don't exist
            if (!Schema::hasColumn('carts', 'size')) {
                $table->string('size')->default('small')->after('product_id');
                $table->string('sugar')->default('no_sugar')->after('size');
                $table->string('extra')->nullable()->after('sugar');
            }
        });
    }

    public function down()
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropColumn(['size', 'sugar', 'extra']);
        });
    }
};