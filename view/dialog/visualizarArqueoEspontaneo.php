<? 
//session_start();
?>
<iframe id="pss" width="1100" height="900" src="./view/reportes/generarArqueo_PDF.php?pss_id<?=$_POST['pss_id'];?>&tipoArqueo=vista_previa"> </iframe>
<?


//$url = './view/reportes/generarArqueo_PDF.php';

/*
Arqueo: arq_id, 
Productos: listaCategorías
Paciente: nombre completo
Boleta: bol_id, subtotales
Pagos:
*/


//PROBANDO LAS VARIABLES ANTES DE ENVIARLA AL PDF, ASÍ NO SE CAÍA 




/*



require_once('../../class/Tipo_Producto.class.php'); $objTipPro = new Tipo_Producto;
require_once('../../class/Conectar.class.php');  $objCon = new Conectar();
require_once('../../class/Arqueo.class.php'); $objArq = new Arqueo;
require_once('../../class/Boleta.class.php'); $objBol = new Boleta;
require_once('../../class/Pagos.class.php'); $objPag = new Pagos;
require_once('../../class/Util.class.php'); $objUti = new Util;
require_once('../../class/Pss.class.php'); $objPss = new Pss;


$objCon->db_connect();
$usu_nombre = $_SESSION['usuario'][1]['nombre_usuario'];
$tipos_productos = $objTipPro->listarTipoProducto($objCon,'nombre');

//$boletas = $objBol->buscarBoletasArqueo($objCon, $usu_nombre);
$boletas = $objBol->buscarBoletasArqueo($objCon, $usu_nombre);



//LISTA DE TIPOS DE PRODUCTOS EXISTENTES

echo "Tipos de productos: 1: ";
for($i=0; $i<count($tipos_productos); $i++){
	echo $tipos_productos[$i]['tip_descripcion']." - ";
}
echo "<br><br>ID de boletas: ";
for($i=0; $i<count($boletas); $i++){
	echo " id ".$boletas[$i]['bol_id']." - id pss: ".$boletas[$i]['pss_id']." - ";
}
$subtotales=0;






?>
<center>
  		<table width="95%"  border="1">	
  			<tr class="cuerpoDatosTablas">
  				<td width="10%" align="center">BOLETA</td>
  				<td width="20%" align="center">PACIENTE</td>
  		<? 
  		$tamaño=(55/(count($tipos_productos)));  		
  		for ($i=0; $i<count($tipos_productos); $i++) {//ciclo para recorrer los tipos de productos
		?>
				<td  width="<?=$tamaño ?>%" align="center"><?=$tipos_productos[$i][tip_prod_id];?></td>
        
        <?
        }
        ?>
        		<td width="10%" align="center">TOTAL</td>
    		</tr>
        <?

for($a=0; $a<count($boletas); $a++){
	$objPss->setPss_id($boletas[$a]['pss_id']);
	$detallesProductos = $objPss->verDetallePss($objCon);

	$arrTiposPSS = Array();
	for($i=0; $i<count($detallesProductos);$i++){
	    $arrTiposPSS[$i] = $detallesProductos[$i]['tip_prod_id']; 
	}


$total_programa = 0;
for ($i=0; $i<count($tipos_productos); $i++) {//ciclo para recorrer los tipos de productos
		
      if(in_array($tipos_productos[$i]['tip_prod_id'], $arrTiposPSS)){ 
        ?>
    
        
      <?$subtotal = 0;

      
      for($a=0; $a<count($detallesProductos); $a++){
        if($detallesProductos[$a][tip_prod_id]==$tipos_productos[$i][tip_prod_id]){          
      ?>
          <tr>
            <td><?=$detallesProductos[$a][pro_id];?></td>
            <td><?=$detallesProductos[$a][pro_nom];?></td>
            <td align="left"><input type="text" class="valores" style="text-align: center; border:none; background: none"  id="txtCantidad<?=$detallesProductos[$a][pro_id];?>" readonly="readonly" value="<?=$detallesProductos[$a][det_proCantidad];?>" /></td>
            <td align="center"><input type="text" class="valores" id="<?=$detallesProductos[$a][pro_id];?>" name="txtValor" readonly="readonly" style="text-align:right; border:none; background: none" value="<?=$detallesProductos[$a][det_proUnitario];?>" /></td>
            <td align="right"><input type="text" class="valores" style="text-align: right; border:none; background: none" id="txtValorT<?=$detallesProductos[$a][pro_id];?>" name="txtValorT<?=$detallesProductos[$a][pro_id];?>" readonly="readonly" value="<?=$detallesProductos[$a][total];?>" /></td>
          </tr>
          <? $subtotal += $detallesProductos[$a][total];
        }
      }


      $total_programa += $subtotal; ?>
      

      <?}
      
    }
?>
</table>
      <br/>
      </center>
      <?

//ECHOs DE PRUEBA
	$subtotales=0;
	echo "<br><br>BOLETA ID $a: Cantidad Productos: ".count($detallesProductos)."<br>";
	for($b=0; $b<count($detallesProductos); $b++){
		$subtotales+=$detallesProductos[$b]['total'];
		echo " - nº: ".($b+1)." Producto ID: ".($b+1)." Nombre: ".$detallesProductos[$b]['pro_nom']." Cantidad: ".$detallesProductos[$b]['det_proCantidad']." Total: ".$detallesProductos[$b]['total']." Categoría: ".$detallesProductos[$b]['tip_descripcion']."<br>";
	}
	echo "SubTotal boleta: ".$subtotales;


}









$arreglo=array();
$arreglo[0]['uno']='seba';
$arreglo[0]['dos']='sergio';
$arreglo[1]['uno']='elias';
$arreglo[1]['dos']='rodrigo';
$valor=1;
for($i=0;$i<count($arreglo);$i++){
  if(in_array('sebax', $arreglo[$i])==true){
    $valor=0;
  }
}

if($valor==0){
  echo "Victoria";
}else{
  echo "Victoria igual";
}



/**/















































//RESPALDO CODIGOO





/*

echo "<br><br>ID de boletas: ";
for($i=0; $i<count($boletas); $i++){
	echo " id ".$boletas[$i]['bol_id']." - id pss: ".$boletas[$i]['pss_id']." - ";
}
$subtotales=0;
for($a=0; $a<count($boletas); $a++){
	$objPss->setPss_id($boletas[$a]['pss_id']);
	$detallesProductos = $objPss->verDetallePss($objCon);

	$arrTiposPSS = Array();
	for($i=0; $i<count($detallesProductos);$i++){
	    $arrTiposPSS[$i] = $detallesProductos[$i]['tip_prod_id']; 
	}



$total_programa = 0;
for ($i=0; $i<count($tipos_productos); $i++) {//ciclo para recorrer los tipos de productos

      if(in_array($tipos_productos[$i]['tip_prod_id'], $arrTiposPSS)){ 
        ?>
    
      <center>
      <table width="95%" id="tblValorizacion" border="1">
        <h3><?=strtoupper($tipos_productos[$i][tip_descripcion]);?></h3>
        <tr class="cuerpoDatosTablas">
            <td width="10%">CÓDIGO</td>
            <td width="50%">DESCRIPCIÓN</td>
            <td align="center" width="10%">CANT</td>
            <td align="center" width="15%">V. UNITARIO</td>
            <td align="right" width="15%">V. TOTAL</td>
        </tr>
      <?$subtotal = 0;

      
      for($a=0; $a<count($detallesProductos); $a++){
        if($detallesProductos[$a][tip_prod_id]==$tipos_productos[$i][tip_prod_id]){          
      ?>
          <tr>
            <td><?=$detallesProductos[$a][pro_id];?></td>
            <td><?=$detallesProductos[$a][pro_nom];?></td>
            <td align="left"><input type="text" class="valores" style="text-align: center; border:none; background: none"  id="txtCantidad<?=$detallesProductos[$a][pro_id];?>" readonly="readonly" value="<?=$detallesProductos[$a][det_proCantidad];?>" /></td>
            <td align="center"><input type="text" class="valores" id="<?=$detallesProductos[$a][pro_id];?>" name="txtValor" readonly="readonly" style="text-align:right; border:none; background: none" value="<?=$detallesProductos[$a][det_proUnitario];?>" /></td>
            <td align="right"><input type="text" class="valores" style="text-align: right; border:none; background: none" id="txtValorT<?=$detallesProductos[$a][pro_id];?>" name="txtValorT<?=$detallesProductos[$a][pro_id];?>" readonly="readonly" value="<?=$detallesProductos[$a][total];?>" /></td>
          </tr>
          <? $subtotal += $detallesProductos[$a][total];
        }
      }$total_programa += $subtotal; ?>
      </table>
      <br/>
      </center>

      <?}
      
    }


//ECHOs DE PRUEBA
	/*$subtotales=0;
	echo "<br><br>BOLETA ID $a: Cantidad Productos: ".count($detallesProductos)."<br>";
	for($b=0; $b<count($detallesProductos); $b++){
		$subtotales+=$detallesProductos[$b]['total'];
		echo " - nº: ".($b+1)." Producto ID: ".($b+1)." Nombre: ".$detallesProductos[$b]['pro_nom']." Cantidad: ".$detallesProductos[$b]['det_proCantidad']." Total: ".$detallesProductos[$b]['total']." Categoría: ".$detallesProductos[$b]['tip_descripcion']."<br>";
	}
	echo "SubTotal boleta: ".$subtotales;
}

*/


































/*
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