$(document).ready(function(){

	
	$('#btnAgregarAsociaciones').button();
	
	$("#btnAgregarAsociaciones").click(function(){
		var arrayPrevisiones="";
		$('input[name="prevision[]"]:checked').each(function() {
			arrayPrevisiones += $(this).val() + ",";
		});
		arrayPrevisiones = arrayPrevisiones.substring(0, arrayPrevisiones.length-1);	
		var rs = validarProcesos('controller/server/controlador_convenio.php','ins_id='+$("#txtIdIns").val()+'&arregloPrevisiones='+arrayPrevisiones+'&op=agregarAsociacion');
		mensajeUsuario('successMensaje','Exito','Previsión/es asociadas con éxito');
		cargarContenido('view/interface/busquedaInstitucionPrevision.php','ins_id='+$("#txtIdIns").val()+'&ins_nombre='+$("#txtIdIns").val(),'#contenidoInstitucionPrevision');
		$('#modalAsociarPrevision').dialog('destroy').remove();
	});
});


