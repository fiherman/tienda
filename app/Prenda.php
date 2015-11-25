<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prenda extends Model
{
     public $timestamps = false;
    
    protected $table = 'prenda';
    
    protected $primaryKey = 'pda_id';
    
    protected $fillable = ['pda_id','pm_id', 'pda_desc','pda_monto', 'pda_fch_reg', 'pda_entrega'];
}
