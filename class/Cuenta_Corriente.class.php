<?php
class Cuenta_Corriente{
		private $cue_id;
		private $cue_unidadOrigen;
		private $cue_FechaApertura;

		function setCuenta_Corriente($cue_id, $cue_unidadOrigen, $cue_FechaApertura){
				 $this->$cue_id=$cue_id;
				 $this->$cue_unidadOrigen=$cue_unidadOrigen;
				 $this->$cue_FechaApertura=$cue_FechaApertura;
		}
		function buscarCtaCte($objCon){

		}
		function generarCtaCte($objCon, $pac_id){
			session_start();
			$usu_nombre=$_SESSION['usuario'][1]['nombre_usuario'];		
			$sql ="INSERT INTO cuenta_corriente 
	 					   (cue_id, usu_nombre, pac_id, cue_unidadOrigen, cue_fechaApertura)
			  	   VALUES ($this->cue_id, '$usu_nombre','$pac_id','$this->cue_unidadOrigen', '$this->cue_FechaApertura')";		
			$rs =$objCon->ejecutarSQL($sql, 'ERROR AL generarCtaCte');
		 	return $rs;
		}

		function buscarMaximoId($objCon){//

		 	$sql="SELECT MAX(cue_id)+1 as CONT
				  FROM cuenta_corriente";
			$i=0;
			$datos;
			foreach ($objCon->consultaSQL($sql, 'ERROR buscarMaximoId') as $v) {
				$datos=$v['CONT'];
		    }
		    if($datos==""){
		    	$datos=1;
		    }
			return $datos;		 	
		}
}
?>