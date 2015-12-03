<?php 
	
		require_once('../../class/Conectar.class.php'); $objCon = new Conectar();
		require_once('../../class/Nacionalidad.class.php');$objNac = new Nacionalidad();
		require_once('../../class/Util.class.php');$objUtil = new Util();



		switch($_POST['op']) {

				case "editar":
						$objNac->setNacionalidad($_POST['txtIdNac'], $objUtil->eliminaEspacios($_POST['txtNacionalidad']));					
						$objCon->db_connect();
						$usuAux=$objNac->buscaNacionalidad($objCon);
						
						if($usuAux!=""){
							echo "Este nombre ya existe en la base de datos";
						}else{

							try{
							 		$objCon->beginTransaction();
							 		$objNac->modificarNacionalidad($objCon);
							 		$objCon->commit();						 		
							}catch (PDOException $e){
								 			$objCon->rollBack(); 
								 			$e->getMessage();
							}
						}
				break;

				case "agregar":
						$objNac->setNacionalidad($_POST['txtIdNac'], $objUtil->eliminaEspacios($_POST['txtNacionalidad']));					
						$objCon->db_connect();
						$usuAux=$objNac->buscaNacionalidad($objCon);
						
						if($usuAux!=""){
							echo "Este nombre ya existe en la base de datos";
						}else{

							try{
							 		$objCon->beginTransaction();
							 		$objNac->insertarNacionalidad($objCon);
							 		$objCon->commit();						 		
							}catch (PDOException $e){
								 			$objCon->rollBack(); 
								 			$e->getMessage();
							}
						}
				break;

		}

?>