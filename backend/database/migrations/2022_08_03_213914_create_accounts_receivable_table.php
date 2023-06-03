<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsReceivableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts_receivable', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->id('id_account_receivable');
            $table->unsignedBigInteger('id_client');
            $table->string('reference', 10);
            $table->string('observation', 500);
            $table->date('broadcast_date');
            $table->date('expirate_date');
            $table->string('coin', 10);
            $table->decimal('exchange_rate',10,4);
            $table->decimal('total',10,2);
            $table->integer('state');
            $table->timestamps();

            $table->foreign('id_client')->references('id_client')->on('clients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts_receivable');
    }
}
