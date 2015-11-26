$(document).ready(function(){
	$('#btnModificarTipoProducto').button().click(function(){
		var datosEnviar=[];
		var i=0;
		$('#tblUME :input').each(function(){
			datosEnviar[i] = $(this).val(); 
			i++;
		})
		var chk = $('#chkUME').val();
		if($("#txtNombreTipoProducto").val()!=""){
			var res = validarProcesos('./controller/server/controlador_producto.php','tip_descripcion='+$("#txtNombreTipoProducto").val()+'&tip_prod_id='+$("#tip_prod_id").val()+"&op=editarTipo"+"&chkUME="+chk+'&datosE='+datosEnviar);
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
	var contadorId = 0;
	$('#chkUME').click(function(){
		if($('#chkUME').prop('checked')==true){
			contadorId++;
			$('#chkUME').val('1');
			$('<table id="tblUME"></table>').appendTo('#tdUnidadMedidaE');
			$('<tr><td>Nombre UM:</td><td>&nbsp;&nbsp;<input type="text" name="'+contadorId+'" id="'+contadorId+'" /><img src="include/img/Information.png" id="err'+contadorId+'" hidden="true"  /></td><td id="btnNuevaMedidaE" class="btnNuevaMedidaE">&nbsp;&nbsp;<img title="Mas" width="25" height="25" src="./include/img/plus.png" style="cursor: pointer;"/></td></tr>').appendTo('#tblUME');
			$('.btnNuevaMedidaE').click(function(){
				contadorId++;
				$('<tr><td>Nombre UM:</td><td>&nbsp;&nbsp;<input type="text" name="'+contadorId+'" id="'+contadorId+'" /><img src="include/img/Information.png" id="err'+contadorId+'" hidden="true"  /></td><td><td></td></tr>').appendTo('#tblUME');
			});
		}else{
			$('#chkUME').val('0');
			$('#tblUME').remove();
			contadorId = 0;
		}
	});
	tabla('tblUnidadesMedida');
});