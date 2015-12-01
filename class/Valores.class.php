<?php 
class Valores{
	 public $val_id;
	 public $val_monto;
	 
	function setValores($val_id,$val_monto){
 		$this->val_id=trim($val_id);
 		$this->val_monto=trim($val_monto);
	}
	function actualizarProducto($conexion){

	}	
	function validarProducto($conexion){

	}
	function buscarMaximoId($objCon){//
	 	$sql="SELECT MAX(val_id)+1 as CONT
			  FROM valores";
		$i=0;
		$datos=1;
		foreach ($objCon->consultaSQL($sql, 'ERROR buscarMaximoId') as $v) {
			if(is_null($v['CONT'])==false){
	 			$datos = $v['CONT'];
	 		}
	    }
		return $datos;		 	
	}
	function agregarValores($objCon, $pro_id, $pre_id, $ins_id){
	 	$sql ="INSERT INTO valores(pro_id,val_id,pre_id,ins_id,val_monto)
			   VALUES ('$pro_id','$this->val_id', '$pre_id', '$ins_id', '$this->val_monto')";
	 	$rs=$objCon->ejecutarSQL($sql,'ERROR agregarValores');
	 	return $rs;
	}
	function editarValores($objCon, $pro_id, $pre_id, $ins_id){
		$sql="UPDATE valores
			  SET pro_id='$pro_id', val_id='$this->val_id', pre_id='$pre_id', val_monto='$this->val_monto', ins_id='$ins_id'
			  WHERE pro_id='$pro_id' AND pre_id='$pre_id' AND  ins_id = '$ins_id'";
		$rs=$objCon->ejecutarSQL($sql,'ERROR editarProducto');
	 	return $rs;
	} 
	function obtenerValorProducto($objCon, $pro_id, $pre_id, $ins_id){
		$sql="SELECT
			valores.val_monto
			FROM valores
			WHERE valores.pro_id = '$pro_id' AND valores.pre_id = '$pre_id' AND valores.ins_id = '$ins_id' ";
		$datos = array();
		$i=0;
		foreach ($objCon->ejecutarSQL($sql,'ERROR obtenerValorProducto') as $v) {
			$datos[$i]['val_monto']=$v['val_monto'];
			$i++;
		}
	 	return $datos;
	} 
	function actualizarValoresProductos($objCon, $pro_id, $pss_id){
	 	$sql="UPDATE
			detalleproducto
			SET detalleproducto.det_proUnitario = '$this->val_monto'
			WHERE detalleproducto.pro_id = '$pro_id' AND detalleproducto.pss_id = '$pss_id'";
		$rs=$objCon->ejecutarSQL($sql,'ERROR actualizarValoresProductos');
	 	return $rs;
	}
	function buscarValoresProducto($objCon, $pro_id, $pre_id, $ins_id){
		if($pre_id != ''){
			$cad_preId = " AND valores.pre_id ='$pre_id'";
		}
		if($ins_id != ''){
			$cad_insId = " AND valores.ins_id ='$ins_id'";
		}
		$sql="SELECT
			valores.pro_id,
			valores.val_id,
			valores.pre_id,
			valores.val_monto
			FROM valores
			WHERE valores.pro_id ='$pro_id'".$cad_preId.$cad_insId."   ";
		$datos = array();
		$i=0;
		foreach ($objCon->consultaSQL($sql, 'ERROR buscarValoresProducto') as $v) {
			$datos[$i]['pro_id']=$v['pro_id'];
			$datos[$i]['val_id']=$v['val_id'];
			$datos[$i]['pre_id']=$v['pre_id'];
			$datos[$i]['val_monto']=$v['val_monto'];
			$i++;
		}
		return $datos;	

	}
}?>