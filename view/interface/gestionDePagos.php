<script type="text/javascript" src="controller/client/js_gestionDePagos.js"></script>
<!-- <div id="information" style="cursor: help; width:120px;"><img src="./include/img/information.png" /> <b>Información</b></div> -->
<center>
<fieldset style="width: 30%;"><legend>Gestion de Pagos</legend>
<table border="0" width="500">
      <tr>
          <td align="center">
              <select name="opcionesGestion" id="opcionesGestion">
                  <optgroup label="Tipos de Busqueda">
                    <option value="CtaCorriente">Buscar Cuenta Corriente</option>
                    <option value="Paciente">Buscar Paciente</option>
                  </optgroup>
              </select>
          </td>
          <td align="center">
              <input type="text" id="filtroBusqueda">
          </td>
          <td align="center">
              <img src="./include/img/buscar.png" id="btnBusqueda" width="28" height="28" />
          </td>
      </tr>
</table>
</fieldset>

<div id="contenidoBuscado"></div>
</center>
