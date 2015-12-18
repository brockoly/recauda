<?php 	
class Tipo_pago{
	public $tip_pag_descripcion;
	public $tip_pag_id;
	public $tip_Pro_estado;
	private $pag_codigoTransaccion;
	private $pag_codigoAutorizacion;
	private $pag_folioCheque;
	private $pag_banco;

	function setTipoPago($tip_pag_id,$tip_pag_descripcion,$pag_codigoTransaccion,$pag_codigoAutorizacion,$pag_folioCheque,$pag_banco){
		$this->tip_pag_descripcion=trim($tip_pag_descripcion);
		$this->tip_pag_id=trim($tip_pag_id);
		$this->pag_codigoTransaccion=trim($pag_codigoTransaccion);
		$this->pag_codigoAutorizacion=trim($pag_codigoAutorizacion);
		$this->pag_folioCheque=trim($pag_folioCheque);
		$this->pag_banco=trim($pag_banco);
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
		$sql ="INSERT INTO pagos_tipoPago(cue_id, pss_id, pag_id, tip_pag_id, pag_monto,pag_codigoTransaccion,pag_codigoAutorizacion,pag_folioCheque,pag_banco)
			   VALUES ('$cue_id', '$pss_id', '$pag_id', '$this->tip_pag_id','$pag_monto','$this->pag_codigoTransaccion','$this->pag_codigoAutorizacion','$this->pag_folioCheque','$this->pag_banco')";
	 	$rs=$objCon->ejecutarSQL($sql,'ERROR AL agregarTipoPago');
	 	return $rs;
	}
}?>