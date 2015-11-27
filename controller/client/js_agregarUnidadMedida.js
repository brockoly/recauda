$(document).ready(function(){
	tablaMinima('tblUnidadMedida');
	tablaMinima('tblUnidadMedidaEliminada');

	$('#btnAddUnidad').button().click(function(){
		if($("#txtDesUnidad").val()!=""){
			var res = validarProcesos('./controller/server/controlador_unidadMedida.php','uni_nombre='+$("#txtDesUnidad").val()+"&op=buscarUM");
		//	alert(res);
			if(res>0){
				$("#txtDesUnidad").addClass("cajamala");
				muestraError("errUnidadDes", "La unidad de medida ya existe");
			}else{
				validarProcesos('./controller/server/controlador_unidadMedida.php','uni_nombre='+$("#txtDesUnidad").val()+"&op=agregarUM");
				cargarContenido('./view/dialog/agregarUnidadMedida.php','','#modalAgregarUnidadMedida');
				mensajeUsuario('successMensaje','Exito','Unidad de medida agregada correctamente.');
			}
		}else{
			$("#txtDesUnidad").addClass("cajamala");
			muestraError("errUnidadDes", "Rellene los campos");
		}
	});
	$("#txtDesUnidad").focus(function(){
		$(this).removeClass("cajabuena cajamala");	
		$('#errUnidadDes').attr("title", "").hide("slow");				
	});
	
});

	
	