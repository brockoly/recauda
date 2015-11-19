$(document).ready(function(){

	
	$('#btnAgregarAsociaciones').button();
	
	$("#btnAgregarAsociaciones").click(function(){
		var arrayInstituciones="";
		$('input[name="institucion[]"]:checked').each(function() {
			arrayInstituciones += $(this).val() + ",";
		});
		arrayInstituciones = arrayInstituciones.substring(0, arrayInstituciones.length-1);	
		validarProcesos('controller/server/controlador_prevision.php','pre_id='+$("#txtIdPre").val()+'&arregloInstituciones='+arrayInstituciones+'&op=agregarAsociacion');
		mensajeUsuario('successMensaje','Exito','Institución/es asociadas con éxito');
		cargarContenido('view/interface/busquedaPrevisionInstitucion.php','pre_id='+$("#txtIdPre").val()+'&pre_nombre='+$("#txtNombrePre").val(),'#contenidoPrevisionInstitucion');
		$('#modalAsociarInstitucion').dialog('destroy').remove();
	});
});

