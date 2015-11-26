<?
	//LLAMADA DE CLASES
	require_once('../../class/Conectar.class.php'); $objCon = new Conectar(); 
	require_once('../../class/Producto.class.php'); $objPro = new Producto();
	require_once('../../class/Tipo_Producto.class.php');$objTipoPro = new Tipo_Producto();
	require_once('../../class/Unidad_Medida.class.php');$objUnidadM = new Unidad_Medida();
	//LLAMADA DE METODOS.
	$objCon->db_connect();
	$objTipoPro->setTipoProducto('',$tip_prod_id);
	$unidadMedida = $objUnidadM->listarUMProducto($objCon,$_POST['tip_prod_id']);
	$cantidadUM =  count($unidadMedida);
	$objCon=null;
?>
<script type="text/javascript" src="controller/client/js_editarTipoProducto.js"></script>
<center>
<form id="frmEditarTipoProducto">
		<input type="hidden" name="tip_prod_id" id="tip_prod_id" value="<?=$_POST['tip_prod_id']?>">
		<fieldset style="width: 400px;"><legend>Producto</legend>
		<table>
				<tr>
					<td>Nombre</td>
					<td>&nbsp;&nbsp;&nbsp;<input value="<?=$_POST['tip_descripcion']?>" type="text" id="txtNombreTipoProducto" onkeyup ="validar('txtNombreTipoProducto', 'id' ,'letras')" name="txtNombreTipoProducto"/>&nbsp;&nbsp;<img src="./include/img/information.png" id="errTipoProducto" hidden="true"/><input type="checkbox" id="chkUME" name="chkUME" value="0">UM</td>
				</tr>
				<tr id="trUnidadMedidaE">
					<tr>
						<td colspan="2" id="tdUnidadMedidaE">
							
						</td>
					</tr>
				</tr>
				<tr>
					<td></td>
					<td align="center"><br><input type="button" value="Modificar" id="btnModificarTipoProducto"/></td>
				</tr>
		</table>
		<br>
		</fieldset>

<? if($cantidadUM>0){ ?>
<fieldset style=""><legend>Unidades de medida</legend>
<br>
	<table class="display" width="100%" id="tblUnidadesMedida">
            <thead>
	            <tr>
	              <th width="60%">Descripción</th>
	              <th width="60%">Opciones</th>
	            </tr>
            </thead>
            <tbody>
			<?php
			for($i=0; $i<$cantidadUM; $i++){
		?> 	<tr>
				<td><?=$unidadMedida[$i]['uni_nombre']?></td>
				<td>
					<img title="Eliminar Unidad Medida" src="./include/img/Delete.png" onclick="mensajeUsuarioConProcedimiento('alertMensaje','Confirmar Acción','Atención, se procederá a ELIMINAR la unidad de medida <?=$unidadMedida[$i]['uni_nombre']?>, ¿Desea continuar?','./controller/server/controlador_producto.php','uni_id=<?=$unidadMedida[$i]['uni_id']?>&op=eliminarUM','./view/dialog/editarTipoProducto.php','tip_prod_id=<?=$_POST['tip_prod_id']?>&tip_descripcion=<?=$_POST['tip_descripcion']?>','#modalEditarTipoProducto')" style="cursor: pointer;" style="cursor: pointer;')"/>
					&nbsp;&nbsp;&nbsp;
				</td>
			</tr>
			<?php 	}
			?>	
            </tbody>
    </table>
<br>
</fieldset>
<? }?>
</form>