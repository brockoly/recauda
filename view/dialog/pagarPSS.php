<?php
  session_start();
  
  require_once('../../class/Conectar.class.php'); $objCon = new Conectar(); 
  require_once('../../class/Util.class.php'); $objUtil = new Util();
  require_once('../../class/Pss.class.php'); $objPss = new Pss();
  require_once('../../class/Paciente.class.php'); $objPac = new Paciente();
  require_once('../../class/Tipo_Producto.class.php'); $objTip_pro = new Tipo_Producto();
  require_once('../../class/Prevision.class.php'); $objPrev = new Prevision();
  require_once('../../class/Tipo_pago.class.php'); $objTipPag = new Tipo_pago();
  
  $objCon->db_connect();
  $objPss->setPss_id($_POST['pss_id']);
  $pss              = $objPss->buscarPss($objCon,"");
  $paciente         = $objPac->getInformacionPaciente($objCon, "", "", $pss[0]['cue_id']);
  $tipoProducto     = $objTip_pro->listarTipoProducto($objCon);
  $detallePSS       = $objPss->verDetallePss($objCon);
  $objTip_pag       = $objTipPag->listarTipoPago($objCon);
  $objCon=null;

  $arrTiposPSS = Array();
  for($i=0; $i<count($detallePSS);$i++){
      $arrTiposPSS[$i] = $detallePSS[$i]['tip_prod_id']; 
  }
  //print_r($_SESSION);
?>
<script type="text/javascript" src="controller/client/js_pagarPSS.js"></script>
<input type="hidden" value="<?=$_POST['pss_id']?>" id="pss_id" />
<br>
<fieldset class="cabezeraDatos"><legend class="cuerpoDatos">Datos PSS N ° <?=$_POST['pss_id'];?></legend>
  <br>
  <?
  $total_programa = 0;
  if(count($detallePSS)>0){ //verifica si hay productos que listar
     for ($i=0; $i<count($tipoProducto); $i++) {//ciclo para recorrer los tipos de productos
      if(in_array($tipoProducto[$i]['tip_prod_id'], $arrTiposPSS)){ 
        ?>
      <center>
      <table width="95%" id="tblValorizacion" border="0">
        <h3><?=strtoupper($tipoProducto[$i][tip_descripcion]);?></h3>
        <tr class="cuerpoDatosTablas">
            <td width="10%">CÓDIGO</td>
            <td width="50%">DESCRIPCIÓN</td>
            <td align="center" width="10%">CANT</td>
            <td align="center" width="15%">V. UNITARIO</td>
            <td align="right" width="15%">V. TOTAL</td>
        </tr>
      <?$subtotal = 0;
      for($a=0; $a<count($detallePSS); $a++){
        if($detallePSS[$a][tip_prod_id]==$tipoProducto[$i][tip_prod_id]){          
      ?>
          <tr>
            <td><?=$detallePSS[$a][pro_id];?></td>
            <td><?=$detallePSS[$a][pro_nom];?></td>
            <td align="left"><input type="text" class="valores" style="text-align: center; border:none; background: none"  id="txtCantidad<?=$detallePSS[$a][pro_id];?>" readonly="readonly" value="<?=$detallePSS[$a][det_proCantidad];?>" /></td>
            <td align="center"><input type="text" class="valores" id="<?=$detallePSS[$a][pro_id];?>" name="txtValor" readonly="readonly" style="text-align:right; border:none; background: none" value="<?=$detallePSS[$a][det_proUnitario];?>" /></td>
            <td align="right"><input type="text" class="valores" style="text-align: right; border:none; background: none" id="txtValorT<?=$detallePSS[$a][pro_id];?>" name="txtValorT<?=$detallePSS[$a][pro_id];?>" readonly="readonly" value="<?=$detallePSS[$a][total];?>" /></td>
          </tr>
          <? $subtotal += $detallePSS[$a][total];
        }
      }$total_programa += $subtotal; ?>
      </table>
      <br/>
      </center>
      <?}
    }
  ?>
<center>
  <table width="95%">
    <tr>
      <td align="right" width="89%"><b>TOTAL FACTURADO: </b></td>
      <td align="right"><input type="text" class="valores" readonly="readonly" style="text-align:right; border:none; background:none" id="txtTotal" value="<?=$total_programa;?>" /> </td>
    </tr>
  </table>
</center>
 <?  }else{ ?>
  <center>
    <table width="100%">
      <tr>
        <td align="center"><label style="color:red !important">SIN PRESTACIONES</label></td>
      </tr>
    </table>
  </center>
  <? }
 
    ?>
  <br/>
</fieldset><br/>
<table width="100%">
  <tr>
    <td width="30%">
      <fieldset class="cabezeraDatos">
        <br/>
        <legend class="cuerpoDatos">Bonos  <img width="20" height="20" id="btnMasBono" src="./include/img/plus.png"></legend>
        <center>
          <table width="90%" border="0">
          <tr>
            <td>PRONTAMENTE</td>
          </tr>
            <!-- <tr align="center">
              <td>ID</td>
              <td>NOMBRE</td>
              <td>VALOR</td>
            </tr>
            <tr align="center">
              <td>1</td>
              <td>Fonasa Ins</td>
              <td>0</td>
            </tr> -->
          </table>
        <center>
        <br/>
      </fieldset>
    </td>
    <td width="70%">
      <fieldset class="cabezeraDatos">
        <br/>
        <legend class="cuerpoDatos">Datos pago</legend>
        <center>
          <table border="0">
            <tr>
              <td >
                <table border="0">
                  <tr class="cuerpoDatosTablas">
                    <td >Tipo Pago</td>
                    <td >Monto a pagar</td>
                    <td >Acción</td>
                    <td align="center" >Total</td>
                  </tr>
                  <tr>
                    <td>
                    <select id="cmbTipoPago">
                      <option value="0">Seleccione...</option>
                      <? for($i=0; $i<count($objTip_pag); $i++){ ?>
                            <option value="<?=$objTip_pag[$i][tip_pag_id]?>"><?=$objTip_pag[$i][tip_pag_descripcion]?></option>
                      <? }?>
                    </select></td>
                    <td><input type="text" class="valores" style="text-align:right;" id="txtMontoPago"></td>
                    <td align="center"><img width="20" height="20" id="bntAgregarPago" style="cursor:pointer;" src="./include/img/plus.png"></td>
                    <td><input type="text" style="border:none; background:none; text-align:center; font-size: 20px;" readonly id="txtTotalPag" value="0"></td>
                  </tr>
                  <tr>
                    <td colspan="4">
                      <table border="0" width="100%" id="tblPagos">
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
              <td align="center"> </td>
            </tr>
          </table>
        </center>
        <br/>
      </fieldset>
    </td>
  </tr>
</table>
<br/>
<br/>
<center>
<input type="button" id="btnPagarPSS" value="Pagar"/>
</center>
<br/>
<input type="hidden" value="<?=$_SESSION['cue_id']?>" id="cue_id">
<input type="hidden" value="<?=$_POST['Paciente']?>" id="Paciente">
<input type="hidden" value="<?=$_POST['CtaCorriente']?>" id="CtaCorriente">
<input type="hidden" value="<?=$_POST['Identificador']?>" id="Identificador">