<?php

	//LLAMADA DE CLASES
	require_once('../../class/Conectar.class.php'); $objCon = new Conectar(); 
	require_once('../../class/Producto.class.php'); $objPro = new Producto();
	require_once('../../class/Tipo_Producto.class.php');$objTipoPro = new Tipo_Producto();
	require_once('../../class/Prevision.class.php');$objPrev = new Prevision();
	//LLAMADA DE METODOS.
	$objCon->db_connect();
	$productos = $objTipoPro->listarTipoProducto($objCon);
	$valores = $objPrev->obtenerPrevisionesActivas($objCon);
	$previsionesInst = $objPrev->listarPrevisionInstitucion($objCon);
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
			<td>&nbsp;&nbsp;&nbsp;<input type="text" id="txtId" class="campoNumero" />&nbsp;&nbsp;<img src="include/img/Information.png" id="errId" hidden="true"  /></td>
		</tr>
		<tr>
			<td>Descripción:</td>
			<td>&nbsp;&nbsp;&nbsp;<input type="text" id="txtDescripcion" class="campoDesc" />&nbsp;&nbsp;<img src="include/img/Information.png" id="errDescrpcion" hidden="true"  /></td>
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
	<tr>
	<td width="35%"><b>Institución</b></td>
	<td width="35%"><b>Previsión</b></td>
	<td width="30%">
	&nbsp;&nbsp;&nbsp; <b>Valor</b>
	</td>
</tr>
<? 	

for ($i=0; $i<count($previsionesInst); $i++) { 
	$pre_nombre = str_replace(' ','', $previsionesInst[$i]['pre_nombre']);
?>

<tr>
	<td><?=$previsionesInst[$i]['ins_nombre']?></td>
	<td><?=$pre_nombre?></td>
	<td>
	&nbsp;&nbsp;&nbsp;<input type="text" class="campoValor" style="width:100px;" value="<? if($previsionesInst[$i]['pre_id'] == $valoresProductos[$i]['pre_id']){ echo $valoresProductos[$i]['val_monto'];} ?>" name="<?=$previsionesInst[$i]['ins_id']?>" id="<?=$previsionesInst[$i]['pre_id']?>" />
		<img src="./include/img/information.png" id="err<?=$previsionesInst[$i]['pre_id']?>" hidden="true"/>
	</td>
</tr>
<? }?>
</table>
</center><br><br>
<center><input type="button" id="btnAddProducto" value="Agregar Producto"/></center>
<br><br>
</fieldset>
<? }?>