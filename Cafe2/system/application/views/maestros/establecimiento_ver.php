<script type="text/javascript" src="<?php echo base_url();?>js/jquery.metadata.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.validate.js"></script>		
<script type="text/javascript" src="<?php echo base_url();?>js/maestros/establecimiento.js"></script>
<div id="pagina">
    <div id="zonaContenido">
        <div align="center">
            <div id="tituloForm" class="header"><?php echo $titulo;?></div>
            <div id="frmBusqueda">
                <table class="fuente8" width="98%" cellspacing="0" cellpadding="3" border="0">
                    <tr>
                        <td width="15%">C&oacute;digo</td>
                        <td width="85%" colspan="2"><?php echo $datos_establecimiento[0]->TESTP_Codigo;?></td>
                    </tr>
                    <tr>
                        <td width="15%">Nombre</td>
                        <td width="85%" colspan="2"><?php echo $datos_establecimiento[0]->TESTC_Descripcion;?></td>
                        <?php echo $oculto;?>
                    </tr>
                </table>
            </div>
            <div id="botonBusqueda">
                <a href="#" onclick="atras_establecimiento();"><img src="<?php echo base_url();?>images/botonaceptar.jpg" width="85" height="22" border="1"></a>
            </div>
        </div>
    </div>
</div>