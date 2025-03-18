<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->integer('type')->default(0);
            $table->unsignedBigInteger('job_id');
            $table->foreign('job_id')->references('id')->on('jobs');
            $table->integer('status')->default(0);
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->foreign('vendor_id')->references('id')->on('vendors');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('payments');
    }
}
