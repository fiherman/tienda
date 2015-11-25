<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Casas;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\UrlGenerator;

class General extends Controller
{
   
    protected $url;
    
    public function __construct(UrlGenerator $url)
    {
        $this->url = $url;
    }
   
    public function get_casas(){
        
        header('Content-type: application/json');
//        $users = DB::table('users')->get();
            $totalg = DB::select('select count(cas_id) as total from casas');
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
            $start  = ($limit * $page) - $limit; // do not put $limit*($page - 1)  
            if($start<0){
                $start = 0;
            }

            $sql = DB::table('casas')->orderBy($sidx,$sord)->limit($limit)->offset($start)->get();
            $table= array();        
            $table['page'] = $page;
            $table['total'] = $total_pages;
            $table['records'] = $count;

            $campos=array('cas_id','cas_des','cas_dir', 'cas_fono','cas_fch_reg','edit');

            $data=array();
            $cell=array();
            $rows=array();

            for($x=0; $x<=(count($sql)-1);$x++){ 
                for($y=0;$y<=(count($campos)-1);$y++){
                    if($campos[$y]=='edit'){ 
                        $tt="insert_update_casa('".$sql[$x]->$campos[0]."',1);";
                        $data[$y]='<div style="cursor:pointer"><img title="Editar Casa" width="17px" height="17px" src="'.$this->url->to('images/editar.png').'" onClick="'.$tt.'"></div>';
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
    
    function buscarCasa($txt){
        header('Content-type: application/json');
        $totalg = DB::select("select count(cas_id) as total from casas where cas_des LIKE Upper('%".$txt."%')");
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
        $start  = ($limit * $page) - $limit; // do not put $limit*($page - 1)  
        if($start<0){
            $start = 0;
        }
        
        $sql = DB::select("select * from casas where cas_des LIKE Upper('%".$txt."%') order by ".$sidx." ".$sord." limit ".$limit." offset ".$start);
        $table= array();        
        $table['page'] = $page;
        $table['total'] = $total_pages;
        $table['records'] = $count;

        $campos=array('cas_id','cas_des','cas_dir', 'cas_fono','cas_fch_reg','edit');

        $data=array();
        $cell=array();
        $rows=array();
        
        for($x=0; $x<=(count($sql)-1);$x++){ 
            for($y=0;$y<=(count($campos)-1);$y++){
                if($campos[$y]=='edit'){
                    $tt="insert_update_casa('".$sql[$x]->$campos[0]."',1);";
                    $data[$y]='<div style="cursor:pointer"><img title="Editar Casa" width="17px" height="17px" src="'.$this->url->to('images/editar.png').'" onClick="'.$tt.'"></div>';
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
    
    function combo_casas(Request $request){
        
        $casas = $sql = DB::table('casas')->select('cas_id','cas_des')->get();
        
        $datos=array();
//        $campos=array('cas_id','cas_des');
        for($y=0;$y<=(count($casas)-1);$y++){
            $Lista=array(); 
            $Lista['cas_id']=$casas[$y]->cas_id;
            $Lista['cas_des']=$casas[$y]->cas_des;            
            array_push($datos,$Lista);
        }
        if($request->ajax()){
            return response()->json($datos);
        }
    }
    
    function get_interes(){
        $interes = $sql = DB::table('system')->select('sys_interes')->get();
        return response()->json([
            'interes'     => $interes[0]->sys_interes,            
        ]); 
    }
    
    function system(Request $request){
        $system = $sql = DB::table('system')->get();
        $Lista=array(); 
        $Lista['interes']   = $system[0]->sys_interes;
        $Lista['rec_ini']   = $system[0]->sys_rec_ini;
        $Lista['rec_fin']   = $system[0]->sys_rec_fin;
        if($request->ajax()){
            return response()->json($Lista);
        }
    }
    
    function casa_save(Request $request){
        
        header('Content-type: application/json');
        $data = $request->all();
        
//         return response()->json($data);
        if($request->ajax()){
            if($this->validar_casa(strtoUpper($data['cas_des'])) && !isset($data['cas_id'])){
               return response()->json([
                   'msg'        => 'no',
                   'cas_des'    => strtoUpper($data['cas_des'])   
               ]);
            }else{
                
                if(isset($data['cas_id']) && $this->update_cas($request->all(),$data['cas_id'])){
                    return response()->json([
                        'msg'     => 'si',
                        'cas_des' => strtoUpper($data['cas_des']) 
                    ]);   
                }
                if($this->insert_cas($request->all())){
                    return response()->json([
                        'msg'       => 'si',
                        'cas_des'   => strtoUpper($data['cas_des'])
                    ]);
                }  
            }
        }
    }   
     
    public function validar_casa($casa){
        $sql = DB::table('casas')->select('cas_des','cas_id')->where('cas_des','=',$casa)->get();
        if($sql) return true;
        else return false;
    }
    
    public function insert_cas(array $data){
        $id= DB::select('select cas_id from casas order by cas_id desc limit 1');
        $idd= substr($id[0]->cas_id, 3);
        
        $casa =array(             
            'cas_id'            => 'CAS'.($idd+1),
            'cas_des'           => strtoUpper(trim($data['cas_des'])),  
            'cas_dir'           => strtoUpper(trim($data['cas_dir'])),
            'cas_fono'          => trim($data['cas_fono']),
            'cas_fch_reg'       => date('d-m-Y H:i:s'),    
            'cas_fch_update'    => date('d-m-Y H:i:s'), 
        );
        $insert_cas=DB::table('casas')->insert($casa);
        if ($insert_cas) 
            return true;
        else return false; 
    }
    
     public function update_cas(array $data, $cas_id)
    {      
        $casa = array(
            'cas_des'      => strtoUpper(trim($data['cas_des'])),  
            'cas_dir'      => strtoUpper(trim($data['cas_dir'])),
            'cas_fono'     => strtoUpper(trim($data['cas_fono'])),
        );
        $update_cas=DB::table('casas')->where('cas_id',$cas_id)->update($casa);
        if ($update_cas) return true;
        else return false;
    }
    
}
