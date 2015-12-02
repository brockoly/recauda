<?php
  session_start();  
  require_once('../../class/Conectar.class.php');
  require_once('../../class/Util.class.php');
  require_once('../../class/Pss.class.php');
  require_once('../../class/Paciente.class.php');
  require_once('../../class/Tipo_Producto.class.php');
  $objCon = new Conectar(); 
  $objUtil = new Util();
  $objPss = new Pss();
  $objPac = new Paciente();
  $objTip_pro = new Tipo_Producto();
  $objCon->db_connect();
  unset($_SESSION['pss_id']);
  $_SESSION['pss_id']=$_POST['pss_id'];  
  $objPss->setPss_id($_POST['pss_id']);
  $pss=$objPss->buscarPss($objCon,"");
  $paciente=$objPac->getInformacionPaciente($objCon, "", "", $pss[0]['cue_id']);
  unset($_SESSION['cue_id']);
  $_SESSION['cue_id']=$pss[0]['cue_id'];
  $tipoProducto=$objTip_pro->listarTipoProducto($objCon);
  $productos_PSS=$objPss->verDetallePss($objCon);
  $objCon=null;
  echo count($productos_PSS);
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
            <fieldset class="cabezeraDatos" style="background-color: #f2f5f7 !important; width: 450px;">
                <b>Buscar <?=$tipoProducto[$i]['tip_descripcion']?></b> 
                <input type="text" id="<?=$tipoProducto[$i]['tip_prod_id']?>" class="filtroBus">&nbsp;&nbsp;&nbsp;
                <input placeholder="cant" type="text" class="cantPro" id="cantPro<?=$tipoProducto[$i]['tip_prod_id']?>" style="width:60px" hidden="true">
            </fieldset>
            </center>
            <fieldset class="cabezeraDatos" style="background-color: #DEE2E4 !important;"><legend  class="cuerpoDatos"><?=$tipoProducto[$i]['tip_descripcion']?></legend>
                  <center>
                    <table width="95%" border="0" class="tablaProductosAgregados" id="tblProducto<?=$tipoProducto[$i]['tip_prod_id']?>" <? if(count($productos_PSS)==0){ echo "hidden='true'";} ?>>
                        <thead>
                          <tr>
                            <th><center>Código</center></th>
                            <th><center>Descripción</center></th>
                            <th><center>Cantidad</center></th>
	                      </tr>
                        </thead>
                        <?php
                        	if(count($productos_PSS)>0){
                        	for($p=0; $p<count($productos_PSS); $p++){
                        		if($tipoProducto[$i]['tip_prod_id']==$productos_PSS[$p]['tip_prod_id']){
						?>	
							                <tr id='eliminarPro<?=$productos_PSS[$p]['pro_id']?>'>
		                             <td align="center" class="cuerpoDatosTablas"><?=$productos_PSS[$p]['pro_id']?></td>
				                         <td class="cuerpoDatosTablas" align="center"><?=$productos_PSS[$p]['pro_nom']?></td>
				                         <td class="cuerpoDatosTablas" align="center" width="10%"><input  class="proCantAgregar" type="text" style="width:60px" id="cantProducto<?=$productos_PSS[$p]['pro_id']?>" onblur="verificaEntero(<?=$productos_PSS[$p]['pro_id']?>)"  value="<?=$productos_PSS[$p]['det_proCantidad']?>" /></td><td width="3%">&nbsp&nbsp<img class="eliminarFila<?=$productos_PSS[$p]['pro_id']?> bd" onclick="eliminarFila(<?=$productos_PSS[$p]['pro_id']?>)" src="./include/img/delete.png" width="16" height="16" id="<?=$productos_PSS[$p]['pro_id']?>"/></td>
		                          </tr>
                        <?  }}}?> 
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
</div><br>
<center>
  <input type="button" value="Guardar PSS"  id="btnAgregar1"  class="btnAdd"> 
  <input type="button"   id="btnAgregar2" class="btnAdd" value="Guardar y Cerrar PSS" <?php if(count($productos_PSS)==0){ ?> style="visibility:hidden;" <?php }?>>
</center>
<input type="hidden" value="<?=$_SESSION['cue_id']?>" id="cue_id">
<input type="hidden" value="<?=$_POST['Paciente']?>" id="Paciente">
<input type="hidden" value="<?=$_POST['CtaCorriente']?>" id="CtaCorriente">
<input type="hidden" value="<?=$_POST['Identificador']?>" id="Identificador">
