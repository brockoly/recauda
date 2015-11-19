<?php
?>

<script type="text/javascript" src="controller/client/js_agregarPrevision.js"></script>
<center>
<form id="frmEditarUsuario">
		<input type="hidden" name="txtIdPre" value="<?=$_POST['pre_id']?>">
		<fieldset style="width: 400px;"><legend>Previsión</legend>
		<table>
				<tr>
					<td>Nombre Previsión</td>
					<td>&nbsp;&nbsp;&nbsp;<input value="" type="text" id="txtPrevisionAgre" onkeyup ="validar('txtPrevisionAgre', 'id' ,'letras')" name="txtPrevision"/>&nbsp;&nbsp;<img src="./include/img/information.png" id="errPrevision" hidden="true"/></td>
				</tr>
				<tr>
					<td></td>
					<td align="center"><br><input type="button" value="Agregar Prevision" id="btnAgregarPre"/></td>
				</tr>
		</table><br>
		</fieldset>
</form>