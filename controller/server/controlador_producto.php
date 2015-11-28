<?php 
	require_once('../../class/Conectar.class.php'); $objCon = new Conectar();
	require_once('../../class/Producto.class.php');$objPro = new Producto();
	require_once('../../class/Tipo_Producto.class.php');$objTipoPro = new Tipo_Producto();
	require_once('../../class/Unidad_Medida.class.php');$objUnidadM = new Unidad_Medida();
	require_once('../../class/Valores.class.php');$objValores = new Valores();

	switch($_POST['op']) {
		case "addProducto":		
			echo $_POST['datosPre'];
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
			print_r($arrDatos);
			try{
		 		$objCon->beginTransaction();
		 		$objPro->setProducto($_POST['pro_id'],$_POST['pro_nom'],'0');
				echo "entra 1  ";
				echo $_POST['pro_id'].' --- '.$_POST['pro_nom'].' --- '.$_POST['tip_pro_id'].' --- '.$_POST['uni_id'].' --- '.$arrDatos[0]['id'];
				echo $objPro->agregarProducto($objCon,$_POST['tip_pro_id'], $_POST['uni_id']);
				echo "entra 2";
				print_r($arrDatos);
				echo count($arrDatos);
				for($i=0; $i<count($arrDatos);$i++){
					$objValores->setValores($arrDatos[$i]['id'],$arrDatos[$i]['prevision'],$arrDatos[$i]['valor']);
					echo $objValores->agregarValores($objCon, $_POST['pro_id'], $arrDatos[$i]['id']);
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

	}

?>