<?php 
	
	require_once('../../class/Conectar.class.php'); $objCon = new Conectar();
	require_once('../../class/Pagos.class.php');$objPag = new Pagos();
	require_once('../../class/Boleta.class.php');$objBol = new Boleta();
	require_once('../../class/Pss.class.php');$objPss = new Pss();
	switch($_POST['op']) {
		case "pagar":		
			session_start();
			$objCon->db_connect();
			$datos = $_POST['datos'];
			$datos = explode(',',$datos);
			$pss_saldo = $_POST['facturado'] - $_POST['pagoActual'];
			$nuevoArr = array();
			$cont = 0;
			for($i=0;$i<count($datos);$i++){
				$nuevoArr[$cont]['tip_pag_id'] = $datos[$i]; 
				$nuevoArr[$cont]['valor'] = $datos[$i+1];
				$i=$i+1;
				$cont++;
			}
			//print_r($nuevoArr);
			try{
		 		$objCon->beginTransaction();

		 		$pag_id = $objPag->buscarMaximoId($objCon);
		 		$bol_id = $objBol->buscarMaximoId($objCon);

		 		//echo "usuario->".$_SESSION['nombre_usuario'];
				for($i=0; $i<count($nuevoArr);$i++){
					$objPag->setPagos($pag_id, $nuevoArr[$i]['valor']);
					$objPag->agregarPago($objCon,$_POST['cue_id'],$_POST['pss_id'], $nuevoArr[$i]['tip_pag_id']);
				}
				$objBol->setBoleta($bol_id, '1', date('Y-m-d'), date('H:i:s'));
				$objBol->agregarNuevaBoleta($objCon,$_POST['cue_id'],$_POST['pss_id'],$pag_id, $_SESSION['usuario'][1]['nombre_usuario'],'1');
				$objPss->actualizarSaldo($objCon, $_POST['pss_id'], $pss_saldo);
		 		echo $bol_id;
		 		$objCon->commit();				 		
			}catch (PDOException $e){
					$objCon->rollBack(); 
					$e->getMessage();
			}
		break;
	}

?>