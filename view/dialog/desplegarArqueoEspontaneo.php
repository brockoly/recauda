<?
session_start();
$nombre=$_SESSION['usuario'][1]['nombre_usuario'];
$url='./view/reportes/'.$nombre.'_arqueoEspontaneo_'.$_POST['arq_id'].'.pdf';

?>
<iframe id="pss" width="1100" height="900" src="<?=$url?>"> </iframe>
