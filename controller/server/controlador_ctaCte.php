<?php 
		require_once('../../class/Conectar.class.php'); $objCon = new Conectar();
		require_once('../../class/Cuenta_Corriente.class.php'); $objCta = new Cuenta_Corriente();

		switch($_POST['op']) {

				case "agregarCta":
						session_start();
						
						try{
							 		$objCon->beginTransaction();
							 		$cod=$objCta->buscarMaximoId($objCon);
									$objCta->setCuenta_Corriente($cod, $_POST['unidadOrigen'], date("Y-m-d"));
							 		$objCta->generarCtaCte($objCon, $_SESSION['pac_id']);
							 		$objCon->commit();
							 		unset($_SESSION['pac_id']);
							 		echo "Cuenta Corriente creada con exito.";					 		
						}catch (PDOException $e){
					 			$objCon->rollBack(); 
					 			echo $e->getMessage();
						}
									
						
						
				break;

		}

?>