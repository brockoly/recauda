<script type="text/javascript" src="controller/client/js_editarTipoProducto.js"></script>
<center>
<form id="frmEditarTipoProducto">
		<input type="hidden" name="tip_prod_id" id="tip_prod_id" value="<?=$_POST['tip_prod_id']?>">
		<fieldset style="width: 400px;"><legend>Producto</legend>
		<table>
				<tr>
					<td>Nombre</td>
					<td>&nbsp;&nbsp;&nbsp;<input value="<?=$_POST['tip_descripcion']?>" type="text" id="txtNombreTipoProducto" onkeyup ="validar('txtNombreTipoProducto', 'id' ,'letras')" name="txtNombreTipoProducto"/>&nbsp;&nbsp;<img src="./include/img/information.png" id="errTipoProducto" hidden="true"/></td>
				</tr>
				<tr>
					<td></td>
					<td align="center"><br><input type="button" value="Modificar" id="btnModificarTipoProducto"/></td>
				</tr>
		</table><br>
		</fieldset>
</form>