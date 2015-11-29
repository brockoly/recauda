<?php
if ( $_SESSION['usuario'] == null ) {
		$GoTo = "../../../login/index.php";
		header(sprintf("Location: %s", $GoTo));
	}
	require_once('../../class/Conectar.class.php'); $objCon = new Conectar();
	require_once('../../class/Producto.class.php'); $objPro = new Producto();
	$objCon->db_connect();
	$listaProductos = $objPro->listarProductos($objCon);
	$listaProductosE = $objPro->listarProductosEliminados($objCon);
?>
<script type="text/javascript" src="controller/client/js_busqudaProducto.js"></script>
<center><h3>Listado de producto</h3></center>
<div id="btnAgregarTipoProducto"><img src="./include/img/tipo_producto.png" width="25" height="25"> Tipo</div>
<div id="btnAgregarProducto"><img src="./include/img/mas.png" width="25" height="25"> Producto</div>
<div id="btnAgregarUm"><img src="./include/img/medida.png" width="25" height="25"> Unidad Medida</div>
<br><br>
<center>
	<table class="display" width="100%" id="tblProductos">
            <thead>
	            <tr>
	              <th width="10%">Id</th>
	              <th width="10%">Tipo</th>
	              <th width="70%">Descripción</th>
	              <th width="10%">Opciones</th>
	            </tr>
            </thead>
            <tbody>
            	<?
            	for($i=0; $i<count($listaProductos); $i++){
	        ?> 	<tr>
            		<td><?=$listaProductos[$i]['pro_id']?></td>
					<td><?=$listaProductos[$i]['tip_descripcion']?></td>
					<td><?=$listaProductos[$i]['pro_nom']?></td>
					<td>
						<img title="Editar producto" src="./include/img/Edit.png" onclick="ventanaModal('./view/dialog/editarProducto.php','pro_id=<?=$listaProductos[$i]["pro_id"]?>','auto','auto','Editar Producto','modalEditarProducto')" style="cursor: pointer;')"/>
						&nbsp;&nbsp;&nbsp;							
						<img title="Eliminar Producto" src="./include/img/Delete.png" onclick="mensajeUsuarioConProcedimiento('alertMensaje','Confirmar Acción','Atención, se procederá a ELIMINAR el producto <?=$listaProductos[$i]['tip_descripcion']?>, ¿Desea continuar?','./controller/server/controlador_prevision.php','pre_id=<?=$datos[$i]['pre_id']?>&op=desactivarPrevision','view/interface/busquedaPrevision.php','pre_id=<?=$_POST['pre_id']?>&pre_nombre=<?=$_POST['pre_nombre']?>','#contenidoCargado')"/>						
					</td>
	            </tr>
            <? 	}
            ?>	
            </tbody>
    </table>
</center>
<br/>

<center><h3>Listado de productos eliminados</h3></center>
<br><br>
<center>
	<table class="display" width="100%" id="tblProductoEliminados">
            <thead>
	            <tr>
	              <th width="10%">Id</th>
	              <th width="10%">Tipo</th>
	              <th width="70%">Descripción</th>
	              <th width="10%">Opciones</th>
	            </tr>
            </thead>
            <tbody>
            	<?
            	for($i=0; $i<count($listaProductosE); $i++){
	        ?> 	<tr>
            		<td><?=$listaProductosE[$i]['pro_id']?></td>
					<td><?=$listaProductosE[$i]['tip_descripcion']?></td>
					<td><?=$listaProductosE[$i]['pro_nom']?></td>
					<td>						
						<img title="Restaurar Producto" src="./include/img/restaurar.png" onclick="mensajeUsuarioConProcedimiento('alertMensaje','Confirmar Acción','Atención, se procederá a DESACTIVAR la previsión <?=$datos[$i]['pre_nombre']?>, ¿Desea desactivar esta previsión?','./controller/server/controlador_prevision.php','pre_id=<?=$datos[$i]['pre_id']?>&op=desactivarPrevision','view/interface/busquedaPrevision.php','pre_id=<?=$_POST['pre_id']?>&pre_nombre=<?=$_POST['pre_nombre']?>','#contenidoCargado')"/>						
					</td>
	            </tr>
            <? 	}
            ?>	
            </tbody>
    </table>
</center>