$(document).ready(function(){
	tabla('tabCtaCorriente');
	$(".nuevaCtaCtePac").button().click(function(){
			//alert($(this).attr('id'))
			var id=$(this).attr('id');
			ventanaModal('./view/dialog/agregarCtaCorriente.php','pac_id='+id,'auto','auto','Crear Cuenta Corriente','modalAgregarCtaCte');
		});
});
