<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentInboxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_inboxes', function (Blueprint $table) {
            $table->id();
            $table->string('msg_reciever')->nullable();
            $table->string('msg_sender')->nullable();
            $table->float('amount')->nullable();
            $table->string('ref')->nullable();
            $table->string('sender_acc_name')->nullable();
            $table->string('sender_acc_no')->nullable();
            $table->date('date_sent')->nullable();
            $table->date('date_recieved')->nullable();
            $table->string('message')->nullable();
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
        Schema::dropIfExists('payment_inboxes');
    }
}
