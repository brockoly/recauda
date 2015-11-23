<?php
	//LLAMADA DE CLASES
	require_once('../../class/Conectar.class.php'); $objCon = new Conectar(); 
	require_once('../../class/Producto.class.php'); $objPro = new Producto();
	//LLAMADA DE METODOS.
	$objCon->db_connect();
	$tipoProducto = $objPro->tipoProducto($objCon);
	$tipoProdcutoEliminados = $objPro->tipoProductoEliminado($objCon);
	$objCon=null;
?>
<script type="text/javascript" src="controller/client/js_agregarTipoProducto.js"></script>
<center>
<fieldset style="width: 400px;"><legend>Datos Tipo Producto</legend>
<center>
<table>
		<tr>
			<td>Nombre:</td>
			<td>&nbsp;&nbsp;&nbsp;<input type="text" id="tip_descripcion" />&nbsp;&nbsp;<img src="include/img/Information.png" id="errtip_descripcion" hidden="true"  /></td>
		</tr>
</table>
</center><br><br>
</fieldset>
<br><br>
<center><input type="button" id="btnAddTipo" value="Agregar Tipo"/></center>
<br><br>
</fieldset>
<fieldset style=""><legend>Tipos de Productos</legend>
<br>
	<table class="display" width="100%" id="tblTipoProducto">
            <thead>
	            <tr>
	              <th width="60%">Nombre</th>
	              <th width="40%">Opciones</th>
	            </tr>
            </thead>
            <tbody>
			<?php
			for($i=0; $i<count($tipoProducto); $i++){
		?> 	<tr>
				<td><?=$tipoProducto[$i]['tip_descripcion']?></td>
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

<br><br>
</fieldset>
<fieldset style=""><legend>Tipos de Productos Eliminados</legend>
<br>
	<table class="display" width="100%" id="tblTipoProductoEliminado">
            <thead>
	            <tr>
	              <th width="60%">Nombre</th>
	              <th width="40%">Opciones</th>
	            </tr>
            </thead>
            <tbody>
			<?php
			for($i=0; $i<count($tipoProdcutoEliminados); $i++){
		?> 	<tr>
				<td><?=$tipoProdcutoEliminados[$i]['tip_descripcion']?></td>
				<td>
					<img title="Restaurar Tipo Producto" src="./include/img/restaurar.png" onclick="mensajeUsuarioConProcedimiento('alertMensaje','Confirmar Acción','Atención, se procederá a RESTAURAR el tipo de producto <?=$tipoProdcutoEliminados[$i]["tip_descripcion"]?>, ¿Desea continuar?','./controller/server/controlador_producto.php','tip_prod_id=<?=$tipoProdcutoEliminados[$i]["tip_prod_id"]?>&op=restaurarTipo','./view/dialog/agregarTipoProducto.php','','#modalAgregarProducto')" style="cursor: pointer;" style="cursor: pointer;')"/>
					&nbsp;&nbsp;&nbsp;
				</td>
			</tr>
			<?php 	}
			?>	
            </tbody>
    </table>
<br>

</center>