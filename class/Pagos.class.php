<?php 

class Pagos{
	private $pag_id;

	function setPagos($pag_id){
	 		$this->pag_id=trim($pag_id);
	}
	function buscarMaximoId($objCon){//

	 	$sql="SELECT MAX(pag_id)+1 as CONT
			  FROM pagos";
		$i=0;
		$datos=1;
		foreach ($objCon->consultaSQL($sql, 'ERROR buscarMaximoId') as $v) {
			if(is_null($v['CONT'])==false){
	 			$datos = $v['CONT'];
	 		}
	    }
		return $datos;		 	
	}
	function agregarPago($objCon,$cue_id,$pss_id){
		$sql ="INSERT INTO pagos(cue_id, pss_id, pag_id)
			   VALUES ('$cue_id', '$pss_id', '$this->pag_id')";
	 	$rs=$objCon->ejecutarSQL($sql,'ERROR AL agregarPago');
	 	return $rs;
	}
	function listarPagosPSS($objCon, $pss_id, $bol_id){ //Cambiar en todos los lados que se llama
		$sql="SELECT
			pagos.cue_id,
			pagos.pss_id,
			pagos_tipopago.pag_monto,
			boleta.bol_fecha,
			boleta.bol_tipo,
			boleta.bol_id,
			boleta.bol_hora,
			boleta.usu_nombre,
			CONCAT(persona.per_nombre,' ',persona.per_apellidoPaterno,' ',persona.per_apellidoMaterno) AS nombre,
			tipo_pago.tip_pag_descripcion
			FROM
			pagos_tipopago
			INNER JOIN tipo_pago ON pagos_tipopago.tip_pag_id = tipo_pago.tip_pag_id
			INNER JOIN pagos ON pagos.pag_id = pagos_tipopago.pag_id
			INNER JOIN boleta ON pagos.pag_id = boleta.pag_id
			INNER JOIN usuario ON usuario.usu_nombre = boleta.usu_nombre
			INNER JOIN persona ON usuario.per_id = persona.per_id";


			if(empty($bol_id)==false){
				$sql.=" WHERE boleta.bol_id = '$bol_id'";
			}else{
				if(empty($pss_id)==false){
					$sql.=" WHERE boleta.pss_id = '$pss_id'";
				}
			}
			//echo $sql;
			$datos = array();
			$i=0;
			foreach ($objCon->consultaSQL($sql, 'ERROR listarPagosPSS') as $v) {
				$datos[$i][cue_id]=$v['cue_id'];
				$datos[$i][pss_id]=$v['pss_id'];
				$datos[$i][pag_monto]=$v['pag_monto'];
				$datos[$i][bol_fecha]=$v['bol_fecha'];
				$datos[$i][tip_pag_descripcion]=$v['tip_pag_descripcion'];
				$datos[$i][bol_id]=$v['bol_id'];
				$datos[$i][bol_hora]=$v['bol_hora'];
				$datos[$i][bol_tipo]=$v['bol_tipo'];
				$datos[$i][usu_nombre]=$v['usu_nombre'];
				$datos[$i][nombre]=$v['nombre'];
				$i++;
		    }
		return $datos;
	}
	function listarPagos($objCon, $pss_id, $bol_id){ //Cambiar en todos los lados que se llama
		$sql="SELECT
			pagos.cue_id,
			pagos.pss_id,
			boleta.bol_fecha,
			boleta.bol_id,
			boleta.bol_tipo,
			boleta.bol_hora,
			boleta.usu_nombre,
			CONCAT(persona.per_nombre,' ',persona.per_apellidoPaterno,' ',persona.per_apellidoMaterno) AS nombre
			FROM
			boleta
			INNER JOIN pagos ON pagos.pag_id = boleta.pag_id
			INNER JOIN usuario ON usuario.usu_nombre = boleta.usu_nombre
			INNER JOIN persona ON usuario.per_id = persona.per_id";


			if(empty($bol_id)==false){
				$sql.=" WHERE boleta.bol_id = '$bol_id'";
			}else{
				if(empty($pss_id)==false){
					$sql.=" WHERE boleta.pss_id = '$pss_id'";
				}
			}
			//echo $sql;
			$datos = array();
			$i=0;
			foreach ($objCon->consultaSQL($sql, 'ERROR listarPagosPSS') as $v) {
				$datos[$i][cue_id]=$v['cue_id'];
				$datos[$i][pss_id]=$v['pss_id'];
				$datos[$i][bol_fecha]=$v['bol_fecha'];
				$datos[$i][bol_id]=$v['bol_id'];
				$datos[$i][bol_hora]=$v['bol_hora'];
				$datos[$i][bol_tipo]=$v['bol_tipo'];
				$datos[$i][usu_nombre]=$v['usu_nombre'];
				$datos[$i][nombre]=$v['nombre'];
				$i++;
		    }
		return $datos;
	}	
}
?>
