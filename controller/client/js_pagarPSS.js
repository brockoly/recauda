$(document).ready(function(){
	$('#btnPagarPSS').button().click(function(){		
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
});
