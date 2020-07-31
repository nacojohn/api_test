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
            $table->string('trans_id');
            $table->double('amount');
            $table->string('currency');
            $table->dateTime('trans_time');
            $table->string('account_id');
            $table->string('approval_code');
            $table->string('pay_type');
            $table->string('order_id');
            $table->string('status');
            $table->string('mac_string');
            $table->foreign('mac_string')->references('donation_ref')->on('donations');
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
