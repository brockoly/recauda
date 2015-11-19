<script type="text/javascript" src="controller/client/js_nuevaCuentaCte.js"></script>
<!-- <div id="information" style="cursor: help; width:120px;"><img src="./include/img/information.png" /> <b>Información</b></div> -->
<center>
<fieldset style="width: 30%;"><legend>Buscar Paciente</legend>
<table border="0" width="500">
      <tr>
          <td align="center">
              <select name="opcionesCuenta" id="opcionesCuenta">
                  <optgroup label="Tipos de Busqueda">
                    <option value="Paciente">Buscar Paciente</option>
                    <option value="Identificador">Buscar N° Identificador</option>
                    <option value="Nombre">Nombre(s) y/o Apellido(s) Paciente</option>
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
