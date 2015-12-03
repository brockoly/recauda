$(document).ready(function(){
	validar('txtNombres', 'id','letras');
	validar('txtApellidoPat', 'id' ,'letras');
	validar('txtApellidoMat', 'id' ,'letras');
	validar('txtTelefono', 'id' ,'numero');
	validar('txtDireccion', 'id' ,'todo');
	var a=0, b=0, c=0, d=0, e=0, f=0, g=0, h=0, rut = 0, id = 0, pacEx = 0; /*BANDERAS GLOBALES*/
	
	$("#btnAgregarPacienteModal").button().click(function(){
		if( $("#txtFechaNac").val()==""){
			$("#txtFechaNac").removeClass("cajabuena" ).addClass( "cajamala" );
			muestraError('errFechaNac','Ingrese una Fecha.');
			e=0;			
		}else{				
			$(this).removeClass("cajamala" );
			e=1;
		}
		if(a==1 && b==1 && c==1 && d==1 && e==1 && f==1 && g==1 && h==1){
			var resPac = validarProcesos('controller/server/controlador_paciente.php','op=buscarPaciente&txtRut='+rut+'&txtIdentificador='+id);
			if(resPac ==0){	
				var cont = validarProcesos('controller/server/controlador_paciente.php',$('#frmDatosPaciente').serialize()+'&op=agregarPaciente&rut='+rut+'&pacEx='+pacEx);
				if(cont ='bien'){ 
					mensajeUsuario('successMensaje','Exito','Paciente creado exitosamente');
					cargarContenido('view/interface/busquedaPaciente.php','','#contenidoCargado');
					$('#modalAgregarPaciente').dialog('destroy').remove();
				}else {
					mensajeUsuario('errorMensaje','Error','A ocurrido un problema al momento de agregar paciente');
				}
			}else{
				mensajeUsuario('alertMensaje','Advertencia','El paciente ya se encuentra en nuestros registros');
			}
		}else{
			$('#txtRut').blur();
			$('#txtIdentificador').blur();
			$("#txtNombres").blur();
			$("#txtApellidoPat").blur();
			$("#txtApellidoMat").blur();
			$("#cmbPais").blur();
			$("#cmbPrevision").blur();
			$("#cmbInstitucion").blur();
			$("#txtDireccion").blur();
		}
	});
	$('#cmbPais').change(function(){
		if($("#cmbPais option:selected").val() == 1){

			$('#trIdentificador').show();
			$('#tdRut').remove();
			$('#tdIdentificador').remove();
			$('<td id="tdRut">&nbsp;&nbsp;&nbsp;<input type="text" id="txtRut" name="txtRut" />&nbsp;&nbsp;<img src="./include/img/information.png" id="errRut" hidden="true"/></td>').appendTo('#trIdentificador');
			validar('txtRut', 'id','rut');
			$('#txtRut').Rut({
			   	on_error: function(){  
							$("#txtRut").removeClass("cajabuena" ).addClass( "cajamala" );
							muestraError('errRut','El rut ingresado es incorrecto');
							a=0;
							rut=0;
						  },
	  			on_success: function(){
	  						a=1;	
							rut=$.Rut.quitarFormato($("#txtRut").val());												
							var resUsu2 = validarProcesos('controller/server/controlador_usuario.php','op=buscarPersona&txtRut='+rut); 
							var resPac2 = validarProcesos('controller/server/controlador_paciente.php','op=buscarPaciente&txtRut='+rut+'&txtIdentificador='+id);

							if(resPac2!=0){
								$("#txtRut").removeClass("cajabuena" ).addClass( "cajamala" );
								muestraError('errRut','Identificador ya existente en nuestros registros');
								a=0;			
							}else{
								if(resUsu2.length>2){
									pacEx =1;
									b=1;
									c=1;
									d=1;
									e=1;
									var arrExistente = JSON.parse(validarProcesos('controller/server/controlador_usuario.php','op=buscarPersona&txtRut='+$('#txtRut').val()));							
									$('#txtNombres').val(arrExistente.per_nombre);
									$('#txtApellidoPat').val(arrExistente.per_apellidoPaterno);
									$('#txtApellidoMat').val(arrExistente.per_apellidoMaterno);
									$('#txtFechaNac').val(arrExistente.per_fechaNacimiento);
									$('#txtTelefono').val(arrExistente.per_telefono);
									if(arrExistente.per_sexo=='m'){
										$("input[name=rdSexo][value=" + arrExistente.per_sexo + "]").attr('checked', 'checked');
									}
									$('#txtDireccion').val(arrExistente.per_direccion);
									$("#txtNombres").blur();
									$("#txtApellidoPat").blur();
									$("#txtApellidoMat").blur();
									$("#cmbPais").blur();
									$("#cmbPrevision").blur();
									$("#cmbInstitucion").blur();
									$("#txtDireccion").blur();
									$("#txtNombres").focus();
									$("#txtApellidoPat").focus();
									$("#txtApellidoMat").focus();
									$("#cmbPais").focus();
									$("#txtDireccion").focus();
									
									if( $("#txtFechaNac").val()==""){
										$("#txtFechaNac").removeClass("cajabuena" ).addClass( "cajamala" );
										muestraError('errFechaNac','Ingrese una Fecha.');
										e=0;			
									}else{
										$("#txtFechaNac").removeClass("cajamala");	
										$('#errFechaNac').attr("title", "").hide("slow");	
										e=1;
									}
								}else{
									$(this).removeClass("cajamala" );
									a=1;
								}
							}
							alert(rut)
						
				},
	  			format_on: 'keyup'
			});
			$('#txtRut').blur(function(){
				if( $(this).val().trim()==""){
					$(this).removeClass("cajabuena" ).addClass( "cajamala" );
					muestraError('errRut','Rellene los campos');
					a=0;			
				}
			});
			$("#txtRut").focus(function(){
				$(this).removeClass("cajabuena cajamala");	
				$('#errRut').attr("title", "").hide("slow");				
			});
		}else if ($("#cmbPais option:selected").val() > 1){
			$('#txtNombres').val("");
			$('#txtApellidoPat').val("");
			$('#txtApellidoMat').val("");
			$('#txtFechaNac').val("");
			$('#txtTelefono').val("");
			$('#txtDireccion').val("");
			$('#trIdentificador').show();
			$('#tdIdentificador').remove();
			$('#tdRut').remove();
			$('<td id="tdIdentificador">&nbsp;&nbsp;&nbsp;<input type="text" id="txtIdentificador" name="txtIdentificador" />&nbsp;&nbsp;<img src="./include/img/information.png" id="errRut" hidden="true"/></td>').appendTo('#trIdentificador');
			$('#txtIdentificador').blur(function(){
				var valor = eliminarEspacio($(this).val());
				$(this).val(valor);
				if( $(this).val().trim()==""){
					$(this).removeClass("cajabuena" ).addClass( "cajamala" );
					muestraError('errRut','Rellene los campos');
					a=0;			
				}else{
					id = $('#txtIdentificador').val();
					rut=-1;
					var resPac = validarProcesos('controller/server/controlador_paciente.php','op=buscarPaciente&txtRut='+rut+'&txtIdentificador='+id);
					if(resPac==0){
						$(this).removeClass("cajabuena cajamala");	
						$('#errRut').attr("title", "").hide("slow");
						a=1;
					}else{
						$(this).removeClass("cajabuena" ).addClass( "cajamala" );
						muestraError('errRut','El identificador ya se encuentra en nuestros registros');
					}	
					
				}
				$(this).val($(this).val().trim());
			});
			$('#txtIdentificador').focus(function(){
				$(this).removeClass("cajabuena cajamala");	
				$('#errRut').attr("title", "").hide("slow");				
			});
		}
	});
	$('#cmbPrevision').change(function(){
		if($("#cmbPrevision option:selected").val() == 0){
			$('#trInstitucion').hide();
		}else{
			$('#trInstitucion').show();
			var prevision = $("#cmbPrevision option:selected").val();
			cargarComboAjax('controller/server/controlador_parametros.php','op=cmbInstitucion'+'&pre_id='+prevision,'#cmbInstitucion');
		}
	});
	/*VALIDACIONES ONBLUR ------------*/
	$("#cmbPais").blur(function(){
		if( $(this).val()==0){
			$(this).removeClass("cajabuena" ).addClass( "cajamala" );
			muestraError('errcmbPais','Seleccione país');
			a=0;			
		}else{
			$(this).removeClass("cajamala" );
			a=1;
		}
	});
	$("#cmbInstitucion").blur(function(){
		if( $(this).val()==0){
			$(this).removeClass("cajabuena" ).addClass( "cajamala" );
			muestraError('errcmbInstitucion','Seleccione institucón');
			g=0;			
		}else{
			$(this).removeClass("cajamala" );
			g=1;
		}
	});
	$("#cmbPrevision").blur(function(){
		if( $(this).val()==0){
			$(this).removeClass("cajabuena" ).addClass( "cajamala" );
			muestraError('errcmbPrevision','Seleccione previsión');
			f=0;			
		}else{
			$(this).removeClass("cajamala" );
			f=1;
		}
	});
	$("#txtNombres").blur(function(){
		var valor = eliminarEspacio($(this).val());
		$(this).val(valor);
		if( $(this).val().trim()==""){
			$(this).removeClass("cajabuena" ).addClass( "cajamala" );
			muestraError('errNombres','Rellene los campos');
			b=0;			
		}else{
			if($(this).val().length>1 && $(this).val().length<35){					
				$(this).removeClass("cajamala" );
				b=1;
			}else{
				$(this).removeClass("cajabuena" ).addClass( "cajamala" );
				muestraError('errNombres','Mínimo 2 caracteres, Máximo 35 caracteres');
				b=0;
			}
		}		
	});
	$("#txtApellidoPat").blur(function(){
		var valor = eliminarEspacio($(this).val());
		$(this).val(valor);
		if( $(this).val().trim()==""){
			$(this).removeClass("cajabuena" ).addClass( "cajamala" );
			muestraError('errApellidoPat','Rellene los campos');
			c=0;			
		}else{
			if($(this).val().length>1 && $(this).val().length<35){					
				$(this).removeClass("cajamala" );
				c=1;
			}else{
				$(this).removeClass("cajabuena" ).addClass( "cajamala" );
				muestraError('errApellidoPat','Mínimo 2 caracteres, Máximo 35 caracteres');
				c=0;
			}
		}		
	});

	$("#txtApellidoMat").blur(function(){
		var valor = eliminarEspacio($(this).val());
		$(this).val(valor);
		if( $(this).val().trim()==""){
			$(this).removeClass("cajabuena" ).addClass( "cajamala" );
			muestraError('errApellidoMat','Rellene los campos');
			d=0;			
		}else{
			if($(this).val().length>1 && $(this).val().length<35){					
				$(this).removeClass("cajamala" );
				d=1;
			}else{
				$(this).removeClass("cajabuena" ).addClass( "cajamala" );
				muestraError('errApellidoMat','Mínimo 2 caracteres, Máximo 35 caracteres');
				d=0;
			}
		}		
	});
	$("#txtDireccion").blur(function(){
			var valor = eliminarEspacio($(this).val());
			$(this).val(valor);
			if( $(this).val().trim()==""){
				$(this).removeClass("cajabuena" ).addClass( "cajamala" );
				muestraError('errDireccion','Rellene los campos');
				h=0;			
			}else{
				$(this).removeClass("cajamala" );
				h=1;
			}
	});
	/*VALIDACIONES ONFOCUS ------------------------------*/
	$("#txtNombres").focus(function(){
		$(this).removeClass("cajabuena cajamala");	
		$('#errNombres').attr("title", "").hide("slow");				
	});
	$("#txtApellidoPat").focus(function(){
		$(this).removeClass("cajabuena cajamala");	
		$('#errApellidoPat').attr("title", "").hide("slow");				
	});
	$("#txtApellidoMat").focus(function(){
		$(this).removeClass("cajabuena cajamala");	
		$('#errApellidoMat').attr("title", "").hide("slow");				
	});
	$("#txtFechaNac").focus(function(){
		$(this).removeClass("cajabuena cajamala");	
		$('#errFechaNac').attr("title", "").hide("slow");				
	});
	$("#txtTelefono").focus(function(){
		$(this).removeClass("cajabuena cajamala");	
		$('#errTelefono').attr("title", "").hide("slow");				
	});
	$("#cmbPais").focus(function(){
		$(this).removeClass("cajabuena cajamala");	
		$('#errcmbPais').attr("title", "").hide("slow");				
	});
	$("#cmbInstitucion").focus(function(){
		$(this).removeClass("cajabuena cajamala");	
		$('#errcmbInstitucion').attr("title", "").hide("slow");				
	});
	$("#cmbPrevision").focus(function(){
		$(this).removeClass("cajabuena cajamala");	
		$('#errcmbPrevision').attr("title", "").hide("slow");				
	});
	$("#txtDireccion").focus(function(){
		$(this).removeClass("cajabuena cajamala");	
		$('#errDireccion').attr("title", "").hide("slow");				
	});
});