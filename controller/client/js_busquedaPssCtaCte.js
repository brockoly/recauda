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
		mensajeUsuarioConProcedimiento('alertMensaje','Confirmar Acción','Atención, se procederá a crear un nuevo PSS asociado a la cuenta corriente, ¿Desea Continuar?','./controller/server/controlador_pss.php',$("#frmAgregarPssCuenta").serialize()+'&op=agregarPSS','./view/interface/busquedaPssCtaCte.php','cue_id='+$('#cue_id').val()+'&Paciente='+$('#Paciente').val()+'&CtaCorriente='+$('#CtaCorriente').val()+'&Identificador='+$('#Identificador').val(),'#contenidoBuscado','modalAgregarCtaCte');
	});
	
});
