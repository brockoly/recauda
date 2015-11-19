<?php
?>

<script type="text/javascript" src="controller/client/js_editarPrevision.js"></script>
<center>
<form id="frmEditarUsuario">
		<input type="hidden" name="txtIdPre" value="<?=$_POST['pre_id']?>">
		<fieldset style="width: 400px;"><legend>Previsión</legend>
		<table>
				<tr>
					<td>Nombre Previsión</td>
					<td>&nbsp;&nbsp;&nbsp;<input value="<?=$_POST['pre_nombre']?>" type="text" id="txtPrevision" onkeyup ="validar('txtPrevision', 'id' ,'letras')" name="txtPrevision"/>&nbsp;&nbsp;<img src="./include/img/information.png" id="errPrevision" hidden="true"/></td>
				</tr>
				<tr>
					<td></td>
					<td align="center"><br><input type="button" value="Modificar Previsión" id="btnModificarPre"/></td>
				</tr>
		</table><br>
		</fieldset>
</form>