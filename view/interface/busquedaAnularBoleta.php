<?php
	require_once('../../class/Conectar.class.php');
	require_once('../../class/Util.class.php');
	$objCon = new Conectar(); 
	$objUtil = new Util(); 
	$objCon->db_connect();
	$objCon=null;
?>
<script type="text/javascript" src="controller/client/js_busquedaAnularBoleta.js"></script>
<br><br>
<center>
<div style="width: 700px;">
	<table class="display" id="tabAnularBoleta">
            <thead>
	            <tr>
	              <th width="50%" align="center">N° Folio</th>
	              <th width="10%" align="center">Usuario Emisión</th>
	            </tr>
            </thead>
           
    </table>
</div>
</center>