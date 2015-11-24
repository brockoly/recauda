$(document).ready(function(){
	$("#agregarCuenta").button().click(function(){
		if($("#unidadOrigen option:selected").val()!=0){
			mensajeUsuarioConProcedimiento('alertMensaje','Confirmar Acción','Atención, se procederá a crear una nueva cuenta para este paciente , ¿Desea Continuar?','./controller/server/controlador_ctaCte.php',$("#frmAgregarCuenta").serialize()+'&op=agregarCta','./view/interface/gestionDePagos.php','','#contenidoCargado','modalAgregarCtaCte');
		}
	});
});