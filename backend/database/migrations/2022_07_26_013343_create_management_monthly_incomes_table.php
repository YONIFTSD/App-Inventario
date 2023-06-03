<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManagementMonthlyIncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('management_monthly_incomes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->id('id_monthly_income');
            $table->integer('id_user')->unsigned();
            $table->string('code', 10);
            $table->date('date');
            $table->string('year', 10);
            $table->string('month', 10);
            $table->string('observation', 500);
            $table->decimal('total_pen', 10,2);
            $table->decimal('total_usd', 10,2);
            $table->integer('state');
            $table->timestamps();
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
        Schema::dropIfExists('management_monthly_incomes');
    }
}
