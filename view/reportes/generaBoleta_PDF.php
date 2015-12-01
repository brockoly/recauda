<?php
/*if (!isset($_SESSION)) {
	session_start();
}
error_reporting(0);
ini_set('post_max_size', '512M'); 
ini_set('memory_limit', '1G'); 
set_time_limit(0);*/
ini_set('post_max_size', '512M'); 
ini_set('memory_limit', '1G'); 
set_time_limit(0);
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Cache-Control: no-store");
//CONEXIONES A BD Y CREACION DE LAS SQL
require_once('../../include/tcpdf/tcpdf.php');
require_once('../../include/tcpdf/config/lang/spa.php');
require_once('../../class/Conectar.class.php');  $objCon = new Conectar();
require_once('../../class/Paciente.class.php'); $objPac = new Paciente;
require_once('../../class/Pagos.class.php'); $objPag = new Pagos;
require_once('../../class/Util.class.php'); $objUti = new Util;
require_once('../../class/Pss.class.php'); $objPss = new Pss;

		//TODO LO QUE NECESITAMOS

		$numFolio = $_GET['bol_id'];	// NUMERO DE FOLIO
		$i=0; $p=0; $b=0;				// Variables para los arrays
		$objCon->db_connect();

		//TODOS LOS DATOS DE PAGO Y BOLETA
		$datosPago = $objPag->listarPagosPSS($objCon, '', $numFolio);	

		//TODOS LOS DATOS DEL PACIENTE (persona,prevision,institucion)
		$datosPaciente = $objPac->getInformacionPaciente($objCon,'','', $datosPago[$i]['cue_id']);

		//TODOS LOS DATOS DE PSS
		$objPss->setPss_id($datosPago[$i]['pss_id']);			
		$datosPss = $objPss->buscarPss($objCon,'');

		//TODOS LOS DETALLES DE LOS PRODUCTOS
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

/*
$RSdatosBoleta = 	$objConsumo->getDatosBoleta($numFolio,$exen,$link);

$id_paciente = $RSdatosBoleta['BOLid_paciente'];
$cta_cte = $RSdatosBoleta['BOLcta_cte'];
$usuario = $RSdatosBoleta['BOLidusuario'];
$monto = $RSdatosBoleta['BOLmonto'];
$nro_pss = $RSdatosBoleta['det_CabId'];
//$boletaExenta = $_GET['boletaExenta'];

$QRprestaciones = 	$objConsumo		->	getConsumoPrestaciones($link, $id_paciente, $nro_pss);
$QRinsumos = 		$objConsumo		->	getConsumoInsumos($link, $id_paciente, $nro_pss);
$QRfarmacos = 		$objConsumo		->	getConsumoFarmacos($link, $id_paciente, $nro_pss);
$QRexamenes = 		$objConsumo		->	getConsumoExamenes($link, $id_paciente, $nro_pss);
$QRanatomia = 		$objAnatomia	->	listarAnatomiaPaciente($link,$nro_pss);
$QRintervenciones = $objConsumo		->	getConsumoIntervenciones($link, $id_paciente, $nro_pss);
$RSpaciente = 		$objPaciente	->	getPacienteBoleta($link, $numFolio, $exen);
$QRdetalle = 		$objBoleta		->	getConsumoPorItem($link, $nro_pss);
$QRpagos = 			$objPago		->  getPagos($link, $numFolio, $exen);
$QRdif =			$objPago 		->  diferenciaPago($link, $numFolio, $exen);

class MYPDF extends TCPDF {
	//Page header
}

while($RSintervenciones = mysql_fetch_array($QRintervenciones)){
	$intervenciones +=$RSintervenciones['total'];
}
while($RSprestaciones = mysql_fetch_array($QRprestaciones)){
	$prestaciones +=$RSprestaciones['total'];
}
while($RSexamenes = mysql_fetch_array($QRexamenes)){
	$examenes +=$RSexamenes['total'];
}
while($RSfarmacos = mysql_fetch_array($QRfarmacos)){
	$farmacos +=$RSfarmacos['total'];
}
while($RSinsumos = mysql_fetch_array($QRinsumos)){
	$insumos +=$RSinsumos['total'];
}	
while($RSanatomia = mysql_fetch_array($QRanatomia)){
	$anatomia +=$RSanatomia['total'];
}	

$totalPres = $intervenciones + $prestaciones + $examenes + $farmacos + $insumos + $anatomia;
*/
/*$array_totales[] = mysql_num_rows($QRintervenciones);
$array_totales[] = mysql_num_rows($QRprestaciones);
$array_totales[] = mysql_num_rows($QRexamenes);
$array_totales[] = mysql_num_rows($QRfarmacos);
$array_totales[] = mysql_num_rows($QRinsumos);
$array_totales[] = mysql_num_rows($QRanatomia);*/
/*
$array_totales[] = mysql_num_rows($QRdetalle);

$totaltodo = array_sum($array_totales) * 8.1;

$tamaño_pagina = $totaltodo + 140;
*/

/*
// create new PDF document
$pdf = new TCPDF('', 'mm', array(80,$tamaño_pagina), true, 'UTF-8', false);
//SET DOCUMENT INFORMATION
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Recaudacion');
$pdf->SetTitle('Programa de Servicio de Salud');
$pdf->SetSubject('Detalle programa paciente');
$pdf->SetKeywords('Paciente, Boleta, Consumo');
$pdf->SetMargins(4, 5, 5, 1);
$pdf->SetAutoPageBreak(FALSE,0);
$pdf->setFontSubsetting(true);
$pdf->SetFont('helvetica', '', 9,false);
$pdf->setPrintFooter(false);
$pdf->setPrintHeader(false);
//CREA UNA PAGINA
$pdf->AddPage();
*/


class MYPDF extends TCPDF {
	//Page header
	public function Header() {
		//get the current page break margin
		$bMargin = $this->getBreakMargin();
		// get current auto-page-break mode
		$auto_page_break = $this->AutoPageBreak;
		// disable auto-page-break
		$this->SetAutoPageBreak(false, 0);
		// restore auto-page-break status
		$this->SetAutoPageBreak($auto_page_break, $bMargin);
		// set the starting point for the page content
		$this->setPageMark();
	}
}
// cre
// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
//SET DOCUMENT INFORMATION
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Recaudacion');
$pdf->SetTitle('Programa de Servicio de Salud');
$pdf->SetSubject('Detalle programa paciente');
$pdf->SetKeywords('Paciente, PSS, Programa');
//$pdf->SetHeaderData('../../img/logo.jpg', PDF_HEADER_LOGO_WIDTH,'SERVICIO DE SALUD ARICA ','HOSPITAL REGIONAL DE ARICA Y PARINACOTA');
$pdf->setHeaderFont(Array('helvetica', '', 6));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(PDF_MARGIN_LEFT, 8, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetAutoPageBreak(TRUE, 15);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->setLanguageArray($l);
$pdf->setFontSubsetting(true);
$pdf->SetFont('helvetica', '', 8, '', true);
//CREA UNA PAGINA
$pdf->AddPage();







//TABLA DE CONTENIDO HTML COMIENZO CABECERA
/* '.$RSpaciente['instNombre'].' */
$html = '
<table align="center">
	<tr>
		<td><b>Hospital Regional Arica</b></td>
	</tr>
	<tr>
		<td><b>Dr. Juan Noe Crevani</b></td>
	</tr>
	<tr>
		<td><b>RUT: 61.606.000-7</b></td>
	</tr>
	<tr>
		<td><b>18 de Septiembre  N° 1000</b></td>
	</tr>
	<tr>
		<td style="border-bottom-width:1px;"></td>
	</tr>
</table>
<br/><br/>
<table align="center">
	<tr>
		<td><b>BOLETA '.$exe.' '.$numFolio.' Fecha: '.$fechaBoleta.'</b></td>
	</tr>
</table>
<br/>
<br/>
<span>Nombre   : '.$datosPaciente[$p]['Nombre'].' '.$datosPaciente[$p]['Apellido_Paterno'].' '.$datosPaciente[$p]['Apellido_Materno'].'</span><br/>
<span>R.U.N    : '.$per_id.'</span><br/>
<span>Previsión: '.$datosPaciente[$p]['pre_nombre'].' </span><br/>
<span>F.Pago   : '.$datosPaciente[$p]['ins_nombre'].'</span><br/>
<span>Cta.Cte. : '.$datosPago[$i]['cue_id'].'  P.S.S: '.$datosPago[$i]['pss_id'].'</span><br/>
<span>Cajero(a) : '.$datosPago[$i]['usu_nombre'].'</span><br/><br/>
';
// TERMINA CABECERA









//DETALLE

	$html .='
		<table>
			<tr>
				<td width="82%" align="left" colspan="2"><strong>ITEM</strong></td>
				<td width="18%" align="right"><strong>MONTO</strong></td>
			</tr>
		</table>
	';

	$total
	for($a=0; $a<count($datosDetallePss); $a++){
		echo "Cantidad: ".$datosDetallePss[$a]['det_proCantidad'];
		echo " - - Nombre: ".$datosDetallePss[$a]['pro_nom'];
		echo " - - Valor: ".$datosDetallePss[$a]['det_proUnitario'];
		echo " - - Tipo Producto: ".$datosDetallePss[$a]['tip_descripcion'];
		echo " - - TOTAL: ".$datosDetallePss[$a]['total'];
		echo "<br>";
	}

	if($valor02!=0){
		
		mysql_data_seek($QRdetalle, 0);
		while($RSdetalle=mysql_fetch_array($QRdetalle)){
			if($RSdetalle['item']=='4310102'){
				$interVal = $RSdetalle['valor'];
				$html .='
				<tr>
					<td width="8%">'.$RSdetalle['cantidad'].'</td>
					<td width="72%">'.strtoupper($RSdetalle['nombre']).'</td>
					<td width="20%" align="right">'.$objUtil->formatearNumero($interVal).'</td>
				</tr>';
			$valorInter +=$interVal; 
			}
			$valorInter = $valorInter;
		}
		$html .='
				<tr>
					<td colspan="2" width="70%" style="border-bottom-width:1px; border-top-width:1px;"><strong>INTERVENCIÓN (4310102)</strong></td>
					<td align="right" width="30%" style="border-bottom-width:1px; border-top-width:1px;">'.$objUtil->formatearNumero($valorInter).'</td>
				</tr>
				<br/>
			';
		
	}
	

// COMIENZO PIE BOLETA
$totalPresPor = $valorUmi+$valorOtro+$valorDent+$valorTra+$valorPro+$valorMedi+$valorConsu+$valorExa+$valorInter+$valorDia;
$html.= '
<table>
    <tr>
        <td width="70%" style="border-bottom-width:1px; border-top-width:1px;"><b>Total facturado programa</b></td>
        <td width="30%" style="border-bottom-width:1px; border-top-width:1px;" align="right"><b>$'.$objUtil->formatearNumero($totalPresPor).'</b></td>
    </tr>
</table>
<br/>
<br/>
 <table>
	<tr>
		<td style="border-top-width:1px; border-bottom-width:1px; border-left-width:1px; border-right-width:1px; width:60%">Pago Actual</td>
	</tr>
	<tr>
		<td style="border-top-width:1px; border-bottom-width:1px; border-left-width:1px; border-right-width:1px; width:100%">
			<table>';
			$montoTotal = 0;
			while($RSpag = mysql_fetch_array($QRpagos)){
				$montoTotal += $RSpag["monto"];
				$html .='<tr>
							<td width="70%">'.$RSpag["tipo"].'</td>
							<td width="30%" align="right">'.$objUtil->formatearNumero($RSpag["monto"]).'</td>
						</tr>';

			}
			$html.='
				<tr>
					<td width="70%" style="border-top-width:1px;"><b>Total Pago</b></td>
					<td width="30%" style="border-top-width:1px;" align="right"><b>$'.$objUtil->formatearNumero($montoTotal).'</b></td>
				</tr>
			</table>
		</td>
	</tr>
</table>  
<br/>';
$monto = $montoTotal;
$dif = $QRdif["pssCabTotal"] - $monto;
$html .='<br/>
<table>
    <tr>
        <td width="70%" style="border-bottom-width:1px; border-top-width:1px;"><b>Saldo Por Pagar</b></td>
       	<td width="30%" style="border-bottom-width:1px; border-top-width:1px;" align="right"><b>$'.$objUtil->formatearNumero($dif).'</b></td>
    </tr>
</table>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<table>
    <tr>
        <td width="100%" style="border-top-width:1px;"><b>TIMBRE RECAUDACION</b></td>
    </tr>
</table>
';
// TERMINO PIE BOLETA		

	
//$guardarValores = $objPago->updateBoleta($link, $numFolio, $valorDia, $valorInter, $valorExa, $valorConsu, $valorMedi, $valorPro, $valorTra, $valorDent, $valorOtro, $valorUmi, $boletaExenta);

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('boleta_'.$numFolio.'.pdf','FI');


/*DEFINE ('FTP_USER','recnet'); 
DEFINE ('FTP_PASS','recnet');
$path = date('Y')."/BOLETA/";
        $path = explode("/",$path);
        $conn_id = @ftp_connect("10.6.21.14",21,1);
        if(!$conn_id) {
            return false;
        }
        if (@ftp_login($conn_id, FTP_USER, FTP_PASS)) {
            foreach ($path as $dir) {
                if(!$dir) {
                    continue;
                }
                $currPath.="/".trim($dir);
                if(!@ftp_chdir($conn_id,$currPath)) {
                    if(!@ftp_mkdir($conn_id,$currPath)) {
                       	@ftp_close($conn_id);
                        return false;
                    }
                    @ftp_chmod($conn_id,0777,$currPath);
                }
            }
        }
        @ftp_close($conn_id);
$ftp_server = "10.6.21.14";
$conn_id = ftp_connect($ftp_server, 21,1) or die("N");
$login_result = ftp_login($conn_id, "recnet", "recnet");
ftp_put($conn_id, date('Y').'/BOLETA/'.'boleta_'.$numFolio.'.pdf', 'boleta_'.$numFolio.'.pdf', FTP_BINARY);
unlink('boleta_'.$numFolio.'.pdf');*/

DEFINE ('FTP_USER','recaudacion'); 
DEFINE ('FTP_PASS','recaudacion');
$path = date('Y')."/boleta/";
        $path = explode("/",$path);
        $conn_id = @ftp_connect("10.2.21.108",21,1);
        if(!$conn_id) {
            return false;
        }
        if (@ftp_login($conn_id, FTP_USER, FTP_PASS)) {
            foreach ($path as $dir) {
                if(!$dir) {
                    continue;
                }
                $currPath.="/".trim($dir);
                if(!@ftp_chdir($conn_id,$currPath)) {
                    if(!@ftp_mkdir($conn_id,$currPath)) {
                       	@ftp_close($conn_id);
                        return false;
                    }
                    @ftp_chmod($conn_id,0777,$currPath);
                }
            }
        }
        @ftp_close($conn_id);
$ftp_server = "10.2.21.108";
$conn_id = ftp_connect($ftp_server, 21,1) or die("N");
$login_result = ftp_login($conn_id, "recaudacion", "recaudacion");
ftp_put($conn_id, date('Y').'/boleta/'.'boleta_'.$numFolio.'.pdf', 'boleta_'.$numFolio.'.pdf', FTP_BINARY);
unlink('boleta_'.$numFolio.'.pdf');
?>