<?php 

class Persona{
	 private $per_id;
	 private $per_nombre;
	 private $per_apellidoPaterno;
	 private $per_apellidoMaterno;
	 private $per_fechaNacimiento;
	 private $per_telefono;
	 private $per_procedencia;
	 private $per_sexo;
	 private $per_direccion;

	 function buscarIdentificador($objCon){
	 	$sql ="SELECT per_id
	 		   FROM persona
	 		   WHERE per_id='$this->per_id'";
	 	$datos = 0;
	 	foreach ($objCon->consultaSQL($sql,'ERROR buscarIdentificador') as $v) {
	 		if(is_null($datos['per_id'])==false){
				$datos = 1;
			}else{
				$datos = 0;
			}
		}
	 	return $datos;
	 }

	 function insertarPersona($objCon){

	 	$sql ="INSERT INTO persona 
	 					   (per_id, per_nombre, per_apellidoPaterno, per_apellidoMaterno, per_fechaNacimiento, per_telefono, per_procedencia, per_sexo, per_direccion)
			   VALUES ('$this->per_id', '$this->per_nombre','$this->per_apellidoPaterno','$this->per_apellidoMaterno', '$this->per_fechaNacimiento', $this->per_telefono, $this->per_procedencia, '$this->per_sexo', '$this->per_direccion')";		
		$rs =$objCon->ejecutarSQL($sql, 'ERROR AL insertarPersona');
	 	return $rs;
	 }
	 function modificarPersona($objCon){

	 	$sql ="UPDATE persona 
	 		   SET per_nombre='$this->per_nombre', 
	 		       per_apellidoPaterno='$this->per_apellidoPaterno',
	 		       per_apellidoMaterno='$this->per_apellidoMaterno', 
	 		       per_fechaNacimiento='$this->per_fechaNacimiento',
	 		       per_telefono=$this->per_telefono,
	 		       per_sexo='$this->per_sexo',
	 		       per_direccion='$this->per_direccion'
			   WHERE per_id = '$this->per_id'";
		$rs = $objCon->ejecutarSQL($sql, 'ERROR AL modificarPersona');
	 	return $rs;
	 }
	 function setPersona($per_id,$per_nombre,$per_apellidoPaterno,$per_apellidoMaterno,$per_fechaNacimiento,$per_telefono,$per_procedencia,$per_sexo, $per_direccion){
	 	$this->per_id=trim($per_id);
	 	$this->per_nombre=utf8_decode(trim($per_nombre));
	    $this->per_apellidoPaterno=utf8_decode(trim($per_apellidoPaterno));
	    $this->per_apellidoMaterno=utf8_decode(trim($per_apellidoMaterno));
	    $this->per_fechaNacimiento=$per_fechaNacimiento;
	    $this->per_telefono=trim($per_telefono);
	    $this->per_procedencia=$per_procedencia;
	    $this->per_sexo=trim($per_sexo);
	    $this->per_direccion=utf8_decode(trim($per_direccion));
	 }

	 function setPer_id($per_id){
	 	$this->per_id=''.utf8_decode(trim($per_id));
	 }
	 function getPer_id(){
	 	return $this->per_id;
	 }

	 function actualizarID($objCon,$per_idAntiguo){
		$sql="UPDATE persona
			  SET persona.per_id='$this->per_id'
			  WHERE persona.per_id='$per_idAntiguo'";
		$rs=$objCon->ejecutarSQL($sql,'ERROR AL actualizarID');
		return $rs;
	}
}?>