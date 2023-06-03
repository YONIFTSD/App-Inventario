<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManagementUtilitiesDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('utilities_detail', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->id('id_utility_detail');
            $table->unsignedBigInteger('id_utility');
            $table->integer('id_detail');
            $table->string('type', 10);
            $table->string('year', 10);
            $table->string('month', 10);
            $table->string('description', 500);
            $table->decimal('total_pen', 10,2);
            $table->decimal('total_usd', 10,2);
            $table->integer('state');
            $table->timestamps();
            $table->foreign('id_utility')->references('id_utility')->on('utilities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('utilities_detail');
    }
}
