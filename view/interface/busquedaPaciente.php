<?php
	require_once('../../class/Conectar.class.php');
	require_once('../../class/Paciente.class.php');
	require_once('../../class/Util.class.php');

	$objCon = new Conectar;
	$objPac = new Paciente;
	$objUtil = new Util;
	$objCon->db_connect();
	$pacientes = $objPac->desplegarPacientes($objCon);
	$pacientesEli = $objPac->desplegarPacientesEliminados($objCon);
	$objCon=null;

?>
<script type="text/javascript" src="controller/client/js_busqudaPaciente.js"></script>
<center><h3>Listado de pacientes</h3></center>
<div id="btnAgregarPaciente" onclick="ventanaModal('./view/dialog/agregarPaciente.php','','auto','auto','Registro de Paciente','modalAgregarPaciente')"><img src="./include/img/patient.png" width="25" height="25"> Agregar Paciente</div>
<br><br>
<center>
	<table class="display" width="100%" id="tabPaciente">
            <thead>
	            <tr>
	              <th width="10%">Identificador</th>
	              <th width="10%">Nombres</th>
	              <th width="10%">Apellido Paterno</th>
	              <th width="10%">Apellido Materno</th>
	              <th width="10%">Fecha Nac.</th>
	              <th width="10%">Nacionalidad</th>
	              <th width="10%">Sexo</th>
	              <th width="10%">Dirección</th>
	              <th width="10%">Opciones</th>
	            </tr>
            </thead>
            	<?
            		for ($i=0; $i<count($pacientes); $i++) { ?> 
					<tr>
						<td><? if($pacientes[$i]['Nacionalidad']=='Chile'){echo $objUtil->formatRut($pacientes[$i]['Identificador']);}else{echo $pacientes[$i]['Identificador'];}?></td>
						<td><?= $pacientes[$i]['Nombre']?></td>
						<td><?= $pacientes[$i]['Apellido_Paterno']?></td>
						<td><?= $pacientes[$i]['Apellido_Materno']?></td>
						<td><?= $objUtil->cambiarfecha_mysql_a_normal($pacientes[$i]['fecha_nac'])?></td>
						<td><?= $pacientes[$i]['Nacionalidad']?></td>
						<td><?= $pacientes[$i]['sexo']?></td>
						<td><?= $pacientes[$i]['direccion']?></td>
						<td>
						<img name="btnEditar" title="Editar Nacionalidad" src="./include/img/Edit.png" onclick="ventanaModal('./view/dialog/editarPaciente.php','pac_id=<?=$pacientes[$i]['pac_id']?>','auto','auto','Editar Paciente','modalEditarPaciente')" style="cursor: pointer;"/>
						<img title="Eliminar Paciente" src="./include/img/Delete.png" onclick="mensajeUsuarioConProcedimiento('alertMensaje','Confirmar Acción','Atención, se procederá a eliminar al paciente, ¿Desea continuar?','./controller/server/controlador_paciente.php','pac_id=<?=$pacientes[$i]['pac_id']?>&op=eliminarPaciente','view/interface/busquedaPaciente.php','','#contenidoCargado')" style="cursor: pointer;"/>
						&nbsp;&nbsp;&nbsp;
						</td>
					</tr>
            		<? }
            	?>
            
    </table>
    <br/><br/>
    <hr>
    <br/><br/>
	<h3>Listado de pacientes eliminados</h3>
	<table class="display" width="100%" id="tabPacienteRes">
            <thead>
	            <tr>
	              <th width="10%">Identificador</th>
	              <th width="10%">Nombres</th>
	              <th width="10%">Apellido Paterno</th>
	              <th width="10%">Apellido Materno</th>
	              <th width="10%">Fecha Nac.</th>
	              <th width="10%">Nacionalidad</th>	 
	              <th width="10%">Sexo</th>
	              <th width="10%">Dirección</th>
	              <th width="10%">Opciones</th>
	            </tr>
            </thead>
            	<?
            		for ($i=0; $i<count($pacientesEli); $i++) { ?> 
					<tr>
						<td><? if($pacientesEli[$i]['Nacionalidad']=='Chile'){echo $objUtil->formatRut($pacientesEli[$i]['Identificador']);}else{echo $pacientesEli[$i]['Identificador'];}?></td>
						<td><?= $pacientesEli[$i]['Nombre']?></td>
						<td><?= $pacientesEli[$i]['Apellido_Paterno']?></td>
						<td><?= $pacientesEli[$i]['Apellido_Materno']?></td>
						<td><?= $objUtil->cambiarfecha_mysql_a_normal($pacientesEli[$i]['fecha_nac'])?></td>
						<td><?= $pacientesEli[$i]['Nacionalidad']?></td>
						<td><?= $pacientesEli[$i]['sexo']?></td>
						<td><?= $pacientesEli[$i]['direccion']?></td>
						<td>
						<img name="btnEditar" title="Restaurar paciente" src="./include/img/Restaurar.png" onclick="mensajeUsuarioConProcedimiento('alertMensaje','Confirmar Acción','Atención, se procederá a RESTAURAR al paciente con identificación <?=$pacientesEli[$i]['Identificador']?>, ¿Desea continuar?','./controller/server/controlador_paciente.php','pac_id=<?=$pacientesEli[$i]['pac_id']?>&op=restaurarPaciente','view/interface/busquedaPaciente.php','','#contenidoCargado')" style="cursor: pointer;" style="cursor: pointer;')"/>
						&nbsp;&nbsp;&nbsp;
						</td>
					</tr>        			
            		<? }
            	?>
            
    </table>
</center>