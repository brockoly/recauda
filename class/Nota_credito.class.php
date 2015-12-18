<?php 

class Nota_Credito{
	 private $not_id;
	 private $usu_nombre;
	 private $cue_id;
	 private $pss_id;
	 private $not_fecha;
	 private $not_hora;
	 private $not_monto;
	 private $not_motivo;

	function notaMax($objCon){
		$sql="SELECT MAX(not_id)+1 as CONT
				  FROM nota_credito";
			$i=0;
			$datos;
			foreach ($objCon->consultaSQL($sql, 'ERROR maxNota') as $v) {
				$datos=$v['CONT'];
		    }
		    if($datos==""){
		    	$datos=1;
		    }
			return $datos;	
	}
	function setNota($not_id, $not_fecha, $not_hora, $usu_nombre, $not_motivo, $not_monto, $cue_id, $pss_id){
	 		$this->not_id=trim($not_id);
	 		$this->not_fecha=trim($not_fecha);
	 		$this->not_hora=trim($not_hora);
	 		$this->usu_nombre=trim($usu_nombre);
	 		$this->not_motivo=trim($not_motivo);
	 		$this->not_monto=trim($not_monto);
	 		$this->cue_id=trim($cue_id);
	 		$this->pss_id=trim($pss_id);
	}
	function rendirNota($objCon, $arq_id, $not_id){

		$sql ="UPDATE nota_credito 
	 		   SET arq_id=$arq_id
			   WHERE not_id = $not_id";
		$rs =$objCon->ejecutarSQL($sql, 'ERROR AL rendirNota');
	 	return $rs;
	}
	function existenNoRendidas($objCon,$usu_nombre){
		$sql="SELECT nota_credito.not_id FROM nota_credito WHERE nota_credito.arq_id IS NULL AND nota_credito.usu_nombre='$usu_nombre'";
		$datos = array();
		$i=0;
		foreach ($objCon->consultaSQL($sql, 'ERROR noRendidas') as $v) {
			$datos[$i][not_id]=$v['not_id'];
			$i++;
		}
		return $datos;
	}
	function buscarNota($objCon, $not_id, $usu_nombre, $arqueo){

		$sql="	SELECT 	nota_credito.not_id,
						nota_credito.usu_nombre,
						nota_credito.not_fecha,
						nota_credito.not_hora,
						nota_credito.not_motivo,
						nota_credito.not_monto,
						nota_credito.cue_id,
						nota_credito.pss_id
						from nota_credito";

				if($not_id!=''){
					$sql.=" WHERE nota_credito.not_id='".$not_id."'";
				}else if($usu_nombre!=''){
					$sql.=" WHERE nota_credito.usu_nombre='".$usu_nombre."'";
				}
				if($not_id=='' && $usu_nombre=='' && $arqueo!=''){
					$sql.=' WHERE nota_credito.arq_id IS NULL';
				}
				if($not_id=='' && $usu_nombre!='' && $arqueo!=''){
					$sql.=' AND nota_credito.arq_id IS NULL';
				}
				if($not_id!='' && $usu_nombre=='' && $arqueo!=''){
					$sql.=' AND nota_credito.arq_id IS NULL';
				}

		$datos = array();
		$i=0;
		foreach ($objCon->consultaSQL($sql, 'ERROR buscarNota') as $v) {
			$datos[$i][not_id]=$v['not_id'];
			$datos[$i][usu_nombre]=$v['usu_nombre'];
			$datos[$i][not_fecha]=$v['not_fecha'];
			$datos[$i][not_hora]=$v['not_hora'];
			$datos[$i][not_motivo]=$v['not_motivo'];
			$datos[$i][not_monto]=$v['not_monto'];
			$datos[$i][cue_id]=$v['cue_id'];
			$datos[$i][pss_id]=$v['pss_id'];
			$i++;
	    }
		return $datos;
	}
	function buscarNotaArqueadas($objCon, $arq_id){

		$sql="	SELECT 	nota_credito.not_id,
						nota_credito.usu_nombre,
						nota_credito.not_fecha,
						nota_credito.not_hora,
						nota_credito.not_motivo,
						nota_credito.not_monto,
						nota_credito.cue_id,
						nota_credito.pss_id
						from nota_credito WHERE nota_credito.arq_id='".$arq_id."'";				

		$datos = array();
		$i=0;
		foreach ($objCon->consultaSQL($sql, 'ERROR buscarNota') as $v) {
			$datos[$i][not_id]=$v['not_id'];
			$datos[$i][usu_nombre]=$v['usu_nombre'];
			$datos[$i][not_fecha]=$v['not_fecha'];
			$datos[$i][not_hora]=$v['not_hora'];
			$datos[$i][not_motivo]=$v['not_motivo'];
			$datos[$i][not_monto]=$v['not_monto'];
			$datos[$i][cue_id]=$v['cue_id'];
			$datos[$i][pss_id]=$v['pss_id'];
			$i++;
	    }
		return $datos;
	}


}
?>
