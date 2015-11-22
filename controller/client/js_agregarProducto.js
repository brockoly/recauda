$(document).ready(function(){	
	$('#btnAddProducto').button().click(function(){
		alert('btnAddProducto');
	});
	$('#btnAddTipo').button().click(function(){
		if($("#tip_descripcion").val()!=""){
			var res = validarProcesos('./controller/server/controlador_producto.php','tip_descripcion='+$("#tip_descripcion").val()+"&op=agregar");
			//alert(res)
			if(res=="existe"){
				$("#tip_descripcion").addClass("cajamala");
				muestraError("errtip_descripcion", "Este tipo de producto ya existe");
			}else{
				cargarContenido('./view/interface/busquedaProducto.php','','#contenidoCargado');
				mensajeUsuario('successMensaje','Exito','Tipo de producto agregado con exito.');
				$('#modalAgregarProducto').dialog('destroy').remove();
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

	
	