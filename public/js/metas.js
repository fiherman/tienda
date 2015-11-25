function mensaje_sis(div, texto, tit) {
    $("#" + div).dialog({
        autoOpen: false, modal: true, title: tit, height: 180, width: 400, show: {effect: "fade", duration: 300},
        buttons: [
            {text: "Aceptar",id:"msg_aceptar", click: function() {
                    $(this).dialog("close");
                }}
        ]
    }).dialog('open');
    $("#" + div).html('<p class="info"><b>' + texto + '</b></p>');
}

function mensaje_eliminar(tit,texto,id) {
//    return true;
    $("#eliminar").dialog({
        autoOpen: false, modal: true, title: tit, height: 180, width: 400, show: {effect: "fade", duration: 300},
        buttons: [
            { text: "Aceptar", click: function() {  $(this).dialog("close"); user_delete(id);} },
            { text: "Cancelar", click: function() { $(this).dialog("close"); return false; } }
        ]
    }).dialog('open');
    $("#eliminar").html('<p class="info"><b>' + texto + '</b></p>');
}


///validacion de formulario//////////////
function fn_onblur(input) {
    if (input.value == "" || !input.value || input.value == "select") {
        $("#" + input.id).css({border: "1px solid #FF8080"});
    }else{
        $("#" + input.id).css({border: "1px solid #83CBFF"});
    }
    
    if(input.id=="dialog_monto_amor"){        
        monto=parseFloat(input.value);
        $("#"+input.id).val(monto.toFixed(2));
    }
}

function limpiar_ctrl(div){
        $(':input', '#' + div).each(function() {
            if (this.type === 'text') {  
                if ( $(this).attr('disabled') ) {
                    //no hase nada
                }else{ this.value = "";  }
                    
            }else if ($(this).is('select')){
//                if ($(this).is(':hidden')) {
                    this.value = '1';
                    this.value = 'select';
//                }
            }else if (this.type === 'radio'){
                this.checked = false;
            }else if (this.type === 'textarea'){
                this.value = '';
            }else if (this.type === 'password'){
                this.value = '';
            }
            
        });
}

function pintar_azul_todo(tip){
    switch (tip) {
        case 1://registro o update de USUARIOS////           
            $("#reg_usuario_ape_nom").css({ border: "1px solid #83CBFF"});
            $("#reg_usuario_usuario").css({ border: "1px solid #83CBFF"});
            $("#reg_usuario_fono").css({ border: "1px solid #83CBFF"});
            $("#reg_usuario_casa_id").css({ border: "1px solid #83CBFF"});
            $("#reg_usuario_contra").css({ border: "1px solid #83CBFF"});
            $("#reg_usuario_confi_contra").css({ border: "1px solid #83CBFF"});
       
           break
        case 2:///dialog insert update casas             
            $("#reg_casa_cas_des").css({ border: "1px solid #83CBFF"});
            $("#reg_casa_cas_dir").css({ border: "1px solid #83CBFF"});
            $("#reg_casa_cas_fono").css({ border: "1px solid #83CBFF"});         
           break
        case 3:// DIALOG INSERT UPDATE CLIENTES
            $("#reg_cli_ape").css({ border: "1px solid #83CBFF"});
            $("#reg_cli_nom").css({ border: "1px solid #83CBFF"});
            $("#reg_cli_dir").css({ border: "1px solid #83CBFF"});
            $("#reg_cli_dni").css({ border: "1px solid #83CBFF"});
            $("#reg_cli_movil").css({ border: "1px solid #83CBFF"});
            $("#reg_cli_fijo").css({ border: "1px solid #83CBFF"});
            $("#reg_cli_cas_id").css({ border: "1px solid #83CBFF"});
            $("#reg_cli_estado").css({ border: "1px solid #83CBFF"});
           break
        case 4:
            $("#new_prestamo_prenda").css({ border: "1px solid #83CBFF"});
            $("#new_prestamo_monto").css({ border: "1px solid #83CBFF"});
           break
        case 5:

           break
        case 6:
        case 7:

           break
        case 15: ///// nueva evolucion 15
           
         break;
        default:
          
    } 
}

function llenar_combo_casas(tip){// 0 llenar registro usuarios
    $.ajax({
        url: 'get_all_casas',
        type: 'GET',
        success: function(data) {
            for (i = 0; i <= data.length - 1; i++) {//carga el combo para seleccionar el seguro desde la BD
                if (tip == 0) {// combo de registro o update de USUARIOS
                    $('#reg_usuario_casa_id').append('<option value=' + data[i].cas_id + '>' + data[i].cas_des + '</option>');
                    $('#reg_cli_cas_id').append('<option value=' + data[i].cas_id + '>' + data[i].cas_des + '</option>');
                }
            }
        },
        error: function(data) {
            mensaje_sis('mensaje', ' Error al traer casas', 'INFORMACION');
        }
    });
}

function soloDNI(evt){
    var charCode = (evt.which) ? evt.which : evt.keyCode
    if((charCode > 45 && charCode < 58) || (charCode > 36 && charCode < 41) || charCode == 9 || charCode == 8 ){       
        if(charCode == 110 || charCode == 190 || charCode == 191 || charCode == 84 || charCode == 78 || charCode == 40 || charCode == 37 || charCode == 46 || charCode == 110){
            return false;
        }else{
            return true;
        }        
    }else{
        return false;
    }
}

function soloNumeroTab(evt) {// con guin y slash ( - / )
   
    var charCode = (evt.which) ? evt.which : evt.keyCode
    if((charCode > 44 && charCode < 58) || (charCode > 36 && charCode < 41) || charCode == 9 || charCode == 8 || charCode == 110){
        if(charCode == 78 || charCode == 40 || charCode == 37 || charCode == 46 || charCode == 110){
            return false;
        }else{
            return true;
        }
        
    }else{
        return false;
    }
//    
//    if (charCode > 31 && (charCode < 48 || charCode > 57) ||  charCode == 9 || charCode == 110 ||  charCode != 123 ||  charCode != 116)
//        return false;
//    
//    return true;
           
}


function datepiker(ide_input_datepiker,ini,fin){
    $.datepicker.regional['es'] =
	  {
	  closeText: 'Cerrar',
	  prevText: 'Previo',
	  nextText: 'Próximo',
	   
	  monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
	  'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
	  monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
	  monthStatus: 'Ver otro mes', yearStatus: 'Ver otro año',
	  dayNames: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],
	  dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sáb'],
	  dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
	  dateFormat: 'dd/mm/yy', firstDay: 1,
	  initStatus: 'Selecciona la fecha', isRTL: false
      };
	 $.datepicker.setDefaults($.datepicker.regional['es']);

	 //miDate: fecha de comienzo D=días | M=mes | Y=año
	 //maxDate: fecha tope D=días | M=mes | Y=año
	 $("#"+ide_input_datepiker).datepicker({ minDate: ini, maxDate: fin});
         $("#"+ide_input_datepiker).css({ border: "1px solid #83CBFF"}); 
}

function timepiker(ide_input_timepiker){
   
    $('#'+ide_input_timepiker).timepicker({
        showPeriod: true,
        onHourShow: OnHourShowCallback,
        onMinuteShow: OnMinuteShowCallback
    });
}
function OnHourShowCallback(hour) {
    if ((hour > 20) || (hour < 6)) {
        return false; // not valid
    }
    return true; // valid
}
function OnMinuteShowCallback(hour, minute) {
    if ((hour == 20) && (minute >= 30)) { return false; } // not valid
    if ((hour == 6) && (minute < 30)) { return false; }   // not valid
    return true;  // valid
}

function get_fecha_actual(input){
    var f = new Date();
    $("#"+input).val(("0" + f.getDate()).slice(-2) + "/" + ("0" + (f.getMonth() + 1)).slice(-2) + "/" + f.getFullYear());
}

sumaFecha = function(d, fecha)
{
 var Fecha = new Date();
 var sFecha = fecha || (Fecha.getDate() + "/" + (Fecha.getMonth() +1) + "/" + Fecha.getFullYear());
 var sep = sFecha.indexOf('/') != -1 ? '/' : '-'; 
 var aFecha = sFecha.split(sep);
 var fecha = aFecha[2]+'/'+aFecha[1]+'/'+aFecha[0];
 fecha= new Date(fecha);
 fecha.setDate(fecha.getDate()+parseInt(d));
 var anno=fecha.getFullYear();
 var mes= fecha.getMonth()+1;
 var dia= fecha.getDate();
 mes = (mes < 10) ? ("0" + mes) : mes;
 dia = (dia < 10) ? ("0" + dia) : dia;
 var fechaFinal = dia+sep+mes+sep+anno;
 return (fechaFinal);
 }
 
 