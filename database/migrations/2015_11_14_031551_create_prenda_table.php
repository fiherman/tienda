<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrendaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prenda', function (Blueprint $table) {
            
            $table->increments('pda_id');          
            $table->string('pmo_id',30);
            $table->string('pda_desc',200);
            $table->decimal('pda_monto',7, 2);
            $table->timestamp('pda_fch_reg');
            $table->string('pda_entrega',2);
        
            
          
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('prenda');
    }
}
