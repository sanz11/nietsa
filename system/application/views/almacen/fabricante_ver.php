<script type="text/javascript" src="<?php echo base_url();?>js/almacen/fabricante.js"></script>
<div id="pagina">
    <div id="zonaContenido">
        <div align="center">
        <div id="tituloForm" class="header"><?php echo $titulo;?></div>
        <div id="frmBusqueda">
            <table class="fuente8" width="98%" cellspacing="0" cellpadding="3" border="0">
                <tr>
                    <td width="15%">CODIGO</td>
                    <td width="85%" colspan="2"><?php echo $fabricante;?></td>
                </tr>
                <tr>
                    <td width="15%">NOMBRE FABRICANTE</td>
                    <td width="85%" colspan="2"><?php echo $nombre_fabricante;?></td>
                </tr>
            </table>
            <?php echo $oculto;?>
        </div>
        <div id="botonBusqueda">
                <a href="#" onclick="atras_fabricante();"><img src="<?php echo base_url();?>images/botonaceptar.jpg" width="85" height="22" border="1"></a>
        </div>
        </div>
    </div>
</div>