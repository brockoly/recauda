$(document).ready(function(){
	 document.getElementById("imgRendirArqueo").style.transition = "all 2s";       // Standard syntax
	 document.getElementById("imgVisualizar").style.transition = "all 0.5s";       // Standard syntax
	$("#btnVisualizar").button().click(function(){
		ventanaModal('./view/dialog/visualizarArqueoEspontaneo.php','','auto','auto','Arqueo Espontáneo','modalVisualizarArqueoEspontaneo');
	});

	$("#btnRendirArqueo").button().click(function(){
		ventanaModal('./view/dialog/rendirArqueoEspontaneo.php','','auto','auto','Arqueo Espontáneo','modalRendirArqueoEspontaneo');
	});

	tooltipImg("btnVisualizar", "Previsualizar arqueo espontáneo");
	tooltipImg("btnRendirArqueo", "Generar arqueo espontáneo");
	tabla('tabArqueos');
});