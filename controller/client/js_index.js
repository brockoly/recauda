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

});