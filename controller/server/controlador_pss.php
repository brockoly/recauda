<?php 
		require_once('../../class/Conectar.class.php'); $objCon = new Conectar();
		require_once('../../class/Cuenta_Corriente.class.php'); $objCta = new Cuenta_Corriente();
		require_once('../../class/Pss.class.php'); $objPss = new Pss();
		require_once('../../class/Paciente.class.php'); $objPac = new Paciente();

		switch($_POST['op']){

				case "agregarPSS":
						session_start();
						$cue_id=$_SESSION['cue_id'];					 							
						try{
							$objCon->db_connect();
							$pss_id=$objPss->buscarMaximoId($objCon, $cue_id);
							$paciente = $objPac->getInformacionPaciente($objCon, "", "", $cue_id);
							$objPss->setPss($pss_id, date("Y-m-d"), date("H:m:s"), 0, "Abierto", $paciente[0]['prevision_id'], $paciente[0]['inst_id']);
						 	$objPss->generarPss($objCon,$cue_id);
						 	$objCon->commit();						 	
							unset($_SESSION['cue_id']);
						 	echo "Cuenta Corriente creada con exito.";
													 		
						}catch (PDOException $e){
					 			$objCon->rollBack(); 
					 			echo $e->getMessage();
						}
				break;

		}

?>