<?php 
	require_once('../../class/Conectar.class.php'); $objCon = new Conectar();
	require_once('../../class/Unidad_Medida.class.php');$objUnidadM = new Unidad_Medida();
	require_once('../../class/Util.class.php');$objUti= new Util();

	switch($_POST['op']) {
		case "buscarUM":				
			$objCon->db_connect();
			try{
				//echo "ANTERIOR: ".$_POST['uni_nombreAct']." AHORA: ".$_POST['uni_nombre'];
		 		$objCon->beginTransaction();
		 		$objUnidadM->setUnidadMedida('',$objUti->eliminaEspacios($_POST['uni_nombre']),'0');
				$res = $objUnidadM->buscarUnidadMedida($objCon,$objUti->eliminaEspacios($_POST['uni_nombreAct']));
		 		$objCon->commit();	
		 		echo count($res);					 		
			}catch (PDOException $e){
					$objCon->rollBack(); 
					$e->getMessage();
			}
		break;
		case "agregarUM":				
			$objCon->db_connect();
			try{
		 		$objCon->beginTransaction();
		 		$objUnidadM->setUnidadMedida('',$objUti->eliminaEspacios($_POST['uni_nombre']),'0');
				$objUnidadM->insertarUnidadMedida($objCon);
		 		$objCon->commit();	
		 		echo 'bien';					 		
			}catch (PDOException $e){
				$objCon->rollBack(); 
				$e->getMessage();
			}
		break;
		case "actualizarUM":				
			$objCon->db_connect();
			try{
		 		$objCon->beginTransaction();
		 		$objUnidadM->setUnidadMedida($_POST['uni_id'],$objUti->eliminaEspacios($_POST['uni_nombre']),'0');
				$objUnidadM->actualizarUnidadMedida($objCon);
		 		$objCon->commit();	
		 		echo 'bien';					 		
			}catch (PDOException $e){
				$objCon->rollBack(); 
				$e->getMessage();
			}
		break;
		case "eliminarUM":				
			$objCon->db_connect();
			try{
		 		$objCon->beginTransaction();
		 		$objUnidadM->setUnidadMedida($_POST['uni_id'],'','0');
				$objUnidadM->cambiarEstadoUnidadMedida($objCon,'1');
		 		$objCon->commit();	
		 		echo 'Unidad de medida eliminada';					 		
			}catch (PDOException $e){
				$objCon->rollBack(); 
				$e->getMessage();
			}
		break;
		case "restaurarUM":				
			$objCon->db_connect();
			try{
		 		$objCon->beginTransaction();
		 		$objUnidadM->setUnidadMedida($_POST['uni_id'],'','0');
				$objUnidadM->cambiarEstadoUnidadMedida($objCon,'0');
		 		$objCon->commit();	
		 		echo 'Unidad de medida restaurada';					 		
			}catch (PDOException $e){
				$objCon->rollBack(); 
				$e->getMessage();
			}
		break;
	}

?>