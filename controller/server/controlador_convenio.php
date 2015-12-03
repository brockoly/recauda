<?php 
		require_once('../../class/Conectar.class.php'); $objCon = new Conectar();
		require_once('../../class/Institucion.class.php');$objIns = new Institucion();
		require_once('../../class/Util.class.php');$objUtil = new Util();



		switch($_POST['op']) {

				case "editar":
						$objIns->setInstitucion($_POST['txtIdCon'], $objUtil->eliminaEspacios($_POST['txtConvenio']));					
						$objCon->db_connect();
						$institucion=$objIns->buscaInstitucion($objCon, 2);
						
						if($institucion=="Existe con id"){
							 $bandera=0;									
						}else{  
							if($institucion=="Existe sin id"){
								$bandera=1;
							}else{
								$bandera=0;
							}
						}						
						if($bandera==0){
							try{
							 		$objCon->beginTransaction();
							 		$objIns->modificarConvenio($objCon);
							 		$objCon->commit();						 		
							}catch (PDOException $e){
						 			$objCon->rollBack(); 
						 			$e->getMessage();
							}
						}else{
							echo "Este nombre ya existe en los registros";
						}
				break;
				//Nuevo Agregar (con asociacion a previsión)
				case "agregarConvenio":
						$objCon->db_connect();
						$id=$objIns->buscarMaximoId($objCon);											
						$objIns->setInstitucion($id,$objUtil->eliminaEspacios($_POST['ins_nombre']));
						$arreglox= explode(",", $_POST['arregloPrevisiones']);
						$usuAux=$objIns->buscaInstitucion($objCon, 1);				
						if($usuAux!=""){
							echo "Este nombre ya existe en la base de datos";
						}else{
							try{
							 		$objCon->beginTransaction();
							 		$objIns->agregarConvenio($objCon, $arreglox);
							 		$objCon->commit();					 		
							}catch (PDOException $e){
						 			$objCon->rollBack(); 
						 			echo $e->getMessage();
							}						
						}
				break;				
				case "desactivarInstitucion":
						$objCon->db_connect();												
						$objIns->setInstitucion($_POST['ins_id'],'');						
						try{
						 		$objCon->beginTransaction();
						 		$objIns->desactivarInstitucion($objCon);
						 		$objCon->commit();
						 		echo "Institución desactivada con éxito";						 		
						}catch (PDOException $e){
					 			$objCon->rollBack(); 
					 			$e->getMessage();
						}
				break;
				case "activarInstitucion":
						$objCon->db_connect();												
						$objIns->setInstitucion($_POST['ins_id'],'');
						try{
						 		$objCon->beginTransaction();
						 		$objIns->activarInstitucion($objCon);
						 		$objCon->commit();
						 		echo "Institución activada con éxito";						 		
						}catch (PDOException $e){
					 			$objCon->rollBack(); 
					 			$e->getMessage();
						}						
				break;
				case "agregarAsociacion":
						$objCon->db_connect();												
						$objIns->setInstitucion($_POST['ins_id'],'');
						$arreglox= explode(",", $_POST['arregloPrevisiones']);	
						try{
						 		$objCon->beginTransaction();
						 		$objIns->asociarInstitucion($objCon, $arreglox);
						 		$objCon->commit();					 		
						}catch (PDOException $e){
					 			$objCon->rollBack(); 
					 			$e->getMessage();
					 			
						}					
				break;
				case "eliminarAsociacionPre":
						$objCon->db_connect();												
						$objIns->setInstitucion($_POST['ins_id'],'');						
						try{
						 		$objCon->beginTransaction();
						 		$objIns->eliminarAsociacion($objCon, $_POST['pre_id']);
						 		$objCon->commit();
						 		echo "Previsión desvinculada con éxito";						 		
						}catch (PDOException $e){
					 			$objCon->rollBack(); 
					 			$e->getMessage();
						}
						
				break;
				case "guardarConvenioPSS":
						$objCon->db_connect();											
						try{
						 		$objCon->beginTransaction();
						 		$objIns->setInstitucion($_POST['ins_id'],'');
						 		$objIns->modificarConvenioPSS($objCon, $_POST['pss_id']);
						 		$objCon->commit();
						 		echo "Convenio guardado";						 		
						}catch (PDOException $e){
					 			$objCon->rollBack(); 
					 			$e->getMessage();
						}
						
				break;

		}
?>