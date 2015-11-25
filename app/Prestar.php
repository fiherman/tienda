<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prestar extends Model
{
    public $timestamps = false;
    
    protected $table = 'prestar';
    
    protected $primaryKey = 'pre_id';
    
    protected $fillable = ['pre_id','pmo_id', 'cli_id','pre_des','pre_monto','pre_moneda','pre_interes','pre_dias','pre_int_gen','pre_fch','pre_fch_fin','pre_fch_up','pre_ano_eje'];
}
