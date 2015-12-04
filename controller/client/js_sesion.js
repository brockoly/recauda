$(document).ready(function(){
	var a=0, b=0, c=0;
	$('#btnCambiarContrasena').button().click(function(){
		$("#txtPassNuevo").blur();
		$("#txtPassNuevoR").blur();
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
		}
	});
	
	//EVENTOS BLUR
	$("#txtPassActual").blur(function(){
			if( $(this).val().trim()==""){
				$(this).removeClass("cajabuena" ).addClass( "cajamala" );
				muestraError('errPassActual','Rellene los campos');
				a=0;			
			}else{			
				$(this).removeClass("cajamala" );
				a=1;
			}
	});

	$("#txtPassNuevo").blur(function(){
			var esp = verificarEspacios($(this).val());
			if(esp==-1){
				if( $(this).val().trim()==""){
					$(this).removeClass("cajabuena" ).addClass( "cajamala" );
					muestraError('errPassNuevo','Rellene los campos');
					b=0;			
				}else{			
					$(this).removeClass("cajamala" );
					b=1;
				}
			}else{
				b=0;
				$(this).removeClass("cajabuena" ).addClass( "cajamala" );
				muestraError('errPassNuevo','Las contraseñas no puede contener espacio');
			}
	});
	$("#txtPassNuevoR").blur(function(){
			var esp = verificarEspacios($(this).val());
			if(esp==-1){
				if( $(this).val().trim()==""){
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
			}else{
				c=0;
				$(this).removeClass("cajabuena" ).addClass( "cajamala" );
				muestraError('errPassNuevoR','Las contraseñas no puede contener espacio');
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

function verificarEspacios(string){
	return string.indexOf(" ");
}