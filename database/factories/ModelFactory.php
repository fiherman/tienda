<?php

date_default_timezone_set('America/Lima');
setlocale(LC_ALL,"es_ES");
$factory->define(App\Casas::class, function (Faker\Generator $faker) {
    return [
        'cas_id'            => strtoUpper(str_random(5)),
        'cas_des'           => strtoUpper($faker->name),
        'cas_dir'           => strtoUpper(str_random(10)),
        'cas_fono'          => str_random(10),
        'cas_fch_reg'       => date('d-m-Y H:i:s'),
        'cas_fch_update'    => date('d-m-Y H:i:s'),
    ];
});

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'cas_id'         => $faker->randomElement(['CAS1','CAS2','CAS3','CAS4']),
        'ape_nom'        => strtoUpper($faker->name),
        'usuario'        => strtoUpper(str_random(10)),
        'password'       => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
        'rol'            => 'USUARIO',
        'fono'           => str_random(10),        
        'estado'         => $faker->randomElement(['0','1']),
        'cad_lar'        => str_random(10)
    ];
});

//TABLA CLIENTES 

$factory->define(App\Cliente::class, function (Faker\Generator $faker) {
    return [
              
            'cli_id'         => strtoUpper(str_random(4)),
            'cas_id'         => $faker->randomElement(['CAS1','CAS2','CAS3','CAS4']),
            'user_id'        => strtoUpper(str_random(4)),
            'cli_ape'        => strtoUpper(str_random(10)),
            'cli_nom'        => strtoUpper(str_random(10)),
            'cli_dir'        => strtoUpper(str_random(10)),
            'cli_dni'        => round(1, 9),
            'cli_movil'      => str_random(10),
            'cli_fijo'       => str_random(10),
            'cli_fch_reg'    => date('d-m-Y H:i:s'),
            'cli_fch_update' => date('d-m-Y H:i:s'),
            'cli_estado'     => $faker->randomElement(['0','1']),
            'cli_cad_lar'    => strtoUpper(str_random(10))
       
    ];
});
//TABLE PRESTAMO
//
//$factory->define(App\Prestamo::class, function (Faker\Generator $faker) {
//    return [
//              
//            'pmo_id'      => strtoUpper(str_random(4)),
//            'user_id'     => strtoUpper(str_random(4)),
//            'cli_id'      => strtoUpper(str_random(4)),
//            'pmo_monto'   => round(10.000, 2),
//            'pmo_moneda'  => strtoUpper(str_random(10)),
//            'pmo_pagado'  => $faker->randomElement(['S','N']),
//            'pmo_fch_reg' => date('d-m-Y'),
//            'pmo_ano_eje' => str_random(4)
//       
//    ];
//});
//TABLE SYSTEM

$factory->define(App\System::class, function () {
    return [
              
            'sys_id'        => strtoUpper(str_random(4)),
            'sys_interes'   => 0.5,
            'sys_rec_ini'   => 1,
            'sys_rec_fin'   => 10,    
       
    ];
});
