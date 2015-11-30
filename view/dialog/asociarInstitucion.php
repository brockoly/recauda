<?php

		require_once('../../class/Conectar.class.php');  $objCon = new Conectar();
		require_once('../../class/Institucion.class.php'); $objIns = new Institucion();	
		$objCon->db_connect();
		$instituciones = $objIns->buscarInstitucionAsociacion($objCon,$_POST['pre_id']);
		$objCon=null;

?>

<script type="text/javascript" src="controller/client/js_asociarInstitucion.js"></script>
<center>
<form id="frmEditarUsuario">
		<input type="hidden" name="txtIdPre" id="txtIdPre" value="<?=$_POST['pre_id']?>">
		<input type="hidden" name="txtNombrePre" id="txtNombrePre" value="<?=$_POST['pre_nombre']?>">
		<fieldset style="width: 400px;"><legend>Lista Instituciones</legend><br>
		<table border="0">
				<tr>
					<td></td>
					<td>
							<?
							for($i=0; $i<count($instituciones); $i++){ ?>
							<input type="checkbox" name="institucion[]" value="<?= $instituciones[$i]['ins_id']?>">&nbsp;&nbsp;&nbsp;<?= $instituciones[$i]['ins_nombre']?><br>
								
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
					<td align="middle" colspan="2"><br><input type="button" value="Asociar Instituciones" id="btnAgregarAsociaciones" name="btnAgregarAsociaciones"/></td>
				</tr>
		</table><br>
		</fieldset>
</form>