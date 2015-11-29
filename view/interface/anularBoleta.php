<?
  if ( $_SESSION['usuario'] == null ) {
    $GoTo = "../../../login/index.php";
    header(sprintf("Location: %s", $GoTo));
  }
?>
<script type="text/javascript" src="controller/client/js_anularBoleta.js"></script>
<!-- <div id="information" style="cursor: help; width:120px;"><img src="./include/img/information.png" /> <b>Información</b></div> -->
<center>
<fieldset style="width: 20%;"><legend>Anular Boleta</legend>
<table border="0" width="300">
      <tr>
          <td align="center">N° Folio
          </td>
          <td align="center">
              <input type="text" id="filtroBusqueda">
          </td>
          <td align="center">
              <img src="./include/img/buscar.png" id="btnBusqueda" width="28" height="28" />
          </td>
            <td><br><br></td>
          </tr>
</table>
</fieldset>
<div id="contenidoBuscado"></div>
</center>
