$(document).ready(function(){

	$("#btnModificarCon").button().click(function(){
		if($("#txtConvenio").val().trim()!=""){
			$("#txtConvenio").val($("#txtConvenio").val().trim());
			var res = validarProcesos('./controller/server/controlador_convenio.php',$("#frmEditarUsuario").serialize()+"&op=editar");
			//alert(res)
			if(res!=""){
				$("#txtConvenio").addClass("cajamala");
				muestraError("errConvenio", res);
			}else{
				cargarContenido('./view/interface/busquedaConvenio.php','','#contenidoCargado');
				mensajeUsuario('successMensaje','Exito','El nombre del convenio fue modificado.</b>');
				$('#modalEditarConvenio').dialog('destroy').remove();
			}
		}else{
			$("#txtConvenio").addClass("cajamala");
			muestraError("errConvenio", "Rellene los campos");
		}
				
	});

});