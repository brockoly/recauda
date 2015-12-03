<? if(!isset($_SESSION)) session_start();

error_reporting(0);
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
$pdf->SetMargins(3, 5, 3);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetAutoPageBreak(TRUE, 15);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->setLanguageArray($l);
$pdf->setFontSubsetting(true);
$pdf->SetFont('helvetica', '', 8, '', true);
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
$tipos_productos = $objTipPro->listarTipoProducto($objCon);

//$boletas = $objBol->buscarBoletasArqueo($objCon, $usu_nombre);
$boletas = $objBol->buscarBoletasArqueo($objCon, $usu_nombre);



//LISTA DE TIPOS DE PRODUCTOS EXISTENTES
/*
echo "Tipos de productos: 1: ";
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
$mensajeDoc = '<label style="color:red;">Este documento NO es valido para rendir</label>';
$tipoDoc ="I";

//CONDICION DE PDF 
/*
switch($tipoArqueo){
	case 'vista_previa'	: 	$textoPrev 			=   'VISTA PREVIA';
							$mensajeTitulo 		=   '<strong>ARQUEO ESPONTANEO <br> '.$textoPrev.'</strong>';
							$nombreUser 		=   'Nombre: '.$nombreUsuario;
							$mensajeDoc 		=   '<label style="color:red;">Este documento NO es valido para rendir</label>';
							$QRrendGlobal 		= 	$objArqueo->arqueoEspontaneoNormal($link, $usuario, $id_rendicion);
							$QRrendGlobalExe 	= 	$objArqueo->arqueoEspontaneoExe($link, $usuario, $id_rendicion);
							$QRcheque        	= 	$objArqueo->arqueoEspontaneoCheque($link, $usuario, $id_rendicion);
							$QRtrans         	= 	$objArqueo->arqueoEspontaneoTransbank($link, $usuario, $id_rendicion);
							$QRnotaC 			= 	$objArqueo->arqueoEspNota($link, $usuario, $id_rendicion);
							$QRrendNula 		=	$objArqueo->arqueoEspontaneoNula($link, $usuario);
							$tipoDoc 			=   "I";
							break;

	case 'generar_arqueo':  $id_rendicion 		= 	$objArqueo->InsertarRendicion($link, $usuario);
							$nro_arq 			=   'N° '.$id_rendicion;
							$mensajeTitulo 		=   '<strong>ARQUEO ESPONTANEO <br> '.$nro_arq.'</strong>';
							$mensajeDoc 		=   '<label style="color:green;">Documento valido para rendir</label>';
							$updateRend			=	$objArqueo->updateArqueoEspontaneoNormal($link, $id_rendicion, $usuario);
							$QRrendGlobal 		= 	$objArqueo->arqueoEspontaneoNormal($link, $usuario, $id_rendicion);
							$QRrendGlobalExe 	= 	$objArqueo->arqueoEspontaneoExe($link, $usuario, $id_rendicion);
							$QRcheque        	= 	$objArqueo->arqueoEspontaneoCheque($link, $usuario, $id_rendicion);
							$QRtrans         	= 	$objArqueo->arqueoEspontaneoTransbank($link, $usuario, $id_rendicion);
							$QRnotaC 			= 	$objArqueo->arqueoEspNota($link, $usuario, $id_rendicion);
							$QRrendNula 		=	$objArqueo->arqueoEspontaneoNula($link, $usuario, $id_rendicion);
							$tipoDoc 			= 	"FI";
							break;
}
*/
//TABLA DE CONTENIDO HTML
$html = '
<table width="100%">
	<tr>
		<td width="40%" align="left"><img src="../../css/img/logo_regional.jpg" width="130" height="120" /></td>
		<td align="center" style="font-size:10;">
		<table>
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
		<td height="10" width="27%" align="right" style="font-size:10;">Arica, '.date('d-m-Y').', '.$objUtil->getHoraBD().' <br/>'.$mensajeDoc.'</td>
	</tr>
</table>
<br/>
<br/>';

$html .='
<table width="100%">
	<tr>
		<td width="30%">&nbsp;</td>
		<td width="70%">
			<table>
				<tr>
					<td>Día cama</td>
					<td>Intervención</td>
					<td>Examenes</td>
					<td>Consultas</td>
					<td>Medicamento</td>
					<td>Prótesis</td>
					<td>Traslado</td>
					<td>Dental</td>
					<td>Otros Ing.</td>
					<td>U.M.I.</td>
				</tr>	
				<tr>
					<td>4310101</td>
					<td>4310102</td>
					<td>4310103</td>
					<td>4310104</td>
					<td>4310105</td>
					<td>4310106</td>
					<td>4310107</td>
					<td>4310108</td>
					<td>4310199</td>
					<td>6310115</td>
				</tr>	
			</table>
		</td>
	</tr>
</table><br/><br/>';
$html .='
	<table>
		<tr>
			<td>
				<strong>BOLETAS DE RECAUDACION</strong>
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
									<td width="10%">	
										<table align="center">
											<tr>
												<td colspan="2" >4310101</td>
											</tr>
											<tr>
												<td>01</td>
												<td align="right">04</td>
											</tr>
										</table>
									</td>
									<td width="10%">
										<table align="center">
											<tr>
												<td colspan="2" >4310102</td>
											</tr>
											<tr>
												<td>01</td>
												<td align="right">04</td>
											</tr>
										</table>
									</td>
									<td width="10%">
										<table align="center">
											<tr>
												<td colspan="2" >4310103</td>
											</tr>
											<tr>
												<td>01</td>
												<td align="right">04</td>
											</tr>
										</table>
									</td>
									<td width="10%">
										<table align="center">
											<tr>
												<td colspan="2" >4310104</td>
											</tr>
											<tr>
												<td>01</td>
												<td align="right">04</td>
											</tr>
										</table>
									</td>
									<td width="10%">
										<table align="center">
											<tr>
												<td colspan="2" >4310105</td>
											</tr>
											<tr>
												<td>01</td>
												<td align="right">04</td>
											</tr>
										</table>
									</td>
									<td width="5%">4310106</td>
									<td width="5%">4310107</td>
									<td width="5%">4310108</td>
									<td width="5%">4310199</td>
									<td width="5%">6310115</td>
									<td>TOTAL</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>';
		while($RSrendGlobal = mysql_fetch_array($QRrendGlobal)){
		$html .='
		<tr>
			<td>
				<table align="center">
					<tr>
						<td colspan="13">
							<table>
								<tr>
									<td width="5%">'.$RSrendGlobal['BOLfolio'].'</td>
									<td width="12.5%" align="left">'.$RSrendGlobal['nombre_completo'].'</td>
									<td width="10%">	
										<table align="center">
											<tr>';
											if($RSrendGlobal['DETprevision']>=0 && $RSrendGlobal['DETprevision']<=3){
													$diaCamaBen = $RSrendGlobal['item4310101'];
													$html .='
															<td align="right">0</td>
															<td align="right">'.$diaCamaBen.'</td>';
												}else {
													$diaCama = $RSrendGlobal['item4310101'];
														$html .='
																<td align="right">'.$diaCama.'</td>
																<td align="right">0</td>';	
													}
											$html .='</tr>
										</table>
									</td>
									<td width="10%">
										<table align="center">
											<tr>';
											if($RSrendGlobal['DETprevision']>=0 && $RSrendGlobal['DETprevision']<=3){
													$interBen = $RSrendGlobal['item4310102'];
													$html .='
															<td align="right">0</td>
															<td align="right">'.$interBen.'</td>';
												}else {
														$inter = $RSrendGlobal['item4310102'];
														$html .='
																<td align="right">'.$inter.'</td>
																<td align="right">0</td>';	
													}
											$html .='</tr>
										</table>
									</td>
									<td width="10%">
										<table align="center">
											<tr>';
											if($RSrendGlobal['DETprevision']>=0 && $RSrendGlobal['DETprevision']<=3){
													$exaBen = $RSrendGlobal['item4310103'];
													$html .='
															<td align="right">0</td>
															<td align="right">'.$exaBen.'</td>';
												}else {
														$exa = $RSrendGlobal['item4310103'];
														$html .='
																<td align="right">'.$exa.'</td>
																<td align="right">0</td>';	
													}
											$html .='</tr>
										</table>
									</td>
									<td width="10%">
										<table align="center">
											<tr>';
											if($RSrendGlobal['DETprevision']>=0 && $RSrendGlobal['DETprevision']<=3){
													$consu_ben = $RSrendGlobal['item4310104'];
													$html .='
															<td align="right">0</td>
															<td align="right">'.$consu_ben.'</td>';
												}else {
														$consu = $RSrendGlobal['item4310104'];
														$html .='
																<td align="right">'.$consu.'</td>
																<td align="right">0</td>';	
													}
											$html .='</tr>
										</table>
									</td>
									<td width="10%">
										<table align="center">
											<tr>';
											if($RSrendGlobal['DETprevision']>=0 && $RSrendGlobal['DETprevision']<=3){
													$medi_ben = $RSrendGlobal['item4310105'];
													$html .='
															<td align="right">0</td>
															<td align="right">'.$medi_ben.'</td>';
												}else {
														$medi = $RSrendGlobal['item4310105'];
														$html .='
																<td align="right">'.$medi.'</td>
																<td align="right">0</td>';	
													}
											$html .='</tr>
										</table>
									</td>';
									if($RSrendGlobal['item4310106'] == NULL){
											$html .='
													<td width="5%" align="right">0</td>';
									}else {
											$pro = $RSrendGlobal['item4310106']; 
											$html .='
													<td width="5%" align="right">'.$pro.'</td>';	
									}
									if($RSrendGlobal['item4310107'] == NULL){
											$html .='
													<td width="5%" align="right">0</td>';
									}else {
											$tra = $RSrendGlobal['item4310107']; 
											$html .='
													<td width="5%" align="right">'.$tra.'</td>';	
									}
									if($RSrendGlobal['item4310108'] == NULL){
											$html .='
													<td width="5%" align="right">0</td>';
									}else {
											$dent = $RSrendGlobal['item4310108']; 
											$html .='
													<td width="5%" align="right">'.$dent.'</td>';	
									}
									if($RSrendGlobal['item4310106'] == NULL){
											$html .='
													<td width="5%" align="right">0</td>';
									}else {
											$otro = $RSrendGlobal['item4310199']; 
											$html .='
													<td width="5%" align="right">'.$otro.'</td>';	
									}
									if($RSrendGlobal['item4310106'] == null){
											$html .='
													<td width="5%" align="right">0</td>';
									}else {
											$umi = $RSrendGlobal['item4310115']; 
											$html .='
													<td width="5%" align="right">'.$umi.'</td>';	
									}

									$html .='<td align="right">'.$RSrendGlobal['BOLmonto'].'</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		';
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
		
		$total_boletas += $RSrendGlobal['BOLmonto'];
		}
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
										<table align="center">
											<tr>
												<td align="right">'.$total_diaCama.'</td>
												<td align="right">'.$total_diaCamaBen.'</td>
											</tr>
										</table>
									</td>
									<td width="10%">
										<table align="center">
											<tr>
												<td align="right">'.$total_Inter.'</td>
												<td align="right">'.$total_InterBen.'</td>
											</tr>
										</table>
									</td>
									<td width="10%">
										<table align="center">
											<tr>
												<td align="right">'.$total_exa.'</td>
												<td align="right">'.$total_exaBen.'</td>
											</tr>
										</table>
									</td>
									<td width="10%">
										<table align="center">
											<tr>
												<td align="right">'.$total_consu.'</td>
												<td align="right">'.$total_consuBen.'</td>
											</tr>
										</table>
									</td>
									<td width="10%">
										<table align="center">
											<tr>
												<td align="right">'.$total_medi.'</td>
												<td align="right">'.$total_mediBen.'</td>
											</tr>
										</table>
									</td>
									<td width="5%" align="right">'.$total_pro.'</td>
									<td width="5%" align="right">'.$total_tra.'</td>
									<td width="5%" align="right">'.$total_dent.'</td>
									<td width="5%" align="right">'.$total_otro.'</td>
									<td width="5%" align="right">'.$total_umi.'</td>
									<td align="right"><strong>'.$objUtil->formatearNumero($total_boletas).'</strong></td>
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
									<td width="10%">	
										<table align="center">
											<tr>
												<td colspan="2" >4310101</td>
											</tr>
											<tr>
												<td>01</td>
												<td align="right">04</td>
											</tr>
										</table>
									</td>
									<td width="10%">
										<table align="center">
											<tr>
												<td colspan="2" >4310102</td>
											</tr>
											<tr>
												<td>01</td>
												<td align="right">04</td>
											</tr>
										</table>
									</td>
									<td width="10%">
										<table align="center">
											<tr>
												<td colspan="2" >4310103</td>
											</tr>
											<tr>
												<td>01</td>
												<td align="right">04</td>
											</tr>
										</table>
									</td>
									<td width="10%">
										<table align="center">
											<tr>
												<td colspan="2" >4310104</td>
											</tr>
											<tr>
												<td>01</td>
												<td align="right">04</td>
											</tr>
										</table>
									</td>
									<td width="10%">
										<table align="center">
											<tr>
												<td colspan="2" >4310105</td>
											</tr>
											<tr>
												<td>01</td>
												<td align="right">04</td>
											</tr>
										</table>
									</td>
									<td width="5%">4310106</td>
									<td width="5%">4310107</td>
									<td width="5%">4310108</td>
									<td width="5%">4310199</td>
									<td width="5%">6310115</td>
									<td>TOTAL</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>';		
		while($RSrendGlobalExe = mysql_fetch_array($QRrendGlobalExe)){
		$html .='
		<tr>
			<td>
				<table align="center">
					<tr>
						<td colspan="13">
							<table>
								<tr>
									<td width="5%">'.$RSrendGlobalExe['BOLfolio'].'</td>
									<td width="12.5%">'.$RSrendGlobalExe['nombre_completo'].'</td>
									<td width="10%">	
										<table align="center">
											<tr>';
											if($RSrendGlobalExe['DETprevision']>=0 && $RSrendGlobalExe['DETprevision']<=3){
													$diaCamaBenE = $RSrendGlobalExe['item4310101'];
													$html .='
															<td align="right">0</td>
															<td align="right">'.$diaCamaBenE.'</td>';
												}else {
													$diaCamaE = $RSrendGlobalExe['item4310101'];
														$html .='
																<td align="right">'.$diaCamaE.'</td>
																<td align="right">0</td>';	
													}
											$html .='</tr>
										</table>
									</td>
									<td width="10%">
										<table align="center">
											<tr>';
											if($RSrendGlobalExe['DETprevision']>=0 && $RSrendGlobalExe['DETprevision']<=3){
													$interBenE = $RSrendGlobalExe['item4310102'];
													$html .='
															<td align="right">0</td>
															<td align="right">'.$interBenE.'</td>';
												}else {
														$interE = $RSrendGlobalExe['item4310102'];
														$html .='
																<td align="right">'.$interE.'</td>
																<td align="right">0</td>';	
													}
											$html .='</tr>
										</table>
									</td>
									<td width="10%">
										<table align="center">
											<tr>';
											if($RSrendGlobalExe['DETprevision']>=0 && $RSrendGlobalExe['DETprevision']<=3){
													$exaBenE = $RSrendGlobalExe['item4310103'];
													$html .='
															<td align="right">0</td>
															<td align="right">'.$exaBenE.'</td>';
												}else {
														$exaE = $RSrendGlobalExe['item4310103'];
														$html .='
																<td align="right">'.$exaE.'</td>
																<td align="right">0</td>';	
													}
											$html .='</tr>
										</table>
									</td>
									<td width="10%">
										<table align="center">
											<tr>';
											if($RSrendGlobalExe['DETprevision']>=0 && $RSrendGlobalExe['DETprevision']<=3){
													$consu_benE = $RSrendGlobal['item4310104'];
													$html .='
															<td align="right">0</td>
															<td align="right">'.$consu_benE.'</td>';
												}else {
														$consuE = $RSrendGlobalExe['item4310104'];
														$html .='
																<td align="right">'.$consuE.'</td>
																<td align="right">0</td>';	
													}
											$html .='</tr>
										</table>
									</td>
									<td width="10%">
										<table align="center">
											<tr>';
											if($RSrendGlobalExe['DETprevision']>=0 && $RSrendGlobalExe['DETprevision']<=3){
													$medi_benE = $RSrendGlobalExe['item4310105'];
													$html .='
															<td align="right">0</td>
															<td align="right">'.$medi_benE.'</td>';
												}else {
														$mediE = $RSrendGlobalExe['item4310105'];
														$html .='
																<td align="right">'.$mediE.'</td>
																<td align="right">0</td>';	
													}
											$html .='</tr>
										</table>
									</td>';
									if($RSrendGlobal['item4310106'] == NULL){
											$html .='
													<td width="5%" align="right">0</td>';
									}else {
											$proE = $RSrendGlobal['item4310106']; 
											$html .='
													<td width="5%" align="right">'.$proE.'</td>';	
									}
									if($RSrendGlobal['item4310107'] == NULL){
											$html .='
													<td width="5%" align="right">0</td>';
									}else {
											$traE = $RSrendGlobal['item4310107']; 
											$html .='
													<td width="5%" align="right">'.$traE.'</td>';	
									}
									if($RSrendGlobal['item4310108'] == NULL){
											$html .='
													<td width="5%" align="right">0</td>';
									}else {
											$dentE = $RSrendGlobal['item4310108']; 
											$html .='
													<td width="5%" align="right">'.$dentE.'</td>';	
									}
									if($RSrendGlobal['item4310106'] == NULL){
											$html .='
													<td width="5%" align="right">0</td>';
									}else {
											$otroE = $RSrendGlobal['item4310199']; 
											$html .='
													<td width="5%" align="right">'.$otroE.'</td>';	
									}
									if($RSrendGlobal['item4310106'] == NULL){
											$html .='
													<td width="5%" align="right">0</td>';
									}else {
											$umiE = $RSrendGlobal['item4310115']; 
											$html .='
													<td width="5%" align="right">'.$umiE.'</td>';	
									}

									$html .='<td align="right">'.$RSrendGlobalExe['BOLmonto'].'</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		';
		$total_diaCamaBenE +=$diaCamaBenE;
		$total_diaCamaE +=$diaCamaE;
		$total_InterBenE +=$interBenE;
		$total_InterE +=$interE;
		$total_exaBenE +=$exaBenE;
		$total_exaE +=$exaE;
		$total_consuBenE +=$consu_benE;
		$total_consuE +=$consuE;
		$total_mediBenE +=$medi_benE;
		$total_mediE +=$mediE;
		$total_proE +=$proE;
		$total_traE +=$traE;
		$total_dentE +=$dentE;
		$total_otroE +=$otroE;
		$total_umiE +=$umiE;
		
		$total_boletasE += $RSrendGlobalExe['BOLmonto'];
		}
		
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
										<table align="center">
											<tr>
												<td align="right">'.$total_diaCamaE.'</td>
												<td align="right">'.$total_diaCamaBenE.'</td>
											</tr>
										</table>
									</td>
									<td width="10%">
										<table align="center">
											<tr>
												<td align="right">'.$total_InterE.'</td>
												<td align="right">'.$total_InterBenE.'</td>
											</tr>
										</table>
									</td>
									<td width="10%">
										<table align="center">
											<tr>
												<td align="right">'.$total_exaE.'</td>
												<td align="right">'.$total_exaBenE.'</td>
											</tr>
										</table>
									</td>
									<td width="10%">
										<table align="center">
											<tr>
												<td align="right">'.$total_consuE.'</td>
												<td align="right">'.$total_consuBenE.'</td>
											</tr>
										</table>
									</td>
									<td width="10%">
										<table align="center">
											<tr>
												<td align="right">'.$total_mediE.'</td>
												<td align="right">'.$total_mediBenE.'</td>
											</tr>
										</table>
									</td>
									<td width="5%" align="right">'.$total_proE.'</td>
									<td width="5%" align="right">'.$total_traE.'</td>
									<td width="5%" align="right">'.$total_dentE.'</td>
									<td width="5%" align="right">'.$total_otroE.'</td>
									<td width="5%" align="right">'.$total_umiE.'</td>
									<td align="right"><strong>'.$objUtil->formatearNumero($total_boletasE).'</strong></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		
		
		<tr>
			<td style="border-top-width:1px;" align="right" width="80%">
			</td>
			<td style="border-top-width:1px;">
				<table align="right">
						<tr>
							<td style="font-size:45px;"><strong>TOTAL:</strong></td>
							<td style="font-size:45px;"><strong>'.$objUtil->formatearNumero($total).'</strong></td>
						</tr>
				</table>
			</td>
		</tr>
		<br/>
	</table>
';		

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
				<td width="15%" align="right"><strong>TOTAL:	'.$objUtil->formatearNumero($total_nota).'</strong></td>
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
				<td width="15%" align="right"><strong>TOTAL:	'.$objUtil->formatearNumero($total_nul).'</strong></td>
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
				<td width="45%" align="right"><strong>TOTAL:	'.$objUtil->formatearNumero($total_trans).'</strong></td>
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
				<td width="45%" align="right"><strong>TOTAL:	'.$objUtil->formatearNumero($total_cheque).'</strong></td>
			</tr>
			</table>
			';
	}	
	$efectivo = ($total_boletas + $total_boletasE) - ($total_cheque + $total_trans + $total_dev);
	$html .='
				<table align="right">
					<tr>
						<td style="font-size:45px;" width="91%"><strong>TOTAL EFECTIVO:</strong></td>
						<td style="font-size:45px;" width="9%"><strong>'.$objUtil->formatearNumero($efectivo).'</strong></td>
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
//Print text using writeHTMLCell()
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output($usuario.'_'.'ArqueoEspontaneo_'.$id_rendicion.'.pdf',$tipoDoc);


/*DEFINE ('FTP_USER','recnet'); 
DEFINE ('FTP_PASS','recnet');
$path = date('Y')."/ARQUEO/";
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
ftp_put($conn_id, date('Y').'/ARQUEO/'.$nombreUsuario.'_'.'ArqueoEspontaneo_'.date('d-m-Y').'.pdf', '.'.$nombreUsuario.'_'.'ArqueoEspontaneo_'.date('d-m-Y').'.pdf', FTP_BINARY);
unlink('.'.$nombreUsuario.'_'.'ArqueoEspontaneo_'.date('d-m-Y').'.pdf');*/

?>