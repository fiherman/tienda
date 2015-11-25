<?php

Route::get('/', [
    'uses'  => 'HomeController@index',
    'as'    => 'home'
]);

// Authentication routes...
Route::get('inicio_de_session', [
    'uses'  =>'Auth\AuthController@getLogin',
    'as'    =>'login'
]);
Route::post('inicio_de_session', 'Auth\AuthController@postLogin');

Route::get('logout', [
    'uses' => 'Auth\AuthController@getLogout',
    'as'   => 'logout'
]);

// Registration routes...

Route::post('registro', 'Auth\AuthController@postRegister');

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');



//Route::get('users', 'Prueva@index');

Route::group(['middleware' => 'auth'], function(){
//    Route::get('registro',[
//        'uses'  => 'Auth\AuthController@getRegister',
//        'as'    => 'register'
//    ]);
    
    Route::post('user_delete/{id}', 'Usuarios@destroy');//eliminar usuario
    Route::get('users', 'Usuarios@index'); // tabla grila usuarios 
    Route::get('user_buscar/{txt}', 'Usuarios@indexBuscar'); 
    Route::get('cliente_buscar/{txt}', 'Cliente@buscarCliente');
    Route::get('clientes', 'Cliente@index'); // tabla grilla Clientes
    
    Route::post('system', 'General@system');
    Route::get('casas', 'General@get_casas');  // tabla grilla casas
    Route::get('casa_buscar/{txt}', 'General@buscarCasa'); 
    Route::get('get_all_casas', 'General@combo_casas'); // llena combo CASAS
    
    Route::post('user_save', 'Usuarios@save');//inserta nuevos usuario
    Route::post('casa_save', 'General@casa_save');//inserta nuevos casa
    Route::post('cliente_save', 'Cliente@save');//insert update CLIENTES
    
    Route::post('get_num_prestamo', 'Prestamo@get_num_prestamo');// trae el numero de prestamo de un cliente
    Route::get('get_interes', 'General@get_interes');//trae el interes del tabla system
    Route::post('pmo_prestar_save', 'Prestamo@insert_prestamo');//insert PRESTAMO y PRESTAR
    Route::post('save_prenda', 'Prestamo@save_prenda');//guarda las prendas del prestamo
    Route::get('est_prestamo/{cli_id}/{num}', 'Prestamo@tabla_est_prestamo');// crea la tabla est prestamo
    Route::post('isset_est_prestamo', 'Prestamo@isset_est_prestamo');
//    Route::get('get_num_prestamo', 'Prestamo@tabla_est_prestamo');
    
});


Route::get('/otro', function () {
   	return view('welcome');
//   	$mes=10;
//   	$ano=2015;
//   	$eventos='sdsd';
//   	return view('otro', [
//    	'mes' => $mes,
//    	'ano' => $ano,
//    	'eventos' => $eventos
//	]);
   	
});

//Route::get('/prueva/{id}','Prueva@index');

//Route::get('/logeo', function () {    
//    return view('layout');
//});