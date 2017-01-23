<script type="text/javascript" src="<?php echo base_url(); ?>js/almacen/guiarem.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/funciones.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>js/fancybox/jquery.fancybox-1.3.4.css"
      media="screen"/>
<script language="javascript">
    $(document).ready(function () {
        $("a#linkVerCliente, a#linkVerProveedor, a#linkVerProducto").fancybox({
            'width': 700,
            'height': 450,
            'autoScale': false,
            'transitionIn': 'none',
            'transitionOut': 'none',
            'showCloseButton': true,
            'modal': true,
            'type': 'iframe'
        });
        
        $("a#ocompra, a#comprobante").fancybox({
            'width': 800,
            'height': 500,
            'autoScale': false,
            'transitionIn': 'none',
            'transitionOut': 'none',
            'showCloseButton': true,
            'modal': false,
            'type': 'iframe'
        });

        //agregado autocompletar gcbq
        $("#nombre_producto").autocomplete({

            source: function (request, response) {

                $.ajax({
                    //contiene flagbs-bien o servicio
                    //url: "<?php echo base_url(); ?>index.php/almacen/producto/autocomplete/"+$("#flagBS").val()+"/"+$("#compania").val(),

                    url: "<?php echo base_url(); ?>index.php/almacen/producto/autocomplete/B/" + $("#compania").val(),
                    type: "POST",
                    data: {term: $("#nombre_producto").val()},
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
            },

            minLength: 2

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

        /////////////////7
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

    function relacionado_comprobante(numero){
        alert('Guia de remision relacionada con el numero ' + numero);
    }

</script>
<div id="pagina">
    <div id="zonaContenido">
        <div align="center">
            <div id="tituloForm" class="header"><?php echo $titulo_busqueda; ?></div>
            <div id="frmBusqueda">
                <form id="form_busqueda" name="form_busqueda" method="post" action="<?php echo $accion; ?>">
                    <table class="fuente8" width="98%" cellspacing="0" cellpadding="3" border="0">
                        <tr>
                            <td align='left' width="10%">Fecha inicial</td>
                            <td align='left' width="90%">
                                <input name="fechai" id="fechai" value="" type="text" class="cajaGeneral" size="10"
                                       maxlength="10"/>
                                <img src="<?php echo base_url(); ?>images/calendario.png" name="Calendario1"
                                     id="Calendario1" width="16" height="16" border="0"
                                     onMouseOver="this.style.cursor='pointer'" title="Calendario"/>
                                <script type="text/javascript">
                                    Calendar.setup({
                                        inputField: "fechai",      // id del campo de texto
                                        ifFormat: "%d/%m/%Y",       // formato de la fecha, cuando se escriba en el campo de texto
                                        button: "Calendario1"   // el id del botÃ³n que lanzarÃ¡ el calendario
                                    });
                                </script>
                                <label style="margin-left: 90px;">Fecha final</label>
                                <input name="fechaf" id="fechaf" value="" type="text" class="cajaGeneral" size="10"
                                       maxlength="10"/>
                                <img src="<?php echo base_url(); ?>images/calendario.png" name="Calendario2"
                                     id="Calendario2" width="16" height="16" border="0"
                                     onMouseOver="this.style.cursor='pointer'" title="Calendario2"/>
                                <script type="text/javascript">
                                    Calendar.setup({
                                        inputField: "fechaf",      // id del campo de texto
                                        ifFormat: "%d/%m/%Y",       // formato de la fecha, cuando se escriba en el campo de texto
                                        button: "Calendario2"   // el id del botÃ³n que lanzarÃ¡ el calendario
                                    });
                                </script>
                            </td>
                        </tr>
                        <tr>
                            <td align='left'>NÃºmero</td>
                            <td align='left'><input type="text" name="serie" id="serie" value="" class="cajaGeneral"
                                                    size="3" maxlength="3" placeholder="Serie"/>
                                <input type="text" name="numero" id="numero" value="" class="cajaGeneral" size="10"
                                       maxlength="6" placeholder="Numero"/>
                            </td>
                        </tr>
                        <tr>
                            <?php if ($tipo_oper == 'V') { ?>
                                <td align='left'>Cliente</td>
                                <td align='left'>
                                    <input type="hidden" name="cliente" value="" id="cliente" size="5"/>
                                    <input type="text" name="ruc_cliente" value="" class="cajaGeneral" id="ruc_cliente"
                                           size="10" maxlength="11" onblur="obtener_cliente();"
                                           onkeypress="return numbersonly(this,event,'.');" readonly="readonly"
                                           placeholder="Ruc"/>
                                    <input type="text" name="nombre_cliente" value="" class="cajaGrande cajaSoloLectura"
                                           id="nombre_cliente" size="40" placeholder="Nombre cliente"/>
                                    <a href="<?php echo base_url(); ?>index.php/ventas/cliente/ventana_busqueda_cliente/"
                                       id="linkVerCliente"><img height='16' width='16'
                                                                src='<?php echo base_url(); ?>/images/ver.png'
                                                                title='Buscar' border='0'/></a>
                                </td>
                            <?php } else { ?>
                                <td align='left'>Proveedor</td>
                                <td align='left'>
                                    <input type="hidden" name="proveedor" value="" id="proveedor" size="5"/>
<input type="text" name="ruc_proveedor" value="" class="cajaGeneral"
                                           id="ruc_proveedor" size="10" maxlength="11" onblur="obtener_proveedor();"
                                           onkeypress="return numbersonly(this,event,'.');" readonly="readonly"
                                           placeholder="Ruc"/>
<input type="text" name="nombre_proveedor" value=""
                                           class="cajaGrande cajaSoloLectura" id="nombre_proveedor" size="40"
                                           placeholder="Nombre proveedor"/>
<a href="<?php echo base_url(); ?>index.php/compras/proveedor/ventana_busqueda_proveedor/" id="linkVerProveedor">
<img height='16' width='16' src='<?php echo base_url(); ?>/images/ver.png'
         title='Buscar' border='0'/></a>
                                </td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <td align='left'>ArtÃ­culo</td>
                            <td align='left'>
                                <input name="compania" type="hidden" id="compania" value="">
                                <input name="producto" type="hidden" class="cajaPequena" id="producto" size="10"
                                       maxlength="11"/>
                                <input name="codproducto" type="text" class="cajaGeneral" id="codproducto" value=""
                                       size="10" maxlength="20" onblur="obtener_producto();" readonly="readonly"
                                       placeholder="Codigo"/>
                                <input name="buscar_producto" type="hidden" class="cajaGeneral" id="buscar_producto"
                                       size="40"/>
                                <input name="nombre_producto" type="text" value="" class="cajaGrande cajaSoloLectura"
                                       id="nombre_producto" size="40" placeholder="Nombre producto"/>
                                <a href="<?php echo base_url(); ?>index.php/almacen/producto/ventana_busqueda_producto/"
                                   id="linkVerProducto"><img height='16' width='16'
                                                             src='<?php echo base_url(); ?>/images/ver.png'
                                                             title='Buscar' border='0'/></a>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
            <div class="acciones">
                <div id="botonBusqueda">
                    <ul id="visualizarSunat" class="lista_botones">
                        <li id="sunat">Consulta Ruc</li>
                    </ul>
                    <ul id="nuevaGuiarem" class="lista_botones">
                        <li id="nuevo">Nueva G. de RemisiÃ³n</li>
                    </ul>
                    <ul id="limpiarGuiarem" class="lista_botones">
                        <li id="limpiar">Limpiar</li>
                    </ul>
                    <ul id="buscarGuiarem" class="lista_botones">
                        <li id="buscar">Buscar</li>
                    </ul>
                </div>
                <div id="lineaResultado">
                    <table class="fuente7" width="100%" cellspacing=0 cellpadding=3 border=0>
                        <tr>
                            <td width="50%" align="left">N de guias de remision
                                encontrados:&nbsp;<?php echo $cantidad; ?> </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div id="cabeceraResultado" class="header"><?php echo $titulo_tabla; ?></div>
            <div id="frmResultado">
                <table class="fuente8" width="100%" cellspacing="0" cellpadding="3" border="0" ID="Table1">
                    <tr class="cabeceraTabla">
                        <td width="5%">ITEM</td>
                        <td width="9%">FECHA</td>
                        <td width="3%">SERIE</td>
                        <td width="5%">NUMERO</td>
                        <td width="39%">RAZON SOCIAL</td>
                        <td width="10%">BOLETA</td>
                        <td width="10%">FACTURA</td>
                        <td width="10%">O. C.</td>
                        <td width="5%">ESTADO</td>
                        <td width="5%">&nbsp;</td>
                        <td width="5%">&nbsp;</td>
                        <td width="5%">&nbsp;</td>
                        <td width="5%">&nbsp;</td>
                        <td width="5%">&nbsp;</td>
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
                                    <div align="left"><?php echo $valor[6]; ?></div>
                                </td>
                                <td>
                                <!--No  visualiza la factura-->
                                    <div align="center"><?php echo $valor[14]; ?></div>
                                </td>
                                
                                <td>
                                <!--NO visualiza la guia de remision-->
                                    <div align="center"><?php echo $valor[13]; ?></div>
                                </td>
                                <td>
                                    <div align="center"><?php echo $valor[12]; ?></div>
                                </td>
                                <td>
                                    <div align="center"><?php echo $valor[16]; ?></div>
                                </td>
                                <td>
                                    <div align="center"><?php echo $valor[11]; ?></div>
                                </td>
                                <td>
                                    <div align="center"><?php echo $valor[8]; ?></div>
                                </td>
                                <td>
                                    <div align="center"><?php echo $valor[9]; ?></div>
                                </td>
                                <td>
                                    <div align="center"><?php echo $valor[10]; ?></div>
                                </td>
                                <td>
                                    <div align="center"><?php echo $valor[15]; ?></div>
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
                    <tr height="28" class="itemImparTabla">
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="left"></div>
                        </td>
                        <td>
                            <div align="left"></div>
                        </td>
                        <td>
                            <div align="left"></div>
                        </td>
                        <td>
                            <div align="right"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                    </tr>


                    <tr height="28" class="itemParTabla">
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="left"></div>
                        </td>
                        <td>
                            <div align="left"></div>
                        </td>
                        <td>
                            <div align="left"></div>
                        </td>
                        <td>
                            <div align="right"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                    </tr>

                    <tr height="28" class="itemImparTabla">
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="left"></div>
                        </td>
                        <td>
                            <div align="left"></div>
                        </td>
                        <td>
                            <div align="left"></div>
                        </td>
                        <td>
                            <div align="right"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                    </tr>


                    <tr height="28" class="itemParTabla">
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="left"></div>
                        </td>
                        <td>
                            <div align="left"></div>
                        </td>
                        <td>
                            <div align="left"></div>
                        </td>
                        <td>
                            <div align="right"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                    </tr>

                    <tr height="28" class="itemImparTabla">
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="left"></div>
                        </td>
                        <td>
                            <div align="left"></div>
                        </td>
                        <td>
                            <div align="left"></div>
                        </td>
                        <td>
                            <div align="right"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                    </tr>


                    <tr height="28" class="itemParTabla">
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="left"></div>
                        </td>
                        <td>
                            <div align="left"></div>
                        </td>
                        <td>
                            <div align="left"></div>
                        </td>
                        <td>
                            <div align="right"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                    </tr>

                    <tr height="28" class="itemImparTabla">
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="left"></div>
                        </td>
                        <td>
                            <div align="left"></div>
                        </td>
                        <td>
                            <div align="left"></div>
                        </td>
                        <td>
                            <div align="right"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                    </tr>


                    <tr height="28" class="itemParTabla">
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="left"></div>
                        </td>
                        <td>
                            <div align="left"></div>
                        </td>
                        <td>
                            <div align="left"></div>
                        </td>
                        <td>
                            <div align="right"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                    </tr>

                    <tr height="28" class="itemImparTabla">
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="left"></div>
                        </td>
                        <td>
                            <div align="left"></div>
                        </td>
                        <td>
                            <div align="left"></div>
                        </td>
                        <td>
                            <div align="right"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                    </tr>


                    <tr height="28" class="itemParTabla">
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="left"></div>
                        </td>
                        <td>
                            <div align="left"></div>
                        </td>
                        <td>
                            <div align="left"></div>
                        </td>
                        <td>
                            <div align="right"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                    </tr>

                    <tr height="28" class="itemImparTabla">
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="left"></div>
                        </td>
                        <td>
                            <div align="left"></div>
                        </td>
                        <td>
                            <div align="left"></div>
                        </td>
                        <td>
                            <div align="right"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                    </tr>


                    <tr height="28" class="itemParTabla">
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="left"></div>
                        </td>
                        <td>
                            <div align="left"></div>
                        </td>
                        <td>
                            <div align="left"></div>
                        </td>
                        <td>
                            <div align="right"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                    </tr>

                    <tr height="28" class="itemImparTabla">
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="left"></div>
                        </td>
                        <td>
                            <div align="left"></div>
                        </td>
                        <td>
                            <div align="left"></div>
                        </td>
                        <td>
                            <div align="right"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"></div>
                        </td>
                    </tr>


                </table>
            </div>
            <div style="margin-top: 15px;"><?php echo $paginacion; ?></div>
            <input type="hidden" id="iniciopagina" name="iniciopagina">
            <input type="hidden" id="cadena_busqueda" name="cadena_busqueda">
            <?php echo $oculto ?>
        </div>
    </div>
</div>