<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDatasToVendorBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendor_bills', function (Blueprint $table) {
            $table->date('paid_date')->nullable();
            $table->string('txn_id')->nullable();
            $table->string('gateway')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendor_bills', function (Blueprint $table) {
            $table->dropColumn(['paid_date','txn_id','gateway']);
        });
    }
}
