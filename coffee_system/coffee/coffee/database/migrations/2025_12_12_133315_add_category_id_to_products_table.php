<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Add the category_id column
            $table->foreignId('category_id')
                  ->nullable() // Allow temporary nulls for existing records
                  ->constrained() // Creates the foreign key constraint to the 'categories' table
                  ->after('price'); // Place it after the 'price' column for organization
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop the foreign key constraint first
            $table->dropConstrainedForeignId('category_id');
            // Then drop the column itself
            $table->dropColumn('category_id');
        });
    }
};