<?php
if ( $_SESSION['usuario'] == null ) {
		$GoTo = "../../../login/index.php";
		header(sprintf("Location: %s", $GoTo));
	}
	//LLAMADA DE CLASES
	require_once('../../class/Conectar.class.php'); $objCon = new Conectar(); 
	require_once('../../class/Unidad_Medida.class.php'); $objUni = new Unidad_Medida();
	require_once('../../class/Tipo_Producto.class.php');$objTipoPro = new Tipo_Producto();
	//LLAMADA DE METODOS.
	$objCon->db_connect();
	$listaUnidad = $objUni->listarUnidadMedida($objCon);
	$listaUnidadEliminados = $objUni->listarUnidadMedidaEliminados($objCon);
	$objCon=null;
?>
<script type="text/javascript" src="controller/client/js_agregarUnidadMedida.js"></script>
<center>
<form id="frmTipoProducto">
<fieldset style="width: 400px;"><legend>Datos Unidad de Medida</legend>
<center>
<table>
	<tr>
		<td width="25%">Descripción:</td>
		<td>&nbsp;&nbsp;&nbsp;<input type="text" name="txtDesUnidad" id="txtDesUnidad" />&nbsp;&nbsp;<img src="include/img/Information.png" id="errUnidadDes" hidden="true"  /></td>
	</tr>
</table>
</center><br><br>
</fieldset>
</form>
<br><br>
<center><input type="button" id="btnAddUnidad" value="Agregar UM"/></center>
<br><br>
</fieldset>
<fieldset style=""><legend>Unidades de medida</legend>
<br>
	<table class="display" width="100%" id="tblUnidadMedida">
            <thead>
	            <tr>
	              <th width="60%">Descripción</th>
	              <th width="40%">Opciones</th>
	            </tr>
            </thead>
            <tbody>
			<?php
			for($i=0; $i<count($listaUnidad); $i++){
		?> 	<tr>
				<td><?=$listaUnidad[$i]['uni_nombre']?></td>
				<td>
					<img title="Editar Unidad Medida" src="./include/img/Edit.png" onclick="ventanaModal('./view/dialog/editarUnidadMedida.php','uni_nombre=<?=$listaUnidad[$i]['uni_nombre']?>&uni_id=<?=$listaUnidad[$i]['uni_id']?>','auto','auto','Editar Unidad de Medida','modalEditarUnidadMedida')" style="cursor: pointer;')"/>
					&nbsp;&nbsp;&nbsp;												
					<img title="Eliminar Unidad Medida" src="./include/img/Delete.png" onclick="mensajeUsuarioConProcedimiento('alertMensaje','Confirmar Acción','Atención, se procederá a ELIMINAR la unidad de medida <?=$listaUnidad[$i]['uni_nombre']?>, ¿Desea continuar?','./controller/server/controlador_unidadMedida.php','uni_id=<?=$listaUnidad[$i]['uni_id']?>&op=eliminarUM','./view/dialog/agregarUnidadMedida.php','','#modalAgregarUnidadMedida')" style="cursor: pointer;" style="cursor: pointer;')"/>
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
<fieldset style=""><legend>Unidades de medida eliminados</legend>
<br>
	<table class="display" width="100%" id="tblUnidadMedidaEliminada">
            <thead>
	            <tr>
	              <th width="60%">Nombre</th>
	              <th width="40%">Opciones</th>
	            </tr>
            </thead>
            <tbody>
			<?php
			for($i=0; $i<count($listaUnidadEliminados); $i++){
		?> 	<tr>
				<td><?=$listaUnidadEliminados[$i]['uni_nombre']?></td>
				<td>
					<img title="Restaurar Unidad Medida" src="./include/img/restaurar.png" onclick="mensajeUsuarioConProcedimiento('alertMensaje','Confirmar Acción','Atención, se procederá a RESTAURAR la unidad de medida <?=$listaUnidadEliminados[$i]['uni_nombre']?>, ¿Desea continuar?','./controller/server/controlador_unidadMedida.php','uni_id=<?=$listaUnidadEliminados[$i]['uni_id']?>&op=restaurarUM','./view/dialog/agregarUnidadMedida.php','','#modalAgregarUnidadMedida')" style="cursor: pointer;" style="cursor: pointer;')"/>
					&nbsp;&nbsp;&nbsp;
				</td>
			</tr>
			<?php 	}
			?>	
            </tbody>
    </table>
<br>

</center>