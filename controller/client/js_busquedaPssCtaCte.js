$(document).ready(function(){
	tooltipImg("close","Cerrar PSS");
	tooltipImg("open","Abrir PSS");
	tooltipImg("detalle","Ver Detalle de PSS");
	tooltipImg("editPss","Editar PSS");
	tooltipImg("printer","Imprimir PSS");
	tooltipImg("calculator","Valorizar PSS");
	tooltipImg("ordenAtencion","Generar Orden Atención PSS");
	tooltipImg("pagar","Pagar PSS");
	tooltipImg("abonar","Abonar PSS");
	
	$("#volver").button();
	$("#nuevoPss").button();
	tabla("tabCtaCorrientePss");
	$("#nuevoPss").click(function(){
		mensajeUsuarioConProcedimiento('alertMensaje','Confirmar Acción','Atención, se procederá a crear un nuevo PSS asociado a la cuenta corriente, ¿Desea Continuar?','./controller/server/controlador_pss.php',$("#frmAgregarPssCuenta").serialize()+'&op=agregarPSS','./view/interface/busquedaPssCtaCte.php','cue_id='+$('#cue_id').val()+'&Paciente='+$('#Paciente').val()+'&CtaCorriente='+$('#CtaCorriente').val()+'&Identificador='+$('#Identificador').val(),'#contenidoBuscado','modalAgregarPssCtaCte');
	});

	$(".opcionPss").click(function(){
			var pss_id=$(this).attr('id');
			if($(this).hasClass('open')){
				mensajeUsuarioConProcedimiento('alertMensaje','Confirmar Acción','Atención, se procederá a Abrir el PSS N° '+pss_id+', ¿Desea Continuar?','./controller/server/controlador_pss.php','pss_id='+pss_id+'&op=abrirPss','./view/interface/busquedaPssCtaCte.php','cue_id='+$('#cue_id').val()+'&Paciente='+$('#Paciente').val()+'&CtaCorriente='+$('#CtaCorriente').val()+'&Identificador='+$('#Identificador').val(),'#contenidoBuscado','modalAgregarPssCtaCte');
			}

			if($(this).hasClass('close')){
				mensajeUsuarioConProcedimiento('alertMensaje','Confirmar Acción','Atención, se procederá a Cerrar el PSS N° '+pss_id+', ¿Desea Continuar?','./controller/server/controlador_pss.php','pss_id='+pss_id+'&op=cerrarPss','./view/interface/busquedaPssCtaCte.php','cue_id='+$('#cue_id').val()+'&Paciente='+$('#Paciente').val()+'&CtaCorriente='+$('#CtaCorriente').val()+'&Identificador='+$('#Identificador').val(),'#contenidoBuscado','modalAgregarPssCtaCte');
			}
			if($(this).hasClass('detalle')){
				ventanaModal('./view/dialog/detallePSS.php','pss_id='+pss_id,'auto','auto','Detalle Pss N°'+pss_id,'modalDetallePss')
			}
			if($(this).hasClass('valorizar')){	
				ventanaModal('./view/dialog/valorizarPss.php','pss_id='+pss_id,'auto','auto','Valorizar Pss N°'+pss_id,'modalValorizarPss')
			}
			if($(this).hasClass('printer')){	
				ventanaModal('./view/dialog/imprimirPSS.php','pss_id='+pss_id,'auto','auto','Imprimir Pss','modalImprimirPss');				
			}
			if($(this).hasClass('editPss')){
				ventanaModal('./view/dialog/editarPss.php','pss_id='+pss_id+'&Paciente='+$('#Paciente').val()+'&CtaCorriente='+$('#CtaCorriente').val()+'&Identificador='+$('#Identificador').val(),'auto','auto','Edición de Pss','modalEditarPss');
			}
			if($(this).hasClass('pagar')){
				mensajeUsuario('alertMensaje','No no nooo','Este opción aun esta en desarrollo.');
			}
			if($(this).hasClass('ordenAtencion')){
				mensajeUsuario('alertMensaje','No no nooo','Este opción aun esta en desarrollo.');
			}
			/*var id=$(this).attr('id');
			var paciente=$("#Paciente").val();
			var ctaCorriente=$("#CtaCorriente").val();
			var identificador=$("#Identificador").val();
			cargarContenido('view/interface/busquedaPssCtaCte.php','cue_id='+id+'&Paciente='+paciente+'&CtaCorriente='+ctaCorriente+'&Identificador='+identificador,'#contenidoBuscado');
	*/});		
	
});
