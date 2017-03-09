var base_url;
var tipo_oper;
var contiene_igv;
jQuery(document).ready(function(){
    base_url   = $("#base_url").val();
    tipo_oper    = $("#tipo_oper").val();
    contiene_igv = $("#contiene_igv").val();
         
    $("#nuevoOcompa").click(function(){
        url = base_url+"index.php/compras/ocompra/nueva_ocompra/"+tipo_oper;
        location.href = url;
    });	
    $("#grabarOcompra").click(function(){
	$( "#grabarOcompra" ).unbind( "click" );
        var error=0;
        $('img#loading').css('visibility','visible');
        var codigo=$('#codigo').val();
        if($("#serie").val()==""){
            $("#serie").focus();
            alert("Ingrese la serie.");
            $('img#loading').css('visibility','hidden');
            return false;
        }
        
        if($('#cliente').val()==""){
            alert('Seleccione Cliente')
            $('#cliente').focus();
            $('img#loading').css('visibility','hidden');
            return false;           
        }
        
        if($('#ruc_proveedor').val()==""){
            alert('Seleccione Proveedor');
            $('#ruc_proveedor').focus();
            $('img#loading').css('visibility','hidden');
            return false;           
        }
        
        if($("#formapago").val()==''){
            alert("Seleccione Forma de pago.");
            //$("#forma_pago option[value=2]").attr("selected",true);
            $('img#loading').css('visibility','hidden');
            return false;         
        }

        n = document.getElementById('tblDetalleOcompra').rows.length;
        if(n==0){
            alert("Ingrese un producto.");
            $('img#loading').css('visibility','hidden');
            return false;     
        }
                   
        if(codigo=='')
            url = base_url+"index.php/compras/ocompra/insertar_ocompra";
        else
            url = base_url+"index.php/compras/ocompra/modificar_ocompra";
            
        dataString  = $('#frmOcompra').serialize();
        $.post(url,dataString,function(data){
            $('img#loading').css('visibility','hidden');
            switch(data.result){
                case 'ok':
					location.href = base_url+"index.php/compras/ocompra/ocompras/0/"+tipo_oper;
					break;
                case 'error':
                    if(data.campo){
                        $('input[type="text"][readonly!="readonly"], select, textarea').css('background-color', '#FFFFFF');
                        $('#'+data.campo).css('background-color', '#FFC1C1').focus();
                    }else
                    if(data.msj)
                        alert(data.msj);
                    break;
                case 'error2':
                    alert(data.msj);
                    break;
            }
        },'json');
    }); 
    $("#limpiarOcompra").click(function(){
        url = base_url+"index.php/compras/ocompra/ocompras/0/"+tipo_oper;
        location.href = url;
    });
    $("#cancelarOcompra").click(function(){
        url = base_url+"index.php/compras/ocompra/ocompras/0/"+tipo_oper;
        location.href = url;
    });
    $("#aceptarOcompra").click(function(){
        url = base_url+"index.php/compras/ocompra/ocompras/0/"+tipo_oper+"/1";
        location.href = url;
    });
    $("#cancelarOcompra2").click(function(){
        url = base_url+"index.php/compras/ocompra/ocompras/0/"+tipo_oper;
        location.href = url;
    });	
    $("#buscarOcompra").click(function(){
        busqueda_ocompra();
    });
    $("#aprobarOcompra").click(function(){
        $("#flag").val('1');
        $("#frmEvaluar").submit();
    }); 
    $("#desaprobarOcompra").click(function(){
        $("#flag").val('2');
        $("#frmEvaluar").submit();
    }); 
$("#imprimirOcompra").click(function(){

    fechai2=$("#fechai").val().split("/");
    datafechaIni=fechai2[2]+"-"+fechai2[1]+"-"+fechai2[0];

    fechaf2=$("#fechaif").val().split("/");
    datafechaFin=fechaf2[2]+"-"+fechaf2[1]+"-"+fechaf2[0];


            var ruc = $("#ruc_cliente").val();
            var nombre = $("#nombre_cliente").val();

            var ruc = sintilde(ruc);
            var nombre= sintilde(nombre);
        ///
          if(docum==""){docum="--";}
          if(nombre==""){nombre="--";}

        url = base_url+"index.php/compras/ocompras/registro_ocompras_pdf/"+tipo_oper+"/"+datafechaIni+"/"+datafechaFin+"/"+ruc+"/"+ nombre;
        window.open(url,'',"width=800,height=600,menubars=no,resizable=no;");
    });


    $("#checkTodos").change(function(){
        $('input').each( function() {					
            if($("#checkTodos").attr('checked') == true){
                this.checked = true;
            } else {
                this.checked = false;
            }
        });
                
    });
    $("#repo1").click(function(){
        $("#divRepo1").show();
        $("#divRepo2").hide();
        $("#divRepo3").hide();
        $("#divRepo4").hide();
        $("#divRepo5").hide();
    }); 
    $("#repo2").click(function(){
        $("#divRepo1").hide();
        $("#divRepo3").hide();
        $("#divRepo4").hide();
        $("#divRepo5").hide();
        url = base_url+"index.php/compras/ocompra/estadisticas";
        $.post(url,'',function(data){
            $('#divRepo2').html(data).show();
        });           
    });
	
    $("#repo3").click(function(){
        $("#divRepo1").hide();
        $("#divRepo2").hide();
        $("#divRepo4").hide();
        $("#divRepo3").show();
        $("#divRepo5").hide();
    });
	
    $("#repo4").click(function(){
        $("#divRepo1").hide();
        $("#divRepo2").hide();
        $("#divRepo3").hide();
        $("#divRepo4").show();
        $("#divRepo5").hide();
    });
	
    $("#repo5").click(function(){
        $("#divRepo1").hide();
        $("#divRepo2").hide();
        $("#divRepo3").hide();
        $("#divRepo4").hide();
        $("#divRepo5").show();
    });

    function busqueda_ocompra()
    {
        var url = $('#form_busqueda').attr('action');
        var dataString = $('#form_busqueda').serialize();
        $.ajax({
            type: "POST",
            url: url,
            data: dataString,
            beforeSend: function (data) {
                $('#cargando_datos').show();
            },
            error: function (XRH, error) {
                $('#cargando_datos').hide();
                console.log(error);
            },
            success: function (data) {
                $('#cargarBusqueda').html(data);
                $('#cargando_datos').hide();
            }

        });
    }

    $('#nombre_proveedor, #ruc_proveedor, #nombre_cliente, #ruc_cliente').keyup(function(e){
        var key=e.keyCode || e.which;
        if (key==13){
            busqueda_ocompra();
        }
    });

    $('img#linkVerPersona').click(function(){
        var contacto=$('#contacto').val();
        if(contacto!='')
            window.open(base_url+'index.php/maestros/persona/persona_ventana_mostrar/'+contacto, '_blank', 'width=700,height=380,scrollbars=yes,status=yes,resizable=yes,screenx=0,screeny=0'); 
    });
    $('#contacto').change(function(){
        if(this.value!=''){
            var contacto=this.value;
            $('#linkVerPersona').show().attr('href', base_url+'index.php/maestros/persona/persona_ventana_mostrar/0/'+contacto);
        }
        else
            $('#linkVerPersona').hide();
    });
    $("#lugar_entrega").click(function() {
        $('#lista_direcciones').slideUp("fast"); 
        $('#lista_direcciones_fact').slideUp("fast"); 
    });
    $("#linkVerDirecciones").click(function(){
        if(tipo_oper=='V')
            var cliente=$("#cliente").val();
       else
			var proveedor=$("#proveedor").val();
			
        $("#lista_direcciones ul").html('');
        $("#lista_direcciones_fact").slideUp("fast");
        $("#lista_direcciones").slideToggle("fast", function(){
            if(tipo_oper !='V')
                  url = base_url+"index.php/compras/proveedor/JSON_listar_sucursalesEmpresa/"+proveedor;
			else
                url = base_url+"index.php/ventas/cliente/JSON_listar_sucursalesEmpresa/"+cliente;
				
            $.getJSON(url,function(data){
                $.each(data, function(i,item){
                    fila='';
                    if(item.Tipo=='1'){
                        fila+='<li style="list-style: none; font-weight:bold; color:#aaa"">'+item.Titulo+'</li>';
                    }
                    else{
                        fila+='<li><a href="javascript:;">'+item.EESTAC_Direccion;
                        if(item.distrito!='')
                            fila+=' / '+item.distrito;
                        if(item.provincia!='')
                            fila+=' / '+item.provincia;
                        if(item.departamento!='')
                            fila+=' / '+item.departamento;  
                        fila+='</a></li>';
                    } 
                    $("#lista_direcciones ul").append(fila);
                });
            });
            return true;
        });
        return true;
    });
    $("#lista_direcciones li a").live('click',function(){
        $("#envio_direccion").val($(this).html());
        $('#lista_direcciones').slideUp("fast"); 
    });
        
    $("#fact_direccion, #envio_direccion").click(function() {
        $('#lista_direcciones').slideUp("fast"); 
        $('#lista_direcciones_fact').slideUp("fast"); 
    });
    $("#linkVerDirecciones_fact").click(function(){
        if(tipo_oper=='V')
            var cliente=$("#cliente").val();
		else
			var proveedor=$("#proveedor").val();	
                
        $('#lista_direcciones').slideUp("fast"); 
        $("#lista_direcciones_fact ul").html('');
        $("#lista_direcciones_fact").slideToggle("fast", function(){
            var url;
            if(tipo_oper !='V')
               url = base_url+"index.php/compras/proveedor/JSON_listar_sucursalesEmpresa/"+proveedor;
            else
                url = base_url+"index.php/ventas/cliente/JSON_listar_sucursalesEmpresa/"+cliente;
				
            $.getJSON(url,function(data){
                $.each(data, function(i,item){
                    fila='';
                    if(item.Tipo=='1'){
                        fila+='<li style="list-style: none; font-weight:bold; color:#aaa"">'+item.Titulo+'1245</li>';
                    }else{
                        fila+='<li><a href="javascript:;">'+item.EESTAC_Direccion;
                        if(item.distrito!='')
                            fila+=' / '+item.distrito;
                        if(item.provincia!='')
                            fila+=' / '+item.provincia;
                        if(item.departamento!='')
                            fila+=' / '+item.departamento;  
                        fila+='</a></li>';
                    } 
                    $("#lista_direcciones_fact ul").append(fila);
                });
            });
            return true;
        });
        return true;
    });
    $("#lista_direcciones_fact li a").live('click',function(){
        $("#fact_direccion").val($(this).html());
        $('#lista_direcciones_fact').slideUp("fast"); 
    });
        
    $('#buscar_cliente').keyup(function(e){
        var key=e.keyCode || e.which;
        if (key==13){
            if($(this).val()!=''){
                $('#linkSelecCliente').attr('href', base_url+'index.php/ventas/cliente/ventana_selecciona_cliente/'+$('#buscar_cliente').val()).click();
            }
        } 
    });
          $('#nombre_cliente').keyup(function(e){
        var key=e.keyCode || e.which;
        if (key==13){
            if($(this).val()!=''){
                $('#linkSelecCliente').attr('href', base_url+'index.php/ventas/cliente/ventana_selecciona_cliente/'+$('#nombre_cliente').val()).click();
            }
        } 
    });
	$("#linkVerSerieNum").click(function () {
        var temp=$("#linkVerSerieNum p").html();
        var serienum=temp.split('-');
        $("#serie").val(serienum[0]);
        $("#numero").val(serienum[1]);
    });
	
    $('#buscar_proveedor').keyup(function(e){
        var key=e.keyCode || e.which;
        if (key==13){
            if($(this).val()!=''){
                $('#linkSelecProveedor').attr('href', base_url+'index.php/compras/proveedor/ventana_selecciona_proveedor/'+$('#buscar_proveedor').val()).click();
            }
        } 
    });
        
	 $('#nombre_proveedor').keyup(function(e){
        var key=e.keyCode || e.which;
        if (key==13){
            if($(this).val()!=''){
                $('#linkSelecProveedor').attr('href', base_url+'index.php/compras/proveedor/ventana_selecciona_proveedor/'+$('#nombre_proveedor').val()).click();
            }
        } 
    });	
		
		
    $('#buscar_producto').keyup(function(e){
        var key=e.keyCode || e.which;
        if (key==13){
            if($(this).val()!=''){                                                                                  //tipo oper estaba asi stv
                $('#linkSelecProducto').attr('href', base_url+'index.php/almacen/producto/ventana_selecciona_producto/C/'+$('#flagBS').val()+'/'+$('#buscar_producto').val()).click();
            }
        } 
    });
        
    $('#cantidad').bind('keypress', function(e) {
        tipo_oper = $("#tipo_oper").val();
        flagGenInd      = $("#flagGenInd").val();
        if(flagGenInd=='I'){
            if(e.keyCode==9 || e.keyCode==13){
                if(tipo_oper == 'V'){
                    if($(this).val()!=''){
                        var cantidad=parseInt($(this).val());
                        var stock=parseInt($('#stock').val());
                        if(cantidad>stock){
                            alert('La cantidad no debe ser mayor al stock.');
                            $(this).val('').focus();
                            return false;
                        }
                        ventana_producto_serie2_2();
                    }
                }
            }
        }
    });
        
    $('input[id^="prodcantidad"]').live('keypress', function(e) {
        var tipo_oper = $("#tipo_oper").val();
        var flagGenInd = $(this).parent().parent().parent().find('input[id^="flagGenIndDet"]').val();
        if(flagGenInd=='I'){
            if(e.keyCode==9 || e.keyCode==13){
                var almacen  = $('#almacen').val();
                var producto = $(this).parent().parent().parent().find('input[id^="prodcodigo"]').val();
                var cantidad=parseInt($(this).val());
                var stock=parseInt($(this).parent().parent().parent().find('input[id^="prodstock"]').val());
                if(tipo_oper == 'V'){
                    if($(this).val()!=''){                            
                        if(cantidad>stock){
                            alert('La cantidad no debe ser mayor al stock.');
                            $(this).val('').focus();
                            return false;
                        }
                        if(e.keyCode==13)
                            ventana_producto_serie2_3(almacen, producto, cantidad);
                    }
                }
            }
        }
        return true;
    });
})

function ver_reporte_pdf_compras(){
    var anio = $("#anioVenta").val();
    url = base_url+"index.php/ventas/comprobante/ver_reporte_pdf_commpras/"+anio;
    window.open(url,'',"width=800,height=600,menubars=no,resizable=no;")
}

function estadisticas_compras_ventas(tipo){
    var anio = $("#anioVenta2").val();
    url = base_url+"index.php/ventas/comprobante/estadisticas_compras_ventas/"+tipo+"/"+anio;
    window.open(url,'',"width=800,height=600,menubars=no,resizable=no;")
}

function estadisticas_compras_ventas_mensual(tipo){
    var anio = $("#anioVenta3").val();
    var mes = $("#mesVenta3").val();
    url = base_url+"index.php/ventas/comprobante/estadisticas_compras_ventas_mensual/"+tipo+"/"+anio+"/"+mes+"";
    window.open(url,'',"width=800,height=600,menubars=no,resizable=no;")
}

function editar_ocompra(ocompra){
    location.href=base_url+"index.php/compras/ocompra/editar_ocompra/"+ocompra+'/'+tipo_oper;
}

function ver_detalle_ocompra(ocompra){
    location.href=base_url+"index.php/compras/ocompra/ver_detalle_ocompra/"+ocompra+'/'+tipo_oper;
}

function eliminar_ocompra(ocompra){
    if(confirm('Esta seguro desea eliminar a esta Orden de Compra?')){
        dataString   = "codigo="+ocompra;
        url          = base_url+"index.php/compras/ocompra/eliminar_ocompra";
        ;
        $.post(url,dataString,function(data){
            location.href = base_url+"index.php/compras/ocompra/ocompras/0/"+tipo_oper;
        });
    }
}
function ver_ocompra(ocompra){
    location.href = base_url+"index.php/compras/ocompra/ver_ocompra/"+ocompra;
}
function ocompra_ver_pdf(ocompra){
    //url = base_url+"index.php/compras/ocompra/ocompra_ver_pdf/"+ocompra;
    url = base_url+"index.php/compras/ocompra/ocompra_ver_pdf_conmenbrete/"+ocompra+"/0";
    window.open(url,'',"width=800,height=600,menubars=no,resizable=no;")
}
function ocompra_ver_pdf_conmenbrete(ocompra){
    url = base_url+"index.php/compras/ocompra/ocompra_ver_pdf_conmenbrete/"+ocompra+"/1";
    window.open(url,'',"width=800,height=600,menubars=no,resizable=no;")
}
function atras_ocompra(){
    location.href = base_url+"index.php/compras/ocompra/ocompras/0/"+tipo_oper;
}
function ver_reporte_pdf(){
    var fechai=$('#fechai').val();
    var fechaf=$('#fechaf').val();
    var proveedor=$('#proveedor').val();
    var producto=$('#producto').val();
    var aprobado=$('#aprobado').val();
    var ingreso=$('#ingreso').val();
     var tipo_oper = $("#tipo_oper").val();
    tipo_oper="C";
    
    url = base_url+"index.php/compras/ocompra/ver_reporte_pdf/"+fechai+'_'+fechaf+'_'+proveedor+'_'+producto+'_'+aprobado+'_'+ingreso+"/"+tipo_oper;
    window.open(url,'',"width=800,height=600,menubars=no,resizable=no;")
}
function agregar_producto_ocompra(){
    flagBS  = $("#flagBS").val();
    
    if($("#producto").val()==''){
        alert('Ingrese el producto.');
        $("#codproducto").focus();
        return false;
    }
    if($("#cantidad").val()==''){
        alert('Ingrese una cantidad.');
        $("#cantidad").focus();
        return false;
    }
    if($("#unidad_medida").val()==0){
        $("#unidad_medida").focus();
        alert('Seleccione una unidad de medida.');
        return false;
    }
    
    codproducto     = $("#codproducto").val();
    producto        = $("#producto").val();
    nombre_producto = $("#nombre_producto").val();
    cantidad        = $("#cantidad").val();
    igv = parseInt($("#igv").val());
    precio_conigv = $("#precio").val();
    if(contiene_igv=='1')
        precio=money_format(precio_conigv*100/(igv+100))
    else{
        precio=precio_conigv;
        precio_conigv = money_format(precio_conigv*(100+igv)/100);
    }
    stock           = parseFloat($("#stock").val());
    costo           = parseFloat($("#costo").val());
    unidad_medida   = '';
    nombre_unidad   = '';
    if(flagBS=='B'){
        unidad_medida = $("#unidad_medida").val();
        nombre_unidad = $('#unidad_medida option:selected').html()
    }
    
    flagGenInd      = $("#flagGenInd").val();
    almacenProducto	=$("#almacenProducto").val();
    n = document.getElementById('tblDetalleOcompra').rows.length;
    j = n+1;
    if(j%2==0){
        clase="itemParTabla";
    }else{
        clase="itemImparTabla";
    }
    
    
    fila = '<tr class="'+clase+'">';
    fila+= '<td width="3%"><div align="center"><font color="red"><strong><a href="javascript:;" onclick="eliminar_producto_ocompra('+n+');">';
    fila+= '<span style="border:1px solid red;background: #ffffff;">&nbsp;X&nbsp;</span>';
    fila+= '</a></strong></font></div></td>';
    fila+= '<td width="4%"><div align="center">'+j+'</div></td>';
    fila+= '<td width="10%"><div align="center">';
    fila+= '<input type="hidden" class="cajaMinima" name="prodcodigo['+n+']" id="prodcodigo['+n+']" value="'+producto+'">'+codproducto;
    fila+= '<input type="hidden" class="cajaMinima" name="produnidad['+n+']" id="produnidad['+n+']" value="'+unidad_medida+'">';
    fila+= '<input type="hidden" class="cajaMinima" name="flagGenIndDet['+n+']" id="flagGenIndDet['+n+']" value="'+flagGenInd+'">';
    fila+= '</div></td>';
    fila+= '<td><div align="left">';
    fila+= '<input type="text" class="cajaGeneral" style="width:395px;" maxlength="250" name="proddescri['+n+']" id="proddescri['+n+']" value="'+nombre_producto+'">';
    fila+= '</div></td>';
    fila+= '<td width="10%"><div align="left">';
    fila+= '<input type="text" class="cajaGeneral" size="1" maxlength="5" name="prodcantidad['+n+']" id="prodcantidad['+n+']" value="'+cantidad+'" onblur="calcula_importe('+n+');" onkeypress="return numbersonly(this,event,\'.\');"> ' + nombre_unidad;

    fila+= '</div></td>';
    fila += '<td width="6%"><div align="center"><input type="text" size="5" maxlength="10" class="cajaGeneral" value="'+precio_conigv+'" name="prodpu_conigv['+n+']" id="prodpu_conigv['+n+']" onblur="modifica_pu_conigv('+n+');" onkeypress="return numbersonly(this,event,\'.\');" /></div></td>'
    fila += '<td width="6%"><div align="center"><input type text" size="5" maxlength="10" class="cajaGeneral" value="'+precio+'" name="prodpu['+n+']" id="prodpu['+n+']" onblur="modifica_pu('+n+');" onkeypress="return numbersonly(this,event,\'.\');">'
    fila += '<td width="6%"><div align="center"><input type="text" size="5" maxlength="10" class="cajaGeneral cajaSoloLectura" name="prodprecio['+n+']" id="prodprecio['+n+']" value="0" readonly="readonly"></div></td>';
    fila+= '<td width="6%"><div align="center"><input type="text" size="5" maxlength="10" class="cajaGeneral cajaSoloLectura" name="prodigv['+n+']" id="prodigv['+n+']" readonly></div></td>';
    fila+= '<td width="6%"><div align="center">';
    fila+= '<input type="hidden" name="detacodi['+n+']" id="detacodi['+n+']">';
    fila+= '<input type="hidden" name="detaccion['+n+']" id="detaccion['+n+']" value="n">';
    fila+= '<input type="hidden" name="prodigv100['+n+']" id="prodigv100['+n+']" value="'+igv+'">';
    fila+= '<input type="hidden" name="prodstock['+n+']" id="prodstock['+n+']" value="'+stock+'"/>';
    fila+= '<input type="hidden" name="prodcosto['+n+']" id="prodcosto['+n+']" value="'+costo+'" readonly="readonly">';
    fila += '<input type="hidden" name="almacenProducto[' + n + ']" id="almacenProducto[' + n + ']" value="' + almacenProducto + '"/>';
    fila+= '<input type="hidden" name="proddescuento100['+n+']" id="proddescuento100['+n+']" value="0">';
    fila+= '<input type="hidden" name="proddescuento['+n+']" id="proddescuento['+n+']" onblur="calcula_importe2('+n+');" />';
    fila+= '<input type="text" size="5" maxlength="10" class="cajaGeneral cajaSoloLectura" name="prodimporte['+n+']" id="prodimporte['+n+']" value="0" readonly="readonly">';
    fila+= '</div></td>';
    fila+= '</tr>';
    $("#tblDetalleOcompra").append(fila);
    
    inicializar_cabecera_item();  
    calcula_importe(n);
    return true;  
}
function eliminar_producto_ocompra(n){
    if(confirm('Esta seguro que desea eliminar este producto?')){
        tabla       = document.getElementById('tblDetalleOcompra');
        a           = "detacodi["+n+"]";
        b           = "detaccion["+n+"]";
        fila        = document.getElementById(a).parentNode.parentNode.parentNode;
        fila.style.display="none";
        document.getElementById(b).value = "e";

        calcula_totales();
    }
}
function calcula_importe(n){
    a  = "prodpu["+n+"]";
    b  = "prodcantidad["+n+"]";
    c  = "proddescuento["+n+"]";
    d  = "prodigv["+n+"]";
    e  = "prodprecio["+n+"]";
    f  = "prodimporte["+n+"]";
    g = "prodigv100["+n+"]";
    h = "proddescuento100["+n+"]";
    i = "prodpu_conigv["+n+"]";
    pu = document.getElementById(a).value;
    pu_conigv = document.getElementById(i).value;
    cantidad = document.getElementById(b).value;
    igv100 = document.getElementById(g).value;
    descuento100 =document.getElementById(h).value;
    precio = money_format(pu*cantidad);
    total_dscto = money_format(precio*descuento100/100);
    precio2 = money_format(precio-parseFloat(total_dscto));
    
    if(pu_conigv=='')
        total_igv = money_format(precio2*igv100/100);
    else{
        total_igv = money_format((pu_conigv-pu)*cantidad);
    }
    importe = money_format(precio-parseFloat(total_dscto)+parseFloat(total_igv));

    document.getElementById(c).value = total_dscto;
    document.getElementById(d).value = total_igv;
    document.getElementById(e).value = precio;
    document.getElementById(f).value = importe;
    
    calcula_totales();
}
function calcula_importe2(n){
    a  = "prodpu["+n+"]";
    b  = "prodcantidad["+n+"]";
    c  = "proddescuento["+n+"]";
    e  = "prodigv["+n+"]";
    f  = "prodprecio["+n+"]";
    g  = "prodimporte["+n+"]";
    pu           = parseFloat(document.getElementById(a).value);
    cantidad     = parseFloat(document.getElementById(b).value);
    descuento    = parseFloat(document.getElementById(c).value);
    total_igv    = parseFloat(document.getElementById(e).value);
    importe      = money_format((pu*cantidad)-descuento+total_igv);
    document.getElementById(g).value = importe;
    
    calcula_totales();
}
function calcula_totales(){
    n = document.getElementById('tblDetalleOcompra').rows.length;
    importe_total = 0;
    igv_total = 0;
    descuento_total = 0;
    precio_total = 0;


     ////aumentado
    igvtotal=0;
    importetotal=0;
    preciototal=0;
    ///

    for(i=0;i<n;i++){//Estanb al reves los campos
        a = "prodimporte["+i+"]"
        b = "prodigv["+i+"]";
        c = "proddescuento["+i+"]";
        d = "prodprecio["+i+"]";
        e  = "detaccion["+i+"]";
        if(document.getElementById(e).value!='e'){
            importe = parseFloat(document.getElementById(a).value);
            igv = parseFloat(document.getElementById(b).value);
            descuento = parseFloat(document.getElementById(c).value);
            precio = parseFloat(document.getElementById(d).value);
            importe_total = money_format(importe + importe_total);
            igv_total = money_format(igv + igv_total);
            descuento_total = money_format(descuento + descuento_total);
            precio_total = money_format(precio + precio_total);
        }
    }


    ///aumentado
       igvtotal=money_format((importe_total*18)/118);
       preciototal=money_format(importe_total-igvtotal);
       importetotal=money_format(importe_total);

    ///


    $("#importetotal").val(importetotal.toFixed(2));  //val(importe_total.toFixed(2))
    $("#igvtotal").val(igvtotal.toFixed(2));  //val(igv_total.toFixed(2))
    $("#descuentotal").val(descuento.toFixed(2));
    $("#preciototal").val(preciototal.toFixed(2));  //val(precio_total.toFixed(2))
}
function modifica_pu_conigv(n){
    a  ="prodpu_conigv["+n+"]";
    g = "prodigv100["+n+"]";
    i = "prodpu["+n+"]";
    pu_conigv = parseFloat(document.getElementById(a).value);
    igv100 = parseFloat(document.getElementById(g).value);
    
    pu = money_format(100*pu_conigv/(100+igv100));
    document.getElementById(i).value=pu;
    
    calcula_importe(n);
}
function modifica_pu(n){
    a = "prodpu["+n+"]";
    g = "prodigv100["+n+"]";
    i = "prodpu_conigv["+n+"]";
    
    pu = parseFloat(document.getElementById(a).value);
    igv100 = parseFloat(document.getElementById(g).value); 
    precio_conigv = money_format(pu*(100+igv100)/100);
    document.getElementById(i).value=precio_conigv;
    
    calcula_importe(n);
}
function modifica_descuento_total(){
    descuento = $('#descuento').val();
    n     = document.getElementById('tblDetalleOcompra').rows.length;
    for(i=0;i<n;i++){
        a = "proddescuento100["+i+"]";
        document.getElementById(a).value = descuento;
    }
    for(jj=0;jj<n;jj++){
        calcula_importe(jj);
    }
    calcula_totales();
}
function modifica_igv_total(){
    igv = $('#igv').val();
    n     = document.getElementById('tblDetalleOcompra').rows.length;
    for(i=0;i<n;i++){
        a = "prodigv100["+i+"]";
        document.getElementById(a).value = igv;
    }
    for(jj=0;jj<n;jj++){
        calcula_importe(jj);
    }
    calcula_totales();
}
function listar_unidad_medida_producto(producto){

/////////stv
    var base_url      = $("#base_url").val();
    var flagBS        = $("#flagBS").val();
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
            texto       = document.createTextNode(descripcion);
            opt.appendChild(texto);
            opt.value = codigo;
            if(i==0)
                opt.selected=true;
            select_umedida.appendChild(opt);
        });
        var nombre;
        nombre=nombre_producto;
        //        if (flagBS == 'B') {
//        	if(marca){ nombre+=' / '+marca;}
//            if(modelo){ nombre+=' /  '+modelo;}
//            if(presentacion){nombre+=' /  '+presentacion;}
//        }
        $("#nombre_producto").val(nombre);
        listar_precios_x_producto_unidad(producto);
    });
////////////

////////asi taba stv
//    base_url     = $("#base_url").val();
//    flagBS       = $("#flagBS").val();
//    url          = base_url+"index.php/almacen/producto/listar_unidad_medida_producto/"+producto;
//    select_umedida   = document.getElementById('unidad_medida');
//    options_umedida = select_umedida.getElementsByTagName("option");
//
//    var num_option=options_umedida.length;
//    for(i=1;i<=num_option;i++){
//        select_umedida.remove(0)
//    }
//    opt = document.createElement("option");
//    texto = document.createTextNode(":: Seleccione ::");
//    opt.appendChild(texto);
//    opt.value = "0";
//    select_umedida.appendChild(opt);
//    $("#cantidad").val('');
//
//    $.getJSON(url,function(data){
//        $.each(data, function(i,item){
//            codigo            = item.UNDMED_Codigo;
//            descripcion  = item.UNDMED_Descripcion;
//            marca           = item.MARCC_Descripcion;
//            modelo          = item.PROD_Modelo;
//            presentacion    = item.PROD_Presentacion;
//            simbolo         = item.UNDMED_Simbolo;
//            nombre_producto = item.PROD_Nombre;
//            opt         = document.createElement('option');
//            texto       = document.createTextNode(simbolo);
//            opt.appendChild(texto);
//            opt.value = codigo;
//            if(i==0)
//                opt.selected=true;
//            select_umedida.appendChild(opt);
//        });
//        var nombre;
//        nombre=nombre_producto;
//        if(flagBS=='B'){
//            if(marca)
//                nombre+=' / Marca:'+marca;
//            if(modelo)
//                nombre+=' / Modelo: '+modelo;
//            if(presentacion)
//                nombre+=' / Prest: '+presentacion;
//        }
//        $("#nombre_producto").val(nombre);
//        listar_precios_x_producto_unidad();
//    });
///////

}
function listar_precios_x_producto_unidad(){
    producto = $("#producto").val();
    unidad = $("#unidad_medida").val();
    moneda = $("#moneda").val();
    base_url = $("#base_url").val();
    flagBS = $("#flagBS").val();
    url          = base_url+"index.php/almacen/producto/listar_precios_x_producto_unidad/"+producto+"/"+unidad+"/"+moneda;
    select_precio   = document.getElementById('precioProducto');
    options_umedida = select_precio.getElementsByTagName("option"); 

    var num_option=options_umedida.length;
    for(i=1;i<=num_option;i++){
        select_precio.remove(0)
    }
    opt = document.createElement("option");
    texto = document.createTextNode("::Seleccion::");
    opt.appendChild(texto);
    opt.value = "";
    select_precio.appendChild(opt);
    $.getJSON(url,function(data){
        $.each(data, function(i,item){
            codigo		= item.codigo;
            moneda		= item.moneda;
            precio		= item.precio;
            opt         = document.createElement('option');
            texto       = document.createTextNode(moneda+" "+precio);
            opt.appendChild(texto);
            opt.value = precio;
            select_precio.appendChild(opt);
        });
    });
}
function mostrar_precio(){
    precio = $("#precioProducto").val();
    $("#precio").val(precio);
}
function obtener_precio_producto(){
    var producto = $("#producto").val();
    if(producto=='')
        producto='0';
    var moneda = $("#moneda").val();
    if(moneda=='')
        moneda='0';
    var cliente = $("#cliente").val();
    if(cliente=='')
        cliente='0';
    var unidad_medida = $("#unidad_medida").val();
    if(unidad_medida=='')
        unidad_medida='0';
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
}
function inicializar_cabecera_item(){
    $("#producto").val('');
    $("#buscar_producto").val('');
    $("#buscar_producto").val('');
    $("#codproducto").val('');
    $("#nombre_producto").val('');
    $("#cantidad").val('');
    $("#costo").val('');
    $("#unidad_medida").val('0');
    $("#precioProducto").val('');
    $("#precio").val('');
    limpiar_combobox('unidad_medida');
}

function load_cotizaciones(){
    var value = $('#pedidos').val();
    if(value == ''){
        $('#text_cotizacion').html("");
        $("#show_cotizaciones").html("");
    }else{
        var url = base_url+"index.php/compras/cuadrocom/cargar_ganadores/"+value;
        $("#show_cotizaciones").load(url);
        $('#text_cotizacion').html("Cotizacion :");
    }
	
}


function obtener_detalle_cotizacion(){//En realidad es detalle de la cotizacion
    cotizacion =  $("#cotizacion").val();
    descuento  =  $("#descuento").val();
    igv        = $("#igv").val();
    url = base_url+"index.php/compras/ocompra/obtener_detalle_cotizacion/"+cotizacion;//Es detalle de la cotizacion
    dataString = "cotizacion="+cotizacion;
    n = 0;
    $.getJSON(url,function(data){
        fila= '<table width="100%" height="250px;" border="0" cellpadding="0" cellspacing="0">';
        fila+= '<tr>';
        fila+= '<td valign="top">';
        fila = '<table id="tblDetalleOcompra" class="fuente8" width="100%" border="0">';
        $.each(data,function(i,item){
            pedido          = item.PEDIP_Codigo;
            n=i;
            j=i+1
            producto        = item.PROD_Codigo;
            codproducto     = item.PROD_CodigoInterno;
            unidad_medida   = item.UNDMED_Codigo;
            nombre_unidad   =item.UNDMED_Simbolo;
            nombre_producto = item.PROD_Nombre;
            cantidad        = item.COTDEC_Cantidad;
            proveedor       = item.PROVP_Codigo;
            ruc             = item.Ruc;
            razon_social    = item.RazonSocial;
            almacen         = item.ALMAP_Codigo;
            formapago       = item.FORPAP_Codigo;
            if((i+1)%2==0){
                clase="itemParTabla";
            }else{
                clase="itemImparTabla";
            }
            fila += '<tr class="'+clase+'">';
            fila +='<td width="3%"><div align="center"><font color="red"><strong><a href="javascript:;" onclick="eliminar_producto_ocompra('+n+');">';
            fila +='<span style="border:1px solid red;background: #ffffff;">&nbsp;X&nbsp;</span>';
            fila +='</a></strong></font></div></td>';
            fila +=	'<td width="4%"><div align="center">'+j+'</div></td>';
            fila += '<td width="10%"><div align="center">';
            fila += '<input type="hidden" class="cajaMinima" name="prodcodigo['+n+']" id="prodcodigo['+n+']" value="'+producto+'">'+codproducto;
            fila += '<input type="hidden" class="cajaMinima" name="produnidad['+n+']" id="produnidad['+n+']" value="'+unidad_medida+'">';
            fila += '</div></td>';
            fila +=	'<td><div align="left"><input type="text" class="cajaGeneral" style="width:335px;" maxlength="250" name="proddescri['+n+']" id="proddescri['+n+']" value="'+nombre_producto+'" /></div></td>';
            fila += '<td width="10%"><div align="left">';
            fila += '<input type="text" class="cajaPequena2" name="prodcantidad['+n+']" id="prodcantidad['+n+']" value="'+cantidad+'" onblur="calcula_importe('+n+');calcula_totales();" onkeypress="return numbersonly(this,event,\'.\');">'+nombre_unidad;
            fila += '</div></td>';
            fila += '<td width="6%"><div align="center">';
            fila += '<input type="text" class="cajaPequena2" name="prodpu['+n+']" id="prodpu['+n+']" value="" onblur="calcula_importe('+n+');calcula_totales();" onkeypress="return numbersonly(this,event,\'.\');"></div></td>';
            fila += '<td width="6%"><div align="center">';
            fila += '<input type="text" class="cajaPequena2" name="prodprecio['+n+']" id="prodprecio['+n+']" value="0" readonly="readonly">';
            fila += '</div></td>';
            fila += '<td width="6%"><div align="center">';
            fila += '<input type="hidden" class="cajaPequena2" name="proddescuento100['+n+']" id="proddescuento100['+n+']" value="'+descuento+'">';
            fila += '<input type="text" class="cajaPequena2" name="proddescuento['+n+']" id="proddescuento['+n+']" onblur="calcula_importe2('+n+');calcula_totales();">';
            fila += '</div></td>';
            fila += '<td width="6%"><div align="center">';
            fila += '<input type="hidden" class="cajaPequena2" name="prodigv100['+n+']" id="prodigv100['+n+']" value="'+igv+'">';
            fila += '<input type="text" class="cajaPequena2" name="prodigv['+n+']" id="prodigv['+n+']" readonly>';
            fila += '</div></td>';
            fila += '<td width="6%"><div align="center">';
            fila += '<input type="text" class="cajaPequena2" name="proddescuento2['+n+']" id="proddescuento2['+n+']" value="0" onblur="calcula_importe2('+n+');calcula_totales();">';
            fila += '</div></td>';
            fila += '<td width="6%"><div align="center">';
            fila +='<input type="hidden" class="cajaMinima" name="detacodi['+n+']" id="detacodi['+n+']">';
            fila +='<input type="hidden" class="cajaMinima" name="detaccion['+n+']" id="detaccion['+n+']" value="n">';
            fila += '<input type="text" class="cajaPequena2" name="prodimporte['+n+']" id="prodimporte['+n+']" value="0" readonly="readonly" value="0">';
            fila += '</div></td>';
            fila += '</tr>';
        })
        fila+='</table>'
        fila+= '</td>';
        fila+= '</tr>';
        fila+= '</table>';
        $('#pedido').val(pedido);
        $('#ruc_proveedor').val(ruc);
        $('#proveedor').val(proveedor);
        $('#nombre_proveedor').val(razon_social);
        $('#almacen').val(almacen);
        $('#formapago').val(formapago);
        $(".divBusqueda").hide();
        if(n>=0){
            $("#lineaResultado2").html(fila);
        }
        else{
            $("#lineaResultado2").html('');
            alert('La cotizacion no tiene elementos.');
        }
    });
}

function obtener_detalle_presupuesto_compra(){
    presupuesto =  $("#pedidos_ganadores").val();
    descuento100  =  $("#descuento").val();
    igv100        = $("#igv").val();
    
    url = base_url+"index.php/ventas/presupuesto/obtener_detalle_presupuesto/"+presupuesto;
    n = document.getElementById('tblDetalleOcompra').rows.length;
    $.getJSON(url,function(data){
        limpiar_datos();
        $.each(data,function(i,item){
            pedido          = item.PEDIP_Codigo;
            j=n+1
            producto        = item.PROD_Codigo;
            codproducto     = item.PROD_CodigoInterno;
            moneda          = item.MONED_Codigo;
            unidad_medida   = item.UNDMED_Codigo;
            nombre_unidad   = item.UNDMED_Simbolo;
            nombre_producto = item.PROD_Nombre;
            cantidad        = item.PRESDEC_Cantidad;
            pu              = item.PRESDEC_Pu;
            subtotal        = item.PRESDEC_Subtotal;
            descuento       = item.PRESDEC_Descuento;
            igv             = item.PRESDEC_Igv;
            total           = item.PRESDEC_Total
            pu_conigv              = item.PRESDEC_Pu_ConIgv;
            subtotal_conigv        = item.PRESDEC_Subtotal_ConIgv;
            descuento_conigv       = item.PRESDEC_Descuento_ConIgv;	
            cliente         = item.CLIP_Codigo ;
            ruc             = item.Ruc;
            razon_social    = item.RazonSocial;
            formapago       = item.FORPAP_Codigo;
            if(j%2==0){
                clase="itemParTabla";
            }else{
                clase="itemImparTabla";
            }
            fila = '<tr class="'+clase+'">';
            fila +='<td width="3%"><div align="center"><font color="red"><strong><a href="javascript:;" onclick="eliminar_producto_ocompra('+n+');">';
            fila +='<span style="border:1px solid red;background: #ffffff;">&nbsp;X&nbsp;</span>';
            fila +='</a></strong></font></div></td>';
            fila +=	'<td width="4%"><div align="center">'+j+'</div></td>';
            fila += '<td width="10%"><div align="center">';
            fila += '<input type="hidden" class="cajaGeneral" name="prodcodigo['+n+']" id="prodcodigo['+n+']" value="'+producto+'">'+codproducto;
            fila += '<input type="hidden" class="cajaGeneral" name="produnidad['+n+']" id="produnidad['+n+']" value="'+unidad_medida+'">';
            fila += '</div></td>';
            fila +=	'<td><div align="left"><input type="text" class="cajaGeneral" style="width:335px;" maxlength="250" name="proddescri['+n+']" id="proddescri['+n+']" value="'+nombre_producto+'" /></div></td>';
            fila += '<td width="10%"><div align="left"><input type="text" size="1" maxlength="5" class="cajaGeneral" name="prodcantidad['+n+']" id="prodcantidad['+n+']" value="'+cantidad+'" onblur="calcula_importe('+n+');calcula_totales();" onkeypress="return numbersonly(this,event,\'.\');">'+nombre_unidad+'</div></td>';
            fila += '<td width="6%"><div align="center"><input type="text" size="5" maxlength="10" class="cajaGeneral" name="prodpu['+n+']" id="prodpu['+n+']" value="'+pu+'" onblur="calcula_importe('+n+');calcula_totales();" onkeypress="return numbersonly(this,event,\'.\');"></div></td>';
            fila += '<td width="6%"><input type="text" class="cajaGeneral cajaSoloLectura" size="5" maxlength="10" name="prodprecio['+n+']" id="prodprecio['+n+']" value="'+subtotal+'" readonly="readonly"></div></td>';
            fila += '<td width="6%"><div align="center">';
            fila += '<input type="hidden" name="proddescuento100['+n+']" id="proddescuento100['+n+']" value="'+descuento100+'">';
            fila += '<input type="text" size="5" maxlength="10" class="cajaGeneral" name="proddescuento['+n+']" id="proddescuento['+n+']" value="'+descuento+'" onblur="calcula_importe2('+n+');calcula_totales();">';
            fila += '</div></td>';
            fila += '<td width="6%"><div align="center"><input type="text" size="5" class="cajaGeneral cajaSoloLectura" name="prodigv['+n+']" value="'+igv+'" id="prodigv['+n+']" readonly></div></td>';
            fila += '<td width="6%"><div align="center">';
            fila+= '<input type="text" size="5" maxlength="10" class="cajaGeneral" name="proddescuento2['+n+']" id="proddescuento2['+n+']" value="0" onblur="calcula_importe2('+n+');calcula_totales();">';
            fila+= '</div></td>'; 
            fila += '<td width="6%"><div align="center">';
            fila +='<input type="hidden" name="detacodi['+n+']" id="detacodi['+n+']">';
            fila += '<input type="hidden" name="prodigv100['+n+']" id="prodigv100['+n+']" value="'+igv100+'">';
            fila +='<input type="hidden" name="detaccion['+n+']" id="detaccion['+n+']" value="n">';
            fila += '<input type="text" size="5" class="cajaGeneral cajaSoloLectura" name="prodimporte['+n+']" id="prodimporte['+n+']" value="'+total+'" readonly="readonly" value="0">';
            fila += '</div></td>';
            fila += '</tr>';
            $("#tblDetalleOcompra").append(fila);
            $('#ruc_cliente').val(ruc);
            $('#cliente').val(cliente);
            $('#nombre_cliente').val(razon_social);
            $('#formapago').val(formapago);
            $('#moneda').val(moneda);
            n++;
        })
           
        if(n>=0){
            calcula_totales();
        }
        else{
            alert('El presupuesto no tiene elementos.');
        }
    });
}


function obtener_detalle_presupuesto(){
    presupuesto =  $("#presupuesto").val();
    descuento100  =  $("#descuento").val();
    igv100        = $("#igv").val();
    
    url = base_url+"index.php/ventas/presupuesto/obtener_detalle_presupuesto/"+presupuesto;
    n = document.getElementById('tblDetalleOcompra').rows.length;
    $.getJSON(url,function(data){
        limpiar_datos();
        $.each(data,function(i,item){
            pedido          = item.PEDIP_Codigo;
            j=n+1
            producto        = item.PROD_Codigo;
            codproducto     = item.PROD_CodigoInterno;
            moneda          = item.MONED_Codigo;
            unidad_medida   = item.UNDMED_Codigo;
            nombre_unidad   = item.UNDMED_Simbolo;
            nombre_producto = item.PROD_Nombre;
            cantidad        = item.PRESDEC_Cantidad;
            pu              = item.PRESDEC_Pu;
            subtotal        = item.PRESDEC_Subtotal;
            descuento       = item.PRESDEC_Descuento;
            igv             = item.PRESDEC_Igv;
            total           = item.PRESDEC_Total
            pu_conigv              = item.PRESDEC_Pu_ConIgv;
            subtotal_conigv        = item.PRESDEC_Subtotal_ConIgv;
            descuento_conigv       = item.PRESDEC_Descuento_ConIgv;	
            cliente         = item.CLIP_Codigo ;
            ruc             = item.Ruc;
            razon_social    = item.RazonSocial;
            formapago       = item.FORPAP_Codigo;
            if(j%2==0){
                clase="itemParTabla";
            }else{
                clase="itemImparTabla";
            }
            fila = '<tr class="'+clase+'">';
            fila +='<td width="3%"><div align="center"><font color="red"><strong><a href="javascript:;" onclick="eliminar_producto_ocompra('+n+');">';
            fila +='<span style="border:1px solid red;background: #ffffff;">&nbsp;X&nbsp;</span>';
            fila +='</a></strong></font></div></td>';
            fila +=	'<td width="4%"><div align="center">'+j+'</div></td>';
            fila += '<td width="10%"><div align="center">';
            fila += '<input type="hidden" class="cajaGeneral" name="prodcodigo['+n+']" id="prodcodigo['+n+']" value="'+producto+'">'+codproducto;
            fila += '<input type="hidden" class="cajaGeneral" name="produnidad['+n+']" id="produnidad['+n+']" value="'+unidad_medida+'">';
            fila += '</div></td>';
            fila +=	'<td><div align="left"><input type="text" class="cajaGeneral" style="width:335px;" maxlength="250" name="proddescri['+n+']" id="proddescri['+n+']" value="'+nombre_producto+'" /></div></td>';
            fila += '<td width="10%"><div align="left"><input type="text" size="1" maxlength="5" class="cajaGeneral" name="prodcantidad['+n+']" id="prodcantidad['+n+']" value="'+cantidad+'" onblur="calcula_importe('+n+');calcula_totales();" onkeypress="return numbersonly(this,event,\'.\');">'+nombre_unidad+'</div></td>';
            fila += '<td width="6%"><div align="center"><input type="text" size="5" maxlength="10" class="cajaGeneral" name="prodpu['+n+']" id="prodpu['+n+']" value="'+pu+'" onblur="calcula_importe('+n+');calcula_totales();" onkeypress="return numbersonly(this,event,\'.\');"></div></td>';
            fila += '<td width="6%"><input type="text" class="cajaGeneral cajaSoloLectura" size="5" maxlength="10" name="prodprecio['+n+']" id="prodprecio['+n+']" value="'+subtotal+'" readonly="readonly"></div></td>';
            fila += '<td width="6%"><div align="center">';
            fila += '<input type="hidden" name="proddescuento100['+n+']" id="proddescuento100['+n+']" value="'+descuento100+'">';
            fila += '<input type="text" size="5" maxlength="10" class="cajaGeneral" name="proddescuento['+n+']" id="proddescuento['+n+']" value="'+descuento+'" onblur="calcula_importe2('+n+');calcula_totales();">';
            fila += '</div></td>';
            fila += '<td width="6%"><div align="center"><input type="text" size="5" class="cajaGeneral cajaSoloLectura" name="prodigv['+n+']" value="'+igv+'" id="prodigv['+n+']" readonly></div></td>';
            fila += '<td width="6%"><div align="center">';
            fila+= '<input type="text" size="5" maxlength="10" class="cajaGeneral" name="proddescuento2['+n+']" id="proddescuento2['+n+']" value="0" onblur="calcula_importe2('+n+');calcula_totales();">';
            fila+= '</div></td>'; 
            fila += '<td width="6%"><div align="center">';
            fila +='<input type="hidden" name="detacodi['+n+']" id="detacodi['+n+']">';
            fila += '<input type="hidden" name="prodigv100['+n+']" id="prodigv100['+n+']" value="'+igv100+'">';
            fila +='<input type="hidden" name="detaccion['+n+']" id="detaccion['+n+']" value="n">';
            fila += '<input type="text" size="5" class="cajaGeneral cajaSoloLectura" name="prodimporte['+n+']" id="prodimporte['+n+']" value="'+total+'" readonly="readonly" value="0">';
            fila += '</div></td>';
            fila += '</tr>';
            $("#tblDetalleOcompra").append(fila);
            $('#ruc_cliente').val(ruc);
            $('#cliente').val(cliente);
            $('#nombre_cliente').val(razon_social);
            $('#formapago').val(formapago);
            $('#moneda').val(moneda);
            n++;
        })
           
        if(n>=0){
            calcula_totales();
        }
        else{
            alert('El presupuesto no tiene elementos.');
        }
    });
}

function ventana_ocompra_factura(ocompra){
    url = base_url+"index.php/compras/ocompra/ventana_ocompra_factura/"+ocompra;
    location.href = url;
}
function limpiar_datos(){
    n = document.getElementById('tblDetalleOcompra').rows.length;
    for(i=0;i<n;i++){
        a                = "detacodi["+i+"]";
        b                = "detaccion["+i+"]";
        fila            = document.getElementById(a).parentNode.parentNode.parentNode;
        fila.style.display="none";
        document.getElementById(b).value = "e";
    }
}
function obtener_cliente(){
    var numdoc = $("#ruc_cliente").val();
    $('#cliente,#nombre_cliente').val('');
    
    if(numdoc=='')
        return false;

    var url = base_url+"index.php/ventas/cliente/JSON_buscar_cliente/"+numdoc;
    $.getJSON(url,function(data){
        $.each(data, function(i,item){
            if(item.EMPRC_RazonSocial!=''){
                $('#nombre_cliente').val(item.EMPRC_RazonSocial);
                $('#cliente').val(item.CLIP_Codigo);
                $('#codproducto').focus();
            }
            else{
                $('#nombre_cliente').val('No se encontró ningún registro');
                $('#linkVerCliente').focus();
            }
        });
    });
    return true;
}
function obtener_proveedor(){
    var numdoc = $("#ruc_proveedor").val();
    $("#proveedor, #nombre_proveedor").val('');
    
    if(numdoc=='')
        return false;

    var url = base_url+"index.php/compras/proveedor/obtener_nombre_proveedor/"+numdoc;
    $.getJSON(url,function(data){
        $.each(data, function(i,item){
            if(item.EMPRC_RazonSocial!=''){
                $('#nombre_proveedor').val(item.EMPRC_RazonSocial);
                $('#proveedor').val(item.PROVP_Codigo);
                $('#codproducto').focus();
            }
            else{
                $('#nombre_proveedor').val('No se encontró ningún registro');
                $('#linkVerProveedor').focus();
            }
        });
    });
    return true;
}
function obtener_producto(){
    var flagBS        = $("#flagBS").val();
    var codproducto   = $("#codproducto").val();
    $("#producto, #nombre_producto").val('');
    if(codproducto=='')
        return false;
    
    var url = base_url+"index.php/almacen/producto/obtener_nombre_producto/"+flagBS+"/"+codproducto;
    $.getJSON(url,function(data){
        $.each(data,function(i,item){
            if(item.PROD_Nombre!=''){
                $("#producto").val(item.PROD_Codigo);
                $("#nombre_producto").val(item.PROD_Nombre);
                listar_unidad_medida_producto($("#producto").val());
                $('#cantidad').focus();
            }
            else{
                $('#nombre_producto').val('No se encontró ningún registro');
                $('#linkVerProducto').focus();
            }
                 
        });
    });
    return true;
}
function listar_contactos(empresa){
    a      = "contacto";
    select = document.getElementById(a);
    
    limpiar_combobox("contacto");
    
    if(tipo_oper=='V')
        cargo='5';
    else
        cargo='4';
    url = base_url+"index.php/maestros/empresa/JSON_listar_personal/"+empresa+"/"+cargo;
    $.getJSON(url,function(data){
        $.each(data, function(i,item){
            codigo      = item.DIREP_Codigo;
            descripcion = item.PERSC_ApellidoPaterno+' '+item.PERSC_ApellidoMaterno+' '+item.PERSC_Nombre;
            opt         = document.createElement('option');
            texto   = document.createTextNode(descripcion);
            opt.appendChild(texto);
            opt.value = codigo;
            select.appendChild(opt);
            
        });
    });
    return true;
}
function limpiar_campos_producto(){
    $("#producto,  #codproducto, #nombre_producto, #cantidad, #precio").val('');
    limpiar_combobox('unidad_medida');
    if($('#flagBS').val()=='B')
        $('#unidad_medida').show();
    else
        $('#unidad_medida').hide();
    $('#linkVerProducto').attr('href', ''+base_url+'index.php/almacen/producto/ventana_busqueda_producto/'+$('#flagBS').val());
}
 function agregar_todoocompra(guia){
 
    descuento100  =  $("#descuento").val();
    igv100        = $("#igv").val();
    url = base_url+"index.php/compras/ocompra/obtener_detalle_ocompra2/"+guia;
    n = document.getElementById('tblDetalleOcompra').rows.length;  
    $.getJSON(url,function(data){
        limpiar_datos();
        $.each(data,function(i,item){
            moneda          = item.MONED_Codigo;
            formapago       = item.FORPAP_Codigo;
            serie           = item.PRESUC_Serie;
            numero          = item.OCOMDEC_Numero;
            codigo_usuario  = item.OCOMDEC_CodigoUsuario;
                         
            if(item.OCOMDEP_Codigo!=''){
                j=n+1
                producto        = item.PROD_Codigo;
                codproducto     = item.PROD_CodigoInterno;
                unidad_medida   = item.UNDMED_Codigo;
                nombre_unidad   = item.UNDMED_Simbolo;
                nombre_producto = item.PROD_Nombre;
                flagGenInd      = item.OCOMDEC_GenInd;
                costo           = item.OCOMDEC_Costo;
                cantidad        = item.OCOMDEC_Cantidad;
                pu              = item.OCOMDEC_Pu;
                subtotal        = item.OCOMDEC_Subtotal;
                descuento       = item.OCOMDEC_Descuento;
                igv             = item.OCOMDEC_Igv;
                total           = item.OCOMDEC_Total;
                pu_conigv              = item.OCOMDEC_Pu_ConIgv;
                subtotal_conigv        = item.OCOMDEC_Subtotal_ConIgv;
                   
                descuento_conigv       = item.OCOMDEC_Descuento_ConIgv;	

				if(j%2==0){
                    clase="itemParTabla";
                }else{
                    clase="itemImparTabla";
                }
                fila = '<tr class="'+clase+'">';
                fila +='<td width="3%"><div align="center"><font color="red"><strong><a href="javascript:;" onclick="eliminar_producto_ocompra('+n+');">';
                fila +='<span style="border:1px solid red;background: #ffffff;">&nbsp;X&nbsp;</span>';
                fila +='</a></strong></font></div></td>';
                fila += '<td width="4%"><div align="center">'+j+'</div></td>';
                fila += '<td width="10%"><div align="center">';
                fila += '<input type="hidden" class="cajaGeneral" name="prodcodigo['+n+']" id="prodcodigo['+n+']" value="'+producto+'">'+codproducto;
                fila += '<input type="hidden" class="cajaGeneral" name="produnidad['+n+']" id="produnidad['+n+']" value="'+unidad_medida+'">';
                fila+= '<input type="hidden" class="cajaMinima" name="flagGenIndDet['+n+']" id="flagGenIndDet['+n+']" value="'+flagGenInd+'">';
                fila += '</div></td>';
                fila += '<td><div align="left"><input type="text" class="cajaGeneral" size="73" maxlength="250" name="proddescri['+n+']" id="proddescri['+n+']" value="'+nombre_producto+'" /></div></td>';
                fila += '<td width="10%"><div align="left"><input type="text" size="1" maxlength="5" class="cajaGeneral" name="prodcantidad['+n+']" id="prodcantidad['+n+']" value="'+cantidad+'" onblur="calcula_importe('+n+');calcula_totales();" onkeypress="return numbersonly(this,event,\'.\');">'+nombre_unidad;
            
                fila += '</div></td>';
				fila += '<td width="6%"><div align="center"><input type="text" name="prodpu_conigv['+n+']" id="prodpu_conigv['+n+']" value="'+pu_conigv+'" size="5" maxlength="10" class="cajaGeneral" onblur="modifica_pu_conigv('+n+');"></div></td>';
                fila += '<td width="6%"><div align="center"><input type="text" size="5" maxlength="10" class="cajaGeneral" name="prodpu['+n+']" id="prodpu['+n+']" value="'+pu+'" onblur="modifica_pu('+n+');" onkeypress="return numbersonly(this,event,\'.\');"></div></td>';                  
                
				fila += '<td width="6%"><input type="text" class="cajaGeneral cajaSoloLectura" size="5" maxlength="10" name="prodprecio['+n+']" id="prodprecio['+n+']" value="'+subtotal+'" readonly="readonly"></div></td>';
				fila += '<td width="6%" style="display:none;"><div align="center">';
                fila += '<input type="hidden" name="proddescuento100['+n+']" id="proddescuento100['+n+']" value="'+descuento100+'">';
                fila += '<input type="hidden" size="5" maxlength="10" class="cajaGeneral" name="proddescuento['+n+']" id="proddescuento['+n+']" value="'+descuento+'" onblur="calcula_importe2('+n+');calcula_totales();">';
 
                fila += '</div></td>';
                fila += '<td width="6%"><div align="center"><input type="text" size="5" class="cajaGeneral cajaSoloLectura" name="prodigv['+n+']" value="'+igv+'" id="prodigv['+n+']" readonly></div></td>';
                fila += '<td width="6%"><div align="center">';
                fila +='<input type="hidden" name="detacodi['+n+']" id="detacodi['+n+']">';
                fila +='<input type="hidden" name="detaccion['+n+']" id="detaccion['+n+']" value="n">';
                fila += '<input type="hidden" name="prodigv100['+n+']" id="prodigv100['+n+']" value="'+igv100+'">';
                fila+= '<input type="hidden" class="cajaPequena2" name="prodcosto['+n+']" id="prodcosto['+n+']" value="'+costo+'" readonly="readonly">';
                fila+= '<input type="hidden" class="cajaPequena2" name="prodventa['+n+']" id="prodventa['+n+']" value="0" readonly="readonly">';                  
                fila += '<input type="text" size="5" class="cajaGeneral cajaSoloLectura" name="prodimporte['+n+']" id="prodimporte['+n+']" value="'+total+'" readonly="readonly" value="0">';
                fila += '</div></td>';
                fila += '</tr>';
                $("#tblDetalleOcompra").append(fila);
				
            }
               

            $('#moneda').val(moneda);
  
            n++;      
        })
        
                calcula_totales();
       
    });
}
function agregar_todopresupuesto(guia,tipo_oper){
    
    descuento100  =  $("#descuento").val();
    igv100        = $("#igv").val();	
	tipo_docu='F';
    url = base_url+"index.php/ventas/presupuesto/obtener_detalle_presupuesto/"+tipo_oper+"/"+tipo_docu+"/"+guia;
	n = document.getElementById('tblDetalleOcompra').rows.length;
    $.getJSON(url,function(data){
        limpiar_datos();
        $.each(data,function(i,item){
            moneda          = item.MONED_Codigo;
            formapago       = item.FORPAP_Codigo;
            serie           = item.PRESUC_Serie;
            numero          = item.PRESUC_Numero;
            codigo_usuario  = item.PRESUC_CodigoUsuario;
            
            if(item.PRESDEP_Codigo!=''){
                j=n+1
                producto        		= item.PROD_Codigo;
                codproducto     		= item.PROD_CodigoInterno;
                unidad_medida   		= item.UNDMED_Codigo;
                nombre_unidad   		= item.UNDMED_Simbolo;
                nombre_producto 		= item.PROD_Nombre;
                flagGenInd      		= item.PROD_GenericoIndividual;
                costo           		= item.PROD_CostoPromedio;
                cantidad        		= item.PRESDEC_Cantidad;
                pu              		= item.PRESDEC_Pu;
                subtotal        		= item.PRESDEC_Subtotal;
                descuento       		= item.PRESDEC_Descuento;
                igv             		= item.PRESDEC_Igv;
                total           		= item.PRESDEC_Total;
                pu_conigv              	= item.PRESDEC_Pu_ConIgv;
                subtotal_conigv        	= item.PRESDEC_Subtotal_ConIgv;
                descuento_conigv       	= item.PRESDEC_Descuento_ConIgv;	

                if(j%2==0){
                    clase="itemParTabla";
                }else{
                    clase="itemImparTabla";
                }
                fila = '<tr class="'+clase+'">';
                fila +='<td width="3%"><div align="center"><font color="red"><strong><a href="javascript:;" onclick="eliminar_producto_ocompra('+n+');">';
                fila +='<span style="border:1px solid red;background: #ffffff;">&nbsp;X&nbsp;</span>';
                fila +='</a></strong></font></div></td>';
                fila += '<td width="4%"><div align="center">'+j+'</div></td>';
                fila += '<td width="10%"><div align="center">';
                fila += '<input type="hidden" class="cajaGeneral" name="prodcodigo['+n+']" id="prodcodigo['+n+']" value="'+producto+'">'+codproducto;
                fila += '<input type="hidden" class="cajaGeneral" name="produnidad['+n+']" id="produnidad['+n+']" value="'+unidad_medida+'">';
                fila+= '<input type="hidden" class="cajaMinima" name="flagGenIndDet['+n+']" id="flagGenIndDet['+n+']" value="'+flagGenInd+'">';
                fila += '</div></td>';
                fila += '<td><div align="left"><input type="text" class="cajaGeneral" size="73" maxlength="250" name="proddescri['+n+']" id="proddescri['+n+']" value="'+nombre_producto+'" /></div></td>';
                fila += '<td width="10%"><div align="left"><input type="text" size="1" maxlength="5" class="cajaGeneral" name="prodcantidad['+n+']" id="prodcantidad['+n+']" value="'+cantidad+'" onblur="calcula_importe('+n+');calcula_totales();" onkeypress="return numbersonly(this,event,\'.\');">'+nombre_unidad;
               
                fila += '</div></td>';
				fila += '<td width="6%"><div align="center"><input type="text" name="prodpu_conigv['+n+']" id="prodpu_conigv['+n+']" value="'+pu_conigv+'" size="5" maxlength="10" class="cajaGeneral" onblur="modifica_pu_conigv('+n+');"></div></td>';
                fila += '<td width="6%"><div align="center"><input type="text" size="5" maxlength="10" class="cajaGeneral" name="prodpu['+n+']" id="prodpu['+n+']" value="'+pu+'" onblur="modifica_pu('+n+');" onkeypress="return numbersonly(this,event,\'.\');"></div></td>';                  
                
				fila += '<td width="6%"><input type="text" class="cajaGeneral cajaSoloLectura" size="5" maxlength="10" name="prodprecio['+n+']" id="prodprecio['+n+']" value="'+subtotal+'" readonly="readonly"></div></td>';
				fila += '<td width="6%" style="display:none;"><div align="center">';
                fila += '<input type="hidden" name="proddescuento100['+n+']" id="proddescuento100['+n+']" value="'+descuento100+'">';
                fila += '<input type="hidden" size="5" maxlength="10" class="cajaGeneral" name="proddescuento['+n+']" id="proddescuento['+n+']" value="'+descuento+'" onblur="calcula_importe2('+n+');calcula_totales();">';
 
                fila += '</div></td>';
                fila += '<td width="6%"><div align="center"><input type="text" size="5" class="cajaGeneral cajaSoloLectura" name="prodigv['+n+']" value="'+igv+'" id="prodigv['+n+']" readonly></div></td>';
                fila += '<td width="6%"><div align="center">';
                fila +='<input type="hidden" name="detacodi['+n+']" id="detacodi['+n+']">';
                fila +='<input type="hidden" name="detaccion['+n+']" id="detaccion['+n+']" value="n">';
                fila += '<input type="hidden" name="prodigv100['+n+']" id="prodigv100['+n+']" value="'+igv100+'">';
                fila+= '<input type="hidden" class="cajaPequena2" name="prodcosto['+n+']" id="prodcosto['+n+']" value="'+costo+'" readonly="readonly">';
                fila+= '<input type="hidden" class="cajaPequena2" name="prodventa['+n+']" id="prodventa['+n+']" value="0" readonly="readonly">';                  
                fila += '<input type="text" size="5" class="cajaGeneral cajaSoloLectura" name="prodimporte['+n+']" id="prodimporte['+n+']" value="'+total+'" readonly="readonly" value="0">';
                fila += '</div></td>';
                fila += '</tr>';
                $("#tblDetalleOcompra").append(fila);
            }
            $('#moneda').val(moneda);
            n++;      
        })
        if(n>=0)
            calcula_totales();
        else
            alert('El presupuesto no tiene elementos.');
        
    });

	}
	function sintilde(cadena){
   
   var specialChars = "!@#$^&%*()+=-[]\/{}|:<>?,.";

   
   for (var i = 0; i < specialChars.length; i++) {
       cadena= cadena.replace(new RegExp("\\" + specialChars[i], 'gi'), '');
   }   

   // Lo queremos devolver limpio en minusculas
   cadena = cadena.toLowerCase();

   // Quitamos acentos y "ñ". Fijate en que va sin comillas el primer parametro
   cadena = cadena.replace(/á/gi,"a");
   cadena = cadena.replace(/é/gi,"e");
   cadena = cadena.replace(/í/gi,"i");
   cadena = cadena.replace(/ó/gi,"o");
   cadena = cadena.replace(/ú/gi,"u");
   cadena = cadena.replace(/ñ/gi,"n");
   return cadena;
}





