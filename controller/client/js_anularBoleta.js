	validar('filtroBusqueda', 'id','numero');
	
	//bandera
	var a=0;
	//muestraError('information', 'Para anular una boleta, primero busque la boleta.');
	$("#btnBusqueda").button().click(function(){	 
		if(a==1){	
		cargarContenido('view/interface/busquedaAnularBoleta.php','filtro='+$("#filtroBusqueda").val(),'#contenidoBuscado'); 					
		}else{
			$("#filtroBusqueda").blur();
		}
	});	

	$("#filtroBusqueda").blur(function(){
		if( $(this).val()==""){
			$(this).removeClass("cajabuena" ).addClass( "cajamala" );			
			a=0;			
		}else{
			$(this).removeClass("cajamala" );
			a=1;
		}
	});

	$("#filtroBusqueda").focus(function(){
		$(this).removeClass("cajabuena cajamala");			
	});