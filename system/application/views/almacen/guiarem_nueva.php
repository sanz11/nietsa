<script type="text/javascript" src="<?php echo base_url(); ?>js/almacen/guiarem.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>js/fancybox/jquery.fancybox-1.3.4.css"
      media="screen"/>
<script type="text/javascript">
    $(document).ready(function () {

        <?php
        if ($tipo_oper == 'V'):
            ?>
        setLimite(<?php echo VENTAS_GUIA; ?>);
        <?php
    elseif ($tipo_oper == 'C') :
        ?>
        setLimite(<?php echo COMPRAS_GUIA; ?>);
        <?php
    endif;
    ?>

        $('#tipo_movimiento').change(function () {
            valor_tipo = $(this).val();
            if (valor_tipo == 13) {
                $('#otro_motivo_oculto').show('slow');
            } else {
                $('#otro_motivo_oculto').hide('slow');
            }
        });

        $("a#linkVerCliente, a#linkSelecCliente, a#linkVerProveedor, a#linkSelecProveedor").fancybox({
            'width': 800,
            'height': 525,
            'autoScale': false,
            'transitionIn': 'none',
            'transitionOut': 'none',
            'showCloseButton': true,
            'modal': true,
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
            'modal': true,
            'type': 'iframe'
        });
        $("a#linkVerOrdenCompra").fancybox({
            'width': 970,
            'height': 550,
            'autoScale': false,
            'transitionIn': 'none',
            'transitionOut': 'none',
            'showCloseButton': true,
            'modal': true,
            'type': 'iframe'
        });

        $(".verDocuRefe").fancybox({
            'width': 800,
            'height': 500,
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
                    } else
                    //alert($('.verDocuRefe::checked').val());
                    if ($('.verDocuRefe::checked').val() == 'F')
                        baseurl = base_url + 'index.php/ventas/comprobante/ventana_muestra_comprobante/' + tipo_oper + '/' + $('#cliente').val() + '/SELECT_HEADER/F/' + almacen + '/F';
                    else if ($('.verDocuRefe::checked').val() == 'P')
                        baseurl = base_url + 'index.php/ventas/presupuesto/ventana_muestra_presupuesto/' + tipo_oper + '/' + $('#cliente').val() + '/SELECT_HEADER/F/' + almacen + '/P';
                    else if ($('.verDocuRefe::checked').val() == 'O')
                        baseurl = base_url + 'index.php/compras/ocompra/ventana_muestra_ocompra/' + tipo_oper + '/' + $('#cliente').val() + '/SELECT_HEADER/F/' + almacen + '/O';
                    else if ($('.verDocuRefe::checked').val() == 'R')
                        baseurl = base_url + 'index.php/almacen/guiarem/ventana_muestra_recurrentes/' + tipo_oper + '/' + $('#cliente').val() + '/SELECT_HEADER/F/' + almacen + '/R';
                    //alert(baseurl);

                    $('.verDocuRefe::checked').attr('href', baseurl);
                }
                else {
                    if ($('#proveedor').val() == '') {
                        alert('Debe seleccionar el proveedor.');
                        $('#ruc_proveedor').focus();
                        return false;
                    } else if ($('.verDocuRefe::checked').val() == 'F')
                        baseurl = base_url + 'index.php/ventas/comprobante/ventana_muestra_comprobante/' + tipo_oper + '/' + $('#proveedor').val() + '/SELECT_HEADER/F/' + almacen + '/F';
                    else if ($('.verDocuRefe::checked').val() == 'P')
                        baseurl = base_url + 'index.php/compras/presupuesto/ventana_muestra_presupuestoCom/' + tipo_oper + '/' + $('#proveedor').val() + '/SELECT_HEADER/F/' + almacen + '/P';
                    else if ($('.verDocuRefe::checked').val() == 'O')
                        baseurl = base_url + 'index.php/compras/ocompra/ventana_muestra_ocompra/' + tipo_oper + '/' + $('#proveedor').val() + '/SELECT_HEADER/F/' + almacen + '/O';
                    else if ($('.verDocuRefe::checked').val() == 'R')
                        baseurl = base_url + 'index.php/almacen/guiarem/ventana_muestra_recurrentes/' + tipo_oper + '/' + $('#proveedor').val() + '/SELECT_HEADER/F/' + almacen + '/R';

                    $('.verDocuRefe').attr('href', baseurl);
                }

            }
        });

    });


    $(function () {

        $("#buscar_producto").autocomplete({
            //flag = $("#flagBS").val();
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
                $("#producto").val(ui.item.codigo);
                $("#codproducto").val(ui.item.codinterno);
                $("#costo").val(ui.item.pcosto);
                $("#cantidad").focus();
                listar_unidad_medida_producto(ui.item.codigo);
                // obtener_producto_desde_codigo(n);
                // return false;
            },
            minLength: 3
        });

        //****** nuevo para ruc
        $("#buscar_cliente").autocomplete({
            //flag = $("#flagBS").val();
            source: function (request, response) {
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/ventas/cliente/autocompletado_ruc/",
                    type: "POST",
                    data: {
                        term: $("#buscar_cliente").val()
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

        /* Descativado hasta corregir vico 22082013  */
        $("#nombre_cliente").autocomplete({
            //flag = $("#flagBS").val();
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
                $("#buscar_cliente").val(ui.item.ruc);
                $("#cliente").val(ui.item.codigo);
                $("#ruc_cliente").val(ui.item.ruc);
                $("#buscar_producto").focus();
            },
            minLength: 3
        });

        /* Descativado hasta corregir vico 22082013  */
        $("#nombre_proveedor").autocomplete({
            //flag = $("#flagBS").val();
            source: function (request, response) {
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/compras/proveedor/autocompletado/",
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
                $("#buscar_proveedor").val(ui.item.ruc);
                $("#proveedor").val(ui.item.codigo);
                $("#ruc_proveedor").val(ui.item.ruc);
                $("#buscar_producto").focus();
            },
            minLength: 3
        });

        //****** nuevo para ruc PROVEEDOR
        $("#buscar_proveedor").autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/compras/proveedor/autocompletado_ruc/",
                    type: "POST",
                    data: {
                        term: $("#buscar_proveedor").val()
                    },
                    dataType: "json",
                    error : function (HXR, error){
                        console.log(error);
                    },
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
            minLength: 3
        });

    });


    /*-----------------------------------*/
    function seleccionar_cliente(codigo, ruc, razon_social, empresa, persona, direccion) {
        $("#cliente").val(codigo);
        $("#ruc_cliente").val(ruc);
        $("#buscar_cliente").val(ruc);
        $("#nombre_cliente").val(razon_social);
        if (tipo_oper == 'V')
            $('#punto_llegada').val(direccion);
    }
    function seleccionar_proveedor(codigo, ruc, razon_social, empresa, persona, ctactesoles, ctactedolares, direccion) {
        $("#proveedor").val(codigo);
        $("#ruc_proveedor").val(ruc);
        $("#nombre_proveedor").val(razon_social);
        $("#buscar_cliente").val(ruc);
        if (tipo_oper == 'C')
            $('#punto_partida').val(direccion);
    }
    function escribe_nombre_unidad_medida() {
        index = document.getElementById("unidad_medida").selectedIndex;
        nombre = document.getElementById("unidad_medida").options[index].text;
        $("#nombre_unidad_medida").val(nombre);
    }
    function seleccionar_producto(codigo, interno, familia, stock, costo, flagGenInd) {
        $("#producto").val(codigo);
        $("#codproducto").val(interno);
        $("#nombre_familia").val(familia);
        $("#stock").val(stock);
        $("#costo").val(costo);
        $("#cantidad").select();
        $("#flagGenInd").val(flagGenInd);

        listar_unidad_medida_producto(codigo);
    }
    function seleccionar_comprobante(guia, serieguia, numeroguia) {
        agregar_todo(guia);
        //alert(guia);
        serienumero = "Numero de Comprobante :" + serieguia + " - " + numeroguia;
        $("#dRef").val(guia);
        $("#serieguiaver").html(serienumero);
        $("#serieguiaver").show(2000);
        $("#serieguiaverPre").hide(2000);
        $("#serieguiaverOC").hide(2000);
        $("#serieguiaverRecu").hide(2000);
        $('#ordencompra').val('');
    }

    function seleccionar_presupuesto(guia, serieguia, numeroguia) {

        agregar_todopresupuesto(guia, tipo_oper);
        serienumero = "Numero de PRESUPUESTO :" + serieguia + " - " + numeroguia;
        $("#serieguiaverPre").html(serienumero);
        $("#serieguiaverPre").show(2000);
        $("#serieguiaver").hide(2000);
        $("#serieguiaverOC").hide(2000);
        $("#serieguiaverRecu").hide(2000);
        $("#numero_ref").val('');
        $("#dRef").val('');
        $('#ordencompra').val('');
    }
    function seleccionar_guiarem_recu(guia, serieguia, numeroguia) {
        agregar_todo_recu(guia);
        //alert(guia);
        serienumero = "Numero de guia :" + serieguia + " - " + numeroguia;
        $("#serieguiaverRecu").html('documento recurrente:' + serienumero);
        $("#serieguiaverRecu").show(2000);
        $("#serieguiaver").hide(2000);
        $("#serieguiaverPre").hide(2000);
        $("#serieguiaverOC").hide(2000);
        $("#numero_ref").val('');
        $("#dRef").val('');
        $('#ordencompra').val('');
    }

    function seleccionar_ocompra(ocompra, serie, numero)
    {
        //alert(guia);
        serienumero = "Numero de Orden <br>" + serie + " - " + numero;
        $('#numeroOrden').val(serie + '-' + numero);
        $('#ordencompra').val(ocompra);
        $("#serieOrden").html(serienumero);
        $("#num_orden_venta").val("0000"+serie + '-' + numero);
        $("#serieOrden").show(2000);
        $("#serieguiaver").hide(2000);
        $("#serieguiaverPre").hide(2000);
        $("#serieguiaverOC").hide(2000);
        $("#numero_ref").val('');
        $("#dRef").val('');
        obtener_detalle_ocompra_origen(ocompra);
    }

</script>
<?php echo $form_open; ?>
<div id="zonaContenido" align="center">
    <input type="hidden" name="codigoguia" id="codigoguia" value="<?php echo $guia; ?>"/>
    <?php echo validation_errors("<div class='error'>", '</div>'); ?>
    <div id="tituloForm" class="header"><?php echo $titulo; ?></div>
    <div id="frmBusqueda">
        <table class="fuente8" width="100%" cellspacing="0" cellpadding="5" border="0">
            <tr>
                <td width="8%">N&uacute;mero</td>
                <td width="39%" valign="top">
                    <?php
                    if ($tipo_oper == 'V') {
                        switch ($tipo_codificacion) {
                            case '1':
                                echo '<input type="text" name="numero" id="numero" value="' . ($codigo != '' ? $numero : $numero_suger) . '" class="cajaGeneral cajaSoloLectura" readonly="readonly"  size="10" maxlength="10" placeholder="Numero" />';
                                break;
                            case '2':
                                echo '<input type="text" name="serie" id="serie" value="' . $serie . '" class="cajaGeneral cajaSoloLectura" size="3" maxlength="3" placeholder="Serie" /> ';
                                echo '<input type="text" name="numero" id="numero" value="' . $numero . '" class="cajaGeneral cajaSoloLectura" size="10" maxlength="6" placeholder="Numero"  /> ';
                                echo '<a href="javascript:;" id="linkVerSerieNum"' . ($codigo != '' ? 'style="display:none"' : '') . '><p style="display:none">' . $serie_suger . '-' . $numero_suger . '</p><image src="' . base_url() . 'images/flecha.png" border="0" alt="Serie y número sugerido" title="Serie y número sugerido" /></a>';
                                break;
                            case '3':
                                echo '<input type="text" name="codigo_usuario" id="codigo_usuario" value="' . $codigo_usuario . '" class="cajaGeneral" size="20" maxlength="50"  />';
                                break;
                        }
                    } else {
                        echo '<input type="text" name="serie" id="serie" value="' . $serie . '" class="cajaGeneral" size="3" maxlength="3" placeholder="Serie"  /> ';
                        echo '<input type="text" name="numero" id="numero" value="' . $numero . '" class="cajaGeneral" size="10" maxlength="6" placeholder="Numero"  /> ';
                    }
                    ?>
                </td>

                <!--<td width="13%" >Presupuesto</td>-->
                <td width="18%">
                    <?php if ($tipo_oper == 'V') { ?>
                        <label for="P" style="cursor: pointer"><img src="<?php echo base_url() ?>images/presupuesto.png"
  class="imgBoton"/></label>
                    <?php } else { ?>
                        <label for="P" style="cursor: pointer"><img src="<?php echo base_url() ?>images/cotizacion.png"
 class="imgBoton"/></label>
                    <?php } ?>
                    <input type="radio" name="referenciar" id="P" value="P" href="javascript:;" class="verDocuRefe"
                           style="display:none;">

                    <div id="serieguiaverPre" name="serieguiaverPre"
                         style="background-color: #cc7700; color:#fff; padding:5px;display:none"></div>
                </td>

                <!--<td width="13%" >O. <?php //if ($tipo_oper == 'C') echo 'Compra'; else echo 'Venta'; ?> </td>-->
                <td width="18%">
                    <!-- <select name="ordencompra" id="ordencompra" class="comboMedio" >
                            <?php
                    /*if ($modo == 'insertar') {
                        echo $cboOrdencompra;
                    } else {
                        echo "<option value=''>::Seleccione::</option>";
                        echo $cboOrdencompra;
                    }*/
                    ?>
                    </select>
                       <a href="<?php echo base_url(); ?>index.php/compras/ocompra/comprobante_nueva_ocompra/" id="linkVerOrdenCompra" ></a>-->
                    <?php if ($tipo_oper == 'V') { ?>
                        <label for="O" style="cursor: pointer"><img src="<?php echo base_url() ?>images/oventa.png"
 class="imgBoton"/></label>
                    <?php } else { ?>
                        <label for="O" style="cursor: pointer"><img src="<?php echo base_url() ?>images/ocompra.png"
   class="imgBoton"/></label>
                    <?php } ?>
                    <input type="radio" name="referenciar" id="O" value="O" href="javascript:;" class="verDocuRefe"
                           style="display:none;">

                    <div id="serieguiaverOC" name="serieguiaverOC"
                         style="background-color: #cc7700; color:#fff; padding:5px;display:none"></div>
                    <input type="hidden" name="ordencompra" id="ordencompra" size="5"
                           value="<?php echo $ordencompra; ?>"/>
                    <input type="hidden" name="numeroOrden" id="numeroOrden" size="5"
                           value=""/>
                    <div id="serieOrden" name="serieOrden"
                         style="background-color: #cc7700; color:#fff; padding:5px; display: none"></div>
                </td>


                <td width="13%">F.Traslado*</td>
                <td width="18%"><?php echo $fecha_traslado; ?>
                    <img src="<?php echo base_url(); ?>images/calendario.png" name="Calendario2" id="Calendario2"
                         width="16" height="16" border="0" onMouseOver="this.style.cursor='pointer'"
                         title="Calendario">
                    <script type="text/javascript">
                        Calendar.setup({
                            inputField: "fecha_traslado",      // id del campo de texto
                            ifFormat: "%d/%m/%Y",       // formato de la fecha, cuando se escriba en el campo de texto
                            button: "Calendario2"   // el id del botón que lanzará el calendario
                        });
                    </script>
                </td>
            </tr>
            <tr>
                <?php if ($tipo_oper == 'V') { ?>
                    <td>Cliente *</td>
                    <td valign="middle">
                        <input type="hidden" name="cliente" id="cliente" size="5" value="<?php echo $cliente ?>"/>
                        <input name="buscar_cliente" type="text" class="cajaGeneral" id="buscar_cliente" size="9"
                               placeholder="Ruc"
                               title="Ingrese parte del nombre o el nro. de documento, luego presione ENTER."/>&nbsp;
                        <input type="hidden" name="ruc_cliente" class="cajaGeneral" id="ruc_cliente" size="10"
                               maxlength="11" onblur="obtener_cliente();" value="<?php echo $ruc_cliente; ?>"
                               onkeypress="return numbersonly(this,event,'.');"/>
                        <input type="text" name="nombre_cliente" class="cajaGeneral cajaSoloLectura" id="nombre_cliente"
                               placeholder="Nombre cliente"
                               size="36" maxlength="50" value="<?php echo $nombre_cliente; ?>"/>
                        <!--<a href="<?php echo base_url(); ?>index.php/ventas/cliente/ventana_busqueda_cliente/" id="linkVerCliente"><img height='16' width='16' src='<?php echo base_url(); ?>/images/ver.png' title='Buscar' border='0' /></a>-->
                        <a href="<?php echo base_url(); ?>index.php/ventas/cliente/ventana_selecciona_cliente/"
                           id="linkSelecCliente"></a>
                    </td>
                <?php } else { ?>
                    <td>Proveedor *</td>
                    <td valign="middle">
                        <input type="hidden" name="proveedor" id="proveedor" size="5" value="<?php echo $proveedor ?>"/>
                        <input type="text" name="buscar_proveedor" class="cajaGeneral" id="buscar_proveedor" size="10"
                               maxlength="11" value="<?php echo $ruc_proveedor; ?>" placeholder="Ruc"
                               onkeypress="return numbersonly(this,event,'.');" />
                        <input type="text" name="nombre_proveedor" class="cajaGeneral cajaSoloLectura"
                               placeholder="Nombre proveedor"
                               id="nombre_proveedor" size="34" maxlength="50" value="<?php echo $nombre_proveedor; ?>"/>
                        <!--<a href="<?php echo base_url(); ?>index.php/compras/proveedor/ventana_busqueda_proveedor/" id="linkVerProveedor"><img height='16' width='16' src='<?php echo base_url(); ?>/images/ver.png' title='Buscar' border='0' /></a>-->
                        <a href="<?php echo base_url(); ?>index.php/compras/proveedor/ventana_selecciona_proveedor/"
                           id="linkSelecProveedor"></a>
                    </td>
                <?php } ?>

                <td>Moneda *</td>
                <td><?php echo $cboMoneda; ?></td>
                <!-- <td>Doc. Pago</td>-->
                <td>
                    <label for="F" style="cursor: pointer"><img src="<?php echo base_url() ?>images/docpago.png"
                                                                class="imgBoton"/></label>
                    <input type="radio" name="referenciar" id="F" value="F" href="javascript:;" class="verDocuRefe"
                           style="display:none;">
                    <input type="hidden" id="dRef" name="dRef">

                    <div id="serieguiaver" name="serieguiaver"
                         style="background-color: #cc7700; color:#fff; padding:5px;display:none"></div>
                </td>
                <!-- <td width="13%" >DOC. Recurrennte</td>-->
                <td width="18%">
                    <label for="R" style="cursor: pointer"><img src="<?php echo base_url() ?>images/docrecurrente.png"
                                                                class="imgBoton"/></label>
                    <input type="radio" name="referenciar" id="R" value="R" href="javascript:;" class="verDocuRefe"
                           style="display:none;">

                    <div id="serieguiaverRecu" name="serieguiaverRecu"
                         style="background-color: #cc7700; color:#fff; padding:5px;display:none"></div>
                </td>
            </tr>
            <tr>
                <td width="13%">Almacen *</td>
                <td width="18%"><?php echo $cboAlmacen; ?></td>
                <td>Motivo del Traslado *</td>
                <td><?php echo $cboTipoMov; ?></td>

            <td width="13%"> Num Order Venta</td>
            <td width="18%">
        <input type="" name="" size="10" id="num_orden_venta" 
        value="<?=$serie_numero_orden?>"></td>
                <td>
                    <div id="otro_motivo_oculto" style="display: none">Otro Motivo <?php echo $otro_motivo; ?></div>
                </td>

            </tr>
            <!--<tr>
                <td align="left"> Doc. Refer. </td>
                <td align="left"> <?php echo $numero_ocompra; ?> <?php if ($tipo_oper != 'C') echo 'P.e: Nro. de Presupuesto o O. Venta'; else echo 'P.e: Nro. de O. Compra o Cotización'; ?></td>
                <td align="left"> Cotizaci&oacute;n</td>
                <td valign="middle"><?php echo $cboCotizacion; ?>
                                        
                </td>
                <td>Factura :</td>
                <td>
                                <select name="factura" id="factura" class="comboMedio"  onchange="obtener_detalle_factura()" >
            <?php echo $cboFactura; ?>
                                </select>
                                </td>

            </tr>-->
            <tr>
                <td>Origen *</td>
                <td><?php echo $punto_partida; ?>
                    <a href="javascript:;" id="linkVerMisDirecciones">
                        <img src="<?php echo base_url(); ?>images/ver.png" border="0"/>
                    </a>

                    <div id="lista_mis_direcciones" class="cuadro_flotante">
                        <ul>
                        </ul>
                    </div>
                </td>
                <td>Destino *</td>
                <td colspan="3"><?php echo $punto_llegada; ?>
                    <a href="javascript:;" id="linkVerDirecciones">
                        <img src="<?php echo base_url(); ?>images/ver.png" border="0"/>
                    </a>

                    <div id="lista_direcciones" class="cuadro_flotante" style="width:315px;">
                        <ul>
                        </ul>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <div id="frmBusqueda"  <?php echo $hidden; ?>>
        <table class="" width="100%" cellspacing='0' cellpadding='3' border='0'>
            <tr>
                <td width="8%">
                    <select name="flagBS" id="flagBS" style="width:68px;" class="comboMedio"
                            onchange="limpiar_campos_producto()">
                        <option value="B" selected="selected" title="Producto">P</option>
                        <option value="S" title="Servicio">S</option>
                    </select>
                </td>
                <td width="37%">
                    <input name="compania" type="hidden" id="compania" value="<?php echo $compania; ?>">
                    <input name="producto" type="hidden" class="cajaGeneral" id="producto"/>
                    <input name="buscar_producto" type="text" class="cajaGeneral" id="buscar_producto" size="10"
                           placeholder="Producto"/>&nbsp;
                    <input name="codproducto" type="hidden" class="cajaGeneral" id="codproducto" size="10"
                           maxlength="20" onblur="obtener_producto();"/>
                    <input NAME="nombre_producto" type="text" class="cajaGeneral cajaSoloLectura" id="nombre_producto"
                           placeholder="Descripcion producto"
                           size="40" readonly="readonly"/>
                    <!--<a href="<?php echo base_url(); ?>index.php/almacen/producto/ventana_busqueda_producto/" id="linkVerProducto"><img height='16' width='16' src='<?php echo base_url(); ?>/images/ver.png' title='Buscar' border='0' /></a>-->
                    <a href="<?php echo base_url(); ?>index.php/almacen/producto/ventana_selecciona_producto/"
                       id="linkSelecProducto"></a>
                    <input name="stock" type="hidden" id="stock"/>
                    <input name="costo" type="hidden" id="costo"/>
                    <input name="simbolo" type="hidden" id="simbolo"/>
                    <input name="nombre_familia" type="hidden" id="nombre_familia"/>
                    <input name="flagGenInd" type="hidden" id="flagGenInd"/>
                </td>
                <td width="6%">Cantidad</td>
                <td width="22%">

                    <input NAME="cantidad" type="text" class="cajaPequena2" id="cantidad" size="5" maxlength="10"
                           onKeyPress="return numbersonly(this,event,'.');"/>
                    <select name="unidad_medida" id="unidad_medida" class="comboMedio"
                            onchange="obtener_precio_producto();">
                        <option value="">::Seleccione::</option>
                    </select>
                </td>
                <td width="17%">
                    <select <?php if ($tipo_oper == 'C') echo 'style="display:none;"' ?> name="precioProducto"
                    id="precioProducto" class="comboPequeno" onchange="mostrar_precio();"
                    style="width:84px;">
                        <option value="0">::Seleccion::</option>
                    </select>
                    <input NAME="precio" type="text" class="cajaGeneral" id="precio" size="5" maxlength="10"
                           onkeypress="return numbersonly(this,event,'.');"
                           title="<?php if ($contiene_igv == true) echo 'Precio con IGV'; ?>"/>
                </td>
                <td width="10%">
                    <div align="right"><a href="javascript:;" onClick="agregar_producto_guiarem();"><img
                                src="<?php echo base_url(); ?>images/botonagregar.jpg" class="imgBoton"
                                align="absbottom"></a></div>
                </td>
            </tr>
        </table>
    </div>
    <div id="frmBusqueda" style="height:250px; overflow: auto">
        <table class="fuente8" width="100%" cellspacing="0" cellpadding="3" border="1" id="Table1">
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
                <td width="6%">
                    <div align="center">I.G.V.</div>
                </td>
                <td width="6%">
                    <div align="center">IMPORTE</div>
                </td>
            </tr>
        </table>
        <div>
            <table id="tblDetalleGuiaRem" class="fuente8" width="100%" cellspacing="1" cellpadding="1" border="0">
                <?php
                if (count($detalle) > 0) {
                    foreach ($detalle as $indice => $valor) {
                        $detacodi = $valor->GUIAREMDETP_Codigo;
                        $prodproducto = $valor->PROD_Codigo;
                        $unidad_medida = $valor->UNDMED_Codigo;
                        $codigo_interno = $valor->PROD_CodigoInterno;
                        $prodcantidad = $valor->GUIAREMDETC_Cantidad;
                        $nombre_producto = $valor->GUIAREMDETC_Descripcion;
                        $nombre_unidad = $valor->UNDMED_Simbolo;
                        $costo = $valor->GUIAREMDETC_Costo;
                        $venta = $valor->GUIAREMDETC_Venta;
                        $GenInd = $valor->GUIAREMDETC_GenInd;
                        $prodpu = $valor->GUIAREMDETC_Pu;
                        $prodsubtotal = $valor->GUIAREMDETC_Subtotal;
                        $proddescuento = $valor->GUIAREMDETC_Descuento;
                        $prodigv = $valor->GUIAREMDETC_Igv;
                        $prodtotal = $valor->GUIAREMDETC_Total;
                        $prodpu_conigv = $valor->GUIAREMDETC_Pu_ConIgv;
                        if (($indice + 1) % 2 == 0) {
                            $clase = "itemParTabla";
                        } else {
                            $clase = "itemImparTabla";
                        }
                        ?>
                        <tr class="<?php echo $clase; ?>">
                            <td width="3%">
                                <div align="center"><font color="red"><strong><a href="javascript:;"
                                onClick="eliminar_producto_ocompra(<?php echo $indice; ?>);"><span
                                style="border:1px solid red;background: #ffffff;">&nbsp;X&nbsp;</span></a></strong></font>
                                </div>
                            </td>
                            <td width="4%">
                                <div align="center"><?php echo $indice + 1; ?></div>
                            </td>
                            <td width="10%">
                                <div align="center">
                                    <?php echo $codigo_interno; ?>
                                    <input type="hidden" class="cajaMinima" name="prodcodigo[<?php echo $indice; ?>]"
                                           id="prodcodigo[<?php echo $indice; ?>]"
                                           value="<?php echo $prodproducto; ?>"/>
                                    <input type="hidden" class="cajaMinima" name="produnidad[<?php echo $indice; ?>]"
                                           id="produnidad[<?php echo $indice; ?>]"
                                           value="<?php echo $unidad_medida; ?>"/>
                                    <input type="hidden" class="cajaMinima" name="flagGenIndDet[<?php echo $indice; ?>]"
                                           id="flagGenIndDet[<?php echo $indice; ?>]" value="<?php echo $GenInd; ?>"/>
                                </div>
                            </td>
                            <td>
                                <div align="left">
                                    <input type="text" class="cajaGeneral" style="width:395px;" maxlength="250"
                                           name="proddescri[<?php echo $indice; ?>]"
                                           id="proddescri[<?php echo $indice; ?>]"
                                           value="<?php echo $nombre_producto; ?>"/>
                                </div>
                            </td>
                            <td width="10%">
                                <div align="left">
                                    <input type="text" class="cajaGeneral" size="1" maxlength="5"
                                           name="prodcantidad[<?php echo $indice; ?>]"
                                           id="prodcantidad[<?php echo $indice; ?>]"
                                           value="<?php echo $prodcantidad; ?>" onblur="calcula_importe(<?php echo $indice; ?>);"
                                           onKeyPress="return numbersonly(this,event,'.');"/> <?php echo $nombre_unidad; ?>
                                    <?php
                                    if ($GenInd == "I") {
                                        if ($tipo_oper == 'V')
                                            echo ' <a href="javascript:;" onclick="ventana_producto_serie2(' . $indice . ')"><img src="' . base_url(), 'images/flag-green_icon.png" width="20" height="20" border="0" align="absmiddle" /></a>';
                                        else
                                            echo ' <a href="javascript:;" onclick="ventana_producto_serie(' . $indice . ')"><img src="' . base_url(), 'images/flag-green_icon.png" width="20" height="20" border="0" align="absmiddle" /></a>';
                                    }
                                    ?>
                                </div>
                            </td>
                            <td width="6%">
                                <div align="center"><input type="text" size="5" maxlength="10" class="cajaGeneral"
                                                           name="prodpu_conigv[<?php echo $indice; ?>]"
                                                           id="prodpu_conigv[<?php echo $indice; ?>]"
                                                           value="<?php echo $prodpu_conigv; ?>"
                                                           onblur="modifica_pu_conigv(<?php echo $indice; ?>);"
                                                           onkeypress="return numbersonly(this,event,'.');"/></div>
                            </td>
                            <td width="6%">
                                <div align="center"><input type="text" size="5" maxlength="10" class="cajaGeneral"
                                                           name="prodpu[<?php echo $indice; ?>]"
                                                           id="prodpu[<?php echo $indice; ?>]"
                                                           value="<?php echo $prodpu; ?>"
                                                           onblur="modifica_pu(<?php echo $indice; ?>);"
                                                           onkeypress="return numbersonly(this,event,'.');"/>
                                    <td width="6%">
                                        <div align="center"><input type="text" size="5" maxlength="10"
                class="cajaGeneral cajaSoloLectura"
                name="prodprecio[<?php echo $indice; ?>]"
                id="prodprecio[<?php echo $indice; ?>]"
                value="<?php echo $prodsubtotal; ?>"
               readonly="readonly"/></div>
                                    </td>
                                    <td width="6%">
                                        <div align="centeclass="cajaGeneral cajaSoloLectura"
 name="prodigv[<?php echo $indice; ?>]"
 id="prodigv[<?php echo $indice; ?>]"
 readonly="readonly" value="<?php echo $prodigv; ?>"/>
                                        </div>
                                    </td>
                                    <td width="6%">
                                        <div align="center">
                                            <input type="hidden" name="detaccion[<?php echo $indice; ?>]"
                                                   id="detaccion[<?php echo $indice; ?>]" value="m"/>
                                            <input type="hidden" name="prodigv100[<?php echo $indice; ?>]"
                                                   id="prodigv100[<?php echo $indice; ?>]" value="<?php echo $igv; ?>"/>
                                            <input type="hidden" name="detacodi[<?php echo $indice; ?>]"
                                                   id="detacodi[<?php echo $indice; ?>]"
                                                   value="<?php echo $detacodi; ?>"/>
                                            <input type="hidden" name="prodstock[<?php echo $indice; ?>]"
                                                   id="prodstock[<?php echo $indice; ?>]" value=""/>
                                            <input type="hidden" name="prodcosto[<?php echo $indice; ?>]"
                                                   id="prodcosto[<?php echo $indice; ?>]" readonly="readonly"
                                                   value="<?php echo $costo; ?>"/>
                                            <input type="hidden" name="prodventa[<?php echo $indice; ?>]"
                                                   id="prodventa[<?php echo $indice; ?>]" value="<?php echo $venta; ?>"
                                                   readonly="readonly"/>
                                            <input type="hidden" name="proddescuento100[<?php echo $indice; ?>]"
                                                   id="proddescuento100[<?php echo $indice; ?>]"
                                                   value="<?php echo $descuento; ?>"/>
                                            <input type="hidden" name="proddescuento[<?php echo $indice; ?>]"
                                                   id="proddescuento[<?php echo $indice; ?>]"
                                                   value="<?php echo $proddescuento; ?>"
                                                   onblur="calcula_importe2(<?php echo $indice; ?>);"/>
 <input type="text" size="5" maxlength="10"
     class="cajaGeneral cajaSoloLectura"
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
    <div id="frmBusqueda" style="margin-top: 5px">
        <table width="100%" border="0" align="center" cellpadding=3 cellspacing=0 class="">
            <tr>
                <td width="75%">
  <table class="fuente8_2" width="100%" border="0" cellpadding="3" cellspacing="5">
    <tr>
    <td><b>EMPRESA DE TRANSP.</b></td>
    <td colspan="3"><?php echo $cboEmpresaTrans; ?></td>
<td>&nbsp;&nbsp;Num Ref Factura</td>
                            <td>
<input class="cajaGeneral" name="numero_ref" type="text" id="numero_ref" size="14" maxlength="26" value="<?php echo $numero_ref; ?>" readonly/>
</td>

</tr>
                        <tr>
                            <td width="30%"><b>UNIDAD DE TRANSP.</b></td>
                            <td width="5%">Marca</td>
                            <td width="20%"><?php echo $marca; ?></td>
                            <td width="10%">Placa</td>
                            <td width="10%"><?php echo $placa; ?></td>
                            <td width="15%">Registro MTC</td>
                            <td width="10%"><?php echo $registro_mtc; ?></td>
                        </tr>
                        <tr>
                            <td><b>CONDUCTOR</b></td>
                            <td>Nombres</td>
                            <td><?php echo $nombre_conductor; ?></td>
                            <td>Cert.Inscripción</td>
                            <td><?php echo $certificado; ?></td>
                            <td>Licencia de conducir</td>
                            <td><?php echo $licencia; ?></td>
                        </tr>
                        <tr>
                            <td><b>PERS. RECEPCIONA</b></td>
                            <td>Nombres</td>
                            <td><?php echo $recepciona_nombres; ?> </td>
                            <td>DNI</td>
                            <td colspan="3"><?php echo $recepciona_dni; ?></td>
                        </tr>
                        <tr>
                            <td style="display: none;"><b>ESTADO</b></td>
                            <td style="display: none;" colspan="6"><?php echo $estado; ?></td>
                        </tr>
                        <tr>
                            <td valign="top"><b>OBSERVACION</b></td>
                            <td colspan="6"><textarea id="observacion" name="observacion" class="cajaTextArea"
                                                      style="width:100%" rows="3"><?php echo $observacion; ?></textarea>
                            </td>
                        </tr>
                    </table>
                </td>
                <td width="5%"></td>
                <td valign="top" width="25%">
                    <table width="100%" border="0" align="right" cellpadding="3" cellspacing="0" class=""
                           style="margin-top:20px;">
                        <tr>
                            <td width="10%">Sub-total</td>
                            <td width="10%" align="right">
                                <div align="right"><input class="cajaTotales" name="preciototal" type="text"
  id="preciototal" size="12" align="right" readonly="readonly"
    value="<?php echo round($preciototal, 2); ?>"/></div>
                            </td>
                        </tr>
                        <tr>
                            <td>Descuento</td>
                            <td align="right">
<div align="right"><input class="cajaTotales" name="descuentotal" type="text"  id="descuentotal" size="12" align="right" readonly="readonly" value="<?php echo round($descuentotal, 2); ?>"/></div>
</td> </tr> <tr>
<td>IGV</td>
<td align="right">
<div align="right"><input class="cajaTotales" name="igvtotal" type="text" id="igvtotal"
 size="12" align="right" readonly="readonly"
 value="<?php echo round($igvtotal, 2); ?>"/></div>
                            </td>
                        </tr>
                        <tr>
                            <td>Precio Total</td>
                            <td align="right">
                                <div align="right"><input class="cajaTotales" name="importetotal" type="text"
                                                          id="importetotal" size="12" align="right" readonly="readonly"
                                                          value="<?php echo round($importetotal, 2); ?>"/></div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <?php echo $oculto; ?>
    </div>
    <br/>

    <div id="botonBusqueda2" style="padding-top:20px;">
        <img id="loading" src="<?php echo base_url(); ?>images/loading.gif" style="visibility: hidden"/>
        <a href="javascript:;" id="grabarGuiarem"><img src="<?php echo base_url(); ?>images/botonaceptar.jpg" width="85"
                                                       height="22" class="imgBoton"/></a>
        <a href="javascript:;" id="limpiarGuiarem"><img src="<?php echo base_url(); ?>images/botonlimpiar.jpg"
                                                        width="69" height="22" class="imgBoton"/></a>
        <a href="javascript:;" id="cancelarGuiarem"><img src="<?php echo base_url(); ?>images/botoncancelar.jpg"
                                                         width="85" height="22" class="imgBoton"/></a>
        <input type="hidden" name="codigo_orden" id="codigo_orden" value=""/>
        <input type="hidden" name="codigo_orden2" id="codigo_orden2" value=""/>
        <input type="hidden" name="txtCodigoG" id="txtCodigoG" value="<?=$codigo_giarem?>">
    </div>
</div>
<?php echo $form_close; ?>