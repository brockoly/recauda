$(document).ready(function(){
	validar('filtroBusqueda', 'id','todo');
	//muestraError('information', 'Para anular una boleta, primero busque la boleta.');
	$("#btnBusqueda").button().click(function(){
	 	
	 		cargarContenido('view/interface/busquedaAnularBoleta.php','filtro='+$("#filtroBusqueda").val(),'#contenidoBuscado');
	 			
	});	
});