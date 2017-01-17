<?php
$nombre_persona = $this->session->userdata('nombre_persona');
$persona = $this->session->userdata('persona');
$usuario = $this->session->userdata('usuario');
$url = base_url() . "index.php";
if (empty($persona)) header("location:$url");
$CI = get_instance();
?>
<html>
<head>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/ventas/notacredito.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>js/fancybox/jquery.fancybox-1.3.4.css"
          media="screen"/>
    <script language="javascript">
        $(document).ready(function () {

            $('#serie').click(function () {
                $('#serie').val("");
                $('#numero').val("");
            });

            $('#numero').click(function () {
                $('#serie').val("");
                $('#numero').val("");
            });

            $('#ruc_cliente').click(function () {
                $('#nombre_cliente').val("");
                $('#ruc_cliente').val("");
            });

            $('#nombre_cliente').click(function () {
                $('#ruc_cliente').val("");
                $('#nombre_cliente').val("");
            });

            $('#codproducto').click(function () {
                $('#codproducto').val("");
                $('#nombre_producto').val("");
            });

            $("a#linkVerCliente, a#linkVerProveedor").fancybox({
                'width': 800,
                'height': 500,
                'autoScale': false,
                'transitionIn': 'none',
                'transitionOut': 'none',
                'showCloseButton': false,
                'modal': true,
                'type': 'iframe'
            });

            $("a#linkVerProducto").fancybox({
                'width': 800,
                'height': 500,
                'autoScale': false,
                'transitionIn': 'none',
                'transitionOut': 'none',
                'showCloseButton': false,
                'modal': true,
                'type': 'iframe'
            });

            $("#nombre_cliente").autocomplete({
                source: function (request, response) {

                    $.ajax({
                        url: "<?php echo base_url(); ?>index.php/ventas/cliente/autocomplete/",
                        type: "POST",
                        data: {term: $("#nombre_cliente").val()},
                        dataType: "json",
                        success: function (data) {
                            response(data);
                        }
                    });
                },

                select: function (event, ui) {
                    $("#buscar_cliente").val(ui.item.ruc)
                    $("#cliente").val(ui.item.codigo);
                    $("#ruc_cliente").val(ui.item.ruc);
                },

                minLength: 2

            });

            $("#nombre_proveedor").autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: "<?php echo base_url(); ?>index.php/compras/proveedor/autocomplete/",
                        type: "POST",
                        data: {term: $("#nombre_proveedor").val()},
                        dataType: "json",
                        success: function (data) {
                            response(data);
                        }

                    });

                },
                select: function (event, ui) {
                    $("#buscar_proveedor").val(ui.item.ruc)
                    $("#proveedor").val(ui.item.codigo);
                    $("#ruc_proveedor").val(ui.item.ruc);
                },

                minLength: 2

            });

            $("#nombre_producto").autocomplete({
                //flag = $("#flagBS").val();
                source: function (request, response) {
                    $.ajax({
                        url: "<?php echo base_url(); ?>index.php/almacen/producto/autocomplete/B/" + $("#compania").val(),
                        type: "POST",
                        data: {
                            term: $("#nombre_producto").val()
                        },
                        dataType: "json",
                        success: function (data) {
                            response(data);
                        }
                    });
                },
                select: function (event, ui) {
                    $("#nombre_producto").val(ui.item.codinterno);
                    $("#producto").val(ui.item.codigo);
                    $("#codproducto").val(ui.item.codinterno);
                },
                minLength: 2
            });

        });
        function seleccionar_cliente(codigo, ruc, razon_social, empresa, persona) {
            $("#cliente").val(codigo);
            $("#ruc_cliente").val(ruc);
            $("#nombre_cliente").val(razon_social);
        }
        function seleccionar_proveedor(codigo, ruc, razon_social) {
            $("#proveedor").val(codigo);
            $("#ruc_proveedor").val(ruc);
            $("#nombre_proveedor").val(razon_social);
        }
        function seleccionar_producto(codigo, interno, familia, stock, costo) {
            $("#producto").val(codigo);
            $("#codproducto").val(interno);

            base_url = $("#base_url").val();
            url = base_url + "index.php/almacen/producto/listar_unidad_medida_producto/" + codigo;
            $.getJSON(url, function (data) {
                $.each(data, function (i, item) {
                    nombre_producto = item.PROD_Nombre;
                });
                $("#nombre_producto").val(nombre_producto);
            });
        }

        var cursor;
        if (document.all) {
            // Está utilizando EXPLORER
            cursor = 'hand';
        } else {
            // Está utilizando MOZILLA/NETSCAPE
            cursor = 'pointer';
        }
    </script>
</head>
<body>
<div id="pagina">
    <div id="zonaContenido">
        <div align="center">
            <div id="tituloForm" class="header"><?php echo $titulo_busqueda; ?></div>
            <input name="compania" type="hidden" id="compania" value="<?php echo $compania; ?>">

            <form id="form_busqueda" name="form_busqueda" method="post"
                  action="<?php echo base_url(); ?>index.php/ventas/notacredito/comprobantes/<?php echo $tipo_oper; ?>/<?php echo $tipo_docu; ?>">
                <div id="frmBusqueda">
                    <table class="fuente8" width="98%" cellspacing="0" cellpadding="3" border="0">
                        <tr>
                            <td align='left' width="10%">Fecha inicial</td>
                            <td align='left' width="90%">
                                <input name="fechai" id="fechai" value="" type="text"
                                       class="cajaGeneral" size="10" maxlength="10"/>
                                <img src="<?php echo base_url(); ?>images/calendario.png" name="Calendario1"
                                     id="Calendario1" width="16" height="16" border="0"
                                     onMouseOver="this.style.cursor='pointer'" title="Calendario"/>
                                <script type="text/javascript">
                                    Calendar.setup({
                                        inputField: "fechai",      // id del campo de texto
                                        ifFormat: "%d/%m/%Y",       // formato de la fecha, cuando se escriba en el campo de texto
                                        button: "Calendario1"   // el id del botón que lanzará el calendario
                                    });
                                </script>
                                <label style="margin-left: 90px;">Fecha final</label>
                                <input name="fechaf" id="fechaf" value="" type="text"
                                       class="cajaGeneral" size="10" maxlength="10"/>
                                <img src="<?php echo base_url(); ?>images/calendario.png" name="Calendario2"
                                     id="Calendario2" width="16" height="16" border="0"
                                     onMouseOver="this.style.cursor='pointer'" title="Calendario2"/>
                                <script type="text/javascript">
                                    Calendar.setup({
                                        inputField: "fechaf",      // id del campo de texto
                                        ifFormat: "%d/%m/%Y",       // formato de la fecha, cuando se escriba en el campo de texto
                                        button: "Calendario2"   // el id del botón que lanzará el calendario
                                    });
                                </script>
                            </td>
                        </tr>
                        <tr>
                            <td align='left'>Número</td>
                            <td align='left'><input type="text" name="serie" id="serie" value=""
                                                    class="cajaGeneral" size="3" maxlength="3" placeholder="Serie"/>
                                <input type="text" name="numero" id="numero" value=""
                                       class="cajaGeneral" size="10" maxlength="6" placeholder="Numero"/>
                            </td>
                        </tr>
                        <tr>
                            <?php if ($tipo_oper == 'V') { ?>
                                <td align='left'>Cliente</td>
                                <td align='left'>
                                    <input type="hidden" name="cliente" value="" id="cliente"
                                           size="5"/>
                                    <input type="text" name="ruc_cliente" value=""
                                           class="cajaGeneral" id="ruc_cliente" size="10" maxlength="11"
                                           onKeyPress="return numbersonly(this,event,'.');" placeholder="Ruc"/>
                                    <input type="text" name="nombre_cliente" value=""
                                           class="cajaGrande cajaSoloLectura" id="nombre_cliente" size="40"
                                           placeholder="Nombre cliente"/>
                                    <a href="<?php echo base_url(); ?>index.php/ventas/cliente/ventana_busqueda_cliente/"
                                       id="linkVerCliente"><img height='16' width='16'
                                                                src='<?php echo base_url(); ?>/images/ver.png'
                                                                title='Buscar' border='0'/></a>
                                </td>
                            <?php } else { ?>
                                <td align='left'>Proveedor</td>
                                <td align='left'>
                                    <input type="hidden" name="proveedor" value=""
                                           id="proveedor" size="5"/>
                                    <input type="text" name="ruc_proveedor" value=""
                                           class="cajaGeneral" id="ruc_proveedor" size="10" maxlength="11"
                                           placeholder="Ruc"
                                           onBlur="obtener_proveedor();"
                                           onKeyPress="return numbersonly(this,event,'.');"/>
                                    <input type="text" name="nombre_proveedor" value=""
                                           class="cajaGrande cajaSoloLectura" id="nombre_proveedor" size="40"
                                           placeholder="Nombre proveedor"/>
                                    <a href="<?php echo base_url(); ?>index.php/compras/proveedor/ventana_busqueda_proveedor/"
                                       id="linkVerProveedor"><img height='16' width='16'
                                                                  src='<?php echo base_url(); ?>/images/ver.png'
                                                                  title='Buscar' border='0'/></a>
                                </td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <td align='left'>Artículo</td>
                            <td align='left'>
                                <input name="producto" type="hidden" class="cajaPequena" id="producto" size="10"
                                       maxlength="11"/>
                                <input name="codproducto" type="text" value=""
                                       class="cajaPequena" id="codproducto" size="10" maxlength="11"
                                       placeholder="Codigo"
                                       onBlur="obtener_producto();" onKeyPress="return numbersonly(this,event,'.');"/>
                                <input NAME="nombre_producto" type="text" value=""
                                       class="cajaGrande cajaSoloLectura" id="nombre_producto" size="40"
                                       placeholder="Nombre producto"/>
                                <a href="<?php echo base_url(); ?>index.php/almacen/producto/ventana_busqueda_producto/"
                                   id="linkVerProducto"><img height='16' width='16'
                                                             src='<?php echo base_url(); ?>/images/ver.png'
                                                             title='Buscar' border='0'/></a>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="acciones">
                    <div id="botonBusqueda">
                        <ul id="imprimirComprobante" class="lista_botones">
                            <li id="imprimir">Imprimir</li>
                        </ul>
                        <ul id="nuevaComprobante" class="lista_botones">
                            <li id="nuevo">Nueva <?php echo ucwords($CI->obtener_tipo_documento($tipo_docu)); ?></li>
                        </ul>
                        <ul id="limpiarComprobante" class="lista_botones">
                            <li id="limpiar">Limpiar</li>
                        </ul>
                        <ul id="buscarComprobante" class="lista_botones">
                            <li id="buscar">Buscar</li>
                        </ul>
                    </div>
                    <div id="lineaResultado">
                        <table class="fuente7" width="100%" cellspacing="0" cellpadding="3" border="0">
                            <tr>
                                <td width="50%" align="left">N de <?php echo $CI->obtener_tipo_documento($tipo_docu); ?>
                                    s encontrados:&nbsp;<?php echo $registros; ?> </td>
                        </table>
                    </div>
                </div>
                <div id="cabeceraResultado" class="header"><?php echo $titulo_tabla;; ?></div>
                <div id="frmResultado">
                    <table class="fuente8" width="100%" cellspacing="0" cellpadding="3" border="0" ID="Table1">
                        <tr class="cabeceraTabla">
                            <td width="4%">ITEM</td>
                            <td width="5%">FECHA</td>
                            <td width="5%">SERIE</td>
                            <td width="6%">NUMERO</td>
                            <td width="25%">RAZON SOCIAL</td>
                            <td>CARGA</td>
                            <td>Doc. Origen</td>
                            <td>Doc. Destino</td>
                            <td width="9%">TOTAL</td>
                            <td width="4%">ESTADO</td>
                            <td width="4%">&nbsp;</td>
                            <td width="4%">&nbsp;</td>
                            <?php if ($tipo_oper == 'V') { ?>
                                <td width="4%">&nbsp;</td>
                            <?php } ?>
                            <td width="4%">USUARIO</td>
                        </tr>
                        <?php
                        if (count($lista) > 0) {
                            foreach ($lista as $indice => $valor) {
                                $class = $indice % 2 == 0 ? 'itemParTabla' : 'itemImparTabla';
                                ?>
                                <tr class="<?php echo $class; ?>">
                                    <td>
                                        <div align="center"><?php echo $valor[0]; ?></div>
                                    </td>
                                    <td>
                                        <div align="center"><?php echo $valor[1]; ?></div>
                                    </td>
                                    <td>
                                        <div align="center"><?php echo $valor[2]; ?></div>
                                    </td>
                                    <td>
                                        <div align="center"><?php echo $valor[3]; ?></div>
                                    </td>

                                    <td>
                                        <div align="center"><?php echo $valor[6]; ?></div>
                                    </td>
                                    <td>
                                        <div>
                                            <?php echo $valor[12]; ?>
                                        </div>
                                    </td>
                                    <td align="center" >
                                        <div>
                                            <?php
                                            $title = "";
                                            if ($valor[13] == 'F') {
                                                $title = "[Factura] " . $valor[17];
                                            } else if ($valor[13] == 'B') {
                                                $title = "[Boleta] " . $valor[17];
                                            } else if ($valor[13] == 'N') {
                                                $title = "[Comprobante] " . $valor[17];
                                            } else {
                                                $title = "[Independiente] " . $valor[17];
                                            }

                                            ?>
                                            <span
                                                style="font-weight: bold; font-size: 12px; text-space: 1; color: #ff1c26"><?php echo "[" . $valor[13] . '] '; ?></span>
                                            <a href="#"
                                               onclick="comprobante_ver_pdf_conmenbrete('1',<?php echo $valor[19]; ?>)"
                                               title="<?php echo $title; ?>">
                                                <!-- AGREGAR MAS ADELANTE UN FANCY PARA VISUALIZAR EL COMPROBANTE -->
                                                <?php echo $valor[17]; ?>
                                            </a>
                                        </div>
                                    </td>
                                    <td align="center" >
                                        <div>
                                            <?php
                                            if ($valor[15] != "") {
                                                $title = "";
                                                if ($valor[13] == 'F') {
                                                    $title = "[Factura] " . $valor[18];
                                                } else if ($valor[13] == 'B') {
                                                    $title = "[Boleta] " . $valor[18];
                                                } else if ($valor[13] == 'N') {
                                                    $title = "[Comprobante] " . $valor[18];
                                                }

                                                ?>
                                                <span
                                                    style="font-weight: bold; font-size: 12px; text-space: 1; color: #ff1c26"><?php echo "[" . $valor[15] . '] '; ?></span>
                                                <a href="#"
                                                   onclick="comprobante_ver_pdf_conmenbrete('1',<?php echo $valor[19]; ?>)"
                                                   title="<?php echo $title; ?>">
                                                    <!-- AGREGAR MAS ADELANTE UN FANCY PARA VISUALIZAR EL COMPROBANTE -->
                                                    <?php echo $valor[18]; ?>
                                                </a>
                                            <?php }else{
                                                echo "-------";
                                            } ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div align="center"><?php echo $valor[7]; ?></div>
                                    </td>
                                    <td>
                                        <div align="center"><?php echo $valor[8]; ?></div>
                                    </td>
                                    <td>
                                        <div align="center"><?php echo $valor[9]; ?></div>
                                    </td>
                                    <?php if ($tipo_oper == 'V') { // Solo cuando es venta se muestra el imprimir ?>
                                        <td>
                                            <div align="center"><?php echo $valor[10]; ?></div>
                                        </td>
                                    <?php } ?>
                                    <td>
                                        <div align="center"><?php echo $valor[11]; ?></div>
                                    </td>
                                    <td>
                                        <div align="center"><?php echo $valor[20]; ?></div>
                                    </td>
                                </tr>
                            <?php
                            }
                        } else {
                            ?>
                            <table width="100%" cellspacing="0" cellpadding="3" border="0" class="fuente8">
                                <tbody>
                                <tr>
                                    <td width="100%" class="mensaje">No hay ning&uacute;n registro que cumpla con los
                                        criterios de b&uacute;squeda
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        <?php
                        }
                        ?>
                    </table>
                </div>
                <div style="margin-top: 15px;"><?php echo $paginacion; ?></div>
                <input type="hidden" id="iniciopagina" name="iniciopagina">
                <?php echo $oculto ?>
            </form>
        </div>
    </div>
</div>
</body>
</html>