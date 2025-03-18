<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImagetypeToVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->string('phone',20)->nullable()->change();
            $table->integer('img_type')->default(1);
            $table->unsignedBigInteger('city_id')->nullable()->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->dropColumn('img_type');
        });
    }
}
