var base_url;
jQuery(document).ready(function () {
    base_url = $("#base_url").val();
    tipo_docu = $("#tipo_docu").val();
    tipo_oper = $("#tipo_oper").val();
    contiene_igv = $("#contiene_igv").val();
    tipo_codificacion = $("#tipo_codificacion").val();
    almacen = $("#almacen").val();

    //////////////////////


    $("#numero_ref").keyup(function (e) {
        var key = e.keyCode || e.which;
        if (key == 13) {
            //alert(almacen);
            var seriep = $("#seriep").val();
            var presupuesto = $(this).val();


            tipo_docu = "F";
            descuento100 = $("#descuento").val();
            igv100 = $("#igv").val();
            seriecom = $("#seriecom").val();

//            alert(seriecom);

            // url = base_url+"index.php/ventas/presupuesto/obtener_detalle_presupuesto1/"+tipo_oper+"/"+tipo_docu+"/"+seriep+"/"+presupuesto;
            url = base_url + "index.php/ventas/comprobante/obtener_detalle_comprobante_x_numero_com/" + seriecom + "/" + presupuesto + "/" + tipo_oper + "/" + almacen;
            //alert(url);
            n = document.getElementById('tblDetalleGuiaRem').rows.length;

            //$('#VentanaTransparente').show();
            $.getJSON(url, function (data) {
                //console.log(data);
                //alert("dentro");
                limpiar_datos();
                $.each(data, function (i, item) {

                    cliente = item.CLIP_Codigo;
                    ruc = item.Ruc;
                    razon_social = item.RazonSocial;
                    moneda = item.MONED_Codigo;
                    formapago = item.FORPAP_Codigo;
                    serie = item.PRESUC_Serie;
                    numero = item.PRESUC_Numero;
                    codigo_usuario = item.PRESUC_CodigoUsuario;
                    presup = item.PRESUP_Codigo;
                    if (item.PRESDEP_Codigo != '') {
                        j = n + 1
                        producto = item.PROD_Codigo;
                        codproducto = item.PROD_CodigoInterno;
                        unidad_medida = item.UNDMED_Codigo;
                        nombre_unidad = item.UNDMED_Simbolo;
                        nombre_producto = item.PROD_Nombre;
                        cantidad = item.CPDEC_Cantidad;
                        pu = item.CPDEC_Pu;
                        subtotal = item.CPDEC_Subtotal;
                        descuento = item.CPDEC_Descuento;
                        igv = item.CPDEC_Igv;
                        total = item.CPDEC_Total
                        pu_conigv = item.CPDEC_Pu_ConIgv;
                        subtotal_conigv = item.CPDEC_Subtotal_ConIgv;
                        stock = '';
                        flagGenInd = item.PROD_GenericoIndividual;
                        flagBS = item.flagBS;
                        costo = item.PROD_CostoPromedio;
                        descuento_conigv = item.CPDEC_Descuento_ConIgv;

                        if (j % 2 == 0) {
                            clase = "itemParTabla";
                        } else {
                            clase = "itemImparTabla";
                        }
                        fila = '<tr class="' + clase + '">';
                        fila += '<td width="3%"><div align="center"><font color="red"><strong><a href="#" onclick="eliminar_producto_comprobante(' + n + ');">';
                        fila += '<span style="border:1px solid red;background: #ffffff;">&nbsp;X&nbsp;</span>';
                        fila += '</a></strong></font></div></td>';
                        fila += '<td width="4%"><div align="center">' + j + '</div></td>';
                        fila += '<td width="10%"><div align="center">';
                        fila += '<input type="hidden" class="cajaGeneral" name="prodcodigo[' + n + ']" id="prodcodigo[' + n + ']" value="' + producto + '">' + codproducto;
                        fila += '<input type="hidden" class="cajaGeneral" name="produnidad[' + n + ']" id="produnidad[' + n + ']" value="' + unidad_medida + '">';
                        fila += '</div></td>';
                        fila += '<td><div align="left"><input type="text" class="cajaGeneral" size="73" maxlength="250" name="proddescri[' + n + ']" id="proddescri[' + n + ']" value="' + nombre_producto + '" /></div></td>';
                        if (tipo_docu != 'B' && tipo_docu != 'N')
                            fila += '<td width="10%"><div align="left"><input type="text" size="1" maxlength="10" class="cajaGeneral" name="prodcantidad[' + n + ']" id="prodcantidad[' + n + ']" value="' + cantidad + '" onblur="calcula_importe(' + n + ');calcula_totales();" onkeypress="return numbersonly(this,event,\'.\');">' + nombre_unidad + '</div></td>';
                        else
                            fila += '<td width="10%"><div align="left"><input type="text" size="1" maxlength="10" class="cajaGeneral" name="prodcantidad[' + n + ']" id="prodcantidad[' + n + ']" value="' + cantidad + '" onblur="calcula_importe_conigv(' + n + ');" onkeypress="return numbersonly(this,event,\'.\');">' + nombre_unidad + '</div></td>';
                        if (tipo_docu != 'B' && tipo_docu != 'N') {
                            fila += '<td width="6%">';
                            /*prodpu_conigv*/
                            fila += '<div align="center"><input type="text" name="prodpu_conigv[' + n + ']" id="prodpu_conigv[' + n + ']" value="' + pu_conigv + '" size="5" maxlength="10" class="cajaGeneral" onblur="modifica_pu_conigv(' + n + ');"></div></td>';
                            /*prodpu*/
                            fila += '<td width="6%"><div align="center"><input type="text" size="5" maxlength="10" class="cajaGeneral" name="prodpu[' + n + ']" id="prodpu[' + n + ']" value="' + pu + '" onblur="modifica_pu(' + n + ');" onkeypress="return numbersonly(this,event,\'.\');">\n\
                                    </div></td>';
                        } else {
                            fila += '<td width="6%"><div align="center"><input type="text" size="5" maxlength="10" class="cajaGeneral" name="prodpu_conigv[' + n + ']" id="prodpu_conigv[' + n + ']" value="' + pu_conigv + '" onblur="calcula_importe_conigv(' + n + ');" onkeypress="return numbersonly(this,event,\'.\');"></div></td>';
                            fila += '<td width="6%"><input type="text" size="5" maxlength="10" class="cajaGeneral" name="prodprecio_conigv[' + n + ']" id="prodprecio_conigv[' + n + ']" value="' + subtotal_conigv + '" readonly="readonly"></div></td>';
                        }
                        fila += '<td width="6%"><div align="center">';
                        fila += '<input type="hidden" readonly name="proddescuento100[' + n + ']" id="proddescuento100[' + n + ']" value="' + descuento100 + '">';
                        if (tipo_docu != 'B' && tipo_docu != 'N') {
                            fila += '<input type="hidden" size="5" maxlength="10" readonly class="cajaGeneral" name="proddescuento[' + n + ']" id="proddescuento[' + n + ']" value="' + descuento + '" onblur="calcula_importe2(' + n + ');calcula_totales();">';
                            fila += '<input type="text" class="cajaGeneral cajaSoloLectura" size="5" maxlength="10" name="prodprecio[' + n + ']" id="prodprecio[' + n + ']" value="' + subtotal + '" readonly="readonly">';
                        } else
                            fila += '<input type="text" size="5" maxlength="10" readonly class="cajaGeneral" name="proddescuento_conigv[' + n + ']" id="proddescuento_conigv[' + n + ']" value="' + descuento_conigv + '" onblur="calcula_importe2_conigv(' + n + ');calcula_totales_conigv();">';
                        fila += '</div></td>';
                        if (tipo_docu != 'B' && tipo_docu != 'N')
                            fila += '<td width="6%"><div align="center"><input type="text" size="5" class="cajaGeneral cajaSoloLectura" name="prodigv[' + n + ']" value="' + igv + '" id="prodigv[' + n + ']" readonly></div></td>';
                        fila += '<td width="6%"><div align="center">';
                        fila += '<input type="hidden" name="detacodi[' + n + ']" id="detacodi[' + n + ']">';
                        fila += '<input type="hidden" name="prodigv100[' + n + ']" id="prodigv100[' + n + ']" value="' + igv100 + '">';
                        fila += '<input type="hidden" name="detaccion[' + n + ']" id="detaccion[' + n + ']" value="n">';
                        fila += '<input type="hidden" name="flagBS[' + n + ']" id="flagBS[' + n + ']" value="' + flagBS + '"/>';
                        fila += '<input type="hidden" name="flagGenIndDet[' + n + ']" id="flagGenIndDet[' + n + ']" value="' + flagGenInd + '"/>';
                        fila += '<input type="hidden" name="prodstock[' + n + ']" id="prodstock[' + n + ']" value="' + stock + '"/>';
                        fila += '<input type="hidden" name="prodcosto[' + n + ']" id="prodcosto[' + n + ']" value="' + costo + '"/>';
                        fila += '<input type="text" size="5" class="cajaGeneral cajaSoloLectura" name="prodimporte[' + n + ']" id="prodimporte[' + n + ']" value="' + total + '" readonly="readonly" value="0">';
                        fila += '</div></td>';
                        fila += '</tr>';
                        $("#tblDetalleGuiaRem").append(fila);
                    }

                    $('#presupuesto_codigo').val(presup);
                    $('#ruc_cliente').val(ruc);
                    $('#cliente').val(cliente);
                    $('#nombre_cliente').val(razon_social);
                    //$('#forma_pago').val(formapago);
                    $('#moneda').val(moneda);
                    if (codigo_usuario)
                        $("#numero_ref").val(codigo_usuario);
                    else if (serie)
                        $("#numero_ref").val('PR: ' + serie + ' / ' + numero);
                    else
                        $("#numero_ref").val('PR: ' + numero);

                    n++;
                })


                $('#VentanaTransparente').hide();
                if (n >= 0) {
                    if (tipo_docu != 'B' && tipo_docu != 'N')
                        calcula_totales();
                    else
                        calcula_totales();
                }
                else {
                    alert('El presupuesto no tiene elementos.');
                }
            });


        }
    });


    ////////////////////////////
    $("#nuevaGuiarem").click(function () {
        url = base_url + "index.php/almacen/guiarem/nueva" + "/" + tipo_oper;
        location.href = url;
    });

    /*$("#grabarGuiarem").click(function () {
        $('#frmGuiarem').submit();
    });*/

    $("#grabarGuiarem").click(function (){
        $('img#loading').css('visibility', 'visible');
        url = base_url + "index.php/almacen/guiarem/grabar";
        dataString = $('#frmGuiarem').serialize();
        $.post(url, dataString, function (data){
            $('img#loading').css('visibility', 'hidden');
            switch (data.result){
                case 'ok':
                    location.href = base_url + "index.php/almacen/guiarem/listar" + "/" + tipo_oper;
                    break;
                case 'error':
                    $('input[type="text"][readonly!="readonly"], select, textarea').css('background-color', '#FFFFFF');
                    $('#' + data.campo).css('background-color', '#FFC1C1').focus();
                    break;
                case 'error2':
                    $('input[type="text"][readonly!="readonly"], select, textarea').css('background-color', '#FFFFFF');
                    var element = document.getElementById(data.campo);
                    element.style.backgroundColor = '#FFC1C1';
                    break;
                case 'error3':
                    alert(data.msj);
                    break;
            }
        }, 'json');
    });

    $("#limpiarGuiarem").click(function (){
        url = base_url + "index.php/almacen/guiarem/listar/" + tipo_oper + "/0/1";
        location.href = url;
    });
    $("#cancelarGuiarem").click(function () {
        url = base_url + "index.php/almacen/guiarem/listar/" + tipo_oper + "/0/1";
        location.href = url;
    });
    $("#cancelarGuiarem2").click(function () {
        url = base_url + "index.php/almacen/guiarem/listar/" + tipo_oper + "/0/1";
        location.href = url;
    });
    $("#buscarGuiarem").click(function () {
        $("#form_busqueda").submit();
    });

    $("#punto_partida").click(function () {
        $('#lista_mis_direcciones').slideUp("fast");
    });
    $("#linkVerMisDirecciones").click(function () {
        if (tipo_oper == 'C')
            proveedor = $("#proveedor").val();

        $('#lista_direcciones').slideUp("fast");

        $("#lista_mis_direcciones ul").html('');
        $("#lista_mis_direcciones").slideToggle("fast", function () {
            if (tipo_oper == 'C')
                url = base_url + "index.php/compras/proveedor/JSON_listar_sucursalesEmpresa/" + proveedor;
            else
                url = base_url + "index.php/maestros/empresa/JSON_listar_sucursalesEmpresa";

            $.getJSON(url, function (data) {
                $.each(data, function (i, item) {
                    fila = '';
                    if (item.Tipo == '1')
                        fila += '<li style="list-style: none; font-weight:bold; color:#aaa"">' + item.Titulo + '</li>';
                    else {
                        fila += '<li><a href="javascript:;">' + item.EESTAC_Direccion;
                        if (item.distrito != '')
                            fila += ' ' + item.distrito;
                        if (item.provincia != '')
                            fila += ' - ' + item.provincia;
                        if (item.departamento != '')
                            fila += ' - ' + item.departamento;
                        fila += '</a></li>';
                    }
                    $("#lista_mis_direcciones ul").append(fila);
                });
            });
            return true;
        });
    });
    $("#lista_mis_direcciones li a").live('click', function () {
        $("#punto_partida").val($(this).html());
        $('#lista_mis_direcciones').slideUp("fast");
    });
    $("#punto_llegada").click(function () {
        $('#lista_direcciones').slideUp("fast");
    });
    $("#linkVerDirecciones").click(function () {
        if (tipo_oper == 'V')
            cliente = $("#cliente").val();
        $('#lista_mis_direcciones').slideUp("fast");

        $("#lista_direcciones ul").html('');
        $("#lista_direcciones").slideToggle("fast", function () {
            if (tipo_oper == 'V')
                var url = base_url + "index.php/ventas/cliente/JSON_listar_sucursalesCliente/" + cliente;
            else
                url = base_url + "index.php/maestros/empresa/JSON_listar_sucursalesEmpresa";
            $.getJSON(url, function (data) {
                $.each(data, function (i, item) {
                    fila = '';
                    if (item.Tipo == '1')
                        fila += '<li style="list-style: none; font-weight:bold; color:#aaa">' + item.Titulo + '</li>';
                    else {
                        fila += '<li><a href="javascript:;">' + item.EESTAC_Direccion;
                        if (item.distrito != '')
                            fila += ' ' + item.distrito;
                        if (item.provincia != '')
                            fila += ' - ' + item.provincia;
                        if (item.departamento != '')
                            fila += ' - ' + item.departamento;
                        fila += '</a></li>';
                    }
                    $("#lista_direcciones ul").append(fila);
                });
            });
            return true;
        });
    });
    $("#lista_direcciones li a").live('click', function () {
        $("#punto_llegada").val($(this).html());
        $('#lista_direcciones').slideUp("fast");
    });
    $("#linkVerSerieNum").click(function () {
        var temp = $("#linkVerSerieNum p").html();
        var serienum = temp.split('-');
        switch (tipo_codificacion) {
            case '1':
                $("#numero").val(serienum[1]);
                break;
            case '2':
                $("#serie").val(serienum[0]);
                $("#numero").val(serienum[1]);
                break;
        }
    });

    $('#precio').keyup(function (e) {
        var key = e.keyCode || e.which;
        if (key == 13) {
            $("#form_busqueda").submit();
        }
    });

    $('#buscar_cliente').keyup(function (e) {
        var key = e.keyCode || e.which;
        if (key == 13) {
            if ($(this).val() != '') {
                $('#linkSelecCliente').attr('href', base_url + 'index.php/ventas/cliente/ventana_selecciona_cliente/' + $('#buscar_cliente').val()).click();
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


    $('#buscar_proveedor').keyup(function (e) {
        var key = e.keyCode || e.which;
        if (key == 13) {
            if ($(this).val() != '') {
                $('#linkSelecProveedor').attr('href', base_url + 'index.php/compras/proveedor/ventana_selecciona_proveedor/' + $('#buscar_proveedor').val()).click();
            }
        }
    });

    $('#nombre_proveedor').keyup(function (e) {
        var key = e.keyCode || e.which;
        if (key == 13) {
            if ($(this).val() != '') {
                $('#linkSelecProveedor').attr('href', base_url + 'index.php/compras/proveedor/ventana_selecciona_proveedor/' + $('#nombre_proveedor').val()).click();
            }
        }
    });

    $('#buscar_producto').keyup(function (e) {
        var key = e.keyCode || e.which;
        if (key == 13) {
            if ($(this).val() != '') {
                $('#linkSelecProducto').attr('href', base_url + 'index.php/almacen/producto/ventana_selecciona_producto/' + tipo_oper + '/' + $('#flagBS').val() + '/' + $('#buscar_producto').val()).click();
            }
        }
    });

    $("select#ordencompra").live('change', function () {
        var value = $(this).val();
        if (value != "") {
            document.getElementById('linkVerOrdenCompra').href = base_url + "index.php/compras/ocompra/comprobante_nueva_ocompra/" + value;
            $("a#linkVerOrdenCompra").click();
        }
    });

    $('#cantidad').bind('keypress', function (e) {
        tipo_oper = $("#tipo_oper").val();
        flagGenInd = $("#flagGenInd").val();
        if (flagGenInd == 'I') {
            if (e.keyCode == 9 || e.keyCode == 13) {
                if (tipo_oper == 'V') {
                    if ($(this).val() != '') {
                        var cantidad = parseInt($(this).val());
                        var stock = parseInt($('#stock').val());
                        if (cantidad > stock) {
                            alert('La cantidad no debe ser mayor al stock.');
                            $(this).val('').focus();
                            return false;
                        }
                        ventana_producto_serie2_2();
                    }

                } else if (tipo_oper == 'C') {
                    ventana_producto_serie_1();
                }
            }
        }
    });

    $('input[id^="prodcantidad"]').live('keypress', function (e) {
        var tipo_oper = $("#tipo_oper").val();
        var flagGenInd = $(this).parent().parent().parent().find('input[id^="flagGenIndDet"]').val();
        if (flagGenInd == 'I') {
            if (e.keyCode == 9 || e.keyCode == 13) {
                var almacen = $('#almacen').val();
                var producto = $(this).parent().parent().parent().find('input[id^="prodcodigo"]').val();
                var cantidad = parseInt($(this).val());
                var stock = parseInt($(this).parent().parent().parent().find('input[id^="prodstock"]').val());
                if (tipo_oper == 'V') {
                    if ($(this).val() != '') {
                        if (cantidad > stock) {
                            alert('La cantidad no debe ser mayor al stock.');
                            $(this).val('').focus();
                            return false;
                        }
                        if (e.keyCode == 13)
                            ventana_producto_serie2_3(almacen, producto, cantidad);
                    }
                } else if (tipo_oper == 'C') {
                    if (e.keyCode == 13)
                        ventana_producto_serie_1_1(producto, cantidad);
                }
            }
        }
        return true;
    });
})

var limite_detalle = 15;
function getLimite() {
    return limite_detalle;
}

function setLimite(limite) {
    limite_detalle = limite;
}

function editar_guiarem(guiarem) {
    location.href = base_url + "index.php/almacen/guiarem/editar/" + guiarem + '/' + tipo_oper;
}
function disparador(guiarem) {

    location.href = base_url + "index.php/almacen/guiarem/disparador/" + guiarem + "/" + tipo_oper;


}
function eliminar_guiarem(guiarem) {
    if (confirm('Esta seguro desea eliminar a esta Guía de Remisión?')) {
        dataString = "codigo=" + guiarem;
        url = base_url + "index.php/almacen/guiarem/eliminar";
        $.post(url, dataString, function (data) {
            location.href = base_url + "index.php/almacen/guiarem/listar" + '/' + tipo_oper;
        });
    }
}
function ver_guiarem(guiarem) {
    location.href = base_url + "index.php/almacen/guiarem/ver/" + guiarem + '/' + tipo_oper;
}
function guiarem_ver_pdf(guiarem) {
    baseurl = base_url + "index.php/almacen/guiarem/disparador/" + guiarem + "/" + tipo_oper;
    $.get(baseurl, function (data) {
        url = base_url + "index.php/almacen/guiarem/guiarem_ver_pdf/" + guiarem + '/' + tipo_oper;
        window.open(url, '', "width=800,height=600,menubars=no,resizable=no;")
    });


}
function guiarem_ver_pdf_conmenbrete(guiarem) {
    tipo_oper = $("#tipo_oper").val();
    url = base_url + "index.php/almacen/guiarem/guiarem_ver_pdf_conmenbrete/" + guiarem + '/' + tipo_oper;
    window.open(url, '', "width=800,height=600,menubars=no,resizable=no;")
}
function atras_guiarem() {
    location.href = base_url + "index.php/almacen/guiarem/listar" + '/' + tipo_oper;
}
/********************************************************************************************/
function obtener_cliente() {
    var numdoc = $("#ruc_cliente").val();
    $('#cliente,#nombre_cliente').val('');

    if (numdoc == '')
        return false;

    var url = base_url + "index.php/ventas/cliente/JSON_buscar_cliente/" + numdoc;
    $.getJSON(url, function (data) {
        $.each(data, function (i, item) {
            if (item.EMPRC_RazonSocial != '') {
                $('#nombre_cliente').val(item.EMPRC_RazonSocial);
                $('#cliente').val(item.CLIP_Codigo);
                $('#codproducto').focus();
            }
            else {
                $('#nombre_cliente').val('No se encontró ningún registro');
                $('#linkVerCliente').focus();
            }
        });
    });
    return true;
}
function obtener_proveedor() {
    var numdoc = $("#ruc_proveedor").val();
    $("#proveedor, #nombre_proveedor").val('');

    if (numdoc == '')
        return false;

    var url = base_url + "index.php/compras/proveedor/obtener_nombre_proveedor/" + numdoc;
    $.getJSON(url, function (data) {
        $.each(data, function (i, item) {
            if (item.EMPRC_RazonSocial != '') {
                $('#nombre_proveedor').val(item.EMPRC_RazonSocial);
                $('#proveedor').val(item.PROVP_Codigo);
                $('#codproducto').focus();
            }
            else {
                $('#nombre_proveedor').val('No se encontró ningún registro');
                $('#linkVerProveedor').focus();
            }
        });
    });
    return true;
}
function busqueda_producto_x_almacen() {
    almacen_id = $("#almacen").val();
    if (almacen_id != "") {
        url = base_url + "index.php/almacen/producto/ventana_busqueda_producto_x_almacen/" + almacen_id;
        window.open(url, "", "width=600,height=400,scrollbars=yes,status=yes,resizable=yes,screenx=0,screeny=0");
    }
    else {
        alert("Debe seleccionar un almacen.");
    }
}
function obtener_producto() {
    var flagBS = $("#flagBS").val();
    var codproducto = $("#codproducto").val();
    $("#producto, #nombre_producto").val('');
    if (codproducto == '')
        return false;

    var url = base_url + "index.php/almacen/producto/obtener_nombre_producto/B/" + flagBS + "/" + codproducto;
    $.getJSON(url, function (data) {
        $.each(data, function (i, item) {
            if (item.PROD_Nombre != '') {
                $("#producto").val(item.PROD_Codigo);
                $("#nombre_producto").val(item.PROD_Nombre);
                $("#flagGenInd").val(item.flagGenInd);
                listar_unidad_medida_producto($("#producto").val());
                $('#cantidad').focus();
            }
            else {
                $('#nombre_producto').val('No se encontró ningún registro');
                $('#linkVerProdcuto').focus();
            }

        });
    });
    return true;
}
function listar_unidad_medida_producto(producto) {
    limpiar_combobox('unidad_medida');

    base_url = $("#base_url").val();
    url = base_url + "index.php/almacen/producto/listar_unidad_medida_producto/" + producto;
    select = document.getElementById('unidad_medida');
    $.getJSON(url, function (data) {
        $.each(data, function (i, item) {
            codigo = item.UNDMED_Codigo;
            descripcion = item.UNDMED_Descripcion;
            simbolo = item.UNDMED_Simbolo;
            nombre_producto = item.PROD_Nombre;
            nombrecorto_producto = item.PROD_NombreCorto;
            marca = item.MARCC_Descripcion;
            modelo = item.PROD_Modelo;
            presentacion = item.PROD_Presentacion;
            opt = document.createElement('option');
            texto = document.createTextNode(descripcion);
            opt.appendChild(texto);
            opt.value = codigo;
            if (i == 0)
                opt.selected = true;
            select.appendChild(opt);
        });
        var nombre;
        if (nombrecorto_producto)
            nombre = nombrecorto_producto;
        else
            nombre = nombre_producto;
        if (marca)
            nombre += ' ';
        if (modelo)
            nombre += ' ';
        if (presentacion)
            nombre += '  ';
        $("#nombre_producto").val(nombre);
        listar_precios_x_producto_unidad();
    });
}
function listar_precios_x_producto_unidad() {
    producto = $("#producto").val();
    unidad = $("#unidad_medida").val();
    moneda = $("#moneda").val();
    base_url = $("#base_url").val();
    flagBS = $("#flagBS").val();
    url = base_url + "index.php/almacen/producto/listar_precios_x_producto_unidad/" + producto + "/" + unidad + "/" + moneda;
    select_precio = document.getElementById('precioProducto');
    options_umedida = select_precio.getElementsByTagName("option");

    var num_option = options_umedida.length;
    for (i = 1; i <= num_option; i++) {
        select_precio.remove(0)
    }
    opt = document.createElement("option");
    texto = document.createTextNode("::Seleccion::");
    opt.appendChild(texto);
    opt.value = "";
    select_precio.appendChild(opt);
    $.getJSON(url, function (data) {
        $.each(data, function (i, item) {
            codigo = item.codigo;
            moneda = item.moneda;
            precio = item.precio;
            opt = document.createElement('option');
            texto = document.createTextNode(moneda + " " + precio);
            opt.appendChild(texto);
            opt.value = precio;
            select_precio.appendChild(opt);
        });
    });
}

function mostrar_precio() {
    precio = $("#precioProducto").val();
    $("#precio").val(precio);
}
function obtener_precio_producto() {
    var producto = $("#producto").val();
    $('#precio').val("");
    if (producto == '' || producto == '0')
        return false;
    var moneda = $("#moneda").val();
    if (moneda == '' || moneda == '0')
        return false;
    var unidad_medida = $("#unidad_medida").val();
    if (unidad_medida == '' || unidad_medida == '0')
        return false;
    var cliente = $("#cliente").val();
    if (cliente == '')
        cliente = '0';
    var igv;
    if (contiene_igv == '1')
        igv = 0;
    else
        igv = $("#igv").val();

    var url = base_url + "index.php/almacen/producto/JSON_precio_producto/" + producto + "/" + moneda + "/" + cliente + "/" + unidad_medida + "/" + igv;
    $.getJSON(url, function (data) {
        $.each(data, function (i, item) {
            $('#precio').val(item.PRODPREC_Precio);
        });
    });
    return true;
}
function agregar_producto_guiarem() {
    flagBS = $("#flagBS").val();

    if ($("#serie").val() == '') {
        $("#serie").focus();
        alert('Ingrese Numero. ');
        return false;
    
    }

    
   



    if ($("#producto").val() == '') {
        alert('Ingrese el producto.');
        $("#codproducto").focus();
        return false;
    }
    if ($("#cantidad").val() == '') {
        alert('Ingrese una cantidad.');
        $("#cantidad").focus();
        return false;
    }
    if ($("#unidad_medida").val() == '') {
        $("#unidad_medida").focus();
        alert('Seleccine una unidad de medida.');
        return false;
    }

    
    if($("#precio").val() == ''){
        $("#precio").focus();
        alert('Ingrese Precio.');
        return false;        
    }

    codproducto = $("#codproducto").val();
    producto = $("#producto").val();
    nombre_producto = $("#nombre_producto").val();
    cantidad = $("#cantidad").val();
    igv = parseInt($("#igv").val());
    precio_conigv = $("#precio").val();
    if (contiene_igv == '1')
        precio = money_format(precio_conigv * 100 / (igv + 100))
    else {
        precio = precio_conigv;
        precio_conigv = money_format(precio_conigv * (100 + igv) / 100);
    }
    stock = parseFloat($("#stock").val());
    costo = parseFloat($("#costo").val());
    unidad_medida = '';
    nombre_unidad = ''
    if (flagBS == 'B') {
        unidad_medida = $("#unidad_medida").val();
        nombre_unidad = $('#unidad_medida option:selected').html()
    }

    flagGenInd = $("#flagGenInd").val();
    n = document.getElementById('tblDetalleGuiaRem').rows.length;

    var limit = getLimite();
    if (n >= 28) {
        alert('Limite del detalle de Documento');
        return false

    }

    j = n + 1;
    if (j % 2 == 0) {
        clase = "itemParTabla";
    } else {
        clase = "itemImparTabla";
    }


    fila = '<tr class="' + clase + '">';
    fila += '<td width="3%"><div align="center"><font color="red"><strong><a href="javascript:;" onclick="eliminar_producto_ocompra(' + n + ');">';
    fila += '<span style="border:1px solid red;background: #ffffff;">&nbsp;X&nbsp;</span>';
    fila += '</a></strong></font></div></td>';
    fila += '<td width="4%"><div align="center">' + j + '</div></td>';
    fila += '<td width="10%"><div align="center">';
    fila += '<input type="hidden" class="cajaMinima" name="prodcodigo[' + n + ']" id="prodcodigo[' + n + ']" value="' + producto + '">' + codproducto;
    fila += '<input type="hidden" class="cajaMinima" name="produnidad[' + n + ']" id="produnidad[' + n + ']" value="' + unidad_medida + '">';
    fila += '<input type="hidden" class="cajaMinima" name="flagGenIndDet[' + n + ']" id="flagGenIndDet[' + n + ']" value="' + flagGenInd + '">';
    fila += '</div></td>';
    fila += '<td><div align="left">';
    fila += '<input type="text" class="cajaGeneral" style="width:395px;" maxlength="250" name="proddescri[' + n + ']" id="proddescri[' + n + ']" value="' + nombre_producto + '">';
    fila += '</div></td>';
    fila += '<td width="10%"><div align="left">';
    fila += '<input type="text" class="cajaGeneral" size="1" maxlength="5" name="prodcantidad[' + n + ']" id="prodcantidad[' + n + ']" value="' + cantidad + '" onblur="calcula_importe(' + n + ');" onkeypress="return numbersonly(this,event,\'.\');"> ' + nombre_unidad;
    if (flagGenInd == "I") {
        if (tipo_oper == 'V')
            fila += ' <a href="javascript:;" onclick="ventana_producto_serie2(' + n + ')"><img src="' + base_url + 'images/flag-green_icon.png" width="20" height="20" border="0" align="absmiddle" /></a>';
        else
            fila += ' <a href="javascript:;" onclick="ventana_producto_serie(' + n + ')"><img src="' + base_url + 'images/flag-green_icon.png" width="20" height="20" border="0" align="absmiddle" /></a>';
    }
    fila += '</div></td>';
    fila += '<td width="6%"><div align="center"><input type="text" size="5" maxlength="10" class="cajaGeneral" value="' + precio_conigv + '" name="prodpu_conigv[' + n + ']" id="prodpu_conigv[' + n + ']" onblur="modifica_pu_conigv(' + n + ');" onkeypress="return numbersonly(this,event,\'.\');" /></div></td>'
    fila += '<td width="6%"><div align="center"><input type text" size="5" maxlength="10" class="cajaGeneral" value="' + precio + '" name="prodpu[' + n + ']" id="prodpu[' + n + ']" onblur="modifica_pu(' + n + ');" onkeypress="return numbersonly(this,event,\'.\');">'
    fila += '<td width="6%"><div align="center"><input type="text" size="5" maxlength="10" class="cajaGeneral cajaSoloLectura" name="prodprecio[' + n + ']" id="prodprecio[' + n + ']" value="0" readonly="readonly"></div></td>';
    fila += '<td width="6%"><div align="center"><input type="text" size="5" maxlength="10" class="cajaGeneral cajaSoloLectura" name="prodigv[' + n + ']" id="prodigv[' + n + ']" readonly></div></td>';
    fila += '<td width="6%"><div align="center">';
    fila += '<input type="hidden" name="detacodi[' + n + ']" id="detacodi[' + n + ']">';
    fila += '<input type="hidden" name="detaccion[' + n + ']" id="detaccion[' + n + ']" value="n"/>';
    fila += '<input type="hidden" name="prodigv100[' + n + ']" id="prodigv100[' + n + ']" value="' + igv + '"/>';
    fila += '<input type="hidden" name="prodstock[' + n + ']" id="prodstock[' + n + ']" value="' + stock + '"/>';
    fila += '<input type="hidden" name="prodcosto[' + n + ']" id="prodcosto[' + n + ']" value="' + costo + '"/>';
    fila += '<input type="hidden" name="prodventa[' + n + ']" id="prodventa[' + n + ']" value="0" readonly="readonly"/>';
    fila += '<input type="hidden" name="proddescuento100[' + n + ']" id="proddescuento100[' + n + ']" value="0"/>';
    fila += '<input type="hidden" name="proddescuento[' + n + ']" id="proddescuento[' + n + ']" onblur="calcula_importe2(' + n + ');" />';
    fila += '<input type="text" size="5" maxlength="10" class="cajaGeneral cajaSoloLectura" name="prodimporte[' + n + ']" id="prodimporte[' + n + ']" value="0" readonly="readonly">';
    fila += '</div></td>';
    fila += '</tr>';
    $("#tblDetalleGuiaRem").append(fila);

    //inicializar_cabecera_item();  
    calcula_importe(n);
    $('#buscar_producto').val('');
    $('#nombre_producto').val('');
    $('#cantidad').val('');
    $('#precio').val('');
    return true;
}
function eliminar_producto_ocompra(n) {
    if (confirm('Esta seguro que desea eliminar este producto?')) {
        tabla = document.getElementById('tblDetalleGuiaRem');
        a = "detacodi[" + n + "]";
        b = "detaccion[" + n + "]";
        fila = document.getElementById(a).parentNode.parentNode.parentNode;
        fila.style.display = "none";
        document.getElementById(b).value = "e";

        calcula_totales();
    }
}
function calcula_importe(n) {
    a = "prodpu[" + n + "]";
    b = "prodcantidad[" + n + "]";
    c = "proddescuento[" + n + "]";
    d = "prodigv[" + n + "]";
    e = "prodprecio[" + n + "]";
    f = "prodimporte[" + n + "]";
    g = "prodigv100[" + n + "]";
    h = "proddescuento100[" + n + "]";
    i = "prodpu_conigv[" + n + "]";
    pu = document.getElementById(a).value;
    pu_conigv = document.getElementById(i).value;
    cantidad = document.getElementById(b).value;
    igv100 = document.getElementById(g).value;
    descuento100 = 0;  //document.getElementById(h).value;
    precio = money_format(pu * cantidad);
    total_dscto = money_format(precio * descuento100 / 100);
    precio2 = money_format(precio - parseFloat(total_dscto));

    if (pu_conigv == '')
        total_igv = money_format(precio2 * igv100 / 100);
    else {
        total_igv = money_format((pu_conigv - pu) * cantidad);
    }
    importe = money_format(precio - parseFloat(total_dscto) + parseFloat(total_igv));

    document.getElementById(c).value = total_dscto;
    document.getElementById(d).value = total_igv;
    document.getElementById(e).value = precio;
    document.getElementById(f).value = importe;

    calcula_totales();
}
function calcula_importe2(n) {
    a = "prodpu[" + n + "]";
    b = "prodcantidad[" + n + "]";
    c = "proddescuento[" + n + "]";
    e = "prodigv[" + n + "]";
    f = "prodprecio[" + n + "]";
    g = "prodimporte[" + n + "]";
    pu = parseFloat(document.getElementById(a).value);
    cantidad = parseFloat(document.getElementById(b).value);
    descuento = parseFloat(document.getElementById(c).value);
    total_igv = parseFloat(document.getElementById(e).value);


    importe = money_format((pu * cantidad) - descuento + total_igv);
    document.getElementById(g).value = importe;

    calcula_totales();
}
function calcula_totales() {
    n = document.getElementById('tblDetalleGuiaRem').rows.length;
    importe_total = 0;
    igv_total = 0;
    descuento_total = 0;
    precio_total = 0;
    for (i = 0; i < n; i++) {//Estanb al reves los campos
        a = "prodimporte[" + i + "]"
        b = "prodigv[" + i + "]";
        c = "proddescuento[" + i + "]";
        d = "prodprecio[" + i + "]";
        e = "detaccion[" + i + "]";
        if (document.getElementById(e).value != 'e') {
            //importe = parseFloat(document.getElementById(a).value);
            //igv = parseFloat(document.getElementById(b).value);
            descuento = parseFloat(document.getElementById(c).value);
            precio = parseFloat(document.getElementById(d).value);
            precio_total = money_format(precio + precio_total);
            //igv_total = money_format(igv + igv_total);
            descuento_total = money_format(descuento + descuento_total);

        }
    }
    igv100 = parseInt($("#igv").val());
    igv_total = money_format(precio_total * igv100 / 100);
    importe_total = money_format(precio_total + igv_total);

    $("#preciototal").val(precio_total.toFixed(2));
    $("#importetotal").val(importe_total.toFixed(2));
    $("#igvtotal").val(igv_total.toFixed(2));
    $("#descuentotal").val(descuento_total.toFixed(2));

}
function modifica_pu_conigv(n) {

    a = "prodpu_conigv[" + n + "]";
    g = "prodigv100[" + n + "]";
    i = "prodpu[" + n + "]";
    pu_conigv = parseFloat(document.getElementById(a).value);
    igv100 = parseFloat(document.getElementById(g).value);
    pu = money_format(100 * pu_conigv / (100 + igv100));
    if (isNaN(pu_conigv)) {
        pu_conigv = 0;
    }
    if (isNaN(igv100)) {
        igv100 = 0;
    }
    if (isNaN(pu)) {
        pu = 0;
    }
    document.getElementById(i).value = pu;

    calcula_importe(n);
}
function modifica_pu(n) {
    a = "prodpu[" + n + "]";
    g = "prodigv100[" + n + "]";
    i = "prodpu_conigv[" + n + "]";

    pu = parseFloat(document.getElementById(a).value);
    igv100 = parseFloat(document.getElementById(g).value);
    precio_conigv = money_format(pu * (100 + igv100) / 100);

    if (isNaN(precio_conigv)) {
        precio_conigv = 0;
    }
    if (isNaN(igv100)) {
        igv100 = 0;
    }
    if (isNaN(pu)) {
        pu = 0;
    }

    document.getElementById(i).value = precio_conigv;

    calcula_importe(n);
}

function obtener_detalle_factura() {
    factura = $("#factura").val();

    descuento100 = $("#descuento").val();
    igv100 = $("#igv").val();
    url = base_url + "index.php/ventas/comprobante/obtener_detalle_comprobante/" + factura;
    n = document.getElementById('tblDetalleGuiaRem').rows.length;

    $.getJSON(url, function (data) {
        limpiar_datos();
        $.each(data, function (i, item) {
            cliente = item.CLIP_Codigo;
            ruc = item.Ruc;
            razon_social = item.RazonSocial;
            moneda = item.MONED_Codigo;
            formapago = item.FORPAP_Codigo;
            serie = item.PRESUC_Serie;
            numero = item.PRESUC_Numero;
            codigo_usuario = item.PRESUC_CodigoUsuario;

            if (item.PRESDEP_Codigo != '') {
                j = n + 1
                producto = item.PROD_Codigo;
                codproducto = item.PROD_CodigoInterno;
                unidad_medida = item.UNDMED_Codigo;
                nombre_unidad = item.UNDMED_Simbolo;
                nombre_producto = item.PROD_Nombre;
                flagGenInd = item.PROD_GenericoIndividual;
                costo = item.PROD_CostoPromedio;
                cantidad = item.CPDEC_Cantidad;
                pu = item.CPDEC_Pu;
                subtotal = item.CPDEC_Subtotal;
                descuento = item.CPDEC_Descuento;
                igv = item.CPDEC_Igv;
                total = item.CPDEC_Total
                pu_conigv = item.CPDEC_Pu_ConIgv;
                subtotal_conigv = item.CPDEC_Subtotal_ConIgv;

                descuento_conigv = item.CPDEC_Descuento_ConIgv;

                if (j % 2 == 0) {
                    clase = "itemParTabla";
                } else {
                    clase = "itemImparTabla";
                }
                fila = '<tr class="' + clase + '">';
                fila += '<td width="3%"><div align="center"><font color="red"><strong><a href="javascript:;" onclick="eliminar_producto_ocompra(' + n + ');">';
                fila += '<span style="border:1px solid red;background: #ffffff;">&nbsp;X&nbsp;</span>';
                fila += '</a></strong></font></div></td>';
                fila += '<td width="4%"><div align="center">' + j + '</div></td>';
                fila += '<td width="10%"><div align="center">';
                fila += '<input type="hidden" class="cajaGeneral" name="prodcodigo[' + n + ']" id="prodcodigo[' + n + ']" value="' + producto + '">' + codproducto;
                fila += '<input type="hidden" class="cajaGeneral" name="produnidad[' + n + ']" id="produnidad[' + n + ']" value="' + unidad_medida + '">';
                fila += '<input type="hidden" class="cajaMinima" name="flagGenIndDet[' + n + ']" id="flagGenIndDet[' + n + ']" value="' + flagGenInd + '">';
                fila += '</div></td>';
                fila += '<td><div align="left"><input type="text" class="cajaGeneral" size="73" maxlength="250" name="proddescri[' + n + ']" id="proddescri[' + n + ']" value="' + nombre_producto + '" /></div></td>';
                fila += '<td width="10%"><div align="left"><input type="text" size="1" maxlength="5" class="cajaGeneral" name="prodcantidad[' + n + ']" id="prodcantidad[' + n + ']" value="' + cantidad + '" onblur="calcula_importe(' + n + ');calcula_totales();" onkeypress="return numbersonly(this,event,\'.\');">' + nombre_unidad;
                if (flagGenInd == "I") {
                    if (tipo_oper == 'V')
                        fila += ' <a href="javascript:;" onclick="ventana_producto_serie2(' + n + ')"><img src="' + base_url + 'images/flag-green_icon.png" width="20" height="20" border="0" align="absmiddle" /></a>';
                    else
                        fila += ' <a href="javascript:;" onclick="ventana_producto_serie(' + n + ')"><img src="' + base_url + 'images/flag-green_icon.png" width="20" height="20" border="0" align="absmiddle" /></a>';
                }
                fila += '</div></td>';
                fila += '<td width="6%"><div align="center"><input type="text" size="5" maxlength="10" class="cajaGeneral" name="prodpu[' + n + ']" id="prodpu[' + n + ']" value="' + pu + '" onblur="modifica_pu(' + n + ');" onkeypress="return numbersonly(this,event,\'.\');">';
                fila += '<input type="hidden" name="prodpu_conigv[' + n + ']" id="prodpu_conigv[' + n + ']" value="' + pu_conigv + '"></div></td>';
                fila += '<td width="6%"><input type="text" class="cajaGeneral cajaSoloLectura" size="5" maxlength="10" name="prodprecio[' + n + ']" id="prodprecio[' + n + ']" value="' + subtotal + '" readonly="readonly"></div></td>';
                fila += '<td width="6%"><div align="center">';
                fila += '<input type="hidden" name="proddescuento100[' + n + ']" id="proddescuento100[' + n + ']" value="' + descuento100 + '">';
                fila += '<input type="text" size="5" maxlength="10" class="cajaGeneral" name="proddescuento[' + n + ']" id="proddescuento[' + n + ']" value="' + descuento + '" onblur="calcula_importe2(' + n + ');calcula_totales();">';

                fila += '</div></td>';
                fila += '<td width="6%"><div align="center"><input type="text" size="5" class="cajaGeneral cajaSoloLectura" name="prodigv[' + n + ']" value="' + igv + '" id="prodigv[' + n + ']" readonly></div></td>';
                fila += '<td width="6%"><div align="center">';
                fila += '<input type="hidden" name="detacodi[' + n + ']" id="detacodi[' + n + ']">';
                fila += '<input type="hidden" name="detaccion[' + n + ']" id="detaccion[' + n + ']" value="n">';
                fila += '<input type="hidden" name="prodigv100[' + n + ']" id="prodigv100[' + n + ']" value="' + igv100 + '">';
                fila += '<input type="hidden" class="cajaPequena2" name="prodcosto[' + n + ']" id="prodcosto[' + n + ']" value="' + costo + '" readonly="readonly">';
                fila += '<input type="hidden" class="cajaPequena2" name="prodventa[' + n + ']" id="prodventa[' + n + ']" value="0" readonly="readonly">';
                fila += '<input type="text" size="5" class="cajaGeneral cajaSoloLectura" name="prodimporte[' + n + ']" id="prodimporte[' + n + ']" value="' + total + '" readonly="readonly" value="0">';
                fila += '</div></td>';
                fila += '</tr>';
                $("#tblDetalleGuiaRem").append(fila);
            }

            $('#ruc_cliente').val(ruc);
            $('#cliente').val(cliente);
            $('#nombre_cliente').val(razon_social);
            $('#moneda').val(moneda);

            n++;
        })
        if (n >= 0)
            calcula_totales();
        else
            alert('La factura no tiene elementos.');
    });
}

function obtener_detalle_presupuesto() {
    //presupuesto =  $("#presupuesto").val();
    var presupuesto = $(this).val();
    var seriep = $("#seriep").val();

    descuento100 = $("#descuento").val();
    igv100 = $("#igv").val();


    //url = base_url+"index.php/ventas/presupuesto/obtener_detalle_presupuesto/"+"V/"+"F/"+presupuesto;
    url = base_url + "index.php/ventas/presupuesto/obtener_detalle_presupuesto1/" + "V/F/" + seriep + "/" + presupuesto;
    n = document.getElementById('tblDetalleGuiaRem').rows.length;

    $.getJSON(url, function (data) {
        limpiar_datos();
        $.each(data, function (i, item) {
            cliente = item.CLIP_Codigo;
            ruc = item.Ruc;
            razon_social = item.RazonSocial;
            moneda = item.MONED_Codigo;
            formapago = item.FORPAP_Codigo;
            serie = item.PRESUC_Serie;
            numero = item.PRESUC_Numero;
            codigo_usuario = item.PRESUC_CodigoUsuario;


            if (item.PRESDEP_Codigo != '') {
                j = n + 1
                producto = item.PROD_Codigo;
                codproducto = item.PROD_CodigoInterno;
                unidad_medida = item.UNDMED_Codigo;
                nombre_unidad = item.UNDMED_Simbolo;
                nombre_producto = item.PROD_Nombre;
                flagGenInd = item.PROD_GenericoIndividual;
                costo = item.PROD_CostoPromedio;
                cantidad = item.PRESDEC_Cantidad;
                pu = item.PRESDEC_Pu;
                subtotal = item.PRESDEC_Subtotal;
                descuento = item.PRESDEC_Descuento;
                igv = item.PRESDEC_Igv;
                total = item.PRESDEC_Total
                pu_conigv = item.PRESDEC_Pu_ConIgv;
                subtotal_conigv = item.PRESDEC_Subtotal_ConIgv;

                descuento_conigv = item.PRESDEC_Descuento_ConIgv;

                if (j % 2 == 0) {
                    clase = "itemParTabla";
                } else {
                    clase = "itemImparTabla";
                }
                fila = '<tr class="' + clase + '">';
                fila += '<td width="3%"><div align="center"><font color="red"><strong><a href="javascript:;" onclick="eliminar_producto_ocompra(' + n + ');">';
                fila += '<span style="border:1px solid red;background: #ffffff;">&nbsp;X&nbsp;</span>';
                fila += '</a></strong></font></div></td>';
                fila += '<td width="4%"><div align="center">' + j + '</div></td>';
                fila += '<td width="10%"><div align="center">';
                fila += '<input type="hidden" class="cajaGeneral" name="prodcodigo[' + n + ']" id="prodcodigo[' + n + ']" value="' + producto + '">' + codproducto;
                fila += '<input type="hidden" class="cajaGeneral" name="produnidad[' + n + ']" id="produnidad[' + n + ']" value="' + unidad_medida + '">';
                fila += '<input type="hidden" class="cajaMinima" name="flagGenIndDet[' + n + ']" id="flagGenIndDet[' + n + ']" value="' + flagGenInd + '">';
                fila += '</div></td>';
                fila += '<td><div align="left"><input type="text" class="cajaGeneral" size="73" maxlength="250" name="proddescri[' + n + ']" id="proddescri[' + n + ']" value="' + nombre_producto + '" /></div></td>';
                fila += '<td width="10%"><div align="left"><input type="text" size="1" maxlength="5" class="cajaGeneral" name="prodcantidad[' + n + ']" id="prodcantidad[' + n + ']" value="' + cantidad + '" onblur="calcula_importe(' + n + ');calcula_totales();" onkeypress="return numbersonly(this,event,\'.\');">' + nombre_unidad;
                if (flagGenInd == "I") {
                    if (tipo_oper == 'V')
                        fila += ' <a href="javascript:;" onclick="ventana_producto_serie2(' + n + ')"><img src="' + base_url + 'images/flag-green_icon.png" width="20" height="20" border="0" align="absmiddle" /></a>';
                    else
                        fila += ' <a href="javascript:;" onclick="ventana_producto_serie(' + n + ')"><img src="' + base_url + 'images/flag-green_icon.png" width="20" height="20" border="0" align="absmiddle" /></a>';
                }
                fila += '</div></td>';
                fila += '<td width="6%"><div align="center"><input type="text" size="5" maxlength="10" class="cajaGeneral" name="prodpu[' + n + ']" id="prodpu[' + n + ']" value="' + pu + '" onblur="modifica_pu(' + n + ');" onkeypress="return numbersonly(this,event,\'.\');">';
                fila += '<input type="hidden" name="prodpu_conigv[' + n + ']" id="prodpu_conigv[' + n + ']" value="' + pu_conigv + '"></div></td>';
                fila += '<td width="6%"><input type="text" class="cajaGeneral cajaSoloLectura" size="5" maxlength="10" name="prodprecio[' + n + ']" id="prodprecio[' + n + ']" value="' + subtotal + '" readonly="readonly"></div></td>';
                fila += '<td width="6%"><div align="center">';
                fila += '<input type="hidden" name="proddescuento100[' + n + ']" id="proddescuento100[' + n + ']" value="' + descuento100 + '">';
                fila += '<input type="text" size="5" maxlength="10" class="cajaGeneral" name="proddescuento[' + n + ']" id="proddescuento[' + n + ']" value="' + descuento + '" onblur="calcula_importe2(' + n + ');calcula_totales();">';

                fila += '</div></td>';
                fila += '<td width="6%"><div align="center"><input type="text" size="5" class="cajaGeneral cajaSoloLectura" name="prodigv[' + n + ']" value="' + igv + '" id="prodigv[' + n + ']" readonly></div></td>';
                fila += '<td width="6%"><div align="center">';
                fila += '<input type="hidden" name="detacodi[' + n + ']" id="detacodi[' + n + ']">';
                fila += '<input type="hidden" name="detaccion[' + n + ']" id="detaccion[' + n + ']" value="n">';
                fila += '<input type="hidden" name="prodigv100[' + n + ']" id="prodigv100[' + n + ']" value="' + igv100 + '">';
                fila += '<input type="hidden" class="cajaPequena2" name="prodcosto[' + n + ']" id="prodcosto[' + n + ']" value="' + costo + '" readonly="readonly">';
                fila += '<input type="hidden" class="cajaPequena2" name="prodventa[' + n + ']" id="prodventa[' + n + ']" value="0" readonly="readonly">';
                fila += '<input type="text" size="5" class="cajaGeneral cajaSoloLectura" name="prodimporte[' + n + ']" id="prodimporte[' + n + ']" value="' + total + '" readonly="readonly" value="0">';
                fila += '</div></td>';
                fila += '</tr>';
                $("#tblDetalleGuiaRem").append(fila);
            }

            $('#ruc_cliente').val(ruc);
            $('#cliente').val(cliente);
            $('#nombre_cliente').val(razon_social);
            $('#moneda').val(moneda);
            n++;
        })
        if (n >= 0)
            calcula_totales();
        else
            alert('El presupuesto no tiene elementos.');
    });
}
function obtener_detalle_ocompra(lista_ocompra) {

    n = document.getElementById('tblDetalleGuiaRem').rows.length;


    limpiar_datos();
    for (var i = 0; i < lista_ocompra.lenght; i++) {
        item = lista_ocompra[i];

        cliente = item.CLIP_Codigo;
        ruc = item.Ruc;
        razon_social = item.RazonSocial;
        moneda = item.MONED_Codigo;
        formapago = item.FORPAP_Codigo;
        numero = item.OCOMC_Numero;

        if (item.PRESDEP_Codigo != '') {
            j = n + 1
            producto = item.PROD_Codigo;
            codproducto = item.PROD_CodigoInterno;
            unidad_medida = item.UNDMED_Codigo;
            nombre_unidad = item.UNDMED_Simbolo;
            nombre_producto = item.PROD_Nombre;
            flagGenInd = item.PROD_GenericoIndividual;
            costo = item.PROD_CostoPromedio;
            cantidad = item.OCOMDEP_Cantidad;
            pu = item.OCOMDEP_Pu;
            subtotal = item.OCOMDEP_Subtotal;
            descuento = item.OCOMDEP_Descuento;
            descuento2 = item.OCOMDEP_Descuento2;
            igv = item.OCOMDEP_Igv;
            total = item.OCOMDEP_Total
            pu_conigv = item.OCOMDEP_Pu_ConIgv;
            subtotal_conigv = item.OCOMDEP_Subtotal_ConIgv;

            descuento_conigv = item.OCOMDEP_Descuento_ConIgv;

            if (j % 2 == 0) {
                clase = "itemParTabla";
            } else {
                clase = "itemImparTabla";
            }
            fila = '<tr class="' + clase + '">';
            fila += '<td width="3%"><div align="center"><font color="red"><strong><a href="javascript:;" onclick="eliminar_producto_ocompra(' + n + ');">';
            fila += '<span style="border:1px solid red;background: #ffffff;">&nbsp;X&nbsp;</span>';
            fila += '</a></strong></font></div></td>';
            fila += '<td width="4%"><div align="center">' + j + '</div></td>';
            fila += '<td width="10%"><div align="center">';
            fila += '<input type="hidden" class="cajaGeneral" name="prodcodigo[' + n + ']" id="prodcodigo[' + n + ']" value="' + producto + '">' + codproducto;
            fila += '<input type="hidden" class="cajaGeneral" name="produnidad[' + n + ']" id="produnidad[' + n + ']" value="' + unidad_medida + '">';
            fila += '<input type="hidden" class="cajaMinima" name="flagGenIndDet[' + n + ']" id="flagGenIndDet[' + n + ']" value="' + flagGenInd + '">';
            fila += '</div></td>';
            fila += '<td><div align="left"><input type="text" class="cajaGeneral" size="73" maxlength="250" name="proddescri[' + n + ']" id="proddescri[' + n + ']" value="' + nombre_producto + '" /></div></td>';
            fila += '<td width="10%"><div align="left"><input type="text" size="1" maxlength="5" class="cajaGeneral" name="prodcantidad[' + n + ']" id="prodcantidad[' + n + ']" value="' + cantidad + '" onblur="calcula_importe(' + n + ');calcula_totales();" onkeypress="return numbersonly(this,event,\'.\');">' + nombre_unidad;
            if (flagGenInd == "I") {
                if (tipo_oper == 'V')
                    fila += ' <a href="javascript:;" onclick="ventana_producto_serie2(' + n + ')"><img src="' + base_url + 'images/flag-green_icon.png" width="20" height="20" border="0" align="absmiddle"/></a>';
                else
                    fila += ' <a href="javascript:;" onclick="ventana_producto_serie(' + n + ')"><img src="' + base_url + 'images/flag-green_icon.png" width="20" height="20" border="0" align="absmiddle"/></a>';
            }
            fila += '</div></td>';
            fila += '<td width="6%"><div align="center"><input type="text" size="5" maxlength="10" class="cajaGeneral" name="prodpu[' + n + ']" id="prodpu[' + n + ']" value="' + pu + '" onblur="modifica_pu(' + n + ');" onkeypress="return numbersonly(this,event,\'.\');">';
            fila += '<input type="hidden" name="prodpu_conigv[' + n + ']" id="prodpu_conigv[' + n + ']" value="' + pu_conigv + '"></div></td>';
            fila += '<td width="6%"><input type="text" class="cajaGeneral cajaSoloLectura" size="5" maxlength="10" name="prodprecio[' + n + ']" id="prodprecio[' + n + ']" value="' + subtotal + '" readonly="readonly"></div></td>';
            fila += '<td width="6%"><div align="center">';
            fila += '<input type="hidden" name="proddescuento100[' + n + ']" id="proddescuento100[' + n + ']" value="' + descuento100 + '">';
            fila += '<input type="text" size="5" maxlength="10" class="cajaGeneral" name="proddescuento[' + n + ']" id="proddescuento[' + n + ']" value="' + descuento + '" onblur="calcula_importe2(' + n + ');calcula_totales();">';

            fila += '</div></td>';
            fila += '<td width="6%"><div align="center"><input type="text" size="5" class="cajaGeneral cajaSoloLectura" name="prodigv[' + n + ']" value="' + igv + '" id="prodigv[' + n + ']" readonly></div></td>';
            fila += '<td width="6%"><div align="center"><input type="text" size="5" class="cajaGeneral cajaSoloLectura" name="prodigv[' + n + ']" value="' + descuento2 + '" id="prodigv[' + n + ']" readonly></div></td>';
            fila += '<td width="6%"><div align="center">';
            fila += '<input type="hidden" name="detacodi[' + n + ']" id="detacodi[' + n + ']">';
            fila += '<input type="hidden" name="detaccion[' + n + ']" id="detaccion[' + n + ']" value="n">';
            fila += '<input type="hidden" name="prodigv100[' + n + ']" id="prodigv100[' + n + ']" value="' + igv100 + '">';
            fila += '<input type="hidden" class="cajaPequena2" name="prodcosto[' + n + ']" id="prodcosto[' + n + ']" value="' + costo + '" readonly="readonly">';
            fila += '<input type="hidden" class="cajaPequena2" name="prodventa[' + n + ']" id="prodventa[' + n + ']" value="0" readonly="readonly">';
            fila += '<input type="text" size="5" class="cajaGeneral cajaSoloLectura" name="prodimporte[' + n + ']" id="prodimporte[' + n + ']" value="' + total + '" readonly="readonly" value="0">';
            fila += '</div></td>';
            fila += '</tr>';
            $("#tblDetalleGuiaRem").append(fila);
        }

        $('#ruc_cliente').val(ruc);
        $('#cliente').val(cliente);
        $('#nombre_cliente').val(razon_social);
        $('#moneda').val(moneda);

        n++;
    }
    if (n >= 0)
        calcula_totales();
    else
        alert('La Orden de Venta no tiene elementos.');

}
function limpiar_datos() {
    /*$('#ruc_cliente').val('');
     $('#cliente').val('');
     $('#nombre_cliente').val('');*/
    $('#moneda').val('1');

    n = document.getElementById('tblDetalleGuiaRem').rows.length;
    for (i = 0; i < n; i++) {
        a = "detacodi[" + i + "]";
        b = "detaccion[" + i + "]";
        fila = document.getElementById(a).parentNode.parentNode.parentNode;
        fila.style.display = "none";
        document.getElementById(b).value = "e";
    }
}
function listar_establecimientos(cliente) {
    select = document.getElementById('dir_entrega');
    url = base_url + "index.php/ventas/cliente/listar_establecimientos/" + cliente;
    $.getJSON(url, function (data) {
        opt0 = document.createElement('option');
        texto0 = document.createTextNode("::Seleccione::");
        opt0.appendChild(texto0);
        opt0.value = "";
        select.appendChild(opt0);
        $.each(data, function (i, item) {
            codigo = item.empresaEstab;
            descripcion = item.direccion;
            opt = document.createElement('option');
            texto = document.createTextNode(descripcion);
            opt.appendChild(texto);
            opt.value = codigo;
            select.appendChild(opt);
        });
    });
}
function inicializar_cabecera_item() {
    $("#producto").val('');
    $("#buscar_producto").val('');
    $("#codproducto").val('');
    $("#nombre_producto").val('');
    $("#cantidad").val('');
    $("#stock").val('0');
    $("#costo").val('');
    $("#nombre_unidad").val('');
    $("#unidad_medida").val('0');
    $("#flagGenInd").val('');
    $("#precioProducto").val('');
    $("#precio").val('');
    limpiar_combobox('unidad_medida');
}

// gcbq
function agregar_producto_guiarem2(codproducto, producto, nombre_producto, cantidad, igv, precio_conigv, unidad_medida, nombre_unidad, codigo_orden, flagGenInd, moneda) {
    igv = parseInt(igv);
    if (contiene_igv == '1')
        precio = money_format(precio_conigv * 100 / (igv + 100))
    else {
        precio = precio_conigv;
        precio_conigv = money_format(precio_conigv * (100 + igv) / 100);
    }
    stock = '0'
    costo = '0';
    n = document.getElementById('tblDetalleGuiaRem').rows.length;

    if ($("#ordencompra").val() != codigo_orden) {
        limpiar_datos();
    }

    j = n + 1;
    if (j % 2 == 0) {
        clase = "itemParTabla";
    } else {
        clase = "itemImparTabla";
    }
    fila = '<tr class="' + clase + '">';
    fila += '<td width="3%"><div align="center"><font color="red"><strong><a href="javascript:;" onclick="eliminar_producto_ocompra(' + n + ');">';
    fila += '<span style="border:1px solid red;background: #ffffff;">&nbsp;X&nbsp;</span>';
    fila += '</a></strong></font></div></td>';
    fila += '<td width="4%"><div align="center">' + j + '</div></td>';
    fila += '<td width="10%"><div align="center">';
    fila += '<input type="hidden" class="cajaMinima" name="prodcodigo[' + n + ']" id="prodcodigo[' + n + ']" value="' + codproducto + '">' + producto;
    fila += '<input type="hidden" class="cajaMinima" name="produnidad[' + n + ']" id="produnidad[' + n + ']" value="' + unidad_medida + '">';
    fila += '<input type="hidden" class="cajaMinima" name="flagGenIndDet[' + n + ']" id="flagGenIndDet[' + n + ']" value="' + flagGenInd + '">';
    fila += '</div></td>';
    fila += '<td><div align="left">';
    fila += '<input type="text" class="cajaGeneral" style="width:395px;" maxlength="250" name="proddescri[' + n + ']" id="proddescri[' + n + ']" value="' + nombre_producto + '">';
    fila += '</div></td>';
    fila += '<td width="10%"><div align="left">';
    fila += '<input type="text" class="cajaGeneral" size="1" maxlength="5" name="prodcantidad[' + n + ']" id="prodcantidad[' + n + ']" value="' + cantidad + '" onblur="calcula_importe(' + n + ');" onkeypress="return numbersonly(this,event,\'.\');"> ' + nombre_unidad;
    if (flagGenInd == "I") {
        if (tipo_oper == 'V')
            fila += ' <a href="javascript:;" onclick="ventana_producto_serie2(' + n + ')"><img src="' + base_url + 'images/flag-green_icon.png" width="20" height="20" border="0" align="absmiddle"/></a>';
        else
            fila += ' <a href="javascript:;" onclick="ventana_producto_serie(' + n + ')"><img src="' + base_url + 'images/flag-green_icon.png" width="20" height="20" border="0" align="absmiddle" /></a>';
    }
    fila += '</div></td>';
    fila += '<td width="6%"><div align="center"><input type="text"  size="5" maxlength="10" value="' + precio_conigv + '" name="prodpu_conigv[' + n + ']" id="prodpu_conigv[' + n + ']" onblur="modifica_pu_conigv(' + n + ');"></div></td>';
    fila += '<td width="6%"><div align="center"><input type text" size="5" maxlength="10" class="cajaGeneral" value="' + precio + '" name="prodpu[' + n + ']" id="prodpu[' + n + ']" onblur="modifica_pu(' + n + ');" onkeypress="return numbersonly(this,event,\'.\');">'
    fila += '<td width="6%"><div align="center"><input type="text" size="5" maxlength="10" class="cajaGeneral cajaSoloLectura" name="prodprecio[' + n + ']" id="prodprecio[' + n + ']" value="0" readonly="readonly"></div></td>';
    fila += '<td width="6%" style="display:none"><div align="center">';
    fila += '<input type="hidden" name="proddescuento100[' + n + ']" id="proddescuento100[' + n + ']" value="0">';
    fila += '<input type="hidden" size="5" maxlength="10" class="cajaGeneral" name="proddescuento[' + n + ']" id="proddescuento[' + n + ']" onblur="calcula_importe2(' + n + ');" />';
    fila += '</div></td>';
    fila += '<td width="6%"><div align="center"><input type="text" size="5" maxlength="10" class="cajaGeneral cajaSoloLectura" name="prodigv[' + n + ']" id="prodigv[' + n + ']" readonly></div></td>';
    fila += '<td width="6%"><div align="center">';
    fila += '<input type="hidden" class="cajaMinima" name="detacodi[' + n + ']" id="detacodi[' + n + ']">';
    fila += '<input type="hidden" class="cajaMinima" name="detaccion[' + n + ']" id="detaccion[' + n + ']" value="n">';
    fila += '<input type="hidden" name="prodigv100[' + n + ']" id="prodigv100[' + n + ']" value="' + igv + '">';
    fila += '<input type="hidden" class="cajaPequena2" name="prodcosto[' + n + ']" id="prodcosto[' + n + ']" value="' + costo + '" readonly="readonly">';
    fila += '<input type="hidden" class="cajaPequena2" name="prodventa[' + n + ']" id="prodventa[' + n + ']" value="0" readonly="readonly">';
    fila += '<input type="text" size="5" maxlength="10" class="cajaGeneral cajaSoloLectura" name="prodimporte[' + n + ']" id="prodimporte[' + n + ']" value="0" readonly="readonly">';
    fila += '</div></td>';
    fila += '</tr>';
    $("#tblDetalleGuiaRem").append(fila);

    calcula_importe(n);

    $('#ordencompra').val(codigo_orden);
    return true;
}
function agregar_ocompra_guiarem2(proveedor, ruc_proveedor, nombre_proveedor, almacen, moneda, numero, codigo_usuario) {
    tipo_oper = $("#tipo_oper").val();

    if (tipo_oper == 'V') {
        $('#cliente').val(proveedor);
        $('#ruc_cliente').val(ruc_proveedor);
        $('#nombre_cliente').val(nombre_proveedor);
    } else {
        $('#proveedor').val(proveedor);
        $('#ruc_proveedor').val(ruc_proveedor);
        $('#nombre_proveedor').val(nombre_proveedor);
    }

    $("#serieguiaverOC").html("O. de compra: " + numero + '-' + codigo_usuario);
    $("#serieguiaverOC").show(2000);
    $("#serieguiaverRecu").hide(2000);
    $("#serieguiaver").hide(2000);
    $("#serieguiaverPre").hide(2000);
    $("#numero_ref").val('');
    $("#dRef").val('');

    $('#almacen').val(almacen);
    if (moneda == 'NUEVOS SOLES') {
        $('#moneda').val('1');
    } else {
        $('#moneda').val('2');
    }
}

function mostrar_ventana_series() {
    tipo_oper = $("#tipo_oper").val();
    if (tipo_oper == 'V')
        ventana_producto_serie2(0)
    else
        ventana_producto_serie(0)
}

function modifica_pu2(prodpu, prodigv100, prodpu_conigv, n) {
    n = n - 1;
    i = "prodpu_conigv[" + n + "]";
    pu = parseFloat(prodpu);
    igv100 = parseFloat(prodigv100);
    precio_conigv = money_format(pu * (100 + igv100) / 100);
    document.getElementById(i).value = precio_conigv;
    calcula_importe(n);
}

function limpiar_campos_producto() {
    $("#producto,  #codproducto, #nombre_producto, #cantidad, #precio").val('');
    limpiar_combobox('unidad_medida');
    if ($('#flagBS').val() == 'B')
        $('#unidad_medida').show();
    else
        $('#unidad_medida').hide();
    $('#linkVerProducto').attr('href', '' + base_url + 'index.php/almacen/producto/ventana_busqueda_producto/' + $('#flagBS').val());
}
function agregar_todo(guia) {
    descuento100 = $("#descuento").val();
    igv100 = $("#igv").val();
    url = base_url + "index.php/ventas/comprobante/obtener_detalle_comprobante/" + guia;
    n = document.getElementById('tblDetalleGuiaRem').rows.length;
    presupuesto = $("#presupuesto").val();


    $.getJSON(url, function (data) {
        limpiar_datos();
        $.each(data, function (i, item) {
            cliente = item.CLIP_Codigo;
            ruc = item.Ruc;
            razon_social = item.RazonSocial;
            moneda = item.MONED_Codigo;
            formapago = item.FORPAP_Codigo;
            serie = item.PRESUC_Serie;
            numero = item.PRESUC_Numero;
            codigo_usuario = item.PRESUC_CodigoUsuario;


            if (item.PRESDEP_Codigo != '') {
                j = n + 1
                producto = item.PROD_Codigo;
                codproducto = item.PROD_CodigoInterno;
                unidad_medida = item.UNDMED_Codigo;
                nombre_unidad = item.UNDMED_Simbolo;
                nombre_producto = item.PROD_Nombre;
                flagGenInd = item.CPDEC_GenInd;
                costo = item.CPDEC_Costo;
                cantidad = item.CPDEC_Cantidad;
                pu = item.CPDEC_Pu;
                subtotal = item.CPDEC_Subtotal;
                descuento = item.CPDEC_Descuento;
                igv = item.CPDEC_Igv;
                total = item.CPDEC_Total
                pu_conigv = item.CPDEC_Pu_ConIgv;
                subtotal_conigv = item.CPDEC_Subtotal_ConIgv;

                descuento_conigv = item.CPDEC_Descuento_ConIgv;


                if (j % 2 == 0) {
                    clase = "itemParTabla";
                } else {
                    clase = "itemImparTabla";
                }
                fila = '<tr class="' + clase + '">';
                fila += '<td width="3%"><div align="center"><font color="red"><strong><a href="javascript:;" onclick="eliminar_producto_ocompra(' + n + ');">';
                fila += '<span style="border:1px solid red;background: #ffffff;">&nbsp;X&nbsp;</span>';
                fila += '</a></strong></font></div></td>';
                fila += '<td width="4%"><div align="center">' + j + '</div></td>';
                fila += '<td width="10%"><div align="center">';
                fila += '<input type="hidden" class="cajaGeneral" name="prodcodigo[' + n + ']" id="prodcodigo[' + n + ']" value="' + producto + '">' + codproducto;
                fila += '<input type="hidden" class="cajaGeneral" name="produnidad[' + n + ']" id="produnidad[' + n + ']" value="' + unidad_medida + '">';
                fila += '<input type="hidden" class="cajaMinima" name="flagGenIndDet[' + n + ']" id="flagGenIndDet[' + n + ']" value="' + flagGenInd + '">';
                fila += '</div></td>';
                fila += '<td><div align="left"><input type="text" class="cajaGeneral" size="73" maxlength="250" name="proddescri[' + n + ']" id="proddescri[' + n + ']" value="' + nombre_producto + '" /></div></td>';
                fila += '<td width="10%"><div align="left"><input type="text" size="1" maxlength="5" class="cajaGeneral" name="prodcantidad[' + n + ']" id="prodcantidad[' + n + ']" value="' + cantidad + '" onblur="calcula_importe(' + n + ');calcula_totales();" onkeypress="return numbersonly(this,event,\'.\');">' + nombre_unidad;
                if (flagGenInd == "I") {
                    if (tipo_oper == 'V')
                        fila += ' <a href="javascript:;" onclick="ventana_producto_serie2(' + n + ')"><img src="' + base_url + 'images/flag-green_icon.png" width="20" height="20" border="0" align="absmiddle" /></a>';
                    else
                        fila += ' <a href="javascript:;" onclick="ventana_producto_serie(' + n + ')"><img src="' + base_url + 'images/flag-green_icon.png" width="20" height="20" border="0" align="absmiddle" /></a>';
                }
                fila += '</div></td>';
                fila += '<td width="6%"><div align="center"><input type="text" size="5" maxlength="10" class="cajaGeneral" name="prodpu_conigv[' + n + ']" id="prodpu_conigv[' + n + ']" value="' + pu_conigv + '"  onblur="modifica_pu_conigv(' + n + ');" onkeypress="return numbersonly(this,event,\'.\');" /></div></td>'
                fila += '<td width="6%"><div align="center"><input type="text" size="5" maxlength="10" class="cajaGeneral" name="prodpu[' + n + ']" id="prodpu[' + n + ']" value="' + pu + '" onblur="modifica_pu(' + n + ');" onkeypress="return numbersonly(this,event,\'.\');">';
                fila += '<td width="6%"><input type="text" class="cajaGeneral cajaSoloLectura" size="5" maxlength="10" name="prodprecio[' + n + ']" id="prodprecio[' + n + ']" value="' + subtotal + '" readonly="readonly"></div></td>';
                fila += '<td width="6%" style="display:none;"><div align="center">';
                fila += '<input type="hidden" name="proddescuento100[' + n + ']" id="proddescuento100[' + n + ']" value="' + descuento100 + '">';
                fila += '<input type="hidden" size="5" maxlength="10" class="cajaGeneral" name="proddescuento[' + n + ']" id="proddescuento[' + n + ']" value="' + descuento + '" onblur="calcula_importe(' + n + ');calcula_totales();">';

                fila += '</div></td>';
                fila += '<td width="6%"><div align="center"><input type="text" size="5" class="cajaGeneral cajaSoloLectura" name="prodigv[' + n + ']" value="' + igv + '" id="prodigv[' + n + ']" readonly></div></td>';
                fila += '<td width="6%"><div align="center">';
                fila += '<input type="hidden" name="detacodi[' + n + ']" id="detacodi[' + n + ']">';
                fila += '<input type="hidden" name="detaccion[' + n + ']" id="detaccion[' + n + ']" value="n">';
                fila += '<input type="hidden" name="prodigv100[' + n + ']" id="prodigv100[' + n + ']" value="' + igv100 + '">';
                fila += '<input type="hidden" class="cajaPequena2" name="prodcosto[' + n + ']" id="prodcosto[' + n + ']" value="' + costo + '" readonly="readonly">';
                fila += '<input type="hidden" class="cajaPequena2" name="prodventa[' + n + ']" id="prodventa[' + n + ']" value="0" readonly="readonly">';
                fila += '<input type="text" size="5" class="cajaGeneral cajaSoloLectura" name="prodimporte[' + n + ']" id="prodimporte[' + n + ']" value="' + total + '" readonly="readonly" value="0">';
                fila += '</div></td>';
                fila += '</tr>';
                $("#tblDetalleGuiaRem").append(fila);

            }

            $('#ruc_cliente').val(ruc);
            $('#cliente').val(cliente);
            $('#nombre_cliente').val(razon_social);
            $('#moneda').val(moneda);
            if (codigo_usuario)
                $("#numero_ref").val(codigo_usuario);
            else if (serie)
                $("#numero_ref").val(serie + '-' + numero);
            else
                $("#numero_ref").val(numero);
            n++;
        })
        if (n >= 0)
            if (tipo_docu != 'B' && tipo_docu != 'N')
                calcula_totales();
            else
                calcula_totales_conigv();
        else
            alert('El presupuesto no tiene elementos.');
    });
}
function calcula_totales_conigv() {
    n = document.getElementById('tblDetalleGuiaRem').rows.length;
    importe_total = 0;
    descuento_total_conigv = 0;
    precio_total_conigv = 0;
    for (i = 0; i < n; i++) {//Estanb al reves los campos
        a = "prodimporte[" + i + "]"
        c = "proddescuento_conigv[" + i + "]";
        d = "prodprecio_conigv[" + i + "]";
        e = "detaccion[" + i + "]";
        if (document.getElementById(e).value != 'e') {
            importe = parseFloat(document.getElementById(a).value);
            descuento_conigv = parseFloat(document.getElementById(c).value);
            precio_conigv = parseFloat(document.getElementById(d).value);
            importe_total = money_format(importe + importe_total);
            descuento_total_conigv = money_format(descuento_conigv + descuento_total_conigv);
            precio_total_conigv = money_format(precio_conigv + precio_total_conigv);
        }
    }


    $("#importetotal").val(importe_total.toFixed(2));
    $("#descuentotal_conigv").val(descuento_total_conigv.toFixed(2));
    $("#preciototal_conigv").val(precio_total_conigv.toFixed(2));
}
function agregar_todopresupuesto(guia, tipo_oper) {


    //presupuesto =  $("#presupuesto").val();

    descuento100 = $("#descuento").val();
    igv100 = $("#igv").val();

    url = base_url + "index.php/ventas/presupuesto/obtener_detalle_presupuesto/" + tipo_oper + "/" + tipo_docu + "/" + guia;

    n = document.getElementById('tblDetalleGuiaRem').rows.length;

    $.getJSON(url, function (data) {
        //limpiar_datos();
        $.each(data, function (i, item) {
            /* cliente         = item.CLIP_Codigo ;
             ruc             = item.Ruc;
             razon_social    = item.RazonSocial;*/
            moneda = item.MONED_Codigo;
            formapago = item.FORPAP_Codigo;
            serie = item.PRESUC_Serie;
            numero = item.PRESUC_Numero;
            codigo_usuario = item.PRESUC_CodigoUsuario;


            if (item.PRESDEP_Codigo != '') {
                j = n + 1
                producto = item.PROD_Codigo;
                codproducto = item.PROD_CodigoInterno;
                unidad_medida = item.UNDMED_Codigo;
                nombre_unidad = item.UNDMED_Simbolo;
                nombre_producto = item.PROD_Nombre;
                flagGenInd = item.PROD_GenericoIndividual;
                costo = item.PROD_CostoPromedio;
                cantidad = item.PRESDEC_Cantidad;
                pu = item.PRESDEC_Pu;
                subtotal = item.PRESDEC_Subtotal;
                descuento = item.PRESDEC_Descuento;
                igv = item.PRESDEC_Igv;
                total = item.PRESDEC_Total
                pu_conigv = item.PRESDEC_Pu_ConIgv;
                subtotal_conigv = item.PRESDEC_Subtotal_ConIgv;

                descuento_conigv = item.PRESDEC_Descuento_ConIgv;

                if (j % 2 == 0) {
                    clase = "itemParTabla";
                } else {
                    clase = "itemImparTabla";
                }
                fila = '<tr class="' + clase + '">';
                fila += '<td width="3%"><div align="center"><font color="red"><strong><a href="javascript:;" onclick="eliminar_producto_ocompra(' + n + ');">';
                fila += '<span style="border:1px solid red;background: #ffffff;">&nbsp;X&nbsp;</span>';
                fila += '</a></strong></font></div></td>';
                fila += '<td width="4%"><div align="center">' + j + '</div></td>';
                fila += '<td width="10%"><div align="center">';
                fila += '<input type="hidden" class="cajaGeneral" name="prodcodigo[' + n + ']" id="prodcodigo[' + n + ']" value="' + producto + '">' + codproducto;
                fila += '<input type="hidden" class="cajaGeneral" name="produnidad[' + n + ']" id="produnidad[' + n + ']" value="' + unidad_medida + '">';
                fila += '<input type="hidden" class="cajaMinima" name="flagGenIndDet[' + n + ']" id="flagGenIndDet[' + n + ']" value="' + flagGenInd + '">';
                fila += '</div></td>';
                fila += '<td><div align="left"><input type="text" class="cajaGeneral" size="73" maxlength="250" name="proddescri[' + n + ']" id="proddescri[' + n + ']" value="' + nombre_producto + '" /></div></td>';
                fila += '<td width="10%"><div align="left"><input type="text" size="1" maxlength="5" class="cajaGeneral" name="prodcantidad[' + n + ']" id="prodcantidad[' + n + ']" value="' + cantidad + '" onblur="calcula_importe(' + n + ');calcula_totales();" onkeypress="return numbersonly(this,event,\'.\');">' + nombre_unidad;
                if (flagGenInd == "I") {
                    if (tipo_oper == 'V')
                        fila += ' <a href="javascript:;" onclick="ventana_producto_serie2(' + n + ')"><img src="' + base_url + 'images/flag-green_icon.png" width="20" height="20" border="0" align="absmiddle" /></a>';
                    else
                        fila += ' <a href="javascript:;" onclick="ventana_producto_serie(' + n + ')"><img src="' + base_url + 'images/flag-green_icon.png" width="20" height="20" border="0" align="absmiddle" /></a>';
                }
                fila += '</div></td>';
                fila += '<td width="6%"><div align="center"><input type="text" name="prodpu_conigv[' + n + ']" id="prodpu_conigv[' + n + ']" value="' + pu_conigv + '" size="5" maxlength="10" class="cajaGeneral" onblur="modifica_pu_conigv(' + n + ');"></div></td>';
                fila += '<td width="6%"><div align="center"><input type="text" size="5" maxlength="10" class="cajaGeneral" name="prodpu[' + n + ']" id="prodpu[' + n + ']" value="' + pu + '" onblur="modifica_pu(' + n + ');" onkeypress="return numbersonly(this,event,\'.\');"></div></td>';

                fila += '<td width="6%"><input type="text" class="cajaGeneral cajaSoloLectura" size="5" maxlength="10" name="prodprecio[' + n + ']" id="prodprecio[' + n + ']" value="' + subtotal + '" readonly="readonly"></div></td>';
                fila += '<td width="6%" style="display:none;"><div align="center">';
                fila += '<input type="hidden" name="proddescuento100[' + n + ']" id="proddescuento100[' + n + ']" value="' + descuento100 + '">';
                fila += '<input type="hidden" size="5" maxlength="10" class="cajaGeneral" name="proddescuento[' + n + ']" id="proddescuento[' + n + ']" value="' + descuento + '" onblur="calcula_importe2(' + n + ');calcula_totales();">';

                fila += '</div></td>';
                fila += '<td width="6%"><div align="center"><input type="text" size="5" class="cajaGeneral cajaSoloLectura" name="prodigv[' + n + ']" value="' + igv + '" id="prodigv[' + n + ']" readonly></div></td>';
                fila += '<td width="6%"><div align="center">';
                fila += '<input type="hidden" name="detacodi[' + n + ']" id="detacodi[' + n + ']">';
                fila += '<input type="hidden" name="detaccion[' + n + ']" id="detaccion[' + n + ']" value="n">';
                fila += '<input type="hidden" name="prodigv100[' + n + ']" id="prodigv100[' + n + ']" value="' + igv100 + '">';
                fila += '<input type="hidden" class="cajaPequena2" name="prodcosto[' + n + ']" id="prodcosto[' + n + ']" value="' + costo + '" readonly="readonly">';
                fila += '<input type="hidden" class="cajaPequena2" name="prodventa[' + n + ']" id="prodventa[' + n + ']" value="0" readonly="readonly">';
                fila += '<input type="text" size="5" class="cajaGeneral cajaSoloLectura" name="prodimporte[' + n + ']" id="prodimporte[' + n + ']" value="' + total + '" readonly="readonly" value="0">';
                fila += '</div></td>';
                fila += '</tr>';
                $("#tblDetalleGuiaRem").append(fila);
            }

            /*  $('#ruc_cliente').val(ruc);
             $('#cliente').val(cliente);
             $('#nombre_cliente').val(razon_social);*/
            $('#moneda').val(moneda);

            n++;
        })
        if (n >= 0)
            calcula_totales();
        else
            alert('El presupuesto no tiene elementos.');
    });

}

//gcbq	
function agregar_todo_recu(guia) {
    descuento100 = $("#descuento").val();
    igv100 = $("#igv").val();
    url = base_url + "index.php/almacen/guiarem/obtener_detalle_guiarem/" + guia;
    n = document.getElementById('tblDetalleGuiaRem').rows.length;
    $.getJSON(url, function (data) {
        limpiar_datos();
        $.each(data, function (i, item) {
            cliente = item.CLIP_Codigo;
            ruc = item.Ruc;
            razon_social = item.RazonSocial;
            moneda = item.MONED_Codigo;
            formapago = item.FORPAP_Codigo;
            serie = item.GUIAREMC_Serie;
            numero = item.GUIAREMC_Numero;
            codigo_usuario = item.GUIAREMC_CodigoUsuario;
            punto_llegada = item.GUIAREMC_PuntoLlegada;

            nombre_conductor = item.GUIAREMC_NombreConductor;
            licencia = item.GUIAREMC_Licencia;
            certificado = item.GUIAREMC_Certificado;
            registro_mtc = item.GUIAREMC_RegistroMTC;
            placa = item.GUIAREMC_Placa;
            marca = item.GUIAREMC_Marca;
            empresa_transporte = item.EMPRP_Codigo;

            if (item.PRESDEP_Codigo != '') {

                j = n + 1
                producto = item.PROD_Codigo;
                codproducto = item.PROD_CodigoInterno;
                unidad_medida = item.UNDMED_Codigo;
                nombre_unidad = item.UNDMED_Descripcion;
                nombre_producto = item.PROD_Nombre;
                cantidad = item.GUIAREMDETC_Cantidad;
                pu = item.GUIAREMDETC_Pu;
                subtotal = item.GUIAREMDETC_Subtotal;
                descuento = item.GUIAREMDETC_Descuento;
                igv = item.GUIAREMDETC_Igv;
                total = item.GUIAREMDETC_Total;
                pu_conigv = item.GUIAREMDETC_Pu_ConIgv;
                subtotal_conigv = parseFloat(pu_conigv) * parseFloat(cantidad);

                descuento_conigv = '';

                if (j % 2 == 0) {
                    clase = "itemParTabla";
                } else {
                    clase = "itemImparTabla";
                }
                fila = '<tr class="' + clase + '">';
                fila += '<td width="3%"><div align="center"><font color="red"><strong><a href="javascript:;" onclick="eliminar_producto_ocompra(' + n + ');">';
                fila += '<span style="border:1px solid red;background: #ffffff;">&nbsp;X&nbsp;</span>';
                fila += '</a></strong></font></div></td>';
                fila += '<td width="4%"><div align="center">' + j + '</div></td>';
                fila += '<td width="10%"><div align="center">';
                fila += '<input type="hidden" class="cajaGeneral" name="prodcodigo[' + n + ']" id="prodcodigo[' + n + ']" value="' + producto + '">' + codproducto;
                fila += '<input type="hidden" class="cajaGeneral" name="produnidad[' + n + ']" id="produnidad[' + n + ']" value="' + unidad_medida + '">';
                fila += '<input type="hidden" class="cajaMinima" name="flagGenIndDet[' + n + ']" id="flagGenIndDet[' + n + ']" value="' + flagGenInd + '">';
                fila += '</div></td>';
                fila += '<td><div align="left"><input type="text" class="cajaGeneral" size="73" maxlength="250" name="proddescri[' + n + ']" id="proddescri[' + n + ']" value="' + nombre_producto + '" /></div></td>';
                fila += '<td width="10%"><div align="left"><input type="text" size="1" maxlength="5" class="cajaGeneral" name="prodcantidad[' + n + ']" id="prodcantidad[' + n + ']" value="' + cantidad + '" onblur="calcula_importe(' + n + ');calcula_totales();" onkeypress="return numbersonly(this,event,\'.\');">' + nombre_unidad;
                if (flagGenInd == "I") {
                    if (tipo_oper == 'V')
                        fila += ' <a href="javascript:;" onclick="ventana_producto_serie2(' + n + ')"><img src="' + base_url + 'images/flag-green_icon.png" width="20" height="20" border="0" align="absmiddle" /></a>';
                    else
                        fila += ' <a href="javascript:;" onclick="ventana_producto_serie(' + n + ')"><img src="' + base_url + 'images/flag-green_icon.png" width="20" height="20" border="0" align="absmiddle" /></a>';
                }
                fila += '</div></td>';
                fila += '<td width="6%"><div align="center"><input type="text" name="prodpu_conigv[' + n + ']" id="prodpu_conigv[' + n + ']" value="' + pu_conigv + '" size="5" maxlength="10" class="cajaGeneral" onblur="modifica_pu_conigv(' + n + ');"></div></td>';
                fila += '<td width="6%"><div align="center"><input type="text" size="5" maxlength="10" class="cajaGeneral" name="prodpu[' + n + ']" id="prodpu[' + n + ']" value="' + pu + '" onblur="modifica_pu(' + n + ');" onkeypress="return numbersonly(this,event,\'.\');"></div></td>';

                fila += '<td width="6%"><input type="text" class="cajaGeneral cajaSoloLectura" size="5" maxlength="10" name="prodprecio[' + n + ']" id="prodprecio[' + n + ']" value="' + subtotal + '" readonly="readonly"></div></td>';
                fila += '<td width="6%" style="display:none;"><div align="center">';
                fila += '<input type="hidden" name="proddescuento100[' + n + ']" id="proddescuento100[' + n + ']" value="' + descuento100 + '">';
                fila += '<input type="hidden" size="5" maxlength="10" class="cajaGeneral" name="proddescuento[' + n + ']" id="proddescuento[' + n + ']" value="' + descuento + '" onblur="calcula_importe2(' + n + ');calcula_totales();">';

                fila += '</div></td>';
                fila += '<td width="6%"><div align="center"><input type="text" size="5" class="cajaGeneral cajaSoloLectura" name="prodigv[' + n + ']" value="' + igv + '" id="prodigv[' + n + ']" readonly></div></td>';
                fila += '<td width="6%"><div align="center">';
                fila += '<input type="hidden" name="detacodi[' + n + ']" id="detacodi[' + n + ']">';
                fila += '<input type="hidden" name="detaccion[' + n + ']" id="detaccion[' + n + ']" value="n">';
                fila += '<input type="hidden" name="prodigv100[' + n + ']" id="prodigv100[' + n + ']" value="' + igv100 + '">';
                fila += '<input type="hidden" class="cajaPequena2" name="prodcosto[' + n + ']" id="prodcosto[' + n + ']" value="' + costo + '" readonly="readonly">';
                fila += '<input type="hidden" class="cajaPequena2" name="prodventa[' + n + ']" id="prodventa[' + n + ']" value="0" readonly="readonly">';
                fila += '<input type="text" size="5" class="cajaGeneral cajaSoloLectura" name="prodimporte[' + n + ']" id="prodimporte[' + n + ']" value="' + total + '" readonly="readonly" value="0">';
                fila += '</div></td>';
                fila += '</tr>';
                $("#tblDetalleGuiaRem").append(fila);
            }

            $('#ruc_cliente').val(ruc);
            $('#cliente').val(cliente);
            $('#nombre_cliente').val(razon_social);
            $('#forma_pago').val(formapago);
            $('#moneda').val(moneda);
            $('#punto_llegada').val(punto_llegada);
            $('#nombre_conductor').val(nombre_conductor);
            $('#licencia').val(licencia);
            $('#certificado').val(certificado);
            $('#registro_mtc').val(registro_mtc);
            $('#placa').val(placa);
            $('#marca').val(marca);
            $('#empresa_transporte').val(empresa_transporte);
            n++;
        })
        if (n >= 0) {
            if (tipo_docu != 'B' && tipo_docu != 'N')
                calcula_totales();
            else
                calcula_totales();

        }
        else {
            alert('El presupuesto no tiene elementos.');
        }
    });
}

function obtener_detalle_ocompra_origen(ocompra) {
    url = base_url + "index.php/compras/ocompra/obtener_detalle_ocompra2/" + ocompra;
    n = document.getElementById('tblDetalleGuiaRem').rows.length;
    $.getJSON(url, function (data) {
        limpiar_datos();
        $.each(data, function (i, item) {
            cliente = item.CLIP_Codigo;
            ruc = item.Ruc;
            razon_social = item.RazonSocial;
            moneda = item.MONED_Codigo;
            serie = item.OCOMC_Serie;
            numero = item.OCOMC_Numero;
            codigo_usuario = item.OCOMC_CodigoUsuario;

            //if(item.GUIAREMP_Codigo != ''){
            j = n + 1;
            producto = item.PROD_Codigo;
            codproducto = item.PROD_CodigoInterno; // 1
            unidad_medida = item.UNDMED_Codigo;
            nombre_unidad = item.UNDMED_Simbolo;
            nombre_producto = item.PROD_Nombre; // 2
            cantidad = item.OCOMDEC_Cantidad; // 3
            precio = item.OCOMDEC_Pu; // 5
            subtotal = item.OCOMDEC_Subtotal; // 6
            descuento = item.OCOMDEC_Descuento100;
            igv = item.OCOMDEC_Igv100;
            igv_general = item.OCOMDEC_Igv; // 7
            precio_conigv = item.OCOMDEC_Pu_ConIgv; // 4
            flagGenInd = item.OCOMDEC_GenInd;
            flagBS = item.PROD_FlagBienServicio;
            costo = item.OCOMDEC_Costo;
            costo_total = item.OCOMDEC_Total; // 8
            stock = '';

            if (j % 2 == 0) {
                clase = "itemParTabla";
            } else {
                clase = "itemImparTabla";
            }

            fila = '<tr class="' + clase + '">';
            fila += '<td width="3%"><div align="center"><font color="red"><strong><a href="#" onclick="eliminar_producto_ocompra(' + n + ');">';
            fila += '<span style="border:1px solid red;background: #ffffff;">&nbsp;X&nbsp;</span>';
            fila += '</a></strong></font></div></td>';
            fila += '<td width="4%"><div align="center">' + j + '</div></td>';
            fila += '<td width="10%"><div align="center">' + codproducto + '</div></td>';
            fila += '<td><div align="left"><input type="text" class="cajaGeneral" size="50" maxlength="250" name="proddescri[' + n + ']" id="proddescri[' + n + ']" value="' + nombre_producto + '" /></div></td>';
            fila += '<td width="10%"><div align="left">';
            fila += '<input type="text" size="1" maxlength="10" class="cajaGeneral" name="prodcantidad[' + n + ']" id="prodcantidad[' + n + ']" value="' + cantidad + '" onblur="calcula_importe(' + n + ');" onkeypress="return numbersonly(this,event,\'.\');">' + nombre_unidad;
            if (flagGenInd == "I") {
                if (tipo_oper == 'V')
                    fila += ' <a href="javascript:;" onclick="ventana_producto_serie2(' + n + ')"><img src="' + base_url + 'images/flag-green_icon.png" width="20" height="20" border="0" align="absmiddle" /></a>';
                else
                    fila += ' <a href="javascript:;" onclick="ventana_producto_serie(' + n + ')"><img src="' + base_url + 'images/flag-green_icon.png" width="20" height="20" border="0" align="absmiddle"/></a>';
            }
            fila += '</div></td>';
            fila += '<td width="6%"><div align="center"><input type="text" size="5" maxlength="10" class="cajaGeneral" value="' + precio_conigv + '" name="prodpu_conigv[' + n + ']" id="prodpu_conigv[' + n + ']" onblur="modifica_pu_conigv(' + n + ');" onkeypress="return numbersonly(this,event,\'.\');" /></div></td>';
            fila += '<td width="6%"><div align="center"><input type="text" size="5" maxlength="10" class="cajaGeneral" value="' + precio + '" name="prodpu[' + n + ']" id="prodpu[' + n + ']" onblur="modifica_pu(' + n + ');" onkeypress="return numbersonly(this,event,\'.\');" ></div></td>';
            fila += '<td width="6%"><div align="center"><input type="text" size="5" maxlength="10" class="cajaGeneral cajaSoloLectura" value="' + subtotal + '" name="prodprecio[' + n + ']" id="prodprecio[' + n + ']" readonly="readonly">';

            fila += '<td width="6%"><div align="center"><input type="text" size="5" class="cajaGeneral cajaSoloLectura" value="' + igv_general + '" name="prodigv[' + n + ']" id="prodigv[' + n + ']" readonly="readonly"></div></td>';
            fila += '<td width="6%" ><div align="center">';
            fila += '<input type="hidden" value="n" name="detaccion[' + n + ']" id="detaccion[' + n + ']">';
            fila += '<input type="hidden" name="prodigv100[' + n + ']" id="prodigv100[' + n + ']" value="' + igv + '">';
            fila += '<input type="hidden" value="" name="detacodi[' + n + ']" id="detacodi[' + n + ']">';
            fila += '<input type="hidden" name="proddescuento100[' + n + ']" id="proddescuento100[' + n + ']" value="' + descuento + '">';
            fila += '<input type="hidden" name="proddescuento[' + n + ']" class="proddescuento" id="proddescuento[' + n + ']" onblur="calcula_importe2(' + n + ');" />';
            //fila += '<input type="hidden" name="proddescuento_conigv[' + n + ']" id="proddescuento_conigv[' + n + ']" onblur="calcula_importe2_conigv(' + n + ');" />';
            fila += '<input type="hidden" name="flagBS[' + n + ']" id="flagBS[' + n + ']" value="' + flagBS + '"/>';
            fila += '<input type="hidden" name="prodcodigo[' + n + ']" id="prodcodigo[' + n + ']" value="' + producto + '"/>';
            fila += '<input type="hidden" name="produnidad[' + n + ']" id="produnidad[' + n + ']" value="' + unidad_medida + '"/>';
            fila += '<input type="hidden" name="flagGenIndDet[' + n + ']" id="flagGenIndDet[' + n + ']" value="' + flagGenInd + '"/>';
            fila += '<input type="hidden" name="prodstock[' + n + ']" id="prodstock[' + n + ']" value="' + stock + '"/>';
            fila += '<input type="hidden" name="prodcosto[' + n + ']" id="prodcosto[' + n + ']" value="' + costo + '"/>';
            fila += '<input type="text" size="5" class="cajaGeneral cajaSoloLectura" name="prodimporte[' + n + ']" id="prodimporte[' + n + ']" value="' + costo_total + '" readonly="readonly">';
            fila += '</div></td>';
            fila += '</tr>';
            $("#tblDetalleGuiaRem").append(fila);
            //}

            /*$('#ruc_cliente').val(ruc);
            $('#cliente').val(cliente);
            $('#nombre_cliente').val(razon_social);
            $('#moneda').val(moneda);*/

            calcula_importe(n);
        })
    });
}