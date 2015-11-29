<?php
	//LLAMADA DE CLASES
	session_start();
	if ( $_SESSION['usuario'] == null ) {
		$GoTo = "../../../login/index.php";
		header(sprintf("Location: %s", $GoTo));
	}
	require_once('../../class/Conectar.class.php'); $objCon = new Conectar(); 
	require_once('../../class/Nacionalidad.class.php'); $objNac = new Nacionalidad();
	require_once('../../class/Privilegios.class.php'); $objPri = new Privilegio();
	require_once('../../class/Usuario.class.php');	$objUsu = new Usuario();
	require_once('../../class/Util.class.php');	$objUtil= new Util();	
	//LLAMADA DE METODOS.
	$objCon->db_connect();
	$privilegios = $objPri->obtenerPrivilegios($objCon);
	$objUsu->setUsu_usuario($_POST['usu_nombre']);
	$datos = $objUsu->getInformacionUsuario($objCon);
	$objCon=null;
	$_SESSION['rut']=$datos[0]['rut'];
	$_SESSION['usu_nombre']=$datos[0]['usuario'];
	$_SESSION['usu_correo']=$datos[0]['correo'];	
	//var_dump($datos);
$fecha = "01/01/".(date("Y")-18);
?>
<script type="text/javascript" src="controller/client/js_editarUsuario.js"></script>
<script type="text/javascript">calendario('txtFechaNacimientos', '<?=$fecha?>')</script>
<center>
<form id="frmAgregarUsuario">
		
		<fieldset style="width: 400px;"><legend>Datos Personales</legend>
		<table>
				<tr>
					<td>Usuario</td>
					<td>
						<b>&nbsp;&nbsp;&nbsp;<?=$datos[0]['usuario']?></b>
					</td>
				</tr>
				<tr>
					<td>Correo *</td>
					<td>&nbsp;&nbsp;
						<input type="text" id="txtCorreo"  onkeypress="validar('txtCorreo', 'id' ,'correo')" name="txtCorreo" value="<?=$datos[0]['correo']?>" />&nbsp;
						<!-- <input type="checkbox" name="checkCorreo" id="checkCorreo" value="0" /> Editar&nbsp; -->
						<img src="./include/img/information.png" id="errCorreo" hidden="true"/>
					</td>
				</tr>
				<tr>
					<td>Privilegio *</td>
					<td>&nbsp;&nbsp;
						<select id="cmbPrivilegios" name="cmbPrivilegios">
							<option value="0">Seleccione</option>
							<?php for($i=0; $i<count($privilegios); $i++) {?>
									<option value="<?=$privilegios[$i]['pri_id']?>"<?php if($datos[0]['privilegio']==$privilegios[$i]['pri_id']) echo "selected";?>> <?=$privilegios[$i]['pri_nombre']?> </option>							
							<?php ;}?>
						</select>
						<img src="./include/img/information.png" id="errPrivilegio" hidden="true"/>
					</td>
				</tr>				
		</table>
		<br>
		</fieldset>
		<br><br>
		<fieldset style="width: 550px;"><legend>Datos Personales</legend>
		<table>
				
				<tr>
					<td>Nombre *</td>
					<td>&nbsp;&nbsp;&nbsp;<input type="text" id="txtNombre"  name="txtNombre" value="<?=$datos[0]['nombre']?>"/>&nbsp;&nbsp;<img src="./include/img/information.png" id="errNombre" hidden="true"/></td>
				</tr>
				<tr>
					<td>Apellido Paterno *</td>
					<td>&nbsp;&nbsp;&nbsp;<input type="text" id="txtApellidoPaterno" name="txtApellidoPaterno" value="<?=$datos[0]['apellidoPaterno']?>" />&nbsp;&nbsp;<img src="./include/img/information.png" id="errApellidoPaterno" hidden="true"/></td>
				</tr>
				<tr>
					<td>Apellido Materno *</td>
					<td>&nbsp;&nbsp;&nbsp;<input type="text" id="txtApellidoMaterno"  name="txtApellidoMaterno" value="<?=$datos[0]['aplellidoMaterno']?>" />&nbsp;&nbsp;<img src="./include/img/information.png" id="errApellidoMaterno" hidden="true"/></td>
				</tr>
				<tr>
					<td>Fecha Nacimiento *</td>
					<td>&nbsp;&nbsp;&nbsp;<input type="text" id="txtFechaNacimientos" name="txtFechaNacimiento" value="<?=$objUtil->cambiarfecha_mysql_a_normal($datos[0]['fechaNacimiento'])?>" />&nbsp;&nbsp;<img src="./include/img/eraser.png" id="goma" style="cursor:pointer;"/>&nbsp;&nbsp;<img src="./include/img/information.png" id="errFechaNacimiento" hidden="true"/></td>
				</tr>
				<tr>
					<td>Telefono</td>
					<td>&nbsp;&nbsp;&nbsp;<input type="text" id="txtTelefono"  name="txtTelefono" value="<?=$datos[0]['telefono']?>"/>&nbsp;&nbsp;<img src="./include/img/information.png" id="errTelefono" hidden="true"/></td>
				</tr>
		</table><br>
		</fieldset><br>		
		<center><input type="button" id="btnEditarUsuario" value="Modificar Usuario"/></center>
</form>


