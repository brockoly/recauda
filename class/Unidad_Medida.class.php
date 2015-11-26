<?php 
class Unidad_Medida{
	 public $uni_id;
	 public $uni_nombre;
	
	function setUnidadMedida($uni_id,$uni_nombre){
 		$this->uni_id=trim($uni_id);
 		$this->uni_nombre=trim($uni_nombre);
	}
	function buscarMaximoIdUM($objCon){//
	 	$sql="SELECT MAX(uni_id)+1 as CONT
			  FROM unidad_de_medida";
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
	function insertarUnidadMedida($objCon, $tip_pro, $uni_nombre){
 		$maxUM=$this->buscarMaximoIdUM($objCon);
	 	$sql ="INSERT INTO unidad_de_medida(uni_id, tip_prod_id, uni_nombre)
			   VALUES ($maxUM, '$tip_pro', '$uni_nombre')";
	 	$rs=$objCon->ejecutarSQL($sql,'ERROR insertarUnidadMedida');
	 	return $rs;
	}
	function eliminarUM($objCon){
		$sql="DELETE FROM unidad_de_medida
			WHERE unidad_de_medida.uni_id = $this->uni_id";			
		$rs=$objCon->ejecutarSQL($sql,'ERROR AL eliminarUM');
		return $rs;
	}
	function listarUMProducto($objCon, $tip_prod_id){
	 	$sql ="SELECT
			unidad_de_medida.uni_id,
			unidad_de_medida.tip_prod_id,
			unidad_de_medida.uni_nombre
			FROM unidad_de_medida
			WHERE tip_prod_id = '$tip_prod_id'";
	 	$datos = array();
			$i=0;
			foreach ($objCon->consultaSQL($sql, 'ERROR listarTipoProducto') as $v) {
				$datos[$i][uni_id]=$v['uni_id'];
				$datos[$i][tip_prod_id]=$v['tip_prod_id'];
				$datos[$i][uni_nombre]=$v['uni_nombre'];
				$i++;
		    }
		return $datos;
	}
	function buscarUnidadMedidaProducto($objCon, $tip_prod_id){
			$sql="SELECT
				tipo_producto.tip_descripcion,
				unidad_de_medida.uni_id,
				unidad_de_medida.uni_nombre
				FROM
				unidad_de_medida
				INNER JOIN tipo_producto ON tipo_producto.tip_prod_id = unidad_de_medida.tip_prod_id
				WHERE tip_pro_estado = '0' AND tipo_producto.tip_prod_id = '$tip_prod_id'";
			$datos = array();
			$i=0;
			foreach ($objCon->consultaSQL($sql, 'ERROR buscarUnidadMedidaProducto') as $v) {
				$datos[$i]['id']=$v['uni_id'];
				$datos[$i]['valor']=$v['uni_nombre'];
				$i++;
		    }
			return $datos;
		}
}?>