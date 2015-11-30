<?php
	require_once('../../class/Conectar.class.php');
	require_once('../../class/Institucion.class.php');	
	$objCon = new Conectar();
	$objIns = new Institucion(); 
	$objCon->db_connect();
	$datos = $objIns->obtenerInstitucionesActivas($objCon);
	$datos2= $objIns->obtenerInstitucionesInactivas($objCon);
	$objCon=null;
?>
<script type="text/javascript" src="controller/client/js_busqudaConvenio.js"></script>
<center><h3>Listado de Convenios</h3></center>
<div id="btnAgregarConvenio" onclick="ventanaModal('./view/dialog/agregarConvenio','','auto','auto','Registro de Convenio','modalAgregarConvenio')"><img src="./include/img/world.png" width="25" height="25"> Agregar Convenio</div>
<br>
<center>
<div style="width]:500px;">
	<table class="display" width="100%" id="tabUsuario">
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
	            		<td><?=$datos[$i]['ins_id']?></td>
						<td align=""><?=$datos[$i]['ins_nombre']?></td>
						<td>
							<img title="Editar Institución" src="./include/img/Edit.png" onclick="ventanaModal('./view/dialog/editarConvenio.php','ins_id=<?=$datos[$i]['ins_id']?>&ins_nombre=<?=$datos[$i]['ins_nombre']?>','auto','auto','Editar Institución','modalEditarConvenio')" style="cursor: pointer;')"/>
							&nbsp;&nbsp;&nbsp;							
							<img title="Desactivar Institución" src="./include/img/Delete.png" onclick="mensajeUsuarioConProcedimiento('alertMensaje','Confirmar Acción','Atención, se procederá a DESACTIVAR la Institución <?=$datos[$i]['ins_nombre']?>, ¿Desea desactivar esta Institución?','./controller/server/controlador_convenio.php','ins_id=<?=$datos[$i]['ins_id']?>&op=desactivarInstitucion','view/interface/busquedaConvenio.php','ins_id=<?=$_POST['ins_id']?>&ins_nombre=<?=$_POST['ins_nombre']?>','#contenidoCargado')" style="cursor: pointer;" style="cursor: pointer;')"/>
							&nbsp;&nbsp;&nbsp;							
							<img title="Previsiones asociadas" height="16" width="16" src="./include/img/buscar.png" onclick="ventanaModal('./view/dialog/asociacionInstitucionPrevision.php','ins_id=<?=$datos[$i]['ins_id']?>&ins_nombre=<?=$datos[$i]['ins_nombre']?>','600','900','Editar Asociaciones','modalEditarConvenio')" style="cursor: pointer;')"/>
							&nbsp;&nbsp;&nbsp;
						</td>
	            </tr>
            <?php 	}
            ?>	
    </table>
    <br><center><h3>Listado de Instituciones Inactivas</h3></center>
    <table class="display" width="100%" id="tabConvenioInactiva">
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
	            		<td><?=$datos2[$i]['ins_id']?></td>
						<td align=""><?=$datos2[$i]['ins_nombre']?></td>
						<td>
							<img title="Editar Institución" src="./include/img/Edit.png" onclick="ventanaModal('./view/dialog/editarConvenio.php','ins_id=<?=$datos2[$i]['ins_id']?>&ins_nombre=<?=$datos2[$i]['ins_nombre']?>','auto','auto','Editar Institución','modalEditarConvenio')" style="cursor: pointer;')"/>
							&nbsp;&nbsp;&nbsp;							
							<img title="Restaurar Institución" src="./include/img/restaurar.png" onclick="mensajeUsuarioConProcedimiento('alertMensaje','Confirmar Acción','Atención, se procederá a ACTIVAR la Institución <?=$datos2[$i]['ins_nombre']?>, ¿Desea activar esta institución?','./controller/server/controlador_convenio.php','ins_id=<?=$datos2[$i]['ins_id']?>&op=activarInstitucion','view/interface/busquedaConvenio.php','ins_id=<?=$_POST['ins_id']?>&ins_nombre=<?=$_POST['ins_nombre']?>','#contenidoCargado')" style="cursor: pointer;" style="cursor: pointer;')"/>
							&nbsp;&nbsp;&nbsp;							
							<img title="Previsiones asociadas" height="16" width="16" src="./include/img/buscar.png" onclick="ventanaModal('./view/dialog/asociacionInstitucionPrevision.php','ins_id=<?=$datos2[$i]['ins_id']?>&ins_nombre=<?=$datos2[$i]['ins_nombre']?>','600','900','Editar Asociaciones','modalEditarConvenio')" style="cursor: pointer;')"/>
							&nbsp;&nbsp;&nbsp;
						</td>
	            </tr>
            <?php 	}
            ?>	
    </table>
</center>
