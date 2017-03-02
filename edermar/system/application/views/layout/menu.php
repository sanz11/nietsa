<?php
$datos_menu = $this->session->userdata('datos_menu');
$base_url = base_url();
$CI = get_instance();
$this->load->model('seguridad/permiso_model');
$this->load->model('seguridad/usuario_compania_model');
$menus_base = $CI->permiso_model->obtener_permisosMenu($this->session->userdata('rol'));
// print_r($_SESSION);
?>
<script type="text/javascript">
	function mostrarMenuIzquierdo(idMenu){
		var arrayMenu= <?php echo json_encode($menus_base); ?>;
		var cantidadMenu=<?php echo count($menus_base); ?>;
		/**ponemos en session id menu seleccionado**/
		ingresarMenuSession(idMenu);
		/****/
		$("#idLiMenuDinamico").html("");
		
		for(x=0;x<cantidadMenu;x++){
			idDefaultd=arrayMenu[x]['MENU_Codigo'];
			if(idDefaultd==idMenu){
				descripcionMenu=arrayMenu[x]['MENU_Descripcion'];
				ArraySubMenu=arrayMenu[x]['submenus'];
				cantidadSub=ArraySubMenu.length;
				idA="#idAMenuPrincipal";
				fila="<a id='idAMenuPrincipal'  href='#'>"+descripcionMenu+"<span>"+cantidadSub+"</span></a> ";
				if(cantidadSub>0){
					fila+="<ul>";
						for(j=0;j<cantidadSub;j++){
							codigoMenuSub=ArraySubMenu[j]['MENU_Codigo'];
							descripcionSub=ArraySubMenu[j]['MENU_Descripcion'];
		            		urlSub=ArraySubMenu[j]['MENU_Url'];
		            		estadoSub=ArraySubMenu[j]['MENU_FlagEstado'];
							if(estadoSub==1){
								fila+="<li class='subitem1'><a href='<?php echo base_url();?>index.php/"+urlSub+"'   onclick='ingresarMenuSession("+idMenu+","+codigoMenuSub+")'   >"+descripcionSub+"</a></li>";
							}
						}
					fila+="</ul>";
				}
				
				
				$("#idLiMenuDinamico").html(fila);
				document.getElementById("idLiMenuDinamico").style.display = "block";
				document.getElementById("idLiMenuDinamico").setAttribute("onclick","logicaMenuDinamico('#idAMenuPrincipal');");
				logicaMenuDinamico(idA);
			}
		}
	}

	function ingresarMenuSession(idMenuSeleccionado,idMenusub){
		url="<?php echo base_url()?>index.php/index/sessionMenuSeleccion";
		$.post(url, {idMenuSeleccionadoReal:idMenuSeleccionado,idMenusubReal:idMenusub});
		
	}
	
</script>


<ul class="nav main">
    <li onclick="mostrarMenuIzquierdo('0','0')" ><a href="<?php echo site_url('index/inicio'); ?>">
    <img alt="Inicio" src="<?php echo base_url();?>images/inicio.png" width="25" height="25">
    </a></li>
    <?php
    foreach ($menus_base as $menu_base) {
    	$idDefaultd=$menu_base->MENU_Codigo;
        $text = ($menu_base->MENU_Url != '') ? '<a  id="idAMenuSuperiorP_'.$idDefaultd.'"  href="' . site_url($menu_base->MENU_Url) . '">' . $menu_base->MENU_Descripcion . '</a>' : '<a  id="idAMenuSuperiorP_'.$idDefaultd.'"  href="javascript:;" onclick="mostrarMenuIzquierdo('.$idDefaultd.')">' . $menu_base->MENU_Descripcion. '</a>';
        $enlaces = $menu_base->submenus;
        ?>
    <li ><?php echo utf8_decode($text) ?>
            <?php
            //if (count($enlaces)) {
                ?>
             <!-- <ul>
                    <?php
                    /**foreach ($enlaces as $enlace) {
                        $subtext = '';
                        if ($enlace->MENU_FlagEstado == 1) {
                        	$codigoSubMenu=$enlace->MENU_Codigo;
                            if ($enlace->MENU_Url != '') {
                                $subtext = '<a href="' . site_url($enlace->MENU_Url) . '" onclick="ingresarMenuSession('.$idDefaultd.','.$codigoSubMenu.')"    >';
                                $subtext.=$enlace->MENU_Descripcion . '</a>';
                            }
                            else
                                $subtext = '<a href="javascript:;">' . $enlace->MENU_Descripcion . '</a>';

                            echo '<li>' . utf8_decode($subtext) . '</li>';
                        }
                    }**/
                    ?>
                </ul> -->   
                <?php
           // }
            ?>
        </li>

        <?php
    }
    ?>              
    <li><a href="<?php echo site_url('index/salir_sistema'); ?>">Salir</a></li>
   
</ul>


<script>
    $(document).ready(function(){
        $('#tip').click(function(){
            $(this).hide();   
        })
    })
</script>
<style>
    #tip{
        cursor: pointer;
        padding:  10px;
        width: 300px;
		display: block;
        position: fixed;
        top: 10px;
        left: 0px;
        background: #FFF;
        z-index: 10;
        border: 1px solid #CCC;
        border-radius: 4px;
        font-family: Arial;
        font-size: 12px;
    }
    #tip div{
        font-weight: bold;
        padding: 5px;
    }
    #tip ul{
        padding-left: 10px;
        margin: 0;
    }
  #tip ul li{
margin-bottom: 5px;
}
</style>
<input type="hidden" name="base_url" id="base_url" value="<?php echo base_url(); ?>">