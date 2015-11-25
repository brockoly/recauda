<?
	//LLAMADA DE CLASES
	require_once('../../class/Conectar.class.php'); $objCon = new Conectar(); 
	require_once('../../class/Producto.class.php'); $objPro = new Producto();
	//LLAMADA DE METODOS.
	$objCon->db_connect();
	$objPro->setProducto('',$tip_prod_id);
	$unidadMedida = $objPro->listarUMProducto($objCon);
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
					<td>&nbsp;&nbsp;&nbsp;<input value="<?=$_POST['tip_descripcion']?>" type="text" id="txtNombreTipoProducto" onkeyup ="validar('txtNombreTipoProducto', 'id' ,'letras')" name="txtNombreTipoProducto"/>&nbsp;&nbsp;<img src="./include/img/information.png" id="errTipoProducto" hidden="true"/></td>
				</tr>
				<tr>
					<td></td>
					<td align="center"><br><input type="button" value="Modificar" id="btnModificarTipoProducto"/></td>
				</tr>
		</table><br>
		</fieldset>
</form>

<fieldset style=""><legend>Unidades de medida</legend>
<br>
	<table class="display" width="100%" id="tblUnidadesMedida">
            <thead>
	            <tr>
	              <th width="60%">Descripción</th>
	            </tr>
            </thead>
            <tbody>
			<?php
			for($i=0; $i<count($unidadMedida); $i++){
		?> 	<tr>
				<td><?=$unidadMedida[$i]['uni_nombre']?></td>
				<td>
					<img title="Editar Tipo Producto" src="./include/img/Edit.png" onclick="ventanaModal('./view/dialog/editarTipoProducto.php','tip_descripcion=<?=$tipoProducto[$i]["tip_descripcion"]?>&tip_prod_id=<?=$tipoProducto[$i]["tip_prod_id"]?>','auto','auto','Editar Tipo Producto','modalEditarTipoProducto')" style="cursor: pointer;')"/>
					&nbsp;&nbsp;&nbsp;
					<img title="Eliminar Tipo Producto" src="./include/img/Delete.png" onclick="mensajeUsuarioConProcedimiento('alertMensaje','Confirmar Acción','Atención, se procederá a ELIMINAR el tipo de producto <?=$tipoProducto[$i]["tip_descripcion"]?>, ¿Desea continuar?','./controller/server/controlador_producto.php','tip_prod_id=<?=$tipoProducto[$i]["tip_prod_id"]?>&op=eliminarTipo','./view/dialog/agregarTipoProducto.php','','#modalAgregarProducto')" style="cursor: pointer;" style="cursor: pointer;')"/>
					&nbsp;&nbsp;&nbsp;
				</td>
			</tr>
			<?php 	}
			?>	
            </tbody>
    </table>
<br>
</fieldset>