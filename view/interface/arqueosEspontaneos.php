<?php
session_start();
	require_once('../../class/Conectar.class.php');
	require_once('../../class/Arqueo.class.php');	
	require_once('../../class/Util.class.php');	
	
	$objCon = new Conectar(); 
	$objUtil = new Util(); 
	$objArq = new Arqueo();
	$objCon->db_connect();
	$usu_nombre = $_SESSION['usuario'][1]['nombre_usuario'];
	$arqueo = $objArq->buscarArqueosRendidox($objCon, $usu_nombre);
	$objCon=null;
	//var_dump($datos);
?>
<style> 
#tabArqueos_wrapper{
	width:40% !important;
}
#imgRendirArqueo {
    width:40px;
    height:40px;    

}
#imgRendirArqueo:hover{
     transform: rotate(360deg);	
}
.arqueos{
	cursor:pointer;
}

</style>
<script type="text/javascript" src="controller/client/js_arqueosEspontaneos.js"></script>
<center><h3 style="margin-bottom:30px;">Arqueos Espontáneos</h3></center>
<br><br>
<center>
	<table class="display" width="100%" id="tabArqueosEspontaneos">
            <thead>
	            <tr>
	              <th width="10%"><center>ID Arqueo</center></th>
	              <th width="15%"><center>ID Cajero</center></th>
	              <th width="30%"><center>Nombre Cajero</center></th>
	              <th width="20%"><center>Fecha</center></th>	              
	              <th width="25%"><center>Hora</center></th>	              
	            </tr>
            </thead>
            <?php
            	for($i=0; $i<count($arqueo); $i++){
	        ?> 
	        	<tr id="<?=$arqueo[$i]['arq_id']?>" class="arqueos">
	        			<td align="center" ><strong><?=$arqueo[$i]['arq_id']?></strong></td>
						<td align="center"><?=$arqueo[$i]['usu_nombre']?></td>					
						<td align="center"><?=$arqueo[$i]['nombre']?></td>
						<td align="center"><?=$objUtil->cambiarfecha_mysql_a_normal($arqueo[$i]['arq_fecha'])?></td>
						<td align="center"><?=$arqueo[$i]['arq_hora']?></td>
	            </tr>
            <?php 	}
            ?>	
    </table>
</center>

