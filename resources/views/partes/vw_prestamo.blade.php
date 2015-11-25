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
    .btn_full_act:focus{
        border: 1px solid #0C6CC8;
    }
    
    .ctrl_input_text_cabesera {
        background: #fafef9 none repeat scroll 0 0;
        border: 1px solid #99bce8;
        border-radius: 0;
        color: #2a2a2a;
        font-size: 12px;
        height: 25px;
        padding: 4px 5px 3px;
        text-transform: uppercase;
        vertical-align: middle;
    }
    .ctrl_input_text_cabesera:disabled {
        background: #f0f0f0;
        border: 1px solid #CCCCCC;
        border-radius: 0;
        color: #2a2a2a;
        font-size: 12px;
        height: 25px;
        padding: 4px 5px 3px;
        text-transform: uppercase;
        vertical-align: middle;
    }
    
    .ctrl_input_cabesera{
        margin: -4px;
        text-align: left;
    }
    .ctrl_input_resumen{
        margin-top: 4px;
        text-align: left;
    }
    
    .ctrl_input_text_disabled{
        background: #F0F0F0;
        border: 0 none;
        font-size: 16px;
        margin-left: 3em;
        text-align: center;
        width: 20%;
        text-transform: uppercase;
        font-weight: bold;
    }
    .ctrl_lavel_0{
        width: 12%;
        text-align: right;
    }
    .lbl_din{
        margin-left: 0.6%; width: 1.2%; text-align: right;        
    }
    .des_din{
        margin-top: 0%;margin-left: 1%;width:64%;height: 21px;font-size: 12px;text-transform: uppercase;
    }
    .control_total_suma{
        text-align: right;color: white; font-size: 12px; float: left; 
        border: 0px none; width: 10%;background: #6FADD9; border-top: 1px solid blue;        
    }
    .footer_prenda{
        background: #ccdef4 none repeat scroll 0 0;
        border-top: 1px solid #99bce8;
        height: 35px;
        margin: 10px 0 -20px;
        padding: 3px 0 0;
    }
    .btn_din{
        background-color:#DFE8F6;                                  
        color:#0C509D;       
        font-weight:bold;
        padding:1px 5px;
        margin-left: 0;
        border: 1px solid #99BCE8;  
    }
    .btn_din:hover{
        color: white;
        background-color: #418BC3;
    }
    .btn_din:active{ 
        color: #418BC3;
        background-color: #FFFFFF;
    }
    .text_monto_din{
        width:10%;height: 21px;font-size: 12px;text-align:right;
        background: #F0F0F0; border: 1px solid #CCCCCC;
    }
    .conta_deudas_pagos{
        background-color: rgb(224, 242, 255); border: 1px solid rgb(131, 203, 255); width: 52%; height: 20px; text-align: right; font-size: 13px; color: rgb(55, 118, 166);
    }
</style>

<!-- DIALOG NUEVO PRESTAMO GENERAL-->
<div id="dialog_nuevo_prestamo_gral" title="NUEVO PRESTAMO" style="display: none;">
    <div class="filtros">
        <p class="spanasis">CLIENTE</p><br/>        
        <div class="ctrl_input_cabesera">   
            <input type="hidden" id="nuevo_prestamo_cliente_id" value="" >           
            <label class="ctrl_lavel_0" style="width:20%">Apellidos y Nombres:</label>
            <input type="text" class="ctrl_input_text_cabesera" style="width: 45%;" id="nuevo_prestamo_cliente_ape_nom" disabled="disabled">
            <input type="text" id="lbl_num_prestamo" class="ctrl_input_text_disabled"  style="width:20%; font-size: 16px; border: 0px;" value="" disabled="">
        </div>
    </div>
    <div class="filtros">
        <p class="spanasis">PRENDAS</p><br/>  
        <div style=" width: 100%;height: 20px;font-size: 12px;margin: -19px 0 10px;background: #ccdef4">
            <div style="float: left;width: 1.5%;margin-left: 7px;"><b>N°</b></div>
            <div style="float: left;width: 64%;margin-left: 12px;"><b>Descripcion de la Prenda</b></div>
            <div style="float: left;width: 15%;margin-left: 18px;"><b>Monto</b></div>
            <div style="float: left;margin-left: 10px;"><b>Otros</b></div>
        </div>
        <div id="div_prendas_dinamico" style="height: 162px">
            <!--div de la consulta por defecto-->

        </div>
        <div style=" width: 100%;height: 20px;font-size: 12px;margin: 5px 5px 5px 0;">
            <div style="float: left;width: 67%;margin-left: 7px;text-align: right; padding-right: 7px;">Total</div>                
            <input type="text" class="control_total_suma" value="0.00" id="div_prenda_monto_total" title="click para calcular" disabled=""/> 
            <label style="margin-left: 7px;">Moneda</label>
            <select style="margin-left: 5px;" id="div_prenda_moneda">
                <option value="sol">Soles</option>
                <option value="dol">Dolares</option>
            </select>
        </div>
        <div class="footer_prenda">
            <label style="width:6%; margin-left: 6px;">Prenda</label>
            <input type="text" id="new_prestamo_prenda" class="ctrl_input_text_cabesera" style="width: 55%;background-color: #EFFAEE" onblur="fn_onblur(this);" placeholder="descripcion de la prenda" >
            <label style="width:5%">Monto</label>
            <input type="text" id="new_prestamo_monto" class="ctrl_input_text_cabesera" style="width: 10%;background-color: #EFFAEE; text-align: right;" onblur="fn_onblur(this);" placeholder="0.00" onkeypress="return soloNumeroTab(event);">
            &nbsp;&nbsp;<button class="btn_full" id="btn_agregar_insertar" onClick="btn_agregar_insertar();">Agregar/Insertar</button>
        </div>
    </div>
     
    <hr style="background-color: #418BC3; height: 1px; border: 0;">
    <button class="btn_full_act"  onClick="dialog_close('dialog_nuevo_prestamo_gral');"><img src="{{asset('images/salir.png')}}" style="width:20px;margin-right: 2px">Salir</img></button>
    <button class="btn_full_act"  onClick="dialog_resumen_prestamo();"><img src="{{asset('images/guardar.png')}}" style="width:20px;margin-right: 4px">Guardar Prestamo</img></button>
    <button class="btn_full_act"  onClick="limpiar_all_prendas();"><img src="{{asset('images/limpiar.png')}}" style="width:20px;margin-right: 4px">Limpiar Todo</img></button>
</div>

<!-- DIALOG GUARDAR PRESTAMO-->
<div id="dialog_dias_prestamo" title="GUARDAR PRESTAMO" style="display: none;">
    <div class="filtros">
        <p class="spanasis">RESUMEN DEL PRESTAMO</p><br/>
        <div class="ctrl_input_resumen">
            <label class="ctrl_lavel_0" style="width:35%">N°</label>
            <input type="text" class="ctrl_input_text_cabesera" style="width: 50%" id="d_p_num" disabled="">
        </div>
        <div class="ctrl_input_resumen">
            <label class="ctrl_lavel_0" style="width:35%">N°. Prendas</label>
            <input type="text" class="ctrl_input_text_cabesera" style="width: 20%;" id="d_p_num_prendas" disabled="">
        </div>
        <div class="ctrl_input_resumen">
            <label class="ctrl_lavel_0" style="width:35%">Monto Total</label>
            <input type="text" class="ctrl_input_text_cabesera" style="width: 20%;" id="d_p_monto" disabled="">
            <input type="text" class="ctrl_input_text_cabesera" id="d_p_moneda" style="width:20%; font-size: 14px; border: 0px;background: #CCCCCC" value="" disabled="">
        </div>
        <div class="ctrl_input_resumen">
            <label class="ctrl_lavel_0" style="width:35%">Interes</label>
            <input type="text" class="ctrl_input_text_cabesera" style="width: 20%;" id="d_p_interes" disabled="">%
        </div>
    </div>
    <div class="filtros">
        <p class="spanasis">DIAS Y FECHA</p><br/>
        <div class="ctrl_input_resumen">
            <label class="ctrl_lavel_0" style="width:35%">Dias</label>
            <input type="text" class="ctrl_input_t" style="width: 50%" id="dialog_dias_prestamo_dias" maxlength="3" onkeypress="return soloNumeroTab(event);" onblur="calcular_dias_interes();">
        </div>
        <div class="ctrl_input_resumen">
            <label class="ctrl_lavel_0" style="width:35%">Fecha de Prestamo</label>
            <input type="text" class="ctrl_input_t" style="width: 50%;" id="dialog_dias_prestamo_fecha" maxlength="10" onblur="calcular_dias_interes();">
        </div>
        <div class="ctrl_input_resumen">
            <label class="ctrl_lavel_0" style="width:35%">Fecha de Pago</label>
            <input type="text" class="ctrl_input_t" style="width: 50%;" id="dialog_dias_prestamo_fecha_fin" maxlength="10">
        </div>
        <div class="ctrl_input_resumen">
            <label class="ctrl_lavel_0" style="width:35%">Interes a Pagar</label>
            <input type="text" class="ctrl_input_text_cabesera" style="width:50%; font-size: 14px; border: 0px;background: #CCCCCC" id="dialog_dias_prestamo_int_gen" readonly="">
        </div>
    </div>
    <hr style="background-color: #418BC3; height: 1px; border: 0;">
    <button class="btn_full_act"  onClick="dialog_close('dialog_dias_prestamo');"><img src="{{asset('images/salir.png')}}" style="width:20px;margin-right: 2px">Salir</img></button>
    <button class="btn_full_act"  onClick="btn_insert_prestamo();"><img src="{{asset('images/guardar.png')}}" style="width:20px;margin-right: 4px">Aceptar y Guardar Prestamo</img></button>
</div>

<!-- DIALOG ESTADO DE PRESTAMO RESUMEN PAGO TOTAL/PAGADO/DEUDA-->
<div id="dialog_tabla_est_prestamo" title="ESTADO DE PRESTAMO" style="display: none;">
    <div class="filtros">
        <p class="spanasis">CLIENTE</p><br/>        
        <div class="ctrl_input_cabesera">   
            <input type="hidden" id="est_prestamo_cli_id" value="" >           
            <label class="ctrl_lavel_0" style="width:25%">Apellidos y Nombres:</label>
            <input type="text" class="ctrl_input_text_cabesera" style="width: 45%;" id="est_prestamo_ape_nom" disabled="disabled">
            <input type="text" id="est_prestamo_combo_num" class="ctrl_input_text_disabled"  style="width:20%; font-size: 16px; border: 0px;" value="" disabled="">
        </div>
        <div class="ctrl_input" style="margin: 2% 0 -1.5% 0; padding: 0 3%;">
            <div style="float: left; background: #6FADD9; color: white; text-align: center; width: 20%;height: 21px;">Soles</div>
            <div>                
                &nbsp;&nbsp;&nbsp;&nbsp;<b>Pago Total</b>&nbsp;&nbsp;<input type="text" class="conta_deudas_pagos" style="width: 12%;" id="div_est_pre_ttotal" disabled/>
                &nbsp;&nbsp;&nbsp;&nbsp;<b>Pagado</b>&nbsp;&nbsp;<input type="text" class="conta_deudas_pagos" style="width: 12%;" id="div_est_pre_pagado"  disabled/>
                &nbsp;&nbsp;&nbsp;&nbsp;<b>Deuda</b>&nbsp;&nbsp;<input type="text" class="conta_deudas_pagos" style="width: 12%;" id="div_est_pre_deuda"  disabled/>
            </div>            
        </div>
    </div>
    <div style="margin: 1.5% 1.5% 1%;">
        <table id="table_est_prestamo"></table>
        <div id="pager_table_est_prestamo"></div>
    </div> 
    <div style="margin: 2.5% -1% 0 0; height: 15px;">
        <button class="btn_full_act"  onClick=""><img src="{{asset('images/salir.png')}}" style="width:20px;margin-right: 2px">Ver Prendas Asociadas a este Prestamo</img></button>
    </div>
    <hr style="background-color: #418BC3; height: 1px; border: 0;">
    <button class="btn_full_act"  onClick="dialog_close('dialog_tabla_est_prestamo');"><img src="{{asset('images/salir.png')}}" style="width:20px;margin-right: 2px">Salir</img></button>
    <button class="btn_full_act"  onClick="amortizar_pres();"><img src="{{asset('images/cliente.png')}}" style="width:20px;margin-right: 4px">Amortizar</img></button>
    <button class="btn_full_act"  onClick="prestar_pres();"><img src="{{asset('images/prestamo2.png')}}" style="width:20px;margin-right: 4px">Prestar</img></button>
    <button class="btn_full_act"  onClick=""><img src="{{asset('images/actualizar.png')}}" style="width:20px;margin-right: 4px">Actualizar</img></button>
</div>

<!-- DIALOG AMORTIZAR-->
<div id="dialog_amortizar" title="AMORTIZAR" style="display: none;">
    <div class="filtros">
        <p class="spanasis">MONTO Y FECHA</p><br/> 
        <div class="ctrl_input_resumen">
            <label class="ctrl_lavel_0" style="width:25%">Monto</label>
            <input type="text" class="ctrl_input_t" style="width: 50%" id="dialog_monto_amor" onkeypress="return soloNumeroTab(event);" onblur="fn_onblur(this);">
        </div>
        <div class="ctrl_input_resumen">
            <label class="ctrl_lavel_0" style="width:25%">Fecha</label>
            <input type="text" class="ctrl_input_t" style="width: 50%;" id="dialog_fecha_amor" onblur="fn_onblur(this);">
        </div>    
    </div>
    <hr style="background-color: #418BC3; height: 1px; border: 0;">
    <button class="btn_full_act"  onClick="dialog_close('dialog_amortizar');"><img src="{{asset('images/salir.png')}}" style="width:20px;margin-right: 2px">Salir</img></button>
    <button class="btn_full_act"  onClick=""><img src="{{asset('images/guardar.png')}}" style="width:20px;margin-right: 4px">Aceptar y Guardar Prestamo</img></button>
</div>