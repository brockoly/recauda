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
require_once('../../class/Tipo_Producto.class.php'); $objTipoProd = new Tipo_Producto;
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

$totalProductos=count($datosDetallePss);


// create new PDF document
$custom_layout = array(80, ($totalProductos*8.3)+162);
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, $custom_layout, true, 'UTF-8', false);
//SET DOCUMENT INFORMATION
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Recaudacion');
$pdf->SetTitle('Programa de Servicio de Salud');
$pdf->SetSubject('Detalle programa paciente');
$pdf->SetKeywords('Paciente, PSS, Programa');
//$pdf->SetHeaderData('../../img/logo.jpg', PDF_HEADER_LOGO_WIDTH,'SERVICIO DE SALUD ARICA ','HOSPITAL REGIONAL DE ARICA Y PARINACOTA');
$pdf->setHeaderFont(Array('helvetica', '', 18));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(4, 5, 5, 1);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(0);
$pdf->SetAutoPageBreak(FALSE, 0);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->setLanguageArray($l);
$pdf->setFontSubsetting(true);
$pdf->SetFont('helvetica', '', 9, '', true);
$pdf->setPrintFooter(false);
//CREA UNA PAGINA
$pdf->AddPage();

//TABLA DE CONTENIDO HTML COMIENZO CABECERA
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
<span>Cajero(a) : '.$datosPago[$i]['nombre'].'</span><br/><br/>
';
// TERMINA CABECERA

//DETALLE

	$html .='
		<table border="0">
			<tr>
				<td width="82%" align="left" colspan="2"><strong>ITEM</strong></td>
				<td width="18%" align="right"><strong>MONTO</strong></td>
			</tr>
		</table>
	';

$tiposProductos = $objTipoProd->listarTipoProducto($objCon);

$totalBoleta=0;

for($x=0; $x<count($tiposProductos); $x++){
	$total=0;
$existe=0;	
	//echo $tiposProductos[$x]['tip_descripcion'];	
	if(count($datosDetallePss)>0){
		//$html .='<table border="1">';
	
		for($a=0; $a<count($datosDetallePss); $a++){
			if($tiposProductos[$x]['tip_descripcion']==$datosDetallePss[$a]['tip_descripcion']){
				$existe=1;
				$html .='<table border="0"><tr>
						<td width="8%">'.$datosDetallePss[$a]['det_proCantidad'].'  </td>
						<td width="70%">'.strtoupper($datosDetallePss[$a]['pro_nom']).'</td>
						<td width="22%" align="right">'.$objUti->formatDinero($datosDetallePss[$a]['total']).'</td></tr></table>';
				$total=$total+$datosDetallePss[$a]['total'];
				$totalBoleta=$totalBoleta+$datosDetallePss[$a]['total'];
			}
			
		}		
		if($existe==1){
			$html .='<table border="0"><tr width="100%" >
						<td style="font-weight:bold;" width="78%">'.strtoupper($tiposProductos[$x]['tip_descripcion']).' ('.$tiposProductos[$x]['tip_prod_id'].')  </td>						
						<td style="font-weight:bold;" width="22%" align="right">'.$objUti->formatDinero($total).'</td></tr><tr><td></td></tr></table>';
		}
	}
}




	
	

// COMIENZO PIE BOLETA
$html.= '
<table>
    <tr>
        <td width="70%" style="border-bottom-width:1px; border-top-width:1px;"><b>Total facturado programa</b></td>
        <td width="30%" style="border-bottom-width:1px; border-top-width:1px;" align="right"><b>$'.$objUti->formatDinero($totalBoleta).'</b></td>
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
			$html .='<tr>
							<td width="70%">'.$datosPago[$i]['tip_pag_descripcion'].'</td>
							<td width="30%" align="right">'.$objUti->formatDinero($datosPago[$i]['pag_monto']).'</td>
						</tr>';

			
			$html.='
				<tr>
					<td width="70%" style="border-top-width:1px;"><b>Total Pago</b></td>
					<td width="30%" style="border-top-width:1px;" align="right"><b>$'.$objUti->formatDinero($datosPago[$i]['pag_monto']).'</b></td>
				</tr>
			</table>
		</td>
	</tr>
</table>  
<br/>';

$html .='<br/>
<table>
    <tr>
        <td width="70%" style="border-bottom-width:1px; border-top-width:1px;"><b>Saldo Por Pagar</b></td>
       	<td width="30%" style="border-bottom-width:1px; border-top-width:1px;" align="right"><b>$'.$objUti->formatDinero($datosPss[$b]['pss_saldo']).'</b></td>
    </tr>
</table>
<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
<table>
    <tr>
        <td width="100%" style="border-top-width:1px;"><b>TIMBRE RECAUDACION</b></td>
    </tr>
</table>
';
// TERMINO PIE BOLETA		

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('boleta_'.$numFolio.'.pdf','FI');

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