<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('type')->default(1);
            $table->string('phone',20);
            $table->text('desc')->nullable();
            $table->text('address')->nullable();
            $table->text('image')->default('uploads/vendor/default.png');
            $table->date('dob')->nullable();
            $table->unsignedTinyInteger('gender')->nullable();
            $table->boolean('is_org')->default(false);
            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->unsignedBigInteger('service_id')->nullable();
            $table->foreign('service_id')->references('id')->on('services');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->decimal('lat',20,14)->nullable();
            $table->decimal('lan',20,14)->nullable();
            $table->boolean('active')->default(true);
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
        Schema::dropIfExists('vendors');
    }
}
