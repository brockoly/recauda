$(document).ready(function(){

	$("#btnModificarPre").button().click(function(){
		if($("#txtPrevision").val().trim()!=""){
			var valor = eliminarEspacio($("#txtPrevision").val());
			$("#txtPrevision").val(valor);
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

	$("#txtPrevision").blur(function(){
		var valor = eliminarEspacio($(this).val());
		$(this).val(valor);
	});
});