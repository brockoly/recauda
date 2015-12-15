<style type="text/css">

</style>
<script type="text/javascript" src="controller/client/js_cargaPaciente.js"></script>
<form id="cargaPacienteMas">
	<table width="630px">
		<tr>
			<td align="center"><input type="file" name="archivo" id="archivo" class="upload" accept=".csv" /></td>			
			<td align="center"><input type="button" id="enviarDatos" value="Subir"></td>
			<td id="wait" width="" align="right">
				&nbsp;<progress id="progreso" max="100" value="0"></progress>&nbsp;				
			</td>
			<td id="porce">0%</td>
		</tr>
		<tr>
			<td><input type="hidden" name="MAX_FILE_SIZE" value="20000" /></td><td></td>
		</tr>			
	</table>
</form><br><br>
<fieldset  id="rsError" hidden="true" class="cabezeraDatos" style="background-color: #f2f5f7 !important; width: 700px;"><legend class="cuerpoDatos">Resumen Resultados</legend><br>
	<center>
		<table id="erroresTB" width="650px">
			<tr class="cuerpoDatos trEncabezados" id="encabezadosError" hidden="true"><td align="center"><b>Identificador</b></td><td align="center"><b>Nombre Paciente</b></td><td align="center"><b>Resumen Error</b></td><td align="center"><b>Resultado</b></td></tr>
		</table>
		<br>
		<table>
			<tr>
				<td><b><u>Resultados</u></b>:&nbsp;&nbsp;&nbsp;</td><td id="totalRS"></td>
			</tr>
		</table>			
	</center>
	<br>
</fieldset>