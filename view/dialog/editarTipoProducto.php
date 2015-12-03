<?

	//LLAMADA DE CLASES
	require_once('../../class/Conectar.class.php'); $objCon = new Conectar(); 
	require_once('../../class/Producto.class.php'); $objPro = new Producto();
	require_once('../../class/Tipo_Producto.class.php');$objTipoPro = new Tipo_Producto();
	require_once('../../class/Unidad_Medida.class.php');$objUniMed = new Unidad_Medida();
	

	//LLAMADA DE METODOS.
	$objCon->db_connect();
	$objTipoPro->setTipoProducto('',$tip_prod_id,'');
	$unidades = $objUniMed->listarUnidadMedida($objCon);
	$unidadesTiPro = $objUniMed->listarUnidadTipoProducto($objCon,$_POST['tip_prod_id']);
	$objCon=null;
?>
<script type="text/javascript" src="controller/client/js_editarTipoProducto.js"></script>
<center>
<form id="frmEditarTipoProducto">
		<input type="hidden" name="tip_prod_idOriginal" id="tip_prod_idOriginal" value="<?=$_POST['tip_prod_id']?>">
		<input type="hidden" name="tip_descripcionOriginal" id="tip_descripcionOriginal" value="<?=$_POST['tip_descripcion']?>">
		<fieldset style="width: 400px;"><legend>Producto</legend>
		<table>
				<tr>
					<td>Código</td>
					<td>&nbsp;&nbsp;&nbsp;<input value="<?=$_POST['tip_prod_id']?>" type="text" id="txtCodigoTipoProducto" onkeyup ="validar('txtCodigoTipoProducto', 'id' ,'numero')" name="txtCodigoTipoProducto"/>&nbsp;&nbsp;<img src="./include/img/information.png" id="errCodigoTipoProducto" hidden="true"/></td>
				</tr>
				<tr>
					<td>Nombre</td>
					<td>&nbsp;&nbsp;&nbsp;<input value="<?=$_POST['tip_descripcion']?>" type="text" id="txtNombreTipoProducto" onkeyup ="validar('txtNombreTipoProducto', 'id' ,'letras')" name="txtNombreTipoProducto"/>&nbsp;&nbsp;<img src="./include/img/information.png" id="errTipoProducto" hidden="true"/></td>
				</tr>
		</table>
		<br/>
		<p><b>Unidades de medida</b></p>
		<table id="tblUME" style="text-align: left; border-collapse: collapse;" border="1" width="80%">
		<?
		$totalRes = count($unidades);
		$columnas = 4;
		$filas = $totalRes/$columnas;
		$arr = $totalRes;
		$cont = 0;
		for($t=0;$t<$filas;$t++){ ?>
			<tr>
			<? for($y=0;$y<$columnas;$y++){
				if($cont<$arr){ ?>
					<td style="padding: 8px; background: #e5f2ff; border:1px solid #fff;"><input type="checkbox" <? foreach ($unidadesTiPro as $k => $v) { if($v['uni_id'] == $unidades[$cont]['uni_id']){  echo "checked"; }} ?> name="chkUM" value="<?=$unidades[$cont]['uni_id']?>"> <?=$unidades[$cont]['uni_nombre']?></td>
					<?$cont++;
				}		
			} ?>
			</tr>
		<?}
		 ?>
		</table>
		<br/>
		<input type="button" value="Modificar" id="btnModificarTipoProducto"/>
		<br/>
		&nbsp;&nbsp;&nbsp;
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
					<img title="Eliminar Unidad Medida" src="./include/img/Delete.png" onclick="mensajeUsuarioConProcedimiento('alertMensaje','Confirmar Acción','Atención, se procederá a ELIMINAR la unidad de medida <?=$unidadMedida[$i]['uni_nombre']?>, ¿Desea continuar?','./controller/server/controlador_tipoProducto.php','uni_id=<?=$unidadMedida[$i]['uni_id']?>&op=eliminarUM','./view/dialog/editarTipoProducto.php','tip_prod_id=<?=$_POST['tip_prod_id']?>&tip_descripcion=<?=$_POST['tip_descripcion']?>','#modalEditarTipoProducto')" style="cursor: pointer;" style="cursor: pointer;')"/>
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