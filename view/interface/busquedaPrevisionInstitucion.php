<?php
if ( $_SESSION['usuario'] == null ) {
		$GoTo = "../../../login/index.php";
		header(sprintf("Location: %s", $GoTo));
	}
	require_once('../../class/Conectar.class.php');
	require_once('../../class/Prevision.class.php');
	$objCon = new Conectar();
	$objPre = new Prevision();
	$objPre->setPrevision($_POST['pre_id'], $_POST['pre_nombre']); 
	$objCon->db_connect();
	$datos = $objPre->obtenerInstitucionesPrevision($objCon);
	$objCon=null;
?>
<script type="text/javascript" src="controller/client/js_busqudaPrevisionInstitucion.js"></script>
<center><h3>Listado de Instituciones asociadas</h3></center>
<div id="btnAsociarInstitucion" onclick="ventanaModal('./view/dialog/asociarInstitucion','pre_id=<?=$_POST['pre_id']?>&pre_nombre=<?=$_POST['pre_nombre']?>','auto','auto','Asociar a Institucion','modalAsociarInstitucion')"><img src="./include/img/user.png" width="25" height="25"> Asociar Institución</div>
<br>
<center>
<div style="width]:500px;">
	<table class="display" width="100%" id="tabPrevisionInstitucion">
            <thead>
            <td><th colspan="3">Institución</th></td>
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
							<img title="Eliminar Asociación" src="./include/img/Delete.png" onclick="mensajeUsuarioConProcedimiento('alertMensaje','Confirmar Acción','Atención, se procederá a eliminar la asociación entre <?=$datos[$i]['ins_nombre']?> y <?=$_POST['pre_nombre']?>, ¿Desea Elimininar Este Asociación?','./controller/server/controlador_prevision.php','pre_id=<?=$_POST['pre_id']?>&ins_id=<?=$datos[$i]['ins_id']?>&op=eliminarAsociacionIns','view/interface/busquedaPrevisionInstitucion.php','pre_id=<?=$_POST['pre_id']?>&pre_nombre=<?=$_POST['pre_nombre']?>','#contenidoPrevisionInstitucion')" style="cursor: pointer;"/>
							
							&nbsp;&nbsp;&nbsp;
						</td>
	            </tr>
            <?php 	}
            ?>	
    </table>
</center>
