<?php
	require_once('../../class/Conectar.class.php');
	require_once('../../class/Paciente.class.php');
	require_once('../../class/Util.class.php');

	$objCon = new Conectar;
	$objPac = new Paciente;
	$objUtil = new Util;
	$objCon->db_connect();
	$pacientes = $objPac->desplegarPacientes($objCon);
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
			              <td><img name="btnEditar" title="Editar Nacionalidad" src="./include/img/Edit.png" onclick="ventanaModal('./view/dialog/editarPaciente.php','pac_id=<?=$pacientes[$i]['pac_id']?>','auto','auto','Editar Paciente','modalEditarPaciente')" style="cursor: pointer;"/>
							&nbsp;&nbsp;&nbsp;</td>
			            </tr>
            		<? }
            	?>
            
    </table>
</center>