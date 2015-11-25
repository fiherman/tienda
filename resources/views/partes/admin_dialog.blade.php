<style type="text/css">
    .ui-jqgrid tr.jqgrow td {font-size:0.8em}
    
    .btn_full_act{
        background-color:#DFE8F6;                                  
        color:#0C509D;
        /*    font-family:arial;
            font-size:19px;*/
        font-weight:bold;
        padding:4px 12px; 
        border: 1px solid #99BCE8;  
        margin-top: -1%;
        float: right;
        margin-right: 15px;
    }
    .btn_full_act:hover{
        color: white;
        background-color: #418BC3;
    }
    .btn_full_act:active{ 
        color: #418BC3;
        background-color: #FFFFFF;
    }
    .btn_full_act[disabled="disabled"]{
        color: #99BCE8;
        background-color: #d1e5f9;//#d1e5f9;
        border: #99BCE8 solid 1px;
    }
    .ctrl_input_t {
        text-transform: uppercase;
        height: 25px;
        padding: 4px 5px 3px 5px ;
        font-size: 12px;
        color: #2A2A2A;
        vertical-align: middle;
        background: #FAFEF9;
        border: 1px solid #83CBFF;
        border-radius: 2px;
      /*  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
                box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
      */  -webkit-transition: border-color ease-in-out 0.15s, box-shadow ease-in-out 0.15s;
                transition: border-color ease-in-out 0.15s, box-shadow ease-in-out 0.15s;


    }
    .ctrl_input_t:focus{
          -moz-box-shadow: 0px 0px 5px #66AFE9;
          -webkit-box-shadow: 0px 0px 5px #66AFE9;
          box-shadow: 0px 0px 5px #66AFE9;
          border: 1px solid #66AFE9;
    }
    .ctrl_input{
    margin: 10px 4px 4px;
    text-align: left;
    }
    .ctrl_lavel_0{
        width: 12%;
        text-align: right;
    }

</style>


<!-- ADMINISYTRACION DEL SISTEMA PANEL-->
<div id="div_adm_all" title="ADMINISTRACION DEL SISTEMA" style="display: none;">
    <div style="height: 100%;padding: 5%; font-size: 13px">       
        <div style="float: left;width: 30%;border: 1px solid #418BC3;border-radius: 3px">
            <a href="#" onclick="open_dialog_load_all_user();" class="list_group_item" style="opacity: 0.8;">
                <center><div style="background: #DFEFFC;color:#2E6EAE; height: 35px;padding-top: 4%"><b>USUARIOS</b></div>
                    <img src="{{ asset('images/user.png') }}" class="img-rounded img-responsive" style="width: 90%;">
                </center>
            </a>                       
        </div>          
        <div style="float: left;width: 30%;border: 1px solid #418BC3;border-radius: 3px; margin-left: 5%">
            <a href="#" onclick="open_dialog_load_all_casas();" class="list_group_item" style="opacity: 0.8;">
                <center><div style="background: #DFEFFC;color:#2E6EAE; height: 35px;padding-top: 4%"><b>CASAS</b></div>
                    <img src="{{ asset('images/banco.png') }}" class="img-rounded img-responsive" style="width: 60%;">
                </center>
            </a>                       
        </div>
        <div style="float: left;width: 30%;border: 1px solid #418BC3;border-radius: 3px; margin-left: 5%">
            <a href="#" onclick="dialog_get_system();" class="list_group_item" style="opacity: 0.8;">
                <center><div style="background: #DFEFFC;color:#2E6EAE; height: 35px;padding-top: 4%"><b>SISTEMA</b></div>
                    <img src="{{ asset('images/configurar.png') }}" class="img-rounded img-responsive" style="width: 60%;">
                </center>
            </a>                       
        </div>
    </div>
</div>

<!-- DIALOG GRID USUARIOS-->
<div id="dialog_load_all_user" title="LISTA DE USUARIOS" style="display: none;">
    <div class="filtros">
        <p class="spanasis">BUSCAR USUARIO</p><br/>        
        <div style="margin: -5px 0px -12px 20px">
            Buscar: <input type="text" id="txtbuscar_user" style="text-transform:uppercase;padding: 3px 10px;width:50%; height: 23px; border-radius: 3px;border: 1px solid #C0CDF6;margin-bottom: 5px;"/>
            &nbsp;&nbsp;&nbsp;&nbsp;<button class="btn_full" id="btn_buscar_user" onClick="btn_buscar_user();" title="Enter">Buscar</button>            
        </div>
    </div>
    <div style="margin: 1.5% 1.5% 1%;">
        <table id="table_user"></table>
        <div id="pager_table_user"></div>
    </div> 
    <hr style="background-color: #418BC3; height: 1px; border: 0;">
    <button class="btn_full_act"  onClick="dialog_close('dialog_load_all_user');"><img src="{{asset('images/salir.png')}}" style="width:20px;margin-right: 2px">Salir</img></button>
    <button class="btn_full_act"  onClick="insertar_nuevo_usuario(0,0);"><img src="{{asset('images/usuario.png')}}" style="width:20px;margin-right: 4px">Nuevo Usuario</img></button>
    <button class="btn_full_act"  onClick="btn_actualizar_grilla('table_user','users');"><img src="{{asset('images/actualizar.png')}}" style="width:20px;margin-right: 4px">Actualizar Tabla</img></button>
</div>
<!-- REGISTER AND UPDATE USUARIOS-->
<div id="dialog_insert_new_user" title="" style="display: none">    
     <div class="filtros">
        <p class="spanasis">DATOS DEL USUARIO</p><br/>        
        <div class="ctrl_input">               
            <input type="hidden" id="user_id" value="0" >
            <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
            <label class="ctrl_lavel_0" style="width:25%">Apellidos y Nombres</label>
            <input type="text" class="ctrl_input_t" style="width: 70%;" id="reg_usuario_ape_nom" onblur="fn_onblur(this);" value="">
        </div>
        <div class="ctrl_input">
            <label class="ctrl_lavel_0" style="width:25%">Usuario</label>
            <input type="text" class="ctrl_input_t" style="width: 40%" id="reg_usuario_usuario" onblur="fn_onblur(this);">
        </div>
        <div class="ctrl_input">
            <label class="ctrl_lavel_0" style="width:25%">Tel. Fijo/Movil</label>
            <input type="text" class="ctrl_input_t" style="width: 40%;" id="reg_usuario_fono" onkeypress="return soloNumeroTab(event);" onblur="fn_onblur(this);" maxlength="15">
        </div>
        <div class="ctrl_input">
            <label class="ctrl_lavel_0" style="width:25%">Casa</label>
            <select class="ctrl_input_t" id="reg_usuario_casa_id" onblur="fn_onblur(this);" style="width: 40%;">
                <option value="select">Seleccione Casa</option>
                <!--LLENADO AUTOMATICO-->
            </select>            
        </div>
        <div class="ctrl_input">
            <label class="ctrl_lavel_0" style="width:25%">Contraseña</label>
            <input type="password" class="ctrl_input_t" style="width: 40%;" id="reg_usuario_contra" onblur="fn_onblur(this);" >
        </div>
        <div class="ctrl_input">
            <label class="ctrl_lavel_0" style="width:25%">Confirmar Contraseña</label>
            <input type="password" class="ctrl_input_t" style="width: 40%;" id="reg_usuario_confi_contra" onblur="fn_onblur(this);">
        </div>
        <div class="ctrl_input">
            <label class="ctrl_lavel_0" style="width:25%">Estado</label>
            <select class="ctrl_input_t" id="reg_usuario_est" style="width: 40%;">
                <option value="1">HABILITADO</option>
                <option value="0">DESHABILITADO</option>                
            </select>            
        </div>        
     </div>
    <hr style="background-color: #418BC3; height: 1px; border: 0;">
    <button class="btn_full_act"  onClick="dialog_close('dialog_insert_new_user');"><img src="{{asset('images/salir.png')}}" style="width:20px;margin-right: 2px">Salir</img></button>
    <button class="btn_full_act"  onClick="btn_guardar_usuario();"><img src="{{asset('images/guardar.png')}}" style="width:20px;margin-right: 4px">Guardar Usuario</img></button>
</div>


<!-- DIALOG CASAS Y GRILLA-->
<div id="dialog_casa_grilla" title="LISTA DE CASAS DE PRESTAMO" style="display: none">
    <div class="filtros">
        <p class="spanasis">BUSCAR CASA</p><br/>        
        <div style="margin: -5px 0px -12px 20px">
            Buscar: <input type="text" id="txtbuscar_casa" style="text-transform:uppercase;padding: 3px 10px;width:50%; height: 23px; border-radius: 3px;border: 1px solid #C0CDF6;margin-bottom: 5px;"/>
            &nbsp;&nbsp;&nbsp;&nbsp;<button class="btn_full" id="btn_buscar_casa" onClick="btn_buscar_casa();" title="buscar casa">Buscar</button>            
        </div>
    </div>
    <div style="margin: 1.5% 1.5% 1%;">
        <table id="table_casas"></table>
        <div id="pager_table_casas"></div>
    </div>  
     <hr style="background-color: #418BC3; height: 1px; border: 0;">
    <button class="btn_full_act"  onClick="dialog_close('dialog_casa_grilla');"><img src="{{asset('images/salir.png')}}" style="width:20px;margin-right: 2px">Salir</img></button>
    <button class="btn_full_act"  onClick="insert_update_casa(0,0);"><img src="{{asset('images/usuario.png')}}" style="width:20px;margin-right: 4px">Nueva Casa</img></button>
    <button class="btn_full_act"  onClick="btn_actualizar_grilla('table_casas','casas');"><img src="{{asset('images/actualizar.png')}}" style="width:20px;margin-right: 4px">Actualizar Tabla</img></button>
</div>

<!-- DIALOG INSERT AND UPDATE CASAS     -->
<div id="dialog_insert_update_casa" title="" style="display: none">    
     <div class="filtros">
        <p class="spanasis">DATOS DE LA CASA / TIENDA</p><br/>        
        <div class="ctrl_input">               
            <input type="hidden" id="cas_id" value="0" >
            <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
            <label class="ctrl_lavel_0" style="width:25%">Descripcion</label>
            <input type="text" class="ctrl_input_t" style="width: 70%;" id="reg_casa_cas_des" onblur="fn_onblur(this);">
        </div>
        <div class="ctrl_input">
            <label class="ctrl_lavel_0" style="width:25%">Direccion</label>
            <input type="text" class="ctrl_input_t" style="width: 40%;" id="reg_casa_cas_dir" onblur="fn_onblur(this);">
        </div>
        <div class="ctrl_input">
            <label class="ctrl_lavel_0" style="width:25%">Telefono</label>
            <input type="text" class="ctrl_input_t" style="width: 40%;" id="reg_casa_cas_fono" onkeypress="return soloNumeroTab(event);" >
        </div>
              
     </div>
    <hr style="background-color: #418BC3; height: 1px; border: 0;">
    <button class="btn_full_act"  onClick="dialog_close('dialog_insert_update_casa');"><img src="{{asset('images/salir.png')}}" style="width:20px;margin-right: 2px">Salir</img></button>
    <button class="btn_full_act"  onClick="btn_guardar_casa();"><img src="{{asset('images/guardar.png')}}" style="width:20px;margin-right: 4px">Guardar Casa</img></button>
</div>


<!-- DIALOG SYSTEM    -->
<div id="dialog_system_data" title="CONFIGURACION DEL SISTEMA" style="display: none">    
     <div class="filtros">
        <p class="spanasis">INTERES / RANGO DE RECIBO</p><br/>        
        <div class="ctrl_input">
            <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
            <label class="ctrl_lavel_0" style="width:35%">Interes</label>
            <input type="text" class="ctrl_input_t" style="width: 20%;" id="dialog_system_data_interes" onblur="fn_onblur(this);" onkeypress="return soloDNI(event);" disabled>%
        </div>
        <div class="ctrl_input">
            <label class="ctrl_lavel_0" style="width:35%">Rango de Recibo</label>
            <input type="text" class="ctrl_input_t" style="width: 20%;" id="dialog_system_data_ini" onblur="fn_onblur(this);" onkeypress="return soloDNI(event);" disabled>        
            <label class="ctrl_lavel_0" style="width:5%;text-align: center">al</label>            
            <input type="text" class="ctrl_input_t" style="width: 20%;" id="dialog_system_data_fin" onkeypress="return soloDNI(event);" disabled>
        </div>
              
     </div>
    <hr style="background-color: #418BC3; height: 1px; border: 0;">
    <button class="btn_full_act"  onClick="dialog_close('dialog_system_data');"><img src="{{asset('images/salir.png')}}" style="width:20px;margin-right: 2px">Salir</img></button>
    <button class="btn_full_act"  onClick=""><img src="{{asset('images/guardar.png')}}" style="width:20px;margin-right: 4px">Guardar</img></button>
</div>