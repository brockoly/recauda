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
	   		for(i; i<rs.length; i++){
	   			$("#rsError").show();
				$("#wait").show();
	   			if(rs.length-i>1){
	   				$('<tr class="trNew"><td class="cuerpoDatosTablas" align="center">'+rs[i].id+'</td><td class="cuerpoDatosTablas" align="center">'+rs[i].nombres+'</td><td class="cuerpoDatosTablas" align="center">'+rs[i].error+'</td><td class="cuerpoDatosTablas" align="center">'+rs[i].result+'</td></tr>').appendTo('#erroresTB');
	   			}
	   		}
	   		$("#totalRS").text("Se agrego un total de "+rs[i-1].totalIns+" paciente(s) a la base de datos.");
	   			   		
	   }
    }; 	

	$('#cargaPacienteMas').ajaxSubmit(options); 
	/*var res = validarProcesos('./controller/server/controlador_paciente.php',$("#cargaPacienteMas").serialize()+"&op=cargarPacienteCSV");
	alert(res);*/

});
