<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrivilegesZonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('privileges_zones', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->id('id_privilege_zone');
            $table->unsignedBigInteger('id_user_type');
            $table->unsignedBigInteger('id_zone');
            $table->unsignedBigInteger('id_privilege');
            $table->integer('state');
            $table->timestamps();

            $table->foreign('id_user_type')->references('id_user_type')->on('user_type');
            $table->foreign('id_zone')->references('id_zone')->on('zones');
            $table->foreign('id_privilege')->references('id_privilege')->on('privileges');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('privileges_zones');
    }
}
