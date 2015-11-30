<? 
ini_set('post_max_size', '512M'); 
ini_set('memory_limit', '1G'); 
set_time_limit(0);
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Cache-Control: no-store");
require_once('../../include/tcpdf/tcpdf.php');
require_once('../../include/tcpdf/config/lang/spa.php');
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
//RECEPCION VARIABLE

$pss_id = '1';

//CARGA DE CLASES Y METODOS
require_once('../../class/Conectar.class.php'); $objCon = new Conectar(); 
require_once('../../class/Tipo_producto.class.php'); $objTip = new Tipo_producto(); 
require_once('../../class/Pss.class.php'); $objPss = new Pss(); 
require_once('../../class/Util.class.php'); $objUtil = new Util(); 

$objCon->db_connect();
$objPss->setPss($pss_id, '', '', '', '', '', '');

$tipoProducto 	= $objTip->listarTipoProducto($objCon);
$detallePSS 	= $objPss->verDetallePss($objCon);
$cabeceraPSS 	= $objPss->cabeceraPSS($objCon);
$objCon = null;
/*print_r($detallePSS);
echo $detallePSS[$i][tip_prod_id];*/

//TABLA DE CONTENIDO HTML
$html = '
<table width="690" border="0">
	<tr>
		<td width="30%" align="left"><img src="../../include/img/logo_regional.jpg" width="130" height="120" /></td>
		<td align="center" style="font-size:10;">
		<table>
			<tr>
			<td height="30px" width="1px" >&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			</tr>
			<tr>
			<td>&nbsp;</td>
			<td width="250px" align="center"><strong style="margin:30px; font-size:10;">PROGRAMA DE SERVICIO DE SALUD (P.S.S.) - Nº: '.$pss_id.' </strong></td>
			<td>&nbsp;</td>
			</tr>
		</table>
		</td>
		<td height="10" width="30%" align="right" style="font-size:10;">Arica, '.date('d-m-Y').'</td>
	</tr>
	<tr>
		<td colspan="3">&nbsp;</td>
	</tr>
	<tr>
		<td style="border-bottom-width:1px;" colspan="3" align="left" valign="bottom"><strong>Información Paciente</strong></td>
	</tr>
	<tr>
		<td style="border-bottom-width:1px;" colspan="3" align="left">
			<table width="100%" cellpadding="1" style="font-size:8;" border="0">
				<tr>
				    <td width="45%"><strong>NOMBRE</strong></td>
					<td width="13%"><strong>EDAD</strong></td>
					<td width="13%"><strong>SEXO</strong></td>
					<td width="11%"><strong>RUT</strong></td>
					<td width="18%"><strong>TELÉFONO</strong></td>
				</tr>
				<tr>
					<td>'.$cabeceraPSS[0][per_nombre].' '.$cabeceraPSS[0][per_apellidoPaterno].' '.$cabeceraPSS[0][per_apellidoMaterno].'</td>
					<td>'.$objUtil->calcularEdad($cabeceraPSS[0][per_fechaNacimiento]).'</td>
					<td>'.$cabeceraPSS[0][per_sexo].'</td>
					<td>'.$cabeceraPSS[0][per_id].'</td>
					<td>'.$cabeceraPSS[0][per_telefono].'</td>
				</tr>
				<tr>
					<td><strong>DIRECCIÓN</strong></td>
					<td><strong>PREVISIÓN</strong></td>
					<td><strong>C.PAGO</strong></td>
					<td><strong>N°PROGRAMA</strong></td>
				</tr>
				<tr>
					<td>DIRECCION</td>
					<td>PREVISION</td>
					<td>INSTITUCION</td>
					<td>CTA CTE</td>
				</tr>
			</table>
		</td>
	</tr>';
	
	$total_programa = 0;
	for ($i=0; $i<count($tipoProducto); $i++) {
		if($detallePSS[$i][tip_prod_id]==$tipoProducto[$i][tip_prod_id]){
			$html .='
			<tr>
				<td colspan="3"><br><br></td>
			</tr>
			<tr>
				<td colspan="3">
					<table width="100%" cellpadding="1" style="font-size:8;" border="0">
						<tr>
							<td align="center" style="border-bottom-width:1px;"><h3>'.strtoupper($tipoProducto[$i][tip_descripcion]).'</h3></td>
						</tr>
						<tr>
							<td style="border-bottom-width:1px;" width="10%">CÓDIGO</td>
							<td style="border-bottom-width:1px;" width="50%">DESCRIPCIÓN</td>
							<td style="border-bottom-width:1px;" align="center" width="10%">CANT</td>
							<td style="border-bottom-width:1px;" align="right" width="15%">V. UNITARIO</td>
							<td style="border-bottom-width:1px;" align="right" width="15%">V. TOTAL</td>
						</tr>';
		
				$html .='<tr>
							<td>'.$detallePSS[$i][pro_id].'</td>
							<td>'.$detallePSS[$i][pro_nom].'</td>
							<td align="left">'.$detallePSS[$i][det_proCantidad].'</td>
							<td align="center">'.$detallePSS[$i][det_proUnitario].'</td>
							<td align="right">'.$detallePSS[$i][total].'</td>
						</tr>';
			
				$subtotal += $detallePSS[$i][total];
				$html .='<tr>
							<td style="border-top-width:1px;" align="right" colspan="6"><b>SUBTOTAL</b></td>
							<td style="border-top-width:1px;" align="right">'.$subtotal.'</td>
						</tr>
						</table>
				</td>
			</tr>';
			
		}
	}
$total_programa += $subtotal;

$html .='<tr>
			<td style="border-bottom-width:1px;" colspan="3"><br><br></td>
		</tr>
		<tr>
			<td colspan="3">
				<table width="100%" cellpadding="1" style="font-size:8;" border="0">
					<tr>
						<td style="border-bottom-width:1px;" width="10%">&nbsp;</td>
						<td style="border-bottom-width:1px;" width="60%">&nbsp;</td>
						<td style="border-bottom-width:1px; font-size:10;" align="center" width="20%">TOTAL PROGRAMA</td>
						<td style="border-bottom-width:1px; font-size:10;" align="right" width="10%">'.$total_programa.'</td>
					</tr>
				</table>
			</td>
		</tr>';
//FIN TOTAL PROGRAMA
//COMIENZA LA MUESTRA DE BOLETAS O ABONOS SI EXISTEN

	$html .='<tr>
				<td style="border-bottom-width:1px;" colspan="3"><br><br></td>
			</tr>
			<tr>
				<td width="50%" align="left" colspan="3"><h3>ABONOS Y PAGOS</h3></td>
			</tr>
			<tr>
			<td colspan="3">
				<table width="100%" cellpadding="1" style="font-size:8;">
					<tr>
						<th>FOLIO</th>
						<th>FECHA</th>
						<th>HORA</th>
						<th>MONTO</th>
					</tr>';
				$html .='
					<tr>
						<td>1</td>
						<td>29-11-2015</td>
						<td>19:00</td>
						<td align="center"><table width="50px" align="right"><tr><td>150</td></tr></table></td>
					</tr>';
				
		$html .='</table>
				</td>
			</tr>';
	


/*if(mysql_num_rows($QRbonos)){
	$html .='<tr>
				<td style="border-bottom-width:1px;" colspan="3"><br><br></td>
			</tr>
			<tr>
				<td width="35%" align="left" colspan="3"><h3>BONOS</h3></td>
			</tr>
			<tr>
			<td colspan="3">
			<table width="100%" cellpadding="1" style="font-size:8;">
			<tr>
				<th>FOLIO</th>
				<th>TIPO</th>
				<th>FECHA</th>
				<th>MONTO</th>
			</tr>';
			while($RSbonos = mysql_fetch_array($QRbonos)){
				$html .='
					<tr>
						<td>'.$RSbonos['PAGBONfolio'].'</td>
						<td>'.$RSbonos['tipo'].'</td>
						<td>'.$RSbonos['PAGBONfecha'].'</td>
						<td>'.$objUtil->formatearNumero($RSbonos['PAGBONmonto']).'</td>
					</tr>';
				}
			$html .='</table>
				</td>
			</tr>';
	
}*/
//TERMINA LA MUESTRA DE BOLETAS O ABONOS
$html .='</table>';

//Print text using writeHTMLCell()
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('PSS_1.pdf','I');

/*DEFINE ('FTP_USER','recnet'); 
DEFINE ('FTP_PASS','recnet');
$path = date('Y')."/PSS/";
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
ftp_put($conn_id, date('Y').'/PSS/'.'PSS_'.$cta_cte.'.pdf', 'PSS_'.$cta_cte.'.pdf', FTP_BINARY);
unlink('PSS_'.$cta_cte.'.pdf');*/
?>