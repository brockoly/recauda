var banTb = 0;
$("#enviarDatos").button().click(function(){
    var progreso     = $('#progreso');
    var porcentaje   = $('#porce');    
	var options = { 
       data: { 'op': 'cargarPacienteCSV' },
       url:   './controller/server/controlador_paciente.php',
       type : "POST",/*
       uploadProgress: function(event, position, total, percentComplete) { //on progress
            progreso.val(percentComplete) //update progressbar percent complete
            porcentaje.html(percentComplete + '%'); //update status text
       },*/
       beforeSubmit:function(){      		
			if($("#archivo").val()==""){
				mensajeUsuario('errorMensaje','Error','<b>Importe un Archivo.</b>');
				return false
			}else{
				$.blockUI({ message: '<h3>Cargando Pacientes</h3><img src="./include/img/upload.png" width="40" height="40">' });
			}

	   },
	   success:function(retorno){
	   		var rs = JSON.parse(retorno);
	   		$('#dvTb').empty();
	   		$('<table id="erroresTB" class="display" width="750px"><thead><tr><th>Identificador</th><th>Nombre Paciente</th><th>Resumen Error</th><th>Resultado</th></tr></thead></table>').appendTo('#dvTb');
	   		
	   		//$(".trNew").remove();
	   		var i=0;
	   		//alert(rs[rs.length-1].totalIns)
	   		if(rs.length>1){
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
	   				$('<tr><td align="center">'+rs[i].id+'</td><td align="center">'+rs[i].nombres+" "+rs[i].apellidoPaterno+" "+rs[i].apellidoMaterno+'</td><td align="center"><b>'+rs[i].error+'</b></td><td align="center">'+rs[i].result+'</td></tr>').appendTo('#erroresTB');
	   			}
	   		}
	   		if(banTb==0){
	   			tablaMinima('erroresTB');
	   			banTb++;
	   		}else{	   			
	   			tablaMinima('erroresTB');
	   		}
	   		$.unblockUI();	   		
	   		$("#totalRS").html("Se agrego un total de <b>"+rs[i-1].totalIns+" paciente(s)</b> a la base de datos.");
	   		cargarContenido('view/interface/busquedaPaciente.php','','#contenidoCargado');
	   		   		
	   }
    }; 	

	$('#cargaPacienteMas').ajaxSubmit(options); 
});
