jQuery(document).ready(function(){
    base_url   = $("#base_url").val();
    tipo_cuenta   = $("#tipo_cuenta").val();
        
    $("#nuevoCuenta").click(function(){
        url = base_url+"index.php/tesoreria/cuentas/nuevo/"+tipo_cuenta;
        location.href = url;
    });
        
   
    
    /*if($('#ruc_cliente').val()!=''){
        $('#estado_pago2').attr("onchange","BuscarxEstadoPago()");
    }
    */
    /*function BuscarxEstadoPago(){
        document.forms['frmCuenta'].action = base_url+"index.php/tesoreria/cuentas/nuevo/"+tipo_cuenta;
        $("#frmCuenta").submit();
    }*/
    
    $("#grabarCuenta").click(function(){
        if(confirm('¿Está seguro de grabar este pago?')){
            $('img#loading').css('visibility','visible');
            url = base_url+"index.php/tesoreria/cuentas/grabar";
            
            dataString  = $('#frmCuenta').serialize();
            $.post(url,dataString,function(data){
                $('img#loading').css('visibility','hidden');
                switch(data.result){
                    case 'ok':
                        $('#monto').val('');
                        $('#forma_pago').val('1');
                        $('.formaPago').hide();
                        mostrar_cuentas();
                        break;
                    case 'error':
                        $('input[type="text"][readonly!="readonly"], select, textarea').css('background-color', '#FFFFFF');
                        $('#'+data.campo).css('background-color', '#FFC1C1').focus();
                        break;
                }
            },'json');
        }
    });
    $("#limpiarCuenta").click(function(){            
        url = base_url+"index.php/tesoreria/cuentas/listar/"+tipo_cuenta;
        location.href=url;
    });
    $("#cancelarCuenta").click(function(){
        url = base_url+"index.php/tesoreria/cuentas/listar/"+tipo_cuenta;
        location.href = url;
    });
    $("#buscarCuenta").click(function(){
        //document.forms['form_busquedaCuenta'].action = base_url+"index.php/tesoreria/cuentas/listar/"+tipo_cuenta;
        $("#form_busqueda").submit();
    });
        
    $('#forma_pago').change(function(){
        $('.formaPago').hide();
        if($(this).val()!='1') {
            $('#formaPago'+$(this).val()).show();
        }
    });    
           
    $('#aplicarpago').click(function(){
        if($('#tdc').val()==''){
            alert('Debe ingresar el Tipo de Cambio del dia')
            top.location=base_url+"index.php/index/inicio";
        }
        if($(this).attr('name')=='aplica')
            mostrar_cuentas('1');
        else
            mostrar_cuentas('0');
    });
        
    $('#moneda').change(function(){
        mostrar_cuentas();
    });
    $('#verpagos').click(function(){
        if(tipo_cuenta=='1'){
            if($('#cliente').val()==''){
                alert('Seleccione el cliente.');
                $('#cliente').focus();
            }else{
                url = base_url+"index.php/tesoreria/pago/listar_ultimos/"+tipo_cuenta+"/"+$('#cliente').val();
                location.href=url;
            }
        }else{
            if($('#proveedor').val()==''){
                alert('Seleccione el proveedor.');
                $('#proveedor').focus();
            }else{
                url = base_url+"index.php/tesoreria/pago/listar_ultimos/"+tipo_cuenta+"/"+$('#proveedor').val();
                location.href=url;
            }
        }
            
                
    });
    
    $('#tipo_docu').change(function(){
        tipo_doc=$('#tipo_docu').val();
        //mostrar_cuentas($('#aplica_pago').val(),estadopago)
        if(tipo_doc=='FACTURA'){
            $('.BOLETA').hide();
            $('.FACTURA').show();
        }else if(tipo_doc=='BOLETA'){
            $('.BOLETA').show();
            $('.FACTURA').hide();
        }else if(tipo_doc=='T'){
            $('.BOLETA').show();
            $('.FACTURA').show();
        }
    //mostrar_cuentas(TRUE,estadopago)
    })
    
    $('#estado_pago2').change(function(){
        estadopago=$('#estado_pago2').val();
        //mostrar_cuentas($('#aplica_pago').val(),estadopago)
        if(estadopago=='C'){
            $('.Pendiente').hide();
            $('.Cancelado').show();
        }else if(estadopago=='P'){
            $('.Pendiente').show();
            $('.Cancelado').hide();
        }else if(estadopago=='T'){
            $('.Pendiente').show();
            $('.Cancelado').show();
        }
    //mostrar_cuentas(TRUE,estadopago)
    })
    
    $('#estado_pago').change(function(){
        estadopago=$('#estado_pago').val();
        //mostrar_cuentas($('#aplica_pago').val(),estadopago)
        if(estadopago=='C'){
            $('.Pendiente').hide();
            $('.Cancelado').show();
        }else if(estadopago=='P'){
            $('.Pendiente').show();
            $('.Cancelado').hide();
        }else if(estadopago=='T'){
            $('.Pendiente').show();
            $('.Cancelado').show();
        }
    })
    
    $('#comprobante').change(function(){
        tipo_doc=$('#comprobante').val();
        //mostrar_cuentas($('#aplica_pago').val(),estadopago)
        if(tipo_doc==8){
            $('.Boleta').hide();
            $('.Factura').show();
        }else if(tipo_doc==9){
            $('.Boleta').show();
            $('.Factura').hide();
        }else if(tipo_doc=='T'){
            $('.Boleta').show();
            $('.Factura').show();
        }
    //mostrar_cuentas(TRUE,estadopago)
    })
    
})

function ver_pagos(cuenta){
    location.href = base_url+"index.php/tesoreria/pago/listar/"+cuenta;
}
function ver_comprobante_pdf(comprobante, tipo_docu){
    var url = base_url+"index.php/ventas/comprobante/comprobante_ver_pdf/"+comprobante+"/"+tipo_docu;
    window.open(url,'',"width=800,height=600,menubars=no,resizable=no;")
}
function comprobante_ver_pdf_conmenbrete(comprobante, tipo_docu){
    var url = base_url+"index.php/ventas/comprobante/comprobante_ver_pdf_conmenbrete/"+comprobante+"/"+tipo_docu;
    window.open(url,'',"width=800,height=600,menubars=no,resizable=no;")
}

function mostrar_cuentas(aplica_pago){
    var monto=$('#monto').val();
    if(monto=='')
        monto='0';
    var moneda=$('#moneda').val();
    var tdc=$('#tdc').val();
    
    if(!aplica_pago)
        aplica_pago='0';
    
    if(tipo_cuenta=='1'){
        codigo=$('#cliente').val();
        if(codigo==''){
            $('#ruc_cliente').focus();
            alert('Seleccione el cliente.');
            return false;
        }
    }else{
        codigo=$('#proveedor').val();
        if(codigo==''){
            $('#ruc_proveedor').focus();
            alert('Seleccione el proveedor.');
            return false;
        }
    }
        
    if(aplica_pago=='1' && monto==0){
        alert('Ingrese el monto a pagar.');
        $('#monto').focus();
        return false;
    }
    if(aplica_pago=='1'){
        $('#aplicarpago img').attr('src', base_url+'images/botonpagoretirar.png');
        $('#aplicarpago').attr('name', 'retira');
    }else{
        $('#aplicarpago img').attr('src', base_url+'images/botonpago.png');
        $('#aplicarpago').attr('name', 'aplica');
    }
    
        
    
    url = base_url+"index.php/tesoreria/cuentas/JSON_cuentas_pendientes/"+tipo_cuenta+"/"+codigo+"/"+monto+"/"+moneda+"/"+tdc+"/"+aplica_pago;
    
    $("#tblDetallePago").html('');
    $('#saldo').val('');
    $.getJSON(url,function(data){
        $.each(data, function(i,item){
            if(i%2==0){
                clase="itemParTabla";
            }else{
                clase="itemImparTabla";
            }
                
            array_estado=obtener_estado_formato(item.avance,item.total).split("_|_")
            fila  = '<tr class="'+clase+' '+array_estado[1]+' '+item.desc_doc+'">';
            fila +=	'<td width="4%"><div align="center">'+(i+1)+'</div></td>';
            fila +=	'<td width="7%"><div align="center">'+item.fecha+'</div></td>';
            fila +=	'<td width="20%"><div align="center">'+item.desc_doc+'</div></td>';
            fila +=	'<td width="13%"><div align="center">'+item.serie+'-'+item.numero+'</div></td>';
            fila +=	'<td width="7%"><div align="center">'+item.moneda+'</div></td>';
            fila +=	'<td width="7%"><div align="center">'+item.total+'</div></td>';
            fila +=	'<td width="7%"><div align="center">'+item.avance+'</div></td>';
            fila +=	'<td width="7%"><div align="center">'+item.saldo+'</div></td>';
            fila +=	'<td width="18%">'+array_estado[0]+'</td>';
            fila +=	'<td width="10%"><a href="javascript:;" onclick="comprobante_ver_pdf_conmenbrete('+ item.cod_documento;
            fila +=	",'"+ item.tipo_doc+"'";   
            fila +=')" target="_parent"><img src="' + base_url+'images/pdf.png" width="16" height="16" border="0" title="Ver PDF"></a></td>';
            fila += '</tr>';            
            $("#tblDetallePago").append(fila);
            if(array_estado[1]=='Pendiente'){
                $('.Cancelado').hide();
            }
            $('#saldo').val(item.saldo_total);
        });
    });
    
    return true;
    
}



function obtener_estado_formato(avance,total){
    if(avance==total)
        result="<div style='width:100px; margin-left:auto; margin-right:auto; height:17px; background-color: #00D269; text-align:center; cursor:help;' title='Cancelado'>Cancelado</div>_|_Cancelado";
    else
    if(parseFloat(avance)>0)
        result="<div style='width:100px; margin-left:auto; margin-right:auto; height:17px; background-color: #FFB648; text-align:center; cursor:help;' title='Pendiente con Avance'>Pendiente (AV)</div>_|_Pendiente";
    else
        result="<div style='width:100px; margin-left:auto; margin-right:auto; height:17px; background-color: #FF6464; text-align:center; cursor:help;' title='Pendiente'>Pendiente</div>_|_Pendiente";

    return result;
}