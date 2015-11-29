<?php
if ( $_SESSION['usuario'] == null ) {
		$GoTo = "../../../login/index.php";
		header(sprintf("Location: %s", $GoTo));
	}
?>

<script type="text/javascript" src="controller/client/js_editarNacionalidad.js"></script>
<center>
<form id="frmEditarUsuario">
		<input type="hidden" name="txtIdNac" value="<?=$_POST['nac_id']?>">
		<fieldset style="width: 400px;"><legend>Nacionalidad</legend>
		<table>
				<tr>
					<td>Nombre Nacionalidad</td>
					<td>&nbsp;&nbsp;&nbsp;<input value="<?=$_POST['nac_nombre']?>" type="text" id="txtNacionalidad" onkeyup ="validar('txtNacionalidad', 'id' ,'letras')" name="txtNacionalidad"/>&nbsp;&nbsp;<img src="./include/img/information.png" id="errNacionalidad" hidden="true"/></td>
				</tr>
				<tr>
					<td></td>
					<td align="center"><br><input type="button" value="Modificar Nacionalidad" id="btnModificarNac"/></td>
				</tr>
		</table><br>
		</fieldset>
</form>