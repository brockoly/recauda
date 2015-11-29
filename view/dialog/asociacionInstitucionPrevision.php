<?
if ( $_SESSION['usuario'] == null ) {
		$GoTo = "../../../login/index.php";
		header(sprintf("Location: %s", $GoTo));
	}
?>
<script type="text/javascript">cargarContenido('./view/interface/busquedaInstitucionPrevision.php','ins_id=<?=$_POST['ins_id']?>&ins_nombre=<?=$_POST['ins_nombre']?>','#contenidoInstitucionPrevision');</script>
<div id="contenidoInstitucionPrevision" name="contenidoInstitucionPrevision"></div>
