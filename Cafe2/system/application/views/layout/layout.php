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

$lista_compania = $CI->usuario_compania_model->listar_compania();


if (empty($persona))
    header("location:$url");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <title><?php echo TITULO; ?></title>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
 		<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/calendario/calendar-win2k-2.css" type="text/css" media="all" title="win2k-cold-1" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/estilos.css" type="text/css"/>
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/nav.css" type="text/css"/>
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/ui-lightness/jquery-ui-1.8.18.custom.css" type="text/css"/>
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
                // Est utilizando EXPLORER
                cursor='hand';
            } else {
                // Est utilizando MOZILLA/NETSCAPE
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
    </head>
    <body>
    <div class="divWF100 divHF60 minWidtContenedor" style="margin-top: 5px;margin-bottom: 5px;" >
	    <div id="idDivLogo" class="divWF70 divHF60"  >
	    	<img src="<?php echo base_url();?>images/logo.png" alt="logo" style="height: 100%;" />
	    </div>
	    <div id="idDivHelp" class="divWF30 divHF60" >
	    	<?php require_once "menuSuperiorDerecho.php"; ?>  
    	</div>
    </div>
    <div class="divWF100 divHF40 minWidtContenedor"  >
	    <div id="idDivMenu" class="divWF80 divHFMenu backgroundMenu"  >
			<?php require_once "menu.php"; ?>  
		</div>
	    <div id="idDivDetalleUsuario" class="divWF20 divHFMenu backgroundMenu"  >
		    <div style="float:right">
	        	<select name="cboCompania" id="cboCompania" onchange="cambiar_sesion();">
	            <?php
	            foreach ($lista_compania as $valor) {
				//ver solo los datos
	             	if($valor['nombre']!="SOLEPER"){ 
	
	      				echo '<option ' . ($valor['compania'] == $_SESSION['compania'] ? 'selected="selected"' : '') . ' ' . ($valor['tipo'] == '1' ? 'disabled="disabled" style="font-weight: bold;"' : '') . ' value="' . $valor['compania'] . '">' . ($valor['tipo'] == '2' ? '&nbsp;&nbsp;&nbsp;&nbsp;' : '') . '' . $valor['nombre'] . 
	          				'</option>';
	            	}
	       		}
	            ?>
	        	</select>
	    	</div>
	    </div>
    </div>
    <div class="divWF100 divHF100p minWidtContenedor"  >
	    <div id="idDivIzquierdo" class="contenedorWidthDeIz divHF800 "  >
	    	<?php require_once "menuIzquierdo.php"; ?>  
	    </div>
	    <div id="idDivContenedor" class="contenedorWidthGeneral divHF100p " >
	    <div class="fuente8" >
                <label style="float:left; width:200px; color:#3E4554; font-size:13px; height:22px; margin-left:2px;">
                    <b>ROL:</b> <?php echo $desc_rol; ?>
                </label>
                <label style="float:right; width:400px; text-align:right; color:#3E4554; font-size:12px; margin-top:1px;">
                    <b>EMPRESA:</b> <?php echo $nombre_empresa ?> <b style="margin-left:20px">USUARIO: <?php echo $nom_user; ?></b>
                </label>
                <div style="clear: both;"></div>
            </div>
	    	<?php echo $content_for_layout ?>
	    </div>
	    <div id="idDivDerecho" class="contenedorWidthDeIz divHF800 " >
	    	<?php require_once "menuDerecho.php"; ?> 
	    </div>
    </div>    
    <div class="divWF100 divHF40" >
    	<div id="footer"></div>
    </div>  
    
    </body>
    <script language="javascript">
            $(document).ready(function(){  
				/**obtenemos resolucion de pantalla**/
					widthBody=$(window).width();
					if(widthBody<1211)	
						widthBody=1211;
					
					widthContenedorPrincipal=$("#idDivContenedor").width();
					/**obtenenemos los porcentajes del lado**/
					widthLadoGeneral=50-(50*widthContenedorPrincipal)/widthBody;
					widthLadoGeneral=widthLadoGeneral.toFixed(4);
                	document.getElementById("idDivIzquierdo").style.width = widthLadoGeneral+"%";
                	document.getElementById("idDivDerecho").style.width = widthLadoGeneral+"%";
                /**fin de acoplar**/
            });  
        </script>
</html>
