$(document).ready(function(){
	var rut="";
	var extranjero="";
	var identificador=0;
	var bandera=-1;
	
	$("#extranjero").on( 'change', function() {
	    if($(this).is(':checked')) {	       
	       	$( "#filtroBusquedaIde").off();
	       	rut=$('#filtroBusquedaIde').val(); 
	       	$('#filtroBusquedaIde').val("");
	       	$('#filtroBusquedaIde').val(extranjero);
	       	bandera=0;
	       	$("#filtroBusquedaIde").removeClass("cajamala" );
	    }else {
	    	bandera=1;
	    	$( "#filtroBusquedaIde").off();
	    	validar('filtroBusquedaIde', 'id','rut');	
	    	extranjero=$('#filtroBusquedaIde').val();
	    	$("#filtroBusquedaIde").removeClass("cajamala" );
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
			$('#filtroBusquedaIde').val(rut); 
	    }
	});
	$( "#opcionesBusquedaPagos" ).selectmenu({
	  change: function( event, ui ) {
	  	switch($("#opcionesBusquedaPagos").val()){
	 		case "CtaCorriente":
	 				$('<input type="text" id="filtroBusquedaCta" name="filtroBusquedaCta" class="inputValidar" />').appendTo('.inputs');
	 				$(".tdOcultos").show('slow');
	 				$("#filtroBusquedaBol").remove();
	 				$("#filtroBusquedaIde").remove();
	 				$(".divOcultos").hide();	
	 				$("#extranjero").prop('checked', false);
	 				validar('filtroBusquedaCta', 'id','numero');
	 			break;
	 		case "Boleta":
	 				$('<input type="text" id="filtroBusquedaBol" placeholder="Id de Boleta" name="filtroBusquedaBol"  class="inputValidar"/>').appendTo('.inputs');
	 				$(".tdOcultos").show('slow');
	 				$("#filtroBusquedaCta").remove();
	 				$("#filtroBusquedaIde").remove();
	 				$(".divOcultos").hide();
	 				$("#extranjero").prop('checked', false);
	 				validar('filtroBusquedaBol', 'id','numero');		
	 			break;
	 		case "Identificador":
	 				$('<input type="text" value="'+rut+'" id="filtroBusquedaIde" name="filtroBusquedaIde" style="margin-top: 20px;" class="inputValidar"/>').appendTo('.inputs');
	 				$(".divOcultos").show('slow');
	 				$(".tdOcultos").show('slow');
	 				$("#filtroBusquedaCta").remove();
	 				$("#filtroBusquedaBol").remove();
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
	 				$("#filtroBusquedaBol").remove();
	 				$("#filtroBusquedaIde").remove();
	 				$(".divOcultos").hide();
	 				$("#extranjero").prop('checked', false);
	 			break;
	 	}	  	
	  }
	});
	$("#btnBusqueda").button().click(function(){
	 	
		 	switch($("#opcionesBusquedaPagos").val()){
		 		case "CtaCorriente":
		 			if($(".inputValidar").val().length>0){
		 				cargarContenido('view/interface/busquedaConsultaPagos.php','CtaCorriente='+$("#filtroBusquedaCta").val(),'#contenidoBuscado');
		 				$(".inputValidar").removeClass("cajamala" );
		 			}else{
		 				$(".inputValidar").removeClass("cajabuena" ).addClass( "cajamala" );
		 			}
		 			break;
		 		case "Boleta":
		 				if($(".inputValidar").val().length>0	){
		 					cargarContenido('view/interface/busquedaConsultaPagos.php','Boleta='+$("#filtroBusquedaBol").val(),'#contenidoBuscado');
		 					$(".inputValidar").removeClass("cajamala" );
		 				}else{
		 					$(".inputValidar").removeClass("cajabuena" ).addClass( "cajamala" );
		 				}
		 			break;
		 		case "Identificador":
		 				if(bandera==1){
		 					cargarContenido('view/interface/busquedaConsultaPagos.php','Identificador='+identificador,'#contenidoBuscado');
		 				}else{
		 					if(bandera==0){
		 						if($("#filtroBusquedaIde").val()==""){
		 							$("#filtroBusquedaIde").addClass("cajamala" );
		 						}else{
		 							$("#filtroBusquedaIde").removeClass("cajamala" );
		 							cargarContenido('view/interface/busquedaConsultaPagos.php','Identificador='+$("#filtroBusquedaIde").val(),'#contenidoBuscado');	 					
		 						}
		 						
		 					}
		 				}

		 			break;
		 	}
		 	
		
	});
		
});
