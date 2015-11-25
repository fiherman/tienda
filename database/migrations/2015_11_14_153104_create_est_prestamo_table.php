<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstPrestamoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('est_prestamo', function (Blueprint $table) {
            
            $table->increments('est_pre_id');          
            $table->string('pmo_id',30);            
            $table->string('est_pre_tipo',20);
            $table->decimal('est_pre_interes',2, 2);
            $table->decimal('est_pre_monto',7, 2);
            $table->timestamp('est_pre_fch');
            $table->decimal('est_pre_dias',3,0);
            $table->decimal('est_pre_int_gen',7, 2);
            
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('est_prestamo');
    }
}
