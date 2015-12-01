<?php
	/*LLAMADA DE CLASES*/
	session_start();
	
	require_once('../../class/Conectar.class.php'); $objCon = new Conectar(); 
	require_once('../../class/Paciente.class.php'); $objPac = new Paciente(); 
	require_once('../../class/Util.class.php');	$objUtil= new Util();
	require_once('../../class/Prevision.class.php'); $objPrev = new Prevision();
	require_once('../../class/Nacionalidad.class.php'); $objNac = new Nacionalidad();
	require_once('../../class/Institucion.class.php'); $objIns = new Institucion();
	/*LLAMADA DE METODOS.*/
	$objCon->db_connect();
	$objPac->setPaciente($_POST['pac_id']);
	$datos = $objPac->getInformacionPaciente($objCon,"","", "");
	$nacionalidades = $objNac->obtenerNacionalidades($objCon);
	$previsiones = $objPrev->obtenerPrevisiones($objCon);
	$instituciones = $objIns->obtenerInstituciones($objCon);
	$objCon=null;
	$fecha = date("d")."/".date("m")."/".date("Y");
?>
<script type="text/javascript">calendario('txtFechaNac', '<?=$fecha?>')</script>
<script type="text/javascript" src="controller/client/js_editarPaciente.js"></script>
<center>
<form id="frmDatosPaciente">
		<input type="hidden" name="per_id" value="<?=$datos[0]['Identificador'];?>">
		<fieldset style="width: 500px;"><legend>Datos Personales</legend>
		<table>
				<tr>
					<td>Nombres *</td>
					<td>&nbsp;&nbsp;&nbsp;<input type="text" id="txtNombres" name="txtNombres" value="<?=$datos[0]['Nombre'];?>"/>&nbsp;&nbsp;<img src="./include/img/information.png" id="errUsuario" hidden="true"/></td>
				</tr>
				<tr>
					<td>Apellido Paterno *</td>
					<td>&nbsp;&nbsp;&nbsp;<input type="text" id="txtApellidoPat"  name="txtApellidoPat" value="<?=$datos[0]['Apellido_Paterno']?>" />&nbsp;&nbsp;<img src="./include/img/information.png" id="errCorreo" hidden="true"/></td>
				</tr>
				<tr>
					<td>Apellido Materno *</td>
					<td>&nbsp;&nbsp;&nbsp;<input type="text" id="txtApellidoMat"  name="txtApellidoMat" value="<?=$datos[0]['Apellido_Materno']?>" />&nbsp;&nbsp;<img src="./include/img/information.png" id="errCorreo" hidden="true"/></td>
				</tr>
				<tr>
					<td>Sexo</td>
					<td>&nbsp;&nbsp;&nbsp;					
					<input type="radio" id="rdSexo"   name="rdSexo" value="f" <?if($datos[0]['per_sexo']=='f'){echo "checked='true'";}?> /> Femenino
					<input type="radio" id="rdSexo"   name="rdSexo" value="m" <?if($datos[0]['per_sexo']=='m'){echo "checked='true'";}?> /> Masculino
					&nbsp;&nbsp;<img src="./include/img/information.png" id="errSexo" hidden="true"/></td>
				</tr>
				<tr>
					<td>Fecha Nac. *</td>
					<td>&nbsp;&nbsp;&nbsp;<input type="text" id="txtFechaNac" readonly="true" name="txtFechaNac" value="<?=$objUtil->cambiarfecha_mysql_a_normal($datos[0]['fecha_nac'])?>" />&nbsp;&nbsp;<img src="./include/img/information.png" id="errCorreo" hidden="true"/></td>
				</tr>
				<tr>
					<td>Telefono </td>
					<td>&nbsp;&nbsp;&nbsp;<input type="text" id="txtTelefono"  name="txtTelefono" value="<?=$datos[0]['per_telefono']?>" />&nbsp;&nbsp;<img src="./include/img/information.png" id="errCorreo" hidden="true"/></td>
				</tr>
		<tr>
			<td>Dirección *</td>
			<td>&nbsp;&nbsp;&nbsp;<input type="text" id="txtDireccion"  name="txtDireccion" value="<?=$datos[0]['per_direccion']?>"/>&nbsp;&nbsp;<img src="./include/img/information.png" id="errDireccion" hidden="true"/></td>
		</tr>
				<tr>
				<tr>
					<td>Previsión:</td>
					<td>&nbsp;&nbsp;
						<select id="cmbPrevision" name="cmbPrevision">
							<option value="0">Seleccione Previsión</option>
						<? 	
						for($i=0; $i<count($previsiones); $i++){ ?>
								<option value="<?= $previsiones[$i]['pre_id']?>" <? if($datos[0]['prevision_id']==$previsiones[$i]['pre_id']) {echo "selected";} ?> ><?= $previsiones[$i]['pre_nombre']?></option>
						<?
							} 
						?>
						</select>
					&nbsp;&nbsp;<img src="./include/img/Information.png" id="errcmbPrevision" hidden="true"  />
					</td>
				</tr>
				<tr id="trInstitucion">
					<td>Institución:</td>
					<td>&nbsp;&nbsp;
						<select id="cmbInstitucion" name="cmbInstitucion">
						<option value="0">Seleccione Institucion</option>
						<? 	
						for($i=0; $i<count($instituciones); $i++){ ?>
								<option value="<?= $instituciones[$i]['ins_id']?>" <? if($datos[0]['inst_id']==$instituciones[$i]['ins_id']) {echo "selected";} ?> ><?= $instituciones[$i]['ins_nombre']?></option>
						<?
							} 
						?>
						</select>
					&nbsp;&nbsp;<img src="./include/img/Information.png" id="errcmbInstitucion" hidden="true"  />
					</td>
				</tr>				
		</table>
		</br>		
		</fieldset>		
		</br>
		<center><input type="button" id="btnEditarPaciente" value="Modificar Paciente"/></center>
</form>
