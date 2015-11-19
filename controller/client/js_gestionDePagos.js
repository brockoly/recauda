$(document).ready(function(){
	//muestraError('information', 'Para gestionar los pagos, busque al paciente mediante los filtros.');
	validar('filtroBusqueda', 'id','numero');
	$("#opcionesGestion").selectmenu();
	$("#btnBusqueda").button().click(function(){
	 	switch($("#opcionesGestion").val()){
	 		case "CtaCorriente":
	 				cargarContenido('view/interface/busquedaGestionDePago.php','CtaCorriente='+$("#filtroBusqueda").val(),'#contenidoBuscado');
	 			break;
	 		case "Paciente":
	 				cargarContenido('view/interface/busquedaGestionDePago.php','Paciente='+$("#filtroBusqueda").val(),'#contenidoBuscado')
	 			break;
	 	}		
	});	
});

	

