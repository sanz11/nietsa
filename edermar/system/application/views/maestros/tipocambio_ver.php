<script type="text/javascript" src="<?php echo base_url();?>js/jquery.metadata.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.validate.js"></script>		
<script type="text/javascript" src="<?php echo base_url();?>js/maestros/tipocambio.js"></script>		
<div id="pagina">
    <div id="zonaContenido">
        <div align="center">
        <div id="tituloForm" class="header"><?php echo $titulo;?></div>
        <div id="frmBusqueda">
            <table width="250" cellspacing="0" cellpadding="6" border="0">
                <?php 
                    $reg_sol=$lista_monedas[0];
                    foreach($lista_monedas as $item=>$reg){
                        if($reg->MONED_Codigo!=1){
                            echo '<tr>';
                            echo '<td>'.$reg_sol->MONED_Descripcion.' ('.$reg_sol->MONED_Simbolo .')'.' a '.$reg->MONED_Descripcion.' ('.$reg->MONED_Simbolo.')'.'</td>';
                            echo '</tr>';
                            echo '<tr>';
                            echo '<td class="cajaTextoGrande">'.$valores[$reg->MONED_Codigo].'&nbsp;</td>';
                            echo '</tr>';
                        } 
                    }
                ?>

            </table>
            <br/>
            <?php echo $oculto;?>
        </div>
        <div id="botonBusqueda">
            <a href="#" onclick="atras_tipocambio();"><img src="<?php echo base_url();?>images/botonaceptar.jpg" width="85" height="22" border="1"></a>
        </div>
    </div>
  </div>
</div>