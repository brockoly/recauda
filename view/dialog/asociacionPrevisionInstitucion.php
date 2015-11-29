<?
if ( $_SESSION['usuario'] == null ) {
		$GoTo = "../../../login/index.php";
		header(sprintf("Location: %s", $GoTo));
	}
?><script type="text/javascript">cargarContenido('./view/interface/busquedaPrevisionInstitucion.php','pre_id=<?=$_POST['pre_id']?>&pre_nombre=<?=$_POST['pre_nombre']?>','#contenidoPrevisionInstitucion');</script>
<div id="contenidoPrevisionInstitucion" name="contenidoPrevisionInstitucion"></div>
