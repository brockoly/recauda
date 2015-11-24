$(document).ready(function(){
	/*muestraError('information', 'Para gestionar los pagos, busque al paciente mediante los filtros.');*/
	rut="";
	extranjero="";
	identificador=0;
	bandera=0;
	
	$("#extranjero").on( 'change', function() {
	    if($(this).is(':checked')) {	       
	       	$( "#filtroBusquedaIde").off();
	       	rut=$('#filtroBusquedaIde').val(); 
	       	$('#filtroBusquedaIde').val("");
	       	$('#filtroBusquedaIde').val(extranjero);
	       	bandera=0;	
	    }else {
	    	bandera=1;
	    	$( "#filtroBusquedaIde").off();
	    	validar('filtroBusquedaIde', 'id','rut');	
	    	extranjero=$('#filtroBusquedaIde').val(); 
	    	$('#filtroBusquedaIde').Rut({
			   	on_error: function(){  
							//$("#filtroBusquedaIde").removeClass("cajabuena" ).addClass( "cajamala" );
							//muestraError('errRut','El rut ingresado es incorrecto');
							//a=0;
							//rut=0;
							bandera=0;
						  },
	  			on_success: function(){
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
	$( "#opcionesGestion" ).selectmenu({
	  change: function( event, ui ) {
	  	switch($("#opcionesGestion").val()){
	 		case "CtaCorriente":
	 				$('<input type="text" id="filtroBusquedaCta" name="filtroBusquedaCta" class="inputValidar" />').appendTo('.inputs');
	 				$(".tdOcultos").show('slow');
	 				$("#filtroBusquedaPac").remove();
	 				$("#filtroBusquedaIde").remove();
	 				$(".divOcultos").hide();	
	 				$("#extranjero").prop('checked', false);
	 				validar('filtroBusquedaCta', 'id','numero');
	 			break;
	 		case "Paciente":
	 				$('<input type="text" id="filtroBusquedaPac" placeholder="Mínimo 3 caracteres" name="filtroBusquedaPac"  class="inputValidar"/>').appendTo('.inputs');
	 				$(".tdOcultos").show('slow');
	 				$("#filtroBusquedaCta").remove();
	 				$("#filtroBusquedaIde").remove();
	 				$(".divOcultos").hide();
	 				$("#extranjero").prop('checked', false);
	 				validar('filtroBusquedaPac', 'id','letras');		
	 			break;
	 		case "Identificador":
	 				$('<input type="text" value="'+rut+'" id="filtroBusquedaIde" name="filtroBusquedaIde" style="margin-top: 20px;" class="inputValidar"/>').appendTo('.inputs');
	 				$(".divOcultos").show('slow');
	 				$(".tdOcultos").show('slow');
	 				$("#filtroBusquedaCta").remove();
	 				$("#filtroBusquedaPac").remove();
	 				$("#extranjero").prop('checked', false);
	 				validar('filtroBusquedaIde', 'id','rut');
					$('#filtroBusquedaIde').Rut({
							   	on_error: function(){  
											//$("#filtroBusquedaIde").removeClass("cajabuena" ).addClass( "cajamala" );
											//muestraError('errRut','El rut ingresado es incorrecto');
											//a=0;
											//rut=0;
											bandera=0;
										  },
					  			on_success: function(){
					  						rut=$("#filtroBusquedaIde").val();
											identificador=$.Rut.quitarFormato($("#filtroBusquedaIde").val());
											bandera=1;
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
	 	
		 	switch($("#opcionesGestion").val()){
		 		case "CtaCorriente":
		 			if($(".inputValidar").val().length>0){
		 				cargarContenido('view/interface/busquedaGestionDePago.php','CtaCorriente='+$("#filtroBusquedaCta").val(),'#contenidoBuscado');
		 				$(".inputValidar").removeClass("cajamala" );
		 			}else{
		 				$(".inputValidar").removeClass("cajabuena" ).addClass( "cajamala" );
		 			}
		 			break;
		 		case "Paciente":
		 				if($(".inputValidar").val().length>2){
		 					cargarContenido('view/interface/busquedaGestionDePago.php','Paciente='+$("#filtroBusquedaPac").val(),'#contenidoBuscado');
		 					$(".inputValidar").removeClass("cajamala" );
		 				}else{
		 					$(".inputValidar").removeClass("cajabuena" ).addClass( "cajamala" );
		 				}
		 			break;
		 		case "Identificador":
		 				if(bandera==1){
		 					cargarContenido('view/interface/busquedaGestionDePago.php','Identificador='+identificador,'#contenidoBuscado');
		 				}else{
		 					cargarContenido('view/interface/busquedaGestionDePago.php','Identificador='+$("#filtroBusquedaIde").val(),'#contenidoBuscado');	 					
		 				}

		 			break;
		 	}
		 	
		
	});
		
});
