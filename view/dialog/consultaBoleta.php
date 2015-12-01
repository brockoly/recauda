<?
$url = './view/reportes/generaBoleta_PDF.php?bol_id='.$_POST['bol_id'];

/* PROBANDO LAS VARIABLES ANTES DE ENVIARLA AL PDF, ASÍ NO SE CAÍA

require_once('../../class/Conectar.class.php');  $objCon = new Conectar();
require_once('../../class/Paciente.class.php'); $objPac = new Paciente;
require_once('../../class/Pagos.class.php'); $objPag = new Pagos;
require_once('../../class/Util.class.php'); $objUti = new Util;
require_once('../../class/Pss.class.php'); $objPss = new Pss;

$numFolio = $_POST['bol_id'];
$i=0; $p=0; $b=0;
$objCon->db_connect();
$datosPago = $objPag->listarPagosPSS($objCon, '', $numFolio);
$datosPaciente = $objPac->getInformacionPaciente($objCon,'','', $datosPago[$i]['cue_id']);
$objPss->setPss_id($datosPago[$i]['pss_id']);
$datosPss = $objPss->buscarPss($objCon);
$datosDetallePss = $objPss->verDetallePss($objCon,'');
$exen = $datosPago[$i]['bol_tipo'];
if($exen == 1){
	$exe = 'EXENTA';
}

$fechaBoleta= $objUti->cambiarfecha_mysql_a_normalGuion($datosPago[$i]['bol_fecha']);
if($datosPaciente[$p]['nac_id']=='1'){
	$per_id=$objUti->formatRut($datosPaciente[$p]['Identificador']);
}else{
	$per_id=$datosPaciente[$p]['Identificador'];
}

$necesito ="
Boleta:			Tipo: $exe --- id: ".$datosPago[$i]['bol_id']." --- fecha: $fechaBoleta --- cta cte: ".$datosPago[$i]['cue_id']." --- pss: ".$datosPago[$i]['pss_id']." --- usuario encargado: ".$datosPago[$i]['usu_nombre']."
<br>Paciente:		Nombre: ".$datosPaciente[$p]['Nombre']." ".$datosPaciente[$p]['Apellido_Paterno']." ".$datosPaciente[$p]['Apellido_Materno']."  ---- id: $per_id ---- prevision ".$datosPaciente[$p]['pre_nombre']."---- institución ".$datosPaciente[$p]['ins_nombre']."
<br>Pago:			".$datosPago[$i]['pag_monto'].", tip_pag_id ".$datosPago[$i]['tip_pag_descripcion']."

<br>PSS:			".$datosPss[$b]['pss_saldo']."
<br>
";

echo $necesito;

for($a=0; $a<count($datosDetallePss); $a++){
	echo "Cantidad: ".$datosDetallePss[$a]['det_proCantidad'];
	echo " - - Nombre: ".$datosDetallePss[$a]['pro_nom'];
	echo " - - Valor: ".$datosDetallePss[$a]['det_proUnitario'];
	echo " - - Tipo Producto: ".$datosDetallePss[$a]['tip_descripcion'];
	echo " - - TOTAL: ".$datosDetallePss[$a]['total'];
	echo "<br>";
}*/
?>
<iframe id="pss" width="800" height="500" src="<?=$url?>"></iframe>
