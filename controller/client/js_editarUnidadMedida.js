$(document).ready(function(){
	$('#btnModUnidadMedida').button().click(function(){
		if($("#txtUnidadMedidaE").val()!=""){
			var res = validarProcesos('./controller/server/controlador_unidadMedida.php','uni_nombre='+$("#txtUnidadMedidaE").val()+'uni_nombreAct='+$("#txtUnidadMedidaAct").val()+"&op=buscarUM");
			if(res>0){
				$("#txtUnidadMedidaE").addClass("cajamala");
				muestraError("errUnidadMedidaE", "La unidad de medida ya existe");
			}else{
				validarProcesos('./controller/server/controlador_unidadMedida.php','uni_nombre='+$("#txtUnidadMedidaE").val()+'&uni_id='+$("#txtuni_id").val()+"&op=actualizarUM");
				cargarContenido('./view/dialog/agregarUnidadMedida.php','','#modalAgregarUnidadMedida');
				$('#modalEditarUnidadMedida').dialog('destroy').remove();
				mensajeUsuario('successMensaje','Exito','Unidad de medida modificada correctamente.');
			}
		}else{
			$("#txtUnidadMedidaE").addClass("cajamala");
			muestraError("errUnidadMedidaE", "Rellene los campos");
		}
	});
	$("#txtUnidadMedidaE").focus(function(){
		$(this).removeClass("cajabuena cajamala");	
		$('#errUnidadMedidaE').attr("title", "").hide("slow");				
	});
});