<?php 
class Producto{
	 public $tip_descripcion;
	 public $tip_prod_id;
	 


	 function setProducto($tip_descripcion){
	 		$this->tip_descripcion=trim($tip_descripcion);
	 }
	 function buscarMaximoId($objCon){//
	 	$sql="SELECT MAX(tip_prod_id)+1 as CONT
			  FROM tipo_producto";
		$i=0;
		$datos;
		foreach ($objCon->consultaSQL($sql, 'ERROR buscarMaximoId') as $v) {
			$datos=$v['CONT'];
	    }
	    if($datos==""){
	    	$datos=1;
	    }
		return $datos;		 	
	}
	 function insertarProducto($objCon){
	 		$max=$this->buscarMaximoId($objCon);
		 	$sql ="INSERT INTO tipo_producto(tip_prod_id, tip_descripcion)
				   VALUES ($max, '$this->tip_descripcion')";
		 	$rs=$objCon->ejecutarSQL($sql,'ERROR AL insertarProducto');
		 	return $rs;
	 }
	 function buscarProducto($objCon){//
	 	echo $sql="SELECT tip_descripcion
			  FROM tipo_producto
			  WHERE tip_descripcion='$this->tip_descripcion'";
		$i=0;
		foreach ($objCon->consultaSQL($sql, 'ERROR buscarProducto') as $v) {
			$datos=$v['tip_descripcion'];
			$i++;
	    }
		return $datos;		 	
	}


	 function actualizarProducto($conexion){

	 }	

	 function validarProducto($conexion){


	 }
	 function tipoProducto($objCon){
	 	$sql ="SELECT
			tipo_producto.tip_prod_id,
			tipo_producto.tip_descripcion
			FROM tipo_producto";
	 	$datos = array();
			$i=0;
			foreach ($objCon->consultaSQL($sql, 'ERROR tipoProducto') as $v) {
				$datos[$i][tip_prod_id]=$v['tip_prod_id'];
				$datos[$i][tip_descripcion]=$v['tip_descripcion'];
				$i++;
		    }
			return $datos;
	 }
}?>