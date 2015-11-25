<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    public $timestamps = false;
    
    protected $table = 'system';
    
    protected $primaryKey = 'sys_id';
    
    protected $fillable = ['sys_id','sys_interes', 'sys_rec_ini','sys_rec_fin'];
}
