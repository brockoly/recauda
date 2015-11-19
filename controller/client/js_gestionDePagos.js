$(document).ready(function(){
	//muestraError('information', 'Para gestionar los pagos, busque al paciente mediante los filtros.');
	
	validar('filtroBusquedaCta', 'id','numero');
	validar('filtroBusquedaPac', 'id','letras');
	$( "#opcionesGestion" ).selectmenu({
	  change: function( event, ui ) {
	  	switch($("#opcionesGestion").val()){
	 		case "CtaCorriente":
	 				$(".tdOcultos").show('slow');
	 				$("#filtroBusquedaCta").show('slow');
	 				$("#filtroBusquedaPac").hide();		
	 			break;
	 		case "Paciente":
	 				$(".tdOcultos").show('slow');
	 				$("#filtroBusquedaPac").show('slow');
	 				$("#filtroBusquedaCta").hide();			
	 			break;
	 		case "0":
	 				$(".tdOcultos").hide('slow');
	 				$("#filtroBusquedaCta").hide();	
	 				$("#filtroBusquedaPac").hide();	
	 			break;
	 	}	  	
	  }
	});

	$("#btnBusqueda").button().click(function(){
	 	switch($("#opcionesGestion").val()){
	 		case "CtaCorriente":
	 				cargarContenido('view/interface/busquedaGestionDePago.php','CtaCorriente='+$("#filtroBusquedaCta").val(),'#contenidoBuscado');
	 			break;
	 		case "Paciente":
	 				cargarContenido('view/interface/busquedaGestionDePago.php','Paciente='+$("#filtroBusquedaPac").val(),'#contenidoBuscado')
	 			break;
	 	}		
	});	
});

	

