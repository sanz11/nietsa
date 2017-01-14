<script>
    $(document).ready(function () {
        base_url  = $('#base_url').val();
        flagBS  = $('#flagBS').val();
        $('#buscarProducto').click(function () {
            activarBusqueda();
        });
    });
    $("#nuevoProducto").click(function(){
        url = base_url+"index.php/almacen/producto/nuevo_producto/"+flagBS;
        location.href = url;
    });
    $("#limpiarProducto").click(function(){
        url = base_url+"index.php/almacen/producto/productos/"+flagBS;
        location.href=url;
    });
    function activarBusqueda() {
        var url = $('#form_busqueda').attr('action');
        var dataString = $('#form_busqueda').serialize();
        var flagBS = $('#flagBS').val();
        $.ajax({
            type: "POST",
            url: url,
            data: dataString,
            beforeSend: function (data) {
                $('#cargando_datos').show();
            },
            success: function (data) {
                $('#cargando_datos').hide();
                $('#cuerpoPagina').html(data);
            },
            error: function (HXR, error) {
                $('#cargando_datos').hide();
                console.log('errrorrr');
            }
        });
    }
</script>

<div id="cuerpoPagina" >
    <form id="frmpublicar" name="frmpublicar" method="post" enctype="multipart/form-data" action="">
        <div class="acciones">
            <div id="botonBusqueda">
                <ul id="imprimirProducto" class="lista_botones">
                    <li id="imprimir">Imprimir</li>
                </ul>
                <ul id="nuevoProducto" class="lista_botones">
                    <li id="nuevo">
                        Nuevo <?php if ($flagBS == 'B') echo 'Artículo'; else echo 'Servicio'; ?></li>
                </ul>
                <ul id="limpiarProducto" class="lista_botones">
                    <li id="limpiar">Limpiar</li>
                </ul>
                <ul id="buscarProducto" class="lista_botones">
                    <li id="buscar">Buscar</li>
                </ul>
                <ul id="buscarProducto2" class="lista_botones" style="display: none;">
                    <li id="buscar">Buscar2</li>
                </ul>

            </div>
            <div id="lineaResultado">
                <table class="fuente7" width="100%" cellspacing=0 cellpadding=3 border=0>
                    <tr>
                        <td width="50%" align="left">N de productos
                            encontrados:&nbsp;<?php echo $registros; ?> </td>
                </table>
            </div>
        </div>
        <a id='ingresar_series' class='fancybox'
           href='"<?php echo base_url(); ?>"index.php/almacen/producto/ventana_nueva_serie/'></a>

        <div id="cabeceraResultado" class="header"><?php
            echo $titulo_tabla;
            ?></div>
        <div id="frmResultado">

            <table class="fuente8" width="100%" cellspacing="0" cellpadding="3" border="0" ID="Table1">
                <tr class="cabeceraTabla">
                    <td width="3%">ITEM</td>

                    <td width="5%" align='center'>&nbsp;CODIGO&nbsp;&nbsp;&nbsp;</td>
                    <td>DESCRIPCION&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <?php if (FORMATO_IMPRESION != 4) { ?>
                        <td width="30%">FAMILIA</td><?php } ?>
                    <?php if ($flagBS == 'B') { ?>

                        <td width="15%">MARCA</td>
                        <?php if (FORMATO_IMPRESION == 4) { ?>
                            <td width="5%">P. VENTA</td><?php } ?>
                        <?php if (FORMATO_IMPRESION == 4) { ?>
                            <td width="5%">P. COSTO</td><?php } ?>
                    <?php } ?>
                    <td width="5%">ESTADO</td>
                    <td width="3%">&nbsp;</td>
                    <td width="3%">&nbsp;</td>

                    <!--<td width="3%">E.T</td>-->
                    <td width="3%">&nbsp;</td>
                    <td width="3%">&nbsp;</td>
                </tr>
                <?php
                if (count($lista) > 0) {
                    foreach ($lista as $indice => $valor) {
                        $class = $indice % 2 == 0 ? 'itemParTabla' : 'itemImparTabla';
                        ?>
                        <tr class="<?php echo $class; ?>">
                            <td><?php echo $valor[16]; ?>
                                <div align="center"><?php echo $valor[0]; ?></div>
                            </td>


                            <td>
                                <div
                                    align="center"><?php if ($valor[1] != '') echo str_pad($valor[1], "3", "0", STR_PAD_LEFT); ?></div>
                            </td>
                            <td>
                                <div align="left"><?php echo $valor[2]; ?></div>
                            </td>
                            <?php if (FORMATO_IMPRESION != 4) { ?>
                                <td>
                                <div align="left"><?php echo $valor[3]; ?></div></td><?php } ?>
                            <?php if ($flagBS == 'B') { ?>

                                <td>
                                    <div align="center"><?php echo $valor[5]; ?></div>
                                </td>
                                <?php if (FORMATO_IMPRESION == 4) { ?>
                                    <td>
                                    <div
                                        align="right"><?php if ($valor[6] != 0 && $valor[6] != '') echo number_format($valor[6], 2); ?></div>
                                    </td><?php } ?>
                                <?php if (FORMATO_IMPRESION == 4) { ?>
                                    <td>
                                    <div
                                        align="right"><?php if ($valor[7] != 0 && $valor[6] != '') echo number_format($valor[7], 2); ?></div>
                                    </td><?php } ?>
                            <?php } ?>
                            <td>
                                <div align="center"><?php echo $valor[8]; ?></div>
                            </td>
                            <td>
                                <div align="center"><?php echo $valor[9]; ?></div>
                            </td>
                            <td>
                                <div align="center"><?php echo $valor[15]; ?></div>
                            </td>
                            <!--<td>
                                <div align="center"><?php echo $valor[17]; ?></div>
                            </td>-->
                            <td>
                                <div align="center"><?php echo $valor[11]; ?></div>
                            </td>

                            <td>
                                <div align="center"><?php echo $valor[12]; ?></div>
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
        <input type="hidden" id="cadena_busqueda" name="cadena_busqueda">
        <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url(); ?>"/>
        <input type="hidden" name="flagBS" id="flagBS" value="<?php echo $flagBS; ?>"/>

    </form>
</div>