<?php
$CI = get_instance();
$this->load->model('maestros/directivo_model');
$this->load->model('almacen/producto_model');
/* BLOQUE CUMPLEAÑOS */

date_default_timezone_set("America/Lima");
$fechaHoy = date("m-d");
$cumpleanios = $CI->directivo_model->lista_cumpleanios($fechaHoy);
//var_dump($cumpleanios);

/* foreach ($cumpleanios as $key => $value) {
  $data['emp_nombre']=$value->PERSC_Nombre;
  $data['emp_apellido']=$value->PERSC_ApellidoPaterno;
  $data['emp_cargo']=$value->CARGC_Descripcion;
  $data['emp_imagen']=$value->DIREC_Imagen;
  $data['emp_nombre']=$value->PERSC_Nombre;
  $data['emp_nombre']=$value->PERSC_Nombre;
  } */

/* FIN BLOQUE CUMPLEAÑOS */

/* BLOQUE STOCK MINIMO */
$productos = $CI->producto_model->listar_producto_stockmin();

/* FIN BLOQUE STOCK MINIMO */
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
            width:330,
            height:290
        });
<?php
if (isset($flagMuestraConfiMoneda) && $flagMuestraConfiMoneda == true)
    echo "$('.defaultCloseDOMWindow').closeDOMWindow({eventType:'click'}); $('#open').click();";
?>
                
    });
</script>
<?php if (isset($ver)) { ?>
    <div id="wrapper" class="clearfix" >
        <!-- Inicio -->
        <div id="VentanaTransparente" style="display:none;">
            <div class="overlay_absolute"></div>
            <div id="cargador" style="z-index:2000">
                <table width="100%" height="100%" border="0" class="fuente8">
                    <tr valign="middle">
                        <td> Por Favor Espere    </td>
                        <td><img src="<?php echo base_url(); ?>images/cargando.gif"  border="0" title="CARGANDO"/><a href="#" id="hider2"></a>	</td>
                    </tr>
                </table>
            </div>
        </div>
        <div align="center">
            <div style="width:934px;margin-top:12px;">
                <a id="linkVerRegistro" href="http://www.ccapaempresas.com/desarrollo/gym/index.php/mod-proveedor/index/registro">&nbsp;</a>
                <table class="fuente8" width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tbody><tr>
                            <td>Bienvenido, Sr <strong>MIRKO GAMBOA</strong></td>
                        </tr><tr>
                        </tr></tbody></table>
            </div>
            <div id="tituloForm" class="header" style="text-align:left;"><span style="font-size:12px;text-align:left;margin-left:15px;">ACTIVIDADES RECIENTES / AVISOS</span></div>
            <div style="width:934px;margin-top:12px;">
                <div class="content_div left margin-right">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tbody>
                            <tr class="cabecera_table">
                                <td class="header" style="color:#FFFFFF" colspan="6">TRANSFERENCIA EN OBSERVACION</td>
                            </tr>
                            <tr class="cabecera_table">
                                <td width="16%" class="css_cabectabla">FECHA</td>
                                <td width="5%" class="css_cabectabla">SERIE</td>
                                <td width="10%" class="css_cabectabla">NÚMERO</td>
                                <td width="39%" class="css_cabectabla">ALMACEN DESTINO</td>
                                <td width="12%" class="css_cabectabla">ESTADO</td>
                                <td width="18%" class="css_cabectabla">USUARIO</td>
                            </tr>
                            <tr class="table_par">
                                <td>2013-03-08</td>
                                <td>001</td>
                                <td>3</td>
                                <td>TDA CYBER</td>
                                <td>ANULADO</td>
                                <td>ADMIN</td>
                            </tr>
                            <tr>
                                <td colspan="6"><div align="right"></div></td>
                            </tr>
                        </tbody>
                    </table>
                    <br/>
                    <br/>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tbody>
                            <tr class="cabecera_table">
                                <td class="header" style="color:#FFFFFF" colspan="4">articulos por debajo del stock</td>
                            </tr>
                            <tr class="cabecera_table">
                                <td width="4%" class="css_cabectabla">ITEM</td>
                                <td width="15%" class="css_cabectabla">CODIGO</td>
                                <td width="70%" class="css_cabectabla">PRODUCTOS</td>
                                <td width="9%" class="css_cabectabla">CANTIDAD</td>
                            </tr>
                            <?php
                            if (count($productos) > 0) {
                                $i = 1;
                                foreach ($array as $key => $value) {
                                    ?>
                                    <tr class="table_par">
                                        <td height="21"><?php echo $i; ?></td>
                                        <td><?php echo $value->PROD_CodigoInterno; ?></td>
                                        <td><?php echo $value->PROD_Nombre; ?></td>
                                        <td><?php echo $value->ALMPROD_Stock; ?></td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <tr class="table_par">
                                    <td colspan="4">
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
                <div class="content_div left">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tbody>
                            <tr class="cabecera_table">
                                <td class="header" style="color:#FFFFFF">MENSAJES PERSONALES</td>
                            </tr>
                            <?php
                            if (count($cumpleanios) > 0) {
                                foreach ($cumpleanios as $key => $value) {
                                    ?>
                                    <tr class="table_par">
                                        <td>
                                            <br/>
                                            HOY ES CUMPLEAÑOS DE: <?php echo $value->PERSC_Nombre . " " . $value->PERSC_ApellidoPaterno; ?><br />
                                            <img height="45px" width="40px" src="<?php echo base_url(); ?>images/<?php echo $value->DIREC_Imagen; ?>" /> 
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
                                    <td>
                                        <b>No hay cumplea&ntilde;os el d&iacute;a de hoy</b>                                                  
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <div class="clear"></div>
                </div>
                <!--////////////////  FIN CUMPLEAÑOS  /////////////////////-->
            </div>
        </div>
    <?php } ?>
    <div style="clear: both;"></div>

    <table class="fuente8" width="93%" border="0" align="center">
        <tr height="90px">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>	  
        <tr height="200px">
            <td>&nbsp;</td>
            <td><div align="center"><img src="<?php echo base_url(); ?>images/3.jpg" width="496" height="180" /></div></td>
            <td>&nbsp;</td>
        </tr>
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
        <div id="pagina" style="/*display:none*/">
            <div id="zonaContenido">
                <div align="center">
                    <div id="tituloForm" class="header" style="width:300px">TIPO DE CAMBIO DEL DIA :<?php echo date('d/m/Y', time()); ?> </div>
                    <div id="frmBusqueda" style="width:300px">
                        <form name="frmTipoCambio" id="frmTipoCambio" method="post" action="<?php echo base_url() ?>index.php/maestros/tipocambio/grabar"  onSubmit="javascript: return false">
                            <div id="datosGenerales">
                                <table class="fuente8" width="98%" cellspacing="0" cellpadding="6" border="0">
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
                                    echo form_hidden(array("moneda_origen" => $reg_sol->MONED_Codigo, 'fecha' => date('Y-m-d')));
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
        <a href="#pagina" id="open" class="defaultDOMWindow"></a>
        <a href="#pagina" id="close" class="defaultCloseDOMWindow"></a>
    <?php } ?>


