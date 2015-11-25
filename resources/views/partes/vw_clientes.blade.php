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

<!-- DIALOG GRID CLIENTES-->
<div id="dialog_load_tabla_clientes" title="LISTA DE CLIENTES" style="display: none;">
    <div class="filtros">
        <p class="spanasis">BUSCAR CLIENTE</p><br/>        
        <div style="margin: -5px 0px -12px 20px">
            Buscar: <input type="text" id="txtbuscar_cliente" style="text-transform:uppercase;padding: 3px 10px;width:50%; height: 23px; border-radius: 3px;border: 1px solid #C0CDF6;margin-bottom: 5px;"/>
            &nbsp;&nbsp;&nbsp;&nbsp;<button class="btn_full" id="btn_buscar_cliente" onClick="btn_buscar_cliente();" title="Enter">Buscar</button>            
        </div>
    </div>
    <div style="margin: 1.5% 1.5% 1%;">
        <table id="table_Clientes"></table>
        <div id="pager_table_Clientes"></div>
    </div> 
    <hr style="background-color: #418BC3; height: 1px; border: 0;">
    <button class="btn_full_act"  onClick="dialog_close('dialog_load_tabla_clientes');"><img src="{{asset('images/salir.png')}}" style="width:20px;margin-right: 2px">Salir</img></button>
    <button class="btn_full_act"  onClick="insert_update_Cliente(0,0);"><img src="{{asset('images/cliente.png')}}" style="width:20px;margin-right: 4px">Nuevo Cliente</img></button>
    <button class="btn_full_act"  onClick="dialog_nuevo_prestamo()"><img src="{{asset('images/prestamo2.png')}}" style="width:20px;margin-right: 4px">Nuevo Prestamo</img></button>
    <button class="btn_full_act"  onClick="btn_actualizar_grilla('table_Clientes','clientes');"><img src="{{asset('images/actualizar.png')}}" style="width:20px;margin-right: 4px">Actualizar Tabla</img></button>
</div>

<!-- REGISTER AND UPDATE USUARIOS-->
<div id="dialog_insert_update_nuevo_cliente" title="" style="display: none">    
     <div class="filtros">
        <p class="spanasis">DATOS DEL CLIENTE</p><br/>        
        <div class="ctrl_input">   
            <input type="hidden" id="cli_id" value="0" >           
            <label class="ctrl_lavel_0" style="width:20%">Apellidos</label>
            <input type="text" class="ctrl_input_t" style="width: 70%;" id="reg_cli_ape" onblur="fn_onblur(this);" value="">
        </div>
        <div class="ctrl_input">
            <label class="ctrl_lavel_0" style="width:20%">Nombres</label>
            <input type="text" class="ctrl_input_t" style="width: 70%" id="reg_cli_nom" onblur="fn_onblur(this);">
        </div>
        <div class="ctrl_input">
            <label class="ctrl_lavel_0" style="width:20%">Direccion</label>
            <input type="text" class="ctrl_input_t" style="width: 70%;" id="reg_cli_dir" onblur="fn_onblur(this);">
        </div>
        <div class="ctrl_input">
            <label class="ctrl_lavel_0" style="width:20%">DNI</label>
            <input type="text" class="ctrl_input_t" style="width: 70%;" id="reg_cli_dni" onkeypress="return soloDNI(event);" onblur="fn_onblur(this);"  maxlength="8">
        </div>
        <div class="ctrl_input">
            <label class="ctrl_lavel_0" style="width:20%">Celular</label>
            <input type="text" class="ctrl_input_t" style="width: 70%;" id="reg_cli_movil" onkeypress="return soloNumeroTab(event);" onblur="fn_onblur(this);">
        </div>
        <div class="ctrl_input">
            <label class="ctrl_lavel_0" style="width:20%">Tel. Fijo</label>
            <input type="text" class="ctrl_input_t" style="width: 70%;" id="reg_cli_fijo" onkeypress="return soloNumeroTab(event);">
        </div>
        <div class="ctrl_input">
            <label class="ctrl_lavel_0" style="width:20%">Casa</label>
            <select class="ctrl_input_t" id="reg_cli_cas_id" onblur="fn_onblur(this);" style="width: 50%;">
                <option value="select">Seleccione Casa</option>
                <!--LLENADO AUTOMATICO-->
            </select>            
        </div>        
        <div class="ctrl_input">
            <label class="ctrl_lavel_0" style="width:20%">Estado</label>
            <select class="ctrl_input_t" id="reg_cli_estado" style="width: 50%;">
                <option value="1">HABILITADO</option>
                <option value="0">DESHABILITADO</option>                
            </select>            
        </div>        
     </div>
    <hr style="background-color: #418BC3; height: 1px; border: 0;">
    <button class="btn_full_act"  onClick="dialog_close('dialog_insert_update_nuevo_cliente');"><img src="{{asset('images/salir.png')}}" style="width:20px;margin-right: 2px">Salir</img></button>
    <button class="btn_full_act"  onClick="btn_guardar_cliente();"><img src="{{asset('images/guardar.png')}}" style="width:20px;margin-right: 4px">Guardar Cliente</img></button>
</div>