<?php
?>

<script type="text/javascript" src="controller/client/js_editarPrevision.js"></script>
<center>
<form id="frmEditarUsuario">
		<input type="hidden" name="txtIdPre" value="<?=$_POST['pre_id']?>">
		<fieldset style="width: 400px;"><legend>Cambio institución</legend>
		<table>
				<tr>
					<td>Nombre Institución</td>
					<td>&nbsp;&nbsp;&nbsp;<input value="<?=$_POST['ins_nombre']?>" type="text" id="txtConvenio" onkeyup ="validar('txtConvenio', 'id' ,'letras')" name="txtConvenio"/>&nbsp;&nbsp;<img src="./include/img/information.png" id="errConvenio" hidden="true"/></td>
				</tr>
				<tr>
					<td></td>
					<td align="center"><br><input type="button" value="Modificar Previsión" id="btnModificarPre"/></td>
				</tr>
		</table><br>
		</fieldset>
</form>