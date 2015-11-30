<?php
	//LLAMADA DE CLASES
	require_once('../../class/Conectar.class.php'); $objCon = new Conectar(); 
	require_once('../../class/Nacionalidad.class.php'); $objNac = new Nacionalidad();
	require_once('../../class/Privilegios.class.php'); $objPri = new Privilegio();
	//LLAMADA DE METODOS.
	$objCon->db_connect();
	//$nacionalidades = $objNac->obtenerNacionalidades($objCon);
	$privilegios = $objPri->obtenerPrivilegios($objCon);
	$objCon=null;
	$fecha = date("d")."/".date("m")."/".(date("Y")-18);
?>
<script type="text/javascript" src="controller/client/js_agregarUsuario.js"></script>
<script type="text/javascript">calendario('txtFechaNacimientos', '<?=$fecha?>')</script>
<center>
<form id="frmAgregarUsuario">
		<fieldset style="width: 400px;"><legend>Datos Personales</legend>
		<table>
				<tr>
					<td>Usuario *</td>
					<td>&nbsp;&nbsp;&nbsp;<input type="text" id="txtUsuario"  name="txtUsuario"/>&nbsp;&nbsp;<img src="./include/img/information.png" id="errUsuario" hidden="true"/></td>
				</tr>
				<tr>
					<td>Correo *</td>
					<td>&nbsp;&nbsp;&nbsp;<input type="text" id="txtCorreo"   name="txtCorreo" />&nbsp;&nbsp;<img src="./include/img/information.png" id="errCorreo" hidden="true"/></td>
				</tr>
				<tr>
					<td>Privilegio *</td>
					<td>&nbsp;&nbsp;
						<select id="cmbPrivilegios" name="cmbPrivilegios">
							<option value="0">Seleccione</option>
							<?php for($i=0; $i<count($privilegios); $i++) {?>
									<option value="<?=$privilegios[$i]['pri_id']?>"> <?=$privilegios[$i]['pri_nombre']?> </option>							
							<?php ;}?>
						</select>
						<img src="./include/img/information.png" id="errPrivilegio" hidden="true"/>
					</td>
				</tr>				
		</table>
		<br>
		</fieldset>
		<br>
		<fieldset style="width: 550px;"><legend>Datos Personales</legend>
		<table>
				<tr>
					<td>Rut *</td>
					<td>&nbsp;&nbsp;&nbsp;<input type="text" id="txtIdentificador"  name="txtIdentificador"/>&nbsp;&nbsp;<img src="./include/img/information.png" id="errIdentificador" hidden="true"/></td>
				</tr>
				<tr>
					<td>Nombre *</td>
					<td>&nbsp;&nbsp;&nbsp;<input type="text" id="txtNombre"  name="txtNombre"/>&nbsp;&nbsp;<img src="./include/img/information.png" id="errNombre" hidden="true"/></td>
				</tr>
				<tr>
					<td>Apellido Paterno *</td>
					<td>&nbsp;&nbsp;&nbsp;<input type="text" id="txtApellidoPaterno"  name="txtApellidoPaterno"/>&nbsp;&nbsp;<img src="./include/img/information.png" id="errApellidoPaterno" hidden="true"/></td>
				</tr>
				<tr>
					<td>Apellido Materno *</td>
					<td>&nbsp;&nbsp;&nbsp;<input type="text" id="txtApellidoMaterno"   name="txtApellidoMaterno"/>&nbsp;&nbsp;<img src="./include/img/information.png" id="errApellidoMaterno" hidden="true"/></td>
				</tr>
				<tr>
					<td>Sexo *</td>
					<td>&nbsp;&nbsp;&nbsp;					
					<input type="radio" id="rdSexo"   name="rdSexo" value="f" checked="true" /> Femenino
					<input type="radio" id="rdSexo"   name="rdSexo" value="m"/> Masculino
					&nbsp;&nbsp;<img src="./include/img/information.png" id="errSexo" hidden="true"/></td>
				</tr>
				<tr>
					<td>Fecha Nacimiento *</td>
					<td>&nbsp;&nbsp;&nbsp;<input type="text" id="txtFechaNacimientos" name="txtFechaNacimiento"/>&nbsp;&nbsp;<img src="./include/img/eraser.png" id="goma" style="cursor:pointer;"/>&nbsp;&nbsp;<img src="./include/img/information.png" id="errFechaNacimiento" hidden="true"/></td>
				</tr>
				<tr>
					<td>Telefono</td>
					<td>&nbsp;&nbsp;&nbsp;<input type="text" id="txtTelefono"  name="txtTelefono"/>&nbsp;&nbsp;<img src="./include/img/information.png" id="errTelefono" hidden="true"/></td>
				</tr>
				<tr>
					<td>Dirección *</td>
					<td>&nbsp;&nbsp;&nbsp;<input type="text" id="txtDireccion"  name="txtDireccion"/>&nbsp;&nbsp;<img src="./include/img/information.png" id="errDireccion" hidden="true"/></td>
				</tr>
		</table><br>
		</fieldset><br>		
		<center><input type="button" id="btnAgregarUsuario" value="Agregar Usuario"/></center>
</form>


