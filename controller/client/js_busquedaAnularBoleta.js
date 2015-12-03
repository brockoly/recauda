	tabla('tabAnularBoleta');
	$("#anularBoleta").button().click(function(){
		cargarContenido('view/interface/busquedaAnularBoleta.php','filtro='+$("#filtroBusqueda").val(),'#contenidoBuscado');
	});
