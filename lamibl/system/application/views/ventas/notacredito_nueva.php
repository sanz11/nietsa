<?php
$nombre_persona = $this->session->userdata('nombre_persona');
$persona = $this->session->userdata('persona');
$usuario = $this->session->userdata('usuario');
$url = base_url() . "index.php";
if (empty($persona))
    header("location:$url");
?>
<html>
<head>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-ui-1.8.17.custom.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/funciones.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/ventas/notacredito.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>js/fancybox/jquery.fancybox-1.3.4.css"
          media="screen"/>
    <script type="text/javascript">
        $(document).ready(function () {
            almacen = $("#cboCompania").val();

            if ($('#tdc').val() == '') {
                alert("Antes de registrar Notas de Credito debe ingresar Tipo de Cambio")
                top.location = "<?php echo base_url(); ?>index.php/index/inicio";
            }

            $("a#linkSelecCliente, a#linkSelecProveedor, #linkSelecProducto").fancybox({
                'width': 800,
                'height': 500,
                'autoScale': false,
                'transitionIn': 'none',
                'transitionOut': 'none',
                'showCloseButton': true,
                'modal': false,
                'type': 'iframe'
            });
            $("#linkSelecProducto").fancybox({
                'width': 800,
                'height': 500,
                'autoScale': false,
                'transitionIn': 'none',
                'transitionOut': 'none',
                'showCloseButton': true,
                'modal': false,
                'type': 'iframe'
            });
            $("a#linkVerProducto").fancybox({
                'width': 800,
                'height': 650,
                'autoScale': false,
                'transitionIn': 'none',
                'transitionOut': 'none',
                'showCloseButton': true,
                'modal': false,
                'type': 'iframe'
            });
            $("#linkVerImpresion").fancybox({
                'transitionIn': 'none',
                'transitionOut': 'none',
                'showCloseButton': true,
                'modal': true
            });

            $("a#verOrden").fancybox({
                'width': 780,
                'height': 450,
                'autoScale': false,
                'transitionIn': 'none',
                'transitionOut': 'none',
                'showCloseButton': true,
                'modal': false,
                'type': 'iframe'
            });

            $(".verDocuRefe").fancybox({
                'width': 770,
                'height': 520,
                'autoScale': false,
                'transitionIn': 'none',
                'transitionOut': 'none',
                'showCloseButton': true,
                'modal': false,
                'type': 'iframe',
                'onStart': function () {
                    if (tipo_oper == 'V') {
                        if ($('#cliente').val() == '') {
                            alert('Debe seleccionar el cliente.');
                            $('#ruc_cliente').focus();
                            return false;
                        } else {
                            if ($('.verDocuRefe::checked').val() == 'F') {
                                baseurl = base_url + 'index.php/ventas/notacredito/ventana_muestra_notadecredito/' + tipo_oper + '/' + $('#cliente').val() + '/SELECT_HEADER/F/' + almacen + '/F';
                            }
                            $('.verDocuRefe::checked').attr('href', baseurl);
                        }
                    }
                    else {
                        if ($('#proveedor').val() == '') {
                            alert('Debe seleccionar el proveedor.');
                            $('#ruc_proveedor').focus();
                            return false;
                        } else

                        if ($('.verDocuRefe::checked').val() == 'F')
                            baseurl = base_url + 'index.php/ventas/notacredito/ventana_muestra_notadecredito/' + tipo_oper + '/' + $('#proveedor').val() + '/SELECT_HEADER/F/' + almacen + '/NC';

                        $('.verDocuRefe').attr('href', baseurl);
                    }
                }
            });


            $("#buscar_producto").autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: "<?php echo base_url(); ?>index.php/almacen/producto/autocomplete/" + $("#flagBS").val() + "/" + $("#compania").val(),
                        type: "POST",
                        data: {
                            term: $("#buscar_producto").val()
                        },
                        dataType: "json",
                        success: function (data) {
                            response(data);
                        }
                    });
                },
                select: function (event, ui) {
                    $("#buscar_producto").val(ui.item.codinterno);
                    $("#producto").val(ui.item.codigo)
                    $("#codproducto").val(ui.item.codinterno);
                    $("#costo").val(ui.item.pcosto);
                    $("#cantidad").focus();
                    listar_unidad_medida_producto(ui.item.codigo);
                    // obtener_producto_desde_codigo(n);
                    // return false;
                },
                minLength: 3
            });

            $("#nombre_cliente").autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: "<?php echo base_url(); ?>index.php/ventas/cliente/autocomplete/",
                        type: "POST",
                        data: {
                            term: $("#nombre_cliente").val()
                        },
                        dataType: "json",
                        success: function (data) {
                            response(data);

                        }

                    });

                },

                select: function (event, ui) {

                    //$("#nombre_cliente").val(ui.item.codinterno);
                    $("#buscar_cliente").val(ui.item.ruc)
                    $("#cliente").val(ui.item.codigo);
                    $("#ruc_cliente").val(ui.item.ruc);
                    $("#buscar_producto").focus();
                },

                minLength: 3

            });

            //****** nuevo para ruc
            $("#ruc_cliente").autocomplete({
                //flag = $("#flagBS").val();
                source: function (request, response) {
                    $.ajax({
                        url: "<?php echo base_url(); ?>index.php/ventas/cliente/autocomplete_ruc/",
                        type: "POST",
                        data: {
                            term: $("#ruc_cliente").val()
                        },
                        dataType: "json",
                        success: function (data) {
                            response(data);
                        }
                    });
                },
                select: function (event, ui) {
                    //$("#nombre_cliente").val(ui.item.codinterno);
                    $("#nombre_cliente").val(ui.item.nombre);
                    $("#cliente").val(ui.item.codigo);
                    $("#ruc_cliente").val(ui.item.ruc);
                    $("#buscar_producto").focus();
                },
                minLength: 4
            });

            $("#nombre_proveedor").autocomplete({
                //flag = $("#flagBS").val();
                source: function (request, response) {
                    $.ajax({
                        url: "<?php echo base_url(); ?>index.php/compras/proveedor/autocomplete/",
                        type: "POST",
                        data: {
                            term: $("#nombre_proveedor").val()
                        },
                        dataType: "json",
                        success: function (data) {
                            response(data);
                        }
                    });
                },
                select: function (event, ui) {
                    //$("#nombre_proveedor").val(ui.item.codinterno);
                    $("#buscar_proveedor").val(ui.item.ruc)
                    $("#proveedor").val(ui.item.codigo);
                    $("#ruc_proveedor").val(ui.item.ruc);
                    $("#buscar_producto").focus();
                },
                minLength: 3
            });

            //****** nuevo para ruc PROVEEDOR
            $("#ruc_proveedor").autocomplete({
                //flag = $("#flagBS").val();
                source: function (request, response) {
                    $.ajax({
                        url: "<?php echo base_url(); ?>index.php/compras/proveedor/autocomplete_ruc/",
                        type: "POST",
                        data: {
                            term: $("#ruc_proveedor").val()
                        },
                        dataType: "json",
                        success: function (data) {
                            response(data);
                        }
                    });
                },
                select: function (event, ui) {
                    //$("#nombre_cliente").val(ui.item.codinterno);
                    $("#nombre_proveedor").val(ui.item.nombre);
                    $("#proveedor").val(ui.item.codigo);
                    $("#ruc_proveedor").val(ui.item.ruc);
                    $("#buscar_producto").focus();
                },
                minLength: 4
            });

        });

        function seleccionar_cliente(codigo, ruc, razon_social) {
            $("#cliente").val(codigo);
            $("#ruc_cliente").val(ruc);
            $("#nombre_cliente").val(razon_social);
            $("#buscar_producto").focus();
        }
        function seleccionar_proveedor(codigo, ruc, razon_social) {
            $("#proveedor").val(codigo);
            $("#ruc_proveedor").val(ruc);
            $("#nombre_proveedor").val(razon_social);
            $("#buscar_producto").focus();
        }
        function seleccionar_producto(producto, cod_interno, familia, stock, costo, flagGenInd) {
            $("#codproducto").val(cod_interno);
            $("#producto").val(producto);
            $("#cantidad").focus();
            $("#costo").val(costo);
            $("#flagGenInd").val(flagGenInd);

            listar_unidad_medida_producto(producto);

        }
        function seleccionar_notadecredito_recu(guia, serieguia, numeroguia) {
            agregar_todonotadecredito(guia);
            serienumero = "Numero de Recurrente :" + serieguia + " - " + numeroguia;
            $("#serieguiaverNC").html(serienumero);
            $("#serieguiaverNC").show(2000);
        }
    </script>
</head>
<body>
<?php
// stylo para ocultar botones combos, etc
$style = "";
if (FORMATO_IMPRESION == 8) {
    $style = "display:none;";
}
?>
<!-- Inicio -->
<div id="VentanaTransparente" style="display:none;">
    <div class="overlay_absolute"></div>
    <div id="cargador" style="z-index:2000">
        <table width="100%" height="100%" border="0" class="fuente8">
            <tr valign="middle">
                <td> Por Favor Espere</td>
                <td><img src="<?php echo base_url(); ?>images/cargando.gif" border="0" title="CARGANDO"/><a href="#"
                                                                                                            id="hider2"></a>
                </td>
            </tr>
        </table>
    </div>
</div>
<!-- Fin -->
<input name="compania" type="hidden" id="compania" value="<?php echo $compania; ?>">

<form id="<?php echo $formulario; ?>" method="post" action="<?php echo $url_action; ?>">
    <div id="zonaContenido" align="center">
        <?php echo validation_errors("<div class='error'>", '</div>'); ?>
        <div id="tituloForm" class="header"><?php echo $titulo; ?></div>
        <div id="frmBusqueda">
            <table class="fuente8" width="100%" cellspacing="0" cellpadding="5" border="0">
                <tr>
                    <td width="10%">N&uacute;mero *</td>
                    <td width="38%" valign="middle">
                        <?php if ($tipo_oper == 'V') { ?>
                        <input class="cajaPequena2 cajaSoloLectura" name="serie" type="text" id="serie" size="10" maxlength="3" placeholder="Serie"
                               value="<?php echo trim($serie); ?>"/>&nbsp;
                        <input class="cajaGeneral cajaSoloLectura" name="numero" type="text" id="numero" size="10" maxlength="6" placeholder="Numero"
                               value="<?php echo trim($numero); ?>"/>
                        <?php }else{ ?>
                            <input class="cajaPequena2" name="serie" type="text" id="serie" size="10" maxlength="3" placeholder="Serie"
                                   value="<?php echo trim($serie); ?>"/>&nbsp;
                            <input class="cajaGeneral" name="numero" type="text" id="numero" size="10" maxlength="6" placeholder="Numero"
                                   value="<?php echo trim($numero); ?>"/>
                        <?php } ?>
                        <?php if ($tipo_oper == 'V') { ?>
                            <a href="javascript:;"
                               id="linkVerSerieNum" <?php if ($codigo != '') echo 'style="display:none"' ?>>
                                <p class="boleta"
                                   style="display:none"><?php echo $serie_suger_b . '-' . '00' . $numero_suger_b ?>
                                </p>

                                <p class="factura"
                                   style="display:none"><?php echo $serie_suger_f . '-' . '00' . $numero_suger_f ?>
                                </p>
                                <!--<p style="display:none"><?php echo $serie_suger . '-' . $numero_suger ?></p>-->

                                <img src="<?php echo base_url(); ?>images/flecha.png" border="0"
                                     alt="Serie y número sugerido" title="Serie y número sugerido"/>
                            </a>
                        <?php } ?>
                    </td>
                    <td width="17%" valign="middle">
                        <label style="margin-left:10px; margin-right: 20px;">IGV</label>
                        <input NAME="igv" type="text" class="cajaGeneral cajaSoloLectura" id="igv" size="2"
                               maxlength="2" value="<?php echo $igv; ?>"
                               onKeyPress="return numbersonly(this,event,'.');" onBlur="modifica_igv_total();"
                               readonly="readonly"/> %
                        <input type="hidden" name="descuento" id="descuento" value=""/>
                        <!--Presupuesto-->
                    </td>
                    <td width="23%" valign="middle">
                        <label style="margin-left:40px; margin-right: 20px;">TDC</label> <input NAME="tdc" type="text"
                                                                                                class="cajaGeneral cajaSoloLectura"
                                                                                                id="tdc" size="3"
                                                                                                value="<?php echo $tdc; ?>"
                                                                                                onKeyPress="return numbersonly(this,event,'.');"
                                                                                                readonly="readonly"/>
                        <!--<select name="presupuesto" id="presupuesto" class="comboMedio"  onfocus="<?php echo $focus; ?>" onChange="obtener_detalle_presupuesto()" ><?php echo $cboPresupuesto; ?></select>-->
                    </td>
                    <td width="7%" valign="middle">Fecha</td>
                    <td width="22%" valign="middle"><input NAME="fecha" type="text" class="cajaGeneral cajaSoloLectura"
                                                           id="fecha" value="<?php echo $hoy; ?>" size="10"
                                                           maxlength="10" readonly="readonly"/>
                        <img height="16" border="0" width="16" id="Calendario1" name="Calendario1"
                             src="<?php echo base_url(); ?>images/calendario.png"/>
                        <script type="text/javascript">
                            Calendar.setup({
                                inputField: "fecha",      // id del campo de texto
                                ifFormat: "%d/%m/%Y",       // formaClienteto de la fecha, cuando se escriba en el campo de texto
                                button: "Calendario1"   // el id del botón que lanzará el calendario
                            });
                        </script>
                    </td>
                </tr>
                <tr>
                    <?php if ($tipo_oper == 'V') { ?>
                        <td>Cliente *</td>
                        <td valign="middle">
                            <input type="hidden" name="cliente" id="cliente" size="5" value="<?php echo $cliente ?>"/>
                            <input type="text" name="ruc_cliente" class="cajaGeneral" id="ruc_cliente" size="10"
                                   maxlength="11" onBlur="obtener_cliente();" value="<?php echo $ruc_cliente; ?>" placeholder="RUC"
                                   onKeyPress="return numbersonly(this,event,'.');"/>
                            <input type="text" name="nombre_cliente" class="cajaGeneral " id="nombre_cliente" size="40" placeholder="Razon social"
                                   maxlength="50" value="<?php echo $nombre_cliente; ?>"/>
                            <a href="<?php echo base_url(); ?>index.php/ventas/cliente/ventana_selecciona_cliente/"
                               id="linkSelecCliente"></a>
                        </td>
                    <?php } else { ?>
                        <td>Proveedor *</td>
                        <td valign="middle">
                            <input type="hidden" name="proveedor" id="proveedor" size="5"
                                   value="<?php echo $proveedor ?>"/>
                            <input type="text" name="ruc_proveedor" class="cajaGeneral" id="ruc_proveedor" size="10"
                                   maxlength="11" onBlur="obtener_proveedor();" value="<?php echo $ruc_proveedor; ?>" placeholder="RUC"
                                   onKeyPress="return numbersonly(this,event,'.');"/>
                            <input type="text" name="nombre_proveedor" class="cajaGeneral " id="nombre_proveedor" placeholder="Razon Social"
                                   size="35" maxlength="50" value="<?php echo $nombre_proveedor; ?>"/>
                            <a href="<?php echo base_url(); ?>index.php/compras/proveedor/ventana_selecciona_proveedor/"
                               id="linkSelecProveedor"></a>

                        </td>
                    <?php } ?>
                    <td valign="middle">
                    </td>
                    <td valign="middle">
                    </td>
                    <td>
                        <?php if ($tipo_oper == 'C') { ?>
                            <!--<a href="<?php echo base_url() ?>index.php/compras/ocompra/ventana_muestra_proveedor/<?php echo $tipo_oper; ?>"
                               id="verOrden"><img src="<?php echo base_url() ?>images/referenciardoc.png"
                                                  class="imgBoton"/></a>-->
                        <?php } ?>
                    </td>
                    <td valign="middle" style="position: relative" >
                            <label for="F" style="cursor: pointer" >
                                <img src="<?php echo base_url() ?>images/docpago.png" class="imgBoton"/>
                            </label>
                            <input type="radio" name="referenciar" id="F" value="F" href="javascript:;"
                                   class="verDocuRefe"
                                   style="display:none;">
                        <input type="hidden" id="origenDocumento" value="0" name="origenDocumento" />
                        <input type="hidden" id="guiaReferente" value="" name="guiaReferente" />
                            <input type="hidden" id="dRef" name="dRef">
                        <input type="hidden" name="idSerie" id="idSerie" value="" />
                        <input type="hidden" name="idNumero" id="idNumero" value="" />
                            <span id="serieguiaverFlecha" class="flecha_izquierda2" ></span>
                            <div id="serieguiaver" class="serieguiaverRecu" >
                            </div>
                    </td>
                </tr>
                <tr>
                    <td>Moneda *</td>
                    <td>
                        <select name="moneda" id="moneda" class="comboPequeno"
                                style="width:150px;"><?php echo $cboMoneda; ?></select>
                    </td>
                    <td></td>
                    <td>

                    </td>
                    <td colspan="2" align="right" >
                        <?php echo $cboAlmacen; ?>
                    </td>
                </tr>
            </table>
        </div>
        <div id="frmBusqueda"  <?php echo $hidden; ?>>
            <table class="fuente8" width="100%" cellspacing='0' cellpadding='3' border='0'>
                <tr>
                    <td width="8%">
                        <select name="flagBS" id="flagBS" style="width:68px;" class="comboMedio"
                                onChange="limpiar_campos_producto()">
                            <option value="B" selected="selected" title="Producto">P</option>
                            <option value="S" title="Servicio">S</option>
                        </select>
                    </td>
                    <td width="37%">
                        <input name="producto" type="hidden" class="cajaGeneral" id="producto"/>
                        <input name="buscar_producto" type="text" class="cajaGeneral" id="buscar_producto" size="10" placeholder="Producto"
                               title="Ingrese parte del nombre o el nro. de serie del producto, luego presione ENTER."/>&nbsp;
                        <input name="codproducto" type="hidden" class="cajaGeneral" id="codproducto" size="10"
                               maxlength="20" onBlur="obtener_producto();"/>
                        <input NAME="nombre_producto" type="text" class="cajaGeneral cajaSoloLectura" placeholder="Descripcion producto"
                               id="nombre_producto" size="39" readonly="readonly"/>
                        <input name="costo" type="hidden" id="costo"/>
                        <input name="flagGenInd" type="hidden" id="flagGenInd"/>
                        <!--<a href="<?php echo base_url(); ?>index.php/almacen/producto/ventana_busqueda_producto/" id="linkVerProducto"><img height='16' width='16' src='<?php echo base_url(); ?>/images/ver.png' title='Buscar' border='0' /></a>-->
                        <a href="<?php echo base_url(); ?>index.php/almacen/producto/ventana_selecciona_producto/"
                           id="linkSelecProducto"></a>

                    </td>
                    <td width="6%">Cantidad</td>
                    <td width="24%">
                        <input NAME="cantidad" type="text" class="cajaGeneral" id="cantidad" size="3" maxlength="10"
                               onKeyPress="return numbersonly(this,event,'.');"/>
                        <select name="unidad_medida" id="unidad_medida"
                                class="comboMedio" <?php if ($tipo_oper == 'V') echo 'onchange="listar_precios_x_producto_unidad();"'; ?>>
                            <option value="0">::Seleccione::</option>
                        </select>
                    </td>
                    <td width="16%">
                        <select name="precioProducto" id="precioProducto" class="comboPequeno"
                                onChange="mostrar_precio();" style="width:84px;">
                            <option value="0">::Seleccion::</option>
                        </select>
                        <input NAME="precio" type="text" class="cajaGeneral" id="precio" size="5" maxlength="10"
                               onKeyPress="return numbersonly(this,event,'.');"
                               title="<?php if ($tipo_docu != 'B' && $contiene_igv == true) echo 'Precio con IGV'; ?>"/>
                    </td>
                    <td width="10%">
                        <div align="right"><a href="javascript:;" onClick="agregar_producto_comprobante();"><img
                                    src="<?php echo base_url(); ?>images/botonagregar.jpg" border="1" align="absbottom"></a>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div id="frmBusqueda" style="height:250px; overflow: auto">
            <table class="fuente8" width="100%" cellspacing="0" cellpadding="3" border="1" ID="Table1">
                <tr class="cabeceraTabla">
                    <td width="3%">
                        <div align="center">&nbsp;</div>
                    </td>
                    <td width="4%">
                        <div align="center">ITEM</div>
                    </td>
                    <td width="10%">
                        <div align="center">C&Oacute;DIGO</div>
                    </td>
                    <td>
                        <div align="center">DESCRIPCI&Oacute;N</div>
                    </td>
                    <td width="10%">
                        <div align="center">CANTIDAD</div>
                    </td>
                    <td width="6%">
                        <div align="center">PU C/IGV</div>
                    </td>
                    <td width="6%">
                        <div align="center">PU S/IGV</div>
                    </td>
                    <td width="6%">
                        <div align="center">PRECIO</div>
                    </td>

                </tr>
            </table>
            <div>
                <table id="tblDetalleComprobante" class="fuente8" width="100%" border="0">
                    <?php
                    if (count($detalle_comprobante) > 0) {
                        foreach ($detalle_comprobante as $indice => $valor) {
                            $detacodi = $valor->CREDET_Codigo;
                            $flagBS = $valor->flagBS;
                            $prodproducto = $valor->PROD_Codigo;
                            $unidad_medida = $valor->UNDMED_Codigo;
                            $codigo_interno = $valor->PROD_CodigoInterno;
                            $nombre_producto = $valor->PROD_Nombre;
                            $nombre_unidad = $valor->UNDMED_Simbolo;
                            $costo = $valor->CREDET_Costo;
                            $GenInd = $valor->CREDET_GenInd;
                            $prodcantidad = $valor->CREDET_Cantidad;
                            $prodpu = $valor->CREDET_Pu;
                            $prodsubtotal = $valor->CREDET_Subtotal;
                            $proddescuento = $valor->CREDET_Descuento;
                            $prodigv = $valor->CREDET_Igv;
                            $prodtotal = $valor->CREDET_Total;
                            $prodpu_conigv = $valor->CREDET_Pu_ConIgv;
                            $prodsubtotal_conigv = $valor->CREDET_Subtotal_ConIgv;
                            $proddescuento_conigv = $valor->CREDET_Descuento_ConIgv;
                            if (($indice + 1) % 2 == 0) {
                                $clase = "itemParTabla";
                            } else {
                                $clase = "itemImparTabla";
                            }
                            ?>
                            <tr class="<?php echo $clase; ?>">
                                <td width="3%">
                                    <div align="center"><font color="red"><strong><a href="javascript:;"
                                                                                     onClick="eliminar_producto_comprobante(<?php echo $indice; ?>);"><span
                                                        style="border:1px solid red;background: #ffffff;">&nbsp;X&nbsp;</span></a></strong></font>
                                    </div>
                                </td>
                                <td width="4%">
                                    <div align="center"><?php echo $indice + 1; ?></div>
                                </td>
                                <td width="10%">
                                    <div align="center"><?php echo $codigo_interno; ?></div>
                                </td>
                                <td>
                                    <div align="left"><input type="text" class="cajaGeneral" style="width:395px;"
                                                             maxlength="250" name="proddescri[<?php echo $indice; ?>]"
                                                             id="proddescri[<?php echo $indice; ?>]"
                                                             value="<?php echo $nombre_producto; ?>"/></div>
                                </td>

                                <td width="10%">
                                    <div align="left"><input type="text" size="1" maxlength="5" class="cajaGeneral"
                                                             name="prodcantidad[<?php echo $indice; ?>]"
                                                             id="prodcantidad[<?php echo $indice; ?>]"
                                                             value="<?php echo $prodcantidad; ?>"
                                                             onBlur="calcula_importe(<?php echo $indice; ?>);"
                                                             onKeyPress="return numbersonly(this,event,'.');"/><?php echo $nombre_unidad; ?>

                                    </div>
                                </td>
                                <td width="6%">
                                    <div align="center"><input type="text" size="5" maxlength="10" class="cajaGeneral"
                                                               name="prodpu_conigv[<?php echo $indice; ?>]"
                                                               id="prodpu_conigv[<?php echo $indice; ?>]"
                                                               value="<?php echo $prodpu_conigv; ?>"
                                                               onBlur="modifica_pu_conigv(<?php echo $indice; ?>);"
                                                               onKeyPress="return numbersonly(this,event,'.');"/></div>
                                </td>
                                <td width="6%">
                                    <div align="center"><input type="text" size="5" maxlength="10" class="cajaGeneral"
                                                               name="prodpu[<?php echo $indice; ?>]"
                                                               id="prodpu[<?php echo $indice; ?>]"
                                                               value="<?php echo $prodpu; ?>"
                                                               onBlur="modifica_pu(<?php echo $indice; ?>);"
                                                               onKeyPress="return numbersonly(this,event,'.');"/>
                                        <td width="6%">
                                            <div align="center"><input type="text" size="5" maxlength="10"
                                                                       class="cajaGeneral cajaSoloLectura"
                                                                       name="prodprecio[<?php echo $indice; ?>]"
                                                                       id="prodprecio[<?php echo $indice; ?>]"
                                                                       value="<?php echo $prodsubtotal; ?>"
                                                                       readonly="readonly"/></div>


                                        <td width="6%" style="display:none;">
                                            <div align="center">
                                                <input type="text" size="5" class="cajaGeneral cajaSoloLectura"
                                                       name="prodigv[<?php echo $indice; ?>]"
                                                       id="prodigv[<?php echo $indice; ?>]" readonly="readonly"
                                                       value="<?php echo $prodigv; ?>"/>
                                            </div>
                                        </td>
                                        <td width="6%" style="display:none;">
                                            <div align="center">
                                                <input type="hidden" name="detaccion[<?php echo $indice; ?>]"
                                                       id="detaccion[<?php echo $indice; ?>]" value="m"/>
                                                <input type="hidden" name="prodigv100[<?php echo $indice; ?>]"
                                                       id="prodigv100[<?php echo $indice; ?>]"
                                                       value="<?php echo $igv; ?>"/>
                                                <input type="hidden" name="detacodi[<?php echo $indice; ?>]"
                                                       id="detacodi[<?php echo $indice; ?>]"
                                                       value="<?php echo $detacodi; ?>"/>
                                                <input type="hidden" name="flagBS[<?php echo $indice; ?>]"
                                                       id="flagBS[<?php echo $indice; ?>]"
                                                       value="<?php echo $flagBS; ?>"/>
                                                <input type="hidden" name="prodcodigo[<?php echo $indice; ?>]"
                                                       id="prodcodigo[<?php echo $indice; ?>]"
                                                       value="<?php echo $prodproducto; ?>"/>
                                                <input type="hidden" name="produnidad[<?php echo $indice; ?>]"
                                                       id="produnidad[<?php echo $indice; ?>]"
                                                       value="<?php echo $unidad_medida; ?>"/>
                                                <input type="hidden" name="flagGenIndDet[<?php echo $indice; ?>]"
                                                       id="flagGenIndDet[<?php echo $indice; ?>]"
                                                       value="<?php echo $GenInd; ?>"/>
                                                <input type="hidden" name="prodcosto[<?php echo $indice; ?>]"
                                                       id="prodcosto[<?php echo $indice; ?>]"
                                                       value="<?php echo $costo; ?>"/>
                                                <input type="hidden" name="proddescuento100[<?php echo $indice; ?>]"
                                                       id="proddescuento100[<?php echo $indice; ?>]"
                                                       value="<?php echo $descuento; ?>"/>

                                                <input type="hidden" size="1"
                                                       name="proddescuento[<?php echo $indice; ?>]"
                                                       id="proddescuento[<?php echo $indice; ?>]"
                                                       value="<?php echo $proddescuento; ?>"
                                                       onBlur="calcula_importe2(<?php echo $indice; ?>);"/>

                                                <input type="hidden" size="5" class="cajaGeneral cajaSoloLectura"
                                                       name="prodimporte[<?php echo $indice; ?>]"
                                                       id="prodimporte[<?php echo $indice; ?>]" readonly="readonly"
                                                       value="<?php echo $prodtotal; ?>"/>
                                            </div>
                                        </td>
                            </tr>
                        <?php
                        }
                    }
                    ?>
                </table>
            </div>
        </div>
        <div id="frmBusqueda3_2">
            <table width="100%" border="0" cellpadding='3' cellspacing='0' class="fuente8_2">
                <tr>
                    <td width="80%" rowspan="4" align="left">
                        <table width="100%" border="0" align="right" cellpadding='3' cellspacing='0' class="fuente8">
                                <!--<td width="14%" height="30">Modo de impresión</td>
                                <td width="50%"><select
                                        name="modo_impresion" <?php if ($tipo_docu == 'B') echo 'disabled="disabled"'; ?>
                                        id="modo_impresion" class="comboGrande" style="width:307px">
                                        <option <?php if ($modo_impresion == '1') echo 'selected="selected"'; ?>
                                            value="1">LOS PRECIOS DE LOS PRODUCTOS DEBEN INCLUIR IGV
                                        </option>
                                        <option <?php if ($modo_impresion == '2') echo 'selected="selected"'; ?>
                                            value="2">LOS PRECIOS DE LOS PRODUCTOS NO DEBEN INCLUIR IGV
                                        </option>
                                    </select>
                                </td>
                                <td width="7%">Estado</td>
                                <td><select name="estado" id="estado" class="comboPequeno">
                                        <option <?php if ($estado == '1') echo 'selected="selected"'; ?> value="1">
                                            Activo
                                        </option>
                                        <option <?php if ($estado == '0') echo 'selected="selected"'; ?> value="0">
                                            Anulado
                                        </option>
                                    </select></td>-->
                            <tr>
                                <td>
                                    <p style="font-weight: bold;" >Observación*</p>
                                    <textarea id="observacion" name="observacion" class="cajaTextArea"
                                              style="width:97%; height:70px;">..<?php echo $observacion; ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div id="notaMensaje" style="color: red; font-weight: bolder" >

                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td width="10%" class="busqueda">Sub-total</td>
                    <td width="10%" align="right">
                        <div align="right"><input class="cajaTotales" name="preciototal" type="text" id="preciototal"
                                                  size="12"
                                                  align="right" <?php if ($tipo_oper == 'V') echo 'readonly="readonly"'; ?>
                                                  value="<?php echo round($preciototal, 2); ?>"></div>
                    </td>

                </tr>
                <tr>
                    <td class="busqueda">Descuento</td>
                    <td align="right">
                        <div align="right"><input class="cajaTotales" name="descuentotal" type="text" id="descuentotal"
                                                  size="12"
                                                  align="right" <?php if ($tipo_oper == 'V') echo 'readonly="readonly"'; ?>
                                                  value="<?php echo round($descuentotal, 2); ?>"></div>
                    </td>

                </tr>

                <tr>
                    <td class="busqueda">IGV</td>
                    <td align="right">
                        <div align="right"><input class="cajaTotales" name="igvtotal" type="text" id="igvtotal"
                                                  size="12"
                                                  align="right" <?php if ($tipo_oper == 'V') echo 'readonly="readonly"'; ?>
                                                  value="<?php echo round($igvtotal, 2); ?>"/></div>
                    </td>
                    <td>
                    </td>
                </tr>

                <tr>
                    <td class="busqueda">Precio Total</td>
                    <td align="right">
                        <div align="right"><input class="cajaTotales" name="importetotal" type="text" id="importetotal"
                                                  size="12"
                                                  align="right" <?php if ($tipo_oper == 'V') echo 'readonly="readonly"'; ?>
                                                  value="<?php echo round($importetotal, 2); ?>"/></div>
                    </td>
                </tr>
            </table>

        </div>
        <br/>

        <div id="botonBusqueda2" style="padding-top:20px; padding-bottom: 10px">
            <img id="loading" src="<?php echo base_url(); ?>images/loading.gif" style="visibility: hidden"/>
            <a href="javascript:;" id="grabarComprobante"><img src="<?php echo base_url(); ?>images/botonaceptar.jpg"
                                                               width="85" height="22" class="imgBoton"></a>
            <a href="javascript:;" id="limpiarComprobante"><img src="<?php echo base_url(); ?>images/botonlimpiar.jpg"
                                                                width="69" height="22" class="imgBoton"></a>
            <a href="javascript:;" id="cancelarComprobante"><img src="<?php echo base_url(); ?>images/botoncancelar.jpg"
                                                                 width="85" height="22" class="imgBoton"></a>
            <?php echo $oculto ?>
        </div>

    </div>
</form>
<a id="linkVerImpresion" href="#ventana"></a>

<div id="ventana" style="display:none">
    <div id="imprimir" style="padding:20px; text-align: center">
        <a href="javascript:;" id="imprimirComprobante"><img src="<?php echo base_url(); ?>images/impresora.jpg"
                                                             class="imgBoton" alt="Imprimir"></a>
        <br/>
        <br/>
        <a href="javascript:;" id="cancelarImprimirComprobante"><img
                src="<?php echo base_url(); ?>images/botoncancelar.jpg" width="85" height="22" class="imgBoton"></a>
    </div>
</div>
</body>
</html>