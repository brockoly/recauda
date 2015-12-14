$(document).ready(function(){
	validar('txtNombres', 'id','letras');
	validar('txtApellidoPat', 'id' ,'letras');
	validar('txtApellidoMat', 'id' ,'letras');
	validar('txtTelefono', 'id' ,'numero');
	validar('txtDireccion', 'id' ,'todo');
	var a=1, b=1, c=1, d=1, e=1, f=1, g=1, h=1, rut = 1, id = 1, pacEx = 1; 

	if($('#naci_id').val()==1){
		var o=0;
		$("#txtIdentificador").Rut({
		  on_error: function(){
			  						 $("#txtIdentificador").removeClass("cajabuena" ).addClass( "cajamala" );
									 muestraError('errIdentificador','El rut ingresado es incorrecto');
									 o=0;
									 rut=0;
							  },
		  on_success: function(){ //alert("Valido rut")
			  						 rut=$.Rut.quitarFormato($("#txtIdentificador").val())
			  						 var resUsu2 = validarProcesos('controller/server/controlador_paciente.php','op=buscarPersona&txtRut='+rut);
			  						 if(resUsu2.length>2){
			  						 	$("#txtIdentificador").removeClass("cajabuena" ).addClass( "cajamala" );
										muestraError('errIdentificador','El rut ingresado es ya está en nuestro registros.');
										o=0;
			  						 }else{
			  						 	var resUsu3 = validarProcesos('controller/server/controlador_usuario.php','op=buscarPersona&txtRut='+rut);
			  						 	if(resUsu3.length>2){
			  						 		$("#txtIdentificador").removeClass("cajabuena" ).addClass( "cajamala" );
											muestraError('errIdentificador','El rut ingresado es ya está en nuestro registros.');
											o=0;
			  						 	}else{
			  						 	 	$('#txtIdentificador').removeClass("cajabuena cajamala");	
									 	    $('#errIdentificador').attr("title", "").hide("slow");
									 	    o=1
			  						 	}			  						 	
			  						 }
			  						 		
								},
		  format_on: 'keyup'
		});
	}else{
		if (typeof($('#naci_id').val()) === "undefined") {
    		//alert("objetoso no esta definido.");
		}else{
			var o=0;
			$('#txtIdentificador').blur(function(){
				var valor = eliminarEspacio($(this).val());
				$(this).val(valor);
				if( $(this).val().trim()==""){
					$(this).removeClass("cajabuena" ).addClass( "cajamala" );
					muestraError('errIdentificador','Rellene los campos');
					o=0;			
				}else{
						id = $('#txtIdentificador').val();
						rut=-1;
						var resPac = validarProcesos('controller/server/controlador_paciente.php','op=buscarPaciente&txtRut='+rut+'&txtIdentificador='+id);
						if(resPac==0){
							$(this).removeClass("cajabuena cajamala");	
							$('#errIdentificador').attr("title", "").hide("slow");
							o=1;
						}else{
							$(this).removeClass("cajabuena" ).addClass( "cajamala" );
							muestraError('errIdentificador','El identificador ya se encuentra en nuestros registros');
							o=0;
						}
				}
				$(this).val($(this).val().trim());
			});
		}
	}
	$('#btnEditarPaciente').button().click(function(){
		if( $("#txtFechaNac").val()==""){
			$("#txtFechaNac").removeClass("cajabuena" ).addClass( "cajamala" );
			muestraError('errFechaNac','Ingrese una Fecha.');
			e=0;			
		}else{				
			$(this).removeClass("cajamala" );
			e=1;
		}
		if(a==1 && b==1 && c==1 && d==1 && e==1 && f==1 && g==1 && h==1){
			//alert("Paciente");
			var cont = validarProcesos('controller/server/controlador_paciente.php',$('#frmDatosPaciente').serialize()+'&op=modificarPaciente');
			if(cont=='bien'){
				mensajeUsuario('successMensaje','Exito','Paciente modificado exitosamente');
				cargarContenido('view/interface/busquedaPaciente.php','','#contenidoCargado');
				$('#modalEditarPaciente').dialog('destroy').remove();
			}			
			
		}else{
			$("#txtNombres").blur();
			$("#txtApellidoPat").blur();
			$("#txtApellidoMat").blur();
			$("#cmbPais").blur();
			$("#cmbPrevision").blur();
			$("#cmbInstitucion").blur();
			$("#txtDireccion").blur();
		}
	});

	$('#btnEditarPacienteRN').button().click(function(){
		if( $("#txtFechaNac").val()==""){
			$("#txtFechaNac").removeClass("cajabuena" ).addClass( "cajamala" );
			muestraError('errFechaNac','Ingrese una Fecha.');
			e=0;			
		}else{				
			$(this).removeClass("cajamala" );
			e=1;
		}
		if(a==1 && b==1 && c==1 && d==1 && e==1 && f==1 && g==1 && h==1){
			//alert("RN");
			if(o==1){
				var cont = validarProcesos('controller/server/controlador_paciente.php',$('#frmDatosPaciente').serialize()+'&op=modificarPaciente&rn=R.N');
				//alert(cont)
				if(cont=='bien'){
					mensajeUsuario('successMensaje','Exito','Paciente modificado exitosamente');
					cargarContenido('view/interface/busquedaPaciente.php','','#contenidoCargado');
					$('#modalEditarPaciente').dialog('destroy').remove();
				}			
			}
			
		}else{
			$("#txtNombres").blur();
			$("#txtApellidoPat").blur();
			$("#txtApellidoMat").blur();
			$("#cmbPais").blur();
			$("#cmbPrevision").blur();
			$("#cmbInstitucion").blur();
			$("#txtDireccion").blur();
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
		if( $(this).val()==""){
			$(this).removeClass("cajabuena" ).addClass( "cajamala" );
			muestraError('errNombres','Rellene los campos');
			b=0;			
		}else{
			if($(this).val().length>1 && $(this).val().length<36){					
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
		if( $(this).val()==""){
			$(this).removeClass("cajabuena" ).addClass( "cajamala" );
			muestraError('errApellidoPat','Rellene los campos');
			c=0;			
		}else{
			if($(this).val().length>1 && $(this).val().length<36){					
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
		if( $(this).val()==""){
			$(this).removeClass("cajabuena" ).addClass( "cajamala" );
			muestraError('errApellidoMat','Rellene los campos');
			d=0;			
		}else{
			if($(this).val().length>1 && $(this).val().length<36){					
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
		if( $(this).val()==""){
			$(this).removeClass("cajabuena" ).addClass( "cajamala" );
			muestraError('errDireccion','Rellene los campos');
			h=0;			
		}else{
			$(this).removeClass("cajamala" );
			h=1;
		}
	});

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

	
	