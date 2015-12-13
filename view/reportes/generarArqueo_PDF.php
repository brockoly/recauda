<? if(!isset($_SESSION)) session_start();

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
$pdf->AddPage('L', 'A4');












//CARGA DE CLASES Y METODOS

require_once('../../class/Tipo_Producto.class.php'); $objTipPro = new Tipo_Producto;
require_once('../../class/Conectar.class.php');  $objCon = new Conectar();
require_once('../../class/Arqueo.class.php'); $objArq = new Arqueo;
require_once('../../class/Boleta.class.php'); $objBol = new Boleta;
require_once('../../class/Pagos.class.php'); $objPag = new Pagos;
require_once('../../class/Util.class.php'); $objUti = new Util;
require_once('../../class/Pss.class.php'); $objPss = new Pss;

//RECEPCION VARIABLE


$objCon->db_connect();
$usu_nombre = $_SESSION['usuario'][1]['nombre_usuario'];
$tipos_productos = $objTipPro->listarTipoProducto($objCon,'codigo');

//$boletas = $objBol->buscarBoletasArqueo($objCon, $usu_nombre);
$boletas = $objBol->buscarBoletasArqueo($objCon, $usu_nombre,'');



//LISTA DE TIPOS DE PRODUCTOS EXISTENTES

/*echo "Tipos de productos: 1: ";
for($i=0; $i<count($tipos_productos); $i++){
	echo $tipos_productos[$i]['tip_descripcion']." - ";
}
echo "<br><br>ID de boletas: ";
for($i=0; $i<count($boletas); $i++){
	echo " id ".$boletas[$i]['bol_id']." - id pss: ".$boletas[$i]['pss_id']." - ";
}*/


$textoPrev = "VISTA PREVIA";
$mensajeTitulo="<strong>ARQUEO ESPONTÁNEO <br> '.$textoPrev.'</strong>'";
$nombreUser = $usu_nombre;
$mensajeDoc = '';
$tipoDoc ="";
$tipoArqueo = $_GET['tipoArqueo'];

//CONDICION DE PDF 

switch($tipoArqueo){
	case 'vista_previa'	: 	$textoPrev 			=   'VISTA PREVIA';
							$mensajeTitulo 		=   '<strong>ARQUEO ESPONTANEO <br> '.$textoPrev.'</strong>';
							$nombreUser 		=   'Nombre: <strong>'.$nombreUser.'</strong>';
							$mensajeDoc 		=   '<label style="color:red;">Este documento NO es válido para rendir</label>';
							/*$QRrendGlobal 		= 	$objArqueo->arqueoEspontaneoNormal($link, $usuario, $id_rendicion);
							$QRrendGlobalExe 	= 	$objArqueo->arqueoEspontaneoExe($link, $usuario, $id_rendicion);
							$QRcheque        	= 	$objArqueo->arqueoEspontaneoCheque($link, $usuario, $id_rendicion);
							$QRtrans         	= 	$objArqueo->arqueoEspontaneoTransbank($link, $usuario, $id_rendicion);
							$QRnotaC 			= 	$objArqueo->arqueoEspNota($link, $usuario, $id_rendicion);
							$QRrendNula 		=	$objArqueo->arqueoEspontaneoNula($link, $usuario);*/
							$tipoDoc 			=   "I";
							break;

	case 'generar_arqueo':  //$id_rendicion 		= 	$objArqueo->InsertarRendicion($link, $usuario);
							$nro_arq 			=   'N° ';
							$mensajeTitulo 		=   '<strong>ARQUEO ESPONTANEO <br> '.$nro_arq.'</strong>';
							$mensajeDoc 		=   '<label style="color:green;">Documento válido para rendir</label>';
							/*$updateRend			=	$objArqueo->updateArqueoEspontaneoNormal($link, $id_rendicion, $usuario);
							$QRrendGlobal 		= 	$objArqueo->arqueoEspontaneoNormal($link, $usuario, $id_rendicion);
							$QRrendGlobalExe 	= 	$objArqueo->arqueoEspontaneoExe($link, $usuario, $id_rendicion);
							$QRcheque        	= 	$objArqueo->arqueoEspontaneoCheque($link, $usuario, $id_rendicion);
							$QRtrans         	= 	$objArqueo->arqueoEspontaneoTransbank($link, $usuario, $id_rendicion);
							$QRnotaC 			= 	$objArqueo->arqueoEspNota($link, $usuario, $id_rendicion);
							$QRrendNula 		=	$objArqueo->arqueoEspontaneoNula($link, $usuario, $id_rendicion);*/
							$tipoDoc 			= 	"FI";
							break;
}

//TABLA DE CONTENIDO HTML
$msjSubTitulo='';
$html = '
<table width="100%" border="0">
	<tr>
		<td width="40%" align="left"><img src="../../include/img/logo_regional.jpg" width="130" height="120" /></td>
		<td align="center" style="font-size:10;">
		<table border="0">
				<tr>
					<td height="30px" width="1px" >&nbsp;</td>
				</tr>
				<tr>
					<td width="250px" align="center">'.$mensajeTitulo.'</td>
				</tr>
				<tr>
					<td width="250px" style="font-size:25px;">'.$nombreUser.' '.$msjSubTitulo.'</td>
				</tr>
			</table >
		</td>
		<td height="10" width="27%" align="right" style="font-size:10;">Arica, '.date('d-m-Y').', '.$objUti->obtenerHora().' <br/>'.$mensajeDoc.'</td>
	</tr>
</table>
<br/>
<br/>';

$arrTotalesBot= Array(count($tipos_productos));


$html .='
<table width="100%" border="0">
	<tr>
		<td width="30%">&nbsp;</td>
		<td width="70%" align="left">
			<table><tr>';

	for($i=0; $i<count($tipos_productos); $i++){
		$html.='<td>'.$tipos_productos[$i]['tip_descripcion'].'</td>';		
	}	
	$html.='</tr><tr>';	
	for($i=0; $i<count($tipos_productos); $i++){
		$html.='<td>'.$tipos_productos[$i]['tip_prod_id'].'</td>';
	}	
	$html.='</tr></table></td></tr></table><br/><br/>';


$html .='
	<table width="100%"border="1">
		<tr>
			<td>
				<strong>BOLETAS DE RECAUDACIÓN</strong>
			</td>
		</tr>

		<tr>
			<td>													<!-- LISTADO DE HEADERS-->
				<table align="center">
					<tr>
						<td colspan="13">
							<table border="1">
								<tr >
									<td style="line-height:8px;" width="5%">Boleta</td>
									<td style="line-height:8px;" width="12.5%">Paciente</td>
									';
									$tamañox=(72.5/count($tipos_productos));
									for($i=0; $i<count($tipos_productos); $i++){
										$html.='<td style="line-height:8px;" width="'.$tamañox.'%">'.$tipos_productos[$i]['tip_prod_id'].'</td>';
									}	
									$html.='<td style="line-height:8px;" width="10%">TOTAL</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>';

		//									EDITAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAR
		//									EDITAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAR
		//									EDITAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAR
		//									EDITAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAR
		//									EDITAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAR
		//									EDITAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAR

$totalBoleta=0;
for($i=0; $i<count($boletas);$i++){
	$objPss->setPss_id($boletas[$i]['pss_id']);
	$detallesProductos = $objPss->verDetallePss($objCon);

	$arrTiposPSS = Array();
	for($a=0; $a<count($detallesProductos);$a++){
	    $arrTiposPSS[$a] = $detallesProductos[$a]['tip_prod_id']; 
	}
			$html .='
			<tr>
				<td>
					<table align="center">
						<tr>
							<td colspan="13">
								<table  border="1">										<!-- DATOS BOLETA -->
									<tr>
										<td width="5%">'.$boletas[$i]['bol_id'].'</td>
										<td width="12.5%" align="left">'.$boletas[$i]['nombre'].'</td>';
	for($b=0; $b<count($tipos_productos); $b++){
		$totalcategoria=0;
		for($c=0; $c<count($detallesProductos); $c++){
			if($tipos_productos[$b]['tip_prod_id'] == $detallesProductos[$c]['tip_prod_id']){
				
				$totalcategoria+=$detallesProductos[$c]['total'];
			}
		}
		$html.='<td width="'.$tamañox.'%">'.$totalcategoria.'</td>';
		$arrTotalesBot[$c]=$totalcategoria;
		$totalBoleta+=$totalcategoria;		
		$totalcategoria=0;
		
	}
	$html.='<td align="right" width="10%">'.$totalBoleta.'</td>';
			
			$html.='							
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			';
			$totalBoleta=0;
			
}
		/* TOTALES
		$total_diaCamaBen +=$diaCamaBen;
		$total_diaCama +=$diaCama;
		$total_InterBen +=$interBen;
		$total_Inter +=$inter;
		$total_exaBen +=$exaBen;
		$total_exa +=$exa;
		$total_consuBen +=$consu_ben;
		$total_consu +=$consu;
		$total_mediBen +=$medi_ben;
		$total_medi +=$medi;
		$total_pro +=$pro;
		$total_tra +=$tra;
		$total_dent +=$dent;
		$total_otro +=$otro;
		$total_umi +=$umi;
		
		$total_boletas += $RSrendGlobal['BOLmonto'];			MONTO TOTAL
		*/




		
		$total_diaCama =0;
		$total_Inter =0;
		$total_exa =0;
		$total_consu =0;
		$total_medi =0;
		$total_pro =0;
		$total_tra =0;
		$total_dent =0;
		$total_otro =0;
		$total_umi =0;
		
		$total_boletas =($total_diaCama+$total_Inter+$total_exa+$total_consu+$total_medi+$total_pro+$total_tra+$total_dent+$total_otro+$total_umi);
		$html.='
		<tr>
			<td>
				<table align="center">							<!-- TOTALES -->
					<tr>
						<td colspan="13">
							<table>
								<tr>
									<td width="5%"></td>
									<td width="12.5%"></td>
									';
										for($i=0;$i<count($arrTotalesBot);$i++){
											$html.='<td width="10%">'.$arrTotalesBot[$i].'</td>';
										}

										$html.='
									
									<td align="right"><strong>'.$objUti->formatDinero($total_boletas).'</strong></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>


		<tr>
			<td style="border-bottom-width:1px;">
			</td>
		</tr>
		<br/>
	</table>';


/*




		$html.='<tr>
			<td>
				<strong>BOLETAS EXENTAS</strong>
			</td>
		</tr>
		<tr>
			<td>
				<table align="center">
					<tr>
						<td colspan="13">
							<table border="1">
								<tr>
									<td width="5%">Boleta</td>
									<td width="12.5%">Paciente</td>
									';
									for($i=0; $i<count($tipos_productos); $i++){
										$html.='<td>'.$tipos_productos[$i]['tip_prod_id'].'</td>';
									}	
									$html.='<td>TOTAL</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>';
		
		//									EDITAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAR
		//									EDITAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAR
		//									EDITAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAR
		//									EDITAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAR
		//									EDITAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAR
		//									EDITAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAR





		$html .='
		<tr>
			<td>
				<table align="center">
					<tr>
						<td colspan="13">
							<table>
								<tr>
									<td width="5%">FOLIO</td>
									<td width="12.5%" align="left">NOMBRE PACIENTE</td>
									<td width="10%">	
										<table align="center">
											<tr>TOTAL CATEGORIA</tr>
										</table>
									</td>
									<td align="right">TOTAL BOLETA</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		';


		$total_diaCamaE =0;
		$total_InterE =0;
		$total_exaE =0;
		$total_consuE =0;
		$total_mediE =0;
		$total_proE =0;
		$total_traE =0;
		$total_dentE =0;
		$total_otroE =0;
		$total_umiE =0;
		
		$total_boletasE =($total_diaCamaE+$total_InterE+$total_exaE+$total_consuE+$total_mediE+$total_proE+$total_traE+$total_dentE+$total_otroE+$total_umiE);
		
		
		$total = $total_boletasE + $total_boletas;
		$html.='
		<tr>
			<td>
				<table align="center">
					<tr>
						<td colspan="13">
							<table>
								<tr>
									<td width="5%"></td>
									<td width="12.5%"></td>
									<td width="10%">
										'.$total_diaCamaE.'												
									</td>
									<td align="right"><strong>'.$objUti->formatDinero($total_boletasE).'</strong></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td style="border-bottom-width:1px;">
			</td>
		</tr>
		<br/>



		<tr>
			<td style="border-top-width:1px;" align="right" width="80%">
			</td>
			<td style="border-top-width:1px;">
				<table align="right">
						<tr>
							<td style="font-size:45px;"><strong>TOTAL:</strong></td>
							<td style="font-size:45px;"><strong>'.$objUti->formatDinero($total).'</strong></td>
						</tr>
				</table>
			</td>
		</tr>
		<br/>
	</table>
';		


*/

















/*
$html .='
<br/><br/><br/><br/>
	<table width="70%">
		<tr>
			<td><strong>NOTA DE CRÉDITO</strong></td>
		</tr>
	</table>
	<table width="70%" border="1">
		<tr>
			<td>
				<table width="100%">	
					<tr>
						<td width="15%">N°Boleta</td>
						<td width="15%">PSS</td>
						<td width="55%">Motivo</td>	
						<td width="15%" align="right">Monto</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>';
	
	while($RSnotaC = mysql_fetch_array($QRnotaC)){
	$motivoN = $RSnotaC['motivo'];
	if($motivoN==null){
		$motivoN = 'SIN ESPECIFICAR';
	}
	else{
		$motivoN = $motivoN;	
	}
	$total_nota += $RSnotaC['monto'];
	$html .='<table width="70%">	
			<tr>
				<td width="15%">'.$RSnotaC['numero'].'</td>
				<td width="15%">'.$RSnotaC['pss'].'</td>
				<td width="55%">'.$motivoN.'</td>
				<td width="15%" align="right">'.$RSnotaC['monto'].'</td>
			</tr>
			';
	}
$html .='
			<tr>
				<td width="15%">&nbsp;</td>
				<td width="70%">&nbsp;</td>
				<td width="15%" align="right"><strong>TOTAL:	'.$objUti->formatearNumero($total_nota).'</strong></td>
			</tr>
			</table>

	<br/><br/><br/><br/>
	<table width="70%">
		<tr>
			<td><strong>NULA</strong></td>
		</tr>
	</table>
	<table width="70%" border="1">
		<tr>
			<td>
				<table width="100%">	
					<tr>
						<td width="15%">N°Boleta</td>
						<td width="70%">Detalle</td>
						<td width="15%" align="right">Monto</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>';
	
	while($RSrendNula = mysql_fetch_array($QRrendNula)){
	$total_nul += $RSrendNula['BOLmonto'];
	$html .='<table width="70%">	
			<tr>
				<td width="15%">'.$RSrendNula['BOLfolio'].'</td>
				<td width="70%">'.$RSrendNula['BOLmotivonula'].'</td>
				<td width="15%" align="right">'.$RSrendNula['BOLmonto'].'</td>
			</tr>
			';
	}
$html .='
			<tr>
				<td width="15%">&nbsp;</td>
				<td width="70%">&nbsp;</td>
				<td width="15%" align="right"><strong>TOTAL:	'.$objUti->formatearNumero($total_nul).'</strong></td>
			</tr>
			</table>
<br/><br/><br/><br/>';
$html .='
	<table width="70%">
		<tr>
			<td><strong>DOCUMENTOS TRANSBANK</strong></td>
		</tr>
	</table>
	<table width="70%" border="1">
		<tr>
			<td>
				<table width="100%">	
					<tr>
						<td width="15%">N°Boleta</td>
						<td width="20%">Código Operación</td>
						<td width="20%">Código Autorización</td>
						<td width="45%" align="right">Monto</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>';
	
	while($RStrans = mysql_fetch_array($QRtrans)){
	$total_trans += $RStrans['BOLmonto'];
	$html .='<table width="70%">	
			<tr>
				<td width="15%">'.$RStrans['BOLfolio'].'</td>
				<td width="20%">'.$RStrans['PAGDEToperacion'].'</td>
				<td width="20%">'.$RStrans['PAGDETautorizacion'].'</td>
				<td width="45%" align="right">'.$RStrans['BOLmonto'].'</td>
			</tr>
			<tr>
				<td width="15%">&nbsp;</td>
				<td width="20%">&nbsp;</td>
				<td width="20%">&nbsp;</td>
				<td width="45%" align="right"><strong>TOTAL:	'.$objUti->formatearNumero($total_trans).'</strong></td>
			</tr>
			</table>
			';
	}	
	
$html .='
<br/><br/><br/><br/>
	<table width="70%">
		<tr>
			<td><strong>DOCUMENTOS CHEQUE</strong></td>
		</tr>
	</table>
	<table width="70%" border="1">
		<tr>
			<td>
				<table width="100%">	
					<tr>
						<td width="15%">N°Boleta</td>
						<td width="20%">Folio</td>
						<td width="20%">Banco</td>
						<td width="45%" align="right">Monto</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>';
	
	while($RScheque = mysql_fetch_array($QRcheque)){
	$total_cheque += $RScheque['BOLmonto'];
	$html .='<table width="70%">	
			<tr>
				<td width="15%">'.$RScheque['BOLfolio'].'</td>
				<td width="20%">'.$RScheque['PAGDETfolio'].'</td>
				<td width="20%">'.$RScheque['banNombre'].'</td>
				<td width="45%" align="right">'.$RScheque['BOLmonto'].'</td>
			</tr>
			<tr>
				<td width="15%">&nbsp;</td>
				<td width="20%">&nbsp;</td>
				<td width="20%">&nbsp;</td>
				<td width="45%" align="right"><strong>TOTAL:	'.$objUti->formatearNumero($total_cheque).'</strong></td>
			</tr>
			</table>
			';
	}	


	*/
	//$efectivo = ($total_boletas + $total_boletasE) - ($total_cheque + $total_trans + $total_dev);

	$html .='
				<table align="right">
					<tr>
						<td style="font-size:45px;" width="91%"><strong>TOTAL EFECTIVO:</strong></td>
						<td style="font-size:45px;" width="9%"><strong>'.$objUti->formatDinero($total).'</strong></td>
					</tr>
				</table>
				<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
				<table align="center">
					<tr>
						<td width="30%">
						</td>
						<td width="60%">
							<table align="center">
								<tr>
									<td style="font-size:30px; border-top-width:1px;" width="30%"><strong>Firma Cajero Recaudación </strong></td>
									<td>&nbsp;</td>
									<td style="font-size:30px; border-top-width:1px;" width="30%"><strong>Firma Cajero Contabilidad</strong></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				
	';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output($nombreUser.'_'.'ArqueoEspontaneo_'.$id_rendicion.'.pdf',$tipoDoc);

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
ftp_put($conn_id, date('Y').'/ARQUEO/'.$nombreUser.'_'.'ArqueoEspontaneo_'.date('d-m-Y').'.pdf', '.'.$nombreUser.'_'.'ArqueoEspontaneo_'.date('d-m-Y').'.pdf', FTP_BINARY);
unlink('.'.$nombreUser.'_'.'ArqueoEspontaneo_'.date('d-m-Y').'.pdf');
?>