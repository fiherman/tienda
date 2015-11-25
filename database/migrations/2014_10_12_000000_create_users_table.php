<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cas_id');
            $table->string('ape_nom');
            $table->string('usuario')->unique();
            $table->string('password', 70);
            $table->enum('rol',['USUARIO','ADMINISTRADOR']);
            $table->string('fono', 15);            
            $table->string('estado', 1);
            $table->string('cad_lar', 200);
            $table->rememberToken();
            $table->timestamps();
//            $table->foreign('cas_id')->references('cas_id')->on('casas');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
