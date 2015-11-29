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
	require_once('../../class/Valores.class.php');$objVal = new Valores();
	//LLAMADA DE METODOS.
	$objCon->db_connect();
	$productos = $objTipoPro->listarTipoProducto($objCon);
	$valores = $objPrev->obtenerPrevisionesActivas($objCon);
	$objPro->setProducto($_POST['pro_id'],'','');
	$productoActual = $objPro->buscarProducto($objCon);
	$valoresProductos = $objVal->buscarValoresProducto($objCon, $_POST['pro_id']);
	$objCon=null;
	if(count($productos) ==0){ ?>
		<label style="color: red; border-color: 1px solid black;">No hay tipos de productos, porfavor agregue uno para comenzar</label>
		<br/>
	<? }else{
?>
<script type="text/javascript" src="controller/client/js_editarProducto.js"></script>
<fieldset style="width: 400px;"><legend>Datos Producto</legend>
<center>
<input type="hidden" value="<?=$_POST['pro_id'];?>" id="pro_id_actual"/>
<table>
	<tr>
		<td>Id:</td>
		<td>&nbsp;&nbsp;&nbsp;<input type="text" id="txtId" readonly="true" style="border:none; background: none;" value="<?=$productoActual[0]['pro_id'];?>" />&nbsp;&nbsp;<img src="include/img/Information.png" id="errId" hidden="true"  /></td>
	</tr>
	<tr>
		<td>Descripción:</td>
		<td>&nbsp;&nbsp;&nbsp;<input type="text" id="txtDescripcion" value="<?=$productoActual[0]['pro_nom'];?>" />&nbsp;&nbsp;<img src="include/img/Information.png" id="errDescrpcion" hidden="true"  /></td>
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
		<td>&nbsp;&nbsp;&nbsp;<input type="text" name="campoValor" value="<? if($valores[$i]['pre_id'] == $valoresProductos[$i]['pre_id']){ echo $valoresProductos[$i]['val_monto'];} ?>" id="<?=$pre_nombre?>_<?=$valores[$i]['pre_id']?>" />
			<img src="./include/img/information.png" id="err<?=$valores[$i]['pre_id']?>" hidden="true"/>
		</td>
	</tr>
	<? }?>
</table>
</center><br><br>
<center><input type="button" id="btnAddProductoE" value="Editar Producto"/></center>
<br><br>
</fieldset>
<? }?>