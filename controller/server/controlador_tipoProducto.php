<?php 
	require_once('../../class/Conectar.class.php'); $objCon = new Conectar();
	require_once('../../class/Tipo_Producto.class.php');$objTipoPro = new Tipo_Producto();
	require_once('../../class/Unidad_Medida.class.php');$objUnidadM = new Unidad_Medida();

	switch($_POST['op']) {
		case "editarTipo":
			$datos = explode(',', $_POST['datosE']);
			$objTipoPro->setTipoProducto($_POST['tip_descripcion'],$_POST['tip_prod_id']);				
			$objCon->db_connect();
			$producto=$objTipoPro->buscarTipoProducto($objCon);
			if(is_null($producto)==true){
				try{
			 		$objCon->beginTransaction();
					$objTipoPro->editarTipoProducto($objCon);
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
			$datosTipo = explode(',', $_POST['datos']);
			$objTipoPro->setTipoProducto($_POST['tip_descripcion'],'');				
			$objCon->db_connect();
			$producto=$objTipoPro->buscarTipoProducto($objCon);
			if(is_null($producto)==true){
				try{
			 		$objCon->beginTransaction();
					$tip_pro_id = $objTipoPro->insertarTipoProducto($objCon);
					for($i=0;$i<count($datosTipo);$i++){
						$objUnidadM->setUnidadMedida($datosTipo[$i],'','');
						$objUnidadM->insertarUnidadMedidaTProducto($objCon,$tip_pro_id);
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
			$objTipoPro->setTipoProducto('',$_POST['tip_prod_id']);				
			$objCon->db_connect();
			try{
		 		$objCon->beginTransaction();
				$objTipoPro->eliminarTipoProducto($objCon);
		 		$objCon->commit();	
		 		echo "Tipo de producto eliminado";					 		
			}catch (PDOException $e){
	 			$objCon->rollBack(); 
	 			$e->getMessage();
			}
		break;
		case "restaurarTipo":
			$objTipoPro->setTipoProducto('',$_POST['tip_prod_id']);				
			$objCon->db_connect();
			try{
		 		$objCon->beginTransaction();
				$objTipoPro->restaurarTipoProducto($objCon);
		 		$objCon->commit();	
		 		echo "Tipo de producto restaurado";					 		
			}catch (PDOException $e){
	 			$objCon->rollBack(); 
	 			$e->getMessage();
			}
		break;
		/*case "buscarUmTipoProducto":				
			$objCon->db_connect();
			try{
		 		$objCon->beginTransaction();
				$res = $objUnidadM->buscarUnidadMedidaProducto($objCon,$_POST['tip_prod_id']);
		 		$objCon->commit();	
		 		echo count($res);					 		
			}catch (PDOException $e){
					$objCon->rollBack(); 
					$e->getMessage();
			}
		break;*/
	}

?>