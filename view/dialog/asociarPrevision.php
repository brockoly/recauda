<?php
		require_once('../../class/Conectar.class.php');  $objCon = new Conectar();
		require_once('../../class/Prevision.class.php'); $objPre = new Prevision();	
		$objCon->db_connect();
		$previsiones = $objPre->buscarPrevisionAsociacion($objCon,$_POST['ins_id']);
		$objCon=null;

?>

<script type="text/javascript" src="controller/client/js_asociarPrevision.js"></script>
<center>
<form id="frmEditarUsuario">
		<input type="hidden" name="txtIdIns" id="txtIdIns" value="<?=$_POST['ins_id']?>">
		<input type="hidden" name="txtNombreIns" id="txtNombreIns" value="<?=$_POST['ins_nombre']?>">
		<fieldset style="width: 400px;"><legend>Lista Previsiones</legend><br>
		<table border="0">
				<tr>
					<td></td>
					<td>
							<?
							for($i=0; $i<count($previsiones); $i++){ ?>
							<input type="checkbox" name="prevision[]" value="<?= $previsiones[$i]['pre_id']?>">&nbsp;&nbsp;&nbsp;<?= $previsiones[$i]['pre_nombre']?><br>								
							<?
							} 
							?>											
					</td>
				</tr>
				<tr>
					<td align="center" colspan="2">									
						
					</td>
				</tr>
				<tr>
					<td align="middle" colspan="2"><br><input type="button" value="Asociar Previsiones" id="btnAgregarAsociaciones" name="btnAgregarAsociaciones"/></td>
				</tr>
		</table><br>
		</fieldset>
</form>