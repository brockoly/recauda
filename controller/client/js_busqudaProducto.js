$(document).ready(function(){
	$('#btnAgregarProducto').button().click(function(){
		ventanaModal('./view/dialog/agregarProducto','','auto','auto','Registro De Producto','modalAgregarProducto')
	});
	$('#btnAgregarTipoProducto').button().click(function(){
		ventanaModal('./view/dialog/agregarTipoProducto','','auto','auto','Registro De Tipo De Producto','modalAgregarProducto');
	});
	$('#btnAgregarUm').button().click(function(){
		ventanaModal('./view/dialog/agregarUnidadMedida','','auto','auto','Registro De Unidad de Medida','modalAgregarUnidadMedida');
	});
	tabla('tblProductos');
	tabla('tblProductoEliminados');
});
