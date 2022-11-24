<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('tx_type_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('tx_user_type_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('source_id')->nullable();
            $table->string('ref_code')->nullable();
            $table->double('amount', 15, 2)->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
