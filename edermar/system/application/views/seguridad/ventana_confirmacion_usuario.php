<html>
<head>
    <title></title>
    <link href="<?php echo base_url(); ?>css/estilos.css" type="text/css" rel="stylesheet">
    <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/funciones.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/seguridad/usuario.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>js/fancybox/jquery.fancybox-1.3.4.css"
          media="screen"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

</head>
<body onload="<?php echo $onload; ?>">
<div align="center">
    <form name="form_busqueda" id="form_busqueda" method="post" action="<?php echo $action; ?>">
    <input type="hidden" value="<?php echo $comprobante; ?>" id="comprobante" name="comprobante" >
    <input type="hidden" value="<?php echo $rolinicio; ?>" id="rolinicio" name="rolinicio" >
        <div id="frmBusqueda" style="width:95%">
            <table class="fuente8" width="100%" cellspacing=0 cellpadding=3 border=0>
                <tr class="cabeceraTabla" height="25px">
                    <td align="center" colspan="3"><?php echo $img; ?><?php echo $titulo; ?></td>
                </tr>
                <?php
                foreach ($campos as $indice => $valor) {
                    ?>
                    <tr>
                        <td width="16%"><?php echo $campos[$indice];?></td>
                        <td><?php echo $valores[$indice]?></td>
                    </tr>
                <?php
                }
                ?>
                <tr>

                    <td></td>
                    <td align="right"><?php echo $nota ?> <input type="hidden" id="txtRol" name="txtRol"
                                                                 value="<?php echo $_SESSION['compania']; ?>">
                        <a href="javascript:;" id="<?php echo $btnAceptar; ?>"><img
                                src="<?php echo base_url(); ?>/images/botonaceptar.jpg" width="85" height="22"
                                class="imgBoton"></a>
                        <a href="javascript:;" id="cerrarUsuario"><img
                                src="<?php echo base_url(); ?>images/botoncerrar.jpg" class="imgBoton"/></a>
                    </td>
                </tr>
            </table>
            <br/>
        </div><?php echo $oculto; ?>
        <div id="lineaResultado" style="width:95%; margin-top:10px">
        </div>

        <input type="hidden" name="base_url" id="base_url" value=""/>
        <input type="hidden" name="flagBS" id="flagBS" value=""/>

    </form>
    <div style="margin-top:15px" class="fuente8"></div>
</div>
</body>
</html>