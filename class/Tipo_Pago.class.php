<?php 	
class Tipo_pago{
	 public $tip_pag_descripcion;
	 public $tip_pag_id;
	 public $tip_Pro_estado;
	 
	 function setTipoPago($tip_pag_id,$tip_pag_descripcion){
 		$this->tip_pag_descripcion=trim($tip_pag_descripcion);
 		$this->tip_pag_id=trim($tip_pag_id);
	 }
	function listarTipoPago($objCon){
	 	$sql ="SELECT
			tipo_pago.tip_pag_id,
			tipo_pago.tip_pag_descripcion
			FROM tipo_pago";
	 	$datos = array();
			$i=0;
			foreach ($objCon->consultaSQL($sql, 'ERROR listarTipoPago') as $v) {
				$datos[$i][tip_pag_id]=$v['tip_pag_id'];
				$datos[$i][tip_pag_descripcion]=$v['tip_pag_descripcion'];
				$i++;
		    }
			return $datos;
	}
	function agregarTipoPago($objCon,$cue_id,$pss_id,$pag_id,$pag_monto){
		$sql ="INSERT INTO pagos_tipoPago(cue_id, pss_id, pag_id, tip_pag_id, pag_monto)
			   VALUES ('$cue_id', '$pss_id', '$pag_id', '$this->tip_pag_id','$pag_monto')";
	 	$rs=$objCon->ejecutarSQL($sql,'ERROR AL agregarTipoPago');
	 	return $rs;
	}
}?>