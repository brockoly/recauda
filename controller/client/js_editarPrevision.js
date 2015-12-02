$(document).ready(function(){

	$("#btnModificarPre").button().click(function(){
		if($("#txtPrevision").val().trim()!=""){
			var res = validarProcesos('./controller/server/controlador_prevision.php',$("#frmEditarUsuario").serialize()+"&op=editar");
			
			if(res!=""){
				$("#txtPrevision").addClass("cajamala");
				muestraError("errPrevision", res);
			}else{
				cargarContenido('./view/interface/busquedaPrevision.php','','#contenidoCargado');
				mensajeUsuario('successMensaje','Exito','El nombre de la prevision fue modificado.</b>');
				$('#modalEditarPrevision').dialog('destroy').remove();
			}
		}else{
			$("#txtPrevision").val().trim();
			$("#txtPrevision").addClass("cajamala");
			muestraError("errPrevision", "Rellene los campos");
		}
				
	});
});