<?php
	class Paciente{

	private $pac_id;
	private $pac_estado;

	 function setPaciente($pac_id){
	 		$this->pac_id=$pac_id;
	 }

	 function insertarPaciente($objCon, $pre_id, $per_id, $ins_id){
	 	$sql ="INSERT INTO paciente 
	 					   (pac_id, pre_id, per_id, ins_id)
			   VALUES ('$this->pac_id', '$pre_id','$per_id','$ins_id')";		
		$rs =$objCon->ejecutarSQL($sql, 'ERROR AL insertarPaciente');
	 	return $rs;
	 }

	 function actualizarPaciente($objCon, $pre_id, $per_id, $ins_id){
	 	$sql ="UPDATE paciente 
	 			SET pre_id = '$pre_id', 
		 			per_id = '$per_id', 
		 			ins_id = '$ins_id'
	 			WHERE per_id = '$per_id'";		
		$rs = $objCon->ejecutarSQL($sql, 'ERROR actualizarPaciente');
	 	return $rs;
	 }	

	 function validarPaciente($conexion){


	 }

	function buscarPaciente($objCon, $per_id){
		$sql="SELECT
			persona.per_id
			FROM
			persona
			WHERE persona.per_id = '$per_id'";
		$datos = array();
		foreach ($objCon->consultaSQL($sql,'ERROR buscarPaciente') as $v) {
			$datos['per_id'] = $v['per_id'];
		}
		//print_r($datos);
		if(is_null($datos['per_id'])==false){
			$datos = 1;
		}else{
			$datos = 0;
		}
		return $datos;
	}
	 function desplegarPacientes($objCon){
	 	$sql="SELECT
			persona.per_id AS Identificador,
			persona.per_nombre AS Nombre,
			persona.per_apellidoPaterno AS Apellido_Paterno,
			persona.per_apellidoMaterno AS Apellido_Materno,
			persona.per_fechaNacimiento AS fecha_nac,
			nacionalidad.nac_nombre AS Nacionalidad,
			paciente.pac_id
			FROM
			persona
			INNER JOIN paciente ON persona.per_id = paciente.per_id
			INNER JOIN nacionalidad_persona ON persona.per_id = nacionalidad_persona.per_id
			INNER JOIN nacionalidad ON nacionalidad_persona.nac_id = nacionalidad.nac_id";
		$datos = array();
		$i = 0;
		foreach ($objCon->consultaSQL($sql,'Error desplegarPacientes') as $v) {
			$datos[$i][Identificador]= $v['Identificador'];
			$datos[$i][Nombre]= $v['Nombre'];
			$datos[$i][Apellido_Paterno]= $v['Apellido_Paterno'];
			$datos[$i][Apellido_Materno]= $v['Apellido_Materno'];
			$datos[$i][fecha_nac]= $v['fecha_nac'];
			$datos[$i][Nacionalidad]= $v['Nacionalidad'];
			$datos[$i][pac_id]= $v['pac_id'];
			$i++;
		}
		return $datos;
	 }
	 function nuevoPac_id($objCon){
	 	$sql="SELECT
			COUNT(paciente.pac_id)+1 AS MAX
			FROM
			paciente";
		foreach ($objCon->consultaSQL($sql,'ERROR nuevoPac_id') as $v) {
	 		if($v['MAX']==""){
	 			$datos = 1;	
	 		}else{ $datos = $v['MAX'];}
	 		
	 	}
	 	return $datos;
	 }

	 function getInformacionPaciente($objCon, $per_id, $pac_nombre){
	 	$datos = array();
		$i=0;
	 	$sql ="SELECT
				persona.per_id AS Identificador,
				persona.per_nombre AS Nombre,
				persona.per_apellidoPaterno AS Apellido_Paterno,
				persona.per_apellidoMaterno AS Apellido_Materno,
				persona.per_fechaNacimiento AS fecha_nac,
				nacionalidad.nac_nombre AS Nacionalidad,
				paciente.pre_id AS prevision_id,
				paciente.ins_id AS inst_id,
				nacionalidad_persona.nac_id,
				persona.per_telefono,
				paciente.pac_id
				FROM
				persona
				INNER JOIN paciente ON persona.per_id = paciente.per_id
				INNER JOIN nacionalidad_persona ON persona.per_id = nacionalidad_persona.per_id
				INNER JOIN nacionalidad ON nacionalidad_persona.nac_id = nacionalidad.nac_id";
		if(empty($per_id)==false){
			$sql.=" WHERE persona.per_id = '$per_id'";
		}else{ 
			if(empty($pac_nombre)==false){ 
				$sql.=" WHERE CONCAT(persona.per_nombre,' ',persona.per_apellidoPaterno,' ', per_apellidoMaterno) LIKE REPLACE('%$pac_nombre%', ' ', '%')";
			}else{ 
			 	$sql.=" WHERE paciente.pac_id = '$this->pac_id'";
			}
		}
			
	 	foreach($objCon->consultaSQL($sql, 'ERROR getInformacionPaciente') as $v) {
				$datos[$i]['Identificador']=$v['Identificador'];
				$datos[$i]['Nombre']=$v['Nombre'];
				$datos[$i]['Apellido_Paterno']=$v['Apellido_Paterno'];
				$datos[$i]['Apellido_Materno']=$v['Apellido_Materno'];
				$datos[$i]['fecha_nac']=$v['fecha_nac'];
				$datos[$i]['Nacionalidad']=$v['Nacionalidad'];
				$datos[$i]['prevision_id']=$v['prevision_id'];
				$datos[$i]['inst_id']=$v['inst_id'];
				$datos[$i]['nac_id']=$v['nac_id'];
				$datos[$i]['per_telefono']=$v['per_telefono'];
				$datos[$i]['pac_id']=$v['pac_id'];
				$i++;
		}
	 	return $datos;
	 }
}
?>