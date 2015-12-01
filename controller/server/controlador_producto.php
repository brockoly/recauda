<?php 
	
	require_once('../../class/Conectar.class.php'); $objCon = new Conectar();
	require_once('../../class/Producto.class.php');$objPro = new Producto();
	require_once('../../class/Tipo_Producto.class.php');$objTipoPro = new Tipo_Producto();
	require_once('../../class/Unidad_Medida.class.php');$objUnidadM = new Unidad_Medida();
	require_once('../../class/Valores.class.php');$objValores = new Valores();

	switch($_POST['op']) {
		case "addProducto":		
			$objCon->db_connect();
			$datos = $_POST['datosEnviar'];
			$datos = explode(',',$datos);
			
			$nuevoArr = array();
			$cont = 0;
			for($i=0;$i<count($datos);$i++){
				$nuevoArr[$cont]['pre_id'] = $datos[$i]; 
				$nuevoArr[$cont]['ins_id'] = $datos[$i+1];
				$nuevoArr[$cont]['val_monto'] = $datos[$i+2];
				$i=$i+2;
				$cont++;
			}
			try{
		 		$objCon->beginTransaction();
		 		$objPro->setProducto($_POST['pro_id'],$_POST['pro_nom'],'0');
				$objPro->agregarProducto($objCon,$_POST['tip_pro_id'], $_POST['uni_id']);
				for($i=0; $i<count($nuevoArr);$i++){
					$val_id = $objValores->buscarMaximoId($objCon);
					$objValores->setValores($val_id,$nuevoArr[$i]['val_monto']);
					$objValores->agregarValores($objCon, $_POST['pro_id'], $nuevoArr[$i]['pre_id'], $nuevoArr[$i]['ins_id']);	
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
			$objCon->db_connect();
			$datos = $_POST['datosEnviar'];
			$datos = explode(',',$datos);
			
			$nuevoArr = array();
			$cont = 0;
			for($i=0;$i<count($datos);$i++){
				$nuevoArr[$cont]['pre_id'] = $datos[$i]; 
				$nuevoArr[$cont]['ins_id'] = $datos[$i+1];
				$nuevoArr[$cont]['val_monto'] = $datos[$i+2];
				$i=$i+2;
				$cont++;
			}
			try{
		 		$objCon->beginTransaction();
		 		$objPro->setProducto($_POST['pro_id'],$_POST['pro_nom'],'0');
				$objPro->editarProducto($objCon,$_POST['tip_pro_id'], $_POST['uni_id']);
				for($i=0; $i<count($nuevoArr);$i++){
					$val_id = $objValores->buscarMaximoId($objCon);
					$objValores->setValores($val_id,$nuevoArr[$i]['val_monto']);
					$valores = $objValores->buscarValoresProducto($objCon, $_POST['pro_id'], $nuevoArr[$i]['pre_id'],$nuevoArr[$i]['ins_id']);
					if($valores[0]==''){
						$objValores->agregarValores($objCon, $_POST['pro_id'], $nuevoArr[$i]['pre_id'], $nuevoArr[$i]['ins_id']);
					}else{
						$objValores->editarValores($objCon, $_POST['pro_id'], $nuevoArr[$i]['pre_id'], $nuevoArr[$i]['ins_id']);
					}
				}
		 		$objCon->commit();	
		 		echo 'bien';					 		
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
		case "eliminarProducto":				
			$objCon->db_connect();
			try{
		 		$objCon->beginTransaction();
		 		$objPro->setProducto($_POST['pro_id'],'','1');
				$objPro->cambiarEstadoProducto($objCon);
		 		$objCon->commit();	
		 		echo 'Producto eliminado con exito';					 		
			}catch (PDOException $e){
				$objCon->rollBack(); 
				$e->getMessage();
			}
		break;
		case "restaurarProducto":				
			$objCon->db_connect();
			try{
		 		$objCon->beginTransaction();
		 		$objPro->setProducto($_POST['pro_id'],'','0');
				$objPro->cambiarEstadoProducto($objCon);
		 		$objCon->commit();	
		 		echo 'Producto restaurado con exito';					 		
			}catch (PDOException $e){
				$objCon->rollBack(); 
				$e->getMessage();
			}
		break;
	}

?>