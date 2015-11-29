$(document).ready(function(){	
	$(".filtroBus").autocomplete({		
	    source: "./controller/server/controlador_sensitiva.php?op=busquedaSensitivaPro&tip_pro="+$(".filtroBus").attr('id'),
        minLength: 2,
        select: function(event, ui){
        	var id = $(".filtroBus").attr('id');
          	var codigo = '<td align="center" class="cuerpoDatosTablas">'+ui.item.id+'</td>';
        	var descripcion = '<td class="cuerpoDatosTablas" align="center">'+ui.item.value+'</td>';
        	var cantidad = '<td class="cuerpoDatosTablas" align="center" width="10%"></td>';
        	$("#tblProducto"+id).append("<tr>"+codigo+descripcion+cantidad+"</tr>"); 
        }
    });
});

$("#tabs" ).tabs();	
