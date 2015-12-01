<?php
	require_once('../../class/Conectar.class.php');
	require_once('../../class/Util.class.php');
	require_once('../../class/Pagos.class.php');
	$objCon = new Conectar(); 
	$objUtil = new Util();
	$objPag = new Pagos(); 
	$objCon->db_connect();
	if(isset($_POST['Boleta']) && $_POST['Boleta']!=""){
		$datos = $objPag->listarPagosPSS($objCon, "", $_POST['Boleta']);
	}
	if(isset($_POST['CtaCorriente']) && $_POST['CtaCorriente']!=""){		
	}
	if(isset($_POST['Identificador']) && $_POST['Identificador']!=""){
		$identificador = "";
		$identificador=$objUtil->valida_rut($_POST['Identificador']);
		if($identificador!=""){
			//$datos=$objCue->buscarCuentaSola($objCon, "", "","", $identificador);
		}else{
			//$datos=$objCue->buscarCuentaSola($objCon, "", "","", $_POST['Identificador']);	
		}	
	}
	$objCon=null;
?>
<script type="text/javascript" src="controller/client/js_busquedaConsultaPagos.js"></script>
<center><br><h3>Listado de Cuentas Corrientes</h3></center>
<br>
<center>
<div style="width: 65%;">
			<table class="display" width="100%" id="tabConsultaPagos">
		            <thead>
			            <tr>
			              <th width="">N° Boleta</th>
			              <th width="">Emisión</th>
			              <th width="">N° Cta Cte</th>
			              <th width="">N° PSS</th>
			            </tr>
		            </thead>
<?php
		            for($i=0; $i<count($datos); $i++){
?>
			        	<tr style="cursor: pointer;" class="buscaPagos" id="<?=$datos[$i]['bol_id']?>">
			        			<td><?=$datos[$i]['bol_id']?></td>
								<td><?=$objUtil->cambiarfecha_mysql_a_normal($datos[$i]['bol_fecha'])?></td>
								<td><?=$datos[$i]['cue_id']?></td>
								<td><?=$datos[$i]['pss_id']?></td>					
						</tr>
<?php		        }
?>
			</table>
</div>
</center>
<input type="hidden" value="<?=$_POST['Paciente']?>" id="Paciente">
<input type="hidden" value="<?=$_POST['CtaCorriente']?>" id="CtaCorriente">
<input type="hidden" value="<?=$_POST['Identificador']?>" id="Identificador">

