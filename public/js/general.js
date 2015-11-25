
function btn_guardar_usuario() {    
    user_id     = $("#user_id").val();
    ape_nom     = $("#reg_usuario_ape_nom").val();
    usuario     = $("#reg_usuario_usuario").val();
    fono        = $("#reg_usuario_fono").val();
    casa        = $("#reg_usuario_casa_id").val();
    contra      = $("#reg_usuario_contra").val();
    conf_contra = $("#reg_usuario_confi_contra").val();
    estado      = $("#reg_usuario_est").val();
    _token      = $("#_token").val();
    
    if (ape_nom != "" && usuario != "" && fono != "" && casa != "select" && contra != "" && conf_contra != "") {
        if(contra!=conf_contra){ mensaje_sis('mensaje','* Las contraseñas no coinciden.','INFORMACION'); return false; }
        if(user_id==0){  //insertar 
//                
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: 'user_save',
                data: {ape_nom:ape_nom, usuario:usuario,fono:fono,casa:casa,contra:contra,estado:estado,_token:_token},
                success: function (data) {
                    if(data.msg=='si'){
                        btn_actualizar_grilla('table_user');
                        dialog_close('dialog_insert_new_user');
                        mensaje_sis('mensaje','* El Usuario "'+data.usuario+'" a sido creado...',':.MENSAJE DE CONFIRMACION...');
                    }else{
                        mensaje_sis('mensaje','* El Usuario "'+data.usuario+'" ya existe...',':.ERROR...!!');
                    }
                },error: function(data){
                    alert('Contactese con el administrador..');
                }
            });
        }else{
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: 'user_save',
                data: {user_id:user_id, ape_nom:ape_nom, usuario:usuario,fono:fono,casa:casa,contra:contra,estado:estado,_token:_token},
                success: function (data) {
                    if(data.msg=='si'){
                        btn_actualizar_grilla('table_user');
                        dialog_close('dialog_insert_new_user');
                        mensaje_sis('mensaje','* El Usuario "'+data.usuario+'" a sido modificado...',':.MENSAJE DE CONFIRMACION...');
                    }else{
                        mensaje_sis('mensaje','* El Usuario "'+data.usuario+'" ya existe...',':.ERROR...!!');
                    }
                },error: function(data){
                    mensaje_sis('mensaje','* El Usuario "'+usuario+'" ya existe...',':.ERROR...!!');
                }
            });
        }               
        return true;

    } else {
        if (ape_nom == "")  { $("#reg_usuario_ape_nom").css({border: "1px solid #FF8080"}); }
        if (usuario == "")  { $("#reg_usuario_usuario").css({border: "1px solid #FF8080"}); }
        if (fono == "")     { $("#reg_usuario_fono").css({border: "1px solid #FF8080"}); }
        if (casa == "select") { $("#reg_usuario_casa_id").css({border: "1px solid #FF8080"}); }
        if (contra == "")   { $("#reg_usuario_contra").css({border: "1px solid #FF8080"}); }
        if (conf_contra == "") { $("#reg_usuario_confi_contra").css({border: "1px solid #FF8080"}); }
        
        mensaje_sis('mensaje','* Los campos marcados de rojo son requeridos.','INFORMACION');
        return false;
//        shorcut_enter=1;
    }
}

function open_dialog_administracion(user){
    if(user=='ADMINISTRADOR'){        
        $("#div_adm_all").dialog({
                autoOpen: false, modal: true, height: 270, width: 750, show: { effect: "fade", duration: 300 }
        }).dialog('open');       
    }else{
        mensaje_sis('mensaje','* Usted no tiene permisos para Administrar...','USUARIO SIN PERMISOS');
    }
}

function btn_buscar_user() {    
    txt = ($("#txtbuscar_user").val()).toUpperCase();    
    if(txt==""){
        btn_actualizar_grilla('table_user','users');
    }else{
        jQuery("#table_user").jqGrid('setGridParam', {
            url: "user_buscar/"+ txt
        }).trigger('reloadGrid');
    }   
}

function open_dialog_load_all_user(){
    
    dialog_close('div_adm_all');    
    $("#dialog_load_all_user").dialog({
            autoOpen: false, modal: true, height: 540, width: 780, show: { effect: "fade", duration: 300 },
//            close: function(){ btn_actualizar_grilla('table_user'); }
    }).dialog('open');
    limpiar_ctrl('dialog_load_all_user');
    
//    $("#table_user").jqGrid("clearGridData", true).trigger("reloadGrid");
    jQuery("#table_user").jqGrid({ 
        url: 'users',
        datatype: 'json', mtype: 'GET',        
        width: '100%', height: '253',
        colNames:['ID','NOMBRES Y APELLIDOS', 'USUARIO','TIENDA','TELEFONO','cas_id','estado','Editar','Elimin'], 
        rowNum: 11, sortname: 'id', sortorder: 'desc', viewrecords: true, caption: 'LISTADO DE USUARIOS REGISTRADOS',  align: "center",
        colModel:[ 
            {name:'id',index:'id', hidden:true}, 
            {name:'name',index:'name', width:270, align:'left'}, 
            {name:'user',index:'user', width:150},
            {name:'cas_des',index:'cas_des', width:90, align:'center'},
            {name:'fono',index:'fono', width:100, align:'center'},
            {name:'cas_id',index:'cas_id',hidden:true},
            {name:'estado',index:'estado', hidden:true},
            {name:'editar',index:'editar', width:60, align:'center'},
            {name:'Elimin',index:'Elimin', width:60, align:'center'}
        ],        
        pager: '#pager_table_user',
        rowList: [11, 20],
        gridComplete: function(){
            var rows = $("#table_user").getDataIDs();
            for (var i = 0; i < rows.length; i++){
                var estado = $("#table_user").getCell(rows[i], "estado");                
                if (estado == 0){
                    $("#table_user").jqGrid('setRowData', rows[i], false, {color: '#FF4444', weightfont: 'bold', background: '#FFDDDD'});
                }
            }
        }
    }); 
}

function insertar_nuevo_usuario(id,tip){
    
    limpiar_ctrl('dialog_insert_new_user');
    
    if(tip==0){tit='AGREGAR NUEVO USUARIO';}
    else{
        tit='MODIFICAR USUARIO';
        $("#user_id").val(id);
        $("#reg_usuario_ape_nom").val($.trim($("#table_user").getCell(id, "name")));
        $("#reg_usuario_usuario").val($.trim($("#table_user").getCell(id, "user")));
        $("#reg_usuario_fono").val($.trim($("#table_user").getCell(id, "fono")));        
        $("#reg_usuario_est").val($.trim($("#table_user").getCell(id, "estado")));
        cas_id=$("#table_user").getCell(id, "cas_id");
        $("#reg_usuario_casa_id").val(cas_id);
    }
    $("#dialog_insert_new_user").dialog({
        autoOpen: false, modal: true,title:tit, height: 450, width: 700, show: { effect: "fade", duration: 300 },        
        close: function() {            
//            document.getElementById('reg_usuario_casa_id').options.length = 1;//reinicia combo             
        }
    }).dialog('open');
    $("#user_id").val(id);
    pintar_azul_todo(1);//registro y update de usuarios

}

function user_delete(id){
       
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: 'user_delete/'+id,
        type: 'POST',        
        success: function (data) {
            btn_actualizar_grilla('table_user');
            mensaje_sis('mensaje','* El Usuario: '+data['usuario']['usuario']+' fue eliminado.',':.MENSAJE DEL SISTEMA...');
        },
        error: function(){
            mensaje_sis('mensaje','* Error interno del sistema...','INTERNO');
        }
    });

}

function btn_actualizar_grilla(grilla,url) {
//    $("#"+grilla).setGridParam({serach: false, searchdata: {}, page: 1}).trigger("reloadGrid");
//    $("#"+grilla).trigger("reloadGrid");
    jQuery("#"+grilla).jqGrid('setGridParam', {
        url: url
    }).trigger('reloadGrid');
}

function open_dialog_load_all_casas(){
    
    dialog_close('div_adm_all');
    $("#dialog_casa_grilla").dialog({
            autoOpen: false, modal: true, height: 550, width: 800, show: { effect: "fade", duration: 300 }
           
    }).dialog('open');
    
    jQuery("#table_casas").jqGrid({ 
        url: 'casas',
        datatype: 'json', mtype: 'GET',        
        width: '100%', height: '265',
        colNames:['ID','SUCURSALES', 'DIRECCION','TELEFONO','FECHA DE REG.','Editar'], 
        rowNum: 10, sortname: 'cas_id', sortorder: 'desc', viewrecords: true, caption: 'LISTADO DE  CASA DE PRESTAMO',  align: "center",
        colModel:[ 
            {name:'cas_id',index:'cas_id',hidden:true}, 
            {name:'cas_des',index:'cas_des', width:200}, 
            {name:'cas_dir',index:'cas_dir', width:250},
            {name:'cas_fono',index:'cas_fono', width:100}, 
            {name:'cas_fch_reg',index:'cas_fch_reg', width:120},
            {name:'editar',index:'editar', width:60, align:'center'}
        ],
        pager: '#pager_table_casas',
        rowList: [10, 20]
    }); 
    
}

function confirmar_eliminar(id){
    mensaje_sis('mensaje','* Este boton no esta disponible...',':.SISTEMA:.');
//    mensaje_eliminar(':.CUIDADO ...!!!','* Esta seguro que decea eliminar este Usuario.<br>* Los cambios no se podran revertir.',id);
}


function dialog_close(cuadro){
    $('#'+cuadro).dialog( "close" );
}

function dialog_get_system(){
    
    dialog_close('div_adm_all');    
    $("#dialog_system_data").dialog({
            autoOpen: false, modal: true, height: 260, width: 480, show: { effect: "fade", duration: 300 }
    }).dialog('open');
}

function get_data_system(){
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: 'system',
        type: 'POST',        
        success: function (data) {
            $("#dialog_system_data_interes").val(data.interes);
            $("#dialog_system_data_ini").val(data.rec_ini);
            $("#dialog_system_data_fin").val(data.rec_fin);            
        },
        error: function(){
            mensaje_sis('mensaje','* Error interno del sistema...','INTERNO');
        }
    });
}
//    $.ajax({
//        url: 'users',
//        type: 'GET',        
//        success: function (data) {
//            console.log(data);
//        }
//    });
