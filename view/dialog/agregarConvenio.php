<?php

	require_once('../../class/Conectar.class.php');  $objCon = new Conectar();
	require_once('../../class/Prevision.class.php'); $objPre = new Prevision();	
	$objCon->db_connect();
	$previsiones = $objPre->obtenerPrevisiones($objCon);
	$objCon=null;
?>

<script type="text/javascript" src="controller/client/js_agregarConvenio.js"></script>
<center>
<form id="frmEditarUsuario">
		<fieldset style="width: 400px;"><legend>Convenio</legend>
		<table>
				<tr>
					<td>Nombre Convenio</td>
					<td>&nbsp;&nbsp;&nbsp;<input value="" type="text" id="txtConvenioAgre" onkeyup ="validar('txtConvenioAgre', 'id' ,'letras')" name="txtConvenio"/>&nbsp;&nbsp;<img src="./include/img/information.png" id="errConvenio" hidden="true"/><br></td>
				</tr>
				<tr><td></td>
					<td><br>
						<?
						for($i=0; $i<count($previsiones); $i++){ 
						?>
						<input type="checkbox" name="prevision[]" value="<?= $previsiones[$i]['pre_id']?>">&nbsp;&nbsp;&nbsp;<?= $previsiones[$i]['pre_nombre']?><br>							
						<?
						} 
						?>
					
				</td></tr>
				<tr><td align="middle" colspan="2"><br><img src="./include/img/alert.png" id="errAgregarConvenio" hidden="true" /></td></tr>
				<tr>
					<td align="middle" colspan="2"><br><input type="button" value="Agregar Convenio" id="btnAgregarCon"/></td>
				</tr>
		</table><br>
		</fieldset>
</form>