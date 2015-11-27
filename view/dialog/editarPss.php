<?php
  session_start();
  require_once('../../class/Conectar.class.php');
  require_once('../../class/Util.class.php');
  require_once('../../class/Pss.class.php');
  require_once('../../class/Cuenta_Corriente.class.php');
  $objCon = new Conectar(); 
  $objUtil = new Util();
  $objPss = new Pss();
  $objCon->db_connect();
  echo $_POST['pss_id'];
  $objCon=null;
?>
<script type="text/javascript" src="controller/client/js_editarPss.js"></script>
<div id="tabs">
  <ul>
    <li><a href="#tabs-1">Nunc tincidunt</a></li>
    <li><a href="#tabs-2">Proin dolor</a></li>
    <li><a href="#tabs-3">Aenean lacinia</a></li>
  </ul>
  <div id="tabs-1">
    <p></p>
  </div>
  <div id="tabs-2">
    <p></p>
  </div>
  <div id="tabs-3">
    <p></p>
  </div>
</div>