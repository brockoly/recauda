<?php
	require_once('../../class/Conectar.class.php');
	require_once('../../class/Util.class.php');
	require_once('../../class/Cuenta_Corriente.class.php');
	$objCon = new Conectar(); 
	$objUtil = new Util();
	$objCue = new Cuenta_Corriente(); 
	$objCon->db_connect();
	if(isset($_POST['Paciente']) && $_POST['Paciente']!=""){
		$datos=$objCue->buscarCuentaSola($objCon, $_POST['Paciente'], "", "","");
	}
	if(isset($_POST['CtaCorriente']) && $_POST['CtaCorriente']!=""){
		$datos=$objCue->buscarCuentaSola($objCon,"", $_POST['CtaCorriente'], "","");
	}
	if(isset($_POST['Identificador']) && $_POST['Identificador']!=""){
		$identificador = "";
		$identificador=$objUtil->valida_rut($_POST['Identificador']);
		if($identificador!=""){
			$datos=$objCue->buscarCuentaSola($objCon, "", "","", $identificador);
		}else{
			$datos=$objCue->buscarCuentaSola($objCon, "", "","", $_POST['Identificador']);	
		}		
	}
	$objCon=null;
?>
<script type="text/javascript" src="controller/client/js_busquedaCtaCorriente.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('tr.trclass').each(function(index, element) {
		$(this).click(function () {
			if($(this).attr('id').match(/.*/)){
				var idTd = $('#tdCue').text();
				var id = $(this).attr('id');
				if(idTd == id){
					cargarContenido('view/interface/busquedaPssCtaCte.php','cue_id='+id+'&Paciente=<?=$_POST['Paciente']?>&CtaCorriente=<?=$_POST['CtaCorriente']?>&Identificador=<?=$_POST['Identificador']?>','#contenidoBuscado');
				}
				else{
					alert('mal');
				}
			}else{
				alert('ñee');
			}
				
		});
	});
});
</script>
<center><br><h3>Listado de Cuentas Corrientes</h3></center>
<br>
<center>
<div style="width: 75%;">
			<table class="display" width="100%" id="tabCtaCorriente">
		            <thead>
			            <tr>
			              <th width="15%">N° Cta Cte</th>
			              <th width="8%">N° Identificación</th>
			              <th width="10%">Nombre(s)</th>
			              <th width="10%">Apellido Paterno</th>
			              <th width="10%">Apellido Materno</th>
			            </tr>
		            </thead>
<?php
		            for($i=0; $i<count($datos); $i++){
?> 
			        	<tr style="cursor: pointer;" class="trclass" id="<?=$datos[$i]['cue_id']?>">
		        			<td id="tdCue"><?=$datos[$i]['cue_id']?></td>
							<td><? if($datos[$i]['Nacionalidad']=='Chile'){echo $objUtil->formatRut($datos[$i]['per_id']);}else{echo $datos[$i]['per_id'];}?></td>
							<td><?=$datos[$i]['per_nombre']?></td>
							<td><?=$datos[$i]['per_apellidoPaterno']?></td>
							<td><?=$datos[$i]['per_apellidoMaterno']?></td>						
						</tr>
<?php		        }
?>
			</table>
</div>

</center>