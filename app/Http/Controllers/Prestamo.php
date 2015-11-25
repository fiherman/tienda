<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Prestamo extends Controller
{
    function get_num_prestamo(Request $request){
        $data = $request->all();
        $id=$data['cli_id'];
        
        $pmo_num  = DB::table('prestamo')->select('pmo_num')->where('cli_id',$id)->orderBy('pmo_fch_reg','desc')->get();
        if(!$pmo_num){
            return response()->json([            
                'num'   => (1)
            ]);
        }
        return response()->json([            
            'num'   => (($pmo_num[0]->pmo_num)+1)
        ]);
    }
    
    public function insert_prestamo(Request $request)
    {
        $data = $request->all();        

        $pmo_id= $this->save_prestamo($request->all());
        if($pmo_id){
            return response()->json([
                'msg'       => 'si', 
                'pmo_id'    => $pmo_id,
            ]);
        }
//        $asdasd = $this->save_prestamo($request->all());
//        return response()->json($asdasd);
    }

    
    function save_prestamo(array $prestamo)
    {
        date_default_timezone_set('America/Lima');
        setlocale(LC_ALL,"es_ES");
        $pmo_id  = DB::table('prestamo')->select('pmo_id')->orderBy('pmo_fch_reg','desc')->get();
        if($pmo_id){
            $pmo_idd = (substr($pmo_id[0]->pmo_id, 3)+1);
            $this->pmo_idd= $pmo_idd;
        }else{ $pmo_idd = 1; $this->pmo_idd= 1;}
        
        
        $pmo = array(
            'pmo_id'            => "PMO".$pmo_idd,
            'user_id'           => $prestamo['user_id'],
            'cli_id'            => $prestamo['cli_id'],
            'pmo_pagado'        => 'NO',
            'pmo_num'           => $prestamo['pre_num'],
            'pmo_num_prendas'   => $prestamo['pre_num_prendas'],
            'pmo_fch_reg'       => date('d-m-Y H:i:s'),
            'pmo_fch_up'        => date('d-m-Y H:i:s'),
            'pmo_ano_eje'       => date('Y'),
        );
//        $qqq = $this->save_prestar($prestamo,$pmo_idd);
////        return response()->json($asdasd);
//        return $qqq;
        
        $insert=DB::table('prestamo')->insert($pmo);
        if ($insert){ 
            if($this->save_prestar($prestamo,$pmo_idd)){
                return ("PMO".$pmo_idd);
            }else{ return false;}
        }else{ 
            return false;
        }
    }
    
    function save_prestar(array $prestamo,$pmo_id)
    {
        date_default_timezone_set('America/Lima');
        setlocale(LC_ALL,"es_ES");
        
        
        $prestar = array(            
            'pmo_id'        => "PMO".$pmo_id,
            'user_id'       => $prestamo['user_id'],
            'cli_id'        => $prestamo['cli_id'],
            'pre_des'       => 'PRESTAMO',
            'pre_monto'     => round($prestamo['pre_monto'],2),
            'pre_moneda'    => strtoupper($prestamo['pre_moneda']),
            'pre_interes'   => $prestamo['pre_interes'],
            'pre_dias'      => $prestamo['pre_dias'],
            'pre_int_gen'   => round($prestamo['pre_int_gen'],2),
            'pre_fch'       => str_replace('/','-',$prestamo['pre_fch']." ".date('H:i:s')),
            'pre_fch_fin'   => str_replace('/','-',$prestamo['pre_fch_fin']." ".date('H:i:s')),
            'pre_fch_up'    => date('d-m-Y H:i:s'),
            'pre_ano_eje'   => date('Y'),
        );
        $pre_num=$prestamo['pre_num'];
//        return $prestar;
        $insert=DB::table('prestar')->insert($prestar);
        if ($insert){
            if($this->save_estado_prestamo($prestar,'PRESTAMO',$pre_num)){            
                return true;
            }else{ return false;}            
        }else {
            return false;            
        }
    }
    
    function save_prenda(Request $request){
        $data = $request->all();
        if($this->insert_prenda($request->all())){            
            return response()->json([
                'msg'       => 'si',                                      
            ]);            
        }
    }

    
    public function insert_prenda(array $prenda)
    {
        date_default_timezone_set('America/Lima');
        setlocale(LC_ALL,"es_ES");        
        
        $pda = array(            
            'pmo_id'            => $prenda['pmo_id'],
            'pda_desc'          => strtoUpper($prenda['pda_des']),
            'pda_monto'         => $prenda['pda_monto'],            
            'pda_fch_reg'       => date('d-m-Y H:i:s'),
            'pda_entrega'       => 'NO',            
        );
        
        $insert=DB::table('prenda')->insert($pda);
        if ($insert) return true;
        else return false;
    }
  
    function save_estado_prestamo(array $data,$tipo,$pre_num)
    {   
        $est_prestamo = array(                       
            'pmo_id'            => $data['pmo_id'],
            'cli_id'            => $data['cli_id'],
            'num_prestamo'      => $pre_num,
            'est_pre_tipo'      => $tipo,
            'est_pre_interes'   => $data['pre_interes'],            
            'est_pre_monto'     => $data['pre_monto'],
            'est_pre_fch'       => $data['pre_fch'],
            'est_pre_dias'      => $data['pre_dias'],
            'est_pre_int_gen'   => $data['pre_int_gen'],
        );
        
        $insert=DB::table('est_prestamo')->insert($est_prestamo);
        if ($insert) return true;
        else return false;
    }

    function tabla_est_prestamo($cli_id,$num)
    {
        header('Content-type: application/json');
//        $users = DB::table('users')->get();
        $totalg = DB::select("select count(est_pre_id) as total from est_prestamo where cli_id='".$cli_id."' and num_prestamo=".$num);
        $page  = $_GET['page']; 
        $limit = $_GET['rows']; 
        $sidx  = $_GET['sidx']; 
        $sord  = $_GET['sord']; 

        $total_pages = 0;
        if(!$sidx){
            $sidx  = 1;
        }
        $count = $totalg[0]->total;
        if($count > 0){
            $total_pages = ceil($count / $limit);
        }
        if($page > $total_pages){
            $page   = $total_pages;
        }
        $start = ($limit * $page) - $limit; // do not put $limit*($page - 1)  
        if($start<0){
            $start = 0;
        }

        $sql = DB::table('est_prestamo')->
                select('*',\DB::raw('(est_pre_monto+est_pre_int_gen)as total'),\DB::raw("to_char(date(est_pre_fch),'DD-MM-YYYY') as fecha"))
                ->where('cli_id',$cli_id)
                ->where('num_prestamo',$num)
                ->orderBy($sidx,$sord)->limit($limit)->offset($start)->get();
        $table= array();        
        $table['page'] = $page;
        $table['total'] = $total_pages;
        $table['records'] = $count;

        $campos=array('est_pre_id','num','pmo_id','est_pre_tipo','est_pre_interes', 'est_pre_monto','fecha','est_pre_dias','est_pre_int_gen','total');
        
        $num=0;
        $data=array();
        $cell=array();
        $rows=array();

        for($x=0; $x<=(count($sql)-1);$x++){ 
            for($y=0;$y<=(count($campos)-1);$y++){
                if($campos[$y]=='num'){ 
                    $num+=1;
                    $data[$y]=$num;
                }else{
                    $data[$y]=$sql[$x]->$campos[$y];
                }
            }
            $cell['id']= $sql[$x]->$campos[0];
            $cell['cell']=$data;
            array_push($rows, $cell);
        }

        $table['rows']=$rows;

        echo json_encode($table);
        
    }

    public function isset_est_prestamo(Request $request)
    {
        $data = $request->all();
        
        $isset_est_pre  = DB::table('est_prestamo')->select('num_prestamo')
                ->where('cli_id',$data['cli_id'])
                ->orderBy('num_prestamo','desc')
                ->limit(1)
                ->get();
        
        if($isset_est_pre){
            return response()->json([
                'msg'=> 'si',
                'num'=> $isset_est_pre[0]->num_prestamo
            ]);
        }else{
            return response()->json(['msg'=> 'no']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
