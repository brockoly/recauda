<?php 
	require_once('../../class/Conectar.class.php'); $objCon = new Conectar();
	require_once('../../class/Producto.class.php');$objPro = new Producto();
	require_once('../../class/Tipo_Producto.class.php');$objTipoPro = new Tipo_Producto();
	require_once('../../class/Unidad_Medida.class.php');$objUnidadM = new Unidad_Medida();
	require_once('../../class/Valores.class.php');$objValores = new Valores();
	
	switch($_GET['op']) {
		case "busquedaSensitivaPro":
								
			$objCon->db_connect();
			try{
		 		$objPro->setProducto("",$_GET['term'],"");
		 		echo $objPro->buscarProductoSensitiva($objCon,$_GET['tip_pro']);
			}catch (PDOException $e){
				$e->getMessage();
			}
	break;

	}

?>

	