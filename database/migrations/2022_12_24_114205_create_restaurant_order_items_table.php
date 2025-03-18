<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurant_order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('restaurant_order_id');
            $table->unsignedBigInteger('restaurant_id');
            $table->string('menu_name');
            $table->string('resturant_name');
            $table->unsignedBigInteger('menu_id');
            $table->decimal('rate',8,2);
            $table->decimal('qty',8,2);
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
        Schema::dropIfExists('restaurant_order_items');
    }
}
