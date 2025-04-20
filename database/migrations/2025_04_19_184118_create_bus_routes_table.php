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
        Schema::create('bus_routes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_location_id')->constrained('bus_route_locations')->onDelete('cascade');
            $table->foreignId('to_location_id')->constrained('bus_route_locations')->onDelete('cascade');
            $table->foreignId('bus_type_id')->constrained('bus_types')->onDelete('cascade');
            $table->decimal('distance', 10, 2)->comment('Distance in km');
            $table->decimal('estimated_time', 5, 2)->comment('Travel time in hours');
            $table->decimal('fare', 10, 2)->comment('Base fare amount');
            $table->text('description')->nullable();
            $table->timestamps();
            
       
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bus_routes');
    }
};
