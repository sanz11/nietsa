<script type="text/javascript" src="<?php echo base_url();?>js/jquery.metadata.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.validate.js"></script>		
<script type="text/javascript" src="<?php echo base_url();?>js/seguridad/impactousuario.js"></script>		
<div id="pagina">
    <div id="zonaContenido">
        <div align="center">
        <div id="tituloForm" class="header"><?php echo $titulo;?></div>
        <div id="formBusqueda">
            <table width="250" cellspacing="10" cellpadding="6" border="0">
                <?php 
                    foreach($lista as $indice=>$valor){
                ?>
                <tr>
                    <td>Usuario : </td>
                    <td><?php echo $valor[2];?></td>
                </tr>
                
                <tr>
                    <td>Fecha de Registro : </td>
                    <td><?php echo $valor[3];?></td>
                </tr>
                <?php
                    }
                ?>
            </table>
            <br/>
            <?php echo $oculto;?>
        </div>
        <div id="botonBusqueda">
            <a href="#" onclick="atras_recepcionproveedor();"><img src="<?php echo base_url();?>images/botonaceptar.jpg" width="85" height="22" border="1"></a>
        </div>
    </div>
  </div>
</div>