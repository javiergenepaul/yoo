<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_hours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shop_info_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('weekday')->nullable();
            $table->string('opening')->nullable();
            $table->string('closing')->nullable();
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
        Schema::dropIfExists('shop_hours');
    }
}
