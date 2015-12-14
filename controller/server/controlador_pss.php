<?php 
	
		require_once('../../class/Conectar.class.php'); $objCon = new Conectar();
		require_once('../../class/Cuenta_Corriente.class.php'); $objCta = new Cuenta_Corriente();
		require_once('../../class/Pss.class.php'); $objPss = new Pss();
		require_once('../../class/Paciente.class.php'); $objPac = new Paciente();

		switch($_POST['op']){

				case "agregarPSS":
						session_start();				 							
						try{
							$objCon->db_connect();
							$objCon->beginTransaction();
							$pss_id=$objPss->buscarMaximoId($objCon, $cue_id);
							$paciente = $objPac->getInformacionPaciente($objCon, "", "", $cue_id);
							$objPss->setPss($pss_id, date("Y-m-d"), date("H:m:s"), 0, "Abierto", $paciente[0]['prevision_id'], $paciente[0]['inst_id']);
						 	$objPss->generarPss($objCon,$cue_id);
						 	$objCon->commit();						 	
						 	echo "PSS creado con exito.";					 	
							unset($_SESSION['cue_id']);
													 		
						}catch (PDOException $e){
					 			$objCon->rollBack(); 
					 			echo $e->getMessage();
						}
				break;

				case "abrirPss":
						session_start();
						$pss_id=$_POST['pss_id'];					 							
						try{
							$objCon->db_connect();
							$objCon->beginTransaction();
							$objPss->setPss_id($pss_id);
							$objPss->setPss_estado("Abierto");
							$objPss->cambiarEstadoPss($objCon);				
						 	$objCon->commit();						 	
						 	echo "PSS Abierto con exito.";
													 		
						}catch (PDOException $e){
					 			$objCon->rollBack(); 
					 			echo $e->getMessage();
						}
				break;

				case "cerrarPss":
						$pss_id=$_POST['pss_id'];					 							
						try{
							$objCon->db_connect();
							$objCon->beginTransaction();
							$objPss->setPss_id($pss_id);
							$objPss->setPss_estado("Cerrado");
							$objPss->cambiarEstadoPss($objCon);				
						 	$objCon->commit();						 	
						 	echo "PSS Cerrado con exito.";
													 		
						}catch (PDOException $e){
					 			$objCon->rollBack(); 
					 			echo $e->getMessage();
						}
				break;
				case "valorizarPss":
						$pss_id=$_POST['pss_id'];					 							
						try{
							$objCon->db_connect();
							$objCon->beginTransaction();
							$objPss->setPss_id($pss_id);
							if($_POST['total']==0){
								$objPss->setPss_estado("Pagado");
							}else{
								$objPss->setPss_estado("Valorizado");
							}
							
							$objPss->cambiarEstadoPss($objCon);				
						 	$objCon->commit();						 	
						 	echo "PSS valorizado con exito.";
													 		
						}catch (PDOException $e){
					 			$objCon->rollBack(); 
					 			echo $e->getMessage();
						}
				break;
				case "pagarPSS":
						$pss_id=$_POST['pss_id'];					 							
						try{
							$objCon->db_connect();
							$objCon->beginTransaction();
							$objPss->setPss_id($pss_id);
							$objPss->setPss_estado("Pagado");
							$objPss->cambiarEstadoPss($objCon);				
						 	$objCon->commit();						 	
						 	echo "PSS valorizado con exito.";
													 		
						}catch (PDOException $e){
					 			$objCon->rollBack(); 
					 			echo $e->getMessage();
						}
				break;

				case "agregarProductoPss":
						session_start();
						$pss_id=$_SESSION['pss_id'];
						$cue_id=$_SESSION['cue_id'];					 							
						try{
							$objCon->db_connect();
							$objCon->beginTransaction();
							$objPss->setPss_id($pss_id);
							$productosFinal = explode(",", $_POST['productosFinal']);

							if(count($productosFinal)>1){
								$objPss->insertarDetallePss($objCon, $cue_id, $productosFinal);
								if($_POST['cambiarEstado']=="si"){
									$objPss->setPss_estado("Cerrado");
									$objPss->cambiarEstadoPss($objCon);
								}								
								$objCon->commit();
							 	unset($_SESSION['pss_id']);
							    unset($_SESSION['cue_id']);
							}
													 	
							echo "PSS Modificado con exito.";				 		
						}catch (PDOException $e){
					 			$objCon->rollBack(); 
					 			echo $e->getMessage();
						}
				break;

				case "eliminarProductoPss":
						session_start();
						$pss_id=$_SESSION['pss_id'];					 							
						try{
							$objCon->db_connect();
							$objCon->beginTransaction();
							$objPss->setPss_id($pss_id);
							$objPss->eliminarProductoDetallePss($objCon, $_POST['idPro']);									
						 	$objCon->commit();												 		
						}catch (PDOException $e){
					 			$objCon->rollBack(); 
					 			echo $e->getMessage();
						}
				break;

		}

?>