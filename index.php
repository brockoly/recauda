<? 
session_start();
if ( $_SESSION['usuario'] == null ) {
	$GoTo = "../login/index.php";
	header(sprintf("Location: %s", $GoTo));
}
?>
<!DOCTYPE html>

<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recaudación</title>
    <!-- IMPORTACION CSS -->
    <link rel="stylesheet" type="text/css" href="include/framework/jquery/jquery-ui-1.11.4.custom/jquery-ui.css" />
    <link rel="stylesheet" type="text/css" href="include/framework/menu/responsive-flat-menu/style.css">
    <link rel="stylesheet" type="text/css" href="include/framework/menu/responsive-flat-menu/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="include/css/menu-lateral.css">
    <link rel="stylesheet" type="text/css" href="include/framework/datatable/dataTables.jqueryui.min.css">
	<link rel="stylesheet" type="text/css" href="include/css/maestro.css">


	<!-- IMPORTACION JS -->
    <script src="include/framework/jquery/jquery-1.9.1.js"></script>
    <script src="include/framework/jquery/jquery-ui-1.11.4.custom/jquery-ui.js"></script>
    <script src="include/framework/jsmaestro/jsmaestro.js"></script>
    <script src="include/framework/menu/responsive-flat-menu/js/menu.js"></script>
    <script src="include/framework/datatable/jquery.dataTables.js"></script>
    <script src="include/js/rut.js"></script>
    <script src="include/js/validCampoFranz.js"></script>
    <script src="controller/client/js_index.js"></script>
    <script src="include/framework/jqueryForm/jqueryForm.js"></script>

<center>
<div class="horizontal">
	<div class="header"><img width="710px" height="180px" src="include/img/logo_hjnc.png" /></div>
    <div class="agrupa_derecha">
        <div class="title" align="right">Recaudación</i>&nbsp;</div>
        <div class="agrupa_vertical">
            <div class="subtitle" align="right">
            	<div class="modulo_actual">BIENVENIDO&nbsp;</div>
            	<div class="usuario" align="right"><img src="include/img/user.png" width="32" height="32"  style="vertical-align:middle"/>&nbsp; <?= $_SESSION['usuario'][1]['nombre_usuario'];?>&nbsp; | <?= $_SESSION['usuario'][0]['tipo_usuario'];?><br/><? //include('');?></div>
            	<div class="btn_logout" align="right"><table id="BTNlogout"><tr><td width="10%"><img src="include/img/buttons/logout.png" width="20" height="20"/></td><td>Cerrar sesión</td></tr></table></div>            
				<div class="right"><a style="cursor:pointer; font-size: 12px;" id="btnChCon" >Cambiar contraseña</a></div>
            </div>
    	</div>
	</div>
</div>
</center>
</head>
<body bgcolor="#E6E6FA" ondrop="return false">
<div class="mainWrap">
<a id="touch-menu" class="mobile-menu" href="#"><i class="icon-reorder"></i>Menu</a>
	<nav>
		<ul class="menu">
		<?
			//if(in_array($caca, $cacaMayor)){
		?>
			<li><a href="#"><i class="icon-home"></i>RECAUDACIÓN</a>
				<ul class="sub-menu">
					<li class="change"><a href="#" onclick="cargarContenido('view/interface/gestionDePagos.php','','#contenidoCargado')">GESTIONAR PAGOS</a></li>
					<li class="change"><a href="#" onclick="cargarContenido('view/interface/nuevaCuentaCte.php','','#contenidoCargado')">NUEVA CUENTA</a></li>
					<li class="change"><a href="#" onclick="cargarContenido('view/interface/anularBoleta.php','','#contenidoCargado')">ANULAR BOLETA</a></li>
				</ul>
			</li>
		<? //}?>
			<li><a href="#"><i class="icon-search"></i>CONSULTA</a>
				<ul class="sub-menu">									
					<li class="change"><a href="#" onclick="cargarContenido('view/interface/consultaPagos.php','','#contenidoCargado')">PAGOS</a></li>									
					<li class="change"><a href="#">PAGARÉ</a></li>
					<li class="change"><a href="#" onclick="cargarContenido('view/interface/arqueosEspontaneos.php','','#contenidoCargado')">ARQUEO ESPONTANEO</a></li>
				</ul>
			</li>
			<li><a href="#"><i class="icon-print"></i>REPORTES</a>
				<ul class="sub-menu">
					<li ><a href="#">ARQUEOS</a>
						<ul class="sub-menu">
							<li class="change"><a href="#" onclick="cargarContenido('view/interface/rendicionEspontanea.php','','#contenidoCargado')">ESPONTÁNEO</a></li>
							<li class="change"><a href="#" onclick="cargarContenido('view/interface/rendicionGlobal.php','','#contenidoCargado')">GLOBAL</a></li>
						</ul>
					</li>
				</ul>
			</li>
			<? if($_SESSION['usuario'][0]['tipo_usuario'] == 'Administrador'){?>
			<li><a href="#"><i class="icon-home"></i>MANTENEDORES</a>
				<ul class="sub-menu">
					<li class="change"><a href="#" onclick="cargarContenido('view/interface/busquedaUsuario.php','','#contenidoCargado')">USUARIO</a></li>
					<li class="change"><a href="#" onclick="cargarContenido('view/interface/busquedaPaciente.php','','#contenidoCargado')">PACIENTES</a></li>
					<li class="change"><a href="#" onclick="cargarContenido('view/interface/busquedaPrevision.php','','#contenidoCargado')">PREVISIÓN</a></li>
					<li class="change"><a href="#" onclick="cargarContenido('view/interface/busquedaConvenio.php','','#contenidoCargado')">CONVENIOS</a></li>
					<li class="change"><a href="#" onclick="cargarContenido('view/interface/busquedaProducto.php','','#contenidoCargado')">PRODUCTOS</a></li>
					<li class="change"><a href="#" onclick="cargarContenido('view/interface/busquedaNacionalidades.php','','#contenidoCargado')">NACIONALIDAD</a></li>
					<li class="change"><a href="#" onclick="cargarContenido('view/interface/busquedaUsuarioEliminar.php','','#contenidoCargado')">RESTAURAR USUARIOS</a></li>
				</ul>
			</li>
			<? }?>
		</ul>
	</nav>
</div><br><br>
<div class="mainWrap" id="contenidoCargado">

</div>
<div id="false" class="finx"></div>
</body>
<center>
	<div style="margin-top: 10%">
	<div class="linea_pie"><hr style="background-color: #665874; height: 3px;" /></div>
	    <table>
	        <tr>
	            <td><img id="fin"class="pie" src="include/img/ing.png" width="30" height="30"></td>
	            <td><label class="pie_pagina">Sistema de recaudación - Hospital Dr. Juan Noé Crevani</label></td>
	        </tr>
	    </table>
	</div>
</center><center><div id="contenidoxCargado" style="float:center;"></div></center>
</html>
