<?php 
	
		require_once('../../class/Conectar.class.php');  $objCon = new Conectar();
		require_once('../../class/Prevision.class.php'); $objPre = new Prevision();



		switch($_POST['op']) {

				case "editar":
						$objPre->setPrevision($_POST['txtIdPre'], $_POST['txtPrevision']);					
						$objCon->db_connect();
						$prevision=$objPre->buscaPrevision($objCon, 1);
						$bandera=-1;
						if($prevision=="Existe con id"){
							 $bandera=0;									
						}else{  
							if($prevision=="Existe sin id"){
								$bandera=1;
							}else{
								$bandera=0;
							}
						}
						
						if($bandera==0){
							try{
						 		$objCon->beginTransaction();
						 		$objPre->modificarPrevision($objCon);
						 		$objCon->commit();						 		
							}catch (PDOException $e){
					 			$objCon->rollBack(); 
					 			$e->getMessage();
							}
						}else{
							echo "Este nombre ya existe en la base de datos";
						}
				break;

				case "agregar":
						$objPre->setPrevision( '', $_POST['txtPrevision']);					
						$objCon->db_connect();
						$prevision=$objPre->buscaPrevision($objCon, 2);
						
						if($prevision!=""){
							echo "Este nombre ya existe en la base de datos";
						}else{

							try{
						 		$objCon->beginTransaction();
						 		$objPre->insertarPrevision($objCon);
						 		$objCon->commit();						 		
							}catch (PDOException $e){
					 			$objCon->rollBack(); 
					 			$e->getMessage();
							}
						}
				break;

				case "eliminarAsociacionIns":
						$objCon->db_connect();												
						$objPre->setPrevision($_POST['pre_id'],'');
						
						try{
						 		$objCon->beginTransaction();
						 		$objPre->eliminarAsociacion($objCon, $_POST['ins_id']);
						 		$objCon->commit();
						 		echo "Previsión desvinculada con éxito";						 		
						}catch (PDOException $e){
					 			$objCon->rollBack(); 
					 			$e->getMessage();
						}
						
				break;
				case "agregarAsociacion":
						$objCon->db_connect();												
						$objPre->setPrevision($_POST['pre_id'],'');
						$arreglox= explode(",", $_POST['arregloInstituciones']);						
						try{
						 		$objCon->beginTransaction();
						 		$objPre->agregarAsociacion($objCon, $arreglox);
						 		$objCon->commit();
						 		echo "Institución vinculada con éxito";						 		
						}catch (PDOException $e){
					 			$objCon->rollBack(); 
					 			$e->getMessage();
						}						
				break;
				case "desactivarPrevision":
						$objCon->db_connect();												
						$objPre->setPrevision($_POST['pre_id'],'');						
						try{
						 		$objCon->beginTransaction();
						 		$objPre->desactivarPrevision($objCon);
						 		$objCon->commit();
						 		echo "Previsión desactivada con éxito";						 		
						}catch (PDOException $e){
					 			$objCon->rollBack(); 
					 			$e->getMessage();
						}						
				break;
				case "activarPrevision":
						$objCon->db_connect();												
						$objPre->setPrevision($_POST['pre_id'],'');
						try{
						 		$objCon->beginTransaction();
						 		$objPre->activarPrevision($objCon);
						 		$objCon->commit();
						 		echo "Previsión activada con éxito";						 		
						}catch (PDOException $e){
					 			$objCon->rollBack(); 
					 			$e->getMessage();
						}						
				break;
		}

?>