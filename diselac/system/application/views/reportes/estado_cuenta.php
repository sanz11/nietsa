<script type="text/javascript" src="<?php echo base_url();?>js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script><script type="text/javascript" src="<?php echo base_url();?>js/fancybox/jquery.fancybox-1.3.4.pack.js"></script><link rel="stylesheet" type="text/css" href="<?php echo base_url();?>js/fancybox/jquery.fancybox-1.3.4.css" media="screen" /><script>    $(document).ready(function(){        $("a#linkVerCliente, a#linkVerProveedor").fancybox({                'width'          : 700,                'height'         : 550,                'autoScale'	 : false,                'transitionIn'   : 'none',                'transitionOut'  : 'none',                'showCloseButton': false,                'modal'          : false,                'type'	         : 'iframe'        });                $('#verReporte').click(function(){            if($('#cliente').val()=='' && $('#proveedor').val()==''){                alert('Debe seleccionar un cliente o un proveedor.');                $('#ruc_cliente').focus();                return false;            }            $('#frmReporte').submit();            return true;        });            });        function seleccionar_cliente(codigo,ruc,razon_social){          $("#cliente").val(codigo);          $("#ruc_cliente").val(ruc);          $("#nombre_cliente").val(razon_social);          $('#proveedor, #ruc_proveedor, #nombre_proveedor').val('');    }    function seleccionar_proveedor(codigo,ruc,razon_social){          $("#proveedor").val(codigo);          $("#ruc_proveedor").val(ruc);          $("#nombre_proveedor").val(razon_social);          $('#cliente, #ruc_cliente, #nombre_cliente').val('');     }    function obtener_cliente(){        var numdoc = $("#ruc_cliente").val();        $('#cliente,#nombre_cliente').val('');        if(numdoc=='')            return false;        var url = base_url+"index.php/ventas/cliente/JSON_buscar_cliente/"+numdoc;        $.getJSON(url,function(data){                    $.each(data, function(i,item){                        if(item.EMPRC_RazonSocial!=''){                            $('#nombre_cliente').val(item.EMPRC_RazonSocial);                            $('#cliente').val(item.CLIP_Codigo);                            $('#codproducto').focus();                        }                        else{                            $('#nombre_cliente').val('No se encontró ningún registro');                            $('#linkVerCliente').focus();                        }                    });        });        return true;    }        </script><div id="pagina">    <div id="zonaContenido">    <div align="center">    <div id="tituloForm" class="header">ESTADO DE CUENTA</div>    <div id="frmBusqueda">      <form method="post" action="" id="frmReporte">        <table class="fuente8" width="100%" cellspacing=0 cellpadding=3 border=0>            <tr>                <td>Cliente</td>                <td colspan="3">                    <input type="hidden" name="cliente" id="cliente" size="5" value="<?php echo $cliente?>" />                         <input type="text" name="ruc_cliente" class="cajaGeneral" id="ruc_cliente" size="10" maxlength="11" onblur="obtener_cliente();" value="<?php echo $ruc_cliente;?>" onkeypress="return numbersonly(this,event,'.');" />                         <input type="text" name="nombre_cliente" class="cajaGeneral cajaSoloLectura" id="nombre_cliente" size="40" maxlength="50" readonly="readonly" value="<?php echo $nombre_cliente;?>" />                         <a href="<?php echo base_url();?>index.php/ventas/cliente/ventana_busqueda_cliente/" id="linkVerCliente"><img height='16' width='16' src='<?php echo base_url(); ?>/images/ver.png' title='Buscar' border='0' /></a>                </td>            </tr>            <tr>                <td>Proveedor </td>                <td>                    <input type="hidden" name="proveedor" id="proveedor" size="5" value="<?php echo $proveedor?>" />                     <input type="text" name="ruc_proveedor" class="cajaGeneral" id="ruc_proveedor" size="10" maxlength="11" onblur="obtener_proveedor();" value="<?php echo $ruc_proveedor;?>" onkeypress="return numbersonly(this,event,'.');" />                     <input type="text" name="nombre_proveedor" class="cajaGeneral cajaSoloLectura" id="nombre_proveedor" size="40" maxlength="50" readonly="readonly" value="<?php echo $nombre_proveedor;?>" />                     <a href="<?php echo base_url();?>index.php/compras/proveedor/ventana_busqueda_proveedor/" id="linkVerProveedor"><img height='16' width='16' src='<?php echo base_url(); ?>/images/ver.png' title='Buscar' border='0' /></a>                </td>                <td>Moneda *</td>                <td><?php echo $cboMoneda; ?></td>            </tr>            <tr>                <td>Fecha de Inicio</td>                <td><input NAME="fecha_inicio" id="fecha_inicio" type="text" class="cajaGeneral" value="<?php echo $f_ini; ?>" size="10" maxlength="10" />                    <img height="16" border="0" width="16" id="Calendario1" name="Calendario1" src="<?php echo base_url();?>images/calendario.png" />                    <script type="text/javascript">                        Calendar.setup({                            inputField     :    "fecha_inicio",                            ifFormat       :    "%d/%m/%Y",                            button         :    "Calendario1"                        });                    </script>                </td>                <td>Fecha Fin</td>                <td><input NAME="fecha_fin" id="fecha_fin" type="text" class="cajaGeneral" value="<?php echo $f_fin; ?>" size="10" maxlength="10" />                    <img height="16" border="0" width="16" id="Calendario2" name="Calendario2" src="<?php echo base_url();?>images/calendario.png" />                    <script type="text/javascript">                        Calendar.setup({                            inputField     :    "fecha_fin",                            ifFormat       :    "%d/%m/%Y",                            button         :    "Calendario2"                        });                    </script>                </td>            </tr>            <tr>                <td colspan="4" align="center"><a href="javascript:;" id="verReporte"><img src="<?php echo base_url();?>images/botonreporte.jpg" width="85" height="22" class="imgBoton" align="absmiddle"/></a></td>            </tr>        </table>        <?php echo $oculto; ?>      </form>      </div>      <br />      <?php if($cliente!='' || $proveedor!=''){ ?>      <div id="frmResultado">                <table  width="100%" cellspacing=1 cellpadding="3" border=0>                        <tr class="cabeceraTabla">                                <th rowspan="2" width="7%">F. Emisión</th>                                <th rowspan="2" width="3%">T/D</th>                                <th rowspan="2" width="7%">Nro. Doc.</th>                                <th rowspan="2" width="4%">Mnd</th>                                <th rowspan="2" width="7%">Monto</th>                                <th colspan="5">Avances de Pago</th>                                <th rowspan="2" width="7%">Saldo</th>                                <th rowspan="2" width="3%">Est</th>                        </tr>                        <tr class="cabeceraTabla">                                <th width="8%">F. Pago</th>                                <th width="4%">Mnd</th>                                <th width="8%">Importe</th>                                <th width="12%">Forma de Pago</th>                                <th>Observación</th>                        </tr>                        <?php                        if(count($lista) > 0){                                foreach($lista as $indice=>$value):                                $class = $indice%2==0?'itemParTabla':'itemImparTabla';                                ?>                                <tr class="<?php echo $class;?>">                                        <td><div align="center"><?php echo $value[0]; ?></div></td>                                        <td><div align="left"><?php echo $value[1]; ?></div></td>                                        <td><div align="center"><?php echo $value[2]; ?></div></td>                                        <td><div align="center"><?php echo $value[3]; ?></div></td>                                        <td><div align="right"><?php echo $value[4]; ?></div></td>                                        <td colspan="5"><div align="right">                                                <table width="100%" border="0">                                                    <?php                                                     foreach($value[5] as $indice=>$value2){                                                    ?>                                                    <tr>                                                        <td width="12%"><div align="center"><?php echo $value2[0]; ?></div></td>                                                        <td width="7%"><div align="center"><?php echo $value2[1]; ?></div></td>                                                        <td width="13%"><div align="right"><?php echo $value2[2]; ?></div></td>                                                        <td width="20%"><div align="left"><?php echo $value2[3]; ?></div></td>                                                        <td><div align="left"><?php echo $value2[4]; ?></div></td>                                                    </tr>                                                    <?php } ?>                                                </table>                                            </div>                                        </td>                                        <td><div align="right"><?php echo $value[6]; ?></div></td>                                        <td><div align="center"><?php echo $value[7]; ?></div></td>                                </tr>                        <?php                                endforeach;                        }else{                        ?>                                        <td colspan="8"><div align="center">No hay ningún registro que cumpla con los criterios de búsqueda</div></td>                        <?php                        }                        ?>                        <tr>                                <td colspan="10"><div align="right"><strong>TOTALES <?php echo $moneda_simbolo; ?></strong></div></td>                                <td><div align="right"><strong><?php echo $total_saldo; ?></strong></div></td>                                <td><div align="right"><strong>&nbsp;</div></td>                        </tr>                </table>                <br/>                <div class="fuente8" align="left"><b>ULTIMOS PAGOS</b></div>                <br/>                <table class="fuente8" width="70%" cellspacing=1 cellpadding="3" border=0 align="left">                        <tr class="cabeceraTabla">                                <th width="20%">F. Pago</th>                                <th width="10%">Mnd</th>                                <th width="20%">Importe</th>                                <th width="12%">Forma de Pago</th>                                <th>Observación</th>                        </tr>                        <?php                        if(count($lista_ultimos) > 0){                                foreach($lista_ultimos as $indice=>$value){                                $class = $indice%2==0?'itemParTabla':'itemImparTabla';                                ?>                                <tr class="<?php echo $class;?>">                                    <td width="12%"><div align="center"><?php echo $value[0]; ?></div></td>                                    <td width="7%"><div align="center"><?php echo $value[1]; ?></div></td>                                    <td width="13%"><div align="right"><?php echo $value[2]; ?></div></td>                                    <td width="20%"><div align="left"><?php echo $value[3]; ?></div></td>                                    <td><div align="left"><?php echo $value[4]; ?></div></td>                                </tr>                        <?php                                }                        }else{                        ?>                                        <td colspan="4"><div align="center">No hay ningún registro que cumpla con los criterios de búsqueda</div></td>                        <?php                        }                        ?>                </table>        </div>        <?php } ?>    </div>    </div></div>