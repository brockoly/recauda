 var productos = [];
 $(document).ready(function(){
    var id = 0;
    var codigo = ""; 
    var descripcion = "";
    var cantidad = "";
    var idSen = 0;
    var idPro = 0;
    var vacio="";
    validar('cantPro', 'class' ,'numero');
    $(".btnAdd").button().click(function(){       
        if($(this).attr('id')=="btnAgregar1"){//SOLO REGISTRA
            var productosFinal = [productos.length]; 
            patron = "cantProducto";
            var z=0;
            $(".tablaProductosAgregados input[type=text]").each(function (index){             
                //var valor = $("#"+$(this).attr('id')).val();
                var productosX = [2];
                productosX[0]=$(this).attr('id').replace(patron,'');
                productosX[1]=$("#"+$(this).attr('id')).val();
                productosFinal[z]=productosX;
                z++;                            
            })
            var cont = validarProcesos('controller/server/controlador_pss.php','productosFinal='+productosFinal+'&op=agregarProductoPss&cambiarEstado=no');
            $('#modalEditarPss').dialog('destroy').remove();
            cargarContenido('./view/interface/busquedaPssCtaCte.php','cue_id='+$("#cue_id").val()+'&Paciente='+$('#Paciente').val()+'&CtaCorriente='+$('#CtaCorriente').val()+'&Identificador='+$('#Identificador').val(),'#contenidoBuscado');
            mensajeUsuario('successMensaje','Exito','<b>PSS modificado con exito</b>');
        }else if($(this).attr('id')=="btnAgregar2"){
            var productosFinal = [productos.length]; 
            patron = "cantProducto";
            var z=0;
            $(".tablaProductosAgregados input[type=text]").each(function (index){             
                var productosX = [2];
                productosX[0]=$(this).attr('id').replace(patron,'');
                productosX[1]=$("#"+$(this).attr('id')).val();
                productosFinal[z]=productosX;
                z++;                            
            })
            var cont = validarProcesos('controller/server/controlador_pss.php','productosFinal='+productosFinal+'&op=agregarProductoPss&cambiarEstado=si');
            $('#modalEditarPss').dialog('destroy').remove();
            cargarContenido('./view/interface/busquedaPssCtaCte.php','cue_id='+$("#cue_id").val()+'&Paciente='+$('#Paciente').val()+'&CtaCorriente='+$('#CtaCorriente').val()+'&Identificador='+$('#Identificador').val(),'#contenidoBuscado');
            mensajeUsuario('successMensaje','Exito','<b>PSS modificado con exito</b>');
        }
        

    });
    	
    $(".filtroBus").keypress(function(){
       idSen = $(this).attr('id');
    });
          
    $(".filtroBus").autocomplete({
        source: function(request, response) {
                $.ajax({
                      type: "POST",
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
        var x = parseInt($("#cantPro"+id).val());
        var y = parseInt($("#cantProducto"+idPro).val());
        if(isNaN(x)==true){
            x=1;
        }        
        if(isNaN(y)==true){
            y=1;
        }
        if(productos.length==0){                    
            cantidad="";
            cantidad = '<td class="cuerpoDatosTablas" align="center" width="10%"><input  class="proCantAgregar" type="text" style="width:60px" id="cantProducto'+idPro+'"  onblur="verificaEntero('+idPro+')" value="'+x+'" /></td><td width="3%">&nbsp&nbsp<img class="eliminarFila'+idPro+'" onclick="eliminarFila('+idPro+')" src="./include/img/delete.png" width="16" height="16" id="'+idPro+'"/></td>';
            $("#tblProducto"+id).append("<tr id='eliminarPro"+idPro+"'>"+codigo+descripcion+cantidad+"</tr>");
            $("#cantPro"+id).val("");
            $("#cantPro"+id).hide();            
            productos[productos.length]=idPro;
            validar('proCantAgregar', 'class' ,'numero');
            $("#btnAgregar2").css( "visibility", "visible" ); 
            
        }else{
            if(jQuery.inArray( idPro, productos )==-1){
                cantidad="";
                cantidad = '<td class="cuerpoDatosTablas" align="center" width="10%"><input  class="proCantAgregar" type="text" style="width:60px" id="cantProducto'+idPro+'" onblur="verificaEntero('+idPro+')"  value="'+x+'" /></td><td width="3%">&nbsp&nbsp<img class="eliminarFila'+idPro+'" onclick="eliminarFila('+idPro+')" src="./include/img/delete.png" width="16" height="16" id="'+idPro+'"/></td>';
                $("#tblProducto"+id).append("<tr id='eliminarPro"+idPro+"'>"+codigo+descripcion+cantidad+"</tr>");
                $("#cantPro"+id).val("");
                $("#cantPro"+id).hide();
                productos[productos.length]=idPro;       
                validar('proCantAgregar', 'class' ,'numero');
            }else{              
               $("#cantProducto"+idPro).val(x+y);
               $("#cantPro"+id).val("");
               $("#cantPro"+id).hide();
            }
        }
        
    });
    /******************Lleno el arreglo para cuando viene de php******************************/
    var j=0;
    $(".tablaProductosAgregados input[type=text]").each(function (index){
            patron = "cantProducto";
            productos[j]=$(this).attr('id').replace(patron,'');
            j++;                      
    });    
            
});

function eliminarFila(idPro){
        if($(".eliminarFila"+idPro).hasClass('bd')){
            validarProcesos('controller/server/controlador_pss.php','idPro='+idPro+'&op=eliminarProductoPss');
            $("#eliminarPro"+idPro).remove();        
            var i=0;
            for(i; i<productos.length; i++){
                if(productos[i]==idPro){
                    productos.splice(i,1); 
                }
            } 
        }else{
            $("#eliminarPro"+idPro).remove();        
            var i=0;
            for(i; i<productos.length; i++){
                if(productos[i]==idPro){
                    productos.splice(i,1); 
                }
            }   
        }

        if(productos.length==0){

             $("#btnAgregar2").css( "visibility", "hidden" ); 
        }
        
}
function verificaEntero(idPro){
        /*$("#cantProducto"+idPro).val();*/
        var x = parseInt($("#cantProducto"+idPro).val());
        if(isNaN(x)==true){
            $("#cantProducto"+idPro).val("1");
        }else{
            if($("#cantProducto"+idPro).val()==""){
                $("#cantProducto"+idPro).val("1");
            }
        }         
}
$(".filtroBus").focus(function(){
     $(this).val("")
});
$("#tabs" ).tabs();	
