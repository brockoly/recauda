<?php
if ( $_SESSION['usuario'] == null ) {
		$GoTo = "../../../login/index.php";
		header(sprintf("Location: %s", $GoTo));
	}
?>

<script type="text/javascript" src="controller/client/js_agregarNacionalidad.js"></script>
<center>
<form id="frmEditarUsuario">
		<fieldset style="width: 400px;"><legend>Nacionalidad</legend>
		<table>
				<tr>
					<td>Nombre Nacionalidad</td>
					<td>&nbsp;&nbsp;&nbsp;<input value="" type="text" id="txtNacionalidadAgre" onkeyup ="validar('txtNacionalidadAgre', 'id' ,'letras')" name="txtNacionalidad"/>&nbsp;&nbsp;<img src="./include/img/information.png" id="errNacionalidad" hidden="true"/></td>
				</tr>
				<tr>
					<td></td>
					<td align="center"><br><input type="button" value="Agregar Nacionalidad" id="btnAgregarNac"/></td>
				</tr>
		</table><br>
		</fieldset>
</form>