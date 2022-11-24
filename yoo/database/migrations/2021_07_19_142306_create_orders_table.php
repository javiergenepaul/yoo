<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->timestamp('completed_datetime')->nullable();
            $table->foreignId('order_status_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->float('total_mileage')->nullable();
            $table->string('instruction')->nullable();
            $table->foreignId('payment_method_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->float('total_amount')->nullable()->default(0.00);
            $table->float('total_paid')->nullable()->default(0.00);
            $table->float('total_due')->nullable()->default(0.00);
            $table->boolean('holiday')->nullable()->default(false);
            $table->boolean('high_demand')->nullable()->default(false);
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
        Schema::dropIfExists('orders');
    }
}
