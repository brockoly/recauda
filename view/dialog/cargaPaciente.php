<script type="text/javascript" src="controller/client/js_cargaPaciente.js"></script>
<form id="cargaPacienteMas">
	<table width="570px">
		<tr>
			<td><input type="file" name="archivo" id="archivo" accept=".csv" /></td>
			<td id="wait" width="50%" align="right">
				&nbsp;&nbsp;<progress id="progreso" max="100" value="0"></progress>&nbsp;				
			</td>
			<td id="porce">0%</td>
		</tr>
		<tr>
			<td colspan="3" align="center"><br><input type="button" id="enviarDatos" value="Subir"></td>
		</tr>
		<tr>
			<td><input type="hidden" name="MAX_FILE_SIZE" value="20000" /></td><td></td>
		</tr>			
	</table>
</form>
<fieldset  id="rsError" hidden="true" class="cabezeraDatos" style="background-color: #f2f5f7 !important; width: 600px;"><legend class="cuerpoDatos">Errores</legend><br>
	<center>
		<table id="erroresTB" width="550px">
			<tr class="cuerpoDatos">
					<td align="center">Identificador</td>
					<td align="center">Nombre Paciente</td>
					<td align="center">Resumen Error</td>
					<td align="center">Resultado</td>
			</tr>
		</table>
		<table>
			<tr>
				<td><b><u>Resultados</u></b>:&nbsp;&nbsp;&nbsp;</td><td id="totalRS"></td>
			</tr>
		</table>			
	</center>
	<br>
</fieldset>