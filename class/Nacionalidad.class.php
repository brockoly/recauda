<?php

	class Nacionalidad{
		private $nac_id;
		private $nac_nombre;

		function actualizarNacionalidad($objCon, $per_id){
			$sql ="UPDATE nacionalidad_persona 
				   SET nac_id = '$this->nac_id'
				   WHERE per_id = '$per_id'";		
			$rs = $objCon->ejecutarSQL($sql, 'ERROR actualizarNacionalidad');
				return $rs;
		}

		function insertarNacionalidadPersona($objCon, $per_id){
			$sql ="INSERT INTO nacionalidad_persona 
							   (nac_id, per_id)
			       VALUES ('$this->nac_id', '$per_id')";		
			$rs =$objCon->ejecutarSQL($sql, 'ERROR AL insertarNacionalidad');
			return $rs;
		}

		function obtenerNacionalidades($objCon){
			$sql="SELECT nac_id, nac_nombre
				  FROM nacionalidad";
			$datos = array();
			$i=0;
			foreach ($objCon->consultaSQL($sql, 'ERROR obtenerNacionalidades') as $v) {
				$datos[$i]['nac_id']=$v['nac_id'];
				$datos[$i]['nac_nombre']=$v['nac_nombre'];
				$i++;
		    }
			return $datos;
		}

		function modificarNacionalidad($objCon){
		 	$sql="UPDATE nacionalidad
				  SET nacionalidad.nac_nombre='$this->nac_nombre'
				  WHERE nacionalidad.nac_id=$this->nac_id";
			$rs=$objCon->ejecutarSQL($sql,'ERROR AL modificarNacionalidad');
		 	return $rs;
		}

		function setNacionalidad($nac_id,$nac_nombre){
		 	$this->nac_id=$nac_id;
		 	$this->nac_nombre=trim($nac_nombre);
		}

		function buscaNacionalidad($objCon){//

		 	$sql="SELECT nac_nombre
				  FROM nacionalidad
				  WHERE nac_nombre='$this->nac_nombre'";
			$i=0;
			foreach ($objCon->consultaSQL($sql, 'ERROR obtenerNacionalidades') as $v) {
				$datos=$v['nac_nombre'];
		    }
			return $datos;		 	
		}

		function buscarMaximoId($objCon){//

		 	$sql="SELECT MAX(nac_id)+1 as CONT
				  FROM nacionalidad";
			$i=0;
			$datos;
			foreach ($objCon->consultaSQL($sql, 'ERROR obtenerNacionalidades') as $v) {
				$datos=$v['CONT'];
		    }
		    if($datos==""){
		    	$datos=1;
		    }
			return $datos;		 	
		}

		function insertarNacionalidad($objCon){
		 	$max=$this->buscarMaximoId($objCon);
		 	$sql ="INSERT INTO nacionalidad(nac_id, nac_nombre)
				   VALUES ($max, '$this->nac_nombre')";
		 	$rs=$objCon->ejecutarSQL($sql,'ERROR AL insertarNacionalidad');
		 	return $rs;
		}
	}
?>