<?php 
class Producto{
	 public $pro_id;
	 public $pro_nom;
	 public $pro_estado;
	 
	function setProducto($pro_id,$pro_nom,$pro_estado){
 		$this->pro_id=trim($pro_id);
 		$this->pro_nom=trim($pro_nom);
 		$this->pro_estado=trim($pro_estado);
	}
	function actualizarProducto($conexion){

	}	
	function validarProducto($conexion){

	}
	function agregarProducto($objCon,$tip_prod_id,$uni_id){
	 	$sql ="INSERT INTO productos(pro_id,tip_prod_id,pro_nom,pro_estado,uni_id)
			   VALUES ('$this->pro_id','$tip_prod_id', '$this->pro_nom', '$this->pro_estado', '$uni_id')";
	 	$rs=$objCon->ejecutarSQL($sql,'ERROR AL insertarPrevision');
	 	return $rs;
	} 
	function editarProducto($objCon,$tip_prod_id,$uni_id){
		echo $sql="UPDATE productos
			  SET productos.tip_prod_id='$tip_prod_id', productos.pro_nom='$this->pro_nom', productos.uni_id='$uni_id' 
			  WHERE productos.pro_id=$this->pro_id";
		$rs=$objCon->ejecutarSQL($sql,'ERROR AL editarProducto');
	 	return $rs;
	} 
	function buscarProducto($objCon){
		$sql="SELECT
			productos.pro_id,
			productos.tip_prod_id,
			productos.pro_nom,
			productos.pro_estado,
			productos.uni_id
			FROM productos
			WHERE pro_id = '$this->pro_id'";
		$datos = array();
		$i=0;
		foreach ($objCon->consultaSQL($sql, 'ERROR buscarProducto') as $v) {
			$datos[$i]['pro_id']=$v['pro_id'];
			$datos[$i]['tip_prod_id']=$v['tip_prod_id'];
			$datos[$i]['pro_nom']=$v['pro_nom'];
			$datos[$i]['pro_estado']=$v['pro_estado'];
			$datos[$i]['uni_id']=$v['uni_id'];
			$i++;
		}
		return $datos;
	}
	function buscarProductoEditar($objCon, $pro_id_editar){
		$sql="SELECT
			productos.pro_id,
			productos.tip_prod_id,
			productos.pro_nom,
			productos.pro_estado,
			productos.uni_id
			FROM productos
			WHERE pro_id = '$this->pro_id' AND pro_id NOT IN ('$pro_id_editar')";
		$datos = array();
		$i=0;
		foreach ($objCon->consultaSQL($sql, 'ERROR buscarProducto') as $v) {
			$datos[$i]['pro_id']=$v['pro_id'];
			$datos[$i]['tip_prod_id']=$v['tip_prod_id'];
			$datos[$i]['pro_nom']=$v['pro_nom'];
			$datos[$i]['pro_estado']=$v['pro_estado'];
			$datos[$i]['uni_id']=$v['uni_id'];
			$i++;
		}
		return $datos;
	}
	function listarProductos($objCon){
	 	$datos = array();
		$i=0;
		$sql ="SELECT
			productos.pro_id,
			tipo_producto.tip_descripcion,
			productos.pro_nom
			FROM
			productos
			INNER JOIN tipo_producto ON productos.tip_prod_id = tipo_producto.tip_prod_id
			WHERE productos.pro_estado = 0";		
			
	 	foreach($objCon->consultaSQL($sql, 'ERROR listarProductos') as $v) {
			$datos[$i]['pro_id']=$v['pro_id'];
			$datos[$i]['tip_descripcion']=$v['tip_descripcion'];
			$datos[$i]['pro_nom']=$v['pro_nom'];
			$i++;
		}
	 	return $datos;
	}
	function listarProductosEliminados($objCon){
	 	$datos = array();
		$i=0;
		$sql ="SELECT
			productos.pro_id,
			tipo_producto.tip_descripcion,
			productos.pro_nom
			FROM
			productos
			INNER JOIN tipo_producto ON productos.tip_prod_id = tipo_producto.tip_prod_id
			WHERE productos.pro_estado = 1";		
			
	 	foreach($objCon->consultaSQL($sql, 'ERROR listarProductos') as $v) {
			$datos[$i]['pro_id']=$v['pro_id'];
			$datos[$i]['tip_descripcion']=$v['tip_descripcion'];
			$datos[$i]['pro_nom']=$v['pro_nom'];
			$i++;
		}
	 	return $datos;
	}
}?>