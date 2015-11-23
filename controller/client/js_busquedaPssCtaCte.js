$(document).ready(function(){

	$("#volver").button();
	$("#nuevoPss").button();
	tabla("tabCtaCorrientePss");
	$("#nuevoPss").click(function(){
		mensajeUsuarioConProcedimiento('alertMensaje','Confirmar Acción','Atención, se procederá a crear un nuevo PSS asociado a la cuenta corriente, ¿Desea Continuar?','./controller/server/controlador_pss.php',$("#frmAgregarPssCuenta").serialize()+'&op=agregarPSS','./view/interface/busquedaPssCtaCte.php','cue_id='+$('#cue_id').val()+'&Paciente='+$('#Paciente').val()+'&CtaCorriente='+$('#CtaCorriente').val()+'&Identificador='+$('#Identificador').val(),'#contenidoCargado','modalAgregarCtaCte');
	});
	
});