<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManagementIncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incomes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->id('id_income');
            $table->integer('id_business')->unsigned();
            $table->integer('id_user')->unsigned();
            $table->string('code', 10);
            $table->date('date');
            $table->string('year', 10);
            $table->string('month', 10);
            $table->string('observation', 500);
            $table->string('coin', 5)->nullable();
            $table->decimal('exchange_rate', 10,4);
            $table->decimal('total', 10,2);
            $table->integer('state');
            $table->timestamps();
            $table->foreign('id_business')->references('id_business')->on('business');
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
        Schema::dropIfExists('incomes');
    }
}
