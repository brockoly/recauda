$(document).ready(function(){
	validar('numero', 'class' ,'numero');
	validar('todo', 'class' ,'todo');
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
					var txtCodT = $("#txtCodT").val();
					var txtCodA = $("#txtCodA").val();
					var txtFolio = $("#txtFolio").val();
					var txtBanco = $("#txtBanco").val();
					if(txtCodT==''){
						txtCodT = 0;
					}
					if(txtCodA==''){
						txtCodA = 0;
					}
					if(txtFolio==''){
						txtFolio = 0;
					}
					if(txtBanco==''){
						txtBanco = 0;
					}
					var valLbl = $('#txtTotalPag').val();
					$('#txtTotalPag').val(parseInt(valor)+parseInt(valLbl));
					$('<tr name="bntEliminarPago'+tip_pag_id+'"><td>'+tipo_pago+'</td><td name="txtCodT">'+txtCodT+'</td><td name="txtCodA">'+txtCodA+'</td><td name="txtFolio">'+txtFolio+'</td><td name="txtBanco">'+txtBanco+'</td><td name="valorPago" id="valor'+tip_pag_id+'" align="right">'+valor+'</td><td align="center"><img width="20" style="cursor: pointer;" height="20" id="bntEliminarPago'+tip_pag_id+'" src="./include/img/eraser.png"></td><td></td></tr>').appendTo('#tblPagos');
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
			}
			else if(pagoActual<facturado && pagoActual>0){ //ABONO
				var datosEnviar = [];
				var i = 0;
				var z=0;
				$('#tblPagos tr').each(function(){
					var valor = $(this).find('[name="valorPago"]').text();
					var idTipoPago = $(this).find('[name="valorPago"]').attr('id').split('valor');
					var idTipoPago = idTipoPago[1];
					var datos = [6];
		            datos[0]=idTipoPago;
		            datos[1]=valor;
		            datos[2]= $(this).find('[name="txtCodT"]').text();
		            datos[3]= $(this).find('[name="txtCodA"]').text();
		            datos[4]= $(this).find('[name="txtFolio"]').text();
		            datos[5]= $(this).find('[name="txtBanco"]').text();
		            datosEnviar[z]=datos;
		            z++;
				});
				var bol_id = validarProcesos('./controller/server/controlador_pagos.php','op=pagar'+'&datos='+datosEnviar+'&cue_id='+$('#cue_id').val()+'&pss_id='+$('#pss_id').val()+'&facturado='+facturado+'&pagoActual='+pagoActual+'&frmPagos='+$('#frmPagos').serialize());
				var cambiarEstado = validarProcesos('./controller/server/controlador_pss.php','pss_id='+$('#pss_id').val()+'&op=abonarPSS');
				var paciente=$("#Paciente").val();
				var ctaCorriente=$("#CtaCorriente").val();
				var identificador=$("#Identificador").val();
				var id = $('#cue_id').val();
				cargarContenido('view/interface/busquedaPssCtaCte.php','cue_id='+id+'&Paciente='+paciente+'&CtaCorriente='+ctaCorriente+'&Identificador='+identificador,'#contenidoBuscado');
				ventanaModal('./view/dialog/consultaBoleta.php','bol_id='+bol_id,'auto','auto','Boleta','modalImprimirPss');
				$('#modalPagarPss').dialog('destroy').remove();
			}
			else{ // PAGO TOTAL
				var datosEnviar = [];
				var i = 0;
				var z=0;
				$('#tblPagos tr').each(function(){
					var valor = $(this).find('[name="valorPago"]').text();
					var idTipoPago = $(this).find('[name="valorPago"]').attr('id').split('valor');
					var idTipoPago = idTipoPago[1];
					var datos = [6];
		            datos[0]=idTipoPago;
		            datos[1]=valor;
		            datos[2]= $(this).find('[name="txtCodT"]').text();
		            datos[3]= $(this).find('[name="txtCodA"]').text();
		            datos[4]= $(this).find('[name="txtFolio"]').text();
		            datos[5]= $(this).find('[name="txtBanco"]').text();
		            datosEnviar[z]=datos;
		            z++;
				});
				var bol_id = validarProcesos('./controller/server/controlador_pagos.php','op=pagar'+'&datos='+datosEnviar+'&cue_id='+$('#cue_id').val()+'&pss_id='+$('#pss_id').val()+'&facturado='+facturado+'&pagoActual='+pagoActual+'&frmPagos='+$('#frmPagos').serialize());
				var cambiarEstado = validarProcesos('./controller/server/controlador_pss.php','pss_id='+$('#pss_id').val()+'&op=pagarPSS');
				var paciente=$("#Paciente").val();
				var ctaCorriente=$("#CtaCorriente").val();
				var identificador=$("#Identificador").val();
				var id = $('#cue_id').val();
				cargarContenido('view/interface/busquedaPssCtaCte.php','cue_id='+id+'&Paciente='+paciente+'&CtaCorriente='+ctaCorriente+'&Identificador='+identificador,'#contenidoBuscado');
				ventanaModal('./view/dialog/consultaBoleta.php','bol_id='+bol_id,'auto','auto','Boleta','modalImprimirPss');
				$('#modalPagarPss').dialog('destroy').remove();
			}
		}else{
			mensajeUsuario('alertMensaje','Advertencia','Porfavor agregue un monto.');
		}
	});
	$('#cmbTipoPago').change(function(){
		limpiarCampos();
		$('[name="tdCodigoT"]').show();
		$('[name="tdCodigoA"]').show();
		$('[name="tdFolio"]').show();
		$('[name="tdBanco"]').show();
		$('[name="tdMonto"]').show();
		$('[name="tdCodigoT"]').hide();
		$('[name="tdCodigoA"]').hide();
		$('[name="tdFolio"]').hide();
		$('[name="tdBanco"]').hide();
		$('[name="tdMonto"]').hide();
		var tip_pag_id = $('#cmbTipoPago option:selected').val();
		if(tip_pag_id==1){
			$('[name="tdCodigoT"]').hide();
			$('[name="tdCodigoA"]').hide();
			$('[name="tdFolio"]').hide();
			$('[name="tdBanco"]').hide();
			$('[name="tdMonto"]').show();
		}
		if(tip_pag_id==2){
			$('[name="tdFolio"]').hide();
			$('[name="tdBanco"]').hide();
			$('[name="tdMonto"]').hide();
			$('[name="tdCodigoT"]').show();
			$('[name="tdCodigoA"]').show();
			$('[name="tdMonto"]').show();
		}
		if(tip_pag_id==3){
			$('[name="tdFolio"]').hide();
			$('[name="tdCodigoT"]').hide();
			$('[name="tdCodigoA"]').hide();
			$('[name="tdFolio"]').show();
			$('[name="tdBanco"]').show();
			$('[name="tdMonto"]').show();
		}
	});
	function limpiarCampos(){
		$("#txtCodT").val('');
		$("#txtCodA").val('');
		$("#txtFolio").val('');
		$("#txtBanco").val('');
		$("#txtMontoPago").val('');
	}
	$('#btnMasBono').click(function(){
		$('<tr><td><input type="text" name="txtBonId" style="width:100px;" /></td><td><select id="cmbBonos"><option>....</option></select></td><td></td><td><img width="20" height="20" style="cursor: pointer;" id="" src="./include/img/eraser.png"></td></tr>').appendTo('#tblBonos');
		cargarComboAjax('controller/server/controlador_parametros.php','op=cmbBonos','#cmbBonos');
	});
});
