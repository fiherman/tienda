<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    public $timestamps = false;
    
    protected $table = 'prestamo';
    
    protected $primaryKey = 'pmo_id';
    
    protected $fillable = ['pmo_id', 'user_id', 'cli_id', 'pmo_pagado', 'pmo_num', 'pmo_num_prendas', 'pmo_fch_reg','pmo_fch_up','pmo_ano_eje'];
    
}
