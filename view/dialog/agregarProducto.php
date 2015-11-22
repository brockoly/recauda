<?php
	//LLAMADA DE CLASES
	require_once('../../class/Conectar.class.php'); $objCon = new Conectar(); 
	require_once('../../class/Producto.class.php'); $objPro = new Producto();
	//LLAMADA DE METODOS.
	$objCon->db_connect();
	$productos = $objPro->tipoProducto($objCon);
	$objCon=null;
	if(count($productos) ==0){ ?>
		<label style="color: red; border-color: 1px solid black;">No hay tipos de productos, porfavor agregue uno para comenzar</label>
		<br/>
	<? }else{
?>
<script type="text/javascript" src="controller/client/js_agregarProducto.js"></script>
<fieldset style="width: 400px;"><legend>Datos Producto</legend>
<center>
<table>
		<tr>
			<td>Id:</td>
			<td>&nbsp;&nbsp;&nbsp;<input type="text" id="txtId" />&nbsp;&nbsp;<img src="include/img/Information.png" id="caca" hidden="true"  /></td>
		</tr>
		<tr>
			<td>Descripción:</td>
			<td>&nbsp;&nbsp;&nbsp;<input type="text" id="txtDescripcion" />&nbsp;&nbsp;<img src="include/img/Information.png" hidden="true"  /></td>
		</tr>
		<tr>
			<td>Tipo Producto:</td>
			<td>&nbsp;&nbsp;
				<select id="cmbTipoProducto" name="cmbTipoProducto">
					<option value="0">Seleccione</option>
					<?php for($i=0; $i<count($productos); $i++) {?>
							<option value="<?=$productos[$i]['tip_prod_id']?>"> <?=$productos[$i]['tip_descripcion']?> </option>							
					<?php ;}?>
				</select>
				<img src="./include/img/information.png" id="errPrivilegio" hidden="true"/>
			</td>
		</tr>
</table>
</center><br><br>
</fieldset>
<br><br>
<fieldset style="width: 400px;"><legend>Valores</legend>
<center>
<table>
		<tr>
			<td>Fonasa A:</td>
			<td>&nbsp;&nbsp;&nbsp;<input type="text"  id="" />&nbsp&nbsp<img src="../../include/img/Information.png" id="" hidden="true" /> </td>
		</tr>
		<tr>
			<td>Fonasa B:</td>
			<td>&nbsp;&nbsp;&nbsp;<input type="text" id="" /></td>
		</tr>
		<tr>
			<td>Fonasa C:</td>
			<td>&nbsp;&nbsp;&nbsp;<input type="text" id="" /></td>
		</tr>
		<tr>
			<td>Fonasa D:</td>
			<td>&nbsp;&nbsp;&nbsp;<input type="text" id="" /></td>
		</tr>
		<tr>
			<td>Isapre:</td>
			<td>&nbsp;&nbsp;&nbsp;<input type="text" id="" /></td>
		</tr>
		<tr>
			<td>Libre Elección N1:</td>
			<td>&nbsp;&nbsp;&nbsp;<input type="text" id="" /></td>
		</tr>
		<tr>
			<td>Libre Elección N2:</td>
			<td>&nbsp;&nbsp;&nbsp;<input type="text" id="" /></td>
		</tr>
		<tr>
			<td>Libre Elección N3:</td>
			<td>&nbsp;&nbsp;&nbsp;<input type="text" id="" /></td>
		</tr>
		<tr>
			<td>Ejercito:</td>
			<td>&nbsp;&nbsp;&nbsp;<input type="text" id="" /></td>
		</tr>
		<tr>
			<td>Fuerza Aérea:</td>
			<td>&nbsp;&nbsp;&nbsp;<input type="text" id="" /></td>
		</tr>
		<tr>
			<td>Dipreca:</td>
			<td>&nbsp;&nbsp;&nbsp;<input type="text" id="" /></td>
		</tr>
		<tr>
			<td>Capredena:</td>
			<td>&nbsp;&nbsp;&nbsp;<input type="text" id="" /></td>
		</tr>
		<tr>
			<td>Armada:</td>
			<td>&nbsp;&nbsp;&nbsp;<input type="text" id="" /></td>
		</tr>
</table>
</center><br><br>
<center><input type="button" id="btnAddProducto" value="Agregar Producto"/></center>
<br><br>
</fieldset>
<? }?>