<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddressColumnsToUserInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_infos', function (Blueprint $table) {
            $table->string('middle_name')->nullable();
            $table->string('country')->nullable();
            $table->string('province')->nullable();
            $table->string('city_municipality')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('barangay')->nullable();
            $table->string('address')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_infos', function (Blueprint $table) {
            $table->dropColumn('middle_name');
            $table->dropColumn('country');
            $table->dropColumn('province');
            $table->dropColumn('city_municipality');
            $table->dropColumn('postal_code');
            $table->dropColumn('barangay');
            $table->dropColumn('address');
        });
    }
}
