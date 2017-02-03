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
        <script type="text/javascript" src="<?php echo base_url(); ?>js/tesoreria/cuentas.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
        <script language="javascript">
            $(document).ready(function(){
                $("a#linkVerCliente, a#linkVerProveedor").fancybox({
                    'width'          : 800,
                    'height'         : 500,
                    'autoScale'	 : false,
                    'transitionIn'   : 'none',
                    'transitionOut'  : 'none',
                    'showCloseButton': false,
                    'modal'          : true,
                    'type'	     : 'iframe'
                });

                $("a#linkVerProducto").fancybox({
                    'width'          : 800,
                    'height'         : 500,
                    'autoScale'	 : false,
                    'transitionIn'   : 'none',
                    'transitionOut'  : 'none',
                    'showCloseButton': false,
                    'modal'          : true,
                    'type'	     : 'iframe'
                });

            });
            function seleccionar_cliente(codigo,ruc,razon_social, empresa, persona){
                $("#cliente").val(codigo);
                $("#ruc_cliente").val(ruc);
                $("#nombre_cliente").val(razon_social);
                $('#estado_pago2').attr("onchange","BuscarxEstadoPago()");
            }
            function seleccionar_proveedor(codigo,ruc,razon_social){
                $("#proveedor").val(codigo);
                $("#ruc_proveedor").val(ruc);
                $("#nombre_proveedor").val(razon_social);
                $('#estado_pago2').attr("onchange","BuscarxEstadoPago()");
            }
            function seleccionar_producto(codigo,interno,familia,stock,costo){
                $("#producto").val(codigo);
                $("#codproducto").val(interno);

                base_url   = $("#base_url").val();
                url          = base_url+"index.php/almacen/producto/listar_unidad_medida_producto/"+codigo;
                $.getJSON(url,function(data){
                    $.each(data, function(i,item){
                        nombre_producto = item.PROD_Nombre;
                    });
                    $("#nombre_producto").val(nombre_producto);
                });
            }

            var cursor;
            if (document.all) {
                // Está utilizando EXPLORER
                cursor='hand';
            } else {
                // Está utilizando MOZILLA/NETSCAPE
                cursor='pointer';
            }
        </script>
    </head>
    <body>
        <div id="pagina">
            <div id="zonaContenido">
                <div align="center">
                    <div id="tituloForm" class="header"><?php echo $titulo_busqueda; ?></div>
                    <form id="form_busqueda" name="form_busquedaCuenta" method="post" action="<?php echo base_url(); ?>index.php/tesoreria/cuentas/listar/<?php echo $tipo_cuenta ?>">
                        <div id="frmBusqueda" >
                            <table class="fuente8" width="98%" cellspacing="0" cellpadding="3" border="0">
                                <tr>
                                    <td align='left' width="10%">Fecha inicial</td>
                                    <td align='left' width="90%">
                                        <input name="fechai" id="fechai" value="<?php echo $fechai; ?>" type="text" class="cajaGeneral" size="10" maxlength="10"/>
                                        <img src="<?php echo base_url(); ?>images/calendario.png" name="Calendario1" id="Calendario1" width="16" height="16" border="0" onMouseOver="this.style.cursor='pointer'" title="Calendario"/>
                                        <script type="text/javascript">
                                            Calendar.setup({
                                                inputField     :    "fechai",      // id del campo de texto
                                                ifFormat       :    "%d/%m/%Y",       // formato de la fecha, cuando se escriba en el campo de texto
                                                button         :    "Calendario1"   // el id del botón que lanzará el calendario
                                            });
                                        </script>
                                        <label style="margin-left: 90px;">Fecha final</label>
                                        <input name="fechaf" id="fechaf" value="<?php echo $fechaf; ?>" type="text" class="cajaGeneral" size="10" maxlength="10" />
                                        <img src="<?php echo base_url(); ?>images/calendario.png" name="Calendario2" id="Calendario2" width="16" height="16" border="0" onMouseOver="this.style.cursor='pointer'" title="Calendario2"/>
                                        <script type="text/javascript">
                                            Calendar.setup({
                                                inputField     :    "fechaf",      // id del campo de texto
                                                ifFormat       :    "%d/%m/%Y",       // formato de la fecha, cuando se escriba en el campo de texto
                                                button         :    "Calendario2"   // el id del botón que lanzará el calendario
                                            });
                                        </script>
                                    </td>
                                </tr>
                                <tr>
                                    <td align='left'>Número</td>
                                    <td align='left'>
                                        <input type="text" name="serie" id="serie" value="<?php echo $serie; ?>" class="cajaGeneral" size="3" maxlength="3" placeholder="Serie" />
                                        <input type="text" name="numero" id="numero" value="<?php echo $numero; ?>"  class="cajaGeneral" size="10" maxlength="6" placeholder="Numero" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align='left'>Estado Pago</td>
                                    <td align='left'>
         <select id="estado_pago" name="estado_pago">
                                            <?php
   if ($cboestadopago == '') {
               ?>
        <option value="T" selected="selected">TODOS</option>
          <option value="C">Cancelado</option>
         <option value="P" >Pendiente</option>
             <?php
        } else if ($cboestadopago == 'C') {
        ?>
          <option value="T">TODOS</option>
    <option value="C" selected="selected">Cancelado</option>
   <option value="P">Pendiente</option>
                                                <?php
  } else if ($cboestadopago == 'T') {
                                                ?>
         <option value="T" selected="selected">TODOS</option>
         <option value="C">Cancelado</option>
          <option value="P">Pendiente</option>
            <?php
        } else if ($cboestadopago == 'P') {
                                                ?>
                                                <option value="T">TODOS</option>
                                                <option value="C">Cancelado</option>
                                                <option value="P"  selected="selected">Pendiente</option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tipo Documento</td>
                                    <td>
                                        <select id="comprobante" name="comprobante">
                                            <?php
                                            if ($cboTipoDoc == '') {
                                                ?>
                                                <option value="T" selected="selected">TODOS</option>
                                                <option value="9">Boleta</option>
                                                <option value="8" >Factura</option>
                                                <?php
                                            } else if ($cboTipoDoc == 9) {
                                                ?>
                                                <option value="">TODOS</option>
                                                <option value="9" selected="selected">Boleta</option>
                                                <option value="8">Factura</option>
                                                <?php
                                            } else if ($cboTipoDoc == 8) {
                                                ?>
                                                <option value="">TODOS</option>
                                                <option value="9">Boleta</option>
                                                <option value="8" selected="selected">Factura</option>
                                                <?php
                                            } else {
                                                ?>
                                                <option value="T" selected="selected">TODOS</option>
                                                <option value="9">Boleta</option>
                                                <option value="8">Factura</option>
                                                <?php
                                            }
                                            ?>

                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <?php if ($tipo_cuenta == '1') { ?>
                                        <td align='left'>Cliente</td>
                                        <td align='left'>
                                            <input type="hidden" name="cliente" value="" id="cliente" size="5" />
                                            <input type="text" name="ruc_cliente" value="" class="cajaGeneral" id="ruc_cliente" size="10" maxlength="11" onBlur="obtener_cliente();" onKeyPress="return numbersonly(this,event,'.');" placeholder="Ruc" />
                                            <input type="text" name="nombre_cliente" value=""  class="cajaGrande cajaSoloLectura" id="nombre_cliente" size="40" readonly="readonly" placeholder="Nombre cliente" />
                                            <a href="<?php echo base_url(); ?>index.php/ventas/cliente/ventana_busqueda_cliente/" id="linkVerCliente"><img height='16' width='16' src='<?php echo base_url(); ?>/images/ver.png' title='Buscar' border='0' /></a>
                                        </td>
                                    <?php } else { ?>
                                        <td align='left'>Proveedor</td>
                                        <td align='left'>
                                            <input type="hidden" name="proveedor" value="<?php echo $proveedor; ?>" id="proveedor" size="5" />
                                            <input type="text" name="ruc_proveedor" value="<?php echo $ruc_proveedor; ?>" class="cajaGeneral" id="ruc_proveedor" size="10" maxlength="11" onBlur="obtener_proveedor();" onKeyPress="return numbersonly(this,event,'.');" placeholder="Ruc" />
                                            <input type="text" name="nombre_proveedor" value="<?php echo $nombre_proveedor; ?>"  class="cajaGrande cajaSoloLectura" id="nombre_proveedor" size="40" readonly="readonly" placeholder="Nombre proveedor" />
                                            <a href="<?php echo base_url(); ?>index.php/compras/proveedor/ventana_busqueda_proveedor/" id="linkVerProveedor"><img height='16' width='16' src='<?php echo base_url(); ?>/images/ver.png' title='Buscar' border='0' /></a>
                                        </td>
                                    <?php } ?>
                                </tr>
                                <tr>
                                    <td align='left'>Artículo</td>
                                    <td align='left'>
                                        <input name="producto" type="hidden" class="cajaPequena" id="producto" size="10" maxlength="11" />
                                        <input name="codproducto" type="text" value="<?php echo $codproducto; ?>" class="cajaPequena" id="codproducto" size="10" maxlength="11" onBlur="obtener_producto();" onKeyPress="return numbersonly(this,event,'.');" placeholder="Codigo" />
                                        <input NAME="nombre_producto" type="text" value="<?php echo $nombre_producto; ?>" class="cajaGrande cajaSoloLectura" id="nombre_producto" size="40" readonly="readonly" placeholder="Nombre producto" />
                                        <a href="<?php echo base_url(); ?>index.php/almacen/producto/ventana_busqueda_producto/" id="linkVerProducto"><img height='16' width='16' src='<?php echo base_url(); ?>/images/ver.png' title='Buscar' border='0' /></a>
                                    </td>
                                </tr>
                            </table>
                        </div>
<div class="acciones">
                        <div id="botonBusqueda">
                           <!-- <ul id="imprimirCuenta" class="lista_botones"><li id="imprimir">Imprimir</li></ul>-->
                            <ul id="nuevoCuenta" class="lista_botones">
                                <li id="nuevo">
                                    <?php
                                    if ($tipo_cuenta == 1) {
                                        echo "Nuevo Cobro";
                                    } else {
                                        echo "Nuevo Pago";
                                    }
                                    ?>
                                </li>
                            </ul>
                            <ul id="limpiarCuenta" class="lista_botones"><li id="limpiar">Limpiar</li></ul>
                            <ul id="buscarCuenta" class="lista_botones"><li id="buscar">Buscar</li></ul>
                        </div>
                        <div id="lineaResultado">
                            <table class="fuente7" width="100%" cellspacing="0" cellpadding="3" border="0">
                                <tr>
                                    <td width="50%" align="left">N de cuentas por <?php echo ($tipo_cuenta == '1' ? 'cobrar' : 'pagar'); ?> encontrados:&nbsp;<?php echo $registros; ?> </td>
                            </table>
                        </div>
</div>
                        <div id="cabeceraResultado" class="header"><?php
                                    echo $titulo_tabla;
                                    ?></div>
                        <div id="frmResultado">
                            <table class="fuente8" width="100%" cellspacing="0" cellpadding="3" border="0" ID="Table1">
                                <tr class="cabeceraTabla">
                                    <td width="4%">ITEM</td>
                                    <td width="8%">TIPO DOC</td>
                                    <td width="5%">SERIE</td>
                                    <td width="6%">NUMERO</td>
                                    <td width="5%">FECHA</td>
                                    <td>RAZON SOCIAL</td>
                                    <td width="9%">TOTAL</td>
                                    <td width="9%">SALDO</td>
                                    <td width="4%">ESTADO</td>
                                    <td width="4%">&nbsp;</td>
                                    <td width="4%">&nbsp;</td>
                                    <td width="4%">&nbsp;</td>
                                </tr>
                                <?php
                                if (count($lista) > 0) {
                                    foreach ($lista as $indice => $valor) {
                                        /* $array_estado_formato = explode("_|_", $valor[8]);
                                          $class = $indice % 2 == 0 ? 'itemParTabla' : 'itemImparTabla';
                                          //if ($array_estado_formato[1] == 'Pendiente') {
                                          ?>
                                          <tr class="<?php echo $class . ' ' . $valor[1] . ' ' . $array_estado_formato[1]; ?> ">
                                          <td><div align="center"><?php echo $valor[0]; ?></div></td>
                                          <td><div align="center"><?php echo $valor[1]; ?></div></td>
                                          <td><div align="center"><?php echo $valor[2]; ?></div></td>
                                          <td><div align="center"><?php echo $valor[3]; ?></div></td>
                                          <td><div align="center"><?php echo $valor[4]; ?></div></td>
                                          <td><div align="left"><?php echo $valor[5]; ?></div></td>
                                          <td><div align="right"><?php echo $valor[6]; ?></div></td>
                                          <td><div align="center"><?php echo $valor[7]; ?></div></td>
                                          <td><div align="center"><?php echo $array_estado_formato[0] ?></div></td>
                                          <td><div align="center">&nbsp;</div></td>
                                          <td><div align="center"><?php echo $valor[9]; ?></div></td>
                                          <td><div align="center"><?php echo $valor[11]; ?></div></td>
                                          </tr>
                                          <?php
                                          //}
                                          /* else {
                                          ?>
                                          <tr class="<?php echo $class . ' ' . $valor[1] . ' ' . $array_estado_formato[1]; ?> " style="display: none;">
                                          <td><div align="center"><?php echo $valor[0]; ?></div></td>
                                          <td><div align="center"><?php echo $valor[1]; ?></div></td>
                                          <td><div align="center"><?php echo $valor[2]; ?></div></td>
                                          <td><div align="center"><?php echo $valor[3]; ?></div></td>
                                          <td><div align="center"><?php echo $valor[4]; ?></div></td>
                                          <td><div align="left"><?php echo $valor[5]; ?></div></td>
                                          <td><div align="right"><?php echo $valor[6]; ?></div></td>
                                          <td><div align="center"><?php echo $valor[7]; ?></div></td>
                                          <td><div align="center"><?php echo $array_estado_formato[0] ?></div></td>
                                          <td><div align="center">&nbsp;</div></td>
                                          <td><div align="center"><?php echo $valor[9]; ?></div></td>
                                          <td><div align="center"><?php echo $valor[11]; ?></div></td>
                                          </tr>
                                          <?php
                                          } */
                                        $array_estado_formato = explode("_|_", $valor[8]);
                                        $class = $indice % 2 == 0 ? 'itemParTabla' : 'itemImparTabla';
                                        if ($array_estado_formato[1] == 'Pendiente') {
                                            ?>
                                            <tr class="<?php echo $class . ' ' . $valor[1] . ' ' . $array_estado_formato[1]; ?> ">
                                                <td><div align="center"><?php echo $valor[0]; ?></div></td>
                                                <td><div align="center"><?php echo $valor[1]; ?></div></td>
                                                <td><div align="center"><?php echo $valor[2]; ?></div></td>
                                                <td><div align="center"><?php echo $valor[3]; ?></div></td>
                                                <td><div align="center"><?php echo $valor[4]; ?></div></td>
                                                <td><div align="left"><?php echo $valor[5]; ?></div></td>
                                                <td><div align="right"><?php echo $valor[6]; ?></div></td>
                                                <td><div align="center"><?php echo $valor[7]; ?></div></td>
                                                <td><div align="center"><?php echo $array_estado_formato[0] ?></div></td>
                                                <td><div align="center">&nbsp;</div></td>
                                                <td><div align="center"><?php echo $valor[9]; ?></div></td>
                                                <td><div align="center"><?php echo $valor[11]; ?></div></td>
                                            </tr>
                                        <?php
                                        } else {
                                            ?>
                                            <tr class="<?php echo $class . ' ' . $valor[1] . ' ' . $array_estado_formato[1]; ?> ">
                                                <td><div align="center"><?php echo $valor[0]; ?></div></td>
                                                <td><div align="center"><?php echo $valor[1]; ?></div></td>
                                                <td><div align="center"><?php echo $valor[2]; ?></div></td>
                                                <td><div align="center"><?php echo $valor[3]; ?></div></td>
                                                <td><div align="center"><?php echo $valor[4]; ?></div></td>
                                                <td><div align="left"><?php echo $valor[5]; ?></div></td>
                                                <td><div align="right"><?php echo $valor[6]; ?></div></td>
                                                <td><div align="center"><?php echo $valor[7]; ?></div></td>
                                                <td><div align="center"><?php echo $array_estado_formato[0] ?></div></td>
                                                <td><div align="center">&nbsp;</div></td>
                                                <td><div align="center"><?php echo $valor[9]; ?></div></td>
                                                <td><div align="center"><?php echo $valor[11]; ?></div></td>
                                            </tr>
                                        <?php
                                        }
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="12">
                                            <table width="100%" cellspacing="0" cellpadding="3" border="0" class="fuente8">
                                                <tbody>
                                                <tr>
                                                    <td width="100%" class="mensaje">No hay ning&uacute;n registro que cumpla con los criterios de b&uacute;squeda</td>
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
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>