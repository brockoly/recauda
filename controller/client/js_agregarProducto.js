$(document).ready(function(){	
	validar('txtId', 'id' ,'numero');
	validar('campoValor', 'name' ,'numero')
	var a=0,b=0,c=0,d=0;
	$('#trUnidadMedida').hide();
	$('#btnAddProducto').button().click(function(){
		var arrDatosPre=[];
		var i = 0;
		$('#tblUM :input').each(function() {
			var res = $(this).attr('id');
			var dat = res.split("_");
			var prevision = dat[0];
			var idPre = dat[1];
			arrDatosPre[i] = idPre+'='+$(this).val()+'|'+prevision; 
			i++;
		});
		//alert(arrDatosPre);
		var pro_id = $('#txtId').val(); ;
		var pro_nom = $('#txtDescripcion').val();
		var tip_pro_id = $('#cmbTipoProducto').val();
		if($('#cmbUnidadM').val()=='undefined'){
			var uni_id = 0;
		}else{
			var uni_id = $('#cmbUnidadM').val();
		}
		//alert("a="+a+"b="+b+"c="+c+"d="+d);
		$('#txtId').blur();
		$('#txtDescripcion').blur();
		$('#cmbTipoProducto').blur();
		$('#tblUM :input').each(function() {
			var res = $(this).attr('id');
			$('#'+res).blur();
		});
		if(a==1 && b==1 && c==1 && d==1){
			var res = validarProcesos('controller/server/controlador_producto.php','op=addProducto'+'&datosPre='+arrDatosPre+'&pro_id='+pro_id+'&pro_nom='+pro_nom+'&tip_pro_id='+tip_pro_id+'&uni_id='+uni_id);
			alert(res);
			if(res=='bien'){
				mensajeUsuario('successMensaje','Éxito','Producto agregado exitosamente.');
				cargarContenido('view/interface/busquedaProducto.php','','#contenidoCargado');
				$('#modalAgregarProducto').dialog('destroy').remove();
			}else{
				$('#txtId').blur();
				$('#txtDescripcion').blur();
				$('#cmbTipoProducto').blur();
			}
		}
	});	
	$('#cmbTipoProducto').change(function(){
		if($("#cmbTipoProducto option:selected").val() == 0){
			$('#trUnidadMedida').hide();
			d=1;
		}else{
			$('[name="tdUM"]').remove();
			$('#trUnidadMedida').hide();
			var producto = $("#cmbTipoProducto option:selected").val();
			var res = validarProcesos('controller/server/controlador_producto.php','op=buscarUmTipoProducto'+'&tip_prod_id='+producto);
			if(res>0){
				$('<td name="tdUM">UM:</td><td name="tdUM">&nbsp;&nbsp;&nbsp;<select id="cmbUnidadM" name="cmbUnidadM"><option value="0">Seleccione..</option></select><img src="./include/img/information.png" id="errCmbUm" hidden="true"/></td>').appendTo('#trUnidadMedida');
				$('#trUnidadMedida').show();
				cargarComboAjax('controller/server/controlador_parametros.php','op=cmbUnidadM'+'&tip_prod_id='+producto,'#cmbUnidadM');
				$('#cmbUnidadM').blur(function(){
					if( $(this).val()==0){
						$(this).removeClass("cajabuena" ).addClass( "cajamala" );
						muestraError('#errCmbUm','Seleccione unidad de medida');	
						d=0;		
					}else{
						$(this).removeClass("cajamala" );
						$('#errCmbUm').attr("title", "").hide("slow");
						d=1;
					}
				});
				$('#cmbUnidadM').focus(function(){
					$(this).removeClass("cajamala");	
					$('#errCmbUm').attr("title", "").hide("slow");				
				});
			}else{
				$('[name="tdUM"]').remove();
				$('#trUnidadMedida').hide();
				d=1;
			}
		}
	});
	var i = 0;
	$('#tblUM :input').each(function() {
		var res = $(this).attr('id');
		var dat = res.split("_");
		var prevision = dat[0];
		var idPre = dat[1];
		$('#'+res).blur(function(){
			if( $(this).val()==""){
				$(this).removeClass("cajabuena" ).addClass( "cajamala" );
				muestraError('err'+idPre,'Rellene los campos');	
				d=0;		
			}else{
				$(this).removeClass("cajamala" );
				$('#err'+idPre).attr("title", "").hide("slow");
				d=1;
			}
		});

		$('#'+res).focus(function(){
			$(this).removeClass("cajamala");	
			$('#err'+idPre).attr("title", "").hide("slow");				
		});
		i++;
	});
		
	$('#txtId').blur(function(){
		if( $(this).val()==""){
			$(this).removeClass("cajabuena" ).addClass( "cajamala" );
			muestraError('errId','Rellene los campos');
			a=0;			
		}else{
			var res = validarProcesos('controller/server/controlador_producto.php','op=buscarProducto'+'&pro_id='+$('#txtId').val());
			if(res>0){
				$(this).removeClass("cajabuena" ).addClass( "cajamala" );
				muestraError('errId','El producto ingresado ya existe');
				a=0;
			}else{
				$(this).removeClass("cajamala" );
				a=1;
			}
		}
	});
	$('#txtDescripcion').blur(function(){
		if( $(this).val()==""){
			$(this).removeClass("cajabuena" ).addClass( "cajamala" );
			muestraError('errDescrpcion','Rellene los campos');
			b=0;			
		}else{
			$(this).removeClass("cajamala" );
			b=1;
		}
	});
	$('#cmbTipoProducto').blur(function(){
		if( $(this).val()==0){
			$(this).removeClass("cajabuena" ).addClass( "cajamala" );
			muestraError('errCmbTipoP','Seleccione un tipo de producto');
			c=0;			
		}else{
			$(this).removeClass("cajamala" );
			c=1;
		}
	});

	$("#txtId").focus(function(){
		$(this).removeClass("cajamala");	
		$('#errId').attr("title", "").hide("slow");				
	});
	$("#txtDescripcion").focus(function(){
		$(this).removeClass("cajamala");	
		$('#errDescrpcion').attr("title", "").hide("slow");				
	});
	$("#cmbTipoProducto").focus(function(){
		$(this).removeClass("cajamala");	
		$('#errCmbTipoP').attr("title", "").hide("slow");				
	});
	
});