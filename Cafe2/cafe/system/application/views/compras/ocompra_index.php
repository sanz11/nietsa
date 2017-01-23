<script type="text/javascript" src="<?php echo base_url(); ?>js/compras/ocompra.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>js/fancybox/jquery.fancybox-1.3.4.css"
      media="screen"/>
<script type="text/javascript">
    $(document).ready(function () {
        $("a#linkVerProveedor").fancybox({
            'width': 700,
            'height': 450,
            'autoScale': false,
            'transitionIn': 'none',
            'transitionOut': 'none',
            'showCloseButton': false,
            'modal': true,
            'type': 'iframe'
        });

        $("a#linkVerProducto").fancybox({
            'width': 800,
            'height': 650,
            'autoScale': false,
            'transitionIn': 'none',
            'transitionOut': 'none',
            'showCloseButton': false,
            'modal': true,
            'type': 'iframe'
        });

        /*//agregado autocompletar gcbq
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
                $("#producto").val(ui.item.codigo);
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
                $("#buscar_cliente").val(ui.item.ruc);
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
                $("#buscar_proveedor").val(ui.item.ruc);
                $("#proveedor").val(ui.item.codigo);
                $("#ruc_proveedor").val(ui.item.ruc);
            },

            minLength: 2

        });*/

        /////////////////

    });
    function seleccionar_producto(codigo, interno, familia, stock, costo) {
        $("#producto").val(codigo);
        $("#codproducto").val(interno);
        $("#cantidad").focus();
        obtener_nombre_producto(codigo);
    }
    function obtener_nombre_producto(producto) {
        base_url = $("#base_url").val();
        url = base_url + "index.php/almacen/producto/listar_unidad_medida_producto/" + producto;
        $.getJSON(url, function (data) {
            $.each(data, function (i, item) {
                nombre_producto = item.PROD_Nombre;
            });
            $("#nombre_producto").val(nombre_producto);
        });
    }
    function seleccionar_proveedor(codigo, ruc, razon_social, empresa, persona) {
        $("#proveedor").val(codigo);
        $("#ruc_proveedor").val(ruc);
        $("#nombre_proveedor").val(razon_social);
    }
</script>
<div id="pagina">
    <div id="zonaContenido">
        <div align="center">
            <div id="tituloForm" class="header"><?php echo $titulo_busqueda; ?></div>
            <div id="frmBusqueda">
                <form id="form_busqueda" name="form_busqueda" method="post"
                      action="<?php echo base_url(); ?>index.php/compras/ocompra/buscar/<?php echo $tipo_oper; ?>">
                    <table class="fuente8" width="98%" cellspacing="0" cellpadding="3" border="0">
                        <tr>
                            <td align='left' width="15%">Fecha inicial</td>
                            <td align='left' width="15%">
                                <?php echo $fechai ?>
                                <img src="<?php echo base_url(); ?>images/calendario.png" name="Calendario1"
                                     id="Calendario1" width="16" height="16" border="0"
                                     onMouseOver="this.style.cursor='pointer'" title="Calendario"/>
                                <script type="text/javascript">
                                    Calendar.setup({
                                        inputField: "fechai",      // id del campo de texto
                                        ifFormat: "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
                                        button: "Calendario1"   // el id del botón que lanzará el calendario
                                    });
                                </script>
                            </td>
                            <td align='left' width="10%">Fecha final</td>
                            <td align='left' width="60%">
                                <?php echo $fechaf ?>
                                <img src="<?php echo base_url(); ?>images/calendario.png" name="Calendario2"
                                     id="Calendario2" width="16" height="16" border="0"
                                     onMouseOver="this.style.cursor='pointer'" title="Calendario2"/>
                                <script type="text/javascript">
                                    Calendar.setup({
                                        inputField: "fechaf",      // id del campo de texto
                                        ifFormat: "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
                                        button: "Calendario2"   // el id del botón que lanzará el calendario
                                    });
                                </script>
                            </td>
                        </tr>
                        <tr>
                            <?php if ($tipo_oper == 'V') { ?>
                                <td align='left'>Cliente</td>
                                <td align='left' colspan="3">
                                    <input type="hidden" name="cliente" id="cliente" size="5"/>
                                    <input type="text" name="ruc_cliente" class="cajaGeneral" id="ruc_cliente" size="10"
                                           placeholder="Ruc o DNI"
                                           maxlength="11"
                                           onkeypress="return numbersonly(this, event, '.');" />
                                    <input type="text" name="nombre_cliente" class="cajaGrande"
                                           placeholder="Nombre cliente"
                                           id="nombre_cliente" size="40" />
                                    <!--<a href="<?php echo base_url(); ?>index.php/ventas/cliente/ventana_busqueda_cliente/"
                                       id="linkVerCliente"><img height='16' width='16'
                                                                src='<?php echo base_url(); ?>/images/ver.png'
                                                                title='Buscar' border='0'/></a>-->
                                </td>
                            <?php } else { ?>
                                <td align='left'>Proveedor</td>
                                <td align='left' colspan="3">
                                    <input type="hidden" name="proveedor" id="proveedor" size="5"/>
                                    <input type="text" name="ruc_proveedor" class="cajaGeneral" id="ruc_proveedor"
                                           placeholder="Ruc"  onfinishinput="busqueda_ocompra();"
                                           size="10" maxlength="11"
                                           onkeypress="return numbersonly(this, event, '.');" />
                                    <input type="text" name="nombre_proveedor" class="cajaGrande"
                                           placeholder="Nombre proveedor"
                                           id="nombre_proveedor" size="40"/>
                                    <a href="<?php echo base_url(); ?>index.php/compras/proveedor/ventana_busqueda_proveedor/"
                                       id="linkVerProveedor"><img height='16' width='16'
                                                                  src='<?php echo base_url(); ?>/images/ver.png'
                                                                  title='Buscar' border='0'/></a>
                                </td>
                            <?php } ?>

                        </tr>
<!--                        <tr>
                            <td>Art&iacute;culo</td>
                            <td colspan="3">
                                <input name="compania" type="hidden" id="compania" value="<?php echo $compania; ?>">
                                <input name="producto" type="hidden" class="cajaPequena" id="producto" size="10"
                                       maxlength="11"/>
                                <input name="codproducto" type="text" class="cajaGeneral" id="codproducto" size="10"
                                       placeholder="Codigo pro."
                                       maxlength="20" onblur="obtener_producto();" readonly="readonly"/>
                                <input name="buscar_producto" type="hidden" class="cajaGeneral" id="buscar_producto"
                                       size="40"/>
                                <input name="nombre_producto" type="text" class="cajaGrande cajaSoloLectura"
                                       placeholder="Nombre producto"
                                       id="nombre_producto" size="40"/>
                                <a href="<?php echo base_url(); ?>index.php/almacen/producto/ventana_busqueda_producto/"
                                   id="linkVerProducto"><img height='16' width='16'
                                                             src='<?php echo base_url(); ?>/images/ver.png'
                                                             title='Buscar' border='0'/></a>
                            </td>
                        </tr>-->
                        <tr>
                            <td>Aprobación</td>
                            <td colspan="3">
                                <select name="aprobado" id="aprobado" class="comboMedio">
                                    <option value="" selected="selected">::Seleccione::</option>
                                    <option value="1">Aprobado</option>
                                    <option value="2">Desaprobado</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Verificación de ingreso</td>
                            <td colspan="3">
                                <select name="ingreso" id="ingreso" class="comboMedio">
                                    <option value="" selected="selected">::Seleccione::</option>
                                    <option value="1">Pendiente</option>
                                    <option value="2">Cangando</option>
                                    <option value="3">Terminado</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
            <div id="cargarBusqueda" >
                <div class="acciones">
                    <div id="botonBusqueda">
                       <ul id="visualizarSunat" class="lista_botones">
                        <li id="sunat">Consulta Ruc</li>
                    </ul>
                        <?php
                        if ($evalua) {
                            ?>
                            <ul id="nuevoOcompa" class="lista_botones">
                                <li id="nuevo" style="background-position:44px 4px;width:120px;">Nueva O.
                                    de <?php if ($tipo_oper == 'V') echo 'Venta'; else echo 'Compra'; ?></li>
                            </ul>
                        <?php
                        }
                        ?>
                        <ul id="limpiarOcompra" class="lista_botones">
                            <li id="limpiar" style="background-position:44px 4px;width:90px;">Limpiar</li>
                        </ul>
                        <ul id="buscarOcompra" class="lista_botones">
                            <li id="buscar" style="background-position:44px 4px;width:90px;">Buscar</li>
                        </ul>
                        <?php if ($evalua == true) { ?>
                            <ul id="desaprobarOcompra" class="lista_botones">
                                <li id="desaprobar" style="background-position:44px 4px;width:90px;">Desaprobar</li>
                            </ul>
                            <ul id="aprobarOcompra" class="lista_botones">
                                <li id="aprobar" style="background-position:44px 4px;width:90px;">Aprobar</li>
                            </ul>
                        <?php } ?>
                    </div>
                    <div id="lineaResultado">
                        <table class="fuente7" width="100%" cellspacing="0" cellpadding="3" border="0">
                            <tr>
                                <td width="50%" align="left">N de ordenes
                                    de <?php if ($tipo_oper == 'V') echo 'venta'; else echo 'compra'; ?>
                                    encontrados:&nbsp;<?php echo $registros; ?> </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div id="cabeceraResultado" class="header"><?php echo $titulo_tabla; ?></div>
                <div id="frmResultado">
                    <form id="frmEvaluar" name="frmEvaluar" method="post"
                          action="<?php echo base_url(); ?>index.php/compras/ocompra/evaluar_ocompra/">
                        <input type="hidden" value="" id="flag" name="flag"/>
                        <table class="fuente8" width="100%" cellspacing="0" cellpadding="3" border="0" ID="Table1">
                            <tr class="cabeceraTabla">
                                <td width="3%"><?php if ($evalua == true) echo "<input type='checkbox' name='checkTodos' id='checkTodos' value='1'>"; ?></td>
                                <td width="3%">ITEM</td>
                                <td width="7%">FECHA</td>
                                <td width="5%">NUMERO</td>
                                <td width="5%">PRESUPUESTO</td>
                                <td width="31%">RAZON SOCIAL</td>
                                <td width="7%">C.INGRESO</td>
                                <td width="9%">TOTAL</td>
                                <td width="4%">ESTADO</td>
                                <td width="4%">&nbsp;</td>
                                <td width="4%">&nbsp;</td>
                                <td width="4%">&nbsp;</td>
                                <td width="4%">&nbsp;</td>
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
                                            <div align="left"><?php echo $valor[2]; ?></div>
                                        </td>
                                        <td>
                                            <div align="center"><?php echo $valor[3]; ?></div>
                                        </td>
                                        <td>
                                            <div align="center"><?php echo $valor[4]; ?></div>
                                        </td>
                                        <td>
                                            <div align="center"><?php echo $valor[6]; ?></div>
                                        </td>
                                        <td>
                                            <div align="center"><?php echo $valor[7]; ?></div>
                                        </td>
                                        <td>
                                            <div align="right"><?php echo $valor[8]; ?></div>
                                        </td>
                                        <td>
                                            <div align="center">
                                                <?php
                                                echo $valor[10];
                                                ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div align="center"><?php //echo $valor[11];
                                                ?></div>
                                        </td>
                                        <td>
                                            <div align="center"><?php echo $valor[12]; ?></div>
                                        </td>
                                        <td>
                                            <div align="center"><?php echo $valor[13]; ?></div>
                                        </td>
                                        <td>
                                            <div align="center"><?php echo $valor[14]; ?></div>
                                        </td>
                                    </tr>
                                <?php
                                }
                            } else {
                                ?>
                                <table width="100%" cellspacing="0" cellpadding="3" border="0" class="fuente8">
                                    <tbody>
                                    <tr>
                                        <td width="100%" class="mensaje">No hay ning&uacute;n registro que cumpla con
                                            los
                                            criterios de b&uacute;squeda
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            <?php
                            }
                            ?>





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
                    </form>
                </div>
                <div style="margin-top: 15px;"><?php echo $paginacion; ?></div>
            </div>
            <?php echo $oculto ?>
        </div>
        <div id="cargando_datos" style="display: none;position: absolute;
                     width: 100%; height: 100%; left: 0; top: 0px;
                     z-index: 9999">
            <div align="center" style="background: #FFF;
                         z-index: 9999;
                         position: relative;
                         top: 40%; margin: 0 auto; width: 140px; height: 32px;padding: 30px 40px; border: 1px solid #cccccc;"
                 class="fuente8">
                <b>ESPERE POR FAVOR...</b><br>
                <img src="<?php echo base_url() ?>images/cargando.gif" border='0'/>
            </div>
        </div>
    </div>
</div>