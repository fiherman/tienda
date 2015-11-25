<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Casas extends Model
{
    public $timestamps = false;
    
    protected $table = 'casas';
    
    protected $primaryKey = 'cas_id';
    
    protected $fillable = ['cas_id','cas_des', 'cas_dir', 'cas_fono','cas_fch_reg','cas_fch_update'];
}
