<?php
	require_once('../../class/Conectar.class.php');
	require_once('../../class/Nacionalidad.class.php');	
	$objCon = new Conectar();
	$objNac = new Nacionalidad(); 
	$objCon->db_connect();
	$datos = $objNac->obtenerNacionalidades($objCon);
	$objCon=null;
?>
<script type="text/javascript" src="controller/client/js_busqudaNacionalidad.js"></script>
<center><h3>Listado de Nacionalidades</h3></center>
<div id="btnAgregarNacionalidad" onclick="ventanaModal('./view/dialog/agregarNacionalidad','','auto','auto','Registro de Nacionalidad','modalAgregarNacionalidad')"><img src="./include/img/world.png" width="25" height="25"> Agregar Nacionalidad</div>
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
	            		<td><?=$datos[$i]['nac_id']?></td>
						<td align=""><?=$datos[$i]['nac_nombre']?></td>
						<td>
							<img title="Editar Nacionalidad" src="./include/img/Edit.png" onclick="ventanaModal('./view/dialog/editarNacionalidad.php','nac_id=<?=$datos[$i]['nac_id']?>&nac_nombre=<?=$datos[$i]['nac_nombre']?>','auto','auto','Editar Nacionalidad','modalEditarNacionalidad')" style="cursor: pointer;"/>
							&nbsp;&nbsp;&nbsp;							
						</td>
	            </tr>
            <?php 	}
            ?>	
    </table>
</center>