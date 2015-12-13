$(document).ready(function(){
	validar('tip_descripcion', 'id' ,'letras')
	tablaMinima('tblTipoProducto');
	tablaMinima('tblTipoProductoEliminado');
	validar('tip_prod_id','id','numero');
	validar('tip_descripcion','id','tipoProd');

	q=0;w=0;
	$('#btnAddTipo').button().click(function(){
		var arrDatosUM=[];
		var i = 0;
		var chk = $('#tblUM').find('input[type="checkbox"]:checked').each(function () {
	       	arrDatosUM[i] = $(this).val(); 
	       	i++;
   		});
		//alert(arrDatosUM);
		var valor = eliminarEspacio($("#tip_descripcion").val());
		$("#tip_descripcion").val(valor);
		if($("#tip_descripcion").val()!=""){
			var res = validarProcesos('./controller/server/controlador_tipoProducto.php','tip_descripcion='+$("#tip_descripcion").val()+"&op=agregarTipo"+'&datos='+arrDatosUM);
			if(res=="existe"){
				//alert(arrDatosUM); 
				if(q!=0 && w!=0){
					var res = validarProcesos('./controller/server/controlador_tipoProducto.php','tip_descripcion='+$("#tip_descripcion").val()+"&op=agregarTipo"+'&datos='+arrDatosUM+'&tip_prod_id='+$("#tip_prod_id").val());
					if(res=="nombreExiste"){
						$("#tip_descripcion").addClass("cajamala");
						muestraError("errtip_descripcion", "Este nombre de producto ya existe");
					}else if(res=="codigoExiste"){
						$("#tip_prod_id").addClass("cajamala");
						muestraError("errTip_prod_id", "Este código de producto ya existe");
					}else{
						cargarContenido('./view/dialog/agregarTipoProducto.php','','#modalAgregarTipoProducto');
						mensajeUsuario('successMensaje','Éxito','Tipo de producto agregado con éxito.');
					}
				}else{
					$("#tip_prod_id").blur();
					$("#tip_descripcion").blur();
				}
			}
		}
	});



	$("#tip_prod_id").blur(function(){
		if($("#tip_prod_id").val()==""){
			$(this).removeClass("cajabuena").addClass("cajamala");	
			muestraError("errTip_prod_id", "Ingrese un código.");
			q=0;					
		}else{
			$(this).removeClass("cajamala");	
			$('#errTip_prod_id').attr("title", "").hide("slow");
			q=1;
		}		
	});


	$("#tip_descripcion").blur(function(){
		if($("#tip_descripcion").val()==""){
			$(this).removeClass("cajabuena").addClass("cajamala");	
			muestraError("errtip_descripcion", "Ingrese un nombre.");
			w=0;					
		}else{
			$(this).removeClass("cajamala");	
			$('#errtip_descripcion').attr("title", "").hide("slow");
			w=1;
		}		
	});

	$("#tip_descripcion").focus(function(){
		$(this).removeClass("cajabuena cajamala");	
		$('#errtip_descripcion').attr("title", "").hide("slow");				
	});

	$("#tip_prod_id").focus(function(){
		$(this).removeClass("cajabuena cajamala");	
		$('#errtip_descripcion').attr("title", "").hide("slow");				
	});
});

	
	