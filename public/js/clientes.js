function open_dialog_tabla_cLiente(){
    limpiar_ctrl('dialog_load_tabla_clientes');
    $("#dialog_load_tabla_clientes").dialog({
            autoOpen: false, modal: true, height: 550, width: 950, show: { effect: "fade", duration: 300 }
    }).dialog('open');

//    $("#table_Clientes").jqGrid("clearGridData", true).trigger("reloadGrid");
    jQuery("#table_Clientes").jqGrid({ 
        url: 'clientes',
        datatype: 'json', mtype: 'GET',        
        width: '100%', height: '254',
        colNames:['id',' APELLIDOS','NOMBRES', 'DIRECCION','DNI','CELULAR','TEL. FIJO','estado','cas_id','TIENDA','Editar','Pmo'], 
        rowNum: 11, sortname: 'cli_id', sortorder: 'desc', viewrecords: true, caption: 'LISTADO DE CLIENTES REGISTRADOS',  align: "center",
        colModel:[ 
            {name:'cli_id',index:'cli_id', hidden:true}, 
            {name:'cli_ape',index:'cli_ape', width:165, align:'left'}, 
            {name:'cli_nom',index:'cli_nom', width:165},
            {name:'cli_dir',index:'cli_dir', width:150, align:'left'},
            {name:'cli_dni',index:'cli_dni', width:70, align:'center'},
            {name:'cli_movil',index:'cli_movil', width:75, align:'center'},
            {name:'cli_fijo',index:'cli_fijo', width:80, align:'center'},
            {name:'cli_estado',index:'cli_estado', hidden:true},
            {name:'cas_id',index:'cas_id', hidden:true},
            {name:'cas_des',index:'cas_des', width:85, align:'left'},            
            {name:'editar',index:'editar', width:50, align:'center'},
            {name:'prestamo',index:'prestamo', width:55, align:'center'}
        ],        
        pager: '#pager_table_Clientes',
        rowList: [11, 22],
        onSelectRow: function(Id){
            ape_nom=$("#table_Clientes").getCell(Id,"cli_ape")+' '+$("#table_Clientes").getCell(Id,"cli_nom");
            $("#nuevo_prestamo_cliente_id").val($("#table_Clientes").getCell(Id,"cli_id"));  
            $("#nuevo_prestamo_cliente_ape_nom").val(ape_nom);
            $("#est_prestamo_ape_nom").val(ape_nom);
            $("#est_prestamo_cli_id").val($("#table_Clientes").getCell(Id,"cli_id"));
        }
//        ondblClickRow: function(Id){            
//            ape_nom=$("#table_Clientes").getCell(Id,"cli_ape")+' '+$("#table_Clientes").getCell(Id,"cli_nom");
//            $("#est_prestamo_ape_nom").val(ape_nom);
//            alert(ape_nom);
//        }
    }); 
}

function insert_update_Cliente(id,tip){
    limpiar_ctrl('dialog_insert_update_nuevo_cliente');
    if(tip==0){tit='NUEVO CLIENTE';}
    else{
        tit='MODIFICAR CLIENTE';
        $("#cli_id").val(id);
        $("#reg_cli_ape").val($.trim($("#table_Clientes").getCell(id, "cli_ape")));
        $("#reg_cli_nom").val($.trim($("#table_Clientes").getCell(id, "cli_nom")));
        $("#reg_cli_dir").val($.trim($("#table_Clientes").getCell(id, "cli_dir")));
        $("#reg_cli_dni").val($.trim($("#table_Clientes").getCell(id, "cli_dni")));
        $("#reg_cli_movil").val($.trim($("#table_Clientes").getCell(id, "cli_movil")));
        $("#reg_cli_fijo").val($.trim($("#table_Clientes").getCell(id, "cli_fijo")));
        $("#reg_cli_cas_id").val($.trim($("#table_Clientes").getCell(id, "cas_id")));
        $("#reg_cli_estado").val($.trim($("#table_Clientes").getCell(id, "cli_estado")));
    }
    $("#dialog_insert_update_nuevo_cliente").dialog({
        autoOpen: false, modal: true,title: tit+(' | '+global_rol+': '+global_usuario), height: 470, width: 620, show: { effect: "fade", duration: 300 },
        close: function() {
            $("#cli_id").val(0);
        }
    }).dialog('open');
    pintar_azul_todo(3);
}
 function btn_guardar_cliente(){

    cli_id      = $("#cli_id").val();
    cli_ape     = $("#reg_cli_ape").val();
    cli_nom     = $("#reg_cli_nom").val();
    cli_dir     = $("#reg_cli_dir").val();
    cli_dni     = $("#reg_cli_dni").val();
    cli_movil   = $("#reg_cli_movil").val();
    cli_fijo    = $("#reg_cli_fijo").val();
    cas_id      = $("#reg_cli_cas_id").val();
    cli_estado  = $("#reg_cli_estado").val();
    
//    alert(cli_id+'/'+cli_ape+'/'+cli_nom+'/'+cli_dir+'/'+cli_dni+'/'+cli_movil+'/'+cli_fijo+'/'+cas_id+'/'+cli_estado);
    if (cli_ape != "" && cli_nom != "" && cli_dir != "" && cli_movil != "" && cas_id != "select") {
        if(cli_dni.length!=8){mensaje_sis('mensaje','* DNI es incorrecto...',':.ERROR...!!'); return false;}
        if(cli_id==0){  //insertar 
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: 'cliente_save',
                data: {cas_id:cas_id,user_id:global_user_id,cli_ape:cli_ape, cli_nom:cli_nom,cli_dir:cli_dir,cli_dni:cli_dni,cli_movil:cli_movil,cli_fijo:cli_fijo,cli_estado:cli_estado,_token:global_token},
                success: function (data) {
                    if(data.msg=='si'){
                        $("#table_Clientes").trigger("reloadGrid");
                        dialog_close('dialog_insert_update_nuevo_cliente');
                        mensaje_sis('mensaje','* Cliente "'+data.cliente+'" a sido registrado...',':.MENSAJE DE CONFIRMACION...');
                    }else{
                        mensaje_sis('mensaje','* El Nro. DNI: "'+data.dni+'" ya existe...',':.ERROR...!!');
                    }
                },error: function(data){
                    alert('Contactese con el administrador..');
                }
            });
        }else{
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: 'cliente_save',
                data: {cli_id:cli_id,cas_id:cas_id,user_id:global_user_id,cli_ape:cli_ape, cli_nom:cli_nom,cli_dir:cli_dir,cli_dni:cli_dni,cli_movil:cli_movil,cli_fijo:cli_fijo,cli_estado:cli_estado,_token:global_token},
                success: function (data) {
                    if(data.msg=='si'){
                        $("#table_Clientes").trigger("reloadGrid");
                        dialog_close('dialog_insert_update_nuevo_cliente');
                        mensaje_sis('mensaje','* Cliente "'+data.cliente+'" a sido modificado...',':.MENSAJE DE CONFIRMACION...');
                    }else{
                        mensaje_sis('mensaje','* El Nro. DNI: "'+data.dni+'" ya existe...',':.ERROR...!!');
                    }
                },error: function(data){
                    mensaje_sis('mensaje','* El Nro. DNI: "'+cli_dni+'" ya existe...',':.ERROR...!!');
                }
            });
        }               
        return true;

    } else {
        if (cli_ape     == "")       { $("#reg_cli_ape").css({border: "1px solid #FF8080"}); }
        if (cli_nom     == "")       { $("#reg_cli_nom").css({border: "1px solid #FF8080"}); }
        if (cli_dir     == "")       { $("#reg_cli_dir").css({border: "1px solid #FF8080"}); }
        if (cas_id      == "select") { $("#reg_cli_cas_id").css({border: "1px solid #FF8080"}); }
        if (cli_dni     == "")       { $("#reg_cli_dni").css({border: "1px solid #FF8080"}); }
        if (cli_movil   == "")       { $("#reg_cli_movil").css({border: "1px solid #FF8080"}); }
        
        mensaje_sis('mensaje','* Los campos marcados de rojo son requeridos.','INFORMACION');
        return false;
//        shorcut_enter=1;
    }
 }
 
 function btn_buscar_cliente() {    
    txt = ($("#txtbuscar_cliente").val()).toUpperCase();    
    if(txt==""){
        btn_actualizar_grilla('table_Clientes','clientes');
    }else{
        jQuery("#table_Clientes").jqGrid('setGridParam', {
            url: "cliente_buscar/"+ txt
        }).trigger('reloadGrid');
    }   
}

