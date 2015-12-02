<?php
  session_start();
  
  require_once('../../class/Conectar.class.php'); $objCon = new Conectar(); 
  require_once('../../class/Util.class.php'); $objUtil = new Util();
  require_once('../../class/Pss.class.php'); $objPss = new Pss();
  require_once('../../class/Paciente.class.php'); $objPac = new Paciente();
  require_once('../../class/Tipo_Producto.class.php'); $objTip_pro = new Tipo_Producto();
  require_once('../../class/Prevision.class.php'); $objPrev = new Prevision();
  
  $objCon->db_connect();
  $objPss->setPss_id($_POST['pss_id']);

  $pss              = $objPss->buscarPss($objCon,"");
  $paciente         = $objPac->getInformacionPaciente($objCon, "", "", $pss[0]['cue_id']);
  $tipoProducto     = $objTip_pro->listarTipoProducto($objCon);
  $detallePSS       = $objPss->verDetallePss($objCon);
  $objPrev->setPrevision($paciente[0]['prevision_id'],'');
  $instituciones    = $objPrev->obtenerInstitucionesPrevision($objCon);
  $objCon=null;

  $arrTiposPSS = Array();
  for($i=0; $i<count($detallePSS);$i++){
      $arrTiposPSS[$i] = $detallePSS[$i]['tip_prod_id']; 
  }
 
?>
<script type="text/javascript" src="controller/client/js_valorizarPSS.js"></script>
<fieldset class="cabezeraDatos"><legend class="cuerpoDatos">Datos Paciente</legend>
<input type="hidden" value="<?=$paciente[0]['prevision_id']?>" id="txtPrevisionId" />
<input type="hidden" value="<?=$_POST['pss_id']?>" id="pss_id" />
   <br><table width="100%" border="0">
        <tr>
            <td width="10%" align="left"><b>N ° IDENTIFICACIÓN:</b> <? if($paciente[0]['nac_id']==1){ echo $objUtil->formatRut($paciente[0]['Identificador']); }else{ echo $paciente[0]['Identificador'];} ?> </td>  
            <td width="10%" align="left"><b>NOMBRES:</b> <?=$paciente[0]['Nombre']?></td>
            <td width="10%" align="left"><b>A. PATERNO:</b> <?=$paciente[0]['Apellido_Paterno']?></td>
            <td width="10%" align="left"><b>A. MATERNO:</b> <?=$paciente[0]['Apellido_Materno']?></td> 
            <td width="10%" align="left"><b>FECHA NACIMIENTO:</b> <?=$objUtil->cambiarfecha_mysql_a_normal($paciente[0]['fecha_nac'])?></td>
        </tr>
        <tr>
            <td width="10%" align="left" id="txtPrevision"><b>PREVISIÓN:</b>  <?=$paciente[0]['pre_nombre']?></td>  
            <td width="10%" align="left"><b>Instituciones: </b>
              <select id="cmbInstitucionVal" name="cmbInstitucionVal">
                <option value="0">Seleccione Inst...</option>
                <?
                if(count($instituciones)>0){
                  for($i=0;$i<count($instituciones);$i++){ ?>
                     <option value="<?=$instituciones[$i][ins_id]?>"><?=$instituciones[$i][ins_nombre]?></option>
                  <?}
                }else{ ?>
                  <option>Sin datos</option>
                  <? } ?>
                  
              </select>
            </td>
            <td width="10%" align="left"></td>
            <td width="10%" align="left"></td> 
            <td width="10%" align="left"></td>
        </tr>
    </table><br>
</fieldset><br>
<table width="100%">
  <tr>
    <td width="5%"></td>
    <td width="50%">
      
    </td>
    <td width="15%" align="right">
      <img title="Editar Tipo Producto" id="imgCandado" class="candadoCerrado" width="20px" height="30px" src="" onclick="" style="cursor: pointer;')"/>
        &nbsp;&nbsp;&nbsp;
    </td>
  </tr>
</table>
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
<center>
<input type="button" id="btnGuardarValorizacion" value="Guardar"/>
<input type="button" id="btnGuardarVCambEsta" value="Guardar Y Cambiar Estado"/>
</center>
<br/>
<input type="hidden" value="<?=$_SESSION['cue_id']?>" id="cue_id">
<input type="hidden" value="<?=$_POST['Paciente']?>" id="Paciente">
<input type="hidden" value="<?=$_POST['CtaCorriente']?>" id="CtaCorriente">
<input type="hidden" value="<?=$_POST['Identificador']?>" id="Identificador">