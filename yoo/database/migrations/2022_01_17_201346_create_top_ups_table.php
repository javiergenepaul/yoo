<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopUpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('top_ups', function (Blueprint $table) {
            $table->id();
            $table->string('request_type')->nullable();
            $table->foreignId('tx_user_type_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->integer('submitted_to')->unsigned()->nullable();
            $table->double('amount', 15, 2)->nullable();
            $table->foreignId('wallet_method_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('top_up_status_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('transaction_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('receiver_acc_name')->nullable();
            $table->string('receiver_acc_no')->nullable();
            $table->string('sender_acc_name')->nullable();
            $table->string('sender_acc_no')->nullable();
            $table->string('ref_no')->nullable();
            $table->string('pop')->nullable();
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('top_ups');
    }
}
