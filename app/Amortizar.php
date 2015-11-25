<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Amortizar extends Model
{
    public $timestamps = false;
    
    protected $table = 'amortizar';
    
    protected $primaryKey = 'amo_id';
    
    protected $fillable = ['amo_id','pmo_id', 'cli_id','amo_des','amo_monto','amo_moneda','amo_fch_reg','amo_fch_up','amo_ano_eje'];
}
