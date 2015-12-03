$(document).ready(function(){
	tooltipImg('candadoCerrado', 'Editar Valores');
	validar('valores', 'class' ,'numero');
	var a=0;
	$("#imgCandado").attr("src","./include/img/candado_cerrado.png");
	$("#imgCandado").click(function(){
		if(a==0){ //ABRIR
			tooltipImg('candadoCerrado', 'Terminar Edición');;
			$("#imgCandado").attr("src","./include/img/candado_abierto.png");
			$("#imgCandado").attr('width','30');
			$('[name="txtValor"]').attr("readonly",false);
			$('[name="txtValor"]').css("background","#FFFFFF");
			
			a=1;
		}else{ //CERRAR
			tooltipImg('candadoCerrado', 'Editar Valores');
			$("#imgCandado").attr("src","./include/img/candado_cerrado.png");
			$("#imgCandado").attr('width','25');
			$('[name="txtValor"]').attr("readonly",true);
			$('[name="txtValor"]').css("background","none");
			var subtotal = 0;
			var subtotal2 = 0;
			$('#tblValorizacion  [name="txtValor"]').each(function(){
				var idVal = $(this).attr('id');
				var val = $(this).val();
				var cantidad = $('#txtCantidad'+idVal).val();
				var total = cantidad * val;
				$('#txtValorT'+idVal).val(total);
				total = subtotal2 + total;

				subtotal = subtotal + total;
				$('#txtTotal').val(subtotal);
				var idSub = $('#txtSubtotal'+idVal).attr('name');
				if(idVal == idSub){
					$('#txtSubtotal'+idVal).val(total);
				}
			});
			a=0;
		}
	});
	$('#btnGuardarValorizacion').button().click(function(){		
		if(a==0){
			$('#tblValorizacion  [name="txtValor"]').each(function(){
				var idVal = $(this).attr('id');
				var val = $(this).val();
				var cantidad = $('#txtCantidad'+idVal).val();
				var total = cantidad * val;
				var prevision = $('#txtPrevisionId').val();
				var res = validarProcesos('./controller/server/controlador_valorizar.php','pro_id='+idVal+'&op=actualizarValor'+'&val_monto='+val+'&pss_id='+$('#pss_id').val()+'&pss_saldo='+$('#txtTotal').val());
			});
			mensajeUsuario('successMensaje','Éxito','Valores actualizados con exito.');
			$('#modalValorizarPss').dialog('destroy').remove();
		}else{
			mensajeUsuario('alertMensaje','Error','Porfavor termine de editar los valores.');
		}
	});

	$('#btnGuardarVCambEsta').button().click(function(){
		var cmbInst = $('#cmbInstitucionVal option:selected').val();
		if(cmbInst==0){
			mensajeUsuario('alertMensaje','Advertencia','Porfavor seleccione una institución.');
		}else{
			if(a==0){
				var totalPrograma = 0;
				$('#tblValorizacion  [name="txtValor"]').each(function(){
					var idVal = $(this).attr('id');
					var val = $(this).val();
					var cantidad = $('#txtCantidad'+idVal).val();
					var total = cantidad * val;
					totalPrograma = totalPrograma + total; 
					var prevision = $('#txtPrevisionId').val();
					var res = validarProcesos('./controller/server/controlador_valorizar.php','pro_id='+idVal+'&op=actualizarValor'+'&val_monto='+val+'&pss_id='+$('#pss_id').val()+'&pss_saldo='+$('#txtTotal').val());
				});
				var cambiarEstado = validarProcesos('./controller/server/controlador_pss.php','pss_id='+$('#pss_id').val()+'&op=valorizarPss&total='+totalPrograma);
				var guardarInst = validarProcesos('./controller/server/controlador_convenio.php','ins_id='+$('#cmbInstitucionVal option:selected').val()+'&op=guardarConvenioPSS&pss_id='+$('#pss_id').val());

				var paciente=$("#Paciente").val();
				var ctaCorriente=$("#CtaCorriente").val();
				var identificador=$("#Identificador").val();
				var id = $('#cue_id').val();
				cargarContenido('view/interface/busquedaPssCtaCte.php','cue_id='+id+'&Paciente='+paciente+'&CtaCorriente='+ctaCorriente+'&Identificador='+identificador,'#contenidoBuscado');
				mensajeUsuario('successMensaje','Éxito','Valores actualizados con exito.');
				$('#modalValorizarPss').dialog('destroy').remove();
			}else{
				mensajeUsuario('alertMensaje','Advertencia','Porfavor termine de editar los valores.');
			}	
		}
	});
	$('#cmbInstitucionVal').change(function(){
		var subtotal = 0;
		var subtotal2 = 0;
		$('#tblValorizacion  [name="txtValor"]').each(function(){
			var idVal = $(this).attr('id');
			var inst = $('#cmbInstitucionVal option:selected').val();
			var prevision = $('#txtPrevisionId').val();
			var val = validarProcesos('./controller/server/controlador_valorizar.php','pre_id='+prevision+'&ins_id='+inst+'&op=valorProducto'+'&pro_id='+idVal);
			$(this).val(val);
			var cantidad = $('#txtCantidad'+idVal).val();
			var total = cantidad * val;
			$('#txtValorT'+idVal).val(total);
			total = subtotal2 + total;
			subtotal = subtotal + total;
			$('#txtTotal').val(subtotal);
			var idSub = $('#txtSubtotal'+idVal).attr('name');
			if(idVal == idSub){
				$('#txtSubtotal'+idVal).val(total);
			}
		});
	});
});
