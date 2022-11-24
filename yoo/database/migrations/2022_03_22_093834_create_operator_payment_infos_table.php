<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOperatorPaymentInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operator_payment_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('package_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('operator_type_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('wallet_method_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('operator_payment_info_status_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->double('amount', 15, 2)->nullable();
            $table->string('receiver_acc_name')->nullable();
            $table->string('receiver_acc_no')->nullable();
            $table->string('sender_acc_name')->nullable();
            $table->string('sender_acc_no')->nullable();
            $table->string('ref_no')->nullable();
            $table->string('pop')->nullable();

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
        Schema::dropIfExists('operator_payment_infos');
    }
}
