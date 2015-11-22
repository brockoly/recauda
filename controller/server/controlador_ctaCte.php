<?php 
		require_once('../../class/Conectar.class.php'); $objCon = new Conectar();
		require_once('../../class/Cuenta_Corriente.class.php'); $objCta = new Cuenta_Corriente();
		require_once('../../class/Pss.class.php'); $objPss = new Pss();
		require_once('../../class/Paciente.class.php'); $objPac = new Paciente();

		switch($_POST['op']){

				case "agregarCta":
						session_start();						 							
						try{
								$objCon->db_connect();
								$objPac->setPaciente($_SESSION['pac_id']);
								$paciente = $objPac->getInformacionPaciente($objCon, "", "");								
						 		$objCon->beginTransaction();
						 		$cue_id=$objCta->buscarMaximoId($objCon);
								$objCta->setCuenta_Corriente($cue_id, $_POST['unidadOrigen'], date("Y-m-d"));	
						 		$objCta->generarCtaCte($objCon, $_SESSION['pac_id']);
						 		$pss_id=$objPss->buscarMaximoId($objCon,$cue_id);
						 		$objPss->setPss($pss_id, date("Y-m-d"), date("H:m:s"), 0, "Abierto", $paciente[0]['prevision_id'], $paciente[0]['inst_id']);
						 		$objPss->generarPss($objCon,$cue_id);
						 		$objCon->commit();
						 		unset($_SESSION['pac_id']);
						 		echo "Cuenta Corriente creada con exito.";
						 		$objCon=null;					 		
						}catch (PDOException $e){
					 			$objCon->rollBack(); 
					 			echo $e->getMessage();
						}

				break;

		}

?>