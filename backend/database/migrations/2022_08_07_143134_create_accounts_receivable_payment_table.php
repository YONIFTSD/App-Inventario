<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsReceivablePaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts_receivable_payment', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->id('id_account_receivable_payment');
            $table->unsignedBigInteger('id_account_receivable');
            $table->integer('id_user')->unsigned();
            $table->string('reference', 10);
            $table->string('payment_method', 10);
            $table->date('payment_date');
            $table->decimal('total',10,2);
            $table->integer('state');
            $table->timestamps();

            $table->foreign('id_account_receivable')->references('id_account_receivable')->on('accounts_receivable');
            $table->foreign('id_user')->references('id_user')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts_receivable_payment');
    }
}
