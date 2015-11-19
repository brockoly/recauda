$(document).ready(function(){
	validar('filtroBusqueda', 'id','numero');
	//muestraError('information', 'Para crear una cuenta corriente, primero busque al paciente.');
	$("#opcionesCuenta").selectmenu();
	$("#btnBusqueda").button().click(function(){
	 	switch($("#opcionesCuenta").val()){
	 		case "Identificador":
	 				cargarContenido('view/interface/busquedaNuevaCtaCorriente.php','Identificador='+$("#filtroBusqueda").val(),'#contenidoBuscado');
	 			break;
	 		case "Paciente":
	 				cargarContenido('view/interface/busquedaNuevaCtaCorriente.php','Paciente='+$("#filtroBusqueda").val(),'#contenidoBuscado')
	 			break;
	 		case "Nombre":
	 				cargarContenido('view/interface/busquedaNuevaCtaCorriente.php','Nombre='+$("#filtroBusqueda").val(),'#contenidoBuscado')
	 			break;
	 	}		
	});	
});

	

