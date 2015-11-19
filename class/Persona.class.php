<?php 
class Persona{
	 private $per_id;
	 private $per_nombre;
	 private $per_apellidoPaterno;
	 private $per_apellidoMaterno;
	 private $per_fechaNacimiento;
	 private $per_telefono;
	 private $per_procedencia;	 

	 function buscarIdentificador($objCon){
	 	$sql ="SELECT per_id
	 		   FROM persona
	 		   WHERE per_id='$this->per_id'";
	 	foreach ($objCon->consultaSQL($sql,'ERROR buscarIdentificador') as $v) {
	 		$datos = $v['per_id'];
	 	}
	 	return $datos;
	 }

	 function insertarPersona($objCon){

	 	$sql ="INSERT INTO persona 
	 					   (per_id, per_nombre, per_apellidoPaterno, per_apellidoMaterno, per_fechaNacimiento, per_telefono, per_procedencia)
			   VALUES ('$this->per_id', '$this->per_nombre','$this->per_apellidoPaterno','$this->per_apellidoMaterno', '$this->per_fechaNacimiento', $this->per_telefono, $this->per_procedencia)";		
		$rs =$objCon->ejecutarSQL($sql, 'ERROR AL insertarPersona');
	 	return $rs;
	 }
	 function modificarPersona($objCon){

	 	$sql ="UPDATE persona 
	 		   SET per_nombre='$this->per_nombre', 
	 		       per_apellidoPaterno='$this->per_apellidoPaterno',
	 		       per_apellidoMaterno='$this->per_apellidoMaterno', 
	 		       per_fechaNacimiento='$this->per_fechaNacimiento',
	 		       per_telefono=$this->per_telefono
			   WHERE per_id = '$this->per_id'";
		$rs = $objCon->ejecutarSQL($sql, 'ERROR AL modificarPersona');
	 	return $rs;
	 }
	 function setPersona($per_id,$per_nombre,$per_apellidoPaterno,$per_apellidoMaterno,$per_fechaNacimiento,$per_telefono,$per_procedencia){
	 	$this->per_id=$per_id;
	 	$this->per_nombre=$per_nombre;
	    $this->per_apellidoPaterno=$per_apellidoPaterno;
	    $this->per_apellidoMaterno=$per_apellidoMaterno;
	    $this->per_fechaNacimiento=$per_fechaNacimiento;
	    $this->per_telefono=$per_telefono;
	    $this->per_procedencia=$per_procedencia;
	 }

	 function setPer_id($per_id){
	 	$this->per_id=''.$per_id;
	 }
	 function getPer_id(){
	 	return $this->per_id;
	 }
}?>