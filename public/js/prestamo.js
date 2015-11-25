

function dialog_nuevo_prestamo(){
    limpiar_ctrl('dialog_nuevo_prestamo_gral');
    id = $("#nuevo_prestamo_cliente_id").val();
    if(!id){
        mensaje_sis('mensaje','* Seleccione un cliente para crear el prestamo....',':.MENSAJE...');
        return false;
    }
    $("#dialog_nuevo_prestamo_gral").dialog({
            autoOpen: false, modal: true, height: 510, width: 850, show: { effect: "fade", duration: 300 },
            close:function(){
                limpiar_all_prendas();
            }
    }).dialog('open');
    pintar_azul_todo(4);
    get_num(id);//trae el numero de prestamo del cliente 1/2/3/4 etc...    
}
cont=0;
total=0;
function btn_agregar_insertar(){
    if(cont>=7){  return false;}
    prenda=$("#new_prestamo_prenda").val();
    monto=$("#new_prestamo_monto").val();    
    if(prenda=="" || monto==""){
        if (prenda == "") { $("#new_prestamo_prenda").css({border: "1px solid #FF8080"});}
        if (monto == "") { $("#new_prestamo_monto").css({border: "1px solid #FF8080"});}
        mensaje_sis('mensaje','* Los Campos marcados con rojo son requeridos...',':.MENSAJE...'); 
        return false;
    }
    monto=parseFloat($("#new_prestamo_monto").val());
    cont++;
    var newdiv = document.createElement('div');
    newdiv.id='div_dina_'+(cont);
    newdiv.innerHTML=
    "<label class='lbl_din'>"+cont+"</label>\n\
    <input type='text' class='des_din' id='prenda_din_"+cont+"' value='"+prenda+"' disabled>\n\
    <input type='text' class='text_monto_din' id='monto_din_"+cont+"' value='"+monto.toFixed(2)+"'>\n\
    <button onclick='btn_borrar_prenda("+cont+","+monto.toFixed(2)+");' class='btn_din' id='btn_eliminar_din_"+cont+"' title='Eliminar'> <img src='http://"+document.domain+"/tienda/public/images/x.png' style='width:15px' ></img></button>";            
    document.getElementById('div_prendas_dinamico').appendChild(newdiv);
    total=(total + monto); 
    $("#div_prenda_monto_total").val(total.toFixed(2));
    
    for(i=1; i<=cont; i++){ 
        if (i==cont){                
            $("#btn_eliminar_din_"+i).show();
        }else{                
            $("#btn_eliminar_din_"+i).hide();
        }            
    }
    
    $("#new_prestamo_prenda").val('');
    $("#new_prestamo_monto").val('');
    $("#new_prestamo_prenda").focus();
}

function limpiar_all_prendas(){    
    for(i=1;i<=cont;i++){
        delete_div = document.getElementById('div_dina_'+i);
        if (!delete_div){
            alert("El elemento selecionado no existe");
        } else {
            padre = delete_div.parentNode;
            padre.removeChild(delete_div);
        }
    }
    cont=0;total=0;  
    $("#div_prenda_monto_total").val('0.00');
}
function btn_borrar_prenda(num,monto){///borrar los tratamientos 
    var d = document.getElementById("div_prendas_dinamico");
    var d_borrar = document.getElementById("div_dina_"+num);
    var throwawayNode = d.removeChild(d_borrar);
    cont--;            

    total=(total - monto); 
    $("#div_prenda_monto_total").val(total.toFixed(2));

    $("#btn_eliminar_din_"+cont).show();
}

moneda="";
function dialog_resumen_prestamo(){
    prenda_div = document.getElementById('div_dina_1');
    if(!prenda_div){
        return false;
    }
    limpiar_ctrl('dialog_dias_prestamo');
    $("#dialog_dias_prestamo").dialog({
            autoOpen: false, modal: true, height: 500, width: 500, show: { effect: "fade", duration: 300 }
    }).dialog('open');
    $("#dialog_dias_prestamo_fecha").mask("99/99/9999");
//    datepiker('dialog_dias_prestamo_fecha','-10D','+4M +10D');
    get_fecha_actual('dialog_dias_prestamo_fecha');
    $("#d_p_num").val($("#lbl_num_prestamo").val());
    $("#d_p_num_prendas").val(cont);
    $("#d_p_monto").val($("#div_prenda_monto_total").val());
    moneda=$("#div_prenda_moneda").val();
    if(moneda=='sol'){
        money='SOLES';
    }else{money='DOLARES'}
    $("#d_p_moneda").val(money);
    
    
    $("#d_p_interes").val(global_interes);
}

function calcular_dias_interes(){
    dias=$("#dialog_dias_prestamo_dias").val();
    fch=$("#dialog_dias_prestamo_fecha").val();
    var fecha = sumaFecha(dias,fch);
    $("#dialog_dias_prestamo_fecha_fin").val(fecha);
    
    monto_tot = parseFloat($("#d_p_monto").val());
    interes   = parseFloat($("#d_p_interes").val());
    
    interes_pagar = ((interes/100)*monto_tot)*dias;
    $("#dialog_dias_prestamo_int_gen").val(interes_pagar.toFixed(2));
}

pre_num=0;
function btn_insert_prestamo(){
    div_dinamico = document.getElementById('div_dina_1');
    if (!div_dinamico){         
        mensaje_sis('mensaje',' NO HAY PRENDAS PARA GUARDAR','MENSAJE DEL SISTEMA');
        return false;
    }
    
    user_id=global_user_id;
    cli_id=$("#nuevo_prestamo_cliente_id").val();
    pre_numm=pre_num;
    pre_num_prendas=$("#d_p_num_prendas").val();
    
    pre_monto       = parseFloat($("#d_p_monto").val());
    pre_moneda      = moneda;
    pre_interes     = global_interes;
    pre_dias        = parseInt($("#dialog_dias_prestamo_dias").val()); 
    very_dias=$("#dialog_dias_prestamo_dias").val();
    if(very_dias==""){
        mensaje_sis('mensaje','* El Campo dias en requerido...',':.MENSAJE...');
        return false;
    }
    pre_int_gen     = parseFloat($("#dialog_dias_prestamo_int_gen").val());
    pre_fch         = $("#dialog_dias_prestamo_fecha").val();
    pre_fch_fin     = $("#dialog_dias_prestamo_fecha_fin").val();
    
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        type: 'POST',
        url: 'pmo_prestar_save',
        data: {
            user_id:user_id,
            cli_id:cli_id,
            pre_num:pre_numm,
            pre_num_prendas:pre_num_prendas,
            pre_monto:pre_monto,
            pre_moneda:pre_moneda,
            pre_interes:pre_interes,
            pre_dias:pre_dias,
            pre_int_gen:pre_int_gen,
            pre_fch:pre_fch,
            pre_fch_fin:pre_fch_fin,
            _token:global_token},
        success: function (data) {
            if(data.msg=='si'){
                for(i=1;i<=cont;i++){
                    btn_guardar_prenda(i,data.pmo_id);
                }
                mensaje_sis('mensaje','* El prestamo a sido guardado...',':.MENSAJE...');
                dialog_close('dialog_dias_prestamo');
                dialog_close('dialog_nuevo_prestamo_gral');                
            }
        },error: function(data){
            
        }
    });
    
}

function btn_guardar_prenda(num,pmo_id){
    
    pda_des=$.trim($("#prenda_din_"+num).val());
    pda_monto=$.trim($("#monto_din_"+num).val());
    
    if(pda_des != "" && pda_monto != "" ){
        $.ajax({                   
            url: 'save_prenda',
            type: 'POST',
            data: {pmo_id:pmo_id,pda_des:pda_des,pda_monto:pda_monto,_token:global_token},
            success: function(data){
            },
            error: function (data) {
                mensaje_sis('mensaje',' ERROR. Contactese con el administrador..','MENSAJE DEL SISTEMA');
            }
        });
    }
}

function est_prestamo_cliente(cli_id){
    
//    $("#reg_usuario_ape_nom").val($.trim($("#table_Clientes").getCell(id, "name")));
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        type: 'POST',
        url: 'isset_est_prestamo',
        data: {cli_id:cli_id,num:1,_token:global_token},
        success: function (data){
            if(data.msg=='si'){
                $("#dialog_tabla_est_prestamo").dialog({
                    autoOpen: false, modal: true, height: 500, width: 700, show: { effect: "fade", duration: 300 }
                }).dialog('open');
                table_est_prestamo();
            }else{
                mensaje_sis('mensaje','* Este Clinte no tiene ningun prestamo...',':.ERROR...!!');
            }
        },error: function(data){
            alert('Contactese con el administrador..');
        }
    });
    
}

function table_est_prestamo(){
    jQuery("#table_est_prestamo").jqGrid({ 
        url: 'est_prestamo',
        datatype: 'json', mtype: 'GET',        
        width: '100%', height: '150',
        colNames:['id','N','pmo_id','TIPO','%', 'MONTO','FECHA','DIAS','PAGO','total'], 
        rowNum: 11, sortname: 'est_pre_id', sortorder: 'desc', viewrecords: true, caption: 'ESTADO DE PRESTAMO',  align: "center",
        colModel:[ 
            {name:'est_pre_id',index:'est_pre_id', hidden:true}, 
            {name:'num',index:'est_pre_id', width:45,align:'center'}, 
            {name:'pmo_id',index:'num', hidden:true},
            {name:'est_pre_tipo',index:'est_pre_tipo', width:110, align:'center'},
            {name:'est_pre_interes',index:'est_pre_interes', width:45, align:'center'},
            {name:'est_pre_monto',index:'est_pre_monto', width:100, align:'center'},
            {name:'fecha',index:'fecha', width:90, align:'center'},
            {name:'est_pre_dias',index:'est_pre_dias',width:65, align:'center'},
            {name:'est_pre_int_gen',index:'est_pre_int_gen',width:100, align:'center'}, 
            {name:'total',index:'total', width:100, align:'center'}  
        ],        
        pager: '#pager_table_est_prestamo',
        rowList: [5, 10],
        gridComplete: function(){           
            var rows = $("#table_est_prestamo").getDataIDs();
            
            var total=0;
            var pagado=0;
            var deuda=0;
            for (var i = 0; i < rows.length; i++){
                tipo = $("#table_est_prestamo").getCell(rows[i], "est_pre_tipo");
                pa_total=parseFloat($("#table_est_prestamo").getCell(rows[i], "total"));
                if(tipo=="PRESTAMO"){
                    total = total + pa_total;
                }else if(tipo=="AMORTIZACION"){
                    pagado = pagado + parseFloat($("#table_est_prestamo").getCell(rows[i], "est_pre_monto"));
                }
                  
            }
            deuda = total - pagado;
            $("#div_est_pre_ttotal").val(total.toFixed(2));
            $("#div_est_pre_pagado").val(pagado.toFixed(2));
            $("#div_est_pre_deuda").val(deuda.toFixed(2));
        }
    }); 
}


function get_num(id){     
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        type: 'POST',
        url: 'get_num_prestamo',
        data: {cli_id:id,_token:global_token},
        success: function (data) {
            $("#lbl_num_prestamo").val('PRESTAMO ' + data.num);
            pre_num=data.num;
        },error: function(data){
            $("#lbl_num_prestamo").val('PRESTAMO 1'); 
            pre_num=1;
        }
    });   
 }
 
 function amortizar_pres() {
    
    $("#dialog_amortizar").dialog({
            autoOpen: false, modal: true, height: 250, width: 400, show: { effect: "fade", duration: 300 }
    }).dialog('open');
    $("#dialog_fecha_amor").mask("99/99/9999");
    get_fecha_actual('dialog_fecha_amor');
 }

function prestar_pres(){
    $("#dialog_prestar").dialog({
            autoOpen: false, modal: true, height: 300, width: 500, show: { effect: "fade", duration: 300 }
    }).dialog('open');
    $("#dialog_fecha_pres").mask("99/99/9999");
}
