<?php
  session_start();
  
  require_once('../../class/Conectar.class.php'); $objCon = new Conectar(); 
  require_once('../../class/Util.class.php'); $objUtil = new Util();
  require_once('../../class/Pss.class.php'); $objPss = new Pss();
  require_once('../../class/Paciente.class.php'); $objPac = new Paciente();
  require_once('../../class/Tipo_Producto.class.php'); $objTip_pro = new Tipo_Producto();
  
  $objCon->db_connect();
  $objPss->setPss_id($_POST['pss_id']);
  $pss=$objPss->buscarPss($objCon,"");
  $paciente=$objPac->getInformacionPaciente($objCon, "", "", $pss[0]['cue_id']);
  $tipoProducto=  $objTip_pro->listarTipoProducto($objCon);
  $detallePSS   = $objPss->verDetallePss($objCon);

  $objCon=null;
?>
<script type="text/javascript" src="controller/client/js_editarPss.js"></script>
<fieldset class="cabezeraDatos"><legend class="cuerpoDatos">Datos Paciente</legend>
   <br><table width="100%">
        <tr>
            <td width="10%" align="center"><b>N ° IDENTIFICACIÓN:</b> <? if($paciente[0]['nac_id']==1){ echo $objUtil->formatRut($paciente[0]['Identificador']); }else{ echo $paciente[0]['Identificador'];} ?> </td>  
            <td width="10%" align="center"><b>NOMBRES:</b> <?=$paciente[0]['Nombre']?></td>
            <td width="10%" align="center"><b>A. PATERNO:</b> <?=$paciente[0]['Apellido_Paterno']?></td>
            <td width="10%" align="center"><b>A. MATERNO:</b> <?=$paciente[0]['Apellido_Materno']?></td> 
            <td width="10%" align="center"><b>FECHA NACIMIENTO:</b> <?=$objUtil->cambiarfecha_mysql_a_normal($paciente[0]['fecha_nac'])?></td>
        </tr>
    </table><br>
</fieldset><br>

<fieldset class="cabezeraDatos"><legend class="cuerpoDatos">Datos PSS N ° <?=$_POST['pss_id'];?></legend>
  <br>
  <?
  $total_programa = 0;
  for ($i=0; $i<count($tipoProducto); $i++) {
    for($a=0; $a<count($detallePSS); $a++){
      if($detallePSS[$a][tip_prod_id]==$tipoProducto[$i][tip_prod_id]){
  ?>
      <table width="100%" cellpadding="1" style="font-size:8;" border="0">
        <tr>
          <td align="center" style="border-bottom-width:1px;"><h3><?=strtoupper($tipoProducto[$i][tip_descripcion]);?></h3></td>
        </tr>
        <tr>
          <td style="border-bottom-width:1px;" width="10%">CÓDIGO</td>
          <td style="border-bottom-width:1px;" width="50%">DESCRIPCIÓN</td>
          <td style="border-bottom-width:1px;" align="center" width="10%">CANT</td>
          <td style="border-bottom-width:1px;" align="right" width="15%">V. UNITARIO</td>
          <td style="border-bottom-width:1px;" align="right" width="15%">V. TOTAL</td>
        </tr>

        <tr>
          <td><?=$detallePSS[$a][pro_id];?></td>
          <td><?=$detallePSS[$a][pro_nom];?></td>
          <td align="left"><?=$detallePSS[$a][det_proCantidad];?></td>
          <td align="center"><?=$detallePSS[$a][det_proUnitario];?></td>
          <td align="right"><?=$detallePSS[$a][total];?></td>
        </tr>

        <? $subtotal += $detallePSS[$a][total]; ?>
        <tr>
          <td style="border-top-width:1px;" align="right" colspan="6"><b>SUBTOTAL</b></td>
          <td style="border-top-width:1px;" align="right"><?=$subtotal;?></td>
        </tr>
      </table>
      <?
      }
    }
  }
$total_programa += $subtotal;
    ?>
  <br>
</fieldset><br>