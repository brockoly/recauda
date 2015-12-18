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
	$arqueo = $objArq->buscarArqueosRendidos($objCon, $usu_nombre);
	$objCon=null;	
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
<script type="text/javascript" src="controller/client/js_rendicionEspontanea.js"></script>
<center><h3 style="margin-bottom:30px;">Arqueo Global</h3></center>
<fieldset style="float:left;width:250px !important; padding:10px !important;" class="cabezeraDatos"><legend class="cuerpoDatos">Opciones de Arqueo</legend>
	<center>
	<div class="btnVisualizar" id="btnVisualizar" ><img class="imgVisualizar" id="imgVisualizar" src="./include/img/preview2.png" width="40" height="40"> 	
	</div>
	<div class="btnRendirArqueo" id="btnRendirArqueo"><img class="imgRendirArqueo" id="imgRendirArqueo" src="./include/img/gear.png">	
	</div></center>
</fieldset>

<br><br>
<center>
	<table class="display" width="100%" id="tabArqueos">
            <thead>
	            <tr>
	              <th width="40%"><center>ID Arqueo</center></th>
	              <th width="40%"><center>Fecha</center></th>	              
	            </tr>
            </thead>
            <?php
            	for($i=0; $i<count($arqueo); $i++){
	        ?> 
	        	<tr id="<?=$arqueo[$i]['arq_id']?>" class="arqueos">
	        			<td align="center" ><strong><?=$arqueo[$i]['arq_id']?></strong></td>
						<td align="center"><?=$objUtil->cambiarfecha_mysql_a_normal($arqueo[$i]['arq_fecha'])?></td>					
	            </tr>
            <?php 	}
            ?>	
    </table>
</center>

