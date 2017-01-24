<html>
<head>
    <title><?php echo TITULO; ?></title>
    <link href="<?php echo base_url(); ?>css/estilos.css" type="text/css" rel="stylesheet"/>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/funciones.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <script>
        var base_url;
        var flagBS;

        $(document).ready(function () {
            base_url = $("#base_url").val();

            $('#imgCancelarDocumento').click(function () {
                parent.$.fancybox.close();
            });

        });

        function ver_detalle_documento(documento) {
            url = base_url + "index.php/ventas/comprobante/obtener_detalle_comprobante/" + documento + "/<?php echo $tipo_oper; ?>/<?php echo $almacen; ?>";
            $("#tblDocumentoDetalle tr[class!='cabeceraTabla']").html('');
            $('#tblDocumentoDetalle').hide();
            $('img#loading,').show();
            $.getJSON(url, function (data) {
                $('#tblDocumentoDetalle').show();
                $('img#loading').hide();
                $.each(data, function (i, item) {
                    if (i % 2 == 0) {
                        clase = "itemParTabla";
                    } else {
                        clase = "itemImparTabla";
                    }

                    fila = '<tr class="' + clase + '">';
                    fila += '<td><div align="left">' + item.PROD_CodigoInterno + '</div></td>';
                    fila += '<td><div align="left">' + item.PROD_Nombre + '</div></td>';
                    fila += '<td><div align="right">' + item.CPDEC_Cantidad + ' ' + item.UNDMED_Simbolo + '</div></td>';
                    fila += '<td ><div align="right">' + item.CPDEC_Pu_ConIgv + '</div></td>';
                    fila += '<td><div align="right">' + item.CPDEC_Total + '</div></td>';
                    //fila+= '<td><div align="right">'+item.onclick+'</div></td>';
                    //fila += '<td><div align="center"><a href="javascript:;" onclick="seleccionar_documento_detalle(' + item.onclick + ')"><img src="' + base_url + 'images/ir.png" width="16" height="16" border="0" title="Seleccionar Detalle"></a></div></td>';
                    fila += '</tr>';
                    $("#tblDocumentoDetalle").append(fila);
                });
            });
        }

        function seleccionar_documento_detalle(producto, codproducto, nombre_producto, cantidad, flagBS, flagGenInd, unidad_medida, nombre_medida, precio_conigv, precio_sinigv, precio, igv, importe, stock, costo) {
            parent.seleccionar_documento_detalle(producto, codproducto, nombre_producto, cantidad, flagBS, flagGenInd, unidad_medida, nombre_medida, precio_conigv, precio_sinigv, precio, igv, importe, stock, costo);
            //parent.$.fancybox.close(); 
        }

        function ver_detalle_documentoPresupuesto(documento) {
            if ('<?php echo $tipo_oper; ?>' != 'C') {
                url = base_url + "index.php/ventas/presupuesto/obtener_detalle_presupuesto/v/<?php echo $tipo_oper; ?>/" + documento;
            } else {
                url = base_url + "index.php/ventas/presupuesto/obtener_detalle_presupuesto/c/<?php echo $tipo_oper; ?>/" + documento;
            }

            $("#tblDocumentoDetalle tr[class!='cabeceraTabla']").html('');
            $('#tblDocumentoDetalle').hide();
            $('img#loading,').show();
            $.getJSON(url, function (data) {
                $('#tblDocumentoDetalle').show();
                $('img#loading').hide();
                $.each(data, function (i, item) {
                    if (i % 2 == 0) {
                        clase = "itemParTabla";
                    } else {
                        clase = "itemImparTabla";
                    }

                    fila = '<tr class="' + clase + '">';
                    fila += '<td><div align="left">' + item.PROD_CodigoInterno + '</div></td>';
                    fila += '<td><div align="left">' + item.PROD_Nombre + '</div></td>';
                    fila += '<td><div align="right">' + item.PRESDEC_Cantidad + ' ' + item.UNDMED_Simbolo + '</div></td>';
                    fila += '<td ><div align="right">' + item.PRESDEC_Pu_ConIgv + '</div></td>';
                    fila += '<td><div align="right">' + item.PRESDEC_Total + '</div></td>';
                    //fila+= '<td><div align="right">'+item.onclick+'</div></td>';
                    fila += '<td><div align="center"><a href="javascript:;" onclick="seleccionar_documento_detalle(' + item.onclick + ')"><img src="' + base_url + 'images/ir.png" width="16" height="16" border="0" title="Seleccionar Detalle"></a></div></td>';
                    fila += '</tr>';
                    $("#tblDocumentoDetalle").append(fila);
                });
            });
        }

        function select_comprobante(guia, serie, numero, tipo) {
            parent.seleccionar_comprobante(guia, serie, numero, tipo);
            parent.$.fancybox.close();
        }

        function ver_detalle_ocompra(documento) {
            //alert(documento);
            url = base_url + "index.php/compras/ocompra/obtener_detalle_ocompra2/" + documento;
            $("#tblDocumentoDetalle tr[class!='cabeceraTabla']").html('');
            $('#tblDocumentoDetalle').hide();
            $('img#loading,').show();

            $.getJSON(url, function (data) {
                $('#tblDocumentoDetalle').show();
                $('img#loading').hide();
                $.each(data, function (i, item) {
                    if (i % 2 == 0) {
                        clase = "itemParTabla";
                    } else {
                        clase = "itemImparTabla";
                    }

                    fila = '<tr class="' + clase + '">';
                    fila += '<td><div align="left">' + item.PROD_CodigoInterno + '</div></td>';
                    fila += '<td><div align="left">' + item.PROD_Nombre + '</div></td>';
                    fila += '<td><div align="right">' + item.OCOMDEC_Cantidad + ' ' + item.UNDMED_Simbolo + '</div></td>';
                    fila += '<td ><div align="right">' + item.OCOMDEC_Pu_ConIgv + '</div></td>';
                    fila += '<td><div align="right">' + item.OCOMDEC_Total + '</div></td>';
                    //fila+= '<td><div align="right">'+item.onclick+'</div></td>';
                    fila += '<td><div align="center"><a href="javascript:;" onclick="seleccionar_documento_detalle(' + item.onclick + ')"><img src="' + base_url + 'images/ir.png" width="16" height="16" border="0" title="Seleccionar Detalle"></a></div></td>';
                    fila += '</tr>';
                    $("#tblDocumentoDetalle").append(fila);
                });
            });
        }


        function ver_detalle_documento_recu(documento) {
            //almacen = $("#almacen").val();
            url = base_url + "index.php/almacen/guiarem/obtener_detalle_guiarem/" + documento + "/<?php echo $tipo_oper; ?>/<?php echo $almacen; ?>";

            $("#tblDocumentoDetalle tr[class!='cabeceraTabla']").html('');
            $('#tblDocumentoDetalle').hide();
            $('img#loading,').show();
            $.getJSON(url, function (data) {
                $('#tblDocumentoDetalle').show();
                $('img#loading').hide();
                $.each(data, function (i, item) {
                    if (i % 2 == 0) {
                        clase = "itemParTabla";
                    } else {
                        clase = "itemImparTabla";
                    }

                    fila = '<tr class="' + clase + '">';
                    fila += '<td><div align="left">' + item.PROD_CodigoInterno + '</div></td>';
                    fila += '<td><div align="left">' + item.PROD_Nombre + '</div></td>';
                    fila += '<td><div align="right">' + item.GUIAREMDETC_Cantidad + '</div></td>';
                    fila += '<td ><div align="right">' + item.GUIAREMDETC_Pu_ConIgv + '</div></td>';
                    fila += '<td><div align="right">' + item.GUIAREMDETC_Total + '</div></td>';
                    //fila+= '<td><div align="right">'+item.onclick+'</div></td>';
                    fila += '<td><div align="center"><a href="javascript:;" onclick="seleccionar_documento_detalle(' + item.onclick + ')"><img src="' + base_url + 'images/ir.png" width="16" height="16" border="0" title="Seleccionar Detalle"></a></div></td>';
                    fila += '</tr>';
                    $("#tblDocumentoDetalle").append(fila);
                });
            });
        }

    </script>
</head>
<body>
<div align="center">
    <?php echo $form_open; ?>
    <div id="tituloForm" class="header" style="width:95%; padding-top: 0;">
        <ul class="lista_tipodoc">
            <li <?php if ($comprobante == 'F') {
                echo 'style="background-color: #FF0000;"';
            } ?> ><a
                    href="<?php echo base_url(); ?>index.php/ventas/notacredito/ventana_muestra_notadecredito/<?php echo $tipo_oper; ?>/<?php if ($tipo_oper == 'V') echo $cliente; else echo $proveedor; ?>/SELECT_HEADER/F/<?php echo $almacen; ?>/F">Factura</a>
            </li>
            <li <?php if ($comprobante == 'B') {
                echo 'style="background-color: #FF0000;"';
            } ?> ><a
                    href="<?php echo base_url(); ?>index.php/ventas/notacredito/ventana_muestra_notadecredito/<?php echo $tipo_oper; ?>/<?php if ($tipo_oper == 'V') echo $cliente; else echo $proveedor; ?>/SELECT_HEADER/B/<?php echo $almacen; ?>/B">Boleta</a>
            </li>
            <li <?php if ($comprobante == 'N') {
                echo 'style="background-color: #FF0000;"';
            } ?>  ><a
                    href="<?php echo base_url(); ?>index.php/ventas/notacredito/ventana_muestra_notadecredito/<?php echo $tipo_oper; ?>/<?php if ($tipo_oper == 'V') echo $cliente; else echo $proveedor; ?>/SELECT_HEADER/N/<?php echo $almacen; ?>/N">Comprobante</a>
            </li>
        </ul>
    </div>
    <div id="frmBusqueda" style="width:97%;">
        <table class="fuente8_2" width="100%" id="tabla_resultado" name="tabla_resultado" align="center" cellspacing="1"
               cellpadding="3" border="0">
            <tr>
                <?php if ($tipo_oper == 'V') { ?>
                    <td><span class="spanTitulo" >Cliente *</span></td>
                    <td valign="middle">
                        <input type="hidden" name="cliente" id="cliente" size="5" value="<?php echo $cliente ?>"/>
                        <input type="text" name="ruc_cliente" class="cajaGeneral" id="ruc_cliente" size="10"
                               maxlength="11" onblur="obtener_cliente();" readonly="readonly"
                               value="<?php echo $ruc_cliente; ?>" onkeypress="return numbersonly(this,event,'.');"/>
                        <input type="text" name="nombre_cliente" class="cajaGeneral cajaSoloLectura" id="nombre_cliente"
                               size="40" maxlength="50" readonly="readonly" value="<?php echo $nombre_cliente; ?>"/>
                        <!--<a href="<?php echo base_url(); ?>index.php/ventas/cliente/ventana_busqueda_cliente/" id="linkVerCliente"><img height='16' width='16' src='<?php echo base_url(); ?>/images/ver.png' title='Buscar' border='0' /></a>-->

                    </td>
                <?php } else { ?>
                    <td>Proveedor *</td>
                    <td valign="middle">
                        <input type="hidden" name="proveedor" id="proveedor" size="5" value="<?php echo $proveedor ?>"/>
                        <input type="text" name="ruc_proveedor" class="cajaGeneral" id="ruc_proveedor" size="10"
                               maxlength="11" onblur="obtener_proveedor();" value="<?php echo $ruc_proveedor; ?>"
                               onkeypress="return numbersonly(this,event,'.');" readonly="readonly"/>
                        <input type="text" name="nombre_proveedor" class="cajaGeneral cajaSoloLectura"
                               id="nombre_proveedor" size="40" maxlength="50" readonly="readonly"
                               value="<?php echo $nombre_proveedor; ?>"/>
                        <a style="display:none;"
                           href="<?php echo base_url(); ?>index.php/compras/proveedor/ventana_busqueda_proveedor/"
                           id="linkVerProveedor"><img height='16' width='16'
                                                      src='<?php echo base_url(); ?>/images/ver.png' title='Buscar'
                                                      border='0'/></a>
                    </td>
                    <td style="display:none;"><a href="javascript:;" id="imgBuscarDocumento"><img
                                src="<?php echo base_url(); ?>images/botonbuscar.jpg" class="imgBoton"/></a>
                        <a href="javascript:;" id="imgCancelarDocumento"><img
                                src="<?php echo base_url(); ?>images/botoncerrar.jpg" width="70" height="22"
                                class="imgBoton"></a>
                    </td>
                <?php } ?>
            </tr>
        </table>
    </div>
    <?php echo $form_hidden; ?>
    <?php echo $form_close; ?>
    <div id="frmResultado" style="width:98%; height: 250px; overflow: auto;">
        <table class="fuente8_2" width="100%" id="tblMovimientoSerie" align="center" cellspacing="1" cellpadding="3"
               border="0">
            <tr class="cabeceraTabla">
                <td colspan="8">
                    <?php
                    if ($comprobante == 'F') {
                        echo 'FACTURA';
                    }
                    if ($comprobante == 'B') {
                        echo 'BOLETA';
                    }
                    if ($comprobante == 'N') {
                        echo 'COMPROBANTE';
                    }
                    ?>
                </td>
            </tr>
            <tr class="cabeceraTabla">
                <td width="10%">FECHA</td>
                <td width="6%">SERIE</td>
                <td width="10%">NUMERO</td>
                <td width="12%">NUM DOC</td>
                <td><?php if ($tipo_oper == 'V') echo 'CLIENTE'; else echo 'PROVEEDOR'; ?></td>
                <td width="10%">TOTAL</td>
                <td width="5%">&nbsp;</td>
                <td width="5%">&nbsp;</td>
            </tr>
            <?php
            if (count($lista) > 0) {
                foreach ($lista as $indice => $valor) {
                    $class = $indice % 2 == 0 ? 'itemParTabla' : 'itemImparTabla';
                    ?>
                    <tr class="<?php echo $class;?>">
                        <td>
                            <div align="center"><?php echo $valor[0];?></div>
                        </td>
                        <td>
                            <div align="center"><?php echo $valor[1];?></div>
                        </td>
                        <td>
                            <div align="center"><?php echo $valor[2];?></div>
                        </td>
                        <td>
                            <div align="center"><?php echo $valor[3];?></div>
                        </td>
                        <td>
                            <div align="left"><?php echo $valor[4];?></div>
                        </td>
                        <td>
                            <div align="right"><?php echo $valor[5];?></div>
                        </td>
                        <td>
                            <div align="center"><?php echo $valor[6];?></div>
                        </td>
                        <td>
                            <div align="center"><?php echo $valor[7];?></div>
                        </td>
                    </tr>
                <?php
                }
            } else {
                ?>
                <tr>
                    <td width="100%" class="mensaje2" colspan="7">No hay ning&uacute;n registro que cumpla con los
                        criterios de b&uacute;squeda
                    </td>
                </tr>
            <?php
            }
            ?>
        </table>
    </div>
    <br/>

    <div id="frmResultado" style="width:98%; height: 150px; overflow: auto;">
        <img id="loading" src="<?php echo base_url(); ?>images/loading.gif" style="display:none"/>
        <table class="fuente8_2_3" width="100%" id="tblDocumentoDetalle" align="center" cellspacing="1" cellpadding="3"
               border="0" style="display:none">
            <tr class="cabeceraTabla">
                <td colspan="7">DETALLES DE LA FACTURA</td>
            </tr>
            <tr class="cabeceraTabla">
                <td width="10%">CODIGO</td>
                <td>DESCRIPCION</td>
                <td width="7%">CANT</td>
                <td width="9%">PU C/IGV</td>
                <td width="8%">IMPORTE</td>
                <!--<td width="4%">&nbsp;</td>-->
            </tr>
        </table>
    </div>
    <input type="hidden" name="almacen" id="almacen" value="<?php echo $almacen; ?>">
</body>
</html>
