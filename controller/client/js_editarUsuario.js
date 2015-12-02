$(document).ready(function(){	

	//Variables Banderas	
	var a=1,b=1,c=1,d=1,e=1,f=1,g=1, o=1, z=1; //BANDERAS GLOBALES
	validar('txtCorreo', 'id' ,'correo');
	validar('txtNombre', 'id' ,'letras');
	validar('txtApellidoPaterno', 'id' ,'letras');
	validar('txtApellidoMaterno', 'id' ,'letras');
	validar('txtTelefono', 'id' ,'numero');
	validar('txtDireccion', 'id' ,'todo');
	
	//BOTON AGREGAR USUARIO.
	$("#btnEditarUsuario").button().click(function(){
		if($("#txtFechaNacimientos").val()==""){
			$("#txtFechaNacimientos").addClass("cajamala");
			muestraError('errFechaNacimiento','Rellene los campos');
			f=0;	
		}else{
			$("#txtFechaNacimientos").removeClass("cajamala" );
			f=1;
		}		
		//alert("a="+a+"b="+b+"c="+c+"d="+d+"e="+e+"f="+f+"o="+o+"z="+z)
		if(a==1 && b==1 && c==1 && d==1 && e==1 && f==1 && o==1 && z==1){
			
			var res = retornarJson('./controller/server/controlador_usuario.php',$("#frmAgregarUsuario").serialize()+"&op=modificarUsuario");
			//alert(Object.keys(res).length);
			//alert(res.txtCorreo)
			if(res.txtCorreo!=0){
					$("#txtCorreo").addClass("cajamala");
					muestraError('errCorreo',res.txtCorreo);
			}else{
				cargarContenido('./view/interface/busquedaUsuario.php','','#contenidoCargado');
				mensajeUsuario('successMensaje','Exito','El usuario fue modificado con exito.</b>');
				$('#modalEditarUsuario').dialog('destroy').remove();
			}
			
		}else{			
			if(z==0){
				$("#cmbPrivilegios").addClass("cajamala");
				muestraError('errPrivilegio','Seleccione un Privilegio Porfavor');
			}else{ $("#cmbPrivilegios").removeClass("cajamala"); $('#errPrivilegio').attr("title", "").hide("slow");	 }

				$("#txtIdentificador").blur();
				$("#txtCorreo").blur();
				$("#txtNombre").blur();
				$("#txtApellidoPaterno").blur();
				$("#txtApellidoMaterno").blur();
				$("#txtDireccion").blur();
		}			
	});	
	

    // VALIDACIONES ONBLUR ------------
	
	$("#txtCorreo").blur(function(){
			if( $(this).val()==""){
				$(this).removeClass("cajabuena" ).addClass( "cajamala" );
				muestraError('errCorreo','Rellene los campos');	
				b=0;		
			}else{
				if(validaEmail($(this).val())){					
					$(this).removeClass("cajamala" );
					b=1;
				}else{
					$(this).removeClass("cajabuena" ).addClass( "cajamala" );
					muestraError('errCorreo','Ingrese un formato de correo valido. Ej: algo@dominio.com');
					b=0;	
				}
			}
	});

	$("#txtNombre").blur(function(){
			if( $(this).val()==""){
				$(this).removeClass("cajabuena" ).addClass( "cajamala" );
				muestraError('errNombre','Rellene los campos');
				c=0;		
			}else{
				if($(this).val().length>1 && $(this).val().length<35){					
					$(this).removeClass("cajamala" );
					c=1;
				}else{
					$(this).removeClass("cajabuena" ).addClass( "cajamala" );
					muestraError('errNombre','Mínimo 2 caracteres, Máximo 35 caracteres');	
					c=0;
				}
			}
	});

	$("#txtApellidoPaterno").blur(function(){
			if( $(this).val()==""){
				$(this).removeClass("cajabuena" ).addClass( "cajamala" );
				muestraError('errApellidoPaterno','Rellene los campos');
				d=0;			
			}else{
				if($(this).val().length>1 && $(this).val().length<35){					
					$(this).removeClass("cajamala" );
					d=1;
				}else{
					$(this).removeClass("cajabuena" ).addClass( "cajamala" );
					muestraError('errApellidoPaterno','Mínimo 2 caracteres, Máximo 35 caracteres');
					d=0;
				}
			}
	});

	$("#txtApellidoMaterno").blur(function(){
			if( $(this).val()==""){
				$(this).removeClass("cajabuena" ).addClass( "cajamala" );
				muestraError('errApellidoMaterno','Rellene los campos');
				e=0;			
			}else{
				if($(this).val().length>1 && $(this).val().length<35	){					
					$(this).removeClass("cajamala" );
					e=1;
				}else{
					$(this).removeClass("cajabuena" ).addClass( "cajamala" );
					muestraError('errApellidoMaterno','Mínimo 2 caracteres, Máximo 35 caracteres');	
					e=0;
				}
			}
	});
	$("#txtDireccion").focus(function(){
		$(this).removeClass("cajabuena cajamala");	
		$('#errDireccion').attr("title", "").hide("slow");				
	});
	/*$("#txtTelefono").blur(function(){
			if( $(this).val()==""){
				//$(this).removeClass("cajabuena" ).addClass( "cajamala" );
				//muestraError('errTelefono','Rellene los campos');
				g=0;			
			}else{
				if($(this).val().length>9 && $(this).val().length<11){					
					//$(this).removeClass("cajamala" );
					g=1;
				}else{
					//$(this).removeClass("cajabuena" ).addClass( "cajamala" );
					//muestraError('errTelefono','Ej: 0582554487');
					g=0;	
				}
			}
	});*/

	
	$("#cmbPrivilegios").change(function(){
			if($(this).val()!=0){
				z=1;
				$("#cmbPrivilegios").removeClass("cajamala"); $('#errPrivilegio').attr("title", "").hide("slow");					
			}else{
				z=0;
			}
	});
	
	$("#goma").click(function(){
			$("#txtFechaNacimientos").val("");
			$('#errFechaNacimiento').attr("title", "").hide("slow");
			$('#txtFechaNacimientos').removeClass("cajamala");						
	});

	// VALIDACIONES ONFOCUS ------------------------------
	
	$("#txtCorreo").focus(function(){
		$(this).removeClass("cajabuena cajamala");	
		$('#errCorreo').attr("title", "").hide("slow");				
	});

	$("#txtNombre").focus(function(){
		$(this).removeClass("cajabuena cajamala");	
		$('#errNombre').attr("title", "").hide("slow");				
	});

	$("#txtApellidoPaterno").focus(function(){
		$(this).removeClass("cajabuena cajamala");	
		$('#errApellidoPaterno').attr("title", "").hide("slow");				
	});

	$("#txtApellidoMaterno").focus(function(){
		$(this).removeClass("cajabuena cajamala");	
		$('#errApellidoMaterno').attr("title", "").hide("slow");				
	});	

	$("#txtTelefono").focus(function(){
		$(this).removeClass("cajabuena cajamala");	
		$('#errTelefono').attr("title", "").hide("slow");				
	});

	$("#txtFechaNacimientos").focus(function(){
		$(this).removeClass("cajamala");	
		$('#errFechaNacimiento').attr("title", "").hide("slow");
	});

	
});

	
	