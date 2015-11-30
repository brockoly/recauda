 $(document).ready(function(){
    var id = 0;
    var codigo = ""; 
    var descripcion = "";
    var cantidad = "";
    var productos = [];
    var idSen = 0;
    var idPro = 0;
    validar('cantPro', 'class' ,'numero');
    validar('proCantAgregar', 'class' ,'numero');
      
	
    $(".filtroBus").keypress(function(){
       idSen = $(this).attr('id');
    });
          
    $(".filtroBus").autocomplete({
        source: function(request, response) {
                $.ajax({
                      type: "GET",
                      url: "./controller/server/controlador_sensitiva.php",
                      dataType: "json",
                      data: {
                        term : request.term,
                        op : 'busquedaSensitivaPro',
                        tip_pro: idSen
                      },
                      success: function(data) {
                            response(data);
                      }
                });
        },
        minLength: 2,
        select: function(event, ui){
            id = 0;
            idPro = ui.item.id;
            codigo = ""; 
            descripcion = "";
            cantidad = "";
            id = $(this).attr('id');
            codigo = '<td align="center" class="cuerpoDatosTablas">'+ui.item.id+'</td>';
            descripcion = '<td class="cuerpoDatosTablas" align="center">'+ui.item.value+'</td>';
            $("#cantPro"+id).show("slow");
            $("#cantPro"+id).focus();     
        }
    });

    $(".cantPro").blur(function(){
        $("#tblProducto"+id).show("slow");
        var x =parseInt($("#cantPro"+id).val());
        if(x==0){
            x=1;
        }
        var y = parseInt($("#cantProducto"+id).val());
        if(productos.length==0){                    
            cantidad="";
            cantidad = '<td class="cuerpoDatosTablas" align="center" width="10%"><input  class="proCantAgregar" type="text" style="width:60px" id="cantProducto'+idPro+'" value="'+x+'" /></td>';
            $("#tblProducto"+id).append("<tr id='eliminarPro"+id+"'>"+codigo+descripcion+cantidad+"</tr>");
            $("#cantPro"+id).val("");
            $("#cantPro"+id).hide();            
            productos[productos.length]=idPro;
        }else{
            if(jQuery.inArray( id, productos )==-1){
                cantidad="";
                cantidad = '<td class="cuerpoDatosTablas" align="center" width="10%"><input class="proCantAgregar"  type="text" style="width:60px" id="cantProducto'+idPro+'" value="'+$("#cantPro"+id).val()+'" /></td>';
                $("#tblProducto"+id).append("<tr id='eliminarPro"+id+"'>"+codigo+descripcion+cantidad+"</tr>");
                $("#cantPro"+id).val("");
                $("#cantPro"+id).hide();
                productos[productos.length]=idPro;
            }else{               
               $("#cantProducto"+id).val(x+y);
               $("#cantPro"+id).val("");
               $("#cantPro"+id).hide();
            }
        }
    });
});

$(".filtroBus").focus(function(){
     $(this).val("")
});

$("#tabs" ).tabs();	
