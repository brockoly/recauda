<?php

	//LLAMADA DE CLASES
	require_once('../../class/Conectar.class.php'); $objCon = new Conectar(); 
	require_once('../../class/Producto.class.php'); $objPro = new Producto();
	require_once('../../class/Tipo_Producto.class.php');$objTipoPro = new Tipo_Producto();
	require_once('../../class/Prevision.class.php');$objPrev = new Prevision();
	require_once('../../class/Valores.class.php');$objVal = new Valores();
	//LLAMADA DE METODOS.
	$objCon->db_connect();
	$productos = $objTipoPro->listarTipoProducto($objCon);
	$valores = $objPrev->obtenerPrevisionesActivas($objCon);
	$objPro->setProducto($_POST['pro_id'],'','');
	$productoActual = $objPro->buscarProducto($objCon);
	$valoresProductos = $objVal->buscarValoresProducto($objCon, $_POST['pro_id'], '', '');
	$previsionesInst = $objPrev->listarPrevisionInstitucion($objCon);
	$objCon=null;
	//var_dump(highlight_string(print_r($valoresProductos, true) ));
	if(count($productos) ==0){ ?>
		<label style="color: red; border-color: 1px solid black;">No hay tipos de productos, porfavor agregue uno para comenzar</label>
		<br/>
	<? }else{
?>
<script type="text/javascript" src="controller/client/js_editarProducto.js"></script>
<center>
<fieldset style="width: 500px;"><legend>Datos Producto</legend>
<input type="hidden" value="<?=$_POST['pro_id'];?>" id="pro_id_actual"/>
<table>
	<tr>
		<td>Id:</td>
		<td>&nbsp;&nbsp;&nbsp;<input type="text" class="" id="txtId" readonly="true" style="border:none; background: none;" value="<?=$productoActual[0]['pro_id'];?>" />&nbsp;&nbsp;<img src="include/img/Information.png" id="errId" hidden="true"  /></td>
	</tr>
	<tr>
		<td>Descripción:</td>
		<td>&nbsp;&nbsp;&nbsp;<input type="text" class="campoDesc" id="txtDescripcion" value="<?=$productoActual[0]['pro_nom'];?>" />&nbsp;&nbsp;<img src="include/img/Information.png" id="errDescrpcion" hidden="true"  /></td>
	</tr>
	<tr>
		<td>Tipo Producto:</td>
		<td>&nbsp;&nbsp;
			<select id="cmbTipoProducto" name="cmbTipoProducto">
				<option value="0">Seleccione</option>
				<?php for($i=0; $i<count($productos); $i++) {?>
						<option <? if($productos[$i]['tip_prod_id'] == $productoActual[0]['tip_prod_id']){ echo "selected"; }?> value="<?=$productos[$i]['tip_prod_id']?>"> <?=$productos[$i]['tip_descripcion']?> </option>							
				<?php ;}?>
			</select>
			<img src="./include/img/information.png" id="errCmbTipoP" hidden="true"/>
		</td>
	</tr>
	<input type="hidden" value="<?=$productoActual[0]['uni_id']?>" id="uni_id" />
	<tr id="trUnidadMedida">
		
	</tr>
</table>
<br>
</fieldset>
</center>
<br><br>
<fieldset style="width: 500px;"><legend>Valores</legend>
<center>
<table id="tblUM" width="100%">
	<tr>
		<td width="35%"><b>&nbsp;&nbsp;&nbsp;&nbsp;Institución</b></td>
		<td width="35%"><b>&nbsp;&nbsp;&nbsp;&nbsp;Previsión</b></td>
		<td width="20%">&nbsp;&nbsp;&nbsp; <b>Valor</b>
		</td>
	</tr>
	<? 	
	
	for ($i=0; $i<count($previsionesInst); $i++) { 
		$pre_nombre = $previsionesInst[$i]['pre_nombre'];//str_replace(' ','', $previsionesInst[$i]['pre_nombre']);
	?>
	
	<tr>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;<?=$previsionesInst[$i]['ins_nombre']?></td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;<?=$pre_nombre?></td>
		<td>
		&nbsp;&nbsp;&nbsp;<input type="text" class="campoValor" style="width:70px;" value="<? if($previsionesInst[$i]['pre_id'] == $valoresProductos[$i]['pre_id']){ echo $valoresProductos[$i]['val_monto']; }else{ echo "0";} ?>" name="<?=$previsionesInst[$i]['ins_id']?>" id="<?=$previsionesInst[$i]['pre_id']?>" />
			<img src="./include/img/information.png" id="err<?=$previsionesInst[$i]['pre_id']?>" hidden="true"/>
		</td>
	</tr>
	<? }?>
</table>
</center><br>
<center><input type="button" id="btnAddProductoE" value="Editar Producto"/></center>
<br>
</fieldset>
<? }?>