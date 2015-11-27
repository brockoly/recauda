<?php 
	require_once('../../class/Conectar.class.php'); $objCon = new Conectar();
	require_once('../../class/Producto.class.php');$objPro = new Producto();
	require_once('../../class/Tipo_Producto.class.php');$objTipoPro = new Tipo_Producto();
	require_once('../../class/Unidad_Medida.class.php');$objUnidadM = new Unidad_Medida();
	require_once('../../class/Valores.class.php');$objValores = new Valores();

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
					if($_POST['chkUME']==1){
						for($i=0; $i<count($datos); $i++){
							$objUnidadM->insertarUnidadMedida($objCon,$_POST['tip_prod_id'],$datos[$i]);
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
		case "agregarTipo":
			$datos = explode(',', $_POST['datos']);
			$objTipoPro->setTipoProducto($_POST['tip_descripcion'],'');				
			$objCon->db_connect();
			$producto=$objTipoPro->buscarTipoProducto($objCon);
			if(is_null($producto)==true){
				try{
			 		$objCon->beginTransaction();
					$tip_pro_id = $objTipoPro->insertarTipoProducto($objCon);
					if($_POST['chkUM']==1){
						for($i=0; $i<count($datos); $i++){
							$objUnidadM->insertarUnidadMedida($objCon,$tip_pro_id,$datos[$i]);
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
		case "eliminarUM":
			$objUnidadM->setUnidadMedida($_POST['uni_id'],'');				
			$objCon->db_connect();
			try{
		 		$objCon->beginTransaction();
				$objUnidadM->eliminarUM($objCon);
		 		$objCon->commit();	
		 		echo "Unidad de medida eliminada";					 		
			}catch (PDOException $e){
					$objCon->rollBack(); 
					$e->getMessage();
			}
		break;
		case "buscarUmTipoProducto":				
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
		break;
		case "addProducto":		
			$datos = explode(',', $_POST['datosPre']);
			$datos2 = array();
			for($i=0; $i<count($datos);$i++){
				$datos2[$i] = explode('=',$datos[$i]);
			}
			$datos3 = array();
			for($i=0; $i<count($datos2);$i++){
				$datos3[$i] = explode('|',$datos2[$i][1]);
			}
			$arrDatos = array();
			$cont=0;
			for($i=0; $i<count($datos3); $i++){
				$arrDatos[$cont]['id']=$datos2[$i][0];
				$arrDatos[$cont]['prevision']=$datos3[$i][1];
				$arrDatos[$cont]['valor']=$datos3[$i][0];
				$cont++;
			}
			$objCon->db_connect();
			try{
		 		$objCon->beginTransaction();
		 		$objPro->setProducto($_POST['pro_id'],$_POST['pro_nom'],'0');
				$objPro->agregarProducto($objCon,$_POST['tip_pro_id'], $_POST['uni_id']);
				for($i=0; $i<count($arrDatos);$i++){
					$objValores->setValores($arrDatos[$i]['id'],$arrDatos[$i]['prevision'],$arrDatos[$i]['valor']);
					$objValores->agregarValores($objCon, $_POST['pro_id'], $arrDatos[$i]['id']);
				}	
		 		$objCon->commit();	
		 		echo 'bien';					 		
			}catch (PDOException $e){
					$objCon->rollBack(); 
					$e->getMessage();
			}
		break;
		case "buscarProducto":				
			$objCon->db_connect();
			try{
		 		$objCon->beginTransaction();
		 		$objPro->setProducto($_POST['pro_id'],'','');
				$res = $objPro->buscarProducto($objCon,$_POST['pro_id']);
		 		$objCon->commit();	
		 		echo count($res);					 		
			}catch (PDOException $e){
					$objCon->rollBack(); 
					$e->getMessage();
			}
		break;
		case "buscarProductoEditar":				
			$objCon->db_connect();
			try{
		 		$objCon->beginTransaction();
		 		$objPro->setProducto($_POST['pro_id'],'','');
				$res = $objPro->buscarProductoEditar($objCon, $_POST['pro_id_editar']);
		 		$objCon->commit();	
		 		echo count($res);					 		
			}catch (PDOException $e){
					$objCon->rollBack(); 
					$e->getMessage();
			}
		break;
		case "editarProducto":		
			$datos = explode(',', $_POST['datosPre']);
			$datos2 = array();
			for($i=0; $i<count($datos);$i++){
				$datos2[$i] = explode('=',$datos[$i]);
			}
			$datos3 = array();
			for($i=0; $i<count($datos2);$i++){
				$datos3[$i] = explode('|',$datos2[$i][1]);
			}
			$arrDatos = array();
			$cont=0;
			for($i=0; $i<count($datos3); $i++){
				$arrDatos[$cont]['id']=$datos2[$i][0];
				$arrDatos[$cont]['prevision']=$datos3[$i][1];
				$arrDatos[$cont]['valor']=$datos3[$i][0];
				$cont++;
			}
			$objCon->db_connect();
			try{
		 		$objCon->beginTransaction();
		 		$objPro->setProducto($_POST['pro_id'],$_POST['pro_nom'],'0');
				$objPro->editarProducto($objCon,$_POST['tip_pro_id'], $_POST['uni_id']);
				for($i=0; $i<count($arrDatos);$i++){
					$objValores->setValores($arrDatos[$i]['id'],$arrDatos[$i]['prevision'],$arrDatos[$i]['valor']);
					$valores = $objValores->buscarValoresProducto($objCon, $_POST['pro_id']);
					if($valores[$i]['val_id']!=$arrDatos[$i]['id']){
						$objValores->agregarValores($objCon, $_POST['pro_id'], $arrDatos[$i]['id']);
					}else{
						$objValores->editarValores($objCon, $_POST['pro_id'], $arrDatos[$i]['id']);
					}					
				}	
		 		$objCon->commit();	
		 		echo 'bien';					 		
			}catch (PDOException $e){
					$objCon->rollBack(); 
					$e->getMessage();
			}
		break;

	}

?>