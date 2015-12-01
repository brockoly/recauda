$(document).ready(function(){
		tabla('tabConsultaPagos');
		$(".buscaPagos").click(function(){	
			bol_id=$(this).attr('id');
			ventanaModal('./view/dialog/consultaBoleta.php','bol_id='+bol_id,'auto','auto','Boleta','modalImprimirPss');
			/*var id=$(this).attr('id');
			var paciente=$("#Paciente").val();
			var ctaCorriente=$("#CtaCorriente").val();
			var identificador=$("#Identificador").val();
			cargarContenido('view/interface/busquedaPssCtaCte.php','cue_id='+id+'&Paciente='+paciente+'&CtaCorriente='+ctaCorriente+'&Identificador='+identificador,'#contenidoBuscado');
		*/});		
});