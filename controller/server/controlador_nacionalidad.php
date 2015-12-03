<?php 
	
		require_once('../../class/Conectar.class.php'); $objCon = new Conectar();
		require_once('../../class/Nacionalidad.class.php');$objNac = new Nacionalidad();
		require_once('../../class/Util.class.php');$objUtil = new Util();

		switch($_POST['op']) {

				case "editar":
						$objNac->setNacionalidad($_POST['txtIdNac'], $objUtil->eliminaEspacios($_POST['txtNacionalidad']));					
						$objCon->db_connect();
						$nacionalidad=$objNac->buscaNacionalidad($objCon);						
						$bandera=-1;
						if($nacionalidad=="Existe con id"){
							$bandera=0;									
						}else{  
							if($nacionalidad=="Existe sin id"){
								$bandera=1;
							}else{
								$bandera=0;
							}
						}						
						if($bandera==0){

							try{
							 		$objCon->beginTransaction();
							 		$objNac->modificarNacionalidad($objCon);
							 		$objCon->commit();						 		
							}catch (PDOException $e){
								 			$objCon->rollBack(); 
								 			$e->getMessage();
							}
						}else{
							echo "Este nombre ya existe en los registros";
						}
				break;

				case "agregar":
						$objNac->setNacionalidad($_POST['txtIdNac'], $objUtil->eliminaEspacios($_POST['txtNacionalidad']));					
						$objCon->db_connect();
						$nacionalidad=$objNac->buscaNacionalidad($objCon);
						
						if($nacionalidad=="Existe con id"){
							$bandera=0;									
						}else{  
							if($nacionalidad=="Existe sin id"){
								$bandera=1;
							}else{
								$bandera=0;
							}
						}						
						if($bandera==0){

							try{
							 		$objCon->beginTransaction();
							 		$objNac->insertarNacionalidad($objCon);
							 		$objCon->commit();						 		
							}catch (PDOException $e){
								 			$objCon->rollBack(); 
								 			$e->getMessage();
							}
						}else{
							echo "Este nombre ya existe en los registros";
						}
				break;

		}

?>