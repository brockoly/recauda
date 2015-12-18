$(document).ready(function(){ 
	
	var a=1;
	var b=1;	
	$(".arqueos").click(function(){
		ventanaModal('./view/dialog/desplegarArqueoEspontaneo.php','arq_id='+$(this).attr('id'),'auto','auto','Arqueo Espontáneo','modalDesplegarArqueoEspontaneo');		
	});
	tabla('tabArqueosEspontaneos');
});