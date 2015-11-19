<?
require_once('../../class/Conectar.class.php'); $objCon = new Conectar(); 
require_once('../../class/Util.class.php'); $objUtil = new Util;
require_once('../../class/Institucion.class.php'); $objInst = new Institucion();

switch($op){
case 'cmbInstitucion':	 	$objCon->db_connect();
							$Institucion = $objInst->buscarInstitucion($objCon,$_POST['pre_id']);
							echo json_encode($Institucion);
							break;
}
?>