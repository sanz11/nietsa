<script type="text/javascript" src="<?php echo base_url();?>js/almacen/guiatrans.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script type="text/javascript">
    $(document).ready(function() {
        $("#linkSelecProducto").fancybox({
            'width'	     : 800,
            'height'         : 500,
            'autoScale'	     : false,
            'transitionIn'   : 'none',
            'transitionOut'  : 'none',
            'showCloseButton': false,
            'modal'          : false,
            'type'	     : 'iframe'
        });
        $("a#linkVerProducto").fancybox({
            'width'	     : 800,
            'height'         : 650,
            'autoScale'	     : false,
            'transitionIn'   : 'none',
            'transitionOut'  : 'none',
            'showCloseButton': false,
            'modal'          : true,
            'type'	     : 'iframe'
        });
        $("#linkConfirmarUsuario").fancybox({
            'width'	     : 600,
            'height'         : 250,
            'autoScale'	     : false,
            'transitionIn'   : 'none',
            'transitionOut'  : 'none',
            'showCloseButton': false,
            'modal'          : true,
            'type'	     : 'iframe'
        });
    });

    function escribe_nombre_unidad_medida(){
        index     = document.getElementById("unidad_medida").selectedIndex;
        nombre = document.getElementById("unidad_medida").options[index].text;
        $("#nombre_unidad_medida").val(nombre);
    }
    function seleccionar_producto(codigo,interno,familia,stock,costo,flagGenInd){
        $("#producto").val(codigo);
        $("#codproducto").val(interno);
        $("#nombre_familia").val(familia);
        $("#stock").val(stock);
        $("#costo").val(costo);
        $("#cantidad").select();
        $("#flagGenInd").val(flagGenInd);

        listar_unidad_medida_producto(codigo);
    }

    $(function () {
        $("#buscar_producto").autocomplete({
            //flag = $("#flagBS").val();
            source: function (request, response) {
                var  almacen_original = $("#almacen").val();
                if(almacen_original == 0 || almacen_original == '0'){
                    alert('Seleccione el almacen!');
                    return false;
                }
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/almacen/producto/autocompletado_producto_x_nombre/",
                    type: "POST",
                    dataType: "json",
                    data: {
                        term: $("#buscar_producto").val(),
                        flag : $('#flagBS').val(),
                        compania : $('#compania').val(),
                        almacen : almacen_original
                    },
                    beforeSend: function(data){

                    },
                    success: function (data) {
                        response(data);
                    },
                    error: function(XHR, error){
                        console.log('errorr');
                        console.log(error);
                    }
                });
            },
            select: function (event, ui) {
                $("#buscar_producto").val(ui.item.codinterno);
                $("#producto").val(ui.item.codigo);
                $("#codproducto").val(ui.item.codinterno);
                $("#costo").val(ui.item.pcosto);
                $('#sotckGeneral').val(ui.item.stock);
                $("#cantidad").focus();
                listar_unidad_medida_producto(ui.item.codigo);
            },
            minLength: 3
        });
        //****** nuevo para ruc
        $("#buscar_cliente").autocomplete({
            //flag = $("#flagBS").val();
            source: function (request, response) {
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/ventas/cliente/autocomplete_ruc/",
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

        /* Descativado hasta corregir vico 22082013 - quien es vico? (fixed) - pregunto lo mismo quien es vicio(ABAc). */
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
                    url: "<?php echo base_url(); ?>index.php/compras/proveedor/autocomplete/",
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
            minLength: 2
        });

        //****** nuevo para ruc PROVEEDOR
        $("#buscar_proveedor").autocomplete({
            //flag = $("#flagBS").val();
            source: function (request, response) {
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/compras/proveedor/autocomplete_ruc/",
                    type: "POST",
                    data: {
                        term: $("#buscar_proveedor").val()
                    },
                    dataType: "json",
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
            minLength: 4
        });


    });
    function Plimpiar(){
        $("#buscar_producto").val("");
        $("#producto").val("");
        $("#nombre_producto").val("");
        $("#costo").val("");
        $("#stock").val("");
        $("#simbolo").val("");
        $("#codproducto").val("");
        $("#nombre_familia").val("");
        $("#buscar_producto").focus();
    }

    function mostrarStockGeneral(codigo){

        $('#sotckGeneral').val(codigo);

    }

</script>
<input name="compania" type="hidden" id="compania" value="<?php echo $compania; ?>">
<input type="hidden" name="codigoguiain" id='codigoguiain' value='<?php echo $codguiain?>'>
<input type="hidden" name="codigoguiasa" id='codigoguiasa' value='<?php echo $codguiasa?>'>
<input type="hidden" name="tipoguia" id='tipoguia' value='<?php echo $tipoguia?>'>
<?php echo $form_open;?>
<div id="zonaContenido" align="center">
    <div id="tituloForm" class="header"><?php echo $titulo;?></div>
    <div id="frmBusqueda">
        <table class="fuente8" width="100%" cellspacing="0" cellpadding="5" border="0">
            <tr>
                <input type="hidden" name="codigo_guiatrans" id='codigo_guiatrans' value='<?php echo $codigo?>'>
                <td  width="22%" valign="top" >N&uacute;mero
                    <?php
                    switch($tipo_codificacion){
                        case '1': echo '<input type="text" name="numero" id="numero"  value="'.($codigo!='' ? $numero : $numero_suger).'" class="cajaGeneral cajaSoloLectura" readonly="readonly"  size="10" maxlength="10"  />'; break;
                        case '2': echo '<input type="text" name="serie" id="serie" placeholder=""readonly="readonly" value="'.$serie.'" class="cajaGeneral cajaSoloLectura" size="3" maxlength="10"  /> ';
                            echo '<input type="text" name="numero" id="numero" placeholder="" value="'.$numero.'"readonly="readonly" class="cajaGeneral cajaSoloLectura" size="10" maxlength="10"  /> ';
                            echo '<a href="javascript:;" id="linkVerSerieNum"'.($codigo!='' ? 'style="display:none"' : '').'><p style="display:none">'.$serie_suger.'-'.$numero_suger.'</p><image src="'.base_url().'images/flecha.png" border="0" alt="Serie y número sugerido" title="Serie y número sugerido" /></a>'; break;
                        case '3': echo '<input type="text" name="codigo_usuario" id="codigo_usuario" value="'.$codigo_usuario.'" class="cajaGeneral" size="20" maxlength="50"  />'; break;
                    }
                    ?>
                </td>
                <td width="25%">Origen *
                    <select name="almacen" id="almacen" class='comboMedio'>
                        <option value="0">::Seleccione::</option>
                        <?php

                        foreach($listar_almacen as $almacen_ori => $value){
                            ?>
                            <option value="<?php echo $value->ALMAP_Codigo; ?>" <?php if($almacen_ori == 0) echo "selected='selected'" ?> ><?php echo $value->ALMAC_Descripcion . ' - ' . $value->EESTABC_Descripcion; ?></option>
                        <?php
                        }

                        ?>
                    </select>
                </td>
                <td width="35%">Destino *
                <?php echo $cboAlmacenDestino;?></td>
                <td width="20%">F.Traslado*
                <?php echo $fecha;?>
                    <img src="<?php echo base_url();?>images/calendario.png" name="Calendario2" id="Calendario2" width="16" height="16" border="0" id="Image1" onMouseOver="this.style.cursor='pointer'" title="Calendario">
                    <script type="text/javascript">
                        Calendar.setup({
                            inputField     :    "fecha",      // id del campo de texto
                            ifFormat       :    "%d/%m/%Y",       // formato de la fecha, cuando se escriba en el campo de texto
                            button         :    "Calendario2"   // el id del botón que lanzará el calendario
                        });
                    </script>
                </td>
            </tr>

        </table>
    </div>
    <div id="frmBusqueda">
        <table class="fuente8" width="100%" cellspacing=0 cellpadding=3 border=0>
            <tr>
                <!--                <td width="8%">
                                        <select name="flagBS" id="flagBS" style="width:68px;" ass="comboMedio"
                                                onchange="limpiar_campos_producto()">
                                            <option value="B" selected="selected" title="Producto">P</option>
                                            <option value="S" title="Servicio">S</option>
                                        </select>
                                    </td>-->
                <td width="10%">Producto</td>
                <td width="48%">
                    <input type="hidden" name="flagBS" id="flagBS" value="B"   />
                    <input name="producto" type="hidden" class="cajaGeneral" id="producto" />
                    <input name="buscar_producto" type="text" class="cajaGeneral" id="buscar_producto" size="10" placeholder="Producto" onclick="Plimpiar()"/>
                    <input name="codproducto" type="hidden" class="cajaGeneral" id="codproducto" size="10" maxlength="20" onblur="obtener_producto();" />
                    <input name="nombre_producto" type="text" class="cajaGeneral cajaSoloLectura" id="nombre_producto" size="40" readonly="readonly" placeholder="Descripción del Producto"/>
                    <!-- <a href="<?php echo base_url();?>index.php/almacen/producto/ventana_busqueda_producto/" id="linkVerProducto"><img height='16' width='16' src='<?php echo base_url(); ?>/images/ver.png' title='Buscar' border='0' /></a>-->
                    <a href="<?php echo base_url();?>index.php/almacen/producto/ventana_selecciona_producto/" id="linkSelecProducto"></a>
                    <input name="stock" type="hidden" id="stock">
                    <input name="costo" type="hidden" id="costo">
                    <input name="simbolo" type="hidden" id="simbolo">
                    <input name="nombre_familia" type="hidden" id="nombre_familia">
                    <input name="flagGenInd" type="hidden" id="flagGenInd" />
                </td>
                <td width="2%">Cantidad</td>
                <td width="26%">
                    <input name="cantidad" type="text" class="cajaPequena2" id="cantidad" size="5" maxlength="10" onKeyPress="return numbersonly(this,event,'.');" />
                    <select name="unidad_medida" id="unidad_medida" class="comboMedio" onchange="obtener_precio_producto();"><option value="">::Seleccione::</option></select>
                </td>
                <td></td>
            </tr>
            <tr>
                <td>
                    Prod. Stock
                </td>
                <td>
                    <input type="text" readonly="readonly" class="cajaPequena2 cajaSoloLectura" id="sotckGeneral" name="sotckGeneral"/>
                </td>
                <td colspan="4" ><div align="right"><a href="javascript:;" onClick="agregar_producto_guiatrans();"><img src="<?php echo base_url();?>images/botonagregar.jpg" class="imgBoton" align="absbottom"></a></div></td>
            </tr>
        </table>
    </div>
    <div id="frmBusqueda" style="height:250px; overflow: auto">
        <table class="fuente8" width="100%" cellspacing="0" cellpadding="3" border="1" id="Table1">
            <tr class="cabeceraTabla">
                <td width="3%"><div align="center">&nbsp;</div></td>
                <td width="4%"><div align="center">ITEM</div></td>
                <td width="10%"><div align="center">C&Oacute;DIGO</div></td>
                <td><div align="center">DESCRIPCI&Oacute;N</div></td>
                <td width="10%"><div align="center">CANTIDAD</div></td>
            </tr>
        </table>
        <div>
            <table id="tblDetalleGuiaTrans" class="fuente8" width="100%" cellspacing="1" cellpadding="1" border="0">
                <?php
                if(count($detalle)>0){
                    foreach($detalle as $indice=>$valor){
                        $detacodi      = $valor->GTRANDETP_Codigo;
                        $prodproducto    = $valor->PROD_Codigo;
                        $unidad_medida   = $valor->UNDMED_Codigo;
                        $codigo_interno  = $valor->PROD_CodigoUsuario;
                        $prodcantidad    = $valor->GTRANDETC_Cantidad;
                        $nombre_producto = $valor->GTRANDETC_Descripcion;
                        $nombre_unidad   =  $valor->UNDMED_Simbolo;
                        $costo           = $valor->GTRANDETC_Costo;
                        $GenInd          = $valor->GTRANDETC_GenInd;
                        if(($indice+1)%2==0){$clase="itemParTabla";}else{$clase="itemImparTabla";}
                        ?>
                        <tr class="<?php echo $clase;?>">
                            <td width="3%"><div align="center"><font color="red"><strong><a href="javascript:;" onClick="eliminar_producto_guiatrans(<?php echo $indice;?>);"><span style="border:1px solid red;background: #ffffff;">&nbsp;X&nbsp;</span></a></strong></font></div></td>
                            <td width="4%"><div align="center"><?php echo $indice+1;?></div></td>
                            <td width="10%"><div align="center">
                                    <?php echo $codigo_interno;?>
                                    <input type="hidden" class="cajaMinima" name="prodcodigo[<?php echo $indice;?>]" id="prodcodigo[<?php echo $indice;?>]" value="<?php echo $prodproducto;?>" />
                                    <input type="hidden" class="cajaMinima" name="produnidad[<?php echo $indice;?>]" id="produnidad[<?php echo $indice;?>]" value="<?php echo $unidad_medida;?>" />
                                    <input type="hidden" class="cajaMinima" name="flagGenIndDet[<?php echo $indice;?>]" id="flagGenIndDet[<?php echo $indice;?>]" value="<?php echo $GenInd;?>" />
                                </div></td>
                            <td><div align="left">
                                    <input type="text" class="cajaGeneral" style="width:667px;" maxlength="250" name="proddescri[<?php echo $indice;?>]" id="proddescri[<?php echo $indice;?>]" value="<?php echo $nombre_producto;?>" />
                                </div></td>
                            <td width="10%">
                                <div align="left">
                                    <input type="text" class="cajaGeneral" size="1" maxlength="5" name="prodcantidad[<?php echo $indice;?>]" id="prodcantidad[<?php echo $indice;?>]" value="<?php echo $prodcantidad;?>" onblur="calcula_importe(<?php echo $indice;?>);" onKeyPress="return numbersonly(this,event,'.');" /> <?php echo $nombre_unidad;?>
                                    <?php if($GenInd=="I")
                                        echo '<a href="javascript:;" onclick="ventana_producto_serie2t('.$indice.')"><img src="'.base_url(),'images/flag-green_icon.png" width="20" height="20" border="0"/></a>';
                                    ?>
                                    <input type="hidden" class="cajaMinima" name="detaccion[<?php echo $indice;?>]" id="detaccion[<?php echo $indice;?>]" value="m" />
                                    <input type="hidden" class="cajaMinima" name="detacodi[<?php echo $indice;?>]" id="detacodi[<?php echo $indice;?>]" value="<?php echo $detacodi;?>" />
                                    <input type="hidden" class="cajaPequena2" name="prodcosto[<?php echo $indice;?>]" id="prodcosto[<?php echo $indice;?>]" readonly="readonly" value="<?php echo $costo;?>" />
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
    <div id="frmBusqueda3_5">
        <table width="100%" border="0" align="right" cellpadding=0 cellspacing=0 class="fuente8">
            <tr>
                <td>
                    <table class="fuente8" width="100%" border="0" cellpadding="3" cellspacing="0">
                        <tr>
                            <td valign="top">Empresa de Transportes</td>
                            <td valign="top"><?php echo $cboEmpresaTrans ?>
                                <!--                          <select>
                                                              <option value="">::Seleccione::</option>
                                                          </select>-->
                            </td>
                            <td valign="top">PLaca</td>
                            <td width="14%"><input name="placa" type="text" class="cajaGeneral" size="10" value="<?php echo $placa ?>" /></td>
                            <td width="12%">Licencia Conducir</td>
                            <td width="8%"><input name="licencia" type="text" class="cajaGeneral" size="10" value="<?php echo $licencia ?>" /></td>
                            <td width="8%">Chofer</td>
                            <td width="22%"><input name="chofer" type="text" class="cajaGeneral" size="20" value="<?php echo $chofer ?>" /></td>
                        </tr>
                        <tr>
                            <!--<td valign="top" width="18%"><b>ESTADO</b></td>-->
                            <td valign="top" width="11%"><b>OBSERVACION</b></td>
                            <td colspan="6"><textarea id="observacion" name="observacion" class="cajaTextArea" style="width:95%" rows="3"><?php echo $observacion;?>..</textarea></td>
                            <td valign="top" width="7%"><?php echo $estado; ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <?php echo $oculto;?>
        <input type="hidden" class="cajaMinima" name="conforusuario" id="conforusuario" value="" />
    </div>
    <br />
    <table width="100%" border="0" align="" cellpadding=0 cellspacing=0 class="fuente8">

        <tr>
            <td>
                <div style="text-align: center;margin-top: 32px; margin-bottom: 10px" >
                    <img id="loading" src="<?php echo base_url();?>images/loading.gif"  style="visibility: hidden" />
                    <a href="javascript:;" id="grabarGuiatrans"><img src="<?php echo base_url();?>images/botonaceptar.jpg" width="85" height="22" class="imgBoton" /></a>
                    <a href="javascript:;" id="limpiarGuiatrans"><img src="<?php echo base_url();?>images/botonlimpiar.jpg" width="69" height="22" class="imgBoton" /></a>
                    <a href="javascript:;" id="cancelarGuiatrans"><img src="<?php echo base_url();?>images/botoncancelar.jpg" width="85" height="22" class="imgBoton" /></a>
                </div>
            </td>
        </tr>

    </table>

</div>
<?php echo $form_close;?>