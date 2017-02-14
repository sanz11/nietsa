var base_url;
var contiene_igv;
var tipo_docu;
var tipo_codificacion;
jQuery(document).ready(function(){
    base_url   = $("#base_url").val();
	contiene_igv = $("#contiene_igv").val();
	tipo_docu   = $("#tipo_docu").val();
	tipo_codificacion = $("#tipo_codificacion").val();
    
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
		location.href = url;
		//$("#zonaContenido").load(url);
    });
    $("#limpiarPedido").click(function(){
        url = base_url+"index.php/compras/pedido/pedidos";
        location.href=url;
    });
    $("#imgCancelarPedido").click(function(){
		base_url = $("#base_url").val();
        location.href = base_url+"index.php/compras/pedido/pedidos";
    });
	$('#ruc_cliente').keyup(function (e) {
        var key = e.keyCode || e.which;
        if (key == 13) {
            if ($(this).val() != '') {
                $('#linkSelecCliente').attr('href', base_url + 'index.php/ventas/cliente/ventana_selecciona_cliente/' + $('#ruc_cliente').val()).click();
            }
        }
    });

    $('#nombre_cliente').keyup(function (e) {
        var key = e.keyCode || e.which;
        if (key == 13) {
            if ($(this).val() != '') {
                $('#linkSelecCliente').attr('href', base_url + 'index.php/ventas/cliente/ventana_selecciona_cliente/' + $('#nombre_cliente').val()).click();
            }
        }
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
						//location.href = base_url+"index.php/compras/pedido/pedidos";
					});
				}
				else if(modo=='modificar'){
					url = base_url+"index.php/compras/pedido/modificar_pedido";
					$.post(url,dataString,function(data){
						$("#VentanaTransparente").css("display","none");
						alert('Su registro ha sido modificado.');
						//location.href = base_url+"index.php/compras/pedido/pedidos";
					});
				}
		}
	});
   
	container = $('div.container');   
});

function eliminar_producto_presupuesto(n){
	if(confirm('Esta seguro que desea eliminar este producto?')){
		a                	= "prodcodigo["+n+"]";
		b					= "eliminado["+n+"]";
		fila            	= document.getElementById(a).parentNode.parentNode.parentNode;
		fila.style.display	="none";
		document.getElementById(b).value="si";
	}
}

function agregar_producto_presupuesto(){
    codproducto  = $("#codproducto").val();
	producto = $("#producto").val();
	nombre_producto = $("#nombre_producto").val();
	descuento = $("#descuento").val();
	igv = parseInt($("#igv").val());
	cantidad = $("#cantidad").val();
        if( $("#precio").val()!='')
            precio_conigv = $("#precio").val();
        else
            precio_conigv=0;
        if(contiene_igv=='1')
            precio=money_format(precio_conigv*100/(igv+100))
        else{
            precio=precio_conigv;
            precio_conigv = money_format(precio_conigv*(100+igv)/100);
        }
        unidad_medida = $("#unidad_medida").val();//select
        nombre_unidad = $('#unidad_medida option:selected').html()
	n = document.getElementById('tblDetalleCotizacion').rows.length;
	j = n+1;
	if(j%2==0){clase="itemParTabla";}else{clase="itemImparTabla";}
	
        if(codproducto==''){
            alert('Ingrese el producto.');
            $("#codproducto").focus();
            return false;
        }
        if(cantidad==''){
            alert('Ingrese una cantidad.');
            $("#cantidad").focus();
            return false;
        }
        if(unidad_medida==''){
            $("#unidad_medida").focus();
            alert('Seleccine una unidad de medida.');
            return false;
        }
        fila  = '<tr class="'+clase+'">';
        fila+='<td width="3%"><div align="center"><font color="red"><strong><a href="javascript:;" onclick="eliminar_producto_presupuesto('+n+');">';
        fila+='<span style="border:1px solid red;background: #ffffff;">&nbsp;X&nbsp;</span>';
        fila+='</a></strong></font></div></td>';
        fila +=	'<td width="4%"><div align="center">'+j+'</div></td>';
        fila += '<td width="10%"><div align="center">';
        //fila+= '<input type="hidden" name="prodcodigo['+n+']" id="prodcodigo['+n+']" value="'+producto+'">'+codproducto;
        fila+= '<input type="hidden" name="prodcodigo['+n+']" id="prodcodigo['+n+']" value="'+producto+'">'+producto;
        fila+= '<input type="hidden" name="produnidad['+n+']" id="produnidad['+n+']" value="'+unidad_medida+'">';
        fila+= '<input type="hidden" name="eliminado['+n+']" id="eliminado['+n+']" value="no">';
        fila+= '</div></td>';
        fila +=	'<td><div align="left"><input type="text" class="cajaGeneral" style="width:395px;" maxlength="250" name="proddescri['+n+']" id="proddescri['+n+']" value="'+nombre_producto+'" /></div></td>';
        if(tipo_docu!='B')
            fila+= '<td width="10%"><div align="center"><input type="text" size="1" maxlength="5" class="cajaGeneral" name="prodcantidad['+n+']" id="prodcantidad['+n+']" value="'+cantidad+'" onblur="calcula_importe('+n+');" onkeypress="return numbersonly(this,event,\'.\');">'+nombre_unidad+'</div></td>';
        else
            fila+= '<td width="10%"><div align="center"><input type="text" size="1" maxlength="5" class="cajaGeneral" name="prodcantidad['+n+']" id="prodcantidad['+n+']" value="'+cantidad+'" onblur="calcula_importe_conigv('+n+');" onkeypress="return numbersonly(this,event,\'.\');">'+nombre_unidad+'</div></td>';
        if(tipo_docu!='B'){
            fila += '<td width="6%" style="display:none;"><div align="center"><input type text" size="5" maxlength="10" class="cajaGeneral" value="'+precio+'" name="prodpu['+n+']" id="prodpu['+n+']" onblur="modifica_pu('+n+');" onkeypress="return numbersonly(this,event,\'.\');">'
            fila += '<td width="6%" style="display:none;"><div align="center"><input type="text" size="5" maxlength="10" class="cajaGeneral cajaSoloLectura" name="prodprecio['+n+']" id="prodprecio['+n+']" value="0" readonly="readonly"></div></td>';
            fila += '<input type="hidden"  value="'+precio_conigv+'" name="prodpu_conigv['+n+']" id="prodpu_conigv['+n+']"></div></td>';
        }
        else{
            fila += '<td width="6%" style="display:none;"><div align="center"><input type="text" size="5" maxlength="10" class="cajaGeneral" value="'+precio_conigv+'" name="prodpu_conigv['+n+']" id="prodpu_conigv['+n+']" onblur="calcula_importe_conigv('+n+');" /></div></td>';
            fila += '<td width="6%" style="display:none;"><div align="center"><input type="text" size="5" maxlength="10" class="cajaGeneral cajaSoloLectura" name="prodprecio_conigv['+n+']" id="prodprecio_conigv['+n+']" value="0" readonly="readonly"></div></td>';
        }

        fila += '<td width="6%" style="display:none;"><div align="center">';           
        fila+= '<input type="hidden" name="proddescuento100['+n+']" id="proddescuento100['+n+']" value="'+descuento+'">';
        if(tipo_docu!='B')
            fila+= '<input type="text" size="5" maxlength="10" class="cajaGeneral" name="proddescuento['+n+']" id="proddescuento['+n+']" onblur="calcula_importe2('+n+');" />';
        else
            fila+= '<input type="text" size="5" maxlength="10" class="cajaGeneral" name="proddescuento_conigv['+n+']" id="proddescuento_conigv['+n+']" onblur="calcula_importe2_conigv('+n+');" />';
        fila+= '</div></td>';
        if(tipo_docu!='B')
            fila += '<td width="6%" style="display:none;"><div align="center"><input type="text" size="5" maxlength="10" class="cajaGeneral cajaSoloLectura" name="prodigv['+n+']" id="prodigv['+n+']" readonly></div></td>';
        fila += '<td width="6%" style="display:none;"><div align="center">';
        fila+='<input type="hidden" value="n" name="detaccion['+n+']" id="detaccion['+n+']">';
        fila+= '<input type="hidden" name="prodigv100['+n+']" id="prodigv100['+n+']" value="'+igv+'">';
        fila+='<input type="hidden" name="detacodi['+n+']" id="detacodi['+n+']">';
        fila+= '<input type="text" size="5" maxlength="10" class="cajaGeneral cajaSoloLectura" name="prodimporte['+n+']" id="prodimporte['+n+']" value="0" readonly="readonly">';
        fila+= '</div></td>';
        fila += '</tr>';
        $("#tblDetalleCotizacion").append(fila);
		
        inicializar_cabecera_item(); 
        return true;
}

function inicializar_cabecera_item(){
    $("#producto").val('');
    $("#codproducto").val('');
    $("#nombre_producto").val('');
    $("#cantidad").val('');
    $("#nombre_unidad").val('');
    $("#unidad_medida").val('0');
    $("#precio").val('');
    limpiar_combobox('unidad_medida');
}

function obtener_precio_producto(){
    var producto = $("#producto").val();
    $('#precio').val("");
    if(producto=='' || producto=='0')
        return false;
    var moneda = $("#moneda").val();
    if(moneda=='' || moneda=='0')
        return false;
    var unidad_medida = $("#unidad_medida").val();
    if(unidad_medida=='' || unidad_medida=='0')
        return false;
    var cliente = $("#cliente").val();
    if(cliente=='')
        cliente='0';
    var igv;
   if(contiene_igv=='1')
        igv=0;
    else
        if(tipo_docu!='B')
            igv=0;
        else
            igv=$("#igv").val();
    
    var url = base_url+"index.php/almacen/producto/JSON_precio_producto/"+producto+"/"+moneda+"/"+cliente+"/"+unidad_medida+"/"+igv;
    $.getJSON(url,function(data){
              $.each(data, function(i,item){
                    $('#precio').val(item.PRODPREC_Precio);
              });
    });
    return true;
}

function listar_unidad_medida_producto(producto){
    base_url   = $("#base_url").val();
    url          = base_url+"index.php/almacen/producto/listar_unidad_medida_producto/"+producto;
    select_umedida   = document.getElementById('unidad_medida');
      
    limpiar_combobox('unidad_medida');
    
    $("#cantidad").val('');  
    $("#precio").val('');
        
    $.getJSON(url,function(data){
          $.each(data, function(i,item){
                codigo            = item.UNDMED_Codigo;
                descripcion  = item.UNDMED_Descripcion;
                simbolo         = item.UNDMED_Simbolo;
                nombre_producto = item.PROD_Nombre;
                marca           = item.MARCC_Descripcion;
                modelo          = item.PROD_Modelo;
                presentacion    = item.PROD_Presentacion;
                opt         = document.createElement('option');
                texto       = document.createTextNode(simbolo);
                opt.appendChild(texto);
                opt.value = codigo;
                select_umedida.appendChild(opt);
          });
          var nombre;
          nombre=nombre_producto;
          if(marca)
            nombre+=' / Marca:'+marca;
          if(modelo)
            nombre+=' / Modelo: '+modelo;
          if(presentacion)
            nombre+=' / Prest: '+presentacion;  
           $("#nombre_producto").val(nombre);
    });
}

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

