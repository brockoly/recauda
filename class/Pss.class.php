<?php

class Pss{
	   private $pss_id;
	   private $pss_fecha;
	   private $pss_hora;
	   private $pss_saldo;
	   private $pss_estado; //ESTADOS: Abierto, cerrado, valorizado, abonado y pagado
	   private $pssPrevId;
	   private $pssInsId;

		function setPss($pss_id, $pss_fecha, $pss_hora, $pss_saldo, $pss_estado, $pss_PrevId, $pss_InsId){
		    $this->pss_id=$pss_id;
		    $this->pss_fecha=$pss_fecha;
		    $this->pss_hora=$pss_hora;
		    $this->pss_saldo=$pss_saldo;
		    $this->pss_estado=$pss_estado;
		    $this->pssPrevId=$pss_PrevId;
		    $this->pssInsId=$pss_InsId;
		}

		function setPss_estado($pss_estado){
			$this->pss_estado=$pss_estado;
		}

		function setPss_id($pss_id){
			$this->pss_id=$pss_id;
		}

		function generarPss($objCon, $cue_id){
			session_start();
			$usu_nombre=$_SESSION['usuario'][1]['nombre_usuario'];		
	  		$sql ="INSERT INTO pss(cue_id, pss_id, usu_nombre, pss_fecha, pss_hora, pss_saldo, pss_estado, pssPrevId,
	  							   pssInsId)
	  			   VALUES ($cue_id, $this->pss_id, '$usu_nombre', '$this->pss_fecha','$this->pss_hora',
	  			   		   $this->pss_saldo, '$this->pss_estado', $this->pssPrevId,  $this->pssInsId)";	
			$rs =$objCon->ejecutarSQL($sql, 'ERROR AL generarCtaCte');
		 	return $rs;
		}

		function buscarMaximoId($objCon,$cue_id){//

		 	$sql="SELECT MAX(pss_id)+1 as CONT
				  FROM pss";
			$i=0;
			$datos=1;
			foreach ($objCon->consultaSQL($sql, 'ERROR buscarMaximoId') as $v) {
				if(is_null($v['CONT'])==false){
    	 			$datos = $v['CONT'];
    	 		}
		    }
			return $datos;		 	
		}

		function buscarPss($objCon,$cuenta_id){
		 	$datos = array();
			$i=0;
			$sql ="SELECT
						pss.cue_id,
						pss.pss_id,
						pss.usu_nombre,
						pss.pss_fecha,
						pss.pss_hora,
						pss.pss_saldo,
						pss.pss_estado,
						pss.pssPrevId,
						pss.pssInsId
				   FROM pss
				   ";
			if(empty($cuenta_id)==false){
				$sql.=" WHERE cue_id=$cuenta_id";
			}else{
				$sql.=" WHERE pss_id=$this->pss_id";
			}		
				
		 	foreach($objCon->consultaSQL($sql, 'ERROR buscarPssCtaCte') as $v) {
					$datos[$i]['cue_id']=$v['cue_id'];
					$datos[$i]['pss_id']=$v['pss_id'];
					$datos[$i]['usu_nombre']=$v['usu_nombre'];
					$datos[$i]['pss_fecha']=$v['pss_fecha'];
					$datos[$i]['pss_hora']=$v['pss_hora'];
					$datos[$i]['pss_saldo']=$v['pss_saldo'];
					$datos[$i]['pss_estado']=$v['pss_estado'];
					$datos[$i]['pssPrevId']=$v['pssPrevId'];
					$datos[$i]['pssInsId']=$v['pssInsId'];
					$i++;
			}
		 	return $datos;
		}
		function desplegarBotonesAcciones($estado,$institucion,$pss_id){
			$ancho=30;
			$alto=30;
			$botones="";
			/*--------------------------Condiciones de los botones------------------------*/
			$rulesAbierto  = array(0 => "Cerrado",1 => "Valorizado",);
			$rulesCerrar  = array(0 => "Abierto",);
			$rulesDetalle  = array(0 => "Valorizado", 1=> "Abonado", 2=>"Pagado");
			$rulesEditarpSS  = array(0 => "Abierto");
			$rulesImprimir  = array(0 => "Valorizado", 1=> "Abonado", 2=>"Pagado");
			$rulesValorizar  = array(0 => "Cerrado",);
			$rulesPagar = array(0 => "Valorizado", 1=> "Abonado",);
			$rulesAbonar = array(0 => "Pagado",);
			$rulesOrdenAtencion  = array(0 => "Pagado",1=> "Abonado",2=> "Valorizado",);// Se valida con la institucion;
			/*--------------------------Botones------------------------*/


			$abrir='<img class="open opcionPss" id="'.$pss_id.'" src="./include/img/open.png" width="'.$ancho.'" height="'.$alto.'" style="cursor: pointer;">';
			$cerrar='<img class="close opcionPss" id="'.$pss_id.'" src="./include/img/close.png" width="'.$ancho.'" height="'.$alto.'" style="cursor: pointer;">';
			$detalle='<img class="detalle opcionPss" id="'.$pss_id.'" src="./include/img/detalle.png" width="'.$ancho.'" height="'.$alto.'" style="cursor: pointer;">';
			$editPss='<img class="editPss opcionPss" id="'.$pss_id.'" src="./include/img/editPss.png" width="'.$ancho.'" height="'.$alto.'" style="cursor: pointer;">';							
			$imprimir='<img class="printer opcionPss" id="'.$pss_id.'" src="./include/img/printer.png" width="'.$ancho.'" height="'.$alto.'" style="cursor: pointer;">';
			$valorizar='<img class="calculator opcionPss" id="'.$pss_id.'" src="./include/img/calculator.png" width="'.$ancho.'" height="'.$alto.'" style="cursor: pointer;">';
			$pagar='<img class="pagar opcionPss" id="'.$pss_id.'" src="./include/img/pagar.png" width="'.$ancho.'" height="'.$alto.'" style="cursor: pointer;">';
			$abonar='<img class="abonar opcionPss" id="'.$pss_id.'" src="./include/img/abonar.png" width="'.$ancho.'" height="'.$alto.'" style="cursor: pointer;">';
			$ordenAtencion='<img class="ordenAtencion opcionPss" id="'.$pss_id.'" src="./include/img/ordenAtencion.png" width="'.$ancho.'" height="$alto" style="cursor: pointer;">';
		 	
		 	if(in_array($estado, $rulesAbierto)){
		 		$botones.=$abrir;
			}
			if(in_array($estado, $rulesCerrar)){
		 		$botones.=$cerrar;
			}
			if(in_array($estado, $rulesDetalle)){
		 		$botones.=$detalle;
			}
			if(in_array($estado, $rulesEditarpSS)){
		 		$botones.=$editPss;
			}
			if(in_array($estado, $rulesImprimir)){
		 		$botones.=$imprimir;
			}
			if(in_array($estado, $rulesValorizar)){
		 		$botones.=$valorizar;
			}
			if(in_array($estado, $rulesPagar)){
		 		$botones.=$pagar;
			}
			if(in_array($estado, $rulesAbonar)){
		 		$botones.=$abonar;
			}
			if(in_array($estado, $rulesOrdenAtencion)){
		 		$botones.=$ordenAtencion;
			}
			return $botones;
		}
		function cambiarEstadoPss($objCon){
			$sql="UPDATE pss
				  SET pss.pss_estado='$this->pss_estado'
				  WHERE pss_id=$this->pss_id";
			$rs=$objCon->ejecutarSQL($sql,'ERROR AL cambiarEstadoPss');
		 	return $rs;

		}
		function verDetallePss($objCon){
			

		}
}
?>