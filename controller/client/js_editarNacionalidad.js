$(document).ready(function(){
	validar('txtNacionalidadAgre', 'id' ,'letras');
	var a=0
	$("#btnModificarNac").button().click(function(){
		$("#txtNacionalidad").blur();
		if(a==1){
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
	$("#txtNacionalidad").blur(function(){
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

	$("#txtNacionalidad").focus(function(){
		$(this).removeClass("cajabuena cajamala");	
		$('#errNacionalidad').attr("title", "").hide("slow");				
	});
});