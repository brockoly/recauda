<?php
	require_once('../../class/Conectar.class.php');
	require_once('../../class/Usuario.class.php');
	require_once('../../class/Util.class.php');	
	$objUsu = new Usuario();
	$objCon = new Conectar(); 
	$objUtil = new Util(); 
	$objCon->db_connect();
	$datos = $objUsu->desplegarUsuarios($objCon,0);
	$objCon=null;
	//var_dump($datos);
?>
<script type="text/javascript" src="controller/client/js_busqudaUsuario.js"></script>
<center><h3>Listado de usuarios</h3></center>
<div id="btnAgregaUsuario" onclick="ventanaModal('./view/dialog/agregarUsuario.php','','auto','auto','Registro de Usuario','modalAgregarUsuario')"><img src="./include/img/agregar.png" width="25" height="25"  > Agregar Usuario
</div>
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
	              <th width="10%">Dirección</th>
	              <th width="10%">Opciones Usuario</th>
	            </tr>
            </thead>
            <?php
            	for($i=0; $i<count($datos); $i++){
	        ?> 
	        	<tr>
	        			<td><?=$datos[$i]['usuario']?></td>
						<td><?=$objUtil->formatRut($datos[$i]['rut'])?></td>
						<td><?=$datos[$i]['nombre']?></td>
						<td><?=$datos[$i]['apellidoPaterno']?></td>
						<td><?=$datos[$i]['aplellidoMaterno']?></td>
						<td><?=$datos[$i]['telefono']?></td>
						<td><?=$datos[$i]['correo']?></td>
						<td><?=$datos[$i]['direccion']?></td>
						<td>
							<img title="Editar Usuario" src="./include/img/Edit.png" onclick="ventanaModal('./view/dialog/editarUsuario.php','usu_nombre=<?=$datos[$i]['usuario']?>','auto','auto','Editar Usuario','modalEditarUsuario')" style="cursor: pointer;"/>
							&nbsp;&nbsp;
							<img title="Eliminar Usuario" src="./include/img/Delete.png" onclick="mensajeUsuarioConProcedimiento('alertMensaje','Confirmar Acción','Atención, se procederá a eliminar el usuario, ¿Desea Eliminar Este Usuario?','./controller/server/controlador_usuario.php','per_id=<?=$datos[$i]['rut']?>&op=eliminarUsuario','view/interface/busquedaUsuario.php','','#contenidoCargado')" style="cursor: pointer;"/>
							&nbsp;&nbsp;
							<img title="Resetear Clave" width="16" height="16" src="./include/img/reset_pass.png" onclick="mensajeUsuarioConProcedimiento('alertMensaje','Confirmar Acción','Atención se procedera a restaurar la clave de ingreso, ¿Desea restaurar la clave a este Usuario?','./controller/server/controlador_usuario.php','usu_nombre=<?=$datos[$i]['usuario']?>&op=restaurarClave','view/interface/busquedaUsuario.php','','#contenidoCargado')" style="cursor: pointer;"/>
						</td>
	            </tr>
            <?php 	}
            ?>	
    </table>
</center>

