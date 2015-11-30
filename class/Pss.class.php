<?php

class Pss{
	   private $pss_id;
	   private $pss_fecha;
	   private $pss_hora;
	   private $pss_saldo;
	   private $pss_estado; //ESTADOS: Abierto, cerrado, valorizado, abonado y pagado
	   private $pss_prevId;
	   private $pss_insId;

		function setPss($pss_id, $pss_fecha, $pss_hora, $pss_saldo, $pss_estado, $pss_prevId, $pss_insId){
		    $this->pss_id=$pss_id;
		    $this->pss_fecha=$pss_fecha;
		    $this->pss_hora=$pss_hora;
		    $this->pss_saldo=$pss_saldo;
		    $this->pss_estado=$pss_estado;
		    $this->pss_prevId=$pss_prevId;
		    $this->pss_insId=$pss_insId;
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
	  		$sql ="INSERT INTO pss(cue_id, pss_id, usu_nombre, pss_fecha, pss_hora, pss_saldo, pss_estado, pss_prevId,
	  							   pss_insId)
	  			   VALUES ($cue_id, $this->pss_id, '$usu_nombre', '$this->pss_fecha','$this->pss_hora',
	  			   		   $this->pss_saldo, '$this->pss_estado', $this->pss_prevId,  $this->pss_insId)";	
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
						pss.pss_prevId,
						pss.pss_insId
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
					$datos[$i]['pss_prevId']=$v['pss_prevId'];
					$datos[$i]['pss_insId']=$v['pss_insId'];
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
			$datos = array();
			$i=0;
			$sql ="SELECT
				detalleproducto.pro_id,
				productos.pro_nom,
				detalleproducto.det_proCantidad,
				detalleproducto.det_proUnitario,
				(detalleproducto.det_proUnitario * detalleproducto.det_proCantidad) AS total,
				tipo_producto.tip_prod_id,
				tipo_producto.tip_descripcion
				FROM
				detalleproducto
				INNER JOIN productos ON detalleproducto.pro_id = productos.pro_id
				INNER JOIN tipo_producto ON productos.tip_prod_id = tipo_producto.tip_prod_id
				WHERE detalleproducto.pss_id = '$this->pss_id'";		
				
		 	foreach($objCon->consultaSQL($sql, 'ERROR verDetallePss') as $v) {
		 		$datos[$i]['pro_id']=$v['pro_id'];
		 		$datos[$i]['pro_nom']=$v['pro_nom'];
				$datos[$i]['det_proCantidad']=$v['det_proCantidad'];
				$datos[$i]['det_proUnitario']=$v['det_proUnitario'];
				$datos[$i]['total']=$v['total'];
				$datos[$i]['tip_prod_id']=$v['tip_prod_id'];
				$datos[$i]['tip_descripcion']=$v['tip_descripcion'];
				$i++;
			}
		 	return $datos;
		}
		function cabeceraPSS($objCon){
			$datos = array();
			$i=0;
			$sql ="SELECT
				persona.per_id,
				persona.per_nombre,
				persona.per_apellidoPaterno,
				persona.per_apellidoMaterno,
				persona.per_fechaNacimiento,
				persona.per_telefono,
				persona.per_direccion,
				persona.per_sexo,
				cuenta_corriente.cue_id,
				pss.pss_id,
				prevision.pre_nombre,
				institucion.ins_nombre
				FROM
				persona
				INNER JOIN paciente ON persona.per_id = paciente.per_id
				INNER JOIN cuenta_corriente ON paciente.pac_id = cuenta_corriente.pac_id
				INNER JOIN pss ON cuenta_corriente.cue_id = pss.cue_id
				INNER JOIN institucion ON pss.pss_insId = institucion.ins_id
				INNER JOIN prevision ON pss.pss_prevId = prevision.pre_id
				WHERE pss.pss_id = '$this->pss_id'";		
				
		 	foreach($objCon->consultaSQL($sql, 'ERROR cabeceraPSS') as $v) {
		 		$datos[$i]['per_id']=$v['per_id'];
		 		$datos[$i]['per_nombre']=$v['per_nombre'];
				$datos[$i]['per_apellidoPaterno']=$v['per_apellidoPaterno'];
				$datos[$i]['per_apellidoMaterno']=$v['per_apellidoMaterno'];
				$datos[$i]['per_fechaNacimiento']=$v['per_fechaNacimiento'];
				$datos[$i]['per_telefono']=$v['per_telefono'];
				$datos[$i]['per_direccion']=$v['per_direccion'];
				$datos[$i]['per_sexo']=$v['per_sexo'];
				$datos[$i]['cue_id']=$v['cue_id'];
				$datos[$i]['pss_id']=$v['pss_id'];
				$datos[$i]['pre_nombre']=$v['pre_nombre'];
				$datos[$i]['ins_nombre']=$v['ins_nombre'];
				$i++;
			}
		 	return $datos;
		}
}
?>