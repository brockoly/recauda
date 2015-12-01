<?php
if (!isset($_SESSION)) {
	session_start();
}
error_reporting(0);
ini_set('post_max_size', '512M'); 
ini_set('memory_limit', '1G'); 
set_time_limit(0);
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
		$datosPss = $objPss->buscarPss($objCon);

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
<span>Nombre   : '.$RSpaciente["nombre"].'</span><br/>
<span>R.U.N    : '.$RSpaciente["rut"].'-'.$objUtil->generaDigito($RSpaciente["rut"]).'</span><br/>
<span>Previsión: '.$RSpaciente["prevision"].' </span><br/>
<span>F.Pago   : '.$RSpaciente["instNombre"].'</span><br/>
<span>Cta.Cte. : '.$RSpaciente["pssCabCtaCte"].'  P.S.S: '.$RSpaciente["det_CabId"].'</span><br/>
<span>Cajero(a) : '.$RSpaciente["nombreusuario"].'</span><br/><br/>
';
// TERMINA CABECERA

//DETALLE

while($RSdetalle=mysql_fetch_array($QRdetalle)){
		if($RSdetalle['item']=='4310101'){
			$valor01 += ($RSdetalle['valor']);
		}
		if($RSdetalle['item']=='4310102'){
			$valor02 += ($RSdetalle['valor']);
		}
		if($RSdetalle['item']=='4310103'){
			$valor03 += ($RSdetalle['valor']);
		}
		if($RSdetalle['item']=='4310104'){
			$valor04 += ($RSdetalle['valor']);
		}
		if($RSdetalle['item']=='4310105'){
			$valor05 += ($RSdetalle['valor']);
		}
		if($RSdetalle['item']=='4310106'){
			$valor06 += ($RSdetalle['valor']);
		}
		if($RSdetalle['item']=='4310107'){
			$valor07 += ($RSdetalle['valor']);
		}
		if($RSdetalle['item']=='4310108'){
			$valor08 += ($RSdetalle['valor']);
		}
		if($RSdetalle['item']=='4310199'){
			$valor09 += ($RSdetalle['valor']);
		}
		if($RSdetalle['item']=='6310115'){
			$valor10 += ($RSdetalle['valor']);
		}
		
	}
	$html .='
		<table>
			<tr>
				<td width="82%" align="left" colspan="2"><strong>ITEM</strong></td>
				<td width="18%" align="right"><strong>MONTO</strong></td>
			</tr>
		<table>
	';
mysql_data_seek($QRdetalle, 0);	
while($det = mysql_fetch_array($QRdetalle)){
		
	if($valor01!=0){
		mysql_data_seek($QRdetalle, 0);
		while($RSdetalle=mysql_fetch_array($QRdetalle)){
			if($RSdetalle['item']=='4310101'){
				$diaVal = $RSdetalle['valor'];
				$html .='
				<table>
					<tr>
						<td width="8%">'.$RSdetalle['cantidad'].'</td>
						<td width="72%">'.strtoupper($RSdetalle['nombre']).'</td>
						<td width="20%" align="right">'.$objUtil->formatearNumero($diaVal).'</td>
					</tr>';
			$valorDia +=$diaVal; 
			}
			$valorDia = $valorDia;
		}
		$html .='
				<tr>
					<td colspan="" width="70%" style="border-bottom-width:1px; border-top-width:1px;"><strong>DIA CAMA (4310101)</strong></td>
					<td align="right" width="30%" style="border-bottom-width:1px; border-top-width:1px;">'.$objUtil->formatearNumero($valorDia).'</td>
				</tr>
				<br/>
			';
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
	
	if($valor03!=0){
		
		mysql_data_seek($QRdetalle, 0);
		while($RSdetalle=mysql_fetch_array($QRdetalle)){
			if($RSdetalle['item']=='4310103'){
				$exaVal = $RSdetalle['valor'];
				$html .='
				<tr>
					<td width="8%">'.$RSdetalle['cantidad'].'</td>
					<td width="72%">'.strtoupper($RSdetalle['nombre']).'</td>
					<td width="20%" align="right">'.$objUtil->formatearNumero($exaVal).'</td>
				</tr>';
			$valorExa +=$exaVal; 
			}
			$valorExa = $valorExa;
		}
		$html .='
				<tr>
					<td colspan="2" width="70%" style="border-bottom-width:1px; border-top-width:1px;"><strong>EXAMENES (4310103)</strong></td>
					<td align="right" width="30%" style="border-bottom-width:1px; border-top-width:1px;">'.$objUtil->formatearNumero($valorExa).'</td>
				</tr>
				<br/>
			';
	}
	
	if($valor04!=0){
		
		mysql_data_seek($QRdetalle, 0);
		while($RSdetalle=mysql_fetch_array($QRdetalle)){
			if($RSdetalle['item']=='4310104'){
				$consuVal = $RSdetalle['valor'];
				/*if($RSdetalle['codigo']=='0102003'){
					$html .='
					<tr>
						<td width="8%">'.$RSdetalle['cantidad'].'</td>
						<td width="72%">'.strtoupper($RSdetalle['nombre']).'</td>
						<td width="20%" align="right">'.$objUtil->formatearNumero(round($consuVal-1)).'</td>
						<td></td>
					</tr>';
					}else{*/
					$html .='
					<tr>
						<td width="8%">'.$RSdetalle['cantidad'].'</td>
						<td width="72%">'.strtoupper($RSdetalle['nombre']).'</td>
						<td width="20%" align="right">'.$objUtil->formatearNumero($consuVal).'</td>
					</tr>';
					/*}*/
			$valorConsu +=$consuVal; 
			}
			$valorConsu = $valorConsu;
		}
		$html .='
				<tr>
					<td colspan="2" width="70%" style="border-bottom-width:1px; border-top-width:1px;"><strong>CONSULTAS (4310104)</strong></td>
					<td align="right" width="30%" style="border-bottom-width:1px; border-top-width:1px;">'.$objUtil->formatearNumero($valorConsu).'</td>
				</tr>
				<br/>
			';
	}
	
	if($valor05!=0){
		
		mysql_data_seek($QRdetalle, 0);
		while($RSdetalle=mysql_fetch_array($QRdetalle)){
			if($RSdetalle['item']=='4310105'){
				$mediVal = $RSdetalle['valor'];
				
				/*if($RSdetalle['codigo']==2250069){
					$html .='<tr>
						<td width="8%">'.$RSdetalle['cantidad'].'</td>
						<td width="72%">'.strtoupper($RSdetalle['nombre']).'</td>
						<td width="20%" align="right">'.$objUtil->formatearNumero(round($mediVal+6)).'</td>
						<td></td>
					</tr>';
					}else{*/
						$html .='<tr>
							<td width="8%">'.$RSdetalle['cantidad'].'</td>
							<td width="72%">'.strtoupper($RSdetalle['nombre']).'</td>
							<td width="20%" align="right">'.$objUtil->formatearNumero($mediVal).'</td>
						</tr>';
						/*}*/
			
			$valorMedi +=$mediVal;
			}
			$valorMedi = $valorMedi;
		}
		$html .='
				<tr>
					<td colspan="2" width="70%" style="border-bottom-width:1px; border-top-width:1px;"><strong>MEDICAMENTOS (4310105)</strong></td>
					<td align="right" width="30%" style="border-bottom-width:1px; border-top-width:1px;">'.$objUtil->formatearNumero($valorMedi).'</td>
				</tr>
				<br/>
			';
	}
	
	if($valor06!=0){
		
		mysql_data_seek($QRdetalle, 0);
		while($RSdetalle=mysql_fetch_array($QRdetalle)){
			if($RSdetalle['item']=='4310106'){
				$proVal = $RSdetalle['valor'];
			$html .='<tr>
					<td width="8%">'.$RSdetalle['cantidad'].'</td>
					<td width="72%">'.strtoupper($RSdetalle['nombre']).'</td>
					<td width="20%" align="right">'.$objUtil->formatearNumero($proVal).'</td>
				</tr>';
			$valorPro +=$proVal;
			}
			$valorPro = $valorPro;
		}
		$html .='
				<tr>
					<td colspan="2" width="70%" style="border-bottom-width:1px; border-top-width:1px;"><strong>PROTESIS (4310106)</strong></td>
					<td align="right" width="30%" style="border-bottom-width:1px; border-top-width:1px;">'.$objUtil->formatearNumero($valorPro).'</td>
				</tr>
				<br/>
			';
	}
	
	if($valor07!=0){
		
		mysql_data_seek($QRdetalle, 0);
		while($RSdetalle=mysql_fetch_array($QRdetalle)){
			if($RSdetalle['item']=='4310107'){
				$traVal = $RSdetalle['valor'];
			$html .='<tr>
					<td width="8%">'.$RSdetalle['cantidad'].'</td>
					<td width="72%">'.strtoupper($RSdetalle['nombre']).'</td>
					<td width="20%" align="right">'.$objUtil->formatearNumero($traVal).'</td>
				</tr>';
			$valorTra +=$traVal;
			}
			$valorTra = $valorTra;
		}
		$html .='
				<tr>
					<td colspan="2" width="70%" style="border-bottom-width:1px; border-top-width:1px;"><strong>TRASLADOS (4310107)</strong></td>
					<td align="right" width="30%" style="border-bottom-width:1px; border-top-width:1px;">'.$objUtil->formatearNumero($valorTra).'</td>
				</tr>
				<br/>
			';
	}
	
	if($valor08!=0){
		
		mysql_data_seek($QRdetalle, 0);
		while($RSdetalle=mysql_fetch_array($QRdetalle)){
			if($RSdetalle['item']=='4310108'){
				$dentVal = $RSdetalle['valor'];
			$html .='<tr>
					<td width="8%">'.$RSdetalle['cantidad'].'</td>
					<td width="72%">'.strtoupper($RSdetalle['nombre']).'</td>
					<td width="20%" align="right">'.$objUtil->formatearNumero($dentVal).'</td>
				</tr>';
			$valorDent +=$dentVal;
			}
			$valorDent = $valorDent;
		}
		$html .='
				<tr>
					<td colspan="2" width="70%" style="border-bottom-width:1px; border-top-width:1px;"><strong>DENTAL (4310108)</strong></td>
					<td align="right" width="30%" style="border-bottom-width:1px; border-top-width:1px;">'.$objUtil->formatearNumero($valorDent).'</td>
				</tr>
				<br/>
			';
	}
	
	if($valor09!=0){
		
		mysql_data_seek($QRdetalle, 0);
		while($RSdetalle=mysql_fetch_array($QRdetalle)){
			if($RSdetalle['item']=='4310199'){
				$otroVal = $RSdetalle['valor'];
			$html .='<tr>
					<td width="8%">'.$RSdetalle['cantidad'].'</td>
					<td width="72%">'.strtoupper($RSdetalle['nombre']).'</td>
					<td width="20%" align="right">'.$objUtil->formatearNumero($otroVal).'</td>
				</tr>';
			$valorOtro +=$otroVal;
			}
			$valorOtro = $valorOtro;
		}	
		$html .='
				<tr>
					<td colspan="2" width="70%" style="border-bottom-width:1px; border-top-width:1px;"><strong>OTRO ING. (4310199)</strong></td>
					<td align="right" width="30%" style="border-bottom-width:1px; border-top-width:1px;">'.$objUtil->formatearNumero($valorOtro).'</td>
				</tr>
				<br/>
			';
	}
	
	if($valor10!=0){
		
		mysql_data_seek($QRdetalle, 0);
		while($RSdetalle=mysql_fetch_array($QRdetalle)){
			if($RSdetalle['item']=='6310115'){
				$valUmi = $RSdetalle['valor'];
			$html .='<tr>
					<td width="8%">'.$RSdetalle['cantidad'].'</td>
					<td width="72%">'.strtoupper($RSdetalle['nombre']).'</td>
					<td width="20%" align="right">'.$objUtil->formatearNumero($valUmi).'</td>
				</tr>';
			$valorUmi +=$valUmi;
			}
			$valorUmi = $valorUmi;
		}
		$html .='
				<tr>
					<td colspan="2" width="70%" style="border-bottom-width:1px; border-top-width:1px;"><strong>U.M.I. (6310115)</strong></td>
					<td align="right" width="30%" style="border-bottom-width:1px; border-top-width:1px;">'.$objUtil->formatearNumero($valorUmi).'</td>
				</tr>
			</table>';	
	}
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
?>