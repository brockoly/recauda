$(document).ready(function(){
	var a=0;
	$("#imgCandado").attr("src","./include/img/candado_cerrado.png");
	$("#imgCandado").click(function(){
		if(a==0){ //ABRIR
			$("#imgCandado").attr("src","./include/img/candado_abierto.png");
			$("#imgCandado").attr('width','30');
			$('[name="txtValor"]').attr("readonly",false);
			$('[name="txtValor"]').css("background","#F5DEB3");
			a=1;
		}else{ //CERRAR
			$("#imgCandado").attr("src","./include/img/candado_cerrado.png");
			$("#imgCandado").attr('width','25');
			$('[name="txtValor"]').attr("readonly",true);
			$('[name="txtValor"]').css("background","none");
			var subtotal = 0;
			var subtotal2 = 0;
			$('#tblValorizacion  [name="txtValor"]').each(function(){
				var idVal = $(this).attr('id');
				var val = $(this).val();
				var cantidad = $('#txtCantidad'+idVal).val();
				var total = cantidad * val;
				$('#txtValorT'+idVal).val(total);
				total = subtotal2 + total;

				subtotal = subtotal + total;
				$('#txtTotal').val(subtotal);
				//alert(subtotal);
				var idSub = $('#txtSubtotal'+idVal).attr('name');
				//alert(idSub);
				if(idVal == idSub){
					$('#txtSubtotal'+idVal).val(total);
				}
				
			});
			a=0;
		}
	});
	$('#btnGuardarValorizacion').button().click(function(){
		$('#tblValorizacion  [name="txtValor"]').each(function(){
			var idVal = $(this).attr('id');
			var val = $(this).val();
			var cantidad = $('#txtCantidad'+idVal).val();
			var total = cantidad * val;
			alert('id producto '+idVal+' valor ='+val);
		});
	});
});
