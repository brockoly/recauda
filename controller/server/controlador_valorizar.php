<?php 
	
	require_once('../../class/Conectar.class.php'); $objCon = new Conectar();
	require_once('../../class/Valores.class.php'); $objVal = new Valores();

	switch($_POST['op']){

			case "valorProducto":					 							
					try{
							//echo $_POST['pro_id'].$_POST['pre_id'];
							$objCon->db_connect();
							$objCon->beginTransaction();
							$valor = $objVal->obtenerValorProducto($objCon, $_POST['pro_id'], $_POST['pre_id'],$_POST['ins_id']);
							//print_r($valor);
							echo $valor[0]['val_monto'];
					 		$objCon->commit();					 		
					}catch (PDOException $e){
				 			$objCon->rollBack(); 
				 			echo $e->getMessage();
					}
			break;
			case "actualizarValor":					 							
					try{
							//echo $_POST['pro_id'].$_POST['pre_id'];
							$objCon->db_connect();
							$objCon->beginTransaction();
							$objVal->setValores('',$_POST['val_monto']);
							$objVal->actualizarValoresProductos($objCon, $_POST['pro_id'], $pss_id);
							//print_r($valor);
							echo 'Actualizado';
					 		$objCon->commit();					 		
					}catch (PDOException $e){
				 			$objCon->rollBack(); 
				 			echo $e->getMessage();
					}
			break;
			

	}

?>