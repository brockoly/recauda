<?php
	require_once('../../class/Conectar.class.php');
	require_once('../../class/Usuario.class.php');
	$usuario = new Usuario();
?>
<script type="text/javascript" src="controller/client/js_busqudaProducto.js"></script>
<center><h3>Listado de producto</h3></center>
<!--
<fieldset style="width:300px;"><legend>Busqueda de Usuario</legend>
<table border="0">
		<tr><td><input type="text" placeholder="Ingrese un nombre" id="txtBusqueda" />&nbsp;&nbsp</td><td><img src="./include/img/buscar.png" width="30" height="30" id="btnBuscar"></td></tr>
</table>
</fieldset><br><br>
-->
<div id="btnAgregarTipoProducto" onclick="ventanaModal('./view/dialog/agregarTipoProducto','','auto','auto','Registro De Tipo De Producto','modalAgregarProducto')"><img src="./include/img/tipo_producto.png" width="25" height="25"> Tipo</div>
<div id="btnAgregarProducto" onclick="ventanaModal('./view/dialog/agregarProducto','','auto','auto','Registro De Producto','modalAgregarProducto')"><img src="./include/img/mas.png" width="25" height="25"> Producto</div>
<br><br>
<center>
	<table class="display" width="100%" id="tblProductos">
            <thead>
	            <tr>
	              <th width="10%">N°</th>
	              <th width="10%">Fecha</th>
	              <th width="10%">Folio</th>
	              <th width="30%">Tipo</th>
	              <th width="30%">Valor</th>
	              <th width="20%">Usuario</th>
	            </tr>
            </thead>
            <tbody>
            	
            </tbody>
    </table>

</center>