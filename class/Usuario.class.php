<?php 
class Usuario{
	 private $usu_nombre;
	 private $usu_clave;
	 private $usu_correo;
	 private $usu_estado;


	function setUsuario($usuario, $clave, $correo){
	 		$this->usu_nombre=trim($usuario);
	 		$this->usu_clave=trim($clave);
	 		$this->usu_correo=trim($correo);
	}

	function setUsu_usuario($usuario){
	 		$this->usu_nombre=trim($usuario);
	}

	function setUsu_correo($correo){
	 		$this->usu_correo=trim($correo);
	}

	function inicioSistema($objCon){
	 	$sql = "SELECT
				COUNT(usuario.pri_id) AS cantidad
				FROM
				usuario";
		foreach ($objCon->consultaSQL($sql,'ERROR inicioSistema') as $v) {
	 		$datos = $v['cantidad'];
	 	}
	 	return $datos;
	}

	function buscarUsuarioSolo($objCon){
	 	$pass = md5($this->usu_clave);
	 	$sql="SELECT
			usuario.pri_id
			FROM usuario
			WHERE usu_nombre = '$this->usu_nombre' AND usu_clave = '$pass'";
		foreach ($objCon->consultaSQL($sql,'ERROR buscarUsuarioSolo') as $v) {
	 		$datos = $v['pri_id'];
	 	}
	 	return $datos;
	}
	function validarUsuarioClave($objCon){
	 	
	 	$sql="SELECT
			usuario.usu_nombre
			FROM usuario
			WHERE usuario.usu_clave = '$this->usu_clave' AND usuario.usu_nombre = '$this->usu_nombre' ";
		foreach ($objCon->consultaSQL($sql,'ERROR validarUsuario') as $v) {
	 		$datos = $v['usu_nombre'];
	 	}
	 	return $datos;
	}

	function validarUsuario($conexion,$privilegio){
	 	session_start();
	 	$_SESSION['usuario'] = Array();
	 	if($privilegio==1){
	 		$_SESSION['usuario'][0]['tipo_usuario'] = 'Administrador';
	 		$_SESSION['usuario'][1]['nombre_usuario'] = $this->usu_nombre;
	 	}else if($privilegio==2){
	 		$_SESSION['usuario'][0]['tipo_usuario'] = 'Recaudador';
	 		$_SESSION['usuario'][1]['nombre_usuario'] = $this->usu_nombre;
	 	}

	}
	
	function buscarContrasenaUsuario($conexion){
	 	$sql ="SELECT usu_nombre
	 		   FROM usuario
	 		   WHERE usu_nombre='$this->usu_nombre'";
	 	foreach ($objCon->consultaSQL($sql,'ERROR buscarUsuario') as $v) {
	 		$datos = $v['usu_nombre'];
	 	}
	 	return $datos;
	}

	function cambiarContrasena($objCon,$passNueva){
	 	$sql="UPDATE usuario
			SET usuario.usu_clave='$passNueva'
			WHERE usuario.usu_nombre='$this->usu_nombre'";
		$rs=$objCon->ejecutarSQL($sql,'ERROR AL cambiarContrasena');
	 	return $rs;
	}

	function buscarUsuario($objCon){ // Busca si existe el nombre usuario en la base de datos
	 	$sql ="SELECT
				CASE 
				WHEN usuario.usu_nombre = '$this->usu_nombre' AND usuario.usu_estado = 0 THEN 'Existe Activado'
				WHEN usuario.usu_nombre = '$this->usu_nombre' AND usuario.usu_estado = 1 THEN 'Existe Desactivado'
				END AS condicion
			  FROM recaudacion.usuario
			  HAVING condicion IS NOT NULL";
		$datos="";
	 	foreach ($objCon->consultaSQL($sql,'ERROR buscarUsuario') as $v) {
					$datos = $v['condicion'];
		}
	 	return $datos;
	}

	function buscarCorreo($objCon){ // Busca si existe el correo en la base de datos
	 	$sql ="SELECT
				CASE 
				WHEN usuario.usu_correo = '$this->usu_correo' AND usuario.usu_nombre = '$this->usu_nombre' THEN 'Existe con usuario'
				WHEN usuario.usu_correo = '$this->usu_correo' AND usuario.usu_nombre <> '$this->usu_nombre' THEN 'Existe sin el usuario'
				END AS condicion
			   FROM recaudacion.usuario";
	 	foreach ($objCon->consultaSQL($sql,'ERROR buscarCorreo') as $v) {
	 		if(is_null($v['condicion'])==false){
	 			$datos = $v['condicion'];
	 		}
	 	}
	 	return $datos;
	}

	function insertarUsuario($objCon,$per_id,$pri_id){
	 	$sql ="INSERT INTO usuario (usu_nombre, pri_id, per_id, usu_clave, usu_correo)
			   VALUES ('$this->usu_nombre', $pri_id, '$per_id','".md5($this->usu_nombre)."', '$this->usu_correo')";
	 	$rs=$objCon->ejecutarSQL($sql,'ERROR AL insertarUsuario');
	 	return $rs;
	}
	
	function desplegarUsuarios($objCon,$opcion){ 
	 	$datos = array();
		$i=0;
		$sql =" SELECT
					usuario.usu_nombre,
					usuario.per_id,
					usuario.usu_correo,
					persona.per_nombre,
					persona.per_apellidoPaterno,
					persona.per_apellidoMaterno,
					persona.per_telefono,
					persona.per_direccion,
					privilegios.pri_descripcion
				FROM
				usuario
				LEFT JOIN persona ON usuario.per_id = persona.per_id
				INNER JOIN privilegios ON usuario.pri_id = privilegios.pri_id";
	 	if($opcion==1){
	 		$sql.=" WHERE usuario.usu_estado=1";	//DESACTIVADOS		 	
	 	}else{
	 		$sql.=" WHERE usuario.usu_estado=0"; //ACTIVOS
	 	}

	 	foreach($objCon->consultaSQL($sql, 'ERROR desplegarUsuarios') as $v) {
				$datos[$i]['usuario']=$v['usu_nombre'];
				$datos[$i]['privilegio']=$v['pri_descripcion'];
				$datos[$i]['rut']=$v['per_id'];
				$datos[$i]['nombre']=$v['per_nombre'];
				$datos[$i]['apellidoPaterno']=$v['per_apellidoPaterno'];
				$datos[$i]['aplellidoMaterno']=$v['per_apellidoMaterno'];
				$datos[$i]['correo']=$v['usu_correo'];
				$datos[$i]['telefono']=$v['per_telefono'];
				$datos[$i]['direccion']=$v['per_direccion'];
				$i++;
		}
	 	return $datos;
	 }

	 function getInformacionUsuario($objCon){ 
	 	$datos = array();
		$i=0;
	 	$sql =" SELECT
					usuario.usu_nombre,
					usuario.pri_id,
					usuario.usu_correo,
					persona.per_id,
					persona.per_nombre,
					persona.per_apellidoPaterno,
					persona.per_apellidoMaterno,
					persona.per_fechaNacimiento,
					persona.per_telefono,
					persona.per_direccion,
					persona.per_sexo
				FROM
					usuario
				LEFT JOIN persona ON usuario.per_id = persona.per_id
				WHERE usu_nombre ='$this->usu_nombre'";
			 	foreach($objCon->consultaSQL($sql, 'ERROR getInformacionUsuario') as $v) {
						$datos[$i]['usuario']=$v['usu_nombre'];
						$datos[$i]['rut']=$v['per_id'];
						$datos[$i]['nombre']=$v['per_nombre'];
						$datos[$i]['apellidoPaterno']=$v['per_apellidoPaterno'];
						$datos[$i]['aplellidoMaterno']=$v['per_apellidoMaterno'];
						$datos[$i]['correo']=$v['usu_correo'];
						$datos[$i]['telefono']=$v['per_telefono'];
						$datos[$i]['privilegio']=$v['pri_id'];
						$datos[$i]['fechaNacimiento']=$v['per_fechaNacimiento'];
						$datos[$i]['direccion']=$v['per_direccion'];
						$datos[$i]['sexo']=$v['per_sexo'];
						$i++;
				}
	 	return $datos;
	 }

	function modificarUsuario($objCon,$per_id,$pri_id){
	 	$sql ="UPDATE usuario 
	 		   SET usu_nombre='$this->usu_nombre', pri_id=$pri_id, usu_correo='$this->usu_correo'
			   WHERE per_id = '$per_id'";
		$rs =$objCon->ejecutarSQL($sql, 'ERROR AL modificarUsuario');
	 	return $rs;
	}

	function eliminarUsuario($objCon,$per_id){
	 	$sql="UPDATE usuario
			  SET usuario.usu_estado=1
			  WHERE usuario.per_id='$per_id'";
		$rs=$objCon->ejecutarSQL($sql,'ERROR AL eliminarUsuario');
	 	return $rs;
	}

	function restaurarUsuario($objCon){
	 	$sql="UPDATE usuario
			  SET usuario.usu_estado=0
			  WHERE usuario.usu_nombre='$this->usu_nombre'";
		$rs=$objCon->ejecutarSQL($sql,'ERROR AL restaurarUsuario');
	 	return $rs;
	}

	function restaurarClave($objCon){
	 	$sql="UPDATE usuario
			  SET usuario.usu_clave='$this->usu_clave'
			  WHERE usuario.usu_nombre='$this->usu_nombre'";
		$rs=$objCon->ejecutarSQL($sql,'ERROR AL restaurarClave');
	 	return $rs;
	}
	function buscarUsuarioRut($objCon, $per_id){
			$datos = 0;
			$i=0;
			$sql =" SELECT	usuario.usu_nombre
					FROM usuario
					WHERE usuario.per_id = '$per_id'";
			foreach($objCon->consultaSQL($sql, 'ERROR buscarUsuario') as $v) {
					$datos =1;
			}
			return $datos;
	}
	function buscarPersona($objCon, $usu_nombre, $per_id){
			$datos = array();
			$i=0;
			$sql =" SELECT
						usuario.usu_nombre,
						usuario.usu_correo,
						persona.per_nombre,
						persona.per_telefono,
						persona.per_apellidoPaterno,
						persona.per_apellidoMaterno,
						persona.per_fechaNacimiento,
						persona.per_sexo,
						persona.per_direccion						
					FROM usuario
					LEFT JOIN persona ON persona.per_id = usuario.per_id";

			if(empty($usu_nombre)==false){
				$sql.=" WHERE usuario.usu_nombre = '$usu_nombre'";
			}else if(empty($per_id)==false){ 
					$sql.=" WHERE usuario.per_id = '$per_id'";
			}				
		 	foreach($objCon->consultaSQL($sql, 'ERROR buscarUsuario') as $v) {
					$datos['usu_nombre']=$v['usu_nombre'];
					$datos['usu_correo']=$v['usu_correo'];
					$datos['per_nombre']=$v['per_nombre'];
					$datos['per_apellidoPaterno']=$v['per_apellidoPaterno'];
					$datos['per_apellidoMaterno']=$v['per_apellidoMaterno'];
					//formatear fecha
					require_once('../../class/Util.class.php'); 
					$objUti=new Util(); 
					$datos['per_fechaNacimiento']=$objUti->cambiarfecha_mysql_a_normal($v['per_fechaNacimiento']);
					$datos['per_telefono']=$v['per_telefono'];
					$datos['per_sexo']=$v['per_sexo'];
					$datos['per_direccion']=$v['per_direccion'];
			}
		 	return json_encode($datos);
	}



}?>