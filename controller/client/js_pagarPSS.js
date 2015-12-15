$(document).ready(function(){
	validar('valores', 'class' ,'numero');
	var a=0,b=0,c=0;
	$('#bntAgregarPago').click(function(){
		var valor = $('#txtMontoPago').val();
		var tipo_pago = $('#cmbTipoPago option:selected').text();
		var tip_pag_id = $('#cmbTipoPago option:selected').val();
		if(isNaN(parseInt(valor))){
			mensajeUsuario('alertMensaje','Advertencia','Solo puede agregar numeros.');
		}else{
			if(tip_pag_id==0){
				mensajeUsuario('alertMensaje','Advertencia','Seleccione un tipo de pago.');
			}
			else if(valor<=0 || valor==''){
				mensajeUsuario('alertMensaje','Advertencia','Ingrese un valor.');
			}
			else{
				if(tip_pag_id==1 && a==1){
					mensajeUsuario('alertMensaje','Advertencia','No puede agregar el mismo tipo.');
				}else if(tip_pag_id==2 && b==1){
					mensajeUsuario('alertMensaje','Advertencia','No puede agregar el mismo tipo.');
				}else if(tip_pag_id==3 && c==1){
					mensajeUsuario('alertMensaje','Advertencia','No puede agregar el mismo tipo.');
				}
				else{
					var valLbl = $('#txtTotalPag').val();
					$('#txtTotalPag').val(parseInt(valor)+parseInt(valLbl));
					$('<tr name="bntEliminarPago'+tip_pag_id+'"><td width="30%">'+tipo_pago+'</td><td width="30%" name="valorPago" id="valor'+tip_pag_id+'" align="right">'+valor+'</td><td width="5%" align="center"><img width="20" height="20" id="bntEliminarPago'+tip_pag_id+'" src="./include/img/eraser.png"></td><td></td></tr>').appendTo('#tblPagos');
					if(tip_pag_id==1){
						a=1;
					}else if(tip_pag_id==2){
						b=1;
					}
					else if(tip_pag_id==3){
						c=1;
					}
					$('#bntEliminarPago'+tip_pag_id).click(function(){
						var total = $('#txtTotalPag').val();
						$('#txtTotalPag').val(parseInt(total)-parseInt($('#valor'+tip_pag_id).text()));
						if(tip_pag_id==1){
							a=0;
						}else if(tip_pag_id==2){
							b=0;
						}
						else if(tip_pag_id==3){
							c=0;
						}
						$('[name="bntEliminarPago'+tip_pag_id+'"]').remove();
					});
				}
			}
		}
	});
	$('#btnPagarPSS').button().click(function(){		
		if(a==1 || b==1 || c==1){
			var facturado = $('#txtTotal').val();
			var pagoActual = $('#txtTotalPag').val();
			if(pagoActual>facturado){
				mensajeUsuario('alertMensaje','Advertencia','No puede pagar mas del total facturado.');
			}else{

				var datosEnviar = [];
				var i = 0;
				var z=0;
				$('#tblPagos [name="valorPago"]').each(function(){
					var valor = $(this).text();
					var idTipoPago = $(this).attr('id').split('valor');
					var idTipoPago = idTipoPago[1];

					var datos = [2];
		            datos[0]=idTipoPago;
		            datos[1]=valor;
		            datosEnviar[z]=datos;
		            z++;
				});
				var bol_id = validarProcesos('./controller/server/controlador_pagos.php','op=pagar'+'&datos='+datosEnviar+'&cue_id='+$('#cue_id').val()+'&pss_id='+$('#pss_id').val()+'&facturado='+facturado+'&pagoActual='+pagoActual);
				var cambiarEstado = validarProcesos('./controller/server/controlador_pss.php','pss_id='+$('#pss_id').val()+'&op=pagarPSS');
				var paciente=$("#Paciente").val();
				var ctaCorriente=$("#CtaCorriente").val();
				var identificador=$("#Identificador").val();
				var id = $('#cue_id').val();
				cargarContenido('view/interface/busquedaPssCtaCte.php','cue_id='+id+'&Paciente='+paciente+'&CtaCorriente='+ctaCorriente+'&Identificador='+identificador,'#contenidoBuscado');
				//alert(bol_id);
				//mensajeUsuario('successMensaje','Exito','Pago generado, boleta Nº.'+bol_id);
				ventanaModal('./view/dialog/consultaBoleta.php','bol_id='+bol_id,'auto','auto','Boleta','modalImprimirPss');
				$('#modalPagarPss').dialog('destroy').remove();
				
				/*mensajeUsuario('successMensaje','Éxito','Valores actualizados con exito.');
				*/
			}
			
		}else{
			mensajeUsuario('alertMensaje','Advertencia','Porfavor agregue un monto.');
		}
	});
});
