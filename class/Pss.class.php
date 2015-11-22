<?php
class Pss{
	   private $pss_id;
	   private $pss_fecha;
	   private $pss_hora;
	   private $pss_saldo;
	   private $pss_estado; //ESTADOS: Abierto, cerrado, valorizado, abonado y pagado
	   private $pssPrevId;
	   private $pssInsId;

		function setPss($pss_id, $pss_fecha, $pss_hora, $pss_saldo, $pss_estado, $pss_PrevId, $pss_InsId){
		   $this->pss_id=$pss_id;
		   $this->pss_fecha=$pss_fecha;
		   $this->pss_hora=$pss_hora;
		   $this->pss_saldo=$pss_saldo;
		   $this->pss_estado=$pss_estado;
		   $this->pssPrevId=$pss_PrevId;
		   $this->pssInsId=$pss_InsId;
		}
		function generarPss($objCon, $cue_id){
			session_start();
			$usu_nombre=$_SESSION['usuario'][1]['nombre_usuario'];		
	  		$sql ="INSERT INTO pss(cue_id, pss_id, usu_nombre, pss_fecha, pss_hora, pss_saldo, pss_estado, pssPrevId,
	  							   pssInsId)
	  			   VALUES ($cue_id, $this->pss_id, '$usu_nombre', '$this->pss_fecha','$this->pss_hora',
	  			   		   $this->pss_saldo, '$this->pss_estado', $this->pssPrevId,  $this->pssInsId)";	
			$rs =$objCon->ejecutarSQL($sql, 'ERROR AL generarCtaCte');
		 	return $rs;
		}

		function buscarMaximoId($objCon,$cue_id){//

		 	$sql="SELECT MAX(pss_id)+1 as CONT
				  FROM pss
				  WHERE cue_id=$cue_id";
			$i=0;
			$datos=1;
			foreach ($objCon->consultaSQL($sql, 'ERROR buscarMaximoId') as $v) {
				if(is_null($v['CONT'])==false){
    	 			$datos = $v['CONT'];
    	 		}
		    }
			return $datos;		 	
		}
}
?>