<?php
$nombre_persona = $this->session->userdata('nombre_persona');
$persona = $this->session->userdata('persona');
$usuario = $this->session->userdata('usuario');
$url = base_url() . "index.php";
if (empty($persona))
    header("location:$url");
?>
<html>
    <head>
        <title><?php echo TITULO; ?></title>
        <link href="<?php echo base_url(); ?>css/estilos.css" type="text/css" rel="stylesheet">
        <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/almacen/ventana_familia.js"></script>
    </head>
    <body <?php echo $onload; ?>>	
        <div id="zonaContenido">
            <div id="pagina" align="center">
                <div id="tituloForm" style="width:95%" class="header"><?php echo $titulo; ?></div>
                <div id="frmBusqueda" style="width:95%"  align='left'>
                    <?php echo validation_errors("<div class='error'>", '</div>'); ?>
                    <form id="<?php echo $formulario; ?>" method="post" action="<?php echo base_url(); ?>index.php/almacen/familia/ventana_busqueda_familia/<?php echo $flagBS; ?>">
                        <?php echo $fila; ?>
                        <input type="hidden" id="flagBS" name="flagBS" value="<?php echo $flagBS; ?>"/>
                        <input type="hidden" id="codfamilia" name="codfamilia" value="<?php echo $codproducto; ?>"/>
                        <input type="hidden" id="idfamilia" name="idfamilia" value="<?php echo $idfamilia; ?>"/>
                        <br>					
                        <div id="botonBusqueda" style="width:85%">
                            <a href="#" id="seleccionarFamilia"><img src="<?php echo base_url(); ?>images/botonaceptar.jpg" width="85" height="22" border="1" ></a>						
                            <a href="#" id="cancelarFamilia"><img src="<?php echo base_url(); ?>images/botoncancelar.jpg" width="85" height="22" border="1" ></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
