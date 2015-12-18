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
$pdf->SetAutoPageBreak(TRUE, 0);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->setLanguageArray($l);
$pdf->setFontSubsetting(true);
$pdf->SetFont('helvetica', '', 9, '', true);
$pdf->setPrintFooter(false);
//CREA UNA PAGINA
$pdf->AddPage('L', 'A4');

//CARGA DE CLASES Y METODOS

require_once('../../class/Tipo_Producto.class.php'); $objTipPro = new Tipo_Producto;
require_once('../../class/Nota_Credito.class.php');  $objNot = new Nota_Credito();
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
$arq_id = $_GET['arq_id'];
$tipoArqueo = $_GET['tipoArqueo'];
$boletas = Array();
$boletasE = Array();
$anuladas= Array();
//$boletas = $objBol->buscarBoletasArqueo($objCon, $usu_nombre);
if($tipoArqueo == 'vista_previa'){
	$boletas = $objBol->buscarBoletasArqueo($objCon, $usu_nombre,'');
	$boletasE = $objBol->buscarBoletasArqueo($objCon, $usu_nombre,'0');	
	$anuladas=$objBol->buscarBoletasArqueadasNulas($objCon, $usu_nombre);
	$notasCredito=$objNot->buscarNota($objCon, '', $usu_nombre, 'si');
}else{
	$notasCredito=$objNot->buscarNotaArqueadas($objCon, $arq_id);
	$anuladas=$objBol->buscarBoletasArqueoNulas($objCon, $arq_id);
	$boletas = $objBol->buscarBoletasArqueadas($objCon, $arq_id,'');
	$boletasE = $objBol->buscarBoletasArqueadas($objCon, $arq_id,'0');	
}






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
							$nro_arq 			=   'N° '.$arq_id;
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

$arrTotalesBot= Array();


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
	<table width="100%"border="0">
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
$totalBot=0;
$totalBoleta=0;
for($i=0; $i<count($boletas);$i++){
	$objPss->setPss_id($boletas[$i]['pss_id']);
	$detallesProductos = $objPss->verDetallePss($objCon);

	$arrTiposPSS = Array();
	for($a=0; $a<count($detallesProductos);$a++){
	    $arrTiposPSS[$a] = $detallesProductos[$a]['tip_prod_id']; 
	}
	$totalBoletaAux=0;
	for($d=0; $d<count($tipos_productos); $d++){
	$totalcategoriaAux=0;

		for($e=0; $e<count($detallesProductos); $e++){
			if($tipos_productos[$d]['tip_prod_id'] == $detallesProductos[$e]['tip_prod_id']){				
				$totalcategoriaAux+=$detallesProductos[$e]['total'];
			}			
		}
		$totalBoletaAux+=$totalcategoriaAux;
		$totalcategoriaAux=0;
	}
	$porcentaje=(($boletas[$i]['total']*100)/$totalBoletaAux)/100;


			$html .='
			<tr>
				<td>
					<table align="center">
						<tr>
							<td colspan="13">
								<table  border="0">										<!-- DATOS BOLETA -->
									<tr>
										<td width="5%">'.$boletas[$i]['bol_id'].'</td>
										<td width="12.5%" align="left">'.$boletas[$i]['paciente'].'</td>';



										// IMPRESIN CATEGORÍAS
	for($b=0; $b<count($tipos_productos); $b++){
		$totalcategoria=0;
		$totalCate=0;


		for($c=0; $c<count($detallesProductos); $c++){
			if($tipos_productos[$b]['tip_prod_id'] == $detallesProductos[$c]['tip_prod_id']){				
				$totalcategoria+=$detallesProductos[$c]['total'];
			}
		}


		$totalCate=round($totalcategoria*$porcentaje);

		/*if($totalCate!=0){
			if($totalCate<$boletas[$i]['total']){
				$totalCate=$totalCate-($totalCate-$boletas[$i]['total']);
			}else if($totalCate>$boletas[$i]['total']){
				$totalCate=$totalCate+($totalCate-$boletas[$i]['total']);
			}
		}*/



		$html.='<td width="'.$tamañox.'%">'.$totalCate.'</td>';
		$arrTotalesBot[$b]+=$totalCate;
		$totalBoleta+=$totalCate;		
		$totalcategoria=0;
		$totalCate=0;
		
	}
	if($totalBoleta!=0){
			if($totalBoleta>$boletas[$i]['total']){
				$totalBoleta=$totalBoleta-($totalBoleta-$boletas[$i]['total']);
			}else if($totalBoleta<$boletas[$i]['total']){
				$totalBoleta=$totalBoleta+$boletas[$i]['total']-($totalBoleta);
			}
		}
		$totalBot+=$totalBoleta;
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
		*/

		$total_boletas =0;			//MONTO TOTAL
		for($i=0;$i<count($arrTotalesBot);$i++){
			$total_boletas+=$arrTotalesBot[$i];
		}

		$html.='
		<tr>
			<td>
				<table align="center">							<!-- TOTALES -->
					<tr>
						<td colspan="13">
							<table border="0">
								<tr>
									<td width="5%"></td>
									<td width="12.5%"></td>
									';
										if(count($arrTotalesBot)!=0){
										for($i=0;$i<count($arrTotalesBot);$i++){
											$html.='<td width="'.$tamañox.'%">'.$arrTotalesBot[$i].'</td>';
										}
									}else{
										$html.='<td colspan="10" width="'.($tamañox*10).'%"></td>';
									}

										$html.='
									
									<td align="right" width="10%"><strong>'.$objUti->formatDinero($totalBot).'</strong></td>
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
	';



		//									EXENTAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
		//									EXENTAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
		//									EXENTAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
		//									EXENTAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
		//									EXENTAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
		//									EXENTAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA






$arrTotalesBotE= Array();

$html .='
	
		<tr>
			<td>
				<strong>BOLETAS EXENTAS</strong>
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
$totalBotE=0;
$totalBoletaE=0;
for($i=0; $i<count($boletasE);$i++){
	$objPss->setPss_id($boletasE[$i]['pss_id']);
	$detallesProductos = $objPss->verDetallePss($objCon);

	$arrTiposPSS = Array();
	for($a=0; $a<count($detallesProductos);$a++){
	    $arrTiposPSS[$a] = $detallesProductos[$a]['tip_prod_id']; 
	}
	$totalBoletaEAux=0;
	for($d=0; $d<count($tipos_productos); $d++){
	$totalCategoriaEAux=0;

		for($e=0; $e<count($detallesProductos); $e++){
			if($tipos_productos[$d]['tip_prod_id'] == $detallesProductos[$e]['tip_prod_id']){				
				$totalCategoriaEAux+=$detallesProductos[$e]['total'];
			}			
		}
		$totalBoletaEAux+=$totalCategoriaEAux;
		$totalCategoriaEAux=0;
	}
	$porcentajeE=(($boletasE[$i]['total']*100)/$totalBoletaEAux)/100;


			$html .='
			<tr>
				<td>
					<table align="center">
						<tr>
							<td colspan="13">
								<table  border="0">										<!-- DATOS BOLETA -->
									<tr>
										<td width="5%">'.$boletasE[$i]['bol_id'].'</td>
										<td width="12.5%" align="left">'.$boletasE[$i]['paciente'].'</td>';



										// IMPRESIN CATEGORÍAS
	for($b=0; $b<count($tipos_productos); $b++){
		$totalCategoriaE=0;
		$totalCateE=0;


		for($c=0; $c<count($detallesProductos); $c++){
			if($tipos_productos[$b]['tip_prod_id'] == $detallesProductos[$c]['tip_prod_id']){				
				$totalCateEgoriaE+=$detallesProductos[$c]['total'];
			}
		}


		$totalCateE=round($totalCateEgoriaE*$porcentajeE);

		/*if($totalCateE!=0){
			if($totalCateE<$boletasE[$i]['total']){
				$totalCateE=$totalCateE-($totalCateE-$boletasE[$i]['total']);
			}else if($totalCateE>$boletasE[$i]['total']){
				$totalCateE=$totalCateE+($totalCateE-$boletasE[$i]['total']);
			}
		}*/



		$html.='<td width="'.$tamañox.'%">'.$totalCateE.'</td>';
		$arrTotalesBotE[$b]+=$totalCateE;
		$totalBoletaE+=$totalCateE;		
		$totalCateEgoriaE=0;
		$totalCate=0;
		
	}
	if($totalBoletaE!=0){
			if($totalBoletaE>$boletasE[$i]['total']){
				$totalBoletaE=$totalBoletaE-($totalBoletaE-$boletasE[$i]['total']);
			}else if($totalBoletaE<$boletasE[$i]['total']){
				$totalBoletaE=$totalBoletaE+$boletasE[$i]['total']-($totalBoletaE);
			}
		}
		$totalBotE+=$totalBoletaE;
	$html.='<td align="right" width="10%">'.$totalBoletaE.'</td>';
			
			$html.='							
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			';
			$totalBoletaE=0;
			
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
		*/

		$total_boletasE =0;			//MONTO TOTAL
		for($i=0;$i<count($arrTotalesBotE);$i++){
			$total_boletasE+=$arrTotalesBotE[$i];
		}

		$html.='
		<tr>
			<td>
				<table align="center">							<!-- TOTALES -->
					<tr>
						<td colspan="13">
							<table border="0">
								<tr>
									<td width="5%"></td>
									<td width="12.5%"></td>
									';
									if(count($arrTotalesBotE)!=0){
										for($i=0;$i<count($arrTotalesBotE);$i++){
											$html.='<td width="'.$tamañox.'%">'.$arrTotalesBotE[$i].'</td>';
										}
									}else{
										$html.='<td colspan="10" width="'.($tamañox*10).'%"></td>';
									}
										$html.='
									
									
									<td align="right" width="10%"><strong>'.$objUti->formatDinero($totalBotE).'</strong></td>
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
		<tr>
			<td style="border-top-width:1px;" align="right" width="80%">
			</td>
			<td style="border-top-width:1px;">
				<table align="right">
						<tr>
							<td style="font-size:45px;"><strong>TOTAL:</strong></td>
							<td style="font-size:45px;"><strong>'.$objUti->formatDinero($totalBot+$totalBotE).'</strong></td>
						</tr>
				</table>
			</td>
		</tr>
		<br/>
	</table>
';		


$html .='
<br/><br/><br/><br/>
	<table width="70%" border="0">
		<tr>
			<td><strong>NOTA DE CRÉDITO</strong></td>
		</tr>
	</table>
	<table width="70%" border="1">
		<tr>
			<td>
				<table width="100%" border="0">	
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
	$total_nota=0;	
	$html .='<table width="70%" border="0">	';
	for($i=0;$i<count($notasCredito);$i++){
		$html .='
			<tr>
				<td width="15%">'.$notasCredito[$i]['not_id'].'</td>
				<td width="15%">'.$notasCredito[$i]['pss_id'].'</td>';
		if($notasCredito[$i]['not_motivo'] != NULL){
			$html.='<td width="55%">'.$notasCredito[$i]['not_motivo'].'</td>';
		}else{
			$html.='<td width="55%">SIN ESPECIFICAR</td>';
		}
		$html.='<td width="15%" align="right">'.$notasCredito[$i]['not_monto'].'</td>
		</tr>';
		$total_nota+=$notasCredito[$i]['not_monto'];
	}
$html .='
			<tr>
				<td width="15%">&nbsp;</td>
				<td width="70%">&nbsp;</td>
				<td width="15%" align="right"><strong>TOTAL:	'.$objUti->formatDinero($total_nota).'</strong></td>
			</tr>
			</table>

	<br/><br/><br/><br/>';























$html.='	<table width="70%">
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
	$total_anuladas=0;
	
	$html .='<table width="70%" border="0">	';
	for($i=0;$i<count($anuladas);$i++){
		$html .='
			<tr>
				<td width="15%">'.$anuladas[$i]['bol_id'].'</td>';

		if($anuladas[$i]['bol_motivo'] != NULL){
			$html.='<td width="70%">'.$anuladas[$i]['bol_motivo'].'</td>';
		}else{
			$html.='<td width="70%">SIN ESPECIFICAR</td>';
		}
		$html.='<td width="15%" align="right">'.$anuladas[$i]['total'].'</td>
		</tr>';
		$total_anuladas+=$anuladas[$i]['total'];
	}
	
$html .='
			<tr>
				<td width="15%">&nbsp;</td>
				<td width="70%">&nbsp;</td>
				<td width="15%" align="right"><strong>TOTAL:	'.$objUti->formatDinero($total_anuladas).'</strong></td>
			</tr>
			</table>
<br/><br/><br/><br/>';

/*

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
	$total_trans=0;
	
	$html .='<table width="70%">	
			<tr>
				<td width="15%">FOLIO</td>
				<td width="20%">COD TRANSACCION</td>
				<td width="20%">COD AUTORIZACION</td>
				<td width="45%" align="right">MONTO</td>
			</tr>
			<tr>
				<td width="15%">&nbsp;</td>
				<td width="20%">&nbsp;</td>
				<td width="20%">&nbsp;</td>
				<td width="45%" align="right"><strong>TOTAL:	'.$objUti->formatDinero($total_trans).'</strong></td>
			</tr>
			</table>
			';
	
	/*
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
/*
	$html .='
				<table align="right">
					<tr>
						<td style="font-size:45px;" width="91%"><strong>TOTAL EFECTIVO:</strong></td>
						<td style="font-size:45px;" width="9%"><strong>'.$objUti->formatDinero($total).'</strong></td>
					</tr>
				</table>*/
				$html.='
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
$pdf->Output($nombreUser.'_'.'arqueoEspontaneo_'.$arq_id.'.pdf',$tipoDoc);

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
ftp_put($conn_id, date('Y').'/ARQUEO/'.$nombreUser.'_'.'arqueoEspontaneo_'.date('d-m-Y').'.pdf', '.'.$nombreUser.'_'.'arqueoEspontaneo_'.date('d-m-Y').'.pdf', FTP_BINARY);
unlink('.'.$nombreUser.'_'.'arqueoEspontaneo_'.date('d-m-Y').'.pdf');
?>