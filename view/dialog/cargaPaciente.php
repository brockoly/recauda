<script src="include/framework/blockUI/jquery.blockUI.js"></script>
<script type="text/javascript" src="controller/client/js_cargaPaciente.js"></script>

<form id="cargaPacienteMas">
	
	<table width="800px">
		<tr>
			<td align="center"><input type="file" name="archivo" id="archivo" class="upload" accept=".csv" /></td>			
			<td align="center"><input type="button" id="enviarDatos" value="Subir"></td>
		</tr>
		<tr>
			<td><input type="hidden" name="MAX_FILE_SIZE" value="20000" /></td><td></td>
		</tr>			
	</table>
</form><br><br>
<fieldset   width="800px" id="rsError" hidden="true" class="cabezeraDatos" style="background-color: #f2f5f7 !important;">
	<legend class="cuerpoDatos">Resumen Resultados</legend><br>
	<center>
		<table>
			<tr>
				<td id="totalRS"></td>
			</tr>
		</table>	
		<!-- <table id="" width="675px" class="display">			
			<tr hidden="true"><td align="center"><b>Identificador</b></td><td align="center"><b>Nombre Paciente</b></td><td align="center"><b>Resumen Error</b></td><td align="center"><b>Resultado</b></td></tr>
		</table>
		 -->
		<div id="dvTb">
		
		</div>
		<br>				
	</center>
	<br>
</fieldset>