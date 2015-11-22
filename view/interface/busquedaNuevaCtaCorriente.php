<?php
	require_once('../../class/Conectar.class.php');
	require_once('../../class/Util.class.php');
	require_once('../../class/Paciente.class.php');
	$objCon = new Conectar(); 
	$objUtil = new Util(); 
	$objPac = new Paciente(); 
	$objCon->db_connect();	
	if(isset($_POST['Paciente']) && $_POST['Paciente']!=""){
		$datos=$objPac->getInformacionPaciente($objCon,'',$_POST['Paciente']);
	}	
	if(isset($_POST['Identificador']) && $_POST['Identificador']!=""){
		$datos=$objPac->getInformacionPaciente($objCon,$objUtil->valida_rut($_POST['Identificador']),'');
	}
	$objCon=null;
?>
<script type="text/javascript" src="controller/client/js_busquedaNuevaCtaCorriente.js"></script>
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
			              <th></th>
			            </tr>
		            </thead>
<?php
		            	for($i=0; $i<count($datos); $i++){
?> 
			        	<tr>
			        			<td><? if( $datos[$i]['nac_id']==1 ){ echo $objUtil->formatRut($datos[$i]['Identificador']);}else{ echo $datos[$i]['Identificador'];}?></td>
								<td><?=$datos[$i]['Nombre']?></td>
								<td><?=$datos[$i]['Apellido_Paterno']?></td>
								<td><?=$datos[$i]['Apellido_Materno']?></td>
								<td><input type="button" value="Nueva Cta Cte (+)" class="modCtaNueva" onclick="ventanaModal('./view/dialog/agregarCtaCorriente.php','pac_id=<?=$datos[$i]['pac_id']?>','auto','auto','Editar Usuario','modalAgregarCtaCte')" /></td>								
			            </tr>
<?php		            }
?>
			</table>
</div>
</center>