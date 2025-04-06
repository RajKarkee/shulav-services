<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::table('vendors', function (Blueprint $table) {
            // Drop foreign key first
            $table->dropForeign(['service_id']);

            // Rename the column
            $table->renameColumn('service_id', 'category_id');
        });

        // Add the new foreign key
        Schema::table('vendors', function (Blueprint $table) {
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendors', function (Blueprint $table) {
            // Drop new foreign key
            $table->dropForeign(['category_id']);

            // Rename column back to original
            $table->renameColumn('category_id', 'service_id');
        });

        Schema::table('vendors', function (Blueprint $table) {
            $table->foreign('service_id')->references('id')->on('services');
        });
    }
};
