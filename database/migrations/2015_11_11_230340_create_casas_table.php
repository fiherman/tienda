<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCasasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('casas', function (Blueprint $table) {
            $table->string('cas_id')->primary();
            $table->string('cas_des',50);
            $table->string('cas_dir',100);
            $table->string('cas_fono',15);
            $table->timestamp('cas_fch_reg'); 
            $table->timestamp('cas_fch_update'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('casas');
    }
}
