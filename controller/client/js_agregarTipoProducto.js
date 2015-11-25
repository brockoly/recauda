$(document).ready(function(){
	tablaMinima('tblTipoProducto');
	tablaMinima('tblTipoProductoEliminado');
	var contadorId = 0;
	$('#chkUM').click(function(){
		if($('#chkUM').prop('checked')==true){
			contadorId++;
			$('#chkUM').val('1');
			$('<table id="tblUM"></table>').appendTo('#tdUnidadMedida');
			$('<tr><td>Nombre UM:</td><td>&nbsp;&nbsp;<input type="text" name="'+contadorId+'" id="'+contadorId+'" /><img src="include/img/Information.png" id="err'+contadorId+'" hidden="true"  /></td><td id="btnNuevaMedida" class="btnNuevaMedida">&nbsp;&nbsp;<img title="Mas" width="25" height="25" src="./include/img/plus.png" style="cursor: pointer;"/></td></tr>').appendTo('#tblUM');
			$('.btnNuevaMedida').click(function(){
				contadorId++;
				$('<tr><td>Nombre UM:</td><td>&nbsp;&nbsp;<input type="text" name="'+contadorId+'" id="'+contadorId+'" /><img src="include/img/Information.png" id="err'+contadorId+'" hidden="true"  /></td><td><td></td></tr>').appendTo('#tblUM');
			});
		}else{
			$('#chkUM').val('0');
			$('#tblUM').remove();
			contadorId = 0;
		}
	});
	$('#btnAddTipo').button().click(function(){
		var datosEnviar=[];
		var i=0;
		$('#tblUM :input').each(function(){
			datosEnviar[i] = $(this).val(); 
			i++;
		})
		var chk = $('#chkUM').val();
		if($("#tip_descripcion").val()!=""){
			var res = validarProcesos('./controller/server/controlador_producto.php','tip_descripcion='+$("#tip_descripcion").val()+"&chkUM="+chk+"&op=agregarTipo"+'&datos='+datosEnviar);
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

	
	