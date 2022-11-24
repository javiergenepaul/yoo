<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDistanceToDropoffLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dropoff_locations', function (Blueprint $table) {
            $table->float('mileage')->nullable()->default(0);
            $table->string('landmark')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dropoff_locations', function (Blueprint $table) {
            $table->dropColumn('mileage');
            $table->dropColumn('landmark');
        });
    }
}
