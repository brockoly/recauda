$(document).ready(function(){	
	$('#btnModificarTipoProducto').button().click(function(){
		if($("#txtNombreTipoProducto").val()!=""){
			var res = validarProcesos('./controller/server/controlador_producto.php','tip_descripcion='+$("#txtNombreTipoProducto").val()+'&tip_prod_id='+$("#tip_prod_id").val()+"&op=editarTipo");
			if(res=="existe"){
				$("#txtNombreTipoProducto").addClass("cajamala");
				muestraError("errTipoProducto", "Este tipo de producto ya existe");
			}else{
				cargarContenido('./view/dialog/agregarTipoProducto.php','','#modalAgregarProducto');
				mensajeUsuario('successMensaje','Exito','Tipo de producto modificado con exito.');
				$('#modalEditarTipoProducto').dialog('destroy').remove();
			}
		}else{
			$("#txtNombreTipoProducto").addClass("cajamala");
			muestraError("errTipoProducto", "Rellene los campos");
		}
	});	
	$("#txtNombreTipoProducto").focus(function(){
		$(this).removeClass("cajabuena cajamala");	
		$('#errTipoProducto').attr("title", "").hide("slow");				
	});
});