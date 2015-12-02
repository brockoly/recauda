$(document).ready(function(){

	$("#btnAgregarCon").button().click(function(){
		if($("#txtConvenioAgre").val().trim()!=""){
			$("#txtConvenioAgre").val($("#txtConvenioAgre").val().trim())
			var arrayPrevisiones="";
			$('input[name="prevision[]"]:checked').each(function() {
				arrayPrevisiones += $(this).val() + ",";
			});
			arrayPrevisiones = arrayPrevisiones.substring(0, arrayPrevisiones.length-1);
			if(arrayPrevisiones.length>=1){
				var res = validarProcesos('controller/server/controlador_convenio.php','ins_nombre='+$("#txtConvenioAgre").val()+'&arregloPrevisiones='+arrayPrevisiones+'&op=agregarConvenio');
				if(res!=""){
					$("#txtConvenioAgre").addClass("cajamala");
					muestraError("errConvenio", res);
				}else{
					cargarContenido('./view/interface/busquedaConvenio.php','','#contenidoCargado');
					mensajeUsuario('successMensaje','Éxito','Institución vinculada con éxito.');
					$('#modalAgregarConvenio').dialog('destroy').remove();
				}
			}else{
				muestraError("errAgregarConvenio", "Seleccione al menos una previsión");
				if($("#txtConvenioAgre").val().trim()!=""){
					$('#txtConvenioAgre').removeClass("cajamala");	
					$('#errConvenio').attr("title", "").hide("slow");					
				}
			}
		}else{
			$("#txtConvenioAgre").val($("#txtConvenioAgre").val().trim())
			$("#txtConvenioAgre").addClass("cajamala");
			muestraError("errConvenio", "Rellene los campos");
		}				
	});
});
