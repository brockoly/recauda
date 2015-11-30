<?php
  session_start();
  
  require_once('../../class/Conectar.class.php');
  require_once('../../class/Util.class.php');
  require_once('../../class/Pss.class.php');
  require_once('../../class/Cuenta_Corriente.class.php');
  require_once('../../class/Paciente.class.php');
  require_once('../../class/Tipo_Producto.class.php');
  $objCon = new Conectar(); 
  $objUtil = new Util();
  $objPss = new Pss();
  $objPac = new Paciente();
  $objTip_pro = new Tipo_Producto();
  $objCon->db_connect();
  $objPss->setPss_id($_POST['pss_id']);
  $pss=$objPss->buscarPss($objCon,"");
  $paciente=$objPac->getInformacionPaciente($objCon, "", "", $pss[0]['cue_id']);
  $tipoProducto=$objTip_pro->listarTipoProducto($objCon);
  $objCon=null;
?>
<script type="text/javascript" src="controller/client/js_editarPss.js"></script>
<fieldset class="cabezeraDatos"><legend class="cuerpoDatos">Datos PSS N ° <?=$_POST['pss_id']?></legend>
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
<div id="tabs">
  <ul>
  <?php
    for($i=0; $i<count($tipoProducto); $i++){
  ?>
    <li><a href="#proTip<?=$tipoProducto[$i]['tip_prod_id']?>"><?=$tipoProducto[$i]['tip_descripcion']?></a></li>
  <?php 
    } 
  ?>
  </ul>
  <?php
    for($i=0; $i<count($tipoProducto); $i++){
  ?>
      <div id="proTip<?=$tipoProducto[$i]['tip_prod_id']?>">
          <p>
            <center>
            <fieldset class="cabezeraDatos" style="background-color: #f2f5f7 !important; width: 400px;">
                <b>Buscar <?=$tipoProducto[$i]['tip_descripcion']?></b> <input type="text" id="<?=$tipoProducto[$i]['tip_prod_id']?>" class="filtroBus">
            </fieldset>
            </center>
            <fieldset class="cabezeraDatos" style="background-color: #DEE2E4 !important;"><legend  class="cuerpoDatos"><?=$tipoProducto[$i]['tip_descripcion']?></legend>
                  <center>
                    <table width="95%" border="0" id="tblProducto<?=$tipoProducto[$i]['tip_prod_id']?>">
                        <thead>
                          <tr>
                            <th><center>Código</center></th>
                            <th><center>Descripción</center></th>
                            <th><center>Cantidad</center></th>
                          </tr>
                        </thead>
                    </table>
                  </center>
                  <br><br>    
            </fieldset>
            <br>
          </p>
      </div>
  <?php 
    } 
  ?>
</div>
