$(document).ready(function(){	
	//Variables Banderas	
	var a=0,b=0,c=0,d=0,e=0,f=0,g=0, h=0, o=0, z=0, rut=0, pacEx=0; //BANDERAS GLOBALES
	validar('txtUsuario', 'id' ,'letrasUsuario');
	validar('txtCorreo', 'id' ,'correo');
	validar('txtIdentificador', 'id' ,'rut');
	validar('txtNombre', 'id' ,'letras');
	validar('txtApellidoPaterno', 'id' ,'letras');
	validar('txtApellidoMaterno', 'id' ,'letras');
	validar('txtTelefono', 'id' ,'numero');
	validar('txtDireccion', 'id' ,'todo');
    
	//BOTON AGREGAR USUARIO

	$("#btnAgregarUsuario").button().click(function(){
		if($("#txtFechaNacimientos").val()==""){
			$("#txtFechaNacimientos").addClass("cajamala");
			muestraError('errFechaNacimiento','Rellene los campos');
			f=0;	
		}else{
			$("#txtFechaNacimientos").removeClass("cajamala" );
			f=1;
		}	
		
		//alert("a="+a+"b="+b+"c="+c+"d="+d+"e="+e+"f="+f+"o="+o+"z="+z)
		if(a==1 && b==1 && c==1 && d==1 && e==1 && f==1 && h==1 && o==1 && z==1){
			var res = retornarJson('./controller/server/controlador_usuario.php',$("#frmAgregarUsuario").serialize()+"&op=agregarUsuario&rut="+rut+"&pacEx="+pacEx);
			//alert(res);
			//alert(Object.keys(res).length);
			if(Object.keys(res).length>0){
				//alert(res.txtUsuario+"-"+res.txtIdentificador+"-"+res.txtCorreo)
				if(res.txtUsuario!=0){
					$("#txtUsuario").removeClass("cajabuena").addClass("cajamala");					
					if(res.txtUsuario=="desactivado"){
						mensajeUsuarioConProcedimiento('alertMensaje','Confirmar Acción','Atención, El usuario ingresado ya existe pero en estado desactivado, ¿Desea Activarlo Nuevamente?','./controller/server/controlador_usuario.php','usu_nombre='+$("#txtUsuario").val()+'&op=restaurarUsuario','view/interface/busquedaUsuario.php','','#contenidoCargado','modalAgregarUsuario');
						muestraError('errUsuario',"El usuario ingresado ya existe pero está desactivado, vaya al mantenedor y activelo nuevamente.");
					}else{
						muestraError('errUsuario',res.txtUsuario);
					}					
				}else{
					$("#txtUsuario").removeClass("cajabuena cajamala");	
					$('#errUsuario').attr("title", "").hide("slow");
				}
				if(res.txtIdentificador!=0){
					$("#txtIdentificador").removeClass("cajabuena").addClass("cajamala");
					muestraError('errIdentificador',res.txtIdentificador);
				}else{
					$("#txtIdentificador").removeClass("cajabuena cajamala");	
					$('#errIdentificador').attr("title", "").hide("slow");
				}
				if(res.txtCorreo!=0){
					$("#txtCorreo").addClass("cajamala");
					muestraError('errCorreo',res.txtCorreo);
				}else{
					$("#txtCorreo").removeClass("cajabuena cajamala");	
					$('#errCorreo').attr("title", "").hide("slow");
				}
			}else{
				$('#modalAgregarUsuario').dialog('destroy').remove();
				cargarContenido('./view/interface/busquedaUsuario.php','','#contenidoCargado');
				mensajeUsuario('successMensaje','Exito','El usuario fue agregado con exito.<br><b><u>Nota</u>:</u></b> Recuerde que la clave generada es la misma que el nombre usuario, <b>Notifique el cambio de esta.</b>');
			}
			
		}else{
			
			if(z==0){
				$("#cmbPrivilegios").addClass("cajamala");
				muestraError('errPrivilegio','Seleccione un Privilegio Porfavor');
			}else{ $("#cmbPrivilegios").removeClass("cajamala"); $('#errPrivilegio').attr("title", "").hide("slow");	 }

			$("#txtIdentificador").blur();
			$("#txtUsuario").blur();
			$("#txtCorreo").blur();
			$("#txtNombre").blur();
			$("#txtApellidoPaterno").blur();
			$("#txtApellidoMaterno").blur();
			$("#txtDireccion").blur();
		}			
	});	

    // VALIDACIONES ONBLUR ------------
	$("#txtUsuario").blur(function(){
			if($(this).val().trim()==""){
				$(this).removeClass("cajabuena" ).addClass( "cajamala" );
				muestraError('errUsuario','Rellene los campos');
				a=0;			
			}else{
				if($(this).val().trim().length>3 && $(this).val().trim().length<20){					
					$(this).removeClass("cajamala" );
					var res = validarProcesos('./controller/server/controlador_usuario.php','op=validarNombreUsuario&usu_nombre='+$("#txtUsuario").val());//FALTA TERMINAR
					if(res=="desactivado"){
						mensajeUsuarioConProcedimiento('alertMensaje','Confirmar Acción','Atención, El usuario ingresado ya existe pero en estado desactivado, ¿Desea Activarlo Nuevamente?','./controller/server/controlador_usuario.php','usu_nombre='+$("#txtUsuario").val()+'&op=restaurarUsuario','view/interface/busquedaUsuario.php','','#contenidoCargado','modalAgregarUsuario');
						muestraError('errUsuario',"El usuario ingresado ya existe pero está desactivado, vaya al mantenedor y activelo nuevamente.");
					}else{ 
						if(res!=""){ 
							muestraError('errUsuario',res);
							$(this).removeClass("cajabuena" ).addClass( "cajamala" );
						}else{
							a=1;
						}
					}
					
				}else{
					$(this).removeClass("cajabuena" ).addClass( "cajamala" );
					muestraError('errUsuario','Mínimo 4 caracteres, Máximo 15 caracteres');
					a=0;
				}
			}
	});
	
	$("#txtCorreo").blur(function(){
			if( $(this).val().trim()==""){
				$(this).removeClass("cajabuena" ).addClass( "cajamala" );
				muestraError('errCorreo','Rellene los campos');	
				b=0;		
			}else{
				if(validaEmail($(this).val().trim())){					
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
			if( $(this).val().trim()==""){
				$(this).removeClass("cajabuena" ).addClass( "cajamala" );
				muestraError('errNombre','Rellene los campos');
				c=0;		
			}else{
				if($(this).val().trim().length>1 && $(this).val().trim().length<35){
					$(this).val($(this).val().trim());					
					$(this).removeClass("cajamala" );
					c=1;
				}else{
					$(this).removeClass("cajabuena" ).addClass( "cajamala" );
					muestraError('errNombre','Mínimo 2 caracteres, Máximo 35 caracteres');	
					c=0;
				}
			}
			var valor = eliminarEspacio($(this).val());
			$(this).val(valor);
	});

	$("#txtApellidoPaterno").blur(function(){
			if($(this).val().trim()==""){
				$(this).removeClass("cajabuena" ).addClass( "cajamala" );
				muestraError('errApellidoPaterno','Rellene los campos');
				d=0;			
			}else{
				if($(this).val().trim().length>1 && $(this).val().trim().length<35){										
					$(this).removeClass("cajamala" );
					d=1;
				}else{
					$(this).removeClass("cajabuena" ).addClass( "cajamala" );
					muestraError('errApellidoPaterno','Mínimo 2 caracteres, Máximo 35 caracteres');
					d=0;
				}
			}
			var valor = eliminarEspacio($(this).val());
			$(this).val(valor);
	});

	$("#txtApellidoMaterno").blur(function(){
			if( $(this).val().trim()==""){
				$(this).removeClass("cajabuena" ).addClass( "cajamala" );
				muestraError('errApellidoMaterno','Rellene los campos');
				e=0;			
			}else{
				if($(this).val().trim().length>1 && $(this).val().trim().length<35	){					
					$(this).removeClass("cajamala" );
					e=1;
				}else{
					$(this).removeClass("cajabuena" ).addClass( "cajamala" );
					muestraError('errApellidoMaterno','Mínimo 2 caracteres, Máximo 35 caracteres');	
					e=0;
				}
			}
			var valor = eliminarEspacio($(this).val());
			$(this).val(valor);
	});

	$("#txtTelefono").blur(function(){
			if( $(this).val().trim()==""){
				//$(this).removeClass("cajabuena" ).addClass( "cajamala" );
				//muestraError('errTelefono','Rellene los campos');
				g=0;			
			}else{
				if($(this).val().trim().length>4){					
					//$(this).removeClass("cajamala" );
					g=1;
				}else{
					//$(this).removeClass("cajabuena" ).addClass( "cajamala" );
					//muestraError('errTelefono','Ej: 0582554487');
					g=0;	
				}
			}
			var valor = eliminarEspacio($(this).val());
			$(this).val(valor);
	});

	$("#txtDireccion").blur(function(){
			if( $(this).val().trim()==""){
				$(this).removeClass("cajabuena" ).addClass( "cajamala" );
				muestraError('errDireccion','Rellene los campos');
				h=0;			
			}else{
				$(this).removeClass("cajamala" );
				h=1;
			}
			var valor = eliminarEspacio($(this).val());
			$(this).val(valor);
	});

	$("#txtIdentificador").blur(function(){
			if($(this).val().trim()==""){				
				$(this).removeClass("cajabuena" ).addClass( "cajamala" );
				muestraError('errIdentificador','Rellene los campos');
				$('#txtNombre').val("");
				$('#txtApellidoPaterno').val("");
				$('#txtApellidoMaterno').val("");
				$('#txtFechaNacimientos').val("");
				$('#txtTelefono').val("");
				$('#txtDireccion').val("");	
				o=0;			
			}
	});

	$("#txtIdentificador").Rut({
		  on_error: function(){
		  						$("#txtIdentificador").removeClass("cajabuena" ).addClass( "cajamala" );
								 muestraError('errIdentificador','El rut ingresado es incorrecto');
								 o=0;
								 rut=0;
							  },
		  on_success: function(){ //alert("Valido rut")
		  						rut=$.Rut.quitarFormato($("#txtIdentificador").val());
		  						o=1;
		  						rut=$.Rut.quitarFormato($("#txtIdentificador").val());				
									var resUsu2 = validarProcesos('controller/server/controlador_paciente.php','op=buscarPersona&txtRut='+rut);
									if(resUsu2.length>2){
										pacEx=1;
										c=1;
										d=1;
										e=1;
										g=1;
										var resUsu3 = validarProcesos('controller/server/controlador_usuario.php','op=buscarPersona&txtRut='+rut);
										if(resUsu3.length<3){
											var arrExistente = JSON.parse(validarProcesos('controller/server/controlador_paciente.php','op=buscarPersona&txtRut='+rut));												
											$('#txtNombre').val(arrExistente.per_nombre);
											$('#txtApellidoPaterno').val(arrExistente.per_apellidoPaterno);
											$('#txtApellidoMaterno').val(arrExistente.per_apellidoMaterno);
											$('#txtFechaNacimientos').val(arrExistente.per_fechaNacimiento);
											$('#txtTelefono').val(arrExistente.per_telefono);
											if(arrExistente.per_sexo=='m'){
												$("input[name=rdSexo][value=" + arrExistente.per_sexo + "]").attr('checked', 'checked');
											}
											$("#txtIdentificador").removeClass("cajabuena cajamala");	
											$('#errIdentificador').attr("title", "").hide("slow");
											$(this).removeClass("cajabuena cajamala");	
											$('#errIdentificador').attr("title", "").hide("slow");				
											$('#txtDireccion').val(arrExistente.per_direccion);
											$("#txtUsuario").blur();
											$("#txtCorreo").blur();
											$("#txtNombre").blur();
											$("#txtApellidoPaterno").blur();
											$("#txtApellidoMaterno").blur();
											$("#txtDireccion").blur();
											$("#txtApellidoPaterno").focus();
											$("#txtApellidoMaterno").focus();
											$("#txtDireccion").focus();
											$("#txtNombre").focus();
											if($("#txtFechaNacimientos").val()==""){
												$("#txtFechaNacimientos").addClass("cajamala");
												muestraError('errFechaNacimiento','Rellene los campos');
												f=0;	
											}else{
												$("#txtFechaNacimientos").removeClass("cajamala" );
												f=1;
											}
											$('#errFechaNacimiento').removeClass("cajamala");	
											$('#errFechaNacimiento').attr("title", "").hide("slow");
										}
									}else{
										pacEx=0;
									}
		  					    },
		  format_on: 'keyup'

	});

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
	$("#txtUsuario").focus(function(){
		$(this).removeClass("cajabuena cajamala");
		$('#errUsuario').attr("title", "").hide("slow");				
	});

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

	$("#txtIdentificador").focus(function(){
		$(this).removeClass("cajabuena cajamala");	
		$('#errIdentificador').attr("title", "").hide("slow");				
	});
	$("#txtDireccion").focus(function(){
		$(this).removeClass("cajabuena cajamala");	
		$('#errDireccion').attr("title", "").hide("slow");				
	});
	
});

	
	