<?
session_start();
if ( $_SESSION['usuario'] == null ) {
		$GoTo = "../../../login/index.php";
		header(sprintf("Location: %s", $GoTo));
	}
//print_r($_SESSION['usuario']);
?>
<script src="controller/client/js_sesion.js"></script>
<form id="frmCambiarContrasena">
	<fieldset style="width: 450px;"><legend>Datos a modificar</legend>
	<center>
	<div id="selector" class="selector"></div>
	<table>
			<tr>
				<td>Contraseña Actual:</td>
				<td>&nbsp;&nbsp;&nbsp;<input type="password" id="txtPassActual" name="txtPassActual" />&nbsp;&nbsp;<img src="./include/img/Information.png" id="errPassActual" hidden="true"  /></td>
			</tr>
			<tr>
				<td>Contraseña Nueva:</td>
				<td>&nbsp;&nbsp;&nbsp;<input type="password" id="txtPassNuevo" name="txtPassNuevo" />&nbsp;&nbsp;<img src="./include/img/Information.png" id="errPassNuevo" hidden="true"  /></td>
			</tr>
			<tr>
				<td>Repita contraseña:</td>
				<td>&nbsp;&nbsp;&nbsp;<input type="password" id="txtPassNuevoR" name="txtPassNuevoR" />&nbsp;&nbsp;<img src="./include/img/Information.png" id="errPassNuevoR" hidden="true"  /></td>
			</tr>
			
	</table>
	</center><br>
	</fieldset>
</form>
<br>
<center><input type="button" id="btnCambiarContrasena" value="Cambiar Contraseña"/></center>
<br>