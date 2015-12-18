$(document).ready(function(){
	$('#btnChCon').click(function(){
		ventanaModal('view/dialog/cambiarContrasena','','auto','auto','Cambiar contraseña','modalcambiarContrasena');
	});

	var a=0, b=0, c=0;
	$('#BTNlogout').button().click(function(){
		var res = validarProcesos('controller/server/controlador_sesion.php','op=cerrar');
		if(res=='1'){
			window.location.href = '../login/index.php';
		}else{
			alert('ups');
		}
	});
	$('.change').click(function() {
		var linkText = $(this).text();
		$('.modulo_actual').text(linkText);
	});
/*
	$('#fin').click(function() {
		$( "#contenidoCargado" ).animate({  }, "slow" ,{complete: function() {
      cargarContenidoSlox('view/interface/fin.php','','#contenidoCargado');
    });		
	});	
	*/

	$( "#fin" ).click(function() {
	  $("#contenidoCargado").animate({
        opacity:0
        
      }, {
        duration: 500,
        complete: function () {
          //$(".factuuradresbutton").html("Toch geen factuuradres")
          cargarContenidoSlox('view/interface/fin.php','','#contenidoCargado');
        }
      });
	});
});







function cargarContenidoSlox(url,parametros,contenedor){
//FUNCION AJAX ENVIAPETICION A SERVIDOR Y CARGA CONTENIDO HTML EN CONTENEDOR(NORMALMENTE ELEMENTO DIV)
	
	$(contenedor).html('');
	
//	setTimeout(function(){
		/***/
		
		$(contenedor).fadeOut(0, function(){
			$.ajax({
				type: "POST",
				url:url,
				data:parametros,
				success: function(datos){
					$('.validity-tooltip').remove();
					//$.unblockUI(); 
					$(contenedor).html(datos);
				}
			});
			$(contenedor).fadeIn(1500);
		});
		
		/***/
//	},5000);
//FIN FUNCION AJAX
}