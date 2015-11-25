<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Request;//no funciona para las llamadas ajax.
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\UrlGenerator;
//use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
class Usuarios extends Controller
{
    protected $url;
    public function __construct(UrlGenerator $url)
    {
        $this->url = $url;
    }

    public function index()
    {   
        
        $rol = Auth::user()->rol;// verifica si usuario logeado es administrador
        if($rol=='ADMINISTRADOR'){
            header('Content-type: application/json');
            
            $users = DB::select('select count(id) as total from users');
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

            $sql = DB::table('vw_user_casa')->orderBy($sidx,$sord)->limit($limit)->offset($start)->get();
            $table= array();        
            $table['page'] = $page;
            $table['total'] = $total_pages;
            $table['records'] = $count;

            $campos=array('id','ape_nom','usuario','cas_des','fono','cas_id','estado','edit','del');

            $data=array();
            $cell=array();
            $rows=array();

            for($x=0; $x<=(count($sql)-1);$x++){ 
                for($y=0;$y<=(count($campos)-1);$y++){
                    if($campos[$y]=='edit'){ 
                        $data[$y]='<div style="cursor:pointer"><img title="Editar Usuario" width="17px" height="17px" src="'.$this->url->to('images/editar.png').'" onClick="insertar_nuevo_usuario('.$data[$y]=$sql[$x]->$campos[0].',1);"></div>';
                    }elseif($campos[$y]=='del'){  
                        $data[$y]='<div style="cursor:pointer"><img title="Eliminar Usuario" width="17px" height="17px" src="'.$this->url->to('images/delete.png').'" onClick="confirmar_eliminar('.$data[$y]=$sql[$x]->$campos[0].');"></div>';
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
        }else{
            return redirect()->route('home');
        }
//        $users = DB::select('select * from users limit 10');///
       
    }
    function indexBuscar($txt){
        header('Content-type: application/json');
        $laPalabras = @split(" ", $txt);
        $lsBus = "";
        for ($i = 0; $i <= count($laPalabras) - 1; $i++) {
            if ($i == 0) {
                $lsBus = " cad_lar LIKE Upper('%" . $laPalabras[$i] . "%')";
            } else {
                $lsBus.=" AND cad_lar LIKE Upper('%" . $laPalabras[$i] . "%')";
            }
        }
            
        $users = DB::select('select count(id) as total from vw_user_casa where '.$lsBus);
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

        $sql = DB::select('select * from vw_user_casa where '.$lsBus.' order by '.$sidx.' '.$sord.' limit '.$limit.' offset '.$start);
        $table= array();        
        $table['page'] = $page;
        $table['total'] = $total_pages;
        $table['records'] = $count;

        $campos=array('id','ape_nom','usuario','cas_des','fono','cas_id','estado','edit','del');

        $data=array();
        $cell=array();
        $rows=array();

        for($x=0; $x<=(count($sql)-1);$x++){ 
            for($y=0;$y<=(count($campos)-1);$y++){
                if($campos[$y]=='edit'){ 
                    $data[$y]='<div style="cursor:pointer"><img title="Editar Usuario" width="17px" height="17px" src="'.$this->url->to('images/editar.png').'" onClick="insertar_nuevo_usuario('.$data[$y]=$sql[$x]->$campos[0].',1);"></div>';
                }elseif($campos[$y]=='del'){  
                    $data[$y]='<div style="cursor:pointer"><img title="Eliminar Usuario" width="17px" height="17px" src="'.$this->url->to('images/delete.png').'" onClick="confirmar_eliminar('.$data[$y]=$sql[$x]->$campos[0].');"></div>';
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

    public function create()
    {
//        return view('welcome');
    }

    public function store()
    {
//        $users = User::create(Request::all());        
//        return redirect()->route('welcome');
    }

    public function insert(array $data)
    {
        $user = array(
            'ape_nom'   => strtoUpper(trim($data['ape_nom'])),
            'usuario'   => strtoUpper(trim($data['usuario'])),  
            'fono'      => strtoUpper(trim($data['fono'])),
            'cas_id'    => $data['casa'],
            'password'  => bcrypt(trim($data['contra'])),
            'estado'    => $data['estado'],
            'cad_lar'   => strtoUpper(trim($data['ape_nom']))." ".strtoUpper(trim($data['usuario'])),
            'rol'       => 'USUARIO',            
            'created_at'=> date("d-m-Y H:i:s"),
            'updated_at'=> date("d-m-Y H:i:s"),
        );
        $insert=DB::table('users')->insert($user);
        if ($insert) return true;
        else return false;
    }
    
    public function save(Request $request)
    {
        header('Content-type: application/json');
        $data = $request->all();        
//        $this->validar_user(strtoUpper($data['usuario']));
        if($request->ajax()){ 
            if($this->validar_user(strtoUpper($data['usuario'])) && !isset($data['user_id'])){
                return response()->json([
                    'msg'       =>'no',
                    'usuario'   => strtoUpper($data['usuario'])
                ]);  
            }else{
                if(isset($data['user_id']) && $this->update($request->all(),$data['user_id'])){//update
                    return response()->json([
                        'msg'       => 'si',
                        'usuario'   => strtoUpper($data['usuario'])
                    ]);
                }
                //insert
                if($this->insert($request->all())){
                    return response()->json([
                        'msg'       => 'si',
                        'usuario'   => strtoUpper($data['usuario'])
                    ]);
                }                                   
            }
        }
        
    }
    
    public function validar_user($user){
        $sql = DB::table('users')->select('usuario','id')->where('usuario','=',$user)->get();
        if($sql) return true;
        else return false;
    }

    
    public function update(array $data, $id)
    {      
        $user = array(
            'ape_nom'   => strtoUpper(trim($data['ape_nom'])),
            'usuario'   => strtoUpper(trim($data['usuario'])),  
            'fono'      => strtoUpper(trim($data['fono'])),
            'cas_id'    => $data['casa'],
            'password'  => bcrypt(trim($data['contra'])),
            'estado'    => $data['estado'],
            'cad_lar'   => strtoUpper(trim($data['ape_nom']))." ".strtoUpper(trim($data['usuario'])),
            'rol'       => 'USUARIO',                        
            'updated_at'=> date("Y-m-d H:i:s"),
        );
        $insert=DB::table('users')->where('id',$id)->update($user);
        if ($insert) return true;
        else return false;
    }

  
    public function destroy($id,Request $request)
    {
        $user = DB::table('users')->select('usuario')->where('id','=',$id)->get();
        $delete = User::where('id', '=', $id)->delete();
        
        if($request->ajax()){
            if($delete){
                return response()->json([
                    'usuario'=>$user[0],                    
                ]);
            }            
        }
    }
}
