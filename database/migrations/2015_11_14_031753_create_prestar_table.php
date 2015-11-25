<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrestarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prestar', function (Blueprint $table) {
           
            $table->increments('pre_id');          
            $table->string('pmo_id',30);
            $table->integer('user_id');
            $table->string('cli_id',30);
            $table->string('pre_des',30);
            $table->decimal('pre_monto',7,2);
            $table->string('pre_moneda',3);
            $table->decimal('pre_interes',2,2);
            $table->decimal('pre_dias',3,0);
            $table->decimal('pre_int_gen',7,2);
            $table->timestamp('pre_fch');
            $table->timestamp('pre_fch_fin');
            $table->timestamp('pre_fch_up');
            $table->string('pre_ano_eje',4);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('prestar');
    }
}
