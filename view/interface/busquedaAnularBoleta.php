<?php
	require_once('../../class/Conectar.class.php');
	require_once('../../class/Util.class.php');
	require_once('../../class/Boleta.class.php');
	$objCon = new Conectar(); 
	$objUtil = new Util(); 
	$objBol = new Boleta();
	$objCon->db_connect();	
	$datos=$objBol->buscarAnularBoleta($objCon, $_POST['filtro']);
	$i=0;
	$objCon=null;
	$tiempoRestante = $objUtil->diferenciaTiempo($datos[$i]['bol_fecha'], $datos[$i]['bol_hora']);
?>
<script type="text/javascript" src="controller/client/js_busquedaAnularBoleta.js"></script>
<!--<input type="hidden" value="<?//=$objUtil->diferenciaTiempo($datos[$i]['bol_fecha'], $datos[$i]['bol_hora']);?> "/>-->

<br><br>
<center>
<div style="width: 70%;">
	<table width="100%"class="display" id="tabAnularBoleta" border="0">
        <thead>
            <tr>
              <th  align="center">N° folio</th>	              
              <th  align="center">Paciente asociado</th>
              <th  align="center">Cajero</th>
              <th  align="center">Estado boleta</th>
              <th  align="center">Fecha emisión</th>
              <th  align="center">Tiempo restante</th>
              <th  align="center">Opción</th>
            </tr>
        </thead>
       <tr>
          <td align="center"><?=$datos[$i]['bol_id'];?></td>
          <td align="center"><?=$objUtil->formatRut($datos[$i]['per_id']);?></td>
          <td align="center"><?=$datos[$i]['nombre'];?></td>
          <td align="center"><?=$datos[$i]['est_descripcion'];?></td>
          <td align="center"><?=$objUtil->cambiarfecha_mysql_a_normal($datos[$i]['bol_fecha']);?></td>	              	              
          <!--<td align="center" id="tdTiempo"><label id="lblTime"></label></td>-->
          <td align="center"><?=$tiempoRestante;?></td>
          <td align="center" ><b><? if($tiempoRestante!="00:00:00"){?> <img class="anularBoleta" id="anularBoleta" src="./include/img/Delete.png" width="18" height="18" style="cursor: pointer;"> <?}else{echo "Anulación expirada.";}?></b></td>
        </tr>
    </table>    
</div>
</center>