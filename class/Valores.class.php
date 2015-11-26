<?php 
class Valores{
	 public $val_id;
	 public $val_nombre;
	 public $val_monto;
	 
	function setValores($val_id,$val_nombre,$val_monto){
 		$this->val_id=trim($val_id);
 		$this->val_nombre=trim($val_nombre);
 		$this->val_monto=trim($val_monto);
	}
	function actualizarProducto($conexion){

	}	
	function validarProducto($conexion){

	}
	function agregarValores($objCon, $pro_id, $pre_id){
	 	$sql ="INSERT INTO valores(pro_id,val_id,pre_id,val_nombre,val_monto)
			   VALUES ('$pro_id','$this->val_id', '$pre_id', '$this->val_nombre', '$this->val_monto')";
	 	$rs=$objCon->ejecutarSQL($sql,'ERROR agregarValores');
	 	return $rs;
	} 
}?>