<?php 
	require_once('../../class/Conectar.class.php'); $objCon = new Conectar();
	require_once('../../class/Producto.class.php');$objPro = new Producto();
	switch($_POST['op']) {
		case "editarTipo":
			$objPro->setProducto($_POST['tip_descripcion'],$_POST['tip_prod_id']);				
			$objCon->db_connect();
			$producto=$objPro->buscarTipoProducto($objCon);
			if(is_null($producto)==true){
				try{
			 		$objCon->beginTransaction();
					$objPro->editarTipoProducto($objCon);
			 		$objCon->commit();						 		
				}catch (PDOException $e){
		 			$objCon->rollBack(); 
		 			$e->getMessage();
				}
			}else{
				echo "existe";
			}
		break;
		case "agregarTipo":
			$datos = explode(',', $_POST['datos']);
			$objPro->setProducto($_POST['tip_descripcion'],'');				
			$objCon->db_connect();
			$producto=$objPro->buscarTipoProducto($objCon);
			if(is_null($producto)==true){
				try{
			 		$objCon->beginTransaction();
					$tip_pro_id = $objPro->insertarTipoProducto($objCon);
					if($_POST['chkUM']==1){
						for($i=0; $i<count($datos); $i++){
							$objPro->insertarUnidadMedida($objCon,$tip_pro_id,$datos[$i]);
						}
					}
			 		$objCon->commit();						 		
				}catch (PDOException $e){
		 			$objCon->rollBack(); 
		 			$e->getMessage();
				}
			}else{
				echo "existe";
			}
		break;
		case "eliminarTipo":
			$objPro->setProducto('',$_POST['tip_prod_id']);				
			$objCon->db_connect();
			try{
		 		$objCon->beginTransaction();
				$objPro->eliminarTipoProducto($objCon);
		 		$objCon->commit();	
		 		echo "Tipo de producto eliminado";					 		
			}catch (PDOException $e){
	 			$objCon->rollBack(); 
	 			$e->getMessage();
			}
		break;
		case "restaurarTipo":
			$objPro->setProducto('',$_POST['tip_prod_id']);				
			$objCon->db_connect();
			try{
		 		$objCon->beginTransaction();
				$objPro->restaurarTipoProducto($objCon);
		 		$objCon->commit();	
		 		echo "Tipo de producto restaurado";					 		
			}catch (PDOException $e){
	 			$objCon->rollBack(); 
	 			$e->getMessage();
			}
		break;

	}

?>