$(document).ready(function(){	
	calendario('txtFechaNac');
	$('#btnEditarPaciente').button().click(function(){
		var cont = validarProcesos('controller/server/controlador_paciente.php',$('#frmDatosPaciente').serialize()+'&op=modificarPaciente');
		//alert(cont);
		if(cont='bien'){
			mensajeUsuario('successMensaje','Exito','Paciente modificado exitosamente');
			cargarContenido('view/interface/busquedaPaciente.php','','#contenidoCargado');
			$('#modalEditarPaciente').dialog('destroy').remove();
		}
	});
	$('#cmbPrevision').change(function(){
		if($("#cmbPrevision option:selected").val() == 0){
			$('#trInstitucion').hide();
		}else{
			$('#trInstitucion').show();
			var prevision = $("#cmbPrevision option:selected").val();
			cargarComboAjax('controller/server/controlador_parametros.php','op=cmbInstitucion'+'&pre_id='+prevision,'#cmbInstitucion');
		}
	});

	
});

	
	