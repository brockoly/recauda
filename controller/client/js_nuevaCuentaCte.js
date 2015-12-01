$(document).ready(function(){
	var rut="";
	var extranjero="";
	var identificador=0;
	var bandera=-1;
	var buscar=0;
	
	$("#extranjero").on( 'change', function() {
	    if($(this).is(':checked')) {
	    	$("#filtroBusquedaIde").removeClass("cajamala" );       
	       	$( "#filtroBusquedaIde").off();
	       	rut=$('#filtroBusquedaIde').val(); 
	       	$('#filtroBusquedaIde').val("");
	       	$('#filtroBusquedaIde').val(extranjero);	       	
		 	$("#filtroBusquedaIde").removeClass("cajamala" );
	       	bandera=0;	
	    }else {	    	
		 	$("#filtroBusquedaIde").removeClass("cajamala" );
	    	bandera=-1;
	    	$( "#filtroBusquedaIde").off();
	    	validar('filtroBusquedaIde', 'id','rut');	
	    	extranjero=$('#filtroBusquedaIde').val(); 
	    	$('#filtroBusquedaIde').Rut({
			   	on_error: function(){  
							$("#filtroBusquedaIde").removeClass("cajabuena" ).addClass( "cajamala" );
							//muestraError('errRut','El rut ingresado es incorrecto');
							//a=0;
							//rut=0;
							bandera=-1;
						  },
	  			on_success: function(){
	  						$("#filtroBusquedaIde").removeClass("cajamala" );
	  						rut=$("#filtroBusquedaIde").val();
							identificador=$.Rut.quitarFormato($("#filtroBusquedaIde").val());
							bandera=1;
							//a=1;
							},
	  			format_on: 'keyup'
			}); 
			$('#filtroBusquedaIde').val(rut); 
	    }
	});
	$( "#opcionesCuenta" ).selectmenu({
	  change: function( event, ui ) {
	  	switch($("#opcionesCuenta").val()){
	 		case "Paciente":
	 				$("#filtroBusquedaPac").remove();
	 				$("#filtroBusquedaIde").remove();
	 				$('<input type="text" placeholder="Mínimo 3 Caracteres" class="inputValidar" id="filtroBusquedaPac" name="filtroBusquedaPac" />').appendTo('.inputs');
	 				$(".tdOcultos").show('slow');	 				
	 				$(".divOcultos").hide();
	 				$("#extranjero").prop('checked', false);
	 				validar('filtroBusquedaPac', 'id','letras');		
	 			break;
	 		case "Identificador":
	 				$("#filtroBusquedaPac").remove();
	 				$("#filtroBusquedaIde").remove();
	 				$('<input type="text" placeholder="Ej: xx.xxx.xxx-x" class="inputValidar" value="'+rut+'" id="filtroBusquedaIde" name="filtroBusquedaIde" style="margin-top: 20px;"/>').appendTo('.inputs');
	 				$(".divOcultos").show('slow');
	 				$(".tdOcultos").show('slow');
	 				$("#extranjero").prop('checked', false);
	 				validar('filtroBusquedaIde', 'id','rut');
					$('#filtroBusquedaIde').Rut({
							   	on_error: function(){  
											$("#filtroBusquedaIde").removeClass("cajabuena" ).addClass( "cajamala" );
											//muestraError('errRut','El rut ingresado es incorrecto');
											//a=0;
											//rut=0;
											bandera=-1;
										  },
					  			on_success: function(){
					  						rut=$("#filtroBusquedaIde").val();
											identificador=$.Rut.quitarFormato($("#filtroBusquedaIde").val());
											bandera=1;
											$("#filtroBusquedaIde").removeClass("cajamala" );
											//a=1;
											},
					  			format_on: 'keyup'
					}); 
	 			break;
	 		case "0":
	 				$(".tdOcultos").hide();
	 				$("#filtroBusquedaCta").remove();	
	 				$("#filtroBusquedaPac").remove();
	 				$("#filtroBusquedaIde").remove();
	 				$(".divOcultos").hide();
	 				$("#extranjero").prop('checked', false);
	 			break;
	 	}
	 			  	
	  }
	});

	$("#btnBusqueda").button().click(function(){
		if($(".inputValidar").val().length>2){
		 	switch($("#opcionesCuenta").val()){
		 		case "Paciente":
		 				cargarContenido('view/interface/busquedaNuevaCtaCorriente.php','Paciente='+$("#filtroBusquedaPac").val(),'#contenidoBuscado');
						$(".inputValidar").removeClass("cajamala" );
		 			break;
		 		case "Identificador":
		 				if(bandera==1){
		 					cargarContenido('view/interface/busquedaNuevaCtaCorriente.php','Identificador='+identificador,'#contenidoBuscado');
		 				}
		 				if(bandera==0){
		 						if($("#filtroBusquedaIde").val()==""){
		 							$("#filtroBusquedaIde").addClass("cajamala" );
		 						}else{
		 							$("#filtroBusquedaIde").removeClass("cajamala" );
		 							cargarContenido('view/interface/busquedaNuevaCtaCorriente.php','Identificador='+$("#filtroBusquedaIde").val(),'#contenidoBuscado');	 					
		 						}
		 						
		 					}
		 			break;
		 	}
		}else{
			$(".inputValidar").removeClass("cajabuena" ).addClass( "cajamala" );
 		}		
	});	

	
});

	

