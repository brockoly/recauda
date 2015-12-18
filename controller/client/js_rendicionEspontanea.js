$(document).ready(function(){
	 document.getElementById("imgRendirArqueo").style.transition = "all 2s";       // Standard syntax
	 document.getElementById("imgVisualizar").style.transition = "all 0.5s";       // Standard syntax
	$("#btnVisualizar").button().click(function(){
		ventanaModal('./view/dialog/visualizarArqueoEspontaneo.php','','auto','auto','Arqueo Espontáneo','modalVisualizarArqueoEspontaneo');
	});
	var a=1;
	var b=1;
	$("#btnRendirArqueo").button().click(function(){
		var res = JSON.parse(validarProcesos('./controller/server/controlador_arqueo.php','&op=buscarNoRendidos'));
		var res3 = JSON.parse(validarProcesos('./controller/server/controlador_notaCredito.php','&op=buscarNoRendidos'));		
		if(res==""){
			a=0;
		}
		if(res3==""){
			b=0;
		}
		if(a==1 || b==1){	
			var res2=validarProcesos('./controller/server/controlador_arqueo.php','&op=rendirArqueo');			
			ventanaModal('./view/dialog/rendirArqueoEspontaneo.php','arq_id='+res2,'auto','auto','Arqueo Espontáneo','modalRendirArqueoEspontaneo');
			cargarContenido('view/interface/rendicionEspontanea.php','','#contenidoCargado');
		}else{
			mensajeUsuario('errorMensaje','Error','No existen boletas o notas de crédito que rendir.');
		}		
	});
	$(".arqueos").click(function(){
		ventanaModal('./view/dialog/desplegarArqueoEspontaneo.php','arq_id='+$(this).attr('id'),'auto','auto','Arqueo Espontáneo','modalDesplegarArqueoEspontaneo');		
	});
	tooltipImg("btnVisualizar", "Previsualizar arqueo espontáneo");
	tooltipImg("btnRendirArqueo", "Generar arqueo espontáneo");
	tabla('tabArqueos');
});