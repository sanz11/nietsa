<script type="text/javascript" src="<?php echo base_url();?>js/almacen/almacenproducto.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/funciones.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script type="text/javascript">
    $(document).ready(function() {
        $("a#linkSerie").fancybox({
                'width'	     : 750,
                'height'         : 540,
                'autoScale'	     : false,
                'transitionIn'   : 'none',
                'transitionOut'  : 'none',
                'showCloseButton': false,
                'modal'          : false,
                'type'	     : 'iframe'
        });
        
        $('#limpiar').click(function(){
            
        location.href="<?php echo base_url() ?>index.php/almacen/almacenproducto/listar";  
        });
    });
</script>
<div id="pagina">
    <div id="zonaContenido">
    <div align="center">
        <div id="tituloForm" class="header"><?php echo $titulo_tabla;;?></div>


        <div id="frmBusqueda" >
		<input type="hidden" name="almacen_id" id="almacen_id" value="<?php echo $_SESSION['compania'];?>">
        <?php echo $form_open;?>
            <table class="fuente8" width="98%" cellspacing="0" cellpadding="3" border="0">
                <tr>
                    <td align='left' width="8%">Producto</td>
                    <td align='left' width="20%"><input name="nombre_prod" style="text-transform:uppercase;" id="nombre_prod" type="text" value="<?php echo $nombre_prod ?>" /></td>
                    
                    <td align='left'> <a href="#" id="limpiar" ><img src="<?php echo base_url();?>images/botonlimpiar.jpg" width="69" height="22" class="imgBoton" onMouseOver="style.cursor=cursor"></a>&nbsp;&nbsp;&nbsp;</td>
                    <td align='center'>
                        <a href="#" id="buscarStock"><img src="<?php echo base_url();?>images/botonbuscar.jpg" width="69" height="22" class="imgBoton" onMouseOver="style.cursor=cursor"></a>&nbsp;&nbsp;&nbsp;&nbsp;
                           
                    </td>
                    <td align='left' width="60%">&nbsp;</td>
                    <td align='left'>&nbsp;</td>
                </tr>
            </table>
        <?php echo $form_close;?>
        </div>
        <!-- <div id="lineaResultado" style="margin-top:20px">
            <table class="fuente8" width="100%" cellspacing=0 cellpadding=3 border=0>
                <tr>
                   <td width="50%" align="left">N de articulos encontrados:&nbsp;<?php echo $registros;?> </td>
                    <td width="50%" align="right">&nbsp;</td>
                </tr>
            </table>
        </div>-->
        <div id="frmResultado">
            <?php echo $form_open2;?>
            <input type="hidden" name="compania" id="compania"/>
            <input type="hidden" name="almacen" id="almacen" />
            <input type="hidden" name="producto" id="producto" />
            <input type="hidden" name="codproducto" id="codproducto" />
            <input type="hidden" name="nombre_producto" id="nombre_producto" />
            <a href="javascript:;" id="linkSerie"></a>
            <table class="fuente8" width="100%" cellspacing="0" cellpadding="3" border="0" ID="Table1">
                <tr class="cabeceraTabla">
                    <td width="5%">ITEM</td>
                    <td width="20%">CODIGO</td>
                    <td width="60%">DESCRIPCION</td>
                    <td width="25%">FABRICANTE</td>
                    <td width="5%">STOCK</td>
                    <td width="5%">UND</td>
                    <!--<td width="5%">COSTO</td>
                    <td width="5%">VALOR</td>-->
                    <td width="5%">ALMACEN</td>
                    <td width="5%">KARDEX</td>
                </tr>
                <?php
                if(count($lista)>0){
                    foreach($lista as $indice=>$valor)
                    {
                        $class = $indice%2==0?'itemParTabla':'itemImparTabla';
                        $flagGenInd = $valor[9];
                        $producto   = $valor[10];
                        $stock      = $valor[4];
                        ?>
                        <tr class="<?php echo $class;?>">
                        <td><div align="center"><?php echo $valor[0];?></div></td>
                        <td><div align="center"><?php echo $valor[1];?></div></td>
                        <td>
                            <div align="left">
                                <input type="hidden" name="prodcodigo[<?php echo $indice;?>]" id="prodcodigo[<?php echo $indice;?>]" value="<?php echo $producto;?>">
                                <input type="hidden" name="prodcantidad[<?php echo $indice;?>]" id="prodcantidad[<?php echo $indice;?>]" value="<?php echo $stock;?>">
                                <?php
                                if($flagGenInd=="I" && $stock>0){
                                    ?>
                                   <a href="#" onclick="ventana_producto_serie0(<?php echo $indice;?>)"><img src="<?php echo base_url();?>images/flag-green_icon.png" width="15" height="15" border="0"/></a>
                                    <?php
                               }
                                echo $valor[2];
                                ?>
                            </div>
                        </td>
                        <td><div align="left"><?php echo $valor[3];?></div></td>
                        <td><div align="center"><?php echo $valor[4];?></div></td>
                        <td><div align="right"><?php echo $valor[5];?></div></td>
                        <!--<td><div align="right"><?php echo number_format($valor[6],2);?></div></td>
                        <td><div align="right"><?php echo number_format($valor[7],2);?></div></td>-->
                        <td><div align="center"><?php echo $valor[11];?></div></td>
                        <td><div align="center"><?php echo $valor[8];?></div></td>
                        </tr>

                        <?php
                    }
                }
                else{
                ?>
                <table width="100%" cellspacing="0" cellpadding="3" border="0" class="fuente8">
                    <tbody>
                        <tr>
                            <td width="100%" class="mensaje">No hay ning&uacute;n registro que cumpla con los criterios de b&uacute;squeda</td>
                        </tr>
                    </tbody>
                </table>
                <?php
                }
                ?>
            </table>
            <?php echo $form_close2;?>
        </div>
         <div style="margin-top: 15px;"><?php echo $paginacion;?></div>
      
        <input type="hidden" id="iniciopagina" name="iniciopagina">
        <input type="hidden" id="cadena_busqueda" name="cadena_busqueda">
        <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
    </div>
</div>			
</div>