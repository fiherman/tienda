function open_dialog_load_all_casas(){
    limpiar_ctrl('dialog_casa_grilla');
    dialog_close('div_adm_all');
    $("#dialog_casa_grilla").dialog({
            autoOpen: false, modal: true, height: 550, width: 800, show: { effect: "fade", duration: 300 }
           
    }).dialog('open');
    
    jQuery("#table_casas").jqGrid({ 
        url: 'casas',
        datatype: 'json', mtype: 'GET',        
        width: '100%', height: '265',
        colNames:['ID','TIENDAS', 'DIRECCION','TELEFONO','FECHA DE REG.','Editar'], 
        rowNum: 10, sortname: 'cas_id', sortorder: 'desc', viewrecords: true, caption: 'LISTADO DE  CASA DE PRESTAMO',  align: "center",
        colModel:[ 
            {name:'cas_id',index:'cas_id',hidden:true}, 
            {name:'cas_des',index:'cas_des', width:200}, 
            {name:'cas_dir',index:'cas_dir', width:250},
            {name:'cas_fono',index:'cas_fono', width:100}, 
            {name:'cas_fch_reg',index:'cas_fch_reg', width:135},
            {name:'editar',index:'editar', width:60, align:'center'}
        ],
        pager: '#pager_table_casas',
        rowList: [10, 20]
    }); 
    
}

function insert_update_casa(cas_id,tip){
    
    limpiar_ctrl('dialog_insert_update_casa');
    pintar_azul_todo(2);
    if(tip==0){
        tit='AGREGAR NUEVA CASA';
    }
    else{
        $('#cas_id').val(cas_id);
        tit='MODIFICAR CASA';
        $("#reg_casa_cas_des").val($.trim($("#table_casas").getCell(cas_id, "cas_des")));
        $("#reg_casa_cas_dir").val($.trim($("#table_casas").getCell(cas_id, "cas_dir")));
        $("#reg_casa_cas_fono").val($.trim($("#table_casas").getCell(cas_id, "cas_fono")));
    }
    $("#dialog_insert_update_casa").dialog({
        autoOpen: false, modal: true,title:tit, height: 300, width: 700, show: { effect: "fade", duration: 300 },
        close:function(){
            $('#cas_id').val(0);

        }
    }).dialog('open');
    
}

function btn_guardar_casa() {    
    cas_id        = $("#cas_id").val();
    cas_des       = $("#reg_casa_cas_des").val();
    cas_dir       = $("#reg_casa_cas_dir").val();
    cas_fono      = $("#reg_casa_cas_fono").val();
    cas_fch_reg   = $("#reg_cas_cas_fch_reg").val();
    _token        = $("#_token").val();
    if (cas_des != "" && cas_dir != "" && cas_fono != "") {
        if(cas_id==0){  //insertar                 
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: 'casa_save',
                data: {cas_des:cas_des, cas_dir:cas_dir, cas_fono:cas_fono,_token:_token},
                success: function (data) {
                    if(data.msg=='si'){
                        btn_actualizar_grilla('table_casas');
                        dialog_close('dialog_insert_update_casa');
                        mensaje_sis('mensaje','* La casa "'+data.cas_des+'" a sido creada...',':.MENSAJE DE CONFIRMACION...');
                    }else{
                        mensaje_sis('mensaje','* La casa "'+data.cas_des+'" ya existe...',':.ERROR...!!');
                    }

                },error: function(data){
                    alert('nons esta bien todo mal');
                }
            });
        }else{
//            alert('good update ');  
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: 'casa_save',
                data: {cas_id:cas_id, cas_des:cas_des, cas_dir:cas_dir,cas_fono:cas_fono,_token:_token},
                success: function (data) {
                    if(data.msg=='si'){
                        btn_actualizar_grilla('table_casas');
                        dialog_close('dialog_insert_update_casa');
                        mensaje_sis('mensaje','* La casa "'+data.cas_des+'" a sido modificada...',':.MENSAJE DE CONFIRMACION...');
                    }else{
                        mensaje_sis('mensaje','* La casa "'+data.cas_des+'" ya existe...',':.ERROR...!!');
                    }

                },error: function(data){
                    alert('Error interno del sistema... Contactese con el administrador del sistema.');
                }
            });
        }               
        return true;

    } else {
        if (cas_des == "")  { $("#reg_casa_cas_des").css({border: "1px solid #FF8080"}); }
        if (cas_dir == "")  { $("#reg_casa_cas_dir").css({border: "1px solid #FF8080"}); }
        if (cas_fono == "") { $("#reg_casa_cas_fono").css({border: "1px solid #FF8080"}); }
       
        
        mensaje_sis('mensaje','* Los campos marcados de rojo son requeridos.','INFORMACION');
        return false;
//        shorcut_enter=1;
    }
}

function btn_buscar_casa() {    
    txt = ($("#txtbuscar_casa").val()).toUpperCase();
    
    if(txt==""){
        btn_actualizar_grilla('table_casas','casas'); 
    }else{
        jQuery("#table_casas").jqGrid('setGridParam', {
            url: "casa_buscar/"+ txt
        }).trigger('reloadGrid');
    }   
}
