<?php 
	require_once('../../class/Conectar.class.php'); $objCon = new Conectar();
	require_once('../../class/Tipo_Producto.class.php');$objTipoPro = new Tipo_Producto();
	require_once('../../class/Unidad_Medida.class.php');$objUnidadM = new Unidad_Medida();
	require_once('../../class/Util.class.php');$objUti = new Util();
	require_once('../../class/Producto.class.php');$objProd = new Producto();

	switch($_POST['op']) {
		case "editarTipo":
			$datos = explode(',', $_POST['datosE']);
			$objTipoPro->setTipoProducto($objUti->eliminaEspacios($_POST['tip_descripcion']),$_POST['tip_prod_id'],'');
			$idoriginal=$_POST['idoriginal'];
			$desoriginal= $_POST['desoriginal'];
			$objTipoPro->setTipoProducto($_POST['tip_descripcion'],$_POST['tip_prod_id'],'');
			$objCon->db_connect();
			$todos = $objTipoPro->listarIdsDes($objCon);
			$valido1=0;
			$valido2=0;
			if($idoriginal==$_POST['tip_prod_id'] && $desoriginal==$_POST['tip_descripcion']){	// Si los campos se mantienen iguales, se registran igual			
				try{
			 		$objCon->beginTransaction();
					$rs= $objTipoPro->editarTipoProducto($objCon);
					$objUnidadM->eliminarUnidadMedidaTProducto($objCon, $idoriginal);
					if($datos[0]!=''){
						for($i=0;$i<count($datos);$i++){
							$objUnidadM->setUnidadMedida($datos[$i],'','');
							$objUnidadM->insertarUnidadMedidaTProducto($objCon,$_POST['tip_prod_id'],'');
						}
					}
			 		$objCon->commit();
			 		echo $rs;						 		
				}catch (PDOException $e){
		 			$objCon->rollBack(); 
		 			$e->getMessage();
				}
			}else if($idoriginal==$_POST['tip_prod_id'] && $desoriginal!=$_POST['tip_descripcion']){ //Si el codigo se mantiene, y la descripcion no se repite en otro
				for($f=0;$f<count($todos);$f++){
					if((in_array($_POST['tip_descripcion'], $todos[$f]))==true){
						$valido1=1;
					}
				}
				if($valido1==0){
					try{
				 		$objCon->beginTransaction();
						$rs = $objTipoPro->editarTipoProducto($objCon);
						$objUnidadM->eliminarUnidadMedidaTProducto($objCon, $idoriginal);
						if($datos[0]!=''){
							for($i=0;$i<count($datos);$i++){
								$objUnidadM->setUnidadMedida($datos[$i],'','');
								$objUnidadM->insertarUnidadMedidaTProducto($objCon,$_POST['tip_prod_id'],'');
							}
						}
				 		$objCon->commit();
				 		echo $rs;						 		
					}catch (PDOException $e){
			 			$objCon->rollBack(); 
			 			$e->getMessage();
					}
				}else{
					echo "nombreExiste";	
				}				
			}else if($idoriginal!=$_POST['tip_prod_id'] && $desoriginal==$_POST['tip_descripcion']){ //Si el nombre se mantiene, y el codigo no se repite en otro
				for($f=0;$f<count($todos);$f++){
					if((in_array($_POST['tip_prod_id'], $todos[$f]))==true){
						$valido2=1;
					}
				}
				if($valido2==0){
					$rs1='';
					$rs2='';
					try{
				 		$objCon->beginTransaction();				 		
						$objTipoPro->editarTipoProductoDescripcion($objCon);						
						$objUnidadM->eliminarUnidadMedidaTProducto($objCon, $_POST['tip_prod_id']);
						if($datos[0]!=''){
							for($i=0;$i<count($datos);$i++){
								$objUnidadM->setUnidadMedida($datos[$i],'','');
								$objUnidadM->insertarUnidadMedidaTProducto($objCon,$_POST['tip_prod_id'],'');
							}
						}
				 		$objCon->commit();
				 		

					}catch (PDOException $e){
			 			$objCon->rollBack(); 
			 			$e->getMessage();			 			
					}
					
				}else{
					echo "codigoExiste";	
				}					
			}else if($idoriginal!=$_POST['tip_prod_id'] && $desoriginal!=$_POST['tip_descripcion']){ //Si nada se mantiene, y no se repiten en otros
				for($f=0;$f<count($todos);$f++){
					if((in_array($_POST['tip_prod_id'], $todos[$f]))==true){
						$valido2=1;
					}
				}
				for($f=0;$f<count($todos);$f++){
					if((in_array($_POST['tip_descripcion'], $todos[$f]))==true){
						$valido1=1;
					}
				}
				if($valido2==0 && $valido1==0){					
					try{
				 		$objCon->beginTransaction();
				 		$objTipoPro->editarTipoProductoAll($objCon,$idoriginal);
						$objUnidadM->eliminarUnidadMedidaTProducto($objCon, $_POST['tip_prod_id']);
						if($datos[0]!=''){
							for($i=0;$i<count($datos);$i++){
								$objUnidadM->setUnidadMedida($datos[$i],'','');
								$objUnidadM->insertarUnidadMedidaTProducto($objCon,$_POST['tip_prod_id'],'');
							}
						}
				 		$objCon->commit();					 		
					}catch (PDOException $e){
			 			$objCon->rollBack(); 
			 			$e->getMessage();
					}
				}else if($valido2!=0 && $valido1==0){
					echo "codigoExiste";	
				}else if($valido2==0 && $valido1!=0){
					echo "nombreExiste";	
				}else if($valido2!=0 && $valido1!=0){
					echo "nombreCodigoExiste";	
				}				
			}
		break;
		case "agregarTipo":
			$datosTipo = explode(',', $_POST['datos']);
			$objTipoPro->setTipoProducto($objUti->eliminaEspacios($_POST['tip_descripcion']),'','');
			$objTipoPro->setTipoProducto($_POST['tip_descripcion'], $_POST['tip_prod_id'],'');	
			$objCon->db_connect();
			$producto=$objTipoPro->buscarTipoProductoNew($objCon);
			if(is_null($producto)==true){

				try{
			 		$objCon->beginTransaction();
					$objTipoPro->insertarTipoProducto($objCon);
					if($datosTipo[0]!=''){
						for($i=0;$i<count($datosTipo);$i++){
							$objUnidadM->setUnidadMedida($datosTipo[$i],'','');
							$objUnidadM->insertarUnidadMedidaTProducto($objCon,$_POST['tip_prod_id']);
						}
					}
			 		$objCon->commit();						 		
				}catch (PDOException $e){
		 			$objCon->rollBack(); 
		 			$e->getMessage();
				}
			}else{
				$i=0;
				if($producto[$i]['tip_prod_id']==$_POST['tip_prod_id']){
					echo "codigoExiste";
				}else if($producto[$i]['tip_descripcion']==$_POST['tip_descripcion']){
					echo "nombreExiste";
				}
				
			}
		break;
		case "eliminarTipo":
			$objTipoPro->setTipoProducto('',$_POST['tip_prod_id'],'1');				
			$objCon->db_connect();
			try{
		 		$objCon->beginTransaction();
				$objTipoPro->cambiarEstadoTipoProducto($objCon);
		 		$objCon->commit();	
		 		echo "Tipo de producto eliminado";					 		
			}catch (PDOException $e){
	 			$objCon->rollBack(); 
	 			$e->getMessage();
			}
		break;
		case "restaurarTipo":
			$objTipoPro->setTipoProducto('',$_POST['tip_prod_id'],'0');				
			$objCon->db_connect();
			try{
		 		$objCon->beginTransaction();
				$objTipoPro->cambiarEstadoTipoProducto($objCon);
		 		$objCon->commit();	
		 		echo "Tipo de producto restaurado";					 		
			}catch (PDOException $e){
	 			$objCon->rollBack(); 
	 			$e->getMessage();
			}
		break;

	}

?>