<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cancelacion extends Model
{
    public $timestamps = false;
    
    protected $table = 'cancelacion';
    
    protected $primaryKey = 'can_id';
    
    protected $fillable = ['can_id','pmo_id', 'user_id', 'can_subtot', 'can_interes', 'can_total','can_fch_reg'];
}
