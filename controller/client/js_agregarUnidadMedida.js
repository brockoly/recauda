$(document).ready(function(){
	tablaMinima('tblUnidadMedida');
	tablaMinima('tblUnidadMedidaEliminada');
	validar('txtDesUnidad', 'id' ,'letras');
	var a=0;
	$('#btnAddUnidad').button().click(function(){
		$("#txtDesUnidad").blur();
		if(a==1){
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
		$('#errUnidadMedidaE').attr("title", "").hide("slow");				
	});
	$("#txtDesUnidad").blur(function(){
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

	
	