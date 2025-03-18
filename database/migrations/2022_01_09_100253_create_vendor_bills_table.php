<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_bills', function (Blueprint $table) {
            $table->id();
            $table->string('name',100);
            $table->string('particular',100);
            $table->integer('amount');
            $table->integer('type');
            $table->boolean('paid')->default(false);
            $table->unsignedBigInteger('vendor_id');
            $table->unsignedBigInteger('service_id')->nullable();
            $table->dateTime('date');
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
        Schema::dropIfExists('vendor_bills');
    }
}
