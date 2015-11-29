<?php 
	if ( $_SESSION['usuario'] == null ) {
		$GoTo = "../../../login/index.php";
		header(sprintf("Location: %s", $GoTo));
	}
class Unidad_Medida{
	public $uni_id;
	public $uni_nombre;
	public $uni_estado;
	
	function setUnidadMedida($uni_id,$uni_nombre,$uni_estado){
 		$this->uni_id=trim($uni_id);
 		$this->uni_nombre=trim($uni_nombre);
 		$this->uni_estado=trim($uni_estado);
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
	function insertarUnidadMedida($objCon){
 		$maxUM=$this->buscarMaximoIdUM($objCon);
	 	$sql ="INSERT INTO unidad_de_medida(uni_id, uni_nombre, uni_estado)
			   VALUES ($maxUM, '$this->uni_nombre', '$this->uni_estado')";
	 	$rs=$objCon->ejecutarSQL($sql,'ERROR insertarUnidadMedida');
	 	return $rs;
	}
	function insertarUnidadMedidaTProducto($objCon,$tip_pro_id){
	 	$sql ="INSERT INTO tipopro_unidadmed(uni_id, tip_prod_id)
			   VALUES ('$this->uni_id', '$tip_pro_id')";
	 	$rs=$objCon->ejecutarSQL($sql,'ERROR insertarUnidadMedidaTProducto');
	 	return $rs;
	}
	function actualizarUnidadMedida($objCon){
		$sql="UPDATE unidad_de_medida
			  SET unidad_de_medida.uni_nombre='$this->uni_nombre'
			  WHERE unidad_de_medida.uni_id='$this->uni_id'";
		$rs=$objCon->ejecutarSQL($sql,'ERROR actualizarUnidadMedida');
	 	return $rs;
	}
	function cambiarEstadoUnidadMedida($objCon,$estado){
		$sql="UPDATE unidad_de_medida
			  SET unidad_de_medida.uni_estado='$estado'
			  WHERE unidad_de_medida.uni_id='$this->uni_id'";
		$rs=$objCon->ejecutarSQL($sql,'ERROR cambiarEstadoUnidadMedida');
	 	return $rs;
	}
	function listarUnidadTipoProducto($objCon,$tip_prod_id){
	 	$sql ="SELECT
			tipopro_unidadmed.uni_id,
			tipopro_unidadmed.tip_prod_id
			FROM tipopro_unidadmed
			WHERE tip_prod_id = '$tip_prod_id'";
	 	$datos = array();
			$i=0;
			foreach ($objCon->consultaSQL($sql, 'ERROR listarUnidadTipoProducto') as $v) {
				$datos[$i][uni_id]=$v['uni_id'];
				$datos[$i][tip_prod_id]=$v['tip_prod_id'];
				$i++;
		    }
		return $datos;
	}
	function buscarUnidadMedida($objCon,$uni_nombreAct){
		if($uni_nombreAct!=''){
			$cadena = " AND uni_nombre NOT IN ('$uni_nombreAct')";
		}
		$sql="SELECT
			unidad_de_medida.uni_id,
			unidad_de_medida.uni_nombre,
			unidad_de_medida.uni_estado
			FROM unidad_de_medida
			WHERE uni_nombre = '$this->uni_nombre' ".$cadena." ";
		$datos = array();
		$i=0;
		foreach ($objCon->consultaSQL($sql, 'ERROR buscarUnidadMedida') as $v) {
			$datos[$i]['uni_id']=$v['uni_id'];
			$datos[$i]['uni_nombre']=$v['uni_nombre'];
			$datos[$i]['uni_estado']=$v['uni_estado'];
			$i++;
	    }
		return $datos;
	}
	function listarUnidadMedida($objCon){
	 	$sql ="SELECT
			unidad_de_medida.uni_id,
			unidad_de_medida.uni_nombre
			FROM unidad_de_medida
			WHERE unidad_de_medida.uni_estado = '0'";
	 	$datos = array();
			$i=0;
			foreach ($objCon->consultaSQL($sql, 'ERROR listarUnidadMedida') as $v) {
				$datos[$i][uni_id]=$v['uni_id'];
				$datos[$i][uni_nombre]=$v['uni_nombre'];
				$i++;
		    }
		return $datos;
	}
	function listarUnidadMedidaEliminados($objCon){
	 	$sql ="SELECT
			unidad_de_medida.uni_id,
			unidad_de_medida.uni_nombre
			FROM unidad_de_medida
			WHERE unidad_de_medida.uni_estado = '1'";
	 	$datos = array();
			$i=0;
			foreach ($objCon->consultaSQL($sql, 'ERROR listarUnidadMedida') as $v) {
				$datos[$i][uni_id]=$v['uni_id'];
				$datos[$i][uni_nombre]=$v['uni_nombre'];
				$i++;
		    }
		return $datos;
	}
}?>