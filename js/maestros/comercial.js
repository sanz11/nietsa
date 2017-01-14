var base_url;
jQuery(document).ready(function(){
	base_url   = $("#base_url").val();
	$("#nuevoComercial").click(function(){
		url = base_url+"index.php/maestros/comercial/nuevo_comercial";
		location.href = url;
	});	
 	$("#grabarComercial").click(function(){
		$("#frmComercial").submit();	
	}); 
	$("#limpiarComercial").click(function(){
            url = base_url+"index.php/maestros/comercial/comerciales";
            $("#txtComercial").val('');
            location.href=url;
	});
        $("#imprimirComercial").click(function(){
		
		///
        url = base_url+"index.php/maestros/comercial/registro_comerciales_pdf/";
        window.open(url,'',"width=800,height=600,menubars=no,resizable=no;");
    });
	$("#cancelarComercial").click(function(){
            url = base_url+"index.php/maestros/comercial/comerciales";
            location.href = url;
	});
	$("#buscarComercial").click(function(){
            $("#form_busquedaComercial").submit();
	});	
});
function editar_comercial(comercial){
	location.href = base_url+"index.php/maestros/comercial/editar_comercial/"+comercial;
}
function eliminar_comercial(comercial){
	if(confirm('¿Está seguro que desea eliminar este comercial?')){
		dataString        = "comercial="+comercial;
                url = base_url+"index.php/maestros/comercial/eliminar_comercial";
		$.post(url,dataString,function(data){
			location.href = base_url+"index.php/maestros/comercial/comerciales";		
		});			
	}
}
function ver_comercial(comercial){
  location.href = base_url+"index.php/maestros/comercial/ver_comercial/"+comercial;
}
function atras_comercial(){
	location.href = base_url+"index.php/maestros/comercial/comerciales";
}