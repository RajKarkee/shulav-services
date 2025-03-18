<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaidToVendorServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendor_services', function (Blueprint $table) {
            $table->tinyInteger('paid')->default(1);
            $table->tinyInteger('renew')->default(1);
            $table->date('till')->nullable();
            $table->unsignedBigInteger('bill_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendor_services', function (Blueprint $table) {
            $table->dropColumn('paid');
            $table->dropColumn('renew');
            $table->dropColumn('till');
            $table->dropColumn('bill_id');
        });
    }
}
