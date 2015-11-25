<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cliente', function (Blueprint $table) {
            $table->string('cli_id',30)->primary();          
            $table->string('cas_id',30);
            $table->integer('user_id');
            $table->string('cli_ape',60);
            $table->string('cli_nom',60);
            $table->string('cli_dir',100);
            $table->string('cli_dni',8)->unique();
            $table->string('cli_movil',15);            
            $table->string('cli_fijo',15);
            $table->timestamp('cli_fch_reg');
            $table->timestamp('cli_fch_update');
            $table->string('cli_estado',1);
            $table->string('cli_cad_lar',200);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cliente');
    }
}
