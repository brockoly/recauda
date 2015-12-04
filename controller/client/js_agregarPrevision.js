$(document).ready(function(){

	validar('txtPrevisionAgre', 'id' ,'letras')
	$("#btnAgregarPre").button().click(function(){
		if($("#txtPrevisionAgre").val().trim()!=""){
			var valor = eliminarEspacio($("#txtPrevisionAgre").val());
			$("#txtPrevisionAgre").val(valor);
			var res = validarProcesos('./controller/server/controlador_prevision.php',$("#frmEditarUsuario").serialize()+"&op=agregar");
			
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
			$("#txtPrevisionAgre").val($("#txtPrevisionAgre").val().trim());
		}
				
	});

	$("#txtPrevisionAgre").blur(function(){
		var valor = eliminarEspacio($(this).val());
		$(this).val(valor);
	});

	$("#txtPrevisionAgre").focus(function(){
		$(this).removeClass("cajabuena cajamala");	
		$('#errPrevision').attr("title", "").hide("slow");
	});

	
	
});