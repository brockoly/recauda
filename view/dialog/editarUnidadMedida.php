<?php

?>

<script type="text/javascript" src="controller/client/js_editarUnidadMedida.js"></script>
<center>
<form id="frmUnidadMedida">
<input type="hidden" value="<?=$_POST['uni_nombre']?>" id="txtUnidadMedidaAct" name="txtUnidadMedidaAct" />
<input type="hidden" value="<?=$_POST['uni_id']?>" id="txtuni_id" name="txtuni_id" />
		<fieldset style="width: 400px;"><legend>Unidad de medida</legend>
		<table>
				<tr>
					<td>Descripción</td>
					<td>&nbsp;&nbsp;&nbsp;<input value="<?=$_POST['uni_nombre']?>" type="text" id="txtUnidadMedidaE" onkeyup ="validar('txtUnidadMedida', 'id' ,'letras')" name="txtUnidadMedidaE"/>&nbsp;&nbsp;<img src="./include/img/information.png" id="errUnidadMedidaE" hidden="true"/></td>
				</tr>
				<tr>
					<td></td>
					<td align="center"><br><input type="button" value="Modificar UM" id="btnModUnidadMedida"/></td>
				</tr>
		</table><br>
		</fieldset>
</form>