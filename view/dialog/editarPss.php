<?php
  session_start();
  require_once('../../class/Conectar.class.php');
  require_once('../../class/Util.class.php');
  require_once('../../class/Pss.class.php');
  require_once('../../class/Cuenta_Corriente.class.php');
  require_once('../../class/Paciente.class.php');
  $objCon = new Conectar(); 
  $objUtil = new Util();
  $objPss = new Pss();
  $objPac = new Paciente();
  $objCon->db_connect();
  $objPss->setPss_id($_POST['pss_id']);
  $pss=$objPss->buscarPss($objCon,"");
  $paciente=$objPac->getInformacionPaciente($objCon, "", "", $pss[0]['cue_id']);
  $objCon=null;
?>
<script type="text/javascript" src="controller/client/js_editarPss.js"></script>
<fieldset class="cabezeraDatos"><legend class="cuerpoDatos">DATOS PSS N° <?=$_POST['pss_id']?></legend>
    <table width="100%">
        <tr>
            <td width="10%" align="center"><b>N ° IDENTIFICACIÓN:</b> <? if($paciente[0]['nac_id']==1){ echo $objUtil->formatRut($paciente[0]['Identificador']); }else{ echo $paciente[0]['Identificador'];} ?> </td>  
            <td width="10%" align="center"><b>NOMBRES:</b> <?=$paciente[0]['Nombre']?></td>
            <td width="10%" align="center"><b>A. PATERNO:</b> <?=$paciente[0]['Apellido_Paterno']?></td>
            <td width="10%" align="center"><b>A. MATERNO:</b> <?=$paciente[0]['Apellido_Materno']?></td> 
            <td width="10%" align="center"><b>FECHA NACIMIENTO:</b> <?=$objUtil->cambiarfecha_mysql_a_normal($paciente[0]['fecha_nac'])?></td>
        </tr>
    </table>
</fieldset><br>
<div id="tabs">
  <ul>
    <li><a href="#tabs-1">Producto A</a></li>
    <li><a href="#tabs-2">Producto B</a></li>
    <li><a href="#tabs-3">Producto C</a></li>
  </ul>
  <div id="tabs-1">
    <p><br><br><br><br><br><br><br><br></p>
  </div>
  <div id="tabs-2">
    <p></p>
  </div>
  <div id="tabs-3">
    <p></p>
  </div>
</div>