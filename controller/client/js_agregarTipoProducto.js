$(document).ready(function(){
	tablaMinima('tblTipoProducto');
	tablaMinima('tblTipoProductoEliminado');
	
	$('#btnAddTipo').button().click(function(){
		var arrDatosUM=[];
		var i = 0;
		var chk = $('#tblUM').find('input[type="checkbox"]:checked').each(function () {
	       	arrDatosUM[i] = $(this).val(); 
	       	i++;
   		});
		//alert(arrDatosUM); 
		if($("#tip_descripcion").val()!=""){
			var res = validarProcesos('./controller/server/controlador_tipoProducto.php','tip_descripcion='+$("#tip_descripcion").val()+"&op=agregarTipo"+'&datos='+arrDatosUM);
			alert(res);
			if(res=="existe"){
				$("#tip_descripcion").addClass("cajamala");
				muestraError("errtip_descripcion", "Este tipo de producto ya existe");
			}else{
				cargarContenido('./view/dialog/agregarTipoProducto.php','','#modalAgregarProducto');
				mensajeUsuario('successMensaje','Exito','Tipo de producto agregado con exito.');
			}
		}else{
			$("#tip_descripcion").addClass("cajamala");
			muestraError("errtip_descripcion", "Rellene los campos");
		}
	});
	$("#tip_descripcion").focus(function(){
		$(this).removeClass("cajabuena cajamala");	
		$('#errtip_descripcion').attr("title", "").hide("slow");				
	});
	
});

	
	