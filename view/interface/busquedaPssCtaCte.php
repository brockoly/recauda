<?php
	session_start();
	require_once('../../class/Conectar.class.php');
	require_once('../../class/Util.class.php');
	require_once('../../class/Pss.class.php');
	require_once('../../class/Cuenta_Corriente.class.php');
	$objCon = new Conectar(); 
	$objUtil = new Util();
	$objPss = new Pss(); 
	$objCue = new Cuenta_Corriente(); 
	$objCon->db_connect();
	if(isset($_POST['cue_id']) && $_POST['cue_id']!=""){
		$datos=$objPss->buscarPssCtaCte($objCon,$_POST['cue_id']);
	}
	unset($_SESSION['cue_id']);
	$_SESSION['cue_id']=$_POST['cue_id'];
	$objCon=null;
?>
<script type="text/javascript" src="controller/client/js_busquedaPssCtaCte.js"></script>
<center><br><br><h3>Listado de PSS asociados a la cuenta corriente <b>N° <?=$_POST['cue_id']?></b></h3></center>
<br>
<center><br>
<form id="frmAgregarPssCuenta">
<div style="width: 60%;">
			<table class="display" width="100%">
			<tr>
	    			<td align="left"><div  id="volver" style="float: left;" onclick="cargarContenido('view/interface/busquedaGestionDePago.php','Paciente=<?=$_POST['Paciente']?>&CtaCorriente=<?=$_POST['CtaCorriente']?>&Identificador=<?=$_POST['Identificador']?>','#contenidoBuscado');"><img src="./include/img/back.png" width="20" height="20"> Atrás</div></td>
					<td></td>
					<td align="right"><div  id="nuevoPss" onclick=""><img src="./include/img/document.png" width="20" height="20"> Crear Nuevo PSS</div></td>
			</tr>
			</table>
			<table class="display" width="100%" id="tabCtaCorrientePss">
		            <thead>
			            <tr>
			              <th width="15%">N° PSS</th>
			              <th width="">Fecha Emisión</th>
			              <th width="">Estado</th>
			              <th width="">Acciones</th>
			            </tr>
		            </thead>
<?php
            	for($i=0; $i<count($datos); $i++){
?> 
		        	<tr>
		        			<td align="center"><?=$datos[$i]['pss_id']?></td>
							<td><?=$objUtil->cambiarfecha_mysql_a_normal($datos[$i]['pss_fecha'])?></td>
							<td><?=$datos[$i]['pss_estado']?></td>
							<td>
								<?=$objPss->desplegarBotonesAcciones('','')?>
							</td>
					</tr>
<?php 			}
?>			</table>
</div>
</form>
<input type="hidden" value="<?=$_SESSION['cue_id']?>" id="cue_id">
<input type="hidden" value="<?=$_POST['Paciente']?>" id="Paciente">
<input type="hidden" value="<?=$_POST['CtaCorriente']?>" id="CtaCorriente">
<input type="hidden" value="<?=$_POST['Identificador']?>" id="Identificador">