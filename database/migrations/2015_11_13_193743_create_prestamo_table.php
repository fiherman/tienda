<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrestamoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prestamo', function (Blueprint $table) {
            
            $table->string('pmo_id',30)->primary();
            $table->integer('user_id');
            $table->string('cli_id',30);
            $table->string('pmo_pagado',2);
            $table->decimal('pmo_num',2,0);
            $table->decimal('pmo_num_prendas',2,0);
            $table->timestamp('pmo_fch_reg');
            $table->timestamp('pmo_fch_up');
            $table->string('pmo_ano_eje',4);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('prestamo');
    }
}
