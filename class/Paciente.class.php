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
		$sql=" SELECT
					REPLACE(paciente.per_id, ' ', '') as per_id
				FROM
				paciente
				WHERE paciente.per_id = '$per_id'";
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
			paciente.pac_id,
			persona.per_sexo,
			persona.per_direccion
			FROM
			persona
			INNER JOIN paciente ON persona.per_id = paciente.per_id
			INNER JOIN nacionalidad ON persona.per_procedencia = nacionalidad.nac_id
			WHERE paciente.pac_estado = '0'";
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
			if($v['per_sexo']=='m'){
				$datos[$i][sexo]= 'Masculino';
			}else{
				$datos[$i][sexo]= 'Femenino';	
			}
			$datos[$i][direccion]= $v['per_direccion'];
			$i++;
		}
		return $datos;
	}
	function desplegarPacientesEliminados($objCon){
		$sql="SELECT
			persona.per_id AS Identificador,
			persona.per_nombre AS Nombre,
			persona.per_apellidoPaterno AS Apellido_Paterno,
			persona.per_apellidoMaterno AS Apellido_Materno,
			persona.per_fechaNacimiento AS fecha_nac,
			nacionalidad.nac_nombre AS Nacionalidad,
			paciente.pac_id,
			persona.per_sexo,
			persona.per_direccion
			FROM
			persona
			INNER JOIN paciente ON persona.per_id = paciente.per_id
			INNER JOIN nacionalidad ON persona.per_procedencia = nacionalidad.nac_id
			WHERE paciente.pac_estado = '1'";
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
			if($v['per_sexo']=='m'){
				$datos[$i][sexo]= 'Masculino';
			}else{
				$datos[$i][sexo]= 'Femenino';	
			}
			$datos[$i][direccion]= $v['per_direccion'];
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

	 function getInformacionPaciente($objCon, $per_id, $pac_nombre, $cue_id){
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
			paciente.pac_id,
			persona.per_sexo,
			persona.per_direccion,
			prevision.pre_nombre,
			institucion.ins_nombre
			FROM
			persona
			INNER JOIN paciente ON persona.per_id = paciente.per_id
			INNER JOIN nacionalidad_persona ON persona.per_id = nacionalidad_persona.per_id
			INNER JOIN nacionalidad ON nacionalidad_persona.nac_id = nacionalidad.nac_id
			INNER JOIN prevision ON paciente.pre_id = prevision.pre_id
			INNER JOIN institucion ON paciente.ins_id = institucion.ins_id";
		if(empty($per_id)==false){
			$sql.=" WHERE persona.per_id = '$per_id'";
		}else{ 
			if(empty($pac_nombre)==false){ 
				$sql.=" WHERE CONCAT(persona.per_nombre,' ',persona.per_apellidoPaterno,' ', per_apellidoMaterno) LIKE REPLACE('%".trim($pac_nombre)."%', ' ', '%')";
			}else{
				if(empty($cue_id)==false){
					$sql.=" WHERE paciente.pac_id IN (SELECT cuenta_corriente.pac_id FROM cuenta_corriente WHERE cue_id = $cue_id)";
				}else{
			 		$sql.=" WHERE paciente.pac_id = '$this->pac_id'";
			 	}
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
				$datos[$i]['per_sexo']=$v['per_sexo'];
				$datos[$i]['per_direccion']=$v['per_direccion'];
				$datos[$i]['pre_nombre']=$v['pre_nombre'];
				$datos[$i]['ins_nombre']=$v['ins_nombre'];
				$i++;
		}
	 	return $datos;
	 }
	function eliminarPaciente($objCon,$pac_id){
		$sql="UPDATE paciente
		  SET paciente.pac_estado=1
		  WHERE paciente.pac_id='$pac_id'";
		$rs=$objCon->ejecutarSQL($sql,'ERROR AL eliminarPaciente');
		return $rs;
	}
	function restaurarPaciente($objCon,$pac_id){
		$sql="UPDATE paciente
		  SET paciente.pac_estado=0
		  WHERE paciente.pac_id='$pac_id'";
		$rs=$objCon->ejecutarSQL($sql,'ERROR AL restaurarPaciente');
		return $rs;
	}

	function buscarPersona($objCon, $per_id){
			$datos = array();
			$i=0;
			$sql =" SELECT
						paciente.pac_id,
						persona.per_nombre,
						persona.per_telefono,
						persona.per_apellidoPaterno,
						persona.per_apellidoMaterno,
						persona.per_fechaNacimiento,
						persona.per_sexo,
						persona.per_direccion						
					FROM paciente
					LEFT JOIN persona ON persona.per_id = paciente.per_id";
			if(empty($per_id)==false){
				$sql.=" WHERE paciente.per_id = '$per_id'";
			}
		 	foreach($objCon->consultaSQL($sql, 'ERROR buscarUsuario') as $v) {
					$datos['pac_id']=$v['pac_id'];
					$datos['per_nombre']=$v['per_nombre'];
					$datos['per_apellidoPaterno']=$v['per_apellidoPaterno'];
					$datos['per_apellidoMaterno']=$v['per_apellidoMaterno'];
					//formatear fecha
					require_once('../../class/Util.class.php'); 
					$objUti=new Util(); 
					$datos['per_fechaNacimiento']=$objUti->cambiarfecha_mysql_a_normal($v['per_fechaNacimiento']);
					$datos['per_telefono']=$v['per_telefono'];
					$datos['per_sexo']=$v['per_sexo'];
					$datos['per_direccion']=$v['per_direccion'];
			}
		 	return json_encode($datos);
	}
}
?>