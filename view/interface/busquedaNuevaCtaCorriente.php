<?php
	require_once('../../class/Conectar.class.php');
	require_once('../../class/Util.class.php');
	require_once('../../class/Paciente.class.php');
	$objCon = new Conectar(); 
	$objUtil = new Util(); 
	$objPac = new Paciente(); 
	$objCon->db_connect();	
	if(isset($_POST['Paciente']) && $_POST['Paciente']!=""){
		//
		$datos=$objPac->getInformacionPaciente($objCon,'',$_POST['Paciente']);
		//echo $_POST['Paciente'];
	}	
	if(isset($_POST['Identificador']) && $_POST['Identificador']!=""){
		//
		$datos=$objPac->getInformacionPaciente($objCon,$objUtil->valida_rut($_POST['Identificador']),'');
	}
	$objCon=null;
?>
<script type="text/javascript" src="controller/client/js_busquedaCtaCorriente.js"></script>
<br><br>
<center>
<div style="width: 70%;">
			<table class="display" width="100%" id="tabCtaCorriente">
		            <thead>
			            <tr>
			              <th>N° Identificación</th>
			              <th>Nombre(s)</th>
			              <th>Apellido Paterno</th>
			              <th>Apellido Materno</th>
			            </tr>
		            </thead>
<?php
		            	for($i=0; $i<count($datos); $i++){
?> 
			        	<tr onclick="">
			        			<td><?=$datos[$i]['Identificador']?></td>
								<td><?=$datos[$i]['Nombre']?></td>
								<td><?=$datos[$i]['Apellido_Paterno']?></td>
								<td><?=$datos[$i]['Apellido_Materno']?></td>								
			            </tr>
<?php		            }
?>
			</table>
</div>
</center>