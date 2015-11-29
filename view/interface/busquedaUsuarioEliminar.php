<?php
if ( $_SESSION['usuario'] == null ) {
		$GoTo = "../../../login/index.php";
		header(sprintf("Location: %s", $GoTo));
	}
	require_once('../../class/Conectar.class.php');
	require_once('../../class/Usuario.class.php');	
	$objUsu = new Usuario();
	$objCon = new Conectar(); 
	$objCon->db_connect();
	$datos = $objUsu->desplegarUsuarios($objCon,1);
	$objCon=null;
	//var_dump($datos);
?>
<script type="text/javascript" src="controller/client/js_busqudaUsuario.js"></script>
<center><h3>Listado de usuarios Eliminado</h3></center>
<br><br>
<center>
	<table class="display" width="100%" id="tabUsuario">
            <thead>
	            <tr>
	              <th width="10%">Usuario</th>
	              <th width="10%">Rut</th>
	              <th width="10%">Nombre</th>
	              <th width="10%">Apellido Paterno</th>
	              <th width="10%">Apellido Materno</th>
	              <th width="10%">Telefono</th>	              
	              <th width="10%">Correo</th>
	              <th width="10%">Opciones Usuario</th>
	            </tr>
            </thead>
            <?php
            	for($i=0; $i<count($datos); $i++){
	        ?> 	<tr>
	            		<td><?=$datos[$i]['usuario']?></td>
						<td><?=$datos[$i]['rut']?></td>
						<td><?=$datos[$i]['nombre']?></td>
						<td><?=$datos[$i]['apellidoPaterno']?></td>
						<td><?=$datos[$i]['aplellidoMaterno']?></td>
						<td><?=$datos[$i]['telefono']?></td>
						<td><?=$datos[$i]['correo']?></td>
						<td>
							<img title="Restaurar Usuario" src="./include/img/restaurar.png" onclick="mensajeUsuarioConProcedimiento('','Confirmar Acción','¿Desea Restaurar Este Usuario?','./controller/server/controlador_usuario.php','usu_nombre=<?=$datos[$i]['usuario']?>&op=restaurarUsuario','view/interface/busquedaUsuarioEliminar.php','','#contenidoCargado')" style="cursor: pointer;"/>
						</td>
	            </tr>
            <?php 	}
            ?>	
    </table>
</div>
</center>