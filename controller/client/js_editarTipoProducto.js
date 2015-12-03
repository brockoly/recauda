$(document).ready(function(){
	validar('txtNombreTipoProducto', 'id' ,'letras')
	$('#btnModificarTipoProducto').button().click(function(){
		var datosEnviar=[];
		var i = 0;
		var chk = $('#tblUME').find('input[type="checkbox"]:checked').each(function () {
	       	datosEnviar[i] = $(this).val(); 
	       	i++;
   		});
   		var valor = eliminarEspacio($("#txtNombreTipoProducto").val());
		$("#txtNombreTipoProducto").val(valor);
		if($("#txtNombreTipoProducto").val()!=""){
			var res = validarProcesos('./controller/server/controlador_tipoProducto.php','tip_descripcion='+$("#txtNombreTipoProducto").val()+'&tip_prod_id='+$("#tip_prod_id").val()+"&op=editarTipo"+'&datosE='+datosEnviar);
			if(res=="existe"){
				$("#txtNombreTipoProducto").addClass("cajamala");
				muestraError("errTipoProducto", "Este tipo de producto ya existe");
			}else{
				cargarContenido('./view/dialog/agregarTipoProducto.php','','#modalAgregarTipoProducto');
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
	tabla('tblUnidadesMedida');
});