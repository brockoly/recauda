<?php
	//LLAMADA DE CLASES
	require_once('../../class/Conectar.class.php'); $objCon = new Conectar(); 
	require_once('../../class/Producto.class.php'); $objPro = new Producto();
	//LLAMADA DE METODOS.
	$objCon->db_connect();
	$objCon=null;
?>
<script type="text/javascript" src="controller/client/js_agregarProducto.js"></script>
<fieldset style="width: 400px;"><legend>Datos Tipo Producto</legend>
<center>
<table>
		<tr>
			<td>Nombre:</td>
			<td>&nbsp;&nbsp;&nbsp;<input type="text" id="tip_descripcion" />&nbsp;&nbsp;<img src="include/img/Information.png" id="errPro_descripcion" hidden="true"  /></td>
		</tr>
</table>
</center><br><br>
</fieldset>
<br><br>

<center><input type="button" id="btnAddTipo" value="Agregar Tipo"/></center>
<br><br>
</fieldset>