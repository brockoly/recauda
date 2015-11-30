<?php

class Cuenta_Corriente{
		private $cue_id;
		private $cue_unidadOrigen;
		private $cue_FechaApertura;

		function setCuenta_Corriente($cue_id, $cue_unidadOrigen, $cue_FechaApertura){
				 $this->cue_id=$cue_id;
				 $this->cue_unidadOrigen=$cue_unidadOrigen;
				 $this->cue_FechaApertura=$cue_FechaApertura;
		}
		function buscarCtaCte($objCon){

		}
		function generarCtaCte($objCon, $pac_id){
			session_start();
			$usu_nombre=$_SESSION['usuario'][1]['nombre_usuario'];		
	  		$sql ="INSERT INTO cuenta_corriente(cue_id, usu_nombre, pac_id, cue_unidadOrigen, cue_fechaApertura)
			  	   VALUES ($this->cue_id, '$usu_nombre', $pac_id, $this->cue_unidadOrigen, '$this->cue_FechaApertura')";	
			$rs =$objCon->ejecutarSQL($sql, 'ERROR AL generarCtaCte');
		 	return $rs;
		}

		function buscarMaximoId($objCon){//

		 	$sql="SELECT MAX(cue_id)+1 as CONT
				  FROM cuenta_corriente";
			$i=0;
			$datos=1;
			foreach ($objCon->consultaSQL($sql, 'ERROR buscarMaximoId') as $v) {
				if(is_null($v['CONT'])==false){
    	 			$datos = $v['CONT'];
    	 		}
		    }
			return $datos;		 	
		}

		function buscarCuentaSola($objCon, $pac_nombre, $cuenta_id, $pac_id, $per_id){
		 	$datos = array();
			$i=0;
			$sql =" SELECT
						cuenta_corriente.cue_id,
						persona.per_id,
						persona.per_nombre,
						persona.per_apellidoPaterno,
						persona.per_apellidoMaterno,
						nacionalidad.nac_nombre
					FROM cuenta_corriente
					LEFT JOIN paciente ON cuenta_corriente.pac_id = paciente.pac_id
					LEFT JOIN persona ON paciente.per_id = persona.per_id
					LEFT JOIN nacionalidad_persona ON nacionalidad_persona.per_id = persona.per_id
					LEFT JOIN nacionalidad ON nacionalidad_persona.nac_id = nacionalidad.nac_id
			";
			if(empty($cuenta_id)==false){
				$sql.=" WHERE cuenta_corriente.cue_id = '$cuenta_id'";
			}else{ 
				if(empty($pac_nombre)==false){ 
					$sql.=" WHERE CONCAT(persona.per_nombre,' ',persona.per_apellidoPaterno,' ', per_apellidoMaterno) LIKE REPLACE('%$pac_nombre%', ' ', '%')";
				}else{ 
					if(empty($pac_id)==false){
						$sql.=" WHERE paciente.pac_id = '$pac_id'";
					}else{
						$sql.=" WHERE persona.per_id = '$per_id'";
					}
				 	
				}
			}
				
		 	foreach($objCon->consultaSQL($sql, 'ERROR buscarCuentaSola') as $v) {
					$datos[$i]['cue_id']=$v['cue_id'];
					$datos[$i]['per_id']=$v['per_id'];
					$datos[$i]['per_nombre']=$v['per_nombre'];
					$datos[$i]['per_apellidoPaterno']=$v['per_apellidoPaterno'];
					$datos[$i]['per_apellidoMaterno']=$v['per_apellidoMaterno'];
					$datos[$i]['Nacionalidad']=$v['nac_nombre'];
					$i++;
			}
		 	return $datos;
		 }
}
?>