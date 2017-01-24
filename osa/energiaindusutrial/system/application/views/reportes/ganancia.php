<script type="text/javascript" src="<?php echo base_url();?>js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script>
    $(document).ready(function(){
        $('#verReporte').click(function(){
            $('#frmReporte').submit();
            return true;
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
        $('input[name^="COMPANIA_"]').click(function(){
            if($(this).is(':checked')==false)
                $('input[name^="TODOS"]').attr('checked', false);
        });
        $('input[name="TODOS"]').click(function(){
            $('input[name^="COMPANIA_"]').attr('checked', false);
            if($(this).is(':checked'))
                $('input[name^="COMPANIA_"]').attr('checked', true);
        });
    });
    
    function seleccionar_producto(codigo,interno,familia,stock,costo,flagGenInd){
        $("#producto").val(codigo);
        $("#codproducto").val(interno);
        listar_unidad_medida_producto(codigo);
    }
    function listar_unidad_medida_producto(producto){   
        base_url   = $("#base_url").val();
        url          = base_url+"index.php/almacen/producto/listar_unidad_medida_producto/"+producto;
        select   = document.getElementById('unidad_medida');
        $.getJSON(url,function(data){
          $.each(data, function(i,item){
                nombre_producto = item.PROD_Nombre;
          });
          $("#nombre_producto").val(nombre_producto);
        });
    }
    
</script>
<div id="pagina">
    <div id="zonaContenido">
    <div align="center">
    <div id="tituloForm" class="header">REPORTES DE GANANCIAS POR PRODUCTO</div>
    <div id="frmBusqueda">
      <form method="post" action="" id="frmReporte">
        <table class="fuente8" width="100%" cellspacing=0 cellpadding=3 border=0>
            <tr>
                <td>Producto</td>
                <td>
                    <input name="producto" type="hidden" class="cajaGeneral" id="producto" value="<?php echo $producto; ?>" />
                    <input name="buscar_producto" type="text" class="cajaGeneral" id="buscar_producto" size="10" />&nbsp;
                    <input name="codproducto" type="hidden" class="cajaGeneral" id="codproducto" size="10" maxlength="20" onblur="obtener_producto();" value="<?php echo $codproducto; ?>" />
                    <input NAME="nombre_producto" type="text" class="cajaGeneral cajaSoloLectura" id="nombre_producto" size="40" readonly="readonly" value="<?php echo $nombre_producto; ?>" />
                    <a href="<?php echo base_url();?>index.php/almacen/producto/ventana_busqueda_producto/" id="linkVerProducto"><img height='16' width='16' src='<?php echo base_url(); ?>/images/ver.png' title='Buscar' border='0' /></a>
                </td>
                <td>Moneda *</td>
                <td><?php echo $cboMoneda; ?></td>
            </tr>
            <tr>
                <td width="10%" height="30">Fecha de Inicio</td>
                <td width="50%"><input NAME="fecha_inicio" id="fecha_inicio" type="text" class="cajaGeneral" value="<?php echo $f_ini; ?>" size="10" maxlength="10" />
                    <img height="16" border="0" width="16" id="Calendario1" name="Calendario1" src="<?php echo base_url();?>images/calendario.png" />
                    <script type="text/javascript">
                        Calendar.setup({
                            inputField     :    "fecha_inicio",
                            ifFormat       :    "%d/%m/%Y",
                            button         :    "Calendario1"
                        });
                    </script>
                </td>
                <td width="10%" rowspan="2" valign="top">Establecimiento</td>
                <td rowspan="2" valign="top">
                    <ul style="list-style: none; margin: 0px; padding: 0px;">
                        <li><input type="checkbox" name="TODOS" id="TODOS" value="1" <?php if($TODOS==true) echo 'checked="checked"'; ?> />TODOS</li>
                   <?php 
                   foreach($lista_companias as $valor){
                        echo '<li><input type="checkbox" name="COMPANIA_'.$valor->COMPP_Codigo.'" id="COMPANIA_'.$valor->COMPP_Codigo.'" value="1" '.($valor->checked==true ? 'checked="checked"' : '').' />'.$valor->EESTABC_Descripcion.'</li>';
                    }
                   ?>
                   </ul>
                </td>
            </tr>
            <tr>
                <td valign="top">Fecha Fin</td>
                <td valign="top"><input NAME="fecha_fin" id="fecha_fin" type="text" class="cajaGeneral" value="<?php echo $f_fin; ?>" size="10" maxlength="10" />
                    <img height="16" border="0" width="16" id="Calendario2" name="Calendario2" src="<?php echo base_url();?>images/calendario.png" />
                    <script type="text/javascript">
                        Calendar.setup({
                            inputField     :    "fecha_fin",
                            ifFormat       :    "%d/%m/%Y",
                            button         :    "Calendario2"
                        });
                    </script>
                </td>
            </tr>
            <tr>
                <td colspan="4" align="center"><a href="javascript:;" id="verReporte"><img src="<?php echo base_url();?>images/botonreporte.jpg" width="85" height="22" class="imgBoton" align="absmiddle"/></a></td>
            </tr>
        </table>
        <?php echo $oculto; ?>
      </form>
      </div>
      <div id="frmResultado">
                <table class="fuente8" width="100%" cellspacing=1 cellpadding="3" border=0>
                        <tr class="cabeceraTabla">
                                <th>Fecha</th>
                                <th>Establec</th>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Moneda</th>
                                <th>PU. Costo</th>
                                <th>PU. Venta</th>
                                <th>Costo</th>
                                <th>Venta</th>
                                <th>Utilidad</th>
                                <th>% Utilidad</th>
                        </tr>
                        <?php
                        if(count($lista) > 0){
                                foreach($lista as $indice=>$value):
                                $class = $indice%2==0?'itemParTabla':'itemImparTabla';
                                ?>
                                <tr class="<?php echo $class;?>">
                                        <td><div align="center"><?php echo $value[0]; ?></div></td>
                                        <td><div align="left"><?php echo $value[1]; ?></div></td>
                                        <td><div align="left"><?php echo $value[2]; ?></div></td>
                                        <td><div align="center"><?php echo $value[3]; ?></div></td>
                                        <td><div align="center"><?php echo $value[4]; ?></div></td>
                                        <td><div align="right"><?php echo $value[5]; ?></div></td>
                                        <td><div align="right"><?php echo $value[6]; ?></div></td>
                                        <td><div align="right"><?php echo $value[7]; ?></div></td>
                                        <td><div align="right"><?php echo $value[8]; ?></div></td>
                                        <td><div align="right"><?php echo $value[9]; ?></div></td>
                                        <td><div align="right"><?php echo $value[10]; ?></div></td>
                                </tr>
                        <?php
                                endforeach;
                        }else{
                        ?>
                                        <td colspan="9"><div align="center">No hay ningún registro que cumpla con los criterios de búsqueda</div></td>
                        <?php
                        }
                        ?>
                        <tr>
                                <td colspan="7"><div align="right"><strong>TOTALES</strong></div></td>
                                <td><div align="right"><strong><?php echo $total_costo; ?></strong></div></td>
                                <td><div align="right"><strong><?php echo $total_venta; ?></strong></div></td>
                                <td><div align="right"><strong><?php echo $total_util; ?></strong></div></td>
                                <td><div align="right"><strong><?php echo $total_porc_util; ?></strong></div></td>

                        </tr>
                </table>
                <div class="fuente8" align="left"><b>RESUMEN POR ESTABLECIMIENTO</b></div>
                <table class="fuente8" width="40%" cellspacing=1 cellpadding="3" border=0 align="left">
                        <tr class="cabeceraTabla">
                                <th>Establec</th>
                                <th>Costo</th>
                                <th>Venta</th>
                                <th>Utilidad</th>
                                <th>% Utilidad</th>
                        </tr>
                        <?php
                        if(count($lista_companias) > 0){
                                foreach($lista_companias as $indice=>$value){
                                $class = $indice%2==0?'itemParTabla':'itemImparTabla';
                                ?>
                                <tr class="<?php echo $class;?>">
                                        <td><div align="left"><?php echo $value->EESTABC_Descripcion; ?></div></td>
                                        <td><div align="right"><?php echo $resumen_compania[$value->COMPP_Codigo]['costo']; ?></div></td>
                                        <td><div align="right"><?php echo $resumen_compania[$value->COMPP_Codigo]['venta']; ?></div></td>
                                        <td><div align="right"><?php echo $resumen_compania[$value->COMPP_Codigo]['util']; ?></div></td>
                                        <td><div align="right"><?php echo $resumen_compania[$value->COMPP_Codigo]['porc']; ?></div></td>
                                </tr>
                        <?php
                                }
                        }else{
                        ?>
                                        <td colspan="4"><div align="center">No hay ningún registro que cumpla con los criterios de búsqueda</div></td>
                        <?php
                        }
                        ?>
                            <tr>
                                <td><div align="right"><b>TOTALES</b></div></td>
                                <td><div align="right"><b><?php echo $t_resumen_costo; ?></b></div></td>
                                <td><div align="right"><b><?php echo $t_resumen_venta; ?></b></div></td>
                                <td><div align="right"><b><?php echo $t_resumen_util; ?></b></div></td>
                                <td><div align="right"><b><?php echo $t_resumen_porc; ?></b></div></td>
                            </tr>
                </table>
        </div>
    </div>
    </div>
</div>