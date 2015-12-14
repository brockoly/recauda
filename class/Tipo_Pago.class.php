<?php 	
class Tipo_pago{
	 public $tip_pag_descripcion;
	 public $tip_pag_id;
	 public $tip_Pro_estado;
	 
	 function setTipoPago($tip_pagId,$tip_pag_descripcion){
 		$this->tip_pag_descripcion=utf8_decode(trim($tip_pag_descripcion));
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
}?>