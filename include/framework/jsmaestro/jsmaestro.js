function cargarContenidoInstalacion(url,parametros,contenedor){//FUNCION AJAX ENVIAPETICION A SERVIDOR Y CARGA CONTENIDO HTML EN CONTENEDOR(NORMALMENTE ELEMENTO DIV)
	$(contenedor).html();
	
//	setTimeout(function(){
		/***/
		$(contenedor).fadeOut(250, function(){
			$.ajax({
				type: "POST",
				url:url,
				data:parametros,
				success: function(datos){
					$('.validity-tooltip').remove();
					//$.unblockUI(); 
					$(contenedor).html(datos);
				}
			});
			$(contenedor).fadeIn();
		});
		
		/***/
//	},5000);
//FIN FUNCION AJAX
}
function cargarContenido(url,parametros,contenedor){
//FUNCION AJAX ENVIAPETICION A SERVIDOR Y CARGA CONTENIDO HTML EN CONTENEDOR(NORMALMENTE ELEMENTO DIV)
	$(contenedor).html('<div style="position: absolute;top: 50%; left: 40%;"><img src="./include/img/cargando.gif"/></div>');
	
//	setTimeout(function(){
		/***/
		$(contenedor).fadeOut(300, function(){
			$.ajax({
				type: "POST",
				url:url,
				data:parametros,
				success: function(datos){
					$('.validity-tooltip').remove();
					//$.unblockUI(); 
					$(contenedor).html(datos);
				}
			});
			$(contenedor).fadeIn();
		});
		
		/***/
//	},5000);
//FIN FUNCION AJAX
}
function cargarContenidoSlow(url,parametros,contenedor){
//FUNCION AJAX ENVIAPETICION A SERVIDOR Y CARGA CONTENIDO HTML EN CONTENEDOR(NORMALMENTE ELEMENTO DIV)
	$(contenedor).html('<div style="position: absolute;top: 50%; left: 40%;"><img src="./include/img/cargando.gif"/></div>');
	
//	setTimeout(function(){
		/***/
		$(contenedor).fadeOut(2500, function(){
			$.ajax({
				type: "POST",
				url:url,
				data:parametros,
				success: function(datos){
					$('.validity-tooltip').remove();
					//$.unblockUI(); 
					$(contenedor).html(datos);
				}
			});
			$(contenedor).fadeIn();
		});
		
		/***/
//	},5000);
//FIN FUNCION AJAX
}
//FUNCION QUE ENVIA PETICION AJAX AL SERVIDOR Y ESPERA UN VALOR DE RETORNO
function validarProcesos(url,parametros){
	var valor;
	$.ajax({   
		type: "POST",
		url:url,
		async: false,
		data: parametros,	
		success: function(retorno){
			valor = retorno;
		}
	});
	return valor;
}

function retornarJson(url,parametros){
	var valor;
	$.ajax({   
		type: "POST",
		dataType: "json",
		url:url,
		async: false,
		data: parametros,
		success: function(retorno){
			valor = retorno;
		}
	});
	return valor;
}
function cargarComboAjax(url,parametros,combo){
	var miselect = $(combo);
	$(combo).find('option').remove().end().append('<option value="">Cargando...</option>').val('');
	$.ajax({   
		type: "POST",
		dataType: "json",
		url:url,
		async: false,
		data: parametros,
		success: function(data){
			$(combo).empty();
			$(combo).append('<option value="0">Seleccione...</option>').val('');
			for (var i=0; i<data.length; i++) {
				$(combo).append('<option value="' + data[i].id + '">' + data[i].valor + '</option>');
			}
		}
	});
}
function cargarComboAjaxValorP(url,parametros,combo, valor){
	var miselect = $(combo);
	$(combo).find('option').remove().end().append('<option value="">Cargando...</option>').val('');
	$.ajax({   
		type: "POST",
		dataType: "json",
		url:url,
		async: false,
		data: parametros,
		success: function(data){
			$(combo).empty();
			$(combo).append('<option value="0">Seleccione...</option>').val('');
			for (var i=0; i<data.length; i++) {
				var se = '';
				if(data[i].id==valor){ se = 'selected'; }
				$(combo).append('<option '+se+' value="' + data[i].id + '">' + data[i].valor + '</option>');
			}
		}
	});
}
//FUNCION QUE ENVIA PETICION AJAX AL SERVIDOR DE FORMA SINCRONICA
function ejecutarProcedimiento(url,parametros){
	$.ajax({   
		type: "POST",
		url:url,
		//async: false,
		data: parametros,
		success: function(retorno){
			//$.unblockUI();
			return false;
		}
	});
}
function pruebaVariables(url,parametros){
	var tag = $("<div id='agendar_main'></div>");
	$.ajax({
	type: "POST",
	url: url,
	data: parametros,
	success: function(data) {
		tag.html(data).dialog({
			title: 'PRUEBA DE RECEPCION DE VARIABLES', 
			width: 800,
			height: 600,
			modal: true, 
			draggable: true, 
			resizable: false,
			close: function(event, ui){
				tag.dialog('destroy').remove(); 
				$('.validity-tooltip').remove();
			}
		}).dialog('open');
	}
	});
}
function mensajeUsuario(clase,titulo,cuerpo){
	var newDiv = $(document.createElement('div'));
	$(newDiv).attr('id','mensaje');
	$(newDiv).html('<div class="'+clase+'">'+cuerpo+'</div>');
	$(newDiv).dialog({
		dialogClass: clase,
		title: titulo,
		resizable: false,
		modal: true,
		width: 'auto',
		height: 'auto',
		async: false,
		buttons:[{
			id: 'ok',
			text: 'Aceptar',
			click: function(event){
				$('#mensaje').dialog('destroy').remove();
			}
		}]
	});			
}
function mensajeUsuarioPaciente(clase,titulo,cuerpo,url,tituloUrl){
	var newDiv = $(document.createElement('div'));
	$(newDiv).attr('id','mensaje');
	$(newDiv).html('<div class="'+clase+'">'+cuerpo+'</div>');
	$(newDiv).dialog({
		dialogClass: clase,
		title: titulo,
		resizable: false,
		modal: true,
		width: 'auto',
		height: 'auto',
		async: false,
		buttons:[
			{ 
				text: 'Si', 
				id: 'Aceptar', 
				click: function(){
					ventanaModal(url,'','auto','auto',tituloUrl,'mensaje');
					$('#mensaje').dialog('destroy').remove();
				}  
				
			},
			{ 
				text: 'No', 
				id: 'Cancelar', 
				click: function(){ 
					$('#mensaje').dialog('destroy').remove();
				} 
			}
		]

	});			
}

function mensajeUsuarioConProcedimiento(clase,titulo,cuerpo,url,parametros,urlContenido,parametrosContenido,div,idModalCerrar){
	var newDiv = $(document.createElement('div'));
	$(newDiv).attr('id','mensaje');
	$(newDiv).html('<div class="'+clase+'">'+cuerpo+'</div>');
	$(newDiv).dialog({
		dialogClass: clase,
		title: titulo,
		resizable: false,
		modal: true,
		width: 'auto',
		height: 'auto',
		async: false,
		buttons:[
			{ 
				text: 'Si', 
				id: 'Aceptar', 
				click: function(){
					var proc = validarProcesos(url,parametros);
					mensajeUsuario('successMensaje','Accion realizada',proc)
					cargarContenido(urlContenido,parametrosContenido,div);
					$('#mensaje').dialog('destroy').remove();
					$('#'+idModalCerrar).dialog('destroy').remove();
				}  
				
			},
			{ 
				text: 'No', 
				id: 'Cancelar', 
				click: function(){ 
					$('#mensaje').dialog('destroy').remove();
				} 
			}
		]

	});			
}

function mensajeConfirmacion(clase,titulo,cuerpo,urlContenido,parametrosContenido,div){
	var newDiv = $(document.createElement('div'));
	$(newDiv).attr('id','mensaje');
	$(newDiv).html('<div class="'+clase+'">'+cuerpo+'</div>');
	$(newDiv).dialog({
		dialogClass: clase,
		title: titulo,
		resizable: false,
		modal: true,
		width: 'auto',
		height: 'auto',
		async: false,
		buttons:[
			{ 
				text: 'Si', 
				id: 'Aceptar', 
				click: function(){
					cargarContenido(urlContenido,parametrosContenido,div);
					$('#mensaje').dialog('destroy').remove();
				}  
				
			},
			{ 
				text: 'No', 
				id: 'Cancelar', 
				click: function(){ 
					$('#mensaje').dialog('destroy').remove();
				} 
			}
		]

	});			
}

function ventanaModal(url,parametros,alto,ancho,titulo,div){
		var tag = $("<div id='"+div+"'></div>");
		$("div#"+div+"").remove();
		tag.html('<div ><img src="./include/img/cargando.gif"/></div>');
		$.ajax({
		type: "POST",
		url: url,
		data: parametros,
		success: function(data) {
			tag.html(data).dialog({
				title: titulo, 
				width: ancho, 
				height: alto,
				modal: true, 
				draggable: true,
				resizable: true,
				show: {
					effect: 'fade',
					duration: 100
				},
				hide: {
					effect: 'fade',
					duration: 100
				},
				buttons: [],
				close: function(event, ui){
					tag.dialog('destroy').remove(); 
					$('.validity-tooltip').remove();
				}
			}).dialog('open');
		}
	  });
	  //return tag;
}

function ventanaModalConBotones(url,parametros,alto,ancho,titulo,div,botones){
		var tag = $("<div id='"+div+"'></div>");
		$("div#"+div+"").remove();
		tag.html('<div style="position: absolute;top: 50%; left: 50%;"><img src="./include/img/cargando.gif"/></div>');
		$.ajax({
		type: "POST",
		url: url,
		data: parametros,
		success: function(data) {
			tag.html(data).dialog({
				title: titulo, 
				width: ancho, 
				height: alto,
				modal: true, 
				draggable: true,
				resizable: true,
				show: {
					effect: 'fade',
					duration: 100
				},
				hide: {
					effect: 'fade',
					duration: 100
				},
				buttons: botones,
				close: function(event, ui){
					tag.dialog('destroy').remove(); 
					$('.validity-tooltip').remove();
				}
			}).dialog('open');
		}
	  });
	  //$("#"+div).dialog(botones);
	  //return tag;
}
function inicio(){
	window.scrollTo(0,0);
}
function tabla(id){
	$('#'+id+'').DataTable({
	"sPaginationType": "full_numbers",
		"language": {
			"lengthMenu": "Mostrar _MENU_ Resultados por pagina.",
			"zeroRecords": "0 resultados de busqueda.",
			"info": "Mostrando pagina _PAGE_ de _PAGES_",
			"infoEmpty": "Sin resultados disponibles",
			"infoFiltered": "(Filtrando en  _MAX_  registros)",
			"search": "Buscar",
			"searchPlaceholder": "Buscar...",
			"paginate": {
			  "first": "Primera Pagina",
			  "last":  "Ultima pagina",
			  "previous": "Atras",
			  "next": "Siguiente"
			}
		}														
	});
}
function tablaMinima(id){
	$('#'+id+'').DataTable({
	"sPaginationType": "full_numbers",
		"language": {
			"lengthMenu": "Mostrar _MENU_ Resultados por pagina.",
			"zeroRecords": "0 resultados de busqueda.",
			"info": "Mostrando pagina _PAGE_ de _PAGES_",
			"infoEmpty": "Sin resultados disponibles",
			"infoFiltered": "",
			"search": "Buscar",
			"searchPlaceholder": "Buscar...",
			"paginate": {
			  "first": "Primera Pagina",
			  "last":  "Ultima pagina",
			  "previous": "Atras",
			  "next": "Siguiente"
			}
		}														
	});
}
function muestraError(div, mensaje){
	$('#'+div).tooltip();
	$('#'+div).attr("title", mensaje).show('500');
}
function tooltipImg(div, mensaje){
	$('.'+div).attr("title", mensaje).show('500');
	$('.'+div).tooltip({
		position: {
	        my: "center bottom-20",
	        at: "center top"
	    }
    });	
}
function validaEmail( email ) {
    expr = /^([a-zA-Z0-9Ññ_\.\-])+\@(([a-zA-Z0-9Ññ\-])+\.)+([a-zA-Z0-9Ññ]{2,4})+$/;
	if ( !expr.test(email) ){// INCORRECTO , ENTRA
		return false;
	}else{
		return true;
	}
}
function calendario(div, maxFecha){

	jQuery(function($){
			$.datepicker.regional['es'] = {
			yearRange: "1920:2015",
			closeText: 'Cerrar',
			prevText: 'Atras',
			nextText: 'Siguiente',
			currentText: 'Hoy',
			changeYear: true,
			constrainInput: true,
			monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
			'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
			monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun',
			'Jul','Ago','Sep','Oct','Nov','Dic'],
			dayNames: ['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'],
			dayNamesShort: ['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'],
			dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
			weekHeader: 'Sm',
			dateFormat: 'dd/mm/yy',
			firstDay: 1,
			isRTL: false,
			maxDate: maxFecha,
			showMonthAfterYear: false,
			yearSuffix: ''};
			$.datepicker.setDefaults($.datepicker.regional['es']);
	})
	$("#"+div).datepicker({
		onSelect: function(){
		}

	});
}

function validar(id, atributo,tipo){
	
	if(atributo=='name'){
		switch(tipo){
			case 'rut' 		: 	$('[name="'+id+'"]').validCampoFranz('0123456789-k'); 
								break;
			case 'numero' 	: 	$('[name="'+id+'"]').validCampoFranz('0123456789');
								break;
			case 'letras' 	: 	$('[name="'+id+'"]').validCampoFranz('abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZáéíóúÁÉÍÓÚ ');
								break;
			case 'letrasUsuario' 	: 	$('[name="'+id+'"]').validCampoFranz('abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ');
								break;
			case 'todo' 	: 	$('[name="'+id+'"]').validCampoFranz('abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZáéíóúÁÉÍÓÚ0123456789.-(),# ');
								break;
			case 'correo' 	: 	$('[name="'+id+'"]').validCampoFranz('abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ0123456789@_.-');
								break;
		}
		$('[name="'+id+'"]').bind('paste', function (e) {
		        e.preventDefault();
		        return false;
		});
	}else{
		if(atributo=='id'){
			switch(tipo){
				case 'rut' 		: 	$('#'+id).validCampoFranz('0123456789-k'); 
									break;
				case 'numero' 	: 	$('#'+id).validCampoFranz('0123456789');
									break;
				case 'letras' 	: 	$('#'+id).validCampoFranz('abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZáéíóúÁÉÍÓÚ ');
									break;
				case 'letrasUsuario' 	: 	$('#'+id).validCampoFranz('abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ');
									break;
				case 'todo' 	: 	$('#'+id).validCampoFranz('abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZáéíóúÁÉÍÓÚ0123456789.-(),# ');
									break;
				case 'correo' 	: 	$('#'+id).validCampoFranz('abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ0123456789@_.-');
									break;
			}
			$('#'+id).bind('paste', function (e) {
		        e.preventDefault();
		        return false;
		    });
		}
		if(atributo=='class'){
			switch(tipo){
				case 'rut' 		: 	$('.'+id).validCampoFranz('0123456789-k'); 
									break;
				case 'numero' 	: 	$('.'+id).validCampoFranz('0123456789');
									break;
				case 'letras' 	: 	$('.'+id).validCampoFranz('abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZáéíóúÁÉÍÓÚ ');
									break;
				case 'letrasUsuario' 	: 	$('.'+id).validCampoFranz('abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ');
									break;
				case 'todo' 	: 	$('.'+id).validCampoFranz('abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZáéíóúÁÉÍÓÚ0123456789.-(),# ');
									break;
				case 'correo' 	: 	$('.'+id).validCampoFranz('abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ0123456789@_.-');
									break;
			}
			$('.'+id).bind('paste', function (e) {
		        e.preventDefault();
		        return false;
		    });
		}
	}
	
}
function recargarTiempoRestante(){	
	alert("hola");
/*	momento = new Date(fechax+" "+horax);
	hora = momento.getHours();
	minuto = momento.getMinutes();
	segundo = momento.getSeconds();

   	momento2 = new Date(); 
   	hora2 = momento2.getHours() ;
   	minuto2 = momento2.getMinutes() ;
   	segundo2 = momento2.getSeconds() ;


	str_segundo = new String (segundo2) ;
   	if (str_segundo.length == 1) 
      	segundo2 = "0" + segundo2 ;

   	str_minuto = new String (minuto2) ;
   	if (str_minuto.length == 1) 
      	minuto2 = "0" + minuto2 ;

   	str_hora = new String (hora2) ;
   	if (str_hora.length == 1) 
      	hora2 = "0" + hora2 ;

   	horaImprimible = hora2 + " : " + minuto2 + " : " + segundo2 ;
   	//alert(horaImprimible);
	$("#lblTime").text(horaImprimible);
	setTimeout("recargarTiempoRestante()",1000) ;
*/

function eliminarEspacio(string){ // Ej: "A      B      C" -> "A B C" , Es decir, deja solo un espacio entre palabras
		string = string.trim();
		string = string.replace(/\s+/g, ' ');
		return string
}

function eliminarTodosEspacio(string){ // Ej: "A      B      C" -> "A B C" , Es decir, deja solo un espacio entre palabras
		string = string.trim();
		string = string.replace(/\s+/g, '');
		return string
}