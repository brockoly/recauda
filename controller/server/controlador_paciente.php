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
							 		if(isset($_POST['rn']) && $_POST['rn']!=""){
							 			$datosRN = $objPac->ultimoRN($objCon);
							 			if(count($datosRN)==0){
							 				$max="RN1";
							 			}else{
								 			$max=0;
								 			for($i=0; $i<count($datosRN); $i++){								 				
								 				$ide = $datosRN[$i]['rn'];
								 				 $tamStr = strlen($ide);
								 				$maxAux=0;
								 				for($p=0; $p<$tamStr; $p++){
								 					if($p>1){
								 						$maxAux.=$ide[$p];
								 					}								 					
								 				}
								 				if($max<$maxAux){									 					
									 				$max = $maxAux;
								 				}
								 			}
								 			$max++;
								 			$max = "RN".$max;
								 		}								 										 		
										//echo "\n/*********".$max."**********/";
							 			$objPer->setPersona($max, $per_nombre, $per_apellidoPaterno, $per_apellidoMaterno, $per_fechaNacimiento, $per_telefono, $per_procedencia, $per_sexo, $per_direccion);
							 			$pac_id = $objPac->nuevoPac_id($objCon);
							 			$pac_id;
							 			$objPac->setPaciente($pac_id);
							 			$objNac->setNacionalidad($nac_id,'');	
							 			$objPer->insertarPersona($objCon);
										$objNac->insertarNacionalidadPersona($objCon, $max);
										$objPac->insertarPaciente($objCon, $pre_id, $max, $ins_id,'Si');
										echo "bien";
							 		}else{
										$objPer->setPersona($per_id, $per_nombre, $per_apellidoPaterno, $per_apellidoMaterno, $per_fechaNacimiento, $per_telefono, $per_procedencia, $per_sexo, $per_direccion);
										$objPac->setPaciente($pac_id);		
										$objNac->setNacionalidad($nac_id,'');
										if($_POST['pacEx']==0){
											$objPer->insertarPersona($objCon);
											$objNac->insertarNacionalidadPersona($objCon, $per_id);
										}else{
											$objPer->modificarPersona($objCon);
										}									
										$objPac->insertarPaciente($objCon, $pre_id, $per_id, $ins_id,'');
										echo "bien";	
									}								
							 		$objCon->commit();					 		
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
								 		if(isset($_POST['rn']) && $_POST['rn']!=""){
								 			if($_POST['naci_id']==1){
												$per_id	= $objUti->valida_rut($_POST['txtIdentificador']);
											}else{
												$per_id	= $objUti->eliminaEspacios($_POST['txtIdentificador']);
											}
								 			$objCon->beginTransaction();
											$objPer->setPersona($per_id,$per_nombre,$per_apellidoPaterno,$per_apellidoMaterno,$per_fechaNacimiento,$per_telefono,$per_procedencia, $per_sexo, $per_direccion);
											$objPac->setPaciente($pac_id);											
								 			$objPer->actualizarID($objCon,$_POST['txtIdentificadorAntiguo']);
											$objPer->modificarPersona($objCon);
											$objPac->actualizarPaciente($objCon, $pre_id, $per_id, $ins_id);
									 		$objCon->commit();
									 		echo "bien";
								 		}else{
									 		$objCon->beginTransaction();
											$objPer->setPersona($per_id,$per_nombre,$per_apellidoPaterno,$per_apellidoMaterno,$per_fechaNacimiento,$per_telefono,$per_procedencia, $per_sexo, $per_direccion);
											$objPac->setPaciente($pac_id);		
											$objPer->modificarPersona($objCon);
											$objPac->actualizarPaciente($objCon, $pre_id, $per_id, $ins_id);
									 		$objCon->commit();
									 		echo "bien";
								 		}
								 								 		
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
		case "cargarPacienteCSV":
								$objCon = new Conectar();
								$objPer= new Persona();
								$objUti= new Util();
								$objPac= new Paciente();
								$objPrev = new Prevision;
								$objInst = new Institucion;
								$objNac = new Nacionalidad;
								$objCon->db_connect();
								$tipo = $_FILES['archivo']['type'];
								$tamanio = $_FILES['archivo']['size'];
								$archivotmp = $_FILES['archivo']['tmp_name'];
								$lineas = file($archivotmp);
								$i=0;
								$j=0;
								$total=0;
								$datosDevueltos = array();
								foreach ($lineas as $linea_num => $linea){
									if($i != 0){
										$datos = explode(';',$linea);
										$id = $objUti->valida_rut(trim($datos[0]));
										$nombres = trim($datos[1]);											
										$apellidoPaterno = trim($datos[2]);											
										$apellidoMaterno = trim($datos[3]);										
										$sexo = trim($datos[4]);											
										$fecha = $objUti->cambiarfecha_mysql(trim($datos[5]));											
										$telefono = trim($datos[6]);											
										$direccion = trim($datos[7]);											
										$prevision = trim($datos[8]);											
										$institucion = trim($datos[9]);	
										$nacionalidad = trim($datos[10]);
										$objNac->setNacionalidad($nacionalidad,'');
										if($id>0){//verifica que el rut es valido										
											$existe = $objPac->buscarPaciente($objCon, $id);
											if($existe==1){										
												$datosDevueltos[$j]['id']=  "<b style='color: red'>".trim($datos[0])."</b>";
												$datosDevueltos[$j]['nombres'] = trim($datos[1]);
												$datosDevueltos[$j]['apellidoPaterno'] = trim($datos[2]);	
												$datosDevueltos[$j]['apellidoMaterno'] = trim($datos[3]);
												$datosDevueltos[$j]['sexo'] = trim($datos[4]);;
												$datosDevueltos[$j]['fecha'] = trim($datos[5]);
												$datosDevueltos[$j]['telefono'] = trim($datos[6]);
												$datosDevueltos[$j]['direccion'] = trim($datos[7]);
												$datosDevueltos[$j]['prevision'] = trim($datos[8]);
												$datosDevueltos[$j]['institucion'] = trim($datos[9]);
												$datosDevueltos[$j]['nacionalidad'] = trim($datos[10]);
												$datosDevueltos[$j]['error'] = "Existe como paciente";
												$datosDevueltos[$j]['result'] = "No Importado";
												$j++;
											}else{//NO EXISTE COMO PACIENTE
												$objPer->setPer_id($id);
												if($objPer->buscarIdentificador($objCon)==1){ //EXISTE EN TABLA PERSONA
													//CREAMOS PACIENTE Y ACTUALIZAMOS INFORMACIÓN DE PERSONA
													try{
														$objCon->beginTransaction();
														$pac_id = $objPac->nuevoPac_id($objCon);
														$objPer->setPersona($id,$nombres,$apellidoPaterno,$apellidoMaterno,$fecha,$telefono,$nacionalidad, $sexo, $direccion);
														$objPac->setPaciente($pac_id);		
														$objPer->modificarPersona($objCon);
														$objPac->insertarPaciente($objCon, $prevision, $id, $institucion,'');
														$objCon->commit();
														$total++;														
													}catch(PDOException $e){
														$total--;
											 			$objCon->rollBack(); 
											 			echo $e->getMessage();
													}	
												}else{
													//CREAMOS PACIENTE Y CREAMOSPERSONA
													try{
														$objCon->beginTransaction();
														$pac_id = $objPac->nuevoPac_id($objCon);
														$objPer->setPersona($id,$nombres,$apellidoPaterno,$apellidoMaterno,$fecha,$telefono,$nacionalidad, $sexo, $direccion);
														$objPac->setPaciente($pac_id);	
														$objPer->insertarPersona($objCon);
														$objNac->insertarNacionalidadPersona($objCon, $id);
														$objPac->insertarPaciente($objCon, $prevision, $id, $institucion,'');
														$objCon->commit();
														$total++;
													}catch (PDOException $e){
														$total--;
											 			$objCon->rollBack(); 
											 			echo $e->getMessage();
													}	
												}
											}								
										}else{
											if($datos[10]==1){//NOTIFICAMOS ERROR DE RUT
												$datosDevueltos[$j]['id']= "<b style='color: red'>".trim($datos[0])."</b>";
												$datosDevueltos[$j]['nombres'] = trim($datos[1]);
												$datosDevueltos[$j]['apellidoPaterno'] = trim($datos[2]);	
												$datosDevueltos[$j]['apellidoMaterno'] = trim($datos[3]);
												$datosDevueltos[$j]['sexo'] = trim($datos[4]);;
												$datosDevueltos[$j]['fecha'] = trim($datos[5]);
												$datosDevueltos[$j]['telefono'] = trim($datos[6]);
												$datosDevueltos[$j]['direccion'] = trim($datos[7]);
												$datosDevueltos[$j]['prevision'] = trim($datos[8]);
												$datosDevueltos[$j]['institucion'] = trim($datos[9]);
												$datosDevueltos[$j]['nacionalidad'] = trim($datos[10]);
												$datosDevueltos[$j]['error'] = "Rut ingresado es Incorrecto";
												$datosDevueltos[$j]['result'] = "No Importado";
												$j++;
											}else{
												$existe2 = $objPac->buscarPaciente($objCon, $id);
												if($existe2==1){	//EXISTE COMO PACIENTE										
													$datosDevueltos[$j]['id']= "<b style='color: red'>".trim($datos[0])."</b>";
													$datosDevueltos[$j]['nombres'] = trim($datos[1]);
													$datosDevueltos[$j]['apellidoPaterno'] = trim($datos[2]);	
													$datosDevueltos[$j]['apellidoMaterno'] = trim($datos[3]);
													$datosDevueltos[$j]['sexo'] = trim($datos[4]);;
													$datosDevueltos[$j]['fecha'] = trim($datos[5]);
													$datosDevueltos[$j]['telefono'] = trim($datos[6]);
													$datosDevueltos[$j]['direccion'] = trim($datos[7]);
													$datosDevueltos[$j]['prevision'] = trim($datos[8]);
													$datosDevueltos[$j]['institucion'] = trim($datos[9]);
													$datosDevueltos[$j]['nacionalidad'] = trim($datos[10]);
													$datosDevueltos[$j]['error'] = "Existe como paciente";
													$datosDevueltos[$j]['result'] = "No Importado";
													$j++;
												}else{
													//CREAMOS PACIENTE Y CREAMOSPERSONA.
													try{
														$objCon->beginTransaction();
														$pac_id = $objPac->nuevoPac_id($objCon);
														$objPer->setPersona($id,$nombres,$apellidoPaterno,$apellidoMaterno,$fecha,$telefono,$nacionalidad, $sexo, $direccion);
														$objPac->setPaciente($pac_id);	
														$objPer->insertarPersona($objCon);
														$objNac->insertarNacionalidadPersona($objCon, $id);
														$objPac->insertarPaciente($objCon, $prevision, $id, $institucion,'');
														$objCon->commit();
														$total++;
													}catch (PDOException $e){
														$total--;
											 			$objCon->rollBack(); 
											 			echo $e->getMessage();
													}	
													
												}
											}
										}
									}
									$i++;
								}
								$datosDevueltos[$j]['totalIns']=$total;								
								echo json_encode($datosDevueltos);
								
								break;
	}	
?>