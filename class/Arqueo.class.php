<?php 

class Arqueo{
	 private $arq_id;
	 private $usu_nombre;
	 private $arq_fecha;
	 private $arq_hora;

	function arqueoMax($objCon){
		$sql="SELECT MAX(arq_id)+1 as CONT
				  FROM arqueo";
			$i=0;
			$datos;
			foreach ($objCon->consultaSQL($sql, 'ERROR maxArqueo') as $v) {
				$datos=$v['CONT'];
		    }
		    if($datos==""){
		    	$datos=1;
		    }
			return $datos;	
	}
	function setArqueo($arq_id, $arq_fecha, $arq_hora, $usu_nombre){
	 		$this->arq_id=trim($arq_id);
	 		$this->arq_fecha=trim($arq_fecha);
	 		$this->arq_hora=trim($arq_hora);
	 		$this->usu_nombre=trim($usu_nombre);
	}
	function rendirArqueo($objCon){

		$sql="	INSERT INTO arqueo (arq_id, usu_nombre, arq_fecha, arq_hora) 
							VALUES ($this->arq_id, '$this->usu_nombre', '$this->arq_fecha', '$this->arq_hora')";
		$rs=$objCon->ejecutarSQL($sql,'ERROR AL rendirArqueo');
	 	return $rs;
	}
	function buscarArqueo($objCon, $arq_id, $usu_nombre){

		$sql="	SELECT 	arqueo.arq_id,
						arqueo.usu_nombre,
						arqueo.arq_fecha,
						arqueo.arq_hora
						from arqueo";

				if($arq_id!=''){
					$sql.=" WHERE arqueo.arq_id='".$arq_id."'";
				}else if($usu_nombre!=''){
					$sql.=" WHERE arqueo.usu_nombre='".$usu_nombre."'";
				}

		$datos = array();
		$i=0;
		foreach ($objCon->consultaSQL($sql, 'ERROR buscarArqueo') as $v) {
			$datos[$i][arq_id]=$v['arq_id'];
			$datos[$i][usu_nombre]=$v['usu_nombre'];
			$datos[$i][arq_fecha]=$v['arq_fecha'];
			$datos[$i][arq_hora]=$v['arq_hora'];
			$i++;
	    }
		return $datos;
	}
	function buscarArqueosRendidos($objCon, $usu_nombre){

		$sql="	SELECT 	arqueo.arq_id,
						arqueo.usu_nombre,
						arqueo.arq_fecha,
						arqueo.arq_hora
						from arqueo						
						 WHERE arqueo.usu_nombre='".strtolower($usu_nombre)."'";			
		$datos = array();
		$i=0;
		foreach ($objCon->consultaSQL($sql, 'ERROR buscarArqueo') as $v) {
			$datos[$i][arq_id]=$v['arq_id'];
			$datos[$i][usu_nombre]=$v['usu_nombre'];
			$datos[$i][arq_fecha]=$v['arq_fecha'];
			$datos[$i][arq_hora]=$v['arq_hora'];
			$i++;
	    }
		return $datos;
	}
}
?>
