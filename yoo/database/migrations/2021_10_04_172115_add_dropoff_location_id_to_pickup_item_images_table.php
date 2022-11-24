<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDropoffLocationIdToPickupItemImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pickup_item_images', function (Blueprint $table) {
            $table->foreignId('dropoff_location_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pickup_item_images', function (Blueprint $table) {
            $table->dropForeign('pickup_item_images_dropoff_location_id_foreign');
        });
    }
}
