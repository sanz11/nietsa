var base_url
jQuery(document).ready(function(){
    base_url   = $("#base_url").val();
    
    $("#imgGuardarPedido").click(function(){
		dataString = $('#frmPedido').serialize();
		$("#container").show();
		$("#frmPedido").submit();
    });
    $("#buscarPedido").click(function(){
		$("#form_busqueda").submit();
    });	
    $("#nuevoPedido").click(function(){
		url = base_url+"index.php/compras/pedido/nuevo_pedido";
		$("#zonaContenido").load(url);
    });
    $("#limpiarPedido").click(function(){
        url = base_url+"index.php/compras/pedido/pedidos";
        location.href=url;
    });
    $("#imgCancelarPedido").click(function(){
	base_url = $("#base_url").val();
        location.href = base_url+"index.php/compras/pedido/pedidos";
    });
    
	container = $('div.container');
 	$("#frmPedido").validate({
		event    : "blur",
		rules    : {
					'centro_costo' : "required",
					'responsable_value' : "required",
					'observacion'  : "required",
 				   },
		debug    : true,
		errorContainer      : "container",
		errorLabelContainer : $(".container"),
		wrapper             : 'li',
		submitHandler       : function(form){
				var valor = $('#centro_costo').val();
				if(valor == 0){
					alert('Elija un centro de costo');
					return false;
				}
        
        valor = $('#tipo_pedido').val();
				if(valor == 0){
					alert('Elija un tipo de pedido');
					return false;
				}
				
				dataString  = $('#frmPedido').serialize();                               
				modo        = $("#modo").val();
				$('#VentanaTransparente').css("display","block");
				if(modo=='insertar'){
					url = base_url+"index.php/compras/pedido/insertar_pedido";
					$.post(url,dataString,function(data){
					$("#VentanaTransparente").css("display","none");
						alert('Se ha ingresado un pedido.');
						location.href = base_url+"index.php/compras/pedido/pedidos";
					});
				}
				else if(modo=='modificar'){
					url = base_url+"index.php/compras/pedido/modificar_pedido";
					$.post(url,dataString,function(data){
						$("#VentanaTransparente").css("display","none");
						alert('Su registro ha sido modificado.');
						location.href = base_url+"index.php/compras/pedido/pedidos";
					});
				}
		}
	});
   
	container = $('div.container');   
});
function editar_pedido(pedido){
        var url = base_url+"index.php/compras/pedido/editar_pedido/"+pedido;
	$("#zonaContenido").load(url);
}
function eliminar_pedido(pedido){
	if(confirm('Esta seguro desea eliminar este pedido?')){
		dataString = "pedido="+pedido;
		url = base_url+"index.php/compras/pedido/eliminar_pedido";
		$.post(url,dataString,function(data){
			url = base_url+"index.php/compras/pedido/pedidos";
			location.href = url;
		});
	}
}

function ver_pedido(pedido){
	url = base_url+"index.php/compras/pedido/ver_pedido/"+pedido;
	$("#zonaContenido").load(url);
}
function atras_persona(){
	location.href = base_url+"index.php/compras/pedido/pedidos";
}

