<?php 

class Pagos{
	 private $pag_id;
	 private $pag_monto;


	function setPagos($pag_id, $pag_monto){
	 		$this->pag_id=trim($pag_id);
	 		$this->pag_monto=trim($pag_monto);
	}
	function listarPagosPSS($objCon, $pss_id, $bol_id){ //Cambiar en todos los lados que se llama
		$sql="SELECT
				pagos.cue_id,
				pagos.pss_id,
				pagos.pag_monto,
				boleta.bol_fecha,
				tipo_pago.tip_pag_descripcion,
				boleta.bol_tipo,
				boleta.bol_id,
				boleta.bol_hora,
				boleta.usu_nombre
			 FROM
				pagos
			 INNER JOIN boleta ON pagos.pag_id = boleta.pag_id
			 INNER JOIN tipo_pago ON pagos.tip_pag_id = tipo_pago.tip_pag_id";

			if(empty($bol_id)==false){
				$sql.=" WHERE boleta.bol_id = '$bol_id'";
			}else{
				if(empty($pss_id)==false){
					$sql.=" WHERE boleta.pss_id = '$pss_id'";
				}
			}
			
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
				$i++;
		    }
		return $datos;
	}
	
}
?>
