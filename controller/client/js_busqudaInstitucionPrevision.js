$(document).ready(function(){
	$("#btnAsociarPrevision").button();	
	tabla('tabInstitucionPrevision');
	muestraError('informationMessage', 'La institución debe tener almenos una previsión.')
}); 