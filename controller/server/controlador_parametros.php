<?
	
require_once('../../class/Conectar.class.php'); $objCon = new Conectar(); 
require_once('../../class/Util.class.php'); $objUtil = new Util;
require_once('../../class/Institucion.class.php'); $objInst = new Institucion();
require_once('../../class/Unidad_Medida.class.php'); $objUnidadM = new Unidad_Medida();
require_once('../../class/Bono.class.php'); $objBono = new Bono();

switch($op){
case 'cmbInstitucion':	 	$objCon->db_connect();
							$Institucion = $objInst->buscarInstitucion($objCon,$_POST['pre_id']);
							echo json_encode($Institucion);
							break;
case 'cmbUnidadM':	 		$objCon->db_connect();
							$unidadMedida = $objUnidadM->buscarUnidadMedidaProducto($objCon,$_POST['tip_prod_id']);
							echo json_encode($unidadMedida);
							break;
case 'cmbBonos':	 		$objCon->db_connect();
							$bonos = $objBono->buscarTiposBonos($objCon);
							echo json_encode($bonos);
							break;							
}
?>