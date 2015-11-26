<?php
	require_once('../../class/Conectar.class.php'); $objCon = new Conectar();
	require_once('../../class/Producto.class.php'); $objPro = new Producto();
	$objCon->db_connect();
	$listaProductos = $objPro->listarProductos($objCon);
?>
<script type="text/javascript" src="controller/client/js_busqudaProducto.js"></script>
<center><h3>Listado de producto</h3></center>
<div id="btnAgregarTipoProducto" onclick="ventanaModal('./view/dialog/agregarTipoProducto','','auto','auto','Registro De Tipo De Producto','modalAgregarProducto')"><img src="./include/img/tipo_producto.png" width="25" height="25"> Tipo</div>
<div id="btnAgregarProducto" onclick="ventanaModal('./view/dialog/agregarProducto','','auto','auto','Registro De Producto','modalAgregarProducto')"><img src="./include/img/mas.png" width="25" height="25"> Producto</div>
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
							<img title="Editar producto" src="./include/img/Edit.png" onclick=""/>
							&nbsp;&nbsp;&nbsp;							
							<img title="Eliminar Producto" src="./include/img/Delete.png" onclick=""/>						
						</td>
	            </tr>
            <? 	}
            ?>	
            </tbody>
    </table>
</center>