$(document).ready(function(){
		tabla('tabConsultaPagos');
		$(".buscaPagos").click(function(){
			alert($(this).attr('id'))
			/*var id=$(this).attr('id');
			var paciente=$("#Paciente").val();
			var ctaCorriente=$("#CtaCorriente").val();
			var identificador=$("#Identificador").val();
			cargarContenido('view/interface/busquedaPssCtaCte.php','cue_id='+id+'&Paciente='+paciente+'&CtaCorriente='+ctaCorriente+'&Identificador='+identificador,'#contenidoBuscado');
		*/});		
});