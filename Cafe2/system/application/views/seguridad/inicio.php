<?php
//error_reporting(E_ALL);
$CI = get_instance();
$this->load->model('maestros/directivo_model');
$this->load->model('almacen/producto_model');
$this->load->model('almacen/guiatrans_model');
$this->load->model('seguridad/usuario_model');
/* BLOQUE CUMPLEAÑOS */

$compania = $CI->session->userdata('compania');

date_default_timezone_set("America/Lima");
$fechaHoy = date("m-d");
$cumpleanios = $CI->directivo_model->lista_cumpleanios($fechaHoy);
/* FIN BLOQUE CUMPLEAÑOS */

/* BLOQUE STOCK MINIMO */
$productos = $CI->producto_model->listar_producto_stockmin();

/* FIN BLOQUE STOCK MINIMO */
/* BLOQUE TRANSFERENCIAS */
$transferencias = $CI->guiatrans_model->listar_transferencias_transito();

/* FIN BLOQUE TRANSFERENCIAS */
$usuario = $CI->usuario_model->usuario_saludo();

?>

<script type="text/javascript" src="<?php echo base_url(); ?>js/domwindow.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/maestros/tipocambio.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.defaultDOMWindow').openDOMWindow({ 
            eventType:'click',
            loader:1, 
            loaderImagePath:'animationProcessing.gif', 
            loaderHeight:16, 
            loaderWidth:17,
            width:322,
            height:200
        });
<?php
if (isset($flagMuestraConfiMoneda) && $flagMuestraConfiMoneda == true){
    echo "$('.defaultCloseDOMWindow').closeDOMWindow({eventType:'click'}); $('#open').click();";
    }
?>
   <?php
if ($flagMuestraConfiMoneda != true)
    echo "$('.defaultCloseDOMWindow').closeDOMWindow({eventType:'click'}); $('#close').click();";
?>             
    });
    
    
    
</script>
<?php if (isset($ver)) { ?>
    <div id="pagina">
   	 <div id="wrapper" class="clearfix" >
        <!-- Inicio -->
        <div id="VentanaTransparente" style="display:none;">
            <div class="overlay_absolute"></div>
            <div id="cargador" style="z-index:2000">
                <table width="100%" height="100%" border="0" class="fuente8">
                    <tr valign="middle">
                        <td> Por Favor Espere    </td>
                        <td><img src="<?php echo base_url(); ?>images/cargando.gif"  border="0" title="CARGANDO"/><a href="#" id="hider2"></a>  </td>
                    </tr>
                </table>
            </div>
        </div>
        <div align="center">
            <div class="divWF100 divHF20" >
                <a id="linkVerRegistro" href="http://www.ccapaempresas.com/desarrollo/gym/index.php/mod-proveedor/index/registro"></a>
                <table class="fuente8" width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tbody><tr>
                            <td>Bienvenido, Sr 
                                <strong>
                                    <?php
                                    foreach ($usuario as $key => $value2) {
                                        echo $value2->PERSC_Nombre . " " . $value2->PERSC_ApellidoPaterno;
                                    }
                                    ?>
                                </strong></td>
                        </tr><tr>
                        </tr></tbody></table>
            </div>
            <div id="tituloForm" class="header divHF20 left" style="text-align:left;">
            <span >ACTIVIDADES RECIENTES / AVISOS</span></div>
            <div class="divWF100">
                <div class="content_div left margin-right" style="margin-right: 0;" >
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tbody>
                            <tr class="cabecera_table">
                                <td class="header" style="color:#000" colspan="6">TRANSFERENCIA EN OBSERVACION</td>
                            </tr>
                            <tr class="cabecera_table">
                                <td width="16%" class="css_cabectabla">FECHA</td>
                                <td width="5%" class="css_cabectabla">SERIE</td>
                                <td width="10%" class="css_cabectabla">NÚMERO</td>
                                <td width="39%" class="css_cabectabla">ALMACEN ORIGEN</td>
                                <td width="10%" class="css_cabectabla">MOVIMIENTO</td>
                            </tr>
                            <?php
                            if (count($transferencias) > 0) {
                                foreach ($transferencias as $key => $value3) {
                                    ?>
                                    <tr class="table_par">
                                        <td><?php echo $value3->GTRANC_Fecha; ?></td>
                                        <td><?php echo $value3->GTRANC_Serie; ?></td>
                                        <td><?php echo $value3->GTRANC_Numero; ?></td>
                                        <td><?php echo $value3->EESTABC_DescripcionOri; ?></td>
                                        <td>
                                            <a href='#' title='Confirmar el envio de la transferencia'><div style='width:70px; height:17px; background-color: yellow; text-align:center'>Transito</div></a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="5" class="table_par"><div align="center"><b>No se encontraron gu&iacute;as en transito</b></div></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>

                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tbody>
                            <tr class="cabecera_table">
                                <td class="header" style="color:#000" colspan="5">articulos por debajo del stock</td>
                            </tr>
                            <tr class="cabecera_table">
                                <td width="4%" class="css_cabectabla">ITEM</td>
                                <td width="15%" class="css_cabectabla">CODIGO</td>
                                <td width="70%" class="css_cabectabla">PRODUCTOS</td>
                                <td width="9%" class="css_cabectabla">STOCK ACTUAL</td>
                                <td width="9%" class="css_cabectabla">STOCK MIN.</td>
                            </tr>
                            <?php
                            if (count($productos) > 0) {
                                $i = 1;
                                foreach ($productos as $key => $value4) {
                                    if ($value4->COMPP_Codigo == $compania) {                                       
                                        if ($value4->ALMAC_Codigo != 8 && $value4->ALMAC_Codigo != 9 &&$value4->ALMAC_Codigo != 10 &&$value4->ALMAC_Codigo != 11) {
                                        ?>
                                        <tr class="table_par">
                                            <td height="21"><?php echo $i; ?></td>
                                            <td style="text-align: left"><?php echo $value4->PROD_CodigoUsuario; ?></td>
                                            <td style="text-align: left"><?php echo $value4->PROD_Nombre; ?></td>
                                            <td><?php echo $value4->ALMPROD_Stock; ?></td>
                                            <td><?php echo $value4->PROD_StockMinimo; ?></td>
                                        </tr>
                                        <?php
                                            }
                                        }
                                    $i++;
                                }
                            } else {
                                ?>
                                <tr class="table_par">
                                    <td colspan="5">
                                        <b>No hay productos por debajo del Stock</b>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <div class="clear"></div>
                </div>

                <!--////////////////  CUMPLEAÑOS  /////////////////////-->
<!--                <div class="content_div left" style="height:190px;">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tbody>
                            <tr class="cabecera_table">
                                <td class="header" style="color:#000">MENSAJES PERSONALES</td>
                            </tr>
                            <?php
                            if (count($cumpleanios) > 0) {
                                foreach ($cumpleanios as $key => $value) {
                                    ?>
                                    <tr class="table_par">
                                        <td>
                                            <br/>
                                            HOY ES CUMPLEAÑOS DE: <?php echo $value->PERSC_Nombre . " " . $value->PERSC_ApellidoPaterno; ?><br />
                                            <?php
                                            if ($value->DIREC_Imagen != '') {
                                                ?>
                                                <img height="45px" width="40px" src="<?php echo base_url(); ?>images/<?php echo $value->DIREC_Imagen; ?>" />
                                                <?php
                                            } else {
                                                ?>
                                                <img height="45px" width="40px" src="<?php echo base_url(); ?>images/persona.jpg" />
                                                <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr class="table_impar">
                                        <td>
                                            <br/>
                                            <?php echo $value->CARGC_Descripcion; ?> 
                                            <br/>&nbsp;
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <tr class="table_par">
                                    <td style="height:172px;">
                                        <b>No hay cumplea&ntilde;os el d&iacute;a de hoy</b>                                                  
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <div class="clear"></div>
                    <br/>
                    <br/>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tbody>
                            
                            <tr class="cabecera_table">
                               <td  style="color:#000;background:red;" colspan='5' >PRODUCTOS NO INVENTARIADO</td>
                            </tr>
                            <tr class="cabecera_table">
                                <td width="4%" class="css_cabectabla">ITEM</td>
                                <td width="9%" class="css_cabectabla">FECHA DE REGISTRO</td>
                                <td width="15%" class="css_cabectabla">CODIGO INTERNO</td>
                                <td width="15%" class="css_cabectabla">CODIGO USUARIO</td>
                                <td width="70%" class="css_cabectabla">PRODUCTOS</td>
                            </tr>

                            <tr>
                             <td colspan='5'><div id="pagination_container" class="busqueda_container" style="margin-top: 15px;width:100%;"></div></td>
                            </tr>
                             </tbody>
                    </table>
                            <br>
                            <br>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tbody>
                            <tr class="cabecera_table">
                               <td  style="color:#000;background:ORANGE;" colspan='5' >PRODUCTOS INVENTARIADOS NO ACTIVADOS</td>
                            </tr>
                             <tr class="cabecera_table">
                                <td width="4%" class="css_cabectabla">ITEM</td>
                                <td width="9%" class="css_cabectabla">FECHA DE REGISTRO</td>
                                <td width="15%" class="css_cabectabla">CODIGO INTERNO</td>
                                <td width="15%" class="css_cabectabla">CODIGO USUARIO</td>
                                <td width="70%" class="css_cabectabla">PRODUCTOS</td>
                            </tr>

                            <tr>
                             <td colspan='5'><div id="pagination_container"  style="margin-top: 15px;width:100%;"></div></td>
                            </tr>
                        </tbody>
                    </table>
                </div>-->
                <!--////////////////  FIN CUMPLEAÑOS  /////////////////////-->
            </div>
        </div>
    <?php } ?>
    <div style="clear: both;"></div>
    <table class="fuente8" width="93%" border="0" align="center">
        <!-- <tr height="90px">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>     
        <tr height="200px">
            <td>&nbsp;</td>
          <td><div align="center"><img src="<?php ///echo base_url(); ?>images/3.jpg" width="496" height="180" /></div></td>
            <td>&nbsp;</td>
        </tr>-->
        <tr>
            <td>&nbsp;</td>
            <td><div align="center" class="Estilo6"><a href="http://www.osa-erp.com" style="text-decoration: none;"> www.osa-erp.com </a></div></td>
            <td>&nbsp;</td>
        </tr>
        <!--
        <tr>
              <td>&nbsp;</td>
              <td><div align="center" class="Estilo6">Versi&oacute;n 1.0</div></td>
              <td>&nbsp;</td>
        </tr>
        <tr>
              <td>&nbsp;</td>
              <td><div align="center" class="Estilo6">&copy; 2013</div></td>
              <td>&nbsp;</td>
        </tr>
        -->
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><table width="50%" border="0" align="center">                   
                    <tr>
                        <td><div align="center"><span class="Estilo5">Resoluci&oacute;n Optima 1024 x 768 p&iacute;xeles  </span></div></td>
                    </tr>
                </table></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td height="27">&nbsp;</td>
            <td><table width="50%" border="0" align="center">
                    <tr>
                        <td width="37%"><div align="right"></div></td>
                        <td width="63%"><a href="http://www.ccapasistemas.com"><span class="Estilo5">www.ccapasistemas.com</span></a></td>
                    </tr>
                </table></td>
            <td>&nbsp;</td>
        </tr>
    </table>

    <?php if (isset($flagMuestraConfiMoneda) && $flagMuestraConfiMoneda == true) { ?>
        <div id="pagina_incio" style="display:none">
            <div id="zonaContenido">
                <div align="center">
                    <div id="tituloForm" class="header" style="width:285px">TIPO DE CAMBIO DEL DIA :<?php echo date('d/m/Y', time()); ?> </div>
                    <div id="frmBusqueda" style="width:300px">
                        <form name="frmTipoCambio" id="frmTipoCambio" method="post" action="<?php echo base_url() ?>index.php/maestros/tipocambio/grabar"  onSubmit="javascript: return false">
                            <div id="datosGenerales">
                                <table class="fuente7" width="98%" cellspacing="0" cellpadding="6" border="0">
                                    <?php
                                    $reg_sol = $lista_monedas[0];
                foreach ($lista_monedas as $item => $reg) {
                 if ($reg->MONED_Codigo != 1) {
                 echo '<tr>';
                echo '<td align="center">' . $reg_sol->MONED_Descripcion . ' (' . $reg_sol->MONED_Simbolo . ')' . ' a ' . $reg->MONED_Descripcion . ' (' . $reg->MONED_Simbolo . ')' . '</td>';
                 echo '</tr>';
                 echo '<tr>';
                 echo '<td align="center">' . form_hidden("moneda[" . $item . "]", $reg->MONED_Codigo) . form_input(array('name' => 'tipocambio[' . $item . ']', 'id' => 'tipocambio[' . $item . ']', 'value' => $valores[$reg->MONED_Codigo], 'maxlength' => '5', 'class' => 'cajaTextoGrande')) . '</td>';
                                            echo '</tr>';
                                        }
                                    }
                                    echo form_hidden(array("moneda_origen" => $reg_sol->MONED_Codigo, 'fecha' => date('Y-m-d'),'dfalt' =>$fdtipocambio));
                                   
                                    
                                   ?>

                                </table>
                            </div>
                            <div style="margin-top:20px;margin-bottom:10px; text-align: center">
                                <a href="javascript:;" id="grabarTipoCambio"><img src="<?php echo base_url(); ?>images/botonaceptar.jpg" width="85" height="22" class="imgBoton" ></a>
                                <a href="javascript:;" id="cancelarTipoCambio"><img src="<?php echo base_url(); ?>images/botoncancelar.jpg" width="85" height="22" class="imgBoton" ></a>
                            </div>
                            <?php echo $oculto ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <a href="#pagina_incio" id="open" class="defaultDOMWindow"></a>
        <a href="#pagina_incio" id="close" class="defaultCloseDOMWindow"></a>
    <?php } ?>
    
    <?php
    if(isset($arreglof)){
    if ($flagMuestraConfiMoneda != true ) { ?>
    <div id="zonaContenido" align="center" style="display: none">
     <div id="tituloForm" class="header" style="width:300px;margin-bottom: 10px;">FALTA INGRESAR TIPO DE CAMBIO</div>
                <div align="center">
                <table style="background: white; width: 315px; margin-top: -10px;">
                    <tr>
                    <td align="center">Indice</td>
                    <td align="center">Fecha</td>
                    </tr>
                        <?php  

                     foreach ($arreglof as $itemf =>$regf) {
                     echo '<tr><td width="10%"><div align="center"><span class="Estilo5">';
                     echo $itemf+1; 
                     echo '</span></div></td>';
                     echo '<td width="15%"><div align="center"><span class="Estilo5">';
                     echo '<a href="'.base_url().'index.php/maestros/tipocambio/editar/'.str_replace('-', '',$regf[0]).'" >'.$regf[0].'</a>'; 
                     echo '</span></div></td> </tr>';
                     }
                        
                        ?>
                        </table>
                        <a href="<?php echo base_url(); ?>index.php/maestros/tipocambio/listar" id=""><img src="<?php echo base_url(); ?>images/botonaceptar.jpg" width="85" height="22" class="imgBoton" ></a>
                        <a href="javascript:;" id="cancelarTipoCambio"><img src="<?php echo base_url(); ?>images/botoncancelar.jpg" width="85" height="22" class="imgBoton" ></a>
                           
            </div>
    </div>
     <a href="#pagina" id="open" class="defaultDOMWindow"></a>
     <a href="#pagina" id="close" class="defaultCloseDOMWindow"></a>
    <?php }} ?>
    </div>
    </div>