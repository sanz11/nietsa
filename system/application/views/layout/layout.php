<?php
$CI = get_instance();
$this->load->model('maestros/directivo_model');
$this->load->model('almacen/producto_model');
$this->load->model('seguridad/usuario_model');
$nombre_empresa = $this->session->userdata('nombre_empresa');
$nombre_persona = $this->session->userdata('nombre_persona');
$persona = $this->session->userdata('persona');
$user = $this->session->userdata('user');
$nom_user = $this->session->userdata('user_name');
$url = base_url() . "index.php/salir_sistema";
$desc_rol = $this->session->userdata('desc_rol');



if (empty($persona))
    header("location:$url");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <title><?php echo TITULO; ?></title>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/calendario/calendar-win2k-2.css" type="text/css" media="all" title="win2k-cold-1" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/estilos.css" type="text/css"/>
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/nav.css" type="text/css"/>
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/ui-lightness/jquery-ui-1.8.18.custom.css" type="text/css"/>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/funciones.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-ui.custom.min.js"></script>
        <!-- Calendario -->
        <script type="text/javascript" src="<?php echo base_url(); ?>js/calendario/calendar.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/calendario/calendar-es.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/calendario/calendar-setup.js"></script>
        <!-- Calendario -->
        <script language="javascript">
            var cursor;
            if (document.all) {
                // Est� utilizando EXPLORER
                cursor='hand';
            } else {
                // Est� utilizando MOZILLA/NETSCAPE
                cursor='pointer';
            }
        </script>
        <script language="javascript">
            $(document).ready(function(){  
        
                $("ul.subnav").parent().append("<span></span>"); //Only shows drop down trigger when js is enabled (Adds empty span tag after ul.subnav*)  
                $("ul.topnav li span").click(function() { //When trigger is clicked...  
      
                    //Following events are applied to the subnav itself (moving subnav up and down)  
                    $(this).parent().find("ul.subnav").slideDown('fast').show(); //Drop down the subnav on click  
      
                    $(this).parent().hover(function() {  
                    }, function(){  
                        $(this).parent().find("ul.subnav").slideUp('slow'); //When the mouse hovers out of the subnav, move it back up  
                    });  
      
                    //Following events are applied to the trigger (Hover events for the trigger)  
                }).hover(function() {  
                    $(this).addClass("subhover"); //On hover over, add class "subhover"  
                }, function(){  //On Hover Out  
                    $(this).removeClass("subhover"); //On hover out, remove class "subhover"  
                });  
      
            });  
        </script>
        <style type="text/css">

        </style>
    </head>
    <body>
        <div id="pagewidth">
            <div align="center" style="margin:0 auto;position:relative;width:934px;">
				
				<!-- MENU FAQ -->
				
				<a class="faqmenu" href="<?php echo base_url(); ?>index.php/index/inicio" style="left:0; width:43px;"></a> <!-- Inicio -->
				<a class="faqmenu" href="#" style="left:46px; width:110px;"></a> <!-- Manual de U. -->
				<a class="faqmenu" href="#" style="left:159px; width:123px;"></a> <!-- P.F. -->
				<a class="faqmenu" href="#" style="left:285px; width:90px;"></a> <!-- S.T. -->
				<a class="faqmenu" href="#" style="left:378px; width:43px;"></a> <!-- Ayuda -->				
				
				<!-- MENU RAPIDO -->
				
				<a class="fastmenu" href="<?php echo base_url(); ?>index.php/ventas/comprobante/comprobantes/V/F" style="left:17px;"></a> <!-- Facturación -->
				<a class="fastmenu" href="<?php echo base_url(); ?>index.php/ventas/comprobante/comprobantes/V/B" style="left:93px;"></a> <!-- Boletas -->
				<a class="fastmenu" href="<?php echo base_url(); ?>index.php/almacen/guiarem/listar/C" style="left:163px;"></a> <!-- Guías -->
				<a class="fastmenu" href="#" style="left:242px;"></a> <!-- Contabilidad -->
				<a class="fastmenu" href="<?php echo base_url(); ?>index.php/ventas/comprobante/reportes" style="left:331px;"></a> <!-- Reportes -->		
				
				
				
				
                <img src="<?php echo base_url(); ?>images/cabeceras/<?php echo $_SESSION['rol']; ?>.jpg" height="93" style="width: 934px;"/>
            </div>

            <div id="MenuAplicacion" ></div>
            <div style="width:934px;  margin-left: auto; margin-right: auto"><?php require_once "menu.php"; ?></div>
            <div class="fuente8" style="margin-left:auto;margin-right:auto;width:936px; font-family:'Arial', sans-serif;">
                <label style="float:left; width:200px; color:#3E4554; font-size:13px; height:22px; margin-left:2px;">
                    <b>ROL:</b> <?php echo $desc_rol; ?>
                </label>
                <label style="float:right; width:400px; text-align:right; color:#3E4554; font-size:12px; margin-top:1px;">
                    <b>EMPRESA:</b> <?php echo $nombre_empresa ?> <b style="margin-left:20px">USUARIO: <?php echo $nom_user; ?></b>
                </label>
                <div style="clear: both;"></div>
            </div>

            
                <!-- Fin -->
                <div id="twocols" class="clearfix"><?php echo $content_for_layout ?></div>
            </div>
            <div id="footer"></div>
        </div>
    </body>
</html>
