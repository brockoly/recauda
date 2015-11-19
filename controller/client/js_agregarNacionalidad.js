$(document).ready(function(){

	$("#btnAgregarNac").button().click(function(){
		if($("#txtNacionalidadAgre").val()!=""){
			var res = validarProcesos('./controller/server/controlador_nacionalidad.php',$("#frmEditarUsuario").serialize()+"&op=agregar");
			//alert(res)
			if(res!=""){
				$("#txtNacionalidadAgre").addClass("cajamala");
				muestraError("errNacionalidad", res);
			}else{
				cargarContenido('./view/interface/busquedaNacionalidades.php','','#contenidoCargado');
				mensajeUsuario('successMensaje','Exito','El nombre de nacionalidad fue modificado.');
				$('#modalAgregarNacionalidad').dialog('destroy').remove();
			}
		}else{
			$("#txtNacionalidadAgre").addClass("cajamala");
			muestraError("errNacionalidad", "Rellene los campos");
		}
				
	});
});