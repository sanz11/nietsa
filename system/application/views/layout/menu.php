<?php
$datos_menu = $this->session->userdata('datos_menu');
$base_url = base_url();
$CI = get_instance();
$this->load->model('seguridad/permiso_model');
$this->load->model('seguridad/usuario_compania_model');
$menus_base = $CI->permiso_model->obtener_permisosMenu($this->session->userdata('rol'));
// print_r($_SESSION);
$lista_compania = $CI->usuario_compania_model->listar_compania();
?>
<ul class="nav main">
    <li><a href="<?php echo site_url('index/inicio'); ?>">Inicio</a></li>
    <?php
    foreach ($menus_base as $menu_base) {
        $text = ($menu_base->MENU_Url != '') ? '<a href="' . site_url($menu_base->MENU_Url) . '">' . $menu_base->MENU_Descripcion . '</a>' : '<a href="javascript:;">' . $menu_base->MENU_Descripcion . '</a>';

        $enlaces = $menu_base->submenus;
        ?>
    <li><?php echo utf8_decode($text) ?>
            <?php
            if (count($enlaces)) {
                ?>
                <ul>
                    <?php
                    foreach ($enlaces as $enlace) {
                        $subtext = '';
                        if ($enlace->MENU_FlagEstado == 1) {
                            if ($enlace->MENU_Url != '') {
                                $subtext = '<a href="' . site_url($enlace->MENU_Url) . '">';
                                $subtext.=$enlace->MENU_Descripcion . '</a>';
                            }
                            else
                                $subtext = '<a href="javascript:;">' . $enlace->MENU_Descripcion . '</a>';

                            echo '<li>' . utf8_decode($subtext) . '</li>';
                        }
                    }
                    ?>
                </ul>
                <?php
            }
            ?>
        </li>

        <?php
    }
    ?>              
    <li><a href="<?php echo site_url('index/salir_sistema'); ?>">Salir</a></li>
    <div style="float:right">
        <select name="cboCompania" id="cboCompania" onchange="cambiar_sesion();" class="comboMedio">
            <?php
            foreach ($lista_compania as $valor) {
                echo '<option ' . ($valor['compania'] == $_SESSION['compania'] ? 'selected="selected"' : '') . ' ' . ($valor['tipo'] == '1' ? 'disabled="disabled" style="font-weight: bold;"' : '') . ' value="' . $valor['compania'] . '">' . ($valor['tipo'] == '2' ? '&nbsp;&nbsp;&nbsp;&nbsp;' : '') . '' . $valor['nombre'] . '</option>';
            }
            ?>
        </select>
    </div>
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
<!-- <div id="tip">
    <div>CAMBIOS REALIZADOS:</div>
    <ul>

       <li>
           (29/05/2013 14:28) - Ya no se genera el descuento de stock al momento de editar un guía de ventas.
        </li>
        <li>
           (29/05/2013 15:17) - Se eliminaron los duplicados de los siguientes articulos:<br>
HEVA043<br>
ACVA103<br>
HEVA044<br>
PUCF006<br>
TIAS166<br>
        </li>
        <li>
           (29/05/2013 15:26) - Se corrigió las cantidades de stock mínimo que se muestra en la pagina principal
(solo se lista las cantidades locales).
        </li>

        <li>
           (29/05/2013 15:37) - Listado de Kardex por producto.
        </li>

        <li>
           (29/05/2013 15:51) - Se quitaron todas la Notas de Crédito.
        </li>

        <li>
           (29/05/2013 16:10) - Se quitaron las Guías de Remisión - Compra con la razón social "FAMYSERFE".
        </li>

        <li>
           (29/05/2013 16:15) - Se arreglo la paginación de Guías de Ventas y Compra.
        </li>

        <li>
           (30/05/2013 13:29) - Se arreglo la paginación de la búsqueda de productos.
        </li>

        <li>
           (31/05/2013 13:22) - Se corrigió el error de descuento de las compras, <b>Se recomienda limpiar el cache del mozilla</b>.
        </li>
    </ul>
    <div>Click en el cuadro para cerrarlo.</div>
</div>
-->

<input type="hidden" name="base_url" id="base_url" value="<?php echo base_url(); ?>">