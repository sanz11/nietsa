<html>
<head>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/almacen/producto.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>js/fancybox/jquery.fancybox-1.3.4.css"
          media="screen"/>
    <style>
        .busqueda_opcinal{
            position: relative;
            text-align: center;
        }

        .busqueda_opcinal_1{
            position: absolute;
            background-color: #004488;
            color: #f1f4f8;
            width: 98px;
            height: 70px;
            top: 14px;
            left: 135px;
            -webkit-box-shadow: 0px 0px 0px 3px rgba(47, 50, 50, 0.34);
            -moz-box-shadow:    0px 0px 0px 3px rgba(47, 50, 50, 0.34);
            box-shadow:         0px 0px 0px 3px rgba(47, 50, 50, 0.34);
            cursor: pointer;
        }

        .control_1 .seleccionado{
            position: absolute;
            border-radius: 3px;
            background-color: #29fb00;
            width: 98px;
            height: 5px;
            bottom: 20px;
            left: 135px;
        }

        .busqueda_opcinal_2{
            position: absolute;
            background: #109EC8;
            color: #f1f4f8;
            width: 95px;
            height: 70px;
            top: 14px;
            right: 102px;
            cursor: pointer;
            -webkit-box-shadow: 0px 0px 0px 3px rgba(47, 50, 50, 0.34);
            -moz-box-shadow:    0px 0px 0px 3px rgba(47, 50, 50, 0.34);
            box-shadow:         0px 0px 0px 3px rgba(47, 50, 50, 0.34);
        }

        .control_2 .seleccionado{
            position: absolute;
            border-radius: 3px;
            background-color: #ab1c27;
            width: 96px;
            height: 5px;
            bottom: 21px;
            right: 102px;
        }
    </style>
    <script language="javascript" >
        var cursor;
        if (document.all) {
            // Está utilizando EXPLORER
            cursor = 'hand';
        } else {
            // Está utilizando MOZILLA/NETSCAPE
            cursor = 'pointer';
        }

        $(document).ready(function () {

            $('#busqueda_1').click(function(){
                var seleccionado = Number($('#seleccionado_1').val());
                if(seleccionado == 0){
                    $('.control_1 .seleccionado').css('background', '#29fb00');
                    $('#seleccionado_1').val("1");
                    $('.control_2 .seleccionado').css('background', '#ab1c27');
                    $('#seleccionado_2').val("0");
                    activarBusqueda();
                }
            });

            $('#busqueda_2').click(function(){
                var seleccionado = Number($('#seleccionado_2').val());
                if(seleccionado == 0){
                    $('.control_2 .seleccionado').css('background', '#29fb00');
                    $('#seleccionado_2').val("1");
                    $('.control_1 .seleccionado').css('background', '#ab1c27');
                    $('#seleccionado_1').val("0");
                    activarBusqueda();
                }

            });

            $('#buscarProducto').click(function () {
                activarBusqueda();
            });

            $("a#linkPublicar").fancybox({
                'width': 650,
                'height': 150,
                'autoScale': false,
                'transitionIn': 'none',
                'transitionOut': 'none',
                'showCloseButton': false,
                'modal': false,
                'type': 'iframe'
            });
            $("a#familiaBusqueda").fancybox({
                'width': 650,
                'height': 250,
                'autoScale': false,
                'transitionIn': 'none',
                'transitionOut': 'none',
                'showCloseButton': false,
                'modal': false,
                'type': 'iframe'
            });

            $("a#ingresar_series").fancybox({
                'width': 300,
                'height': 500,
                'autoScale': false,
                'transitionIn': 'none',
                'transitionOut': 'none',
                'showCloseButton': false,
                'modal': true,
                'type': 'iframe'
            });

            $("a#subirdoc").fancybox({
                'width': 650,
                'height': 150,
                'autoScale': false,
                'transitionIn': 'none',
                'transitionOut': 'none',
                'showCloseButton': false,
                'modal': false,
                'type': 'iframe'
            });
        });
        function cargar_familia(nivel, nombre, codfamilia, idfamilia) {
            $("#txtFamilia").val(nombre);//nombre
            $("#familiaid").val(idfamilia);//codigo
        }

        //function guardar_series(codigo,series,hdseries){
        function guardar_series(codigo, series) {
            //dataString        = "codigo="+codigo+"&series="+series+"&hdseries="+hdseries;
            dataString = "codigo=" + codigo + "&series=" + series;
            url = base_url + "index.php/almacen/producto/guardarseries";
            $.post(url, dataString, function (data) {

            });
        }

        function cambiarEstado(estado, producto){
            url = '<?php echo base_url(); ?>index.php/almacen/producto/cambiarEstado/';
            $.ajax({
                url : url,
                type: "POST",
                data: {
                    estado : Number(estado),
                    cod_producto : producto
                },
                dataType: "json",
                beforeSend: function(data){
                    $('#cargando_datos').show();
                },
                success: function(data){
                    if(data.cambio == true || data.cambio == 'true'){
                        $('#cargando_datos').hide();
                        alert('Cambio de estado correctamente!');
                        window.location = "<?php echo base_url(); ?>index.php/almacen/producto/productos/B";
                    }else{
                        $('#cargando_datos').hide();
                        alert('Ah Ocurrido un error con el cambio de estado!');
                    }
                },
                error: function(data){
                    $('#cargando_datos').hide();
                    console.log('Error en cambio de fase');
                }
            });
        }

     
    </script>
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

</head>
<body>
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
                        <td width="20%">FAMILIA</td><?php } ?>
                    <?php if ($flagBS == 'B') { ?>
                        <td width="7%">Precio 1</td>
                        <td width="7%">Precio 2</td>

                        <td width="15%">MARCA</td>
                        
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
                                    <div
                                        align="right"><?php echo number_format($valor[6], 2); ?>                        
                                    </div>
                                </td>
                                <td>
                                    <div
                                        align="right"><?php echo number_format($valor[7], 2); ?></div>
                                </td>
                                <td>
                                    <div align="center"><?php echo $valor[5]; ?></div>
                                </td>
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
                            </td>
                            <td>
                                <div align="center"><?php echo $valor[11]; ?></div>
                            </td>-->

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
        <div style="margin-top: 15px;">
        <?php
       echo $paginacion;
        ?>
        </div>
        <input type="hidden" id="iniciopagina" name="iniciopagina">
        <input type="hidden" id="cadena_busqueda" name="cadena_busqueda">

        <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url(); ?>"/>

        <input type="hidden" name="flagBS" id="flagBS" value="<?php echo $flagBS; ?>"/>

    </form>
</div>
</body>
</html>