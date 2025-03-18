<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRealstatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('realstates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('desc');
            $table->decimal('rate',8,2);
            $table->string('contacts');
            // images(multiple image)
            $table->text('image')->nullable();
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('location_id');
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
        Schema::dropIfExists('realstates');
    }
}
