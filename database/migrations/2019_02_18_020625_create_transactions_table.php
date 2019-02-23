<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->integer('user_id');// A transaction belongs to a user
            $table->integer('qrcode_owner_id')->nullable();
            $table->integer('qrcode_id');// The qrcode being bought
            $table->string('payment_method')->nullable();// paypal,paystack etc
            $table->longText('message')->nullable();
            $table->float('amount',10,4);
            $table->string('status')->default('initiated');//Initiated, completed but not successful,completed and succesful
            $table->softDeletes();
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
