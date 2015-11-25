<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Est_prestamo extends Model
{
    public $timestamps = false;
    
    protected $table = 'est_prestamo';
    
    protected $primaryKey = 'est_pre_id';
    
    protected $fillable = ['est_pre_id','pmo_id','cli_id','num_prestamo','est_pre_tipo', 'est_pre_interes', 'est_pre_monto','est_pre_fch','est_pre_dias','est_pre_int_gen'];
}
