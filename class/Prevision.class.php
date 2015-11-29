<?php
	if ( $_SESSION['usuario'] == null ) {
		$GoTo = "../../../login/index.php";
		header(sprintf("Location: %s", $GoTo));
	}
	class Prevision{
		private $pre_id;
		private $pre_nombre;

		function setPrevision($pre_id,$pre_nombre){
			$this->pre_id=$pre_id;
			$this->pre_nombre=$pre_nombre;
		}
		function actualizarPrevision($conexion){

		}
		function buscarMaximoId($objCon){//

		 	$sql="SELECT MAX(pre_id)+1 as CONT
				  FROM prevision";
			$i=0;
			$datos;
			foreach ($objCon->consultaSQL($sql, 'ERROR obtenerPrevisiones') as $v) {
				$datos=$v['CONT'];
		    }
		    if($datos==""){
		    	$datos=1;
		    }
			return $datos;		 	
		}
		function buscarPrevisionAsociacion($objCon, $ins_id){
			$sql="	SELECT 	DISTINCT 
							prevision.pre_id,
							prevision.pre_nombre
					FROM	prevision 
					LEFT JOIN institucion_prevision ON prevision.pre_id = institucion_prevision.pre_id 
					WHERE 	prevision.pre_id NOT IN (SELECT institucion_prevision.pre_id from institucion_prevision WHERE institucion_prevision.ins_id = $ins_id)";

			$datos = array();
			$i=0;
			foreach ($objCon->consultaSQL($sql, 'ERROR buscarPrevisiones') as $v) {
				$datos[$i]['pre_id']=$v['pre_id'];
				$datos[$i]['pre_nombre']=$v['pre_nombre'];
				$i++;
		    }
			return $datos;
		}
		function insertarPrevision($objCon){
		 	$max=$this->buscarMaximoId($objCon);
		 	$sql ="INSERT INTO prevision(pre_id, pre_nombre)
				   VALUES ($max, '$this->pre_nombre')";
		 	$rs=$objCon->ejecutarSQL($sql,'ERROR AL insertarPrevision');
		 	return $rs;
		}
		function modificarPrevision($objCon){
		 	$sql="UPDATE prevision
				  SET prevision.pre_nombre='$this->pre_nombre'
				  WHERE prevision.pre_id=$this->pre_id";
			$rs=$objCon->ejecutarSQL($sql,'ERROR AL modificarPrevision');
		 	return $rs;
		}	
		function obtenerPrevisiones($objCon){
			$sql="SELECT pre_id, pre_nombre
				  FROM prevision";
			$datos = array();
			$i=0;
			foreach ($objCon->consultaSQL($sql, 'ERROR obtenerPrevisiones') as $v) {
				$datos[$i]['pre_id']=$v['pre_id'];
				$datos[$i]['pre_nombre']=$v['pre_nombre'];
				$i++;
			}
			return $datos;
		}
		function obtenerPrevisionesActivas($objCon){
			$sql="SELECT prevision.pre_id, prevision.pre_nombre
				  FROM prevision
				  WHERE prevision.pre_estado=0";
			$datos = array();
			$i=0;
			foreach ($objCon->consultaSQL($sql, 'ERROR obtenerPrevisiones') as $v) {
				$datos[$i]['pre_id']=$v['pre_id'];
				$datos[$i]['pre_nombre']=$v['pre_nombre'];
				$i++;
			}
			return $datos;
		}
		function obtenerPrevisionesInactivas($objCon){
			$sql="SELECT prevision.pre_id, prevision.pre_nombre
				  FROM prevision
				  WHERE prevision.pre_estado=1";
			$datos = array();
			$i=0;
			foreach ($objCon->consultaSQL($sql, 'ERROR obtenerPrevisiones') as $v) {
				$datos[$i]['pre_id']=$v['pre_id'];
				$datos[$i]['pre_nombre']=$v['pre_nombre'];
				$i++;
			}
			return $datos;
		}
		function obtenerInstitucionesPrevision($objCon){

			$sql="	SELECT 	institucion_prevision.ins_id,
						 	institucion.ins_nombre
					FROM	institucion_prevision
					INNER JOIN institucion ON institucion_prevision.ins_id = institucion.ins_id
					WHERE institucion_prevision.pre_id = $this->pre_id";
			$datos = array();
			$i=0;
			foreach ($objCon->consultaSQL($sql, 'ERROR obtenerPrevisiones') as $v) {
				$datos[$i]['ins_id']=$v['ins_id'];
				$datos[$i]['ins_nombre']=$v['ins_nombre'];
				$i++;
			}
			return $datos;
		}
		function buscaPrevision($objCon){//

		 	$sql="SELECT pre_nombre
				  FROM prevision
				  WHERE pre_nombre='$this->pre_nombre'";
			$i=0;
			foreach ($objCon->consultaSQL($sql, 'ERROR obtenerPrevisiones') as $v) {
				$datos=$v['pre_nombre'];
		    }
			return $datos;		 	
		}
		
		function eliminarAsociacion($objCon, $insId){
			$sql="	DELETE 	FROM institucion_prevision
					WHERE institucion_prevision.pre_id = $this->pre_id AND institucion_prevision.ins_id = $insId";			
			$rs=$objCon->ejecutarSQL($sql,'ERROR AL eliminarAsociacion');
		 	return $rs;
		}
		function agregarAsociacion($objCon,$arregloInstituciones){

			for ($a=0; $a < count($arregloInstituciones); $a++) { 
				$sql="INSERT into institucion_prevision(ins_id, pre_id) values($arregloInstituciones[$a], $this->pre_id)";
				$rs=$objCon->ejecutarSQL($sql,'ERROR AL agregarAsociacion');				
	 		}
			return $rs;
		}
		function desactivarPrevision($objCon){
		 	$sql="UPDATE prevision
				  SET prevision.pre_estado=1
				  WHERE prevision.pre_id=$this->pre_id";
			$rs=$objCon->ejecutarSQL($sql,'ERROR AL desactivarPrevision');
		 	return $rs;
		}	
		function activarPrevision($objCon){
		 	$sql="UPDATE prevision
				  SET prevision.pre_estado=0
				  WHERE prevision.pre_id=$this->pre_id";
			$rs=$objCon->ejecutarSQL($sql,'ERROR AL activarPrevision');
		 	return $rs;
		}
	}
?>