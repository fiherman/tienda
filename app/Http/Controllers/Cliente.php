<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//use App\Cliente;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class Cliente extends Controller
{
    protected $url;
    public function __construct(UrlGenerator $url)
    {
        $this->url = $url;
    }
    
    public function index()
    {
        header('Content-type: application/json');

        $totalg = DB::select('select count(cli_id) as total from vw_cliente_casa');
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

        $sql = DB::table('vw_cliente_casa')->orderBy($sidx,$sord)->limit($limit)->offset($start)->get();
        $table= array();        
        $table['page'] = $page;
        $table['total'] = $total_pages;
        $table['records'] = $count;

        $campos=array('cli_id','cli_ape','cli_nom', 'cli_dir','cli_dni','cli_movil','cli_fijo','cli_estado','cas_id','cas_des','edit','prestamo');

        $data=array();
        $cell=array();
        $rows=array();

        for($x=0; $x<=(count($sql)-1);$x++){ 
            for($y=0;$y<=(count($campos)-1);$y++){
                if($campos[$y]=='edit'){
                    $tt="insert_update_Cliente('".$sql[$x]->$campos[0]."',1);";
                    $data[$y]='<div style="cursor:pointer"><img title="Editar Cliente" width="17px" height="17px" src="'.$this->url->to('images/editar.png').'" onClick="'.$tt.'"></div>';
                }elseif($campos[$y]=='prestamo'){  
                    $pp="est_prestamo_cliente('".$sql[$x]->$campos[0]."');";
                    $data[$y]='<div style="cursor:pointer"><img title="Prestamo Cliente" width="17px" height="17px" src="'.$this->url->to('images/prestamo.png').'" onClick="'.$pp.'"></div>';
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
    
    function buscarCliente($txt){
       header('Content-type: application/json');
        $laPalabras = @split(" ", $txt);
        $lsBus = "";
        for ($i = 0; $i <= count($laPalabras) - 1; $i++) {
            if ($i == 0) {
                $lsBus = " cli_cad_lar LIKE Upper('%" . $laPalabras[$i] . "%')";
            } else {
                $lsBus.=" AND cli_cad_lar LIKE Upper('%" . $laPalabras[$i] . "%')";
            }
        }
            
        $users = DB::select('select count(cli_id) as total from vw_cliente_casa where '.$lsBus);
        $page  = $_GET['page']; 
        $limit = $_GET['rows']; 
        $sidx  = $_GET['sidx']; 
        $sord  = $_GET['sord']; 

        $total_pages = 0;
        if(!$sidx){
            $sidx  = 1;
        }
        $count = $users[0]->total;
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

        $sql = DB::select('select * from vw_cliente_casa where '.$lsBus.' order by '.$sidx.' '.$sord.' limit '.$limit.' offset '.$start);
        $table= array();        
        $table['page'] = $page;
        $table['total'] = $total_pages;
        $table['records'] = $count;

        $campos=array('cli_id','cli_ape','cli_nom', 'cli_dir','cli_dni','cli_movil','cli_fijo','cli_estado','cas_id','cas_des','edit','prestamo');

        $data=array();
        $cell=array();
        $rows=array();

        for($x=0; $x<=(count($sql)-1);$x++){ 
            for($y=0;$y<=(count($campos)-1);$y++){
                if($campos[$y]=='edit'){
                    $tt="insert_update_Cliente('".$sql[$x]->$campos[0]."',1);";
                    $data[$y]='<div style="cursor:pointer"><img title="Editar Cliente" width="17px" height="17px" src="'.$this->url->to('images/editar.png').'" onClick="'.$tt.'"></div>';                    
                }elseif($campos[$y]=='prestamo'){ 
                    $pp="est_prestamo_cliente('".$sql[$x]->$campos[0]."');";
                    $data[$y]='<div style="cursor:pointer"><img title="Prestamo Cliente" width="17px" height="17px" src="'.$this->url->to('images/prestamo.png').'" onClick="'.$pp.'"></div>';
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

    function save(Request $request)
    {
        header('Content-type: application/json');
        $data = $request->all();//        return response()->json($data);       
        if($request->ajax()){ 
            if($this->validar_dni($data['cli_dni']) && !isset($data['cli_id'])){
                return response()->json([
                    'msg'       =>'no',
                    'dni'       => $data['cli_dni']
                ]);  
            }else{
                if(isset($data['cli_id']) && $this->update($request->all(),$data['cli_id'])){//update
                    return response()->json([
                        'msg'       => 'si',
                        'cliente'   => strtoUpper($data['cli_ape']).' '.strtoUpper($data['cli_nom'])
                    ]);
                }
                //insert
                if($this->insert($request->all())){
                    return response()->json([
                        'msg'       => 'si',
                        'cliente'   => strtoUpper(trim($data['cli_ape']))." ".strtoUpper(trim($data['cli_nom']))                        
                    ]);
                }                                   
            }
        }
    }
    public function validar_dni($dni){
        $sql = DB::table('cliente')->select('cli_dni','cli_id')->where('cli_dni','=',$dni)->get();
        if($sql) return true;
        else return false;
    }
    
    public function insert(array $data)
    {   
        $id  = DB::table('cliente')->select('cli_id')->orderBy('cli_id','desc')->get();
        $idd = (substr($id[0]->cli_id, 1)+1);
        $cliente = array(
            'cli_id'        => "C".$idd,
            'cas_id'        => strtoUpper(trim($data['cas_id'])),  
            'user_id'       => trim($data['user_id']),
            'cli_ape'       => strtoUpper(trim($data['cli_ape'])),
            'cli_nom'       => strtoUpper(trim($data['cli_nom'])),
            'cli_dir'       => strtoUpper(trim($data['cli_dir'])),
            'cli_dni'       => $data['cli_dni'],
            'cli_movil'     => trim($data['cli_movil']),
            'cli_fijo'      => trim($data['cli_fijo']),
            'cli_estado'    => $data['cli_estado'],
            'cli_fch_reg'   => date("Y-m-d H:i:s"),
            'cli_fch_update'=> date("Y-m-d H:i:s"),
            'cli_cad_lar'   => strtoUpper(trim($data['cli_ape']))." ".strtoUpper(trim($data['cli_nom']))." ".strtoUpper(trim($data['cli_dni'])),
        );
        $insert=DB::table('cliente')->insert($cliente);
        if ($insert) return true;
        else return false;
    }
    
    public function update(array $data, $cli_id)
    {
        $cliente = array(            
            'cas_id'        => strtoUpper(trim($data['cas_id'])),  
            'user_id'       => trim($data['user_id']),
            'cli_ape'       => strtoUpper(trim($data['cli_ape'])),
            'cli_nom'       => strtoUpper(trim($data['cli_nom'])),
            'cli_dir'       => strtoUpper(trim($data['cli_dir'])),
            'cli_dni'       => $data['cli_dni'],
            'cli_movil'     => trim($data['cli_movil']),
            'cli_fijo'      => trim($data['cli_fijo']),
            'cli_estado'    => $data['cli_estado'],            
            'cli_fch_update'=> date("Y-m-d H:i:s"),
            'cli_cad_lar'   => strtoUpper(trim($data['cli_ape']))." ".strtoUpper(trim($data['cli_nom']))." ".strtoUpper(trim($data['cli_dni'])),
        );
        $insert=DB::table('cliente')->where('cli_id',$cli_id)->update($cliente);
        if ($insert) return true;
        else return false;
    }
    
    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }
    
    public function edit($id)
    {
        //
    }

    

    public function destroy($id)
    {
        //
    }
}
