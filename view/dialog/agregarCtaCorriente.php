<?php
	session_start();	
	unset($_SESSION['pac_id']);
	$_SESSION['pac_id']=$_POST['pac_id'];
	//echo $_SESSION['usuario'][1]['nombre_usuario'];	
?>
<script type="text/javascript" src="controller/client/js_agregarCtaCorriente.js"></script>
<center>
<form id="frmAgregarCuenta">
		<table border="0">
				<tr>
					<td>Unidad de Origen&nbsp;</td>
					<td>&nbsp;&nbsp;&nbsp;
							<select id="unidadOrigen" name="unidadOrigen">
								<option value="0">Seleccione</option>
								<option value="1">Pensionado</option>
								<option value="2">Urgencia</option>
								<option value="3">Central</option>
							</select>
							<img src="./include/img/information.png" id="errUsuario" hidden="true"/>
					</td>
				</tr>				
		</table>
</form><br>
		
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="Crear Cuenta" id="agregarCuenta">
		
</center>
<input type="hidden" value="<?=$_POST['pac_id']?>" id="cue_id">