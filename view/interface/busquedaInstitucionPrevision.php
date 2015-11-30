<?php
	require_once('../../class/Conectar.class.php');
	require_once('../../class/Institucion.class.php');
	$objCon = new Conectar();
	$objIns = new Institucion();
	$objIns->setInstitucion($_POST['ins_id'], $_POST['ins_nombre']); 
	$objCon->db_connect();
	$datos = $objIns->obtenerPrevisionesInstitucion($objCon);
	$objCon=null;
?>
<script type="text/javascript" src="controller/client/js_busqudaInstitucionPrevision.js"></script>
<center><h3>Listado de Previsiones asociadas</h3></center>
<div id="btnAsociarPrevision" onclick="ventanaModal('./view/dialog/asociarPrevision','ins_id=<?=$_POST['ins_id']?>&ins_nombre=<?=$_POST['ins_nombre']?>','auto','auto','Asociar a Previsión','modalAsociarPrevision')"><img src="./include/img/user.png" width="25" height="25"> Asociar Previsión</div>
<br>
<center>
<div style="width]:500px;">
	<table class="display" width="100%" id="tabInstitucionPrevision">
            <thead>
            <td><th colspan="3">Previsión</th></td>
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
						<? 
							if(count($datos)>1){
						?>
							<img title="Eliminar Asociación" src="./include/img/Delete.png" onclick="mensajeUsuarioConProcedimiento('alertMensaje','Confirmar Acción','Atención, se procederá a eliminar la asociación entre <?=$datos[$i]['pre_nombre']?> y <?=$_POST['ins_nombre']?>, ¿Desea elimininar esta asociación?','./controller/server/controlador_convenio.php','ins_id=<?=$_POST['ins_id']?>&pre_id=<?=$datos[$i]['pre_id']?>&op=eliminarAsociacionPre','view/interface/busquedaInstitucionPrevision.php','ins_id=<?=$_POST['ins_id']?>&ins_nombre=<?=$_POST['ins_nombre']?>','#contenidoInstitucionPrevision')" style="cursor: pointer;"/>
							
							&nbsp;&nbsp;&nbsp;
							<? }else{ ?><img id="informationMessage" src="./include/img/Information.png" /><? } ?>
						</td>
	            </tr>
            <?php 	}
            ?>	
    </table>
</center>
