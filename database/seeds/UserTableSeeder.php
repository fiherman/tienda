<?php

use Illuminate\Database\Seeder;
//use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {      
        date_default_timezone_set('America/Lima');
        $tienda=array('TACNA','LAMPA','INCA','JULIACA','SAN MARTIN');
        
        factory(App\Casas::class)->create([
            'cas_id'        => 'CAS'.(+1),
            'cas_des'       => 'JULIACA',
            'cas_dir'       => 'JR. LAS GARDENIAS 103',
            'cas_fono'      => '054-322199',
            'cas_fch_reg'   => date('d-m-Y H:i:s'),
            'cas_fch_update'=> date('d-m-Y H:i:s'),
        ]);
        

//        DB::table('users')->truncate();
        
        factory(App\User::class)->create([
            'cas_id'    => 'CAS1',
            'ape_nom'   => 'CARDENAS QUISPE ANTONIO',
            'usuario'   => 'ACARDENAS',
            'password'  => bcrypt('admin'),
            'rol'       => 'ADMINISTRADOR',
            'fono'      => '956714364',                        
            'estado'    => '1',
            'cad_lar'   => 'CARDENAS QUISPE ANTONIO 956714364'
        ]);        
        
        
        
//        $dni=12345678;
        $input=array('CAS1','CAS2','CAS3','CAS4','CAS5');
//        for($i=0;$i<=30;$i++){ 
            factory(App\Cliente::class)->create([
                'cli_id'         => 'C1',
                'cas_id'         => $input[rand(0,4)],
                'user_id'        => 1,
                'cli_ape'        => 'VELASQUEZ MAMANI',
                'cli_nom'        => 'VLADIMIRO ETDISSON',
                'cli_dir'        => 'JR. SANDIA 302 MZ 13',
                'cli_dni'        => '46981875',
                'cli_movil'      => '956714364',                
                'cli_fijo'       => '051-123456',
                'cli_fch_reg'    => date('d-m-Y H:i:s'),
                'cli_fch_update' => date('d-m-Y H:i:s'),
                'cli_estado'     => '1',
                'cli_cad_lar'    => 'VELASQUEZ MAMANI VLADIMIRO ETDISSON 46981875'
            ]); 
//        }
    
      
//            factory(App\Cliente::class, 30)->create();
        
    
    //TABLA PRESTAMo
//        for($y=0;$y<=30;$y++){
//            factory(App\Prestamo::class)->create([
//                'pmo_id'      => 'P'.($y+1),
//                'user_id'     => ($y+1),
//                'cli_id'      => 'C1',
//                'pmo_monto'   => ($y*4+10/3),
//                'pmo_moneda'  => 'soles',
//                'pmo_pagado'  => 'SI',
//                'pmo_fch_reg' => date('d-m-Y'),
//                'pmo_ano_eje' => '2015',
//            ]);    
//           
//        }
        
        
        factory(App\System::class)->create([
              'sys_id'        => '1',
              'sys_interes'   => 0.5,
              'sys_rec_ini'   => 1,
              'sys_rec_fin'   => 10,
        ]);
        
    }
}
