$(document).ready(function(){

	$("#btnModificarNac").button().click(function(){
		if($("#txtNacionalidad").val()!=""){
			var res = validarProcesos('./controller/server/controlador_nacionalidad.php',$("#frmEditarUsuario").serialize()+"&op=editar");
			//alert(res)
			if(res!=""){
				$("#txtNacionalidad").addClass("cajamala");
				muestraError("errNacionalidad", res);
			}else{
				cargarContenido('./view/interface/busquedaNacionalidades.php','','#contenidoCargado');
				mensajeUsuario('successMensaje','Exito','El nombre de nacionalidad fue modificado.</b>');
				$('#modalEditarNacionalidad').dialog('destroy').remove();
			}
		}else{
			$("#txtNacionalidad").addClass("cajamala");
			muestraError("errNacionalidad", "Rellene los campos");
		}				
	});
});