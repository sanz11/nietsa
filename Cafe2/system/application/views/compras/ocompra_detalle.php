<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/compras/ocompra.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/funciones.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>js/fancybox/jquery.fancybox-1.3.4.css"
      media="screen"/>
<script type="text/javascript">
    $(document).ready(function () {
        $("a#ver_detalles_guias").fancybox({
            'width': 750,
            'height': 400,
            'autoScale': false,
            'transitionIn': 'none',
            'transitionOut': 'none',
            'showCloseButton': false,
            'modal': true,
            'type': 'iframe'
        });

    });
</script>
<form id="frmOcompra" id="<?php echo $formulario; ?>" method="post" action="<?php echo $url_action; ?>"
      onsubmit="return valida_ocompra();">
    <div id="zonaContenido" align="center">
        <div id="tituloForm" class="header"><?php echo $titulo; ?></div>
        <div id="frmBusqueda">
            <table class="fuente8" width="100%" cellspacing="0" cellpadding="5" border="0">
                <tr>
                    <td width="8%">N&uacute;mero :</td>
                    <td width="38%"><?php echo $numero; ?>
                        <label style="padding-left:52px;">Código :
                            &nbsp;&nbsp;&nbsp;&nbsp;</label><?php echo $codigo_usuario; ?>

                        <input name="pedido" type="hidden" class="cajaPequena2" id="pedido" size="10" maxlength="10"
                               readonly="readonly" value="<?php echo $pedido; ?>"/></td>
                    <td width="8%">Almacen</td>
                    <td width="20%"><?php echo $cboAlmacen[0]->ALMAC_Descripcion; ?></td>
                    <td width="8%">Fecha</td>
                    <td width="18%"><?php echo $hoy; ?></td>
                </tr>
                <tr>
                    <?php if ($tipo_oper == 'V') { ?>
                        <td>Cliente *</td>
                        <td valign="middle">
                            <?php echo $ruc_cliente; ?>
                            <?php echo $nombre_cliente; ?>
                        </td>
                    <?php } else { ?>
                        <td>Proveedor</td>
                        <td>
                            <?php echo $ruc_proveedor; ?>
                            <?php echo $nombre_proveedor; ?>
                        </td>
                    <?php } ?>
                    <td>Moneda</td>
                    <td> <?php echo $cboMoneda[0]->MONED_Descripcion; ?></td>
                </tr>
                <tr>
                    <td valign="middle"><?php if ($tipo_oper == 'V') echo 'Comprador'; else echo 'Vendedor'; ?></td>
                    <td><?php echo $contacto; ?>
                    </td>
                    <td valign="middle">Forma Pago</td>
                    <td><?php if (count($cboFormapago) > 0) {
                            echo $cboFormapago[0]->FORPAC_Descripcion;
                        } ?></td>
                    <td valign="middle"><?php if ($tipo_oper == 'V') echo 'Vendedor'; else echo 'Comprador'; ?></td>
                    <td><?php echo $mi_contacto; ?></td>
                </tr>
                <tr>
                    <td>I.G.V.</td>
                    <td><?php echo $igv; ?>%
                    </td>
                    <td>Dscto</td>
                    <td>
                        <?php echo $descuento; ?>
                    </td>
                    <td>Percepci&oacute;n</td>
                    <td>
                        <?php echo $percepcion; ?>
                        <label> % </label>
                    </td>
                </tr>
            </table>
        </div>
        <br>

        <div id="frmBusqueda" style="height:250px; overflow: auto">

            <div class="fuente8" align="left" style="color:white;font-weight:bold;">
                <span style="border:1px solid green;background-color:green;">&nbsp;ENTREGA FINALIZADA&nbsp;</span>
                <span style="border:1px solid orange;background-color:orange;">&nbsp;ENTREGA EN PROCESO&nbsp;</span>
                <span style="border:1px solid red;background-color:red;">&nbsp;ENTREGA SIN MOVIMIENTO&nbsp;</span>
            </div>
            <table class="fuente8" width="100%" cellspacing="0" cellpadding="3" border="0" ID="Table1">
                <tr class="cabeceraTabla">
                    <td width="4%">
                        <div align="center">ITEM</div>
                    </td>
                    <td width="5%">
                        <div align="center">C&Oacute;DIGO</div>
                    </td>
                    <td width="35%">
                        <div align="center">DESCRIPCI&Oacute;N</div>
                    </td>
                    <td width="7%">
                        <div align="center">CANTIDAD</div>
                    </td>
                    <td width="15%">
                        <div align="center">ESTADO</div>
                    </td>
                    <td width="10%">
                        <div align="center">AVANCE VENTA</div>
                    </td>
                    <td width="6%">
                        <div align="center">Guias Ref.</div>
                    </td>
                    <td width="6%">
                        <div align="center">Compr.</div>
                    </td>
                </tr>
            </table>

            <div>
                <table id="tblDetalleOcompra" class="fuente8" width="100%" border="0">
                    <?php
                    if (count($detalle_ocompra) > 0) {
                        foreach ($detalle_ocompra as $indice => $valor) {
                            $detocom = $valor->OCOMDEP_Codigo;
                            $flagBS = $valor->flagBS;
                            $prodproducto = $valor->PROD_Codigo;
                            $unidad_medida = $valor->UNDMED_Codigo;
                            $codigo_interno = $valor->PROD_CodigoInterno;
                            $prodcantidad = $valor->COTDEC_Cantidad;
                            $nombre_producto = $valor->PROD_Nombre;
                            $nombre_unidad = $valor->UNDMED_Simbolo;
                            $prodpu = $valor->OCOMDEC_Pu;
                            $prodsubtotal = $valor->OCOMDEC_Subtotal;
                            $proddescuento = $valor->OCOMDEC_Descuento;
                            $proddescuento2 = $valor->OCOMDEC_Descuento2;
                            $prodigv = $valor->OCOMDEC_Igv;
                            $prodtotal = $valor->OCOMDEC_Total;
                            $cantidad_entregada = $valor->cantidad_entregada;
                            $cantidad_pendiente = $valor->cantidad_pendiente;
                            $cantidad_vendida = $valor->cantidad_vendida;
                            $codigo = $valor->codigo;
                            $tipo_oper = $valor->tipo_oper;

                            $color_f = "";
                            if ($cantidad_entregada == 0) {
                                $color_f = "red";
                            }
                            if ($cantidad_entregada > 0) {
                                $color_f = "orange";
                            }
                            if ($cantidad_entregada == $prodcantidad) {
                                $color_f = "green";
                            }

                            if (($indice + 1) % 2 == 0) {
                                $clase = "itemParTabla";
                            } else {
                                $clase = "itemImparTabla";
                            }
                            ?>
                            <tr class="<?php echo $clase;?>">
                                <td width="4%">
                                    <div align="center"><?php echo $indice + 1;?></div>
                                </td>
                                <td width="5%">
                                    <div align="center"><?php echo $codigo_interno;?></div>
                                </td>
                                <td width="35%">
                                    <div align="left"><?php echo $nombre_producto;?>"</div>
                                </td>
                                <td width="7%">
                                    <div align="center"><?php echo $prodcantidad;?></div>
                                </td>
                                <td width="15%"
                                    style="background-color:<?php echo $color_f; ?>;color:white;font-weight:bold;">
                                    <div
                                        align="center"><?php echo $cantidad_entregada . " de " . $prodcantidad; ?></div>
                                </td>
                                <td width="10%">
                                    <div align="center"><?php echo $cantidad_vendida;?></div>
                                </td>
                                <td width="6%">
                                    <div align="center">
                                        <a id="ver_detalles_guias"
                                           href="<?php echo base_url();?>index.php/almacen/guiarem/ver_guias_x_orden_producto/<?php echo $tipo_oper; ?>/<?php echo $tipo_oper; ?>/<?php echo $codigo;?>/<?php echo $prodproducto; ?>">
                                            <img src="<?php echo base_url() ?>images/ver_guias.png" width="14px"
                                                 height="14px" style="border:none;" title="ver guias" alt="ver guias"/></a>
                                    </div>
                                </td>
                                <td width="6%">
                                    <div align="center">
                                        <a id="ver_detalles_guias"
                                           href="<?php echo base_url();?>index.php/ventas/comprobante/ver_comprobantes_x_orden_producto/<?php echo $tipo_oper; ?>/<?php echo $tipo_oper; ?>/<?php echo $codigo;?>/<?php echo $prodproducto; ?>">
                                            <img src="<?php echo base_url() ?>images/ver_guias.png" width="14px"
                                                 height="14px" style="border:none;" title="ver Comprobantes"
                                                 alt="ver Comprobantes"/></a>
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
        <div id="frmBusqueda3">
            <table width="100%" border="0" align="right" cellpadding=3 cellspacing=0 class="fuente8">
                <tr>
                    <td valign="top">
                        <table width="100%" border="0" align="right" cellpadding=3 cellspacing=0 class="">
                            <tr>
                                <td colspan="2" height="25"><b>INFORMACION DE LA ENTREGA </b></td>
                                <td height="25"><b>ESTADO</b></td>
                            </tr>
                            <tr>
                                <td width="100">Lugar de entrega</td>
                                <td width="340">
                                    <?php echo $envio_direccion; ?>
                                </td>
                                <td>
                                    <?php
                                    if ($estado == '1') {
                                        echo "Activo";
                                    } else {
                                        echo "Anulado";
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Facturar en</td>
                                <td>
                                    <?php echo $fact_direccion; ?>
                                </td>
                                <td height="25"><b>OBSERVACION</b></td>
                            </tr>
                            <tr>
                                <td>Fecha límite entrega</td>
                                <td>
                                    <?php echo $fechaentrega; ?>
                                </td>
                                <td rowspan="3" valign="top"><textarea id="observacion" name="observacion"
                                                                       class="cajaTextArea" style="width:97%"
                                                                       readonly="readonly"
                                                                       rows="4"><?php echo $observacion; ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td><b>CTA. CTE.</b></td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>Cta. Cte. S/.</td>
                                <td><?php echo $ctactesoles; ?>
                                    Cta. Cte. US$ <?php echo $ctactedolares; ?></td>
                            </tr>
                        </table>
                    </td>
                    <td width="10%" valign="top">
                        <table width="100%" border="0" align="right" cellpadding=3 cellspacing=0 class=""
                               style="margin-top:20px;">
                            <tr>
                                <td>Sub-total</td>
                                <td width="10%" align="right">
                                    <div align="right">
                                        <input class="cajaGeneral cajaSoloLectura" size="5"  type="text" value="<?php echo round($preciototal, 2); ?>" />
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="busqueda">Descuento</td>
                                <td align="right">
                                    <div align="right">
                                        <input class="cajaGeneral cajaSoloLectura" size="5" type="text" value="<?php echo round($descuentotal, 2); ?>" />
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="busqueda">IGV</td>
                                <td align="right">
                                    <div align="right">
                                        <input class="cajaGeneral cajaSoloLectura" size="5" type="text" value="<?php echo round($igvtotal, 2); ?>" />
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="busqueda">Precio Total</td>
                                <td align="right">
                                    <div align="right">
                                        <input class="cajaGeneral cajaSoloLectura" size="5" type="text" value="<?php echo round($importetotal, 2); ?>" />
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="busqueda">Percepci&oacute;n</td>
                                <td align="right">
                                    <div align="right">
                                        <input class="cajaGeneral cajaSoloLectura" size="5" type="text" value="<?php echo round($percepciontotal, 2); ?>" />
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

        </div>
        <br/>

        <div style="margin-top:170px; clear:both">
            <img id="loading" src="<?php echo base_url(); ?>images/loading.gif" style="visibility: hidden"/>
            <a href="javascript:;" id="aceptarOcompra"><img src="<?php echo base_url(); ?>images/botonaceptar.jpg"
                                                            width="85" height="22" class="imgBoton"></a>
            <?php echo $oculto ?>
        </div>
    </div>
</form>
