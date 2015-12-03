<?php

	class Institucion{

		private $ins_id;
		private $ins_nombre;

		function setInstitucion($ins_id,$ins_nombre){
			$this->ins_id=$ins_id;
			$this->ins_nombre=trim($ins_nombre);
		}
		function buscarMaximoId($objCon){//

			 	$sql="SELECT MAX(ins_id)+1 as CONT
					  FROM institucion";
				$i=0;
				$datos;
				foreach ($objCon->consultaSQL($sql, 'ERROR obtenerInstituciones') as $v) {
					$datos=$v['CONT'];
			    }
			    if($datos==""){
			    	$datos=1;
			    }
				return $datos;		 	
			}
		function actualizarInstitucion($conexion){

		}	
		function buscaInstitucion($objCon, $opcion){//
			if($opcion==1){
			 	$sql="SELECT ins_nombre
					  FROM institucion
					  WHERE ins_nombre='$this->ins_nombre'";
				$i=0;
				foreach ($objCon->consultaSQL($sql, 'ERROR obtenerInstituciones') as $v) {
					$datos=$v['ins_nombre'];
			    }
				return $datos;
			}

			if($opcion==2){
				$sql =" SELECT
								CASE 
								WHEN institucion.ins_nombre = '$this->ins_nombre' AND institucion.ins_id = '$this->ins_id' THEN 'Existe con id'
								WHEN institucion.ins_nombre = '$this->ins_nombre' AND institucion.ins_id <>'$this->ins_id'THEN 'Existe sin id'
								END AS condicion
					   	FROM recaudacion.institucion";
			 	foreach ($objCon->consultaSQL($sql,'ERROR buscaInstitucion') as $v) {
			 		if(is_null($v['condicion'])==false){
			 			$datos = $v['condicion'];
			 		}
			 	}
			 	return $datos;
			}	 	
		}
		function buscarInstitucionAsociacion($objCon, $pre_id){
			$sql="	SELECT 	DISTINCT 
							institucion.ins_id,
							institucion.ins_nombre
					FROM	institucion 
					LEFT JOIN institucion_prevision ON institucion.ins_id = institucion_prevision.ins_id 
					WHERE 	institucion.ins_id NOT IN (SELECT institucion_prevision.ins_id from institucion_prevision WHERE institucion_prevision.pre_id = $pre_id)";

			$datos = array();
			$i=0;
			foreach ($objCon->consultaSQL($sql, 'ERROR buscarInstitucion') as $v) {
				$datos[$i]['ins_id']=$v['ins_id'];
				$datos[$i]['ins_nombre']=$v['ins_nombre'];
				$i++;
		    }
			return $datos;
		}

		function buscarInstitucion($objCon, $pre_id){
			$sql="SELECT
				institucion.ins_id,
				institucion.ins_nombre
				FROM
				institucion
				INNER JOIN institucion_prevision ON institucion.ins_id = institucion_prevision.ins_id
				WHERE institucion_prevision.pre_id = '$pre_id'";
			$datos = array();
			$i=0;
			foreach ($objCon->consultaSQL($sql, 'ERROR buscarInstitucion') as $v) {
				$datos[$i]['id']=$v['ins_id'];
				$datos[$i]['valor']=$v['ins_nombre'];
				$i++;
		    }
			return $datos;
		}
		function obtenerPrevisionesInstitucion($objCon){
			$sql="	SELECT 	institucion_prevision.pre_id,
						 	prevision.pre_nombre
					FROM	institucion_prevision
					INNER JOIN prevision ON institucion_prevision.pre_id = prevision.pre_id
					WHERE institucion_prevision.ins_id = $this->ins_id";
			$datos = array();
			$i=0;
			foreach ($objCon->consultaSQL($sql, 'ERROR obtenerPrevisiones') as $v) {
				$datos[$i]['pre_id']=$v['pre_id'];
				$datos[$i]['pre_nombre']=$v['pre_nombre'];
				$i++;
			}
			return $datos;
		}
		function obtenerInstituciones($objCon){
			$sql="SELECT
				institucion.ins_id,
				institucion.ins_nombre
				FROM
				institucion";
			$datos = array();
			$i=0;
			foreach ($objCon->consultaSQL($sql, 'ERROR obtenerInstituciones') as $v){
				$datos[$i][ins_id]=$v['ins_id'];
				$datos[$i][ins_nombre]=$v['ins_nombre'];
				$i++;
			}
			return $datos;
		}
		function obtenerInstitucionesActivas($objCon){
			$sql="SELECT
				institucion.ins_id,
				institucion.ins_nombre
				FROM
				institucion
				WHERE institucion.ins_estado=0";
			$datos = array();
			$i=0;
			foreach ($objCon->consultaSQL($sql, 'ERROR obtenerInstituciones') as $v){
				$datos[$i][ins_id]=$v['ins_id'];
				$datos[$i][ins_nombre]=$v['ins_nombre'];
				$i++;
			}
			return $datos;
		}
		function obtenerInstitucionesInactivas($objCon){
			$sql="SELECT
				institucion.ins_id,
				institucion.ins_nombre
				FROM institucion
				WHERE institucion.ins_estado=1";
			$datos = array();
			$i=0;
			foreach ($objCon->consultaSQL($sql, 'ERROR obtenerInstituciones') as $v){
				$datos[$i][ins_id]=$v['ins_id'];
				$datos[$i][ins_nombre]=$v['ins_nombre'];
				$i++;
			}
			return $datos;
		}
		function modificarConvenio($objCon){
			 	$sql="UPDATE institucion
					  SET institucion.ins_nombre='$this->ins_nombre'
					  WHERE institucion.ins_id=$this->ins_id";
				$rs=$objCon->ejecutarSQL($sql,'ERROR AL modificarConvenio');
			 	return $rs;
		}
		function agregarConvenio($objCon,$arregloPrevisiones){
			 	$sql ="INSERT INTO institucion(ins_id, ins_nombre)
					   VALUES ($this->ins_id, '$this->ins_nombre')";
			 	$rs=$objCon->ejecutarSQL($sql,'ERROR AL agregarConvenio');
			 	$this->asociarInstitucion($objCon, $arregloPrevisiones);
			 	return $rs;
		}
		function desactivarInstitucion($objCon){
		 	$sql="UPDATE institucion
				  SET institucion.ins_estado=1
				  WHERE institucion.ins_id=$this->ins_id";
			$rs=$objCon->ejecutarSQL($sql,'ERROR AL desactivarInstitucion');
		 	return $rs;
		}
		function activarInstitucion($objCon){
		 	$sql="UPDATE institucion
				  SET institucion.ins_estado=0
				  WHERE institucion.ins_id=$this->ins_id";
			$rs=$objCon->ejecutarSQL($sql,'ERROR AL activarInstitucion');
		 	return $rs;
		}
		function asociarInstitucion($objCon, $arregloPrevisiones){
			for ($a=0; $a < count($arregloPrevisiones); $a++) { 
				$sql="INSERT into institucion_prevision(ins_id, pre_id) values($this->ins_id, $arregloPrevisiones[$a])";
				$rs=$objCon->ejecutarSQL($sql,'ERROR AL agregarAsociacion');				
	 		}
			return $rs;
		}
		function eliminarAsociacion($objCon, $preId){
			$sql="	DELETE 	FROM institucion_prevision
					WHERE institucion_prevision.pre_id = $preId AND institucion_prevision.ins_id = $this->ins_id";			
			$rs=$objCon->ejecutarSQL($sql,'ERROR AL eliminarAsociacion');
		 	return $rs;
		}
		function modificarConvenioPSS($objCon, $pss_id){
			 	$sql="UPDATE pss
					  SET pss.pss_insId ='$this->ins_id'
					  WHERE pss.pss_id=$pss_id";
				$rs=$objCon->ejecutarSQL($sql,'ERROR AL modificarConvenioPSS');
			 	return $rs;
		}
	}
?>