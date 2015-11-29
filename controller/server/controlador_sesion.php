<?php
session_start();
	if ( $_SESSION['usuario'] == null ) {
		$GoTo = "../../../login/index.php";
		header(sprintf("Location: %s", $GoTo));
	}
//LLAMADA DE CLASES
require_once('../../class/Conectar.class.php');
require_once('../../class/Usuario.class.php'); 
require_once('../../class/Persona.class.php'); 
require_once('../../class/Privilegios.class.php'); 
require_once('../../class/Util.class.php'); 


switch ($_POST['op']) {
	case 'cerrar':		unset($_SESSION['usuario']);
						echo '1';
						break;
	case 'modificar': 	$objCon = new Conectar();
						$objUsu= new Usuario();
						$objUti= new Util();
						$objCon->db_connect();
						if($_POST['txtPassNuevo']!='' && $_POST['txtPassNuevoR']!='' && $_POST['txtPassActual']!=''){
							$objUsu->setUsuario($_SESSION['usuario'][1]['nombre_usuario'],md5($_POST['txtPassActual']), '');
							$usu = $objUsu->validarUsuarioClave($objCon);
							if($usu!=''){
							try{
						 		$objCon->beginTransaction();
						 		$objUsu->cambiarContrasena($objCon,md5($_POST['txtPassNuevo']));
						 		$objCon->commit();
						 		echo "1";					 		
						 	} catch (PDOException $e){
					 			$objCon->rollBack(); 
					 			echo $e->getMessage();
						 	}
							}else{
								echo "3";
							}
						}else{
							echo "4";
						}
						
						break;
}
	
?>