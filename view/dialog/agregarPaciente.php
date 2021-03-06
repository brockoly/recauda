<?php

	//LLAMADA DE CLASES
	require_once('../../class/Conectar.class.php'); $objCon = new Conectar(); 
	require_once('../../class/Nacionalidad.class.php'); $objNac = new Nacionalidad();
	require_once('../../class/Prevision.class.php'); $objPrev = new Prevision();
	require_once('../../class/Institucion.class.php'); $objInst = new Institucion();

	//LLAMADA DE METODOS.
	$objCon->db_connect();
	$nacionalidades = $objNac->obtenerNacionalidades($objCon);
	$previsiones = $objPrev->obtenerPrevisiones($objCon);
	$objCon=null;
	$fecha = date("d")."/".date("m")."/".date("Y");
?>

<script type="text/javascript" src="controller/client/js_agregarPaciente.js"></script>
<script type="text/javascript">calendario('txtFechaNac', '<?=$fecha?>')</script>
<form id="frmDatosPaciente" name="frmDatosPaciente">
<fieldset style="width: 500px;"><legend>Datos Paciente</legend>
<center>
<table><tr>
			<td>País *</td>
			<td>&nbsp;&nbsp;
				<select id="cmbPais" name="cmbPais">
					<option value="0">Seleccione País</option>
				<?
				for($i=0; $i<count($nacionalidades); $i++){ ?>
						<option value="<?= $nacionalidades[$i]['nac_id']?>"><?= $nacionalidades[$i]['nac_nombre']?></option>
				<?
					} 
				?>
					
				</select>
			&nbsp;&nbsp;<img src="./include/img/Information.png" id="errcmbPais" hidden="true"  /></td>
		</tr>
		<tr hidden="true" id="trIdentificador">
			<td>Identificador *</td>
			
		</tr>
		<tr>
			<td>Nombres *</td>
			<td>&nbsp;&nbsp;&nbsp;<input type="text" id="txtNombres" name="txtNombres" />&nbsp;&nbsp;<img src="./include/img/Information.png" id="errNombres" hidden="true"  /></td>
		</tr>
		<tr>
			<td>Apellido Paterno *</td>
			<td>&nbsp;&nbsp;&nbsp;<input type="text" id="txtApellidoPat" name="txtApellidoPat" />&nbsp;&nbsp;<img src="./include/img/Information.png" id="errApellidoPat" hidden="true"  /></td>
		</tr>
		<tr>
			<td>Apellido Materno *</td>
			<td>&nbsp;&nbsp;&nbsp;<input type="text" id="txtApellidoMat" name="txtApellidoMat" />&nbsp;&nbsp;<img src="./include/img/Information.png" id="errApellidoMat" hidden="true"  /></td>
		</tr>
		<tr>
					<td>Sexo</td>
					<td>&nbsp;&nbsp;&nbsp;					
					<input type="radio" id="rdSexo"   name="rdSexo" value="f" checked="true" /> Femenino
					<input type="radio" id="rdSexo"   name="rdSexo" value="m"/> Masculino
					&nbsp;&nbsp;<img src="./include/img/information.png" id="errSexo" hidden="true"/></td>
				</tr>
		<tr>
			<td>Fecha Nac *</td>
			<td>&nbsp;&nbsp;&nbsp;<input type="text" id="txtFechaNac" name="txtFechaNac" readonly="true"/>&nbsp;&nbsp;<img src="./include/img/Information.png" id="errFechaNac" hidden="true"  /></td>
		</tr>
		<tr>
			<td>Telefono </td>
			<td>&nbsp;&nbsp;&nbsp;<input type="text" id="txtTelefono" name="txtTelefono" />&nbsp;&nbsp;<img src="./include/img/Information.png" id="errTelefono" hidden="true"  /></td>
		</tr>
		<tr>
			<td>Dirección *</td>
			<td>&nbsp;&nbsp;&nbsp;<input type="text" id="txtDireccion"  name="txtDireccion"/>&nbsp;&nbsp;<img src="./include/img/information.png" id="errDireccion" hidden="true"/></td>
		</tr>		
		<tr>
			<td>Previsión *</td>
			<td>&nbsp;&nbsp;
				<select id="cmbPrevision" name="cmbPrevision">
					<option value="0">Seleccione Previsión</option>
				<? 	
				for($i=0; $i<count($previsiones); $i++){ ?>
						<option value="<?= $previsiones[$i]['pre_id']?>"><?= $previsiones[$i]['pre_nombre']?></option>
				<?
					} 
				?>
					
				</select>
			&nbsp;&nbsp;<img src="./include/img/Information.png" id="errcmbPrevision" hidden="true"  />
			</td>
		</tr>
		<tr hidden="hidden" id="trInstitucion">
			<td>Institución *</td>
			<td>&nbsp;&nbsp;
				<select id="cmbInstitucion" name="cmbInstitucion">
				</select>
			&nbsp;&nbsp;<img src="./include/img/Information.png" id="errcmbInstitucion" hidden="true"  />
			</td>
		</tr>		
		
</table>
</center><br>
</fieldset>

<br>
<center><input type="button" id="btnAgregarPacienteModal" value="Agregar Paciente"/></center>
<br>
</form>