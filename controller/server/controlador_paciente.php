<?php
	
	//LLAMADA DE CLASES
	require_once('../../class/Conectar.class.php');
 	require_once('../../class/Paciente.class.php'); 
	require_once('../../class/Persona.class.php'); 
	require_once('../../class/Util.class.php'); 
	require_once('../../class/Prevision.class.php'); 
	require_once('../../class/Institucion.class.php'); 
	require_once('../../class/Nacionalidad.class.php'); 
	switch($_POST['op']) {
		case 'agregarPaciente': // Agrega paciente y sus datos personales asociados
								$objCon = new Conectar();
								$objPer= new Persona();
								$objUti= new Util();
								$objPac= new Paciente();
								$objPrev = new Prevision;
								$objInst = new Institucion;
								$objNac = new Nacionalidad;
								$objCon->db_connect();
								if($_POST['cmbPais']==1){
									$per_id	= $objUti->valida_rut($_POST['rut']);
								}else{
									$per_id	= $objUti->eliminaEspacios($_POST['txtIdentificador']);
								}
								$per_nombre	=  $objUti->eliminaEspacios($_POST['txtNombres']);
								$per_apellidoPaterno	=  $objUti->eliminaEspacios($_POST['txtApellidoPat']);
								$per_apellidoMaterno	=  $objUti->eliminaEspacios($_POST['txtApellidoMat']);
								$per_fechaNacimiento	=  $objUti->cambiarfecha_mysql($_POST['txtFechaNac']);
								if($_POST['txtTelefono'] ==""){
									$per_telefono = 0;
								}else{
									$per_telefono = $_POST['txtTelefono'];
								}
								$per_procedencia = $_POST['cmbPais'];
								$per_sexo = $_POST['rdSexo'];
								$per_direccion =  $objUti->eliminaEspacios($_POST['txtDireccion']);
								$pac_id = $objPac->nuevoPac_id($objCon);
								$pre_id = $_POST['cmbPrevision']; 
								$ins_id = $_POST['cmbInstitucion'];
								$nac_id = $_POST['cmbPais'];
								try{									
							 		$objCon->beginTransaction();
									$objPer->setPersona($per_id, $per_nombre, $per_apellidoPaterno, $per_apellidoMaterno, $per_fechaNacimiento, $per_telefono, $per_procedencia, $per_sexo, $per_direccion);
									$objPac->setPaciente($pac_id);		
									$objNac->setNacionalidad($nac_id,'');
									if($_POST['pacEx']==0){
										$objPer->insertarPersona($objCon);
										$objNac->insertarNacionalidadPersona($objCon, $per_id);
									}else{
										$objPer->modificarPersona($objCon);
									}									
									$objPac->insertarPaciente($objCon, $pre_id, $per_id, $ins_id);									
							 		$objCon->commit();
							 		echo "bien";						 		
							 	} catch (PDOException $e){
						 			$objCon->rollBack(); 
						 			echo $e->getMessage();
							 	}	
								break;
		case 'modificarPaciente': // Modifica paciente y sus datos personales asociados
								$objCon = new Conectar();
								$objPer= new Persona();
								$objUti= new Util();
								$objPac= new Paciente();
								$objPrev = new Prevision;
								$objInst = new Institucion;
								$objCon->db_connect();
								$per_nombre	=  $objUti->eliminaEspacios($_POST['txtNombres']);
								$per_apellidoPaterno	=  $objUti->eliminaEspacios($_POST['txtApellidoPat']);
								$per_apellidoMaterno	=  $objUti->eliminaEspacios($_POST['txtApellidoMat']);
								$per_fechaNacimiento	=  $objUti->cambiarfecha_mysql($_POST['txtFechaNac']);
								if($_POST['txtTelefono'] ==0){
									$per_telefono = 0;
								}else{
									$per_telefono = $_POST['txtTelefono'];
								}
								$per_procedencia = $_POST['cmbPais'];
								$per_sexo = $_POST['rdSexo'];
								$per_direccion =  $objUti->eliminaEspacios($_POST['txtDireccion']);
								$per_id = $_POST['per_id'];
								//$pac_id = $objPac->nuevoPac_id($objCon);
								$pre_id = $_POST['cmbPrevision']; 
								$ins_id = $_POST['cmbInstitucion'];
								try{
								 		$objCon->beginTransaction();
										$objPer->setPersona($per_id,$per_nombre,$per_apellidoPaterno,$per_apellidoMaterno,$per_fechaNacimiento,$per_telefono,$per_procedencia, $per_sexo, $per_direccion);
										$objPac->setPaciente($pac_id);		
										$objPer->modificarPersona($objCon);
										$objPac->actualizarPaciente($objCon, $pre_id, $per_id, $ins_id);
								 		$objCon->commit();
								 		echo "bien";						 		
								 	} catch (PDOException $e){
							 			$objCon->rollBack(); 
							 			echo $e->getMessage();
								 	}	
								break;
		case 'buscarPaciente': // Busca si el paciente existe en la base de datos
								$objCon = new Conectar();
								$objPac= new Paciente();
								$objUti= new Util(); 
								$objCon->db_connect();
								$txtRut = $_POST['txtRut'];
								$txtIdentificador =   $objUti->eliminaTodoEspacios($_POST['txtIdentificador']);
								if($txtRut > 0){
									$per_id = $objUti->valida_rut($txtRut);
								}else if($txtIdentificador !=""){
									$per_id = $txtIdentificador;
								}
								echo $res = $objPac->buscarPaciente($objCon, $per_id);
								break;
		case "eliminarPaciente": 
								$objCon = new Conectar();
								$objPac= new Paciente();
								$objCon->db_connect();
								try{
							 		$objCon->beginTransaction();
							 		$objPac->eliminarPaciente($objCon, $_POST['pac_id']);
							 		$objCon->commit();
							 		echo "<b>Paciente eliminado con exito</b>";					 		
							 	} catch (PDOException $e){
						 			$objCon->rollBack(); 
						 			$e->getMessage();
							 	}
								break;
		case "restaurarPaciente": 
								$objCon = new Conectar();
								$objPac= new Paciente();
								$objCon->db_connect();
								try{
							 		$objCon->beginTransaction();
							 		$objPac->restaurarPaciente($objCon, $_POST['pac_id']);
							 		$objCon->commit();
							 		echo "<b>Paciente restaurado con exito</b>";					 		
							 	} catch (PDOException $e){
						 			$objCon->rollBack(); 
						 			$e->getMessage();
							 	}
								break;
		case "buscarPersona":
								$objCon = new Conectar();
								$objPac= new Paciente();
								$objUti= new Util(); 
								$objCon->db_connect();
								$txtRut = $_POST['txtRut'];
								$per_id = $objUti->valida_rut($txtRut);
								echo $res = $objPac->buscarPersona($objCon, $per_id);
								break;
	}
?>