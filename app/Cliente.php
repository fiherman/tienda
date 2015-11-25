<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
public $timestamps = false;
protected $table = 'cliente';
protected $primaryKey = 'cli_id';
protected $fillable = ['cli_id', 'cas_id', 'us_id', 'cli_ape', 'cli_nom', 'cli_dir', 'cli_dni','cli_movil','cli_fijo','cli_fch_reg','cli_fch_update', 'cli_estado', 'cli_cad_lar'];

}

