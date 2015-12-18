<?php 

class Bono{
	 private $bonId;
	 private $tipBonId;
	 private $bonMonto;
	 
	function setBono($bonId, $tipBonId,$bonMonto){
	 		$this->bonId=trim($bonId);
	 		$this->tipBonId=trim($tipBonId);
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
	function guardarBonos($objCon, $cue_id, $pss_id){
 		$sql ="INSERT INTO bono(bono.bonId,bono.cue_id,bono.pss_id,bono.tipBonId,bono.bonMonto)
			   VALUES ('$this->bonId','$cue_id','$pss_id','$this->tipBonId','$this->bonMonto')";		   
	 	$rs=$objCon->ejecutarSQL($sql,'ERROR AL guardarBonos');
	 	return $rs;			
	}
	function buscarBonosPSS($objCon, $pss_id){
 		$sql="SELECT 
			SUM(bono.bonMonto) AS monto
			FROM bono
			WHERE pss_id = '$pss_id'";
		$datos = array();
		$i=0;
		foreach ($objCon->consultaSQL($sql, 'ERROR buscarBonosPSS') as $v) {
			$datos[$i][monto]=$v['monto'];
			$i++;
	    }
		return $datos;			
	}
	function listarBonosPSS($objCon, $pss_id){
 		$sql="SELECT bono.bonId, 
			bono.cue_id, 
			bono.pss_id, 
			bono.tipBonId, 
			bono.bonMonto
			FROM bono
			WHERE pss_id = '$pss_id'";
		$datos = array();
		$i=0;
		foreach ($objCon->consultaSQL($sql, 'ERROR listarBonosPSS') as $v) {
			$datos[$i][bonId]=$v['bonId'];
			$datos[$i][cue_id]=$v['cue_id'];
			$datos[$i][pss_id]=$v['pss_id'];
			$datos[$i][tipBonId]=$v['tipBonId'];
			$datos[$i][bonMonto]=$v['bonMonto'];
			$i++;
	    }
		return $datos;			
	}

}
?>
