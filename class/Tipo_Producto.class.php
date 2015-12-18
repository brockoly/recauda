<?php 	
class Tipo_Producto{
	 public $tip_descripcion;
	 public $tip_prod_id;
	 public $tip_Pro_estado;
	 
	 function setTipoProducto($tip_descripcion,$tip_prod_id,$tip_Pro_estado){
 		$this->tip_descripcion=utf8_decode(trim($tip_descripcion));
 		$this->tip_prod_id=trim($tip_prod_id);
 		$this->tip_Pro_estado=trim($tip_Pro_estado);
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
	function insertarTipoProducto($objCon){
		
	 	$sql ="INSERT INTO tipo_producto(tip_prod_id, tip_descripcion)
			   VALUES ($this->tip_prod_id, '$this->tip_descripcion')";
	 	$rs=$objCon->ejecutarSQL($sql,'ERROR AL insertarTipoProducto');
	 	return $rs;
	}
	function editarTipoProducto($objCon){
	 	$sql="UPDATE tipo_producto
			  SET tipo_producto.tip_descripcion='$this->tip_descripcion'
			  WHERE tipo_producto.tip_prod_id=$this->tip_prod_id";
		$rs=$objCon->ejecutarSQL($sql,'ERROR AL editarTipoProducto');
	 	return $rs;
	}
	function editarTipoProductoDescripcion($objCon){
	 	$sql="UPDATE tipo_producto
			  SET tipo_producto.tip_prod_id=$this->tip_prod_id
			  WHERE tipo_producto.tip_descripcion='$this->tip_descripcion'";
		$rs=$objCon->ejecutarSQL($sql,'ERROR AL editarTipoProducto');
	 	return $rs;
	}
	function editarTipoProductoAll($objCon, $original){
	 	$sql="UPDATE tipo_producto
			  SET tipo_producto.tip_prod_id=$this->tip_prod_id, tipo_producto.tip_descripcion='$this->tip_descripcion'
			  WHERE tipo_producto.tip_prod_id=$original";
		$rs=$objCon->ejecutarSQL($sql,'ERROR AL editarTipoProducto');
	 	return $rs;
	}
	function cambiarEstadoTipoProducto($objCon){
		$sql="UPDATE tipo_producto
			  SET tipo_producto.tip_pro_estado='$this->tip_Pro_estado'
			  WHERE tipo_producto.tip_prod_id=$this->tip_prod_id";			
		$rs=$objCon->ejecutarSQL($sql,'ERROR AL eliminarTipoProducto');
	 	return $rs;
	}
	function restaurarTipoProducto($objCon){
		$sql="UPDATE tipo_producto
			  SET tipo_producto.tip_pro_estado='0'
			  WHERE tipo_producto.tip_prod_id=$this->tip_prod_id";			
		$rs=$objCon->ejecutarSQL($sql,'ERROR AL restaurarTipoProducto');
	 	return $rs;
	}
	function buscarTipoProducto($objCon){//
	 	if(is_null($this->tip_prod_id)==false){
	 		$cadena_id = " AND tip_prod_id NOT IN ('$this->tip_prod_id') ";
	 	}
	 	$sql="SELECT tip_descripcion
			  FROM tipo_producto
			  WHERE tip_descripcion='$this->tip_descripcion'".$cadena_id."   ";
		$i=0;
		foreach ($objCon->consultaSQL($sql, 'ERROR buscarTipoProducto') as $v) {
			$datos=$v['tip_descripcion'];
			$i++;
	    }
		return $datos;		 	
	}
	function buscarTipoProductoNew($objCon){//
	 	
	 	$sql="SELECT tip_descripcion,
	 				 tip_prod_id
			  FROM tipo_producto
			  WHERE tip_descripcion='$this->tip_descripcion' OR tip_prod_id=$this->tip_prod_id ";
		$i=0;
		foreach ($objCon->consultaSQL($sql, 'ERROR buscarTipoProducto') as $v) {
			$datos[$i]['tip_prod_id']=$v['tip_prod_id'];
			$datos[$i]['tip_descripcion']=$v['tip_descripcion'];
			$i++;
	    }
		return $datos;		 	
	}
	function buscarTipoProductoEditDescripcion($objCon){//
	 	
	 	$sql="SELECT tip_descripcion,
	 				 tip_prod_id
			  FROM tipo_producto
			  WHERE tip_descripcion='$this->tip_descripcion'";
		$i=0;
		foreach ($objCon->consultaSQL($sql, 'ERROR buscarTipoProducto') as $v) {
			$datos[$i]['tip_prod_id']=$v['tip_prod_id'];
			$datos[$i]['tip_descripcion']=$v['tip_descripcion'];
			$i++;
	    }
		return $datos;		 	
	}
	function buscarTipoProductoEditId($objCon){//
	 	
	 	$sql="SELECT tip_descripcion,
	 				 tip_prod_id
			  FROM tipo_producto
			  WHERE tip_prod_id='$this->tip_prod_id'";
		$i=0;
		foreach ($objCon->consultaSQL($sql, 'ERROR buscarTipoProducto') as $v) {
			$datos[$i]['tip_prod_id']=$v['tip_prod_id'];
			$datos[$i]['tip_descripcion']=$v['tip_descripcion'];
			$i++;
	    }
		return $datos;		 	
	}
	function listarIdsDes($objCon){//
	 	
	 	$sql="SELECT *
			  FROM tipo_producto";
		$i=0;
		foreach ($objCon->consultaSQL($sql, 'ERROR buscarTipoProducto') as $v) {
			$datos[$i]['tip_prod_id']=$v['tip_prod_id'];
			$datos[$i]['tip_descripcion']=$v['tip_descripcion'];
			$i++;
	    }
		return $datos;		 	
	}
	function listarTipoProducto($objCon, $orden){
	 	$sql ="SELECT
			tipo_producto.tip_prod_id,
			tipo_producto.tip_descripcion
			FROM tipo_producto
			WHERE tipo_producto.tip_pro_estado='0'";

			switch ($orden) {
				case 'nombre':
					$sql.='ORDER BY tipo_producto.tip_descripcion ASC';
					break;
				
				case 'codigo':
					$sql.='ORDER BY tipo_producto.tip_prod_id ASC';
					break;
			}
	 	$datos = array();
			$i=0;
			foreach ($objCon->consultaSQL($sql, 'ERROR listarTipoProducto') as $v) {
				$datos[$i][tip_prod_id]=$v['tip_prod_id'];
				$datos[$i][tip_descripcion]=$v['tip_descripcion'];
				$i++;
		    }
			return $datos;
	}
	function tipoProductoEliminado($objCon){
	 	$sql ="SELECT
			tipo_producto.tip_prod_id,
			tipo_producto.tip_descripcion
			FROM tipo_producto
			WHERE tipo_producto.tip_pro_estado='1'";
	 	$datos = array();
			$i=0;
			foreach ($objCon->consultaSQL($sql, 'ERROR tipoProductoEliminado') as $v) {
				$datos[$i][tip_prod_id]=$v['tip_prod_id'];
				$datos[$i][tip_descripcion]=$v['tip_descripcion'];
				$i++;
		    }
			return $datos;
	}
}?>