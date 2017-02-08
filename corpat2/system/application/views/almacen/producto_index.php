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

        function activarBusqueda()
        {
            var url = $('#form_busqueda').attr('action');
            var dataString = $('#form_busqueda').serialize();
            var flagBS = $('#flagBS').val();
            $.ajax({
                type: "POST",
                url: url,
                data: dataString,
                beforeSend: function(data){
                    $('#cargando_datos').show();
                },
                success: function(data){
                    $('#cargando_datos').hide();

                    $('#cuerpoPagina').html(data);
                },
                error : function(HXR, error){
                    $('#cargando_datos').hide();
                    console.log(data);
                }
            });
        }
    </script>
    <script type="text/javascript">
$(document).ready(function() {    
    $('.paginacion').live('click', function(){
var urls = base_url() . "index.php/almacen/producto/buscar_productos/";
        $('#cuerpoPagina').html('<div><img src="images/loading.gif" width="70px" height="70px"/></div>');

        var page = $(this).attr('data');        
        var dataString = 'page='+page;

        $.ajax({
            type: "GET",
            url: urls;
            data: dataString,
            success: function(data) {
                $('#cuerpoPagina').fadeIn(1000).html(data);
            }
        });
    });              
});    
</script>
<div id="pagina">
    <div id="zonaContenido">
        <div align="center">
            <div id="tituloForm" class="header"><?php echo $titulo_busqueda; ?></div>
            <div id="frmBusqueda">
                <form id="form_busqueda" name="form_busqueda" method="post" action="<?php echo $action; ?>">
                    <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
                        <tr>
                            <td width="16%">Código Usuario</td>
                            <td width="34%">
                            
                            <input id="txtCodigo" type="text" class="cajaPequena" NAME="txtCodigo" placeholder="Codigo"
                            maxlength="30" value="<?php echo $codigo;?>">
                            <td width="47%" rowspan="6" class="busqueda_opcinal" >
                                <div class="control_1" >
                                    <span class="busqueda_opcinal_1" role="button" aria-checked="true" id="busqueda_1" >
                                        Productos.<br>
                                        Activos
                                    </span>
                                    <span class="seleccionado" ></span>
                                    <input type="hidden" id="seleccionado_1" value="1" name="busqueda_1" />
                                </div>
                                <div class="control_2">
                                    <span class="busqueda_opcinal_2" id="busqueda_2" >
                                        Productos.<br>
                                        No activos
                                    </span>
                                    <span class="seleccionado" ></span>
                                    <input type="hidden" id="seleccionado_2" value="0" name="busqueda_2" />
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Nombre</td>
                            <td><input id="txtNombre" name="txtNombre" type="text" class="cajaGrande" maxlength="100" placeholder="Nombre producto"
                                       value="<?php echo $nombre; ?>"></td>
                        </tr>
                        <tr>
                            <td>Familia</td>
                            <td>
                                <input id="txtFamilia" type="text" class="cajaGrande cajaSoloLectura" NAME="txtFamilia" placeholder="Familia producto"
                                       maxlength="100" readonly="readonly" value="<?php echo $familia; ?>">
                                <input type="hidden" id="familiaid" name="familiaid" value="<?php echo $familiaid; ?>">
                                <a id="familiaBusqueda" name="familiaBusqueda"
                                   href="<?php echo base_url(); ?>index.php/almacen/familia/ventana_busqueda_familia/B">
                                    <img src="<?php echo base_url(); ?>/images/ver.png">
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Marca</td>
                            <td><input id="txtMarca" type="text" class="cajaGrande" NAME="txtMarca" maxlength="100" placeholder="Marca producto"
                                       value="<?php echo $marca; ?>"></td>
                        </tr>
                    </table>
                </form>
            </div>

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

                            <td width="5%" align='center'>&nbsp;CODIGO&nbsp; U.</td>
                            <td>DESCRIPCION&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

                            <?php if (FORMATO_IMPRESION != 4) { ?>
                                <td width="20%">FAMILIA</td><?php } ?>
                            <?php if ($flagBS == 'B') { ?>
                               <!-- <td width="7%">PRECIO 1</td>
                                <td width="7%">PRECIO 2</td>-->
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
            <div align="center"><?php if ($valor[1] != '') 
            echo str_pad($valor[1], "3", "0", STR_PAD_LEFT); ?>
            </div>
        </td>
        <td>
            <div align="left"><?php echo $valor[2]; ?></div>
        </td>
                                    
        <?php if (FORMATO_IMPRESION != 4) { 
            ?>
        <td>
            <div align="left"><?php echo $valor[3]; ?></div>
            </td><?php } 
            ?>

         <?php if ($flagBS == 'B') { ?>
       <!-- <td>
            <div align="left"><?php echo number_format($valor[6],2);   ?>
                
            </div>
         </td>
         <td>
            <div align="left"><?php  echo  number_format($valor[7], 2);  ?>
                 
            </div>
         </td>-->
         <td>
        <div align="center"><?php echo $valor[5 ]; ?></div>
         </td>
         <?php if (FORMATO_IMPRESION == 4) { ?>
        <td>
        <div align="right"><?php if ($valor[6] != 0 && $valor[6] != '') echo number_format($valor[6], 2); ?></div>
        </td><?php 
        } 
        ?>
         <?php if (FORMATO_IMPRESION == 4) { 
        ?>
        <td>
        <div align="right"><?php if ($valor[7] != 0 && $valor[7] != '') echo number_format($valor[7], 2); ?></div>
         </td><?php 
        }
        ?>
      <?php 
                                } 
                                ?>
    <td>
        <div align="center"><?php echo $valor[8]; ?></div>
    </td>
    <td>
        <div align="center"><?php echo $valor[9]; ?></div>
    </td>
    <td>
         <div align="center"><?php echo $valor[15]; ?></div>
    </td>
      <!-- <td>
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
                <div class="paginacion" 
                 style="margin-top: 15px;"><?php echo $paginacion; ?></div>
                <input type="hidden" id="iniciopagina" name="iniciopagina">
                <input type="hidden" id="cadena_busqueda" name="cadena_busqueda">
                <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url(); ?>"/>
                <input type="hidden" name="flagBS" id="flagBS" value="<?php echo $flagBS; ?>"/>

            </form>
            </div>
        </div>
    </div>

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
