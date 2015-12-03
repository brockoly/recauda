$(document).ready(function(){

	q=1;w=1;
	$('#btnModificarTipoProducto').button().click(function(){
		var datosEnviar=[];
		var i = 0;
		var chk = $('#tblUME').find('input[type="checkbox"]:checked').each(function () {
	       	datosEnviar[i] = $(this).val(); 
	       	i++;
   		});
		if(q!=0 && w!=0){
			var res = validarProcesos('./controller/server/controlador_tipoProducto.php','tip_descripcion='+$("#txtNombreTipoProducto").val()+'&tip_prod_id='+$("#txtCodigoTipoProducto").val()+"&op=editarTipo"+'&datosE='+datosEnviar+'&idoriginal='+$("#tip_prod_idOriginal").val()+'&desoriginal='+$("#tip_descripcionOriginal").val());
			if(res=="nombreExiste"){
				$("#txtNombreTipoProducto").addClass("cajamala");
				muestraError("errTipoProducto", "Este nombre de producto ya existe");
			}else if(res=="codigoExiste"){
				$("#txtCodigoTipoProducto").addClass("cajamala");
				muestraError("errCodigoTipoProducto", "Este código de producto ya existe");
			}else if(res=="nombreCodigoExiste"){
				$("#txtNombreTipoProducto").addClass("cajamala");
				muestraError("errTipoProducto", "Este nombre de producto ya existe");
				$("#txtCodigoTipoProducto").addClass("cajamala");
				muestraError("errCodigoTipoProducto", "Este código de producto ya existe");
			}else{
				cargarContenido('./view/dialog/agregarTipoProducto.php','','#modalAgregarTipoProducto');
				mensajeUsuario('successMensaje','Exito','Tipo de producto modificado con exito.');
				$('#modalEditarTipoProducto').dialog('destroy').remove();
			}
		}else{
			$("#txtCodigoTipoProducto").blur();
			$("#txtNombreTipoProducto").blur();
		}
	});	

	$("#txtCodigoTipoProducto").blur(function(){
		if($("#txtCodigoTipoProducto").val()==""){
			$(this).removeClass("cajabuena").addClass("cajamala");	
			muestraError("errCodigoTipoProducto", "Ingrese un código.");
			q=0;					
		}else{
			$(this).removeClass("cajamala");	
			$('#errCodigoTipoProducto').attr("title", "").hide("slow");
			q=1;
		}		
	});


	$("#txtNombreTipoProducto").blur(function(){
		if($("#txtNombreTipoProducto").val()==""){
			$(this).removeClass("cajabuena").addClass("cajamala");	
			muestraError("errTipoProducto", "Ingrese un nombre.");
			w=0;					
		}else{
			$(this).removeClass("cajamala");	
			$('#errTipoProducto').attr("title", "").hide("slow");
			w=1;
		}		
	});

	$("#txtCodigoTipoProducto").focus(function(){
		$(this).removeClass("cajabuena cajamala");	
		$('#errCodigoTipoProducto').attr("title", "").hide("slow");				
	});

	$("#txtNombreTipoProducto").focus(function(){
		$(this).removeClass("cajabuena cajamala");	
		$('#errTipoProducto').attr("title", "").hide("slow");				
	});
	tabla('tblUnidadesMedida');
});