<?php 
	session_start();
	require_once('../../class/Conectar.class.php'); $objCon = new Conectar();
	require_once('../../class/Nota_Credito.class.php'); $objNot = new Nota_Credito();
	require_once('../../class/Boleta.class.php'); $objBol = new Boleta();
	require_once('../../class/Arqueo.class.php'); $objArq = new Arqueo();
	require_once('../../class/Util.class.php');$objUti = new Util();

	switch($_POST['op']) {
		case "rendirNota":		
			$objCon->db_connect();
			$usu_nombre = $_SESSION['usuario'][1]['nombre_usuario'];
			$notas = $objNot->existenNoRendidas($objCon,$usu_nombre);			
			try{
		 		$objCon->beginTransaction();
		 		$datox=$objArq->arqueoMax($objCon);
		 		$arqueoId =$datox;
	 			$objArq->setArqueo($arqueoId, date('Y-m-d'), date('H:i:s'), $usu_nombre);
	 			$objArq->rendirArqueo($objCon);
		 		for($i=0;$i<count($notas);$i++){
		 			$objBol->rendirBoleta($objCon, $arqueoId, $notas[$i]['bol_id']);		 			
		 		}
		 		$objCon->commit();			 		
		 		echo $arqueoId;
			}catch (PDOException $e){
					$objCon->rollBack(); 
					$e->getMessage();
			}
			
		break;

		case "buscarNoRendidos":				
			$objCon->db_connect();
			try{
		 		$objCon->beginTransaction();		 		
		 		$usu_nombre = $_SESSION['usuario'][1]['nombre_usuario'];
				$res = json_encode($objNot->existenNoRendidas($objCon,$usu_nombre));
		 		$objCon->commit();	
		 		echo $res;					 		
			}catch (PDOException $e){
					$objCon->rollBack(); 
					$e->getMessage();
			}
		break;
	}

?>