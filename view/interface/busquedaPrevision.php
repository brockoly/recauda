<?php
	require_once('../../class/Conectar.class.php');
	require_once('../../class/Prevision.class.php');
	$objCon = new Conectar();
	$objPre = new Prevision(); 
	$objCon->db_connect();
	$datos = $objPre->obtenerPrevisionesActivas($objCon);
	$datos2= $objPre->obtenerPrevisionesInactivas($objCon);
	$objCon=null;	
?>
<script type="text/javascript" src="controller/client/js_busqudaPrevision.js"></script>
<center><h3>Listado de Previsiones</h3></center>
<div id="btnAgregarPrevision" onclick="ventanaModal('./view/dialog/agregarPrevision','','auto','auto','Registro de Prevision','modalAgregarPrevision')"><img src="./include/img/world.png" width="25" height="25"> Agregar Previsión</div>
<br>
<center>
<div style="width]:500px;">
	<table class="display" width="100%" id="tabPrevision">
            <thead>
	            <tr>
	              <th width="10%">Id</th>
	              <th width="10%">Nombre</th>
	              <th width="10%">Opciones</th>
	            </tr>
            </thead>
            <?php
            	for($i=0; $i<count($datos); $i++){
	        ?> 	<tr>
	            		<td><?=$datos[$i]['pre_id']?></td>
						<td align=""><?=$datos[$i]['pre_nombre']?></td>
						<td>
							<img title="Editar Previsión" src="./include/img/Edit.png" onclick="ventanaModal('./view/dialog/editarPrevision.php','pre_id=<?=$datos[$i]['pre_id']?>&pre_nombre=<?=$datos[$i]['pre_nombre']?>','auto','auto','Editar Previsión','modalEditarPrevision')" style="cursor: pointer;')"/>
							&nbsp;&nbsp;&nbsp;							
							<img title="Desactivar Previsión" src="./include/img/Delete.png" onclick="mensajeUsuarioConProcedimiento('alertMensaje','Confirmar Acción','Atención, se procederá a DESACTIVAR la previsión <?=$datos[$i]['pre_nombre']?>, ¿Desea desactivar esta previsión?','./controller/server/controlador_prevision.php','pre_id=<?=$datos[$i]['pre_id']?>&op=desactivarPrevision','view/interface/busquedaPrevision.php','pre_id=<?=$_POST['pre_id']?>&pre_nombre=<?=$_POST['pre_nombre']?>','#contenidoCargado')" style="cursor: pointer;" style="cursor: pointer;')"/>
							&nbsp;&nbsp;&nbsp;							
							<img title="Instituciones asociadas" height="16" width="16" src="./include/img/buscar.png" onclick="ventanaModal('./view/dialog/asociacionPrevisionInstitucion.php','pre_id=<?=$datos[$i]['pre_id']?>&pre_nombre=<?=$datos[$i]['pre_nombre']?>','600','900','Editar Asociaciones','modalEditarPrevision')" style="cursor: pointer;')"/>
							&nbsp;&nbsp;&nbsp;
						</td>
	            </tr>
            <?php 	}
            ?>
    </table>
<br><center><h3>Listado de Previsiones Inactivas</h3></center>
    <table class="display" width="100%" id="tabPrevisionInactiva">
            <thead>
	            <tr>
	              <th width="10%">Id</th>
	              <th width="10%">Nombre</th>
	              <th width="10%">Opciones</th>
	            </tr>
            </thead>
            <?php
            	for($i=0; $i<count($datos2); $i++){
	        ?> 	<tr>
	            		<td><?=$datos2[$i]['pre_id']?></td>
						<td align=""><?=$datos2[$i]['pre_nombre']?></td>
						<td>
							<img title="Editar Previsión" src="./include/img/Edit.png" onclick="ventanaModal('./view/dialog/editarPrevision.php','pre_id=<?=$datos2[$i]['pre_id']?>&pre_nombre=<?=$datos2[$i]['pre_nombre']?>','auto','auto','Editar Previsión','modalEditarPrevision')" style="cursor: pointer;')"/>
							&nbsp;&nbsp;&nbsp;							
							<img title="Restaurar Previsión" src="./include/img/restaurar.png" onclick="mensajeUsuarioConProcedimiento('alertMensaje','Confirmar Acción','Atención, se procederá a ACTIVAR la previsión <?=$datos2[$i]['pre_nombre']?>, ¿Desea activar esta previsión?','./controller/server/controlador_prevision.php','pre_id=<?=$datos2[$i]['pre_id']?>&op=activarPrevision','view/interface/busquedaPrevision.php','pre_id=<?=$_POST['pre_id']?>&pre_nombre=<?=$_POST['pre_nombre']?>','#contenidoCargado')" style="cursor: pointer;" style="cursor: pointer;')"/>
							&nbsp;&nbsp;&nbsp;							
							<img title="Instituciones asociadas" height="16" width="16" src="./include/img/buscar.png" onclick="ventanaModal('./view/dialog/asociacionPrevisionInstitucion.php','pre_id=<?=$datos2[$i]['pre_id']?>&pre_nombre=<?=$datos2[$i]['pre_nombre']?>','500','900','Editar Asociaciones','modalEditarPrevision')" style="cursor: pointer;')"/>
							&nbsp;&nbsp;&nbsp;
						</td>
	            </tr>
            <?php 	}
            ?>	
    </table>
</center>
