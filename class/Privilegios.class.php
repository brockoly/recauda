<?php 

class Privilegio{
	 private $pri_id;
	 private $pri_descripcion;


	 function setPrivilegio($id, $nombre){
	 		$this->pri_id=$id;
	 		$this->pri_descripcion=trim($nombre);
	 }
	 function getPri_id(){
	 		return($this->pri_id);
	 }
	 function agregarPrivilegios($objCon){ //Inicializa los privilegios
	 	$sql="INSERT INTO privilegios
			(privilegios.pri_id, privilegios.pri_descripcion)
			VALUES(1,'Administrador')";
		$rs2 =$objCon->ejecutarSQL($sql, 'ERROR agregarPrivilegios');
		$sql2="INSERT INTO privilegios
			(privilegios.pri_id, privilegios.pri_descripcion)
			VALUES(2,'Recaudador')";
		$rs2 =$objCon->ejecutarSQL($sql2, 'ERROR agregarPrivilegios');
	 }
	 function buscarPrivilegios($objCon){
	 	$sql="SELECT
			privilegios.pri_id
			FROM
			privilegios
			WHERE privilegios.pri_id = '$this->pri_id'";
		foreach ($objCon->consultaSQL($sql,'ERROR buscarPrivilegios') as $v) {
	 		$datos = $v['pri_id'];
	 	}
	 	return $datos;
	 }
	 function obtenerPrivilegios($objCon){
	 		$sql="SELECT pri_id, pri_descripcion
				  FROM privilegios";
			$datos = array();
			$i=0;
			foreach ($objCon->consultaSQL($sql, 'ERROR obtenerPrivilegios') as $v) {
				$datos[$i][pri_id]=$v['pri_id'];
				$datos[$i][pri_nombre]=$v['pri_descripcion'];
				$i++;
		    }
			return $datos;			
	 }
}
?>
