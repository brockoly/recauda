<?php 

class Bono{
	 private $bonId;
	 private $bonMonto;
	 
	function setBoleta($bonId, $bonMonto){
	 		$this->bonId=trim($bonId);
	 		$this->bonMonto=trim($bonMonto);
	}

	function buscarTiposBonos($objCon){
 		$sql="SELECT
			tipobono.tipBonId,
			tipobono.tipBonNombre
			FROM tipobono";
		$datos = array();
		$i=0;
		foreach ($objCon->consultaSQL($sql, 'ERROR buscarTiposBonos') as $v) {
			$datos[$i][id]=$v['tipBonId'];
			$datos[$i][valor]=$v['tipBonNombre'];
			$i++;
	    }
		return $datos;			
	}
}
?>
