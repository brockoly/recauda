<?
?>
<script type="text/javascript" src="controller/client/js_consultaPagos.js"></script>
<!-- <div id="information" style="cursor: help; width:120px;"><img src="./include/img/information.png" /> <b>Información</b></div> -->
<center>
<fieldset style="width: 30%;"><legend>Consulta de Pagos</legend>
<table border="0" width="500">
      <tr>
          <td align="center">
              <select name="opcionesBusquedaPagos" id="opcionesBusquedaPagos">
                  <optgroup label="Tipos de Busqueda">
                    <option value="0">Seleccione</option>
                    <option value="Boleta">Folio Boleta</option>
                  </optgroup>
              </select>
          </td>
          <td align="center" hidden="true" class="tdOcultos">
              <div class="inputs"></div><center><div class="divOcultos"><input type="checkbox" id="extranjero" value="1">Extranjero</div></center>
          </td>
          <td align="center" hidden="true" class="tdOcultos">
              <img src="./include/img/buscar.png" id="btnBusqueda" width="32" height="32" />
          </td>
      </tr>
</table>
</fieldset>

<div id="contenidoBuscado"></div>
</center>
