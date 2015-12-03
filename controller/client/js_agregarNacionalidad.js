$(document).ready(function(){
	validar('txtNacionalidadAgre', 'id' ,'letras');
	var a=0
	$("#btnAgregarNac").button().click(function(){
		$("#txtNacionalidadAgre").blur();
		if(a==1){
			var res = validarProcesos('./controller/server/controlador_nacionalidad.php',$("#frmEditarUsuario").serialize()+"&op=agregar");
			//alert(res)
			if(res!=""){
				$("#txtNacionalidadAgre").addClass("cajamala");
				muestraError("errNacionalidad", res);
			}else{
				cargarContenido('./view/interface/busquedaNacionalidades.php','','#contenidoCargado');
				mensajeUsuario('successMensaje','Exito','Nacionalidad Agregada Con Exito.</b>');
				$('#modalAgregarNacionalidad').dialog('destroy').remove();
			}
		}else{
			$("#txtNacionalidadAgre").addClass("cajamala");
			muestraError("errNacionalidad", "Rellene los campos");
		}				
	});
	$("#txtNacionalidadAgre").blur(function(){
		    var valor = eliminarEspacio($(this).val());
			$(this).val(valor);
			if( $(this).val().trim()==""){
				$(this).removeClass("cajabuena" ).addClass( "cajamala" );
				muestraError('errNacionalidad','Rellene los campos');
				a=0;		
			}else{
				if($(this).val().trim().length>1 && $(this).val().trim().length<35){
					$(this).val($(this).val().trim());					
					$(this).removeClass("cajamala" );
					a=1;
				}else{
					$(this).removeClass("cajabuena" ).addClass( "cajamala" );
					muestraError('errNacionalidad','Mínimo 2 caracteres, Máximo 35 caracteres');	
					a=0;
				}
			}			
	});

	$("#txtNacionalidadAgre").focus(function(){
		$(this).removeClass("cajabuena cajamala");	
		$('#errNacionalidad').attr("title", "").hide("slow");				
	});
});