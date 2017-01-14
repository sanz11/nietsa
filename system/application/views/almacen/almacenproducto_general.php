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
    });
</script>
<div id="pagina">
    <div id="zonaContenido">
    <div align="center">
        <div id="tituloForm" class="header"><?php echo $titulo_tabla;;?></div>
        <div id="frmBusqueda" >
        <form id="form_busqueda" name="form_busqueda" method="post" action="<?php echo $action;?>">
            <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>					
                <tr>
                    <td width="16%">Cè´¸digo </td>
                    <td width="68%"><input id="txtCodigo" type="text" class="cajaPequena" NAME="txtCodigo" maxlength="30" value="<?php echo $codigo; ?>" />
                    <td width="5%">&nbsp;</td>
                    <td width="5%">&nbsp;</td>
                    <td width="6%" align="right"></td>
                    </tr>
                    <tr>
                                    <td>Nombre</td>
                                    <td><input id="txtNombre" name="txtNombre" type="text" class="cajaGrande" maxlength="100" value="<?php echo $nombre; ?>"></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                    </tr>
                    <!--<tr>
                      <td>Familia</td>
                      <td><input id="txtFamilia" type="text" class="cajaGrande" NAME="txtFamilia" maxlength="100" value="<?php echo $familia; ?>"></td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td>Marca</td>
                      <td><input id="txtMarca" type="text" class="cajaGrande" NAME="txtMarca" maxlength="100" value="<?php echo $marca; ?>"></td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                     </tr>-->
                 </table>
            </form>
        </div>
<div class="acciones">
        <div id="botonBusqueda">
                <ul id="imprimirProducto" class="lista_botones"><li id="imprimir">Imprimir</li></ul>
                <ul id="limpiarProducto" class="lista_botones"><li id="limpiar">Limpiar</li></ul>
                <ul id="buscarProducto" class="lista_botones"><li id="buscar">Buscar</li></ul>   
        </div>
        <div id="lineaResultado" style="margin-top:20px">
            <table class="fuente7" width="100%" cellspacing=0 cellpadding=3 border=0>
                <tr>
                    <td width="50%" align="left">N de articulos encontrados:&nbsp;<?php echo $registros;?> </td>
                </tr>
            </table>
        </div>
</div>
        <div id="frmResultado">
            <form id="frmkardex" name="frmkardex" method="post" action="<?php echo $action2;?>">
            <input type="hidden" name="compania" id="compania"/>
            <input type="hidden" name="almacen_id" id="almacen_id" />
            <input type="hidden" name="producto" id="producto" />
            <a href="javascript:;" id="linkSerie"></a>
            <table class="fuente8" width="100%" cellspacing="0" cellpadding="3" border="0" ID="Table1">
                <tr class="cabeceraTabla">
                    <td width="3%">ITEM</td>
                    <td width="5%">CODIGO</td>
                    <td width="30%">DESCRIPCION</td>
                    <?php foreach($lista_establec as $indice=>$valor){ ?>
                            <td align="center"><?php echo $valor->EESTABC_Descripcion; ?></td>
                    <?php } ?>
                    <td width="4%" align="left">TOTAL</td>
                </tr>
                <?php
                if(count($lista)>0){
                    foreach($lista as $indice=>$valor)
                    {
                        $class = $indice%2==0?'itemParTabla':'itemImparTabla';
                        ?>
                        <tr class="<?php echo $class;?>">
                        <td><div align="center"><?php echo $valor[0];?></div></td>
                        <td><div align="center"><?php echo $valor[3];?></div></td>
                        <td><div align="left"><?php echo $valor[4];?></div></td>
                        <?php 
                              
                            foreach($valor[5] as $indice2=>$valor2){ ?>
                                 <td><div align="left" style="<?php if($valor2>0) echo 'font-weight:bold; color:blue'; ?>"><?php echo $valor2;?>
                                     <?php if($indice2<count($lista_establec)){ ?>
                                             &nbsp;<!--<a href='javascript:;' onclick='ver_kardex("<?php echo $valor[1]; ?>", "<?php echo $lista_establec[$indice2]->COMPP_Codigo; ?>")'><img src='<?php echo base_url()?>images/ver_detalle.png' width='14' height='14' border='0' align='absmiddle' title='Ver Kardex' /></a>-->
                                             <?php if($valor[2]=="I"){?>
                                                <!--<input type="hidden" name="prodcodigo[<?php echo $indice;?>]" id="prodcodigo[<?php echo $indice;?>]" value="<?php echo $valor[1]; ?>" />
                                                <a href="javascript:;" onclick="ventana_producto_serie0(<?php echo $indice;?>, <?php echo $lista_establec[$indice2]->COMPP_Codigo; ?>)"><img src="<?php echo base_url();?>images/flag-green_icon.png" width="15" height="15" border="0" align='absmiddle' title="Ver Series"/></a>-->
                                             <?php } ?>
                                    <?php } ?>
                                 </div></td>
                             <?php } ?>
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
            </form>
        </div>
        <div style="margin-top: 15px;"><?php echo $paginacion;?></div>
        <input type="hidden" id="iniciopagina" name="iniciopagina">
        <input type="hidden" id="cadena_busqueda" name="cadena_busqueda">
        <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
    </div>
</div>			
</div>