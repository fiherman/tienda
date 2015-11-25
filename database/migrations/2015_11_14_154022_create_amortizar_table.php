<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAmortizarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amortizar', function (Blueprint $table) {
            
            $table->increments('amo_id');
            $table->string('pmo_id',30);
            $table->integer('user_id');
            $table->string('cli_id',30);
            $table->string('amo_des',30);
            $table->decimal('amo_monto',7,2);
            $table->string('amo_moneda',3);            
            $table->timestamp('amo_fch_reg');
            $table->timestamp('amo_fch_up');
            $table->string('amo_ano_eje',4);
            
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('amortizar');
    }
}
