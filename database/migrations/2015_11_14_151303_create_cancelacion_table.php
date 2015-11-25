<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCancelacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cancelacion', function (Blueprint $table) {
              
            $table->string('can_id',30)->primary();          
            $table->string('pmo_id',30);
            $table->integer('user_id');
            $table->decimal('can_subtot',7, 2);
            $table->decimal('can_interes',7,2);
            $table->decimal('can_total',7, 2);
            $table->timestamp('can_fch_reg');
      
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cancelacion');
    }
}
