<?php
	
	//LLAMADA DE CLASES
	require_once('../../class/Conectar.class.php');
	require_once('../../class/Usuario.class.php'); 
	require_once('../../class/Persona.class.php'); 
	require_once('../../class/Privilegios.class.php'); 
	require_once('../../class/Nacionalidad.class.php'); 
	require_once('../../class/Util.class.php'); 



	switch($_POST['op']) {
		case "agregarUsuario": // Agrega usuario y sus datos personales asociados a su cuenta.
								$errores = array();
								$objCon = new Conectar();
								$objUsu= new Usuario();
								$objPer= new Persona();
								$objPri= new Privilegio();
								$objNac= new Nacionalidad();
								$objUti= new Util();
								$objCon->db_connect();
								$errores['txtUsuario']=0;
								$errores['txtIdentificador']=0;
								$errores['txtCorreo']=0;
								
								$objUsu->setUsuario($_POST['txtUsuario'],'', $_POST['txtCorreo']);								
								($_POST['txtTelefono']=="") ? $telefono=0 : $telefono = $_POST['txtTelefono'];
								$objPri->setPrivilegio($_POST['cmbPrivilegios'], '');
								$objNac->setNacionalidad(1,"");								
								$rut = $objUti->valida_rut($_POST['rut']);
								$objPer->setPersona($rut,$_POST['txtNombre'],$_POST['txtApellidoPaterno'],$_POST['txtApellidoMaterno'],
													$objUti->cambiarfecha_mysql($_POST['txtFechaNacimiento']),$telefono,1);
								$objPer->buscarIdentificador($objCon);
								$usuAux=$objUsu->buscarUsuario($objCon);

								if($usuAux!=""){
									if($usuAux=="Existe Activado"){//Retorna 0 si no existe el nombre usuario.
										$errores['txtUsuario']="El usuario ya existe en nuestros registros";
									}else{
										$errores['txtUsuario']="desactivado";
										//$errores['txtUsuario']="El usuario ya existe pero está desactivado, vaya al mantenedor y activelo nuevamente.";
									}
								}

								if($rut!=0){
									if($objUsu->buscarUsuarioRut($objCon,$rut)!=0){//Retorna 0 si no existe el identificador de persona.
										$errores['txtIdentificador']="El rut ya existe asociado a un paciente";
									}
								}else{						
								 	$errores['txtIdentificador']="El rut de persona no es valido";
								}
								if($objUsu->buscarCorreo($objCon)==$_POST['txtCorreo']){//Retorna 0 si no existe el identificador de persona.
									$errores['txtCorreo']="El correo de usuario ya existe en nuestros registros";
								}
								if( strlen($errores['txtUsuario'])!=1 || strlen($errores['txtIdentificador'])!=1 || strlen($errores['txtCorreo'])!=1){
									echo json_encode($errores);
								}else{	
									unset($errores['txtUsuario']);
									unset($errores['txtIdentificador']);
									unset($errores['txtCorreo']);
									try{										
								 		$objCon->beginTransaction();
								 		if($_POST['pacEx']==0){
											$objPer->insertarPersona($objCon);
											$objNac->insertarNacionalidadPersona($objCon, $rut);
										}else{
											$objPer->modificarPersona($objCon);
										}
								 		$objUsu->insertarUsuario($objCon,$objPer->getPer_id(),$objPri->getPri_id());
								 		$objCon->commit();
								 	} catch (PDOException $e){
							 			$objCon->rollBack(); 
							 			echo $e->getMessage();
								 	}
								 	echo json_encode($errores);
								}

								break;

		case "modificarUsuario": // Modifica usuario y sus datos personales asociados a su cuenta.
								session_start();
								$errores =array();
								$objCon = new Conectar();
								$objUsu= new Usuario();
								$objPer= new Persona();
								$objPri= new Privilegio();
								$objUtil= new Util();
								$objCon->db_connect();							

								($_POST['txtTelefono']=="") ? $telefono=0 : $telefono = $_POST['txtTelefono'];
								$objPri->setPrivilegio($_POST['cmbPrivilegios'], '');

								$fecha = $objUtil->cambiarfecha_mysql($_POST['txtFechaNacimiento']);
								$objUsu->setUsuario($_SESSION['usu_nombre'], '',$_POST['txtCorreo']);
								$objPer->setPersona($_SESSION['rut'],$_POST['txtNombre'],$_POST['txtApellidoPaterno'],$_POST['txtApellidoMaterno'],	$fecha ,$telefono,1);
								
								$correoAux = $objUsu->buscarCorreo($objCon);
								if($correoAux=="Existe con usuario"){
									$objUsu->setUsu_correo($_SESSION['usu_correo']);
									$errores['txtCorreo']=0;									
								}else{  
									if($correoAux=="Existe sin el usuario"){
										$errores["txtCorreo"]="El correo de usuario ya existe en nuestros registros";
									}else{
										$errores['txtCorreo']=0;
									}
								}						
								if($errores['txtCorreo']==0){									
									try{
								 		$objCon->beginTransaction();
								 		$objUsu->modificarUsuario($objCon,$objPer->getPer_id(),$objPri->getPri_id());
								 		$objPer->modificarPersona($objCon);
								 		$objCon->commit();						 		
								 	} catch (PDOException $e){
							 			$objCon->rollBack(); 
							 			$e->getMessage();
								 	}
								}								
								echo json_encode($errores);
								break;
		case "eliminarUsuario": 
								$objCon = new Conectar();
								$objUsu= new Usuario();
								$objCon->db_connect();
							
								try{
							 		$objCon->beginTransaction();
							 		$objUsu->eliminarUsuario($objCon, $_POST['per_id']);
							 		$objCon->commit();
							 		echo "<b>Usuario eliminado con exito</b>";					 		
							 	} catch (PDOException $e){
						 			$objCon->rollBack(); 
						 			$e->getMessage();
							 	}
							 	
								break;

		case "restaurarUsuario": 
								$objCon = new Conectar();
								$objUsu= new Usuario();
								$objCon->db_connect();
								$objUsu->setUsu_usuario($_POST['usu_nombre']);
								try{
							 		$objCon->beginTransaction();
							 		$objUsu->restaurarUsuario($objCon);
							 		$objCon->commit();
							 		echo "<b>Usuario restaurado con exito</b>";						 		
							 	}catch (PDOException $e){
						 			$objCon->rollBack(); 
						 			$e->getMessage();
							 	}
							 	
								break;
		case "restaurarClave": 
								$objCon = new Conectar();
								$objUsu= new Usuario();
								$objCon->db_connect();
								try{
									$objCon->beginTransaction();
									$objUsu->setUsuario($_POST['usu_nombre'], md5($_POST['usu_nombre']) ,'');
									$objUsu->restaurarClave($objCon);
									$objCon->commit();
									echo "La clave fue reseteada con exito.<br><b><u>Nota</u>:</u></b> Recuerde que la clave generada es la misma que el nombre usuario, <b>Notifique el cambio de esta.</b>";
								}catch (PDOException $e){
						 			$objCon->rollBack(); 
						 			$e->getMessage();
							 	}
							 	
								break;
		case "validarNombreUsuario":
								
								$objCon = new Conectar();
								$objUsu= new Usuario();
								$objCon->db_connect();
								$error="";
								$objUsu->setUsu_usuario($_POST['usu_nombre']);
								$usuAux=$objUsu->buscarUsuario($objCon);

								if($usuAux!=""){
									if($usuAux=="Existe Activado"){//Retorna 0 si no existe el nombre usuario.
										$error="El usuario ya existe en nuestros registros";
									}else{
										$error="desactivado";
										//$errores['txtUsuario']="El usuario ya existe pero está desactivado, vaya al mantenedor y activelo nuevamente.";
									}
								}

								echo $error;
														 	
								break;

		case "buscarUsuario":
								$objCon = new Conectar();
								$objUsu= new Usuario();
								$objUti= new Util(); 
								$objCon->db_connect();
								$txtRut = $_POST['txtRut'];
								$per_id = $objUti->valida_rut($txtRut);
								echo $res = $objUsu->buscarUsuario($objCon, $per_id);
								break;
		case "buscarPersona":
								$objCon = new Conectar();
								$objUsu= new Usuario();
								$objUti= new Util(); 
								$objCon->db_connect();
								$txtRut = $_POST['txtRut'];
								$per_id = $objUti->valida_rut($txtRut);
								echo $res = $objUsu->buscarPersona($objCon, '', $per_id);
								break;

	}
?>