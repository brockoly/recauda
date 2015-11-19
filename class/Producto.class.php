<?php 
class Producto{
	 public $nombre;
	 public $id;
	 


	 function setProducto($Producto, $id){
	 		$this->Producto=$Producto;
	 		$this->id=$id;
	 }

	 function insertarProducto($conexion, $per_id, $pri_id){
	 		
	 }

	 function actualizarProducto($conexion){

	 }	

	 function validarProducto($conexion){


	 }

	 function buscarProducto($conexion){

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