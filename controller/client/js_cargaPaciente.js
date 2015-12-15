$("#enviarDatos").button().click(function(){
    var progreso     = $('#progreso');
    var porcentaje   = $('#porce');
	var options = { 
       data: { 'op': 'cargarPacienteCSV' },
       url:   './controller/server/controlador_paciente.php',
       type : "POST",
       uploadProgress: function(event, position, total, percentComplete) { //on progress
            progreso.val(percentComplete) //update progressbar percent complete
            porcentaje.html(percentComplete + '%'); //update status text
       },
       beforeSubmit:function(){      		
			if($("#archivo").val()==""){
				mensajeUsuario('errorMensaje','Error','<b>Importe un Archivo.</b>');
				return false
			}
	   },
	   success:function(retorno){
	   		var rs = JSON.parse(retorno); 
	   		$(".trNew").remove();
	   		var i=0;
	   		//alert(rs[rs.length-1].totalIns)
	   		if(rs.length>1){
	   			$('#encabezadosError').show();
	   			//mensajeUsuario('errorMensaje','Exito','<b> Carga Procesada Con Exito.</b>');
	   			if(rs[rs.length-1].totalIns>0){
	   				mensajeUsuario('alertMensaje','Advertencia','<b>Carga realizada, corrija los errores ya encontrados y vuelva a cargar.</b>')
	   			}else{
	   				mensajeUsuario('errorMensaje','Error','<b> No se pudo realizar la carga, corrija los errores.</b>');
	   			}
	   		}else{
	   			$('#encabezadosError').hide();
	   			mensajeUsuario('successMensaje','Exito','<b> Carga procesada con exito.</b>');	
	   		}
	   		for(i; i<rs.length; i++){
	   			$("#rsError").show();
				$("#wait").show();
	   			if(rs.length-i>1){
	   				$('<tr class="trNew"><td class="cuerpoDatosTablas" align="center">'+rs[i].id+'</td><td class="cuerpoDatosTablas" align="center">'+rs[i].nombres+" "+rs[i].apellidoPaterno+" "+rs[i].apellidoMaterno+'</td><td class="cuerpoDatosTablas" align="center"><b>'+rs[i].error+'</b></td><td class="cuerpoDatosTablas" align="center">'+rs[i].result+'</td></tr>').appendTo('#erroresTB');
	   			}
	   		}
	   		$("#totalRS").html("Se agrego un total de <b>"+rs[i-1].totalIns+" paciente(s)</b> a la base de datos.");
	   		   		
	   }
    }; 	

	$('#cargaPacienteMas').ajaxSubmit(options); 
});
