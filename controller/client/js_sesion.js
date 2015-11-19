$(document).ready(function(){
	var a=0, b=0, c=0;
	$('#btnCambiarContrasena').button().click(function(){
		if(a==1 && b==1 && c==1){
			var resCambio = validarProcesos('controller/server/controlador_sesion.php',$("#frmCambiarContrasena").serialize()+"&op=modificar");
			if(resCambio=='1'){
				//mensajeUsuario('successMensaje','Exito','Contraseña cambiada');
				validarProcesos('controller/server/controlador_sesion.php','op=cerrar');
				$('#modalcambiarContrasena').dialog('destroy').remove();
				window.location.href = '../login/index.php';
			}else if(resCambio=='3'){
				mensajeUsuario('errorMensaje','Error','Contraseña Incorrecta');
			}else{
				mensajeUsuario('errorMensaje','Error','A ocurrido un error');
			}
		}else{
			mensajeUsuario('errorMensaje','Advertencia','Complete los campos correctamente');
		}
	});
	
	//EVENTOS BLUR
	$("#txtPassActual").blur(function(){
			if( $(this).val()==""){
				$(this).removeClass("cajabuena" ).addClass( "cajamala" );
				muestraError('errPassActual','Rellene los campos');
				a=0;			
			}else{			
				$(this).removeClass("cajamala" );
				a=1;
			}
	});

	$("#txtPassNuevo").blur(function(){
			if( $(this).val()==""){
				$(this).removeClass("cajabuena" ).addClass( "cajamala" );
				muestraError('errPassNuevo','Rellene los campos');
				b=0;			
			}else{			
				$(this).removeClass("cajamala" );
				b=1;
			}
	});
	$("#txtPassNuevoR").blur(function(){
			if( $(this).val()==""){
				$(this).removeClass("cajabuena" ).addClass( "cajamala" );
				muestraError('errPassNuevoR','Rellene los campos');
				c=0;			
			}else if($("#txtPassNuevo").val() != $(this).val()){
				$(this).removeClass("cajabuena" ).addClass( "cajamala" );
				muestraError('errPassNuevoR','Las contraseñas no coinciden');
				c=0;
			}else{			
				$(this).removeClass("cajamala" );
				c=1;	
			}
	});

	// EVENTOS ONFOCUS ------------------------------
	$("#txtPassActual").focus(function(){
		$(this).removeClass("cajabuena cajamala");	
		$('#errPassActual').attr("title", "").hide("slow");				
	});

	$("#txtPassNuevo").focus(function(){
		$(this).removeClass("cajabuena cajamala");	
		$('#errPassNuevo').attr("title", "").hide("slow");				
	});

	$("#txtPassNuevoR").focus(function(){
		$(this).removeClass("cajabuena cajamala");	
		$('#errPassNuevoR').attr("title", "").hide("slow");				
	});

});