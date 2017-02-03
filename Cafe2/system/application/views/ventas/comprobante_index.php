<?php
$nombre_persona = $this->session->userdata('nombre_persona');
$persona = $this->session->userdata('persona');
$usuario = $this->session->userdata('usuario');
$url = base_url() . "index.php";
if (empty($persona))
    header("location:$url");
$CI = get_instance();
?>
<html>
<head>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/ventas/comprobante.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/funciones.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>js/fancybox/jquery.fancybox-1.3.4.css"
          media="screen"/>
    <script language="javascript">
        $(document).ready(function () {
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
            $("a#linkVerPersona").fancybox({
                'width': 800,
                'height': 650,
                'autoScale': false,
                'transitionIn': 'none',
                'transitionOut': 'none',
                'showCloseButton': false,
                'modal': true,
                'type': 'iframe'
            });
            $("a.canjear_doc").fancybox({
                'width': 900,
                'height': 550,
                'autoScale': false,
                'transitionIn': 'none',
                'transitionOut': 'none',
                'showCloseButton': false,
                'modal': true,
                'type': 'iframe'
            });
            $("a#comprobante").fancybox({
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
            /*$("#nombre_producto").autocomplete({

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

            });*/

            /*$("#nombre_cliente").autocomplete({
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

            });*/


            /*$("#nombre_proveedor").autocomplete({
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
            <form id="form_busqueda" name="form_busqueda" method="post"
                  action="<?php echo base_url(); ?>index.php/ventas/comprobante/comprobantes">
                <div id="frmBusqueda">
                    <table class="fuente8" width="98%" cellspacing="0" cellpadding="3" border="0">
                        <tr>
                            <td align='left' width="10%">Fecha inicial</td>
                            <td align='left' width="90%">
                                <input name="fechai" id="fechai" value="" type="text"
                                       class="cajaGeneral cajaSoloLectura" size="10" maxlength="10"/>
                                <img src="<?php echo base_url(); ?>images/calendario.png" name="Calendario1"
                                     id="Calendario1" width="16" height="16" border="0"
                                     onMouseOver="this.style.cursor = 'pointer'" title="Calendario"/>
                                <script type="text/javascript">
                                    Calendar.setup({
                                        inputField: "fechai", // id del campo de texto
                                        ifFormat: "%d/%m/%Y", // formato de la fecha, cuando se escriba en el campo de texto
                                        button: "Calendario1"   // el id del botón que lanzará el calendario
                                    });
                                </script>
                                <label style="margin-left: 90px;">Fecha final</label>
                                <input name="fechaf" id="fechaf" value="" type="text"
                                       class="cajaGeneral cajaSoloLectura" size="10" maxlength="10"/>
                                <img src="<?php echo base_url(); ?>images/calendario.png" name="Calendario2"
                                     id="Calendario2" width="16" height="16" border="0"
                                     onMouseOver="this.style.cursor = 'pointer'" title="Calendario2"/>
                                <script type="text/javascript">
                                    Calendar.setup({
                                        inputField: "fechaf", // id del campo de texto
                                        ifFormat: "%d/%m/%Y", // formato de la fecha, cuando se escriba en el campo de texto
                                        button: "Calendario2"   // el id del botón que lanzará el calendario
                                    });
                                </script>
                            </td>
                        </tr>
                        <tr>
                            <td align='left'>Número</td>
                            <td align='left'><input type="text" name="seriei" id="seriei" value="" placeholder="Serie"
                                                    class="cajaGeneral" size="3" maxlength="3"/>
                                <input type="text" name="numero" id="numero" value="" placeholder="Numero"
                                       class="cajaGeneral" size="10" maxlength="6"/>
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
                                           placeholder="Ruc"
                                           onkeypress="return numbersonly(this, event, '.');" />
                                    <input type="text" name="nombre_cliente" value="" placeholder="Nombre cliente"
                                           class="cajaGrande" id="nombre_cliente" size="40"/>
                                    <!-- <a href="<?php echo base_url(); ?>index.php/ventas/cliente/ventana_busqueda_cliente/"
                                       id="linkVerCliente"><img height='16' width='16'
                                                                src='<?php echo base_url(); ?>/images/ver.png'
                                                                title='Buscar' border='0'/></a>
                                                                -->
                                </td>
                            <?php } else { ?>
                                <td align='left'>Proveedor</td>
                                <td align='left'>
                                    <input type="hidden" name="proveedor" value=""
                                           id="proveedor" size="5"/>
                                    <input type="text" name="ruc_proveedor" value="" placeholder="Ruc"
                                           class="cajaGeneral" id="ruc_proveedor" size="10" maxlength="11"
                                           onblur="obtener_proveedor();"
                                           onkeypress="return numbersonly(this, event, '.');" />
                                    <input type="text" name="nombre_proveedor" value="" placeholder="Nombre proveedor"
                                           class="cajaGrande" id="nombre_proveedor" size="40"/>
                                    <!--<a href="<?php echo base_url(); ?>index.php/compras/proveedor/ventana_busqueda_proveedor/"
                                       id="linkVerProveedor"><img height='16' width='16'
                                                                  src='<?php echo base_url(); ?>/images/ver.png'
                                                                  title='Buscar' border='0'/></a>-->
                                </td>
                            <?php } ?>
                        </tr>
                        <!--<tr>
                            <td align='left'>Artículo</td>
                            <td align='left'>
                                <input name="compania" type="hidden" id="compania" value="<?php echo $compania; ?>">
                                <input name="producto" type="hidden" class="cajaPequena" id="producto" size="10"
                                       maxlength="11"/>
                                <input name="codproducto" type="text" class="cajaGeneral" id="codproducto"
                                       value="" size="10" maxlength="20" placeholder="Codigo"
                                       onblur="obtener_producto();" readonly="readonly"/>
                                <input name="buscar_producto" type="hidden" class="cajaGeneral" id="buscar_producto"
                                       size="40"/>
                                <input name="nombre_producto" type="text" value="" placeholder="Nombre producto"
                                       class="cajaGrande" id="nombre_producto" size="40"/>
                                <!--<a href="<?php //echo base_url(); ?>index.php/almacen/producto/ventana_busqueda_producto/"
                                   id="linkVerProducto"><img height='16' width='16'
                                                             src='<?php //echo base_url(); ?>/images/ver.png'
                                                             title='Buscar' border='0'/></a>
                            </td>
                        </tr>-->
                    </table>
                </div>
                <div class="acciones">
                    <div id="botonBusqueda">
                        <ul id="visualizarSunat" class="lista_botones">
                        <li id="sunat">Consulta Ruc</li>
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
                                <td width="100%" align="left">N
                                    de <?php echo $CI->obtener_tipo_documento($tipo_docu); ?>s
                                    encontrados:&nbsp;<?php echo $registros; ?> </td>
                                <td width="50%" align="right">&nbsp;</td>
                        </table>
                    </div>
                </div>
                <div id="cabeceraResultado" class="header">
                    <?php
                    echo $titulo_tabla;
                    ?>
                </div>
                <div id="contenedor-busqueda" >
                    <div id="frmResultado">
                        <table class="fuente8" width="100%" cellspacing="0" cellpadding="3" border="0" ID="Table1">
                            <tr class="cabeceraTabla">
                                <td width="4%">ITEM</td>
                                <td width="5%">FECHA</td>
                                <td width="5%">SERIE</td>
                                <td width="6%">NUMERO</td>
                                <?php if($tipo_docu != 'N') { ?>
                                	<td width="9%">GUIA REMISION</td>
                                <?php } ?>
                                <td width="13%">DOC. REFERENCIA</td>
                                
                                <?php if($tipo_docu == 'N'){ ?>
                                	<td width="9%">COMPROBANTE</td>
                                <?php } ?>
                                <?php if($tipo_docu != 'N' &&  $tipo_oper == 'V') { ?>
                                	<td width="9%">COMPROBANTE CANJE</td>
                                <?php } ?>
                                
                                <td>RAZON SOCIAL</td>
                                <td width="9%">TOTAL</td>
                                <td width="4%">ESTADO</td>
                                <td width="4%">&nbsp;</td>
                                <?php 
                                if ($tipo_oper == 'V') {

                                 ?>
                                    <td width="4%">&nbsp;</td>
                                    <td width="4%">&nbsp;</td>
                                    <?php if ($tipo_docu == 'N') {
                                        ?>
                                        <td width="4%">&nbsp;</td>
                                    <?php
                                    }
                                    ?>
                                <?php
                                } else {
                                    ?>
                                    <td width="4%">&nbsp;</td>
                                    <td width="4%">&nbsp;</td>
                                <?php
                                }
                                ?>
                                <
                                <td width="8%">&nbsp;</td>
                                <td width="8%">&nbsp;</td>
                                <td width="8%">&nbsp;</td>
                                <td width="8%">&nbsp;</td>

                                
                            </tr>
                            <?php
                            if (count($lista) > 0) {
                                foreach ($lista as $indice => $valor) {
                                    $class = $indice % 2 == 0 ? 'itemParTabla' : 'itemImparTabla';
                                    ?>
                                    <tr class="<?php echo $class; ?>">

                                    <input type="hidden" name="numeroClave" id="numeroClave" value="<?php echo $valor[17]; ?>">

                                        <td>
                                            <div align="center"><?php echo $valor[0]; ?></div>
                                        </td>
                                        <td>
                                            <div align="center"><?php echo $valor[1]; ?></div>
                                        </td>
                                        <td>
                                            <div align="center"><?php
                                                if ($valor[13] == 2)
                                                    echo '---';
                                                else
                                                    echo $valor[2];
                                                ?></div>
                                        </td>
                                        <td>
                                            <div align="center"><?php
                                                if ($valor[13] == 2)
                                                    echo '------';
                                                else
                                                    echo $valor[3];
                                                ?></div>
                                        </td>
	                                    <?php if($tipo_docu != 'N') { ?>
	                                    <td>
                                            <div align="center">
                                            	<?php echo $valor[4];  ?>
                                            </div>
                                        </td>
                                         <td>
	                                   		<div align="center"><?php echo $valor[5]; ?></div>
	                                    </td>
                                        <?php }else{ ?>
                                         <td>
	                                   		<div align="center"><?php echo $valor[5]; ?></div>
	                                    </td>
                                        <!-- numero serie de comprobante realizado -->
                                        	<td>
	                                            <div align="center"><?php echo $valor[18]; ?></div>
	                                        </td>
                                        <?php } ?>
	                                    
	                                    
	                                    
	                                    
	                                    <?php if($tipo_docu != 'N' &&  $tipo_oper == 'V') { ?>
                                		<td>
	                                   		<div align="center"><?php echo $valor[19]; ?></div>
	                                    </td>
                                		<?php } ?>
                                        <td>
                                            <div align="left"><?php echo $valor[6]; 
                                            ?></div>
                                        </td>
                                        <td>
                                            <div align="right"><?php echo $valor[7]; 
                                            ?></div>
                                        </td>
                                        <td>
                                            <div align="center"><?php echo $valor[8]; ?></div>
                                        </td>
                                        <!-- OPCION EDITAR NO SE MUESTRA SI PROVIENE DE UN COMPROBANTE -->
                                        <td>
                                        	<?php //if(trim($valor[19]=="")){ ?>
                                            <div align="center"><?php echo $valor[9];  ?></div>
                                        	<?php //} ?>
                                        </td>
                                        
                                        <?php if ($tipo_oper == 'V') { // 10 y 11 - Imprimir y PDF  ?>
                                            <?php if ($valor[10] != "") { ?>
                                                <td>
                                                    <div align="center"><?php echo $valor[10]; ?></div>
                                                </td>
                                            <?php }else{ ?>
                                            
                                            <td>
                                            	<div align="center"><?php echo $valor[10]; ?></div>
                                            </td>
                                            
                                            <?php } ?>
                                            <td colspan="<?php echo $valor[16]; ?>" >
                                                <div align="center"><?php echo $valor[11]; ?></div>
                                            </td>
                                            <?php
                                            if ($tipo_docu == 'N') {
                                                ?>
                                                <td width="4%" colspan="5">
                                                    <?php
                                                    if ($valor[13] == 1)
                                                        if ($valor[15] == '' || $valor[15] == NULL || $valor[15] == 0)
                                                            echo '<a href="' . base_url() . 'index.php/ventas/comprobante/canje_documento/' . $valor[14] . '" class="canjear_doc">Canjear</a>';
                                                    ?>
                                                </td>
                                                
                                                
                                            <?php
                                            }
                                            ?>
                                        <?php } else { ?>
                                            <?php if ($valor[10] != "") { ?>
                                            <td>
                                            	<div align="center"><?php echo $valor[10]; ?></div>
                                            </td>
                                            <?php } ?>
                                        
                                            <td colspan="<?php echo $valor[16]; ?>">
                                                <div align="center"><?php echo $valor[11]; ?></div>
                                            </td>
                                        <?php } ?>
                                        <?php if ($valor[12] != "") { ?>
                                            <td>
                                                <div align="center"><?php echo $valor[12]; ?></div>
                                            </td>
                                        <?php } ?>
                                         <td>
                                                <div align="center"><?php echo $valor[20]; ?></div>
                                            </td>
                                    </tr>
					

                                <?php
                                }
                            } else {
                                ?>

                                <tr>
                                    <td colspan="16">
                                        <table width="100%" cellspacing="0" cellpadding="3" border="0" class="fuente8">
                                            <tbody>
                                            <tr>
                                                <td width="100%" class="mensaje">No hay ning&uacute;n registro que cumpla
                                                    con los criterios de b&uacute;squeda
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>


                        </table>
                    </div>
                    <div style="margin-top: 15px;"><?php echo $paginacion; ?></div>
                    <input type="hidden" id="iniciopagina" name="iniciopagina">
                    <?php echo $oculto ?>
                </div>
            </form>
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
</body>
</html>