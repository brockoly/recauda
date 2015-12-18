<?php 
	
	require_once('../../class/Conectar.class.php'); $objCon = new Conectar();
	require_once('../../class/Pagos.class.php');$objPag = new Pagos();
	require_once('../../class/Boleta.class.php');$objBol = new Boleta();
	require_once('../../class/Pss.class.php');$objPss = new Pss();
	require_once('../../class/Tipo_Pago.class.php');$objTipo = new Tipo_Pago();
	switch($_POST['op']) {
		case "pagar":		
			session_start();
			$objCon->db_connect();			
			$datos = $_POST['datos'];
			$datos = explode(',',$datos);
			$pss_saldo = $_POST['facturado'] - $_POST['pagoActual'];
			$nuevoArr = array();
			$cont = 0;
			//echo count($datos);
			for($i=0;$i<count($datos);$i++){
				if($datos[0]!=''){

				}
				$nuevoArr[$cont]['tip_pag_id'] = $datos[$i]; 
				$nuevoArr[$cont]['valor'] = $datos[$i+1];
				$nuevoArr[$cont]['txtCodT'] = $datos[$i+2];
				$nuevoArr[$cont]['txtCodA'] = $datos[$i+3];
				$nuevoArr[$cont]['txtFolio'] = $datos[$i+4];
				$nuevoArr[$cont]['txtBanco'] = $datos[$i+5];
				$i=$i+5;
				$cont++;
			}

			$datosBonos = $_POST['datosBonos'];
			$datosBonos = explode(',', $datosBonos);
			print_r($datosBonos);
			try{
		 		$objCon->beginTransaction();
		 		$bol_id = $objBol->buscarMaximoId($objCon);
		 		$pag_id = $objPag->buscarMaximoId($objCon);
				$objPag->setPagos($pag_id);
				$objPag->agregarPago($objCon,$_POST['cue_id'],$_POST['pss_id']);
				$objBol->setBoleta($bol_id, '1', date('Y-m-d'), date('H:i:s'));
				$objBol->agregarNuevaBoleta($objCon,$_POST['cue_id'],$_POST['pss_id'],$pag_id, $_SESSION['usuario'][1]['nombre_usuario'],'1');
				for($i=0; $i<count($nuevoArr);$i++){
					$objTipo->setTipoPago($nuevoArr[$i]['tip_pag_id'],'',$nuevoArr[$i]['txtCodT'],$nuevoArr[$i]['txtCodA'],$nuevoArr[$i]['txtFolio'],$nuevoArr[$i]['txtBanco']);
					$objTipo->agregarTipoPago($objCon,$cue_id,$pss_id,$pag_id,$nuevoArr[$i]['valor']);
				}
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