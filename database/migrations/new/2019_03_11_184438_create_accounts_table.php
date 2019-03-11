<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->float('balance',10,4)->nullable()->default(0);
            $table->float('total_credit',10,4)->nullable()->default(0);
            $table->float('total_debit',10,4)->nullable()->default(0);
            $table->string('withdrawal_method')->nullable()->default('bank');// Paypal , Stripe
            $table->string('payment_email')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_branch')->nullable();
            $table->string('bank_account')->nullable();
            $table->string('country')->nullable();
            $table->longText('other_details')->nullable();
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
        Schema::dropIfExists('accounts');
    }
}
