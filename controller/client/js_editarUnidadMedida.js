$(document).ready(function(){
	validar('txtUnidadMedidaE', 'id' ,'letras');
	var a=0;
	$('#btnModUnidadMedida').button().click(function(){
		$("#txtUnidadMedidaE").blur();
		if(a==1){
			var res = validarProcesos('./controller/server/controlador_unidadMedida.php','uni_nombre='+$("#txtUnidadMedidaE").val()+'&uni_nombreAct='+$("#txtUnidadMedidaAct").val()+"&op=buscarUM");
			if(res>0){
				$("#txtUnidadMedidaE").addClass("cajamala");
				muestraError("errUnidadMedidaE", "La unidad de medida ya existe");
			}else{
				validarProcesos('./controller/server/controlador_unidadMedida.php','uni_nombre='+$("#txtUnidadMedidaE").val()+'&uni_id='+$("#txtuni_id").val()+"&op=actualizarUM");
				cargarContenido('./view/dialog/agregarUnidadMedida.php','','#modalAgregarUnidadMedida');
				$('#modalEditarUnidadMedida').dialog('destroy').remove();
				mensajeUsuario('successMensaje','Exito','Unidad de medida modificada correctamente.');
			}
		}
	});
	$("#txtUnidadMedidaE").focus(function(){
		$(this).removeClass("cajabuena cajamala");	
		$('#errUnidadMedidaE').attr("title", "").hide("slow");				
	});
	$("#txtUnidadMedidaE").blur(function(){
		var valor = eliminarEspacio($(this).val());
		$(this).val(valor);	
		if($(this).val()==""){
			muestraError("errUnidadMedidaE", "Rellene los campos");	
			$(this).addClass("cajamala");
			a=0;			
		}else{			
			$('#errUnidadMedidaE').attr("title", "").hide("slow");
			$(this).removeClass("cajabuena cajamala");
			a=1;
		}
				
	});
	
});