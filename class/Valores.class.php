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
	function editarValores($objCon, $pro_id, $pre_id){
		$sql="UPDATE valores
			  SET pro_id='$pro_id', val_id='$this->val_id', pre_id='$pre_id' , val_nombre='$this->val_nombre', val_monto='$this->val_monto'
			  WHERE pro_id='$pro_id' AND val_id='$this->val_id' ";
		$rs=$objCon->ejecutarSQL($sql,'ERROR editarProducto');
	 	return $rs;
	} 
	function buscarValoresProducto($objCon, $pro_id){
		$sql="SELECT
			valores.pro_id,
			valores.val_id,
			valores.pre_id,
			valores.val_nombre,
			valores.val_monto
			FROM valores
			WHERE valores.pro_id ='$pro_id'";
		$datos = array();
		$i=0;
		foreach ($objCon->consultaSQL($sql, 'ERROR buscarValoresProducto') as $v) {
			$datos[$i]['pro_id']=$v['pro_id'];
			$datos[$i]['val_id']=$v['val_id'];
			$datos[$i]['pre_id']=$v['pre_id'];
			$datos[$i]['val_nombre']=$v['val_nombre'];
			$datos[$i]['val_monto']=$v['val_monto'];
			$i++;
		}
		return $datos;	

	}
}?>