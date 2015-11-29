$(document).ready(function(){
	validar('txtNombres', 'id','letras');
	var a=0, b=0, c=0, d=0, e=0, f=0,g=0, rut = 0, id = 0, pacEx = 0; /*BANDERAS GLOBALES*/
	calendario('txtFechaNac');
	$("#btnAgregarPacienteModal").button().click(function(){
		if( $("#txtFechaNac").val()==""){
			$("#txtFechaNac").removeClass("cajabuena" ).addClass( "cajamala" );
			muestraError('errFechaNac','Ingrese una Fecha.');
			e=0;			
		}else{				
			$(this).removeClass("cajamala" );
			e=1;
		}
		if(a==1 && b==1 && c==1 && d==1 && e==1 && f==1 && g==1){
			var resPac = validarProcesos('controller/server/controlador_paciente.php','op=buscarPaciente&txtRut='+rut+'&txtIdentificador='+id);
			if(resPac ==0){
				if(pacEx == 0){


				}
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
			$("#txtApellidoPat").blur();
			$("#txtApellidoMat").blur();
			$("#cmbPais").blur();
			$("#cmbPrevision").blur();
			$("#cmbInstitucion").blur();
			mensajeUsuario('alertMensaje','Advertencia','Complete los campos solicitados');
		}
	});
	$('#cmbPais').change(function(){
		if($("#cmbPais option:selected").text() == 'Chile'){
			$('#trIdentificador').show();
			$('#tdRut').remove();
			$('#tdIdentificador').remove();
			$('<td id="tdRut">&nbsp;&nbsp;&nbsp;<input type="text" id="txtRut" name="txtRut" />&nbsp;&nbsp;<img src="./include/img/information.png" id="errRut" hidden="true"/></td>').appendTo('#trIdentificador');
			$('#txtRut').Rut({
			   	on_error: function(){  
							$("#txtRut").removeClass("cajabuena" ).addClass( "cajamala" );
							muestraError('errRut','El rut ingresado es incorrecto');
							a=0;
							rut=0;
						  },
	  			on_success: function(){ 
							rut=$.Rut.quitarFormato($("#txtRut").val());
							a=1;
							},
	  			format_on: 'keyup'
			});
			$('#txtRut').blur(function(){
				if( $(this).val()==""){
					$(this).removeClass("cajabuena" ).addClass( "cajamala" );
					muestraError('errRut','Rellene los campos');
					a=0;			
				}else{
					if(a==1){						
						var resUsu2 = validarProcesos('controller/server/controlador_usuario.php','op=buscarPersona&txtRut='+rut); 
						var resPac2 = validarProcesos('controller/server/controlador_paciente.php','op=buscarPaciente&txtRut='+rut+'&txtIdentificador='+id);
						if(resPac2!=0){
							$(this).removeClass("cajabuena" ).addClass( "cajamala" );
							muestraError('errRut','Identificador ya existente');
							a=0;			
						}else if(resUsu2.length>2){
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
						}else{
							$(this).removeClass("cajamala" );
							a=1;
						}
					}
				}
			});
			$("#txtRut").focus(function(){
				$(this).removeClass("cajabuena cajamala");	
				$('#errRut').attr("title", "").hide("slow");				
			});
		}else if ($("#cmbPais option:selected").val() > 1){
			$('#trIdentificador').show();
			$('#tdIdentificador').remove();
			$('#tdRut').remove();
			$('<td id="tdIdentificador">&nbsp;&nbsp;&nbsp;<input type="text" id="txtIdentificador" name="txtIdentificador" />&nbsp;&nbsp;<img src="./include/img/information.png" id="errRut" hidden="true"/></td>').appendTo('#trIdentificador');
			$('#txtIdentificador').blur(function(){
			if( $(this).val()==""){
				$(this).removeClass("cajabuena" ).addClass( "cajamala" );
				muestraError('errRut','Rellene los campos');
				a=0;			
			}else{		
				$(this).removeClass("cajamala" );
				id = $('#txtIdentificador').val();
				a=1;
			}
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
		if( $(this).val()==""){
			$(this).removeClass("cajabuena" ).addClass( "cajamala" );
			muestraError('errNombres','Rellene los campos');
			b=0;			
		}else{
			if($(this).val().length>3 && $(this).val().length<16){					
				$(this).removeClass("cajamala" );
				b=1;
			}else{
				$(this).removeClass("cajabuena" ).addClass( "cajamala" );
				muestraError('errNombres','Mínimo 4 caracteres, Máximo 15 caracteres');
				b=0;
			}
		}
	});
	$("#txtApellidoPat").blur(function(){
		if( $(this).val()==""){
			$(this).removeClass("cajabuena" ).addClass( "cajamala" );
			muestraError('errApellidoPat','Rellene los campos');
			c=0;			
		}else{
			if($(this).val().length>3 && $(this).val().length<16){					
				$(this).removeClass("cajamala" );
				c=1;
			}else{
				$(this).removeClass("cajabuena" ).addClass( "cajamala" );
				muestraError('errApellidoPat','Mínimo 4 caracteres, Máximo 15 caracteres');
				c=0;
			}
		}
	});
	$("#txtApellidoMat").blur(function(){
		if( $(this).val()==""){
			$(this).removeClass("cajabuena" ).addClass( "cajamala" );
			muestraError('errApellidoMat','Rellene los campos');
			d=0;			
		}else{
			if($(this).val().length>3 && $(this).val().length<16){					
				$(this).removeClass("cajamala" );
				d=1;
			}else{
				$(this).removeClass("cajabuena" ).addClass( "cajamala" );
				muestraError('errApellidoMat','Mínimo 4 caracteres, Máximo 15 caracteres');
				d=0;
			}
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
});