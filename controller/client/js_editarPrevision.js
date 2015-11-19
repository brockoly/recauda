$(document).ready(function(){

	$("#btnModificarPre").button().click(function(){
		if($("#txtPrevision").val()!=""){
			var res = validarProcesos('./controller/server/controlador_prevision.php',$("#frmEditarUsuario").serialize()+"&op=editar");
			//alert(res)
			if(res!=""){
				$("#txtPrevision").addClass("cajamala");
				muestraError("errPrevision", res);
			}else{
				cargarContenido('./view/interface/busquedaPrevision.php','','#contenidoCargado');
				mensajeUsuario('successMensaje','Exito','El nombre de la prevision fue modificado.</b>');
				$('#modalEditarPrevision').dialog('destroy').remove();
			}
		}else{
			$("#txtPrevision").addClass("cajamala");
			muestraError("errPrevision", "Rellene los campos");
		}
				
	});

	$("#btnAgregarPre").button().click(function(){
		if($("#txtPrevisionAgre").val()!=""){
			var res = validarProcesos('./controller/server/controlador_prevision.php',$("#frmEditarUsuario").serialize()+"&op=agregar");
			//alert(res)
			if(res!=""){
				$("#txtPrevisionAgre").addClass("cajamala");
				muestraError("errPrevision", res);
			}else{
				cargarContenido('./view/interface/busquedaPrevision.php','','#contenidoCargado');
				mensajeUsuario('successMensaje','Exito','Previsión agregada.');
				$('#modalAgregarPrevision').dialog('destroy').remove();
			}
		}else{
			$("#txtPrevisionAgre").addClass("cajamala");
			muestraError("errPrevision", "Rellene los campos");
		}
				
	});
});