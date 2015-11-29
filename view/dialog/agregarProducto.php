<?php
if ( $_SESSION['usuario'] == null ) {
		$GoTo = "../../../login/index.php";
		header(sprintf("Location: %s", $GoTo));
	}
	//LLAMADA DE CLASES
	require_once('../../class/Conectar.class.php'); $objCon = new Conectar(); 
	require_once('../../class/Producto.class.php'); $objPro = new Producto();
	require_once('../../class/Tipo_Producto.class.php');$objTipoPro = new Tipo_Producto();
	require_once('../../class/Prevision.class.php');$objPrev = new Prevision();
	//LLAMADA DE METODOS.
	$objCon->db_connect();
	$productos = $objTipoPro->listarTipoProducto($objCon);
	$valores = $objPrev->obtenerPrevisionesActivas($objCon);
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
			<td>&nbsp;&nbsp;&nbsp;<input type="text" id="txtId" />&nbsp;&nbsp;<img src="include/img/Information.png" id="errId" hidden="true"  /></td>
		</tr>
		<tr>
			<td>Descripción:</td>
			<td>&nbsp;&nbsp;&nbsp;<input type="text" id="txtDescripcion" />&nbsp;&nbsp;<img src="include/img/Information.png" id="errDescrpcion" hidden="true"  /></td>
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
				<img src="./include/img/information.png" id="errCmbTipoP" hidden="true"/>
			</td>
		</tr>
		<tr id="trUnidadMedida">
			
		</tr>
</table>
</center><br><br>
</fieldset>
<br><br>
<fieldset style="width: 400px;"><legend>Valores</legend>
<center>
<table id="tblUM">
		<?
		for ($i=0; $i<count($valores); $i++) { 
			$pre_nombre = str_replace(' ','', $valores[$i]['pre_nombre']);
		?>
		<tr>
			<td><?=$pre_nombre?></td>
			<td>&nbsp;&nbsp;&nbsp;<input type="text" name="campoValor" id="<?=$pre_nombre?>_<?=$valores[$i]['pre_id']?>" />
				<img src="./include/img/information.png" id="err<?=$valores[$i]['pre_id']?>" hidden="true"/>
			</td>
		</tr>
		<? }?>
</table>
</center><br><br>
<center><input type="button" id="btnAddProducto" value="Agregar Producto"/></center>
<br><br>
</fieldset>
<? }?>