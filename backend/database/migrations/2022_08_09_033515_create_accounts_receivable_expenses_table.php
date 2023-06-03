<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsReceivableExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts_receivable_expenses', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->id('id_expense');
            $table->unsignedBigInteger('id_type_expense');
            $table->integer('id_user')->unsigned();
            $table->string('code', 10);
            $table->date('date');
            $table->string('year', 10);
            $table->string('month', 10);
            $table->string('payment_method', 10);
            $table->string('observation', 500);
            $table->string('coin', 10);
            $table->decimal('exchange_rate', 10,4);
            $table->decimal('total', 10,2);
            $table->integer('state');
            $table->timestamps();
            $table->foreign('id_type_expense')->references('id_type_expense')->on('type_expenses');
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
        Schema::dropIfExists('accounts_receivable_expenses');
    }
}
