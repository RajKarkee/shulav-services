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
        Schema::table('products', function (Blueprint $table) {
             // Make vendor_id nullable
             $table->unsignedBigInteger('vendor_id')->nullable()->change();

             // Add city_id column
             $table->unsignedBigInteger('city_id')->nullable()->after('vendor_id');
             $table->foreign('city_id')->references('id')->on('cities')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Revert vendor_id to NOT NULL
            $table->unsignedBigInteger('vendor_id')->nullable(false)->change();

            // Drop city_id column and foreign key
            $table->dropForeign(['city_id']);
            $table->dropColumn('city_id');
        });
    }
};
