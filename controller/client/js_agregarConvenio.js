$(document).ready(function(){

	$("#btnAgregarCon").button().click(function(){
		if($("#txtConvenioAgre").val()!=""){
			var arrayPrevisiones="";
			$('input[name="prevision[]"]:checked').each(function() {
				arrayPrevisiones += $(this).val() + ",";
			});
			arrayPrevisiones = arrayPrevisiones.substring(0, arrayPrevisiones.length-1);
			if(arrayPrevisiones.length>=1){
				var res = validarProcesos('controller/server/controlador_convenio.php','ins_nombre='+$("#txtConvenioAgre").val()+'&arregloPrevisiones='+arrayPrevisiones+'&op=agregarConvenio');
				if(res!=""){
					$("#txtConvenioAgre").addClass("cajamala");
					muestraError("errAgregarConvenio", res);
				}else{
					cargarContenido('./view/interface/busquedaConvenio.php','','#contenidoCargado');
					mensajeUsuario('successMensaje','Éxito','Institución vinculada con éxito.');
					$('#modalAgregarConvenio').dialog('destroy').remove();
				}
			}else{
				muestraError("errAgregarConvenio", "Seleccione al menos una previsión");				
			}
		}else{
			$("#txtConvenioAgre").addClass("cajamala");
			muestraError("errAgregarConvenio", "Rellene los campos");
		}				
	});
});
