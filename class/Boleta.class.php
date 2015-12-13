<?php 

class Boleta{
	 private $bol_id;
	 private $bol_tipo;
	 private $bol_fecha;
	 private $bol_hora;

	function setBoleta($bol_id, $bol_tipo, $bol_fecha, $bol_hora){
	 		$this->bol_id=trim($bol_id);
	 		$this->bol_tipo=trim($bol_tipo);
	 		$this->bol_fecha=trim($bol_fecha);
	 		$this->bol_hora=trim($bol_hora);
	}
	function listarBoletaPagos($objCon, $pss_id, $bol_id, $pag_id){ //Cambiar en todos los lados que se llama
		$sql="SELECT ";
			
			$datos = array();
			$i=0;
			foreach ($objCon->consultaSQL($sql, 'ERROR listarBoletaPagos') as $v) {
				$datos[$i][cue_id]=$v['cue_id'];
				$i++;
		    }
		return $datos;
	}
	function anularBoleta($objCon, $bol_id){
		$sql="UPDATE boleta
			SET boleta.est_id='2'
			WHERE boleta.bol_id='$bol_id'";
		$rs=$objCon->ejecutarSQL($sql,'ERROR AL anularBoleta');
	 	return $rs;
	}
	function buscarAnularBoleta($objCon, $bol_id){ //Cambiar en todos los lados que se llama
		$sql="	SELECT
					boleta.bol_id,
					boleta.bol_fecha,
					boleta.bol_hora,
					estado_boleta.est_descripcion,
					paciente.per_id,
					CONCAT(persona.per_nombre,' ',persona.per_apellidoPaterno,' ',persona.per_apellidoMaterno) AS 'nombre'
				FROM boleta				
			 	INNER JOIN usuario ON usuario.usu_nombre = boleta.usu_nombre
			 	INNER JOIN persona ON persona.per_id = usuario.per_id
			 	INNER JOIN estado_boleta on estado_boleta.est_id = boleta.est_id
				INNER JOIN cuenta_corriente on cuenta_corriente.cue_id = boleta.cue_id
				INNER JOIN paciente on paciente.pac_id=cuenta_corriente.pac_id			 
				WHERE boleta.bol_id='$bol_id'";
			
			$datos = array();
			$i=0;
			foreach ($objCon->consultaSQL($sql, 'ERROR buscarBoleta') as $v) {
				$datos[$i][bol_id]=$v['bol_id'];
				$datos[$i][bol_fecha]=$v['bol_fecha'];
				$datos[$i][bol_hora]=$v['bol_hora'];
				$datos[$i][nombre]=$v['nombre'];
				$datos[$i][est_descripcion]=$v['est_descripcion'];
				$datos[$i][per_id]=$v['per_id'];
				$i++;
		    }
		return $datos;
	}

	function buscarBoletasArqueo($objCon, $usu_nombre, $tipo){ //Cambiar en todos los lados que se llama
		$sql="	SELECT
					boleta.bol_id,
					boleta.bol_fecha,
					boleta.bol_hora,					
					estado_boleta.est_descripcion,
					paciente.per_id,
					boleta.pss_id,
					CONCAT(persona.per_nombre,' ',persona.per_apellidoPaterno,' ',persona.per_apellidoMaterno) AS 'nombre'
				FROM boleta				
			 	INNER JOIN usuario ON usuario.usu_nombre = boleta.usu_nombre
			 	INNER JOIN persona ON persona.per_id = usuario.per_id
			 	INNER JOIN estado_boleta on estado_boleta.est_id = boleta.est_id
				INNER JOIN cuenta_corriente on cuenta_corriente.cue_id = boleta.cue_id
				INNER JOIN paciente on paciente.pac_id=cuenta_corriente.pac_id			 
				WHERE boleta.usu_nombre='$usu_nombre' AND boleta.arq_id IS NULL";
				if($tipo!=''){
					$sql.='AND boleta.bol_tipo <> 0';
				}
			
			$datos = array();
			$i=0;
			foreach ($objCon->consultaSQL($sql, 'ERROR buscarBoleta') as $v) {
				$datos[$i][bol_id]=$v['bol_id'];
				$datos[$i][bol_fecha]=$v['bol_fecha'];
				$datos[$i][bol_hora]=$v['bol_hora'];
				$datos[$i][nombre]=$v['nombre'];
				$datos[$i][est_descripcion]=$v['est_descripcion'];
				$datos[$i][per_id]=$v['per_id'];
				$datos[$i][pss_id]=$v['pss_id'];
				$i++;
		    }

		$sql="	SELECT
					boleta.bol_id,
					boleta.bol_fecha,
					boleta.bol_hora,					
					estado_boleta.est_descripcion,
					paciente.per_id,
					boleta.pss_id,
					CONCAT(persona.per_nombre,' ',persona.per_apellidoPaterno,' ',persona.per_apellidoMaterno) AS 'nombre'
				FROM boleta				
			 	INNER JOIN usuario ON usuario.usu_nombre = boleta.usu_nombre
			 	INNER JOIN persona ON persona.per_id = usuario.per_id
			 	INNER JOIN estado_boleta on estado_boleta.est_id = boleta.est_id
				INNER JOIN cuenta_corriente on cuenta_corriente.cue_id = boleta.cue_id
				INNER JOIN paciente on paciente.pac_id=cuenta_corriente.pac_id			 
				WHERE boleta.usu_nombre='$usu_nombre' AND boleta.arq_id IS NULL";
				
				if($tipo!=''){
					$sql.='AND boleta.bol_tipo <> 0';
				}    
		return $datos;
	}

}
?>
