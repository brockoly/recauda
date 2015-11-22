<?php 

	require_once('../../class/Conectar.class.php'); $objCon = new Conectar();
	require_once('../../class/Producto.class.php');$objPro = new Producto();
	switch($_POST['op']) {

			/*case "editar":
					$objNac->setNacionalidad($_POST['txtIdNac'], $_POST['txtNacionalidad']);					
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
			break;*/

		case "agregar":
			$objPro->setProducto($_POST['tip_descripcion']);				
			$objCon->db_connect();
			echo $producto=$objPro->buscarProducto($objCon);
			if(is_null($producto)==true){
				try{
			 		$objCon->beginTransaction();
					$objPro->insertarProducto($objCon);
			 		$objCon->commit();						 		
				}catch (PDOException $e){
		 			$objCon->rollBack(); 
		 			$e->getMessage();
				}
			}else{
				echo "existe";
			}
		break;

	}

?>