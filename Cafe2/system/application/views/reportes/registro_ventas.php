<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.metadata.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/maestros/area.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {

        $("#tipo_doc").change(function() {

            tipo_docu = $("#tipo_doc").val();
            tipo_oper = $("#tipo_oper").val();
            fecha1 = $("#fecha1").val();
            fecha2 = $("#fecha2").val();

            location.href = "<?php echo base_url() ?>index.php/reportes/ventas/registro_ventas/" + tipo_oper + "/" + tipo_docu + "/" + fecha1 + "/" + fecha2;

        });
        $("#imprimirArea").click(function() {
            tipo_docu = $("#tipo_doc").val();
            tipo_oper = $("#tipo_oper").val();
            fecha1 = $("#fecha1").val();
            fecha2 = $("#fecha2").val();

            var url = "<?php echo base_url() ?>index.php/reportes/ventas/registro_ventas_pdf/" + tipo_oper + "/" + tipo_docu + "/" + fecha1 + "/" + fecha2;
            window.open(url, '', "menubars=no,resizable=no;");
        });

        $("#imprimirexcel").click(function() {

            tipo_docu = $("#tipo_doc").val();

            tipo_oper = $("#tipo_oper").val();

            fecha1 = $("#fecha1").val();

            fecha2 = $("#fecha2").val();

            location.href = "<?php echo base_url() ?>index.php/reportes/ventas/registro_ventas_excel2/" + tipo_oper + "/" + tipo_docu + "/" + fecha1 + "/" + fecha2;

        });
        
        $("#imprimirexcel_contador").click(function() {

            tipo_docu = $("#tipo_doc").val();

            tipo_oper = $("#tipo_oper").val();

            fecha1 = $("#fecha1").val();

            fecha2 = $("#fecha2").val();

            location.href = "<?php echo base_url() ?>index.php/reportes/ventas/registro_ventas_excel/" + tipo_oper + "/" + tipo_docu + "/" + fecha1 + "/" + fecha2;

        });


//error key
//         $("#fecha").key(function() {
//             tipo_docu = $("#tipo_doc").val();
//             tipo_oper = $("#tipo_oper").val();
//             fecha1 = $("#fecha1").val();
//             fecha2 = $("#fecha2").val();
//            location.href = "<?php echo base_url() ?>index.php/reportes/ventas/registro_ventas/" + tipo_oper + "/" + tipo_docu + "/" + fecha1 + "/" + fecha2;
// 		 });




    });


</script>    
<div id="pagina">
    <div id="zonaContenido">
        <div align="center">
            <div id="tituloForm" class="header"><?php //echo $titulo;    ?></div>
            <input type="hidden" name="tipo_oper" id="tipo_oper" value="<?php echo $tipo_oper ?>" />
      
<div class="acciones">

      <div id="botonBusqueda" style="width:100%">
<div style="float:left;">
                Desde:
                <input name="fecha1" type="text" class="cajaGeneral cajaSoloLectura" id="fecha1" value="<?php echo $fecha1; ?>" size="10" maxlength="10" readonly="readonly" />
                <img height="16" border="0" width="16" id="Calendario1" name="Calendario1" src="<?php echo base_url(); ?>images/calendario.png" />
                <script type="text/javascript">
                    Calendar.setup({
                        inputField: "fecha1", // id del campo de texto
                        ifFormat: "%Y-%m-%d", // formaClienteto de la fecha, cuando se escriba en el campo de texto
                        button: "Calendario1"   // el id de
                    });
                </script>
                Hasta:
                <input name="fecha2" type="text" class="cajaGeneral cajaSoloLectura" id="fecha2" value="<?php echo $fecha2; ?>" size="10" maxlength="10" readonly="readonly" />
                <img height="16" border="0" width="16" id="Calendario2" name="Calendario2" src="<?php echo base_url(); ?>images/calendario.png" />
                <script type="text/javascript">
                    Calendar.setup({
                        inputField: "fecha2", // id del campo de texto
                        ifFormat: "%Y-%m-%d", // formaClienteto de la fecha, cuando se escriba en el campo de texto
                        button: "Calendario2"   // el id del 
                    });
                </script>                
                <select id="tipo_doc" name="tipo_doc">
                    <option value="">::Seleccione::</option>
                    <option value="F" <?php if ($tipo_docu == 'F') echo 'selected="selected"'; ?>>Factura</option>
                    <option value="B" <?php if ($tipo_docu == 'B') echo 'selected="selected"'; ?>>Boletas</option>
                    <option value="N" <?php if ($tipo_docu == 'N') echo 'selected="selected"'; ?>>Comprobante</option>

                </select> 
</div>  
                <ul id="imprimirArea" class="lista_botones"><li id="imprimir">Imprimir PDF</li></ul>
                <ul id="imprimirexcel" class="lista_botones"><li id="imprimir">Descargar EXCEL</li></ul>
                <ul id="imprimirexcel_contador" class="lista_botones"><li id="imprimir" style="width:200px; background-position:90px 4px;">Descargar EXCEL-CONTADOR</li></ul>
            </div>
</div>
            <div id="cabeceraResultado" class="header"><?php echo $titulo_tabla; ?></div>
            <div id="frmResultado">
                <table class="fuente8" width="100%" cellspacing="0" cellpadding="3" border="0" ID="Table1">
                    <tr class="cabeceraTabla">
                        <td width="10%">FEHCA DE EMISION</td>
                        <td width="7%">TIPO</td>
                        <td width="5%">SERIE</td>
                        <td width="5%">NUMERO</td>
                        <td width="10%">NOMBRE Y/O RAZON SOCIAL</td>
                        <td width="5%">RUC</td>
                        <td width="5%">VALOR VENTA</td>
                        <td width="5%">I.G.V</td>
                        <td width="5%">TOTAL IMPORTE</td>
                    </tr>
                    <?php
                    if (count($lista) > 0) {
						$valor_ventaS = 0;
                        $valor_igvS = 0;
                        $valor_totalS =0;
								
                        $valor_ventaD = 0;
                        $valor_igvD = 0;
                        $valor_totalD =0;
                       
                        foreach ($lista as $indice => $valor) {
                            $fecha = $valor->CPC_Fecha;
                            $tipo = $valor->CPC_TipoDocumento;
                            $serie = $valor->CPC_Serie;
                            $numero = $valor->CPC_Numero;
                            $flag = $valor->CPC_FlagEstado;
                            $tipo_persona = $valor->CLIC_TipoPersona;
                            $tipo_proveedor = $valor->PROVC_TipoPersona;
							$tipo_Moneda=$valor->MONED_Simbolo;
							$cod_Moneda=$valor->MONED_Codigo;
                            if ($flag == 1) {
                                $venta = $valor->CPC_subtotal;
                                $igv = $valor->CPC_igv;
                                $total = $valor->CPC_total;

                               if($cod_Moneda==1){
                                $valor_ventaS += $venta;
                                $valor_igvS += $igv;
                                $valor_totalS +=$total;}
								if($cod_Moneda==2){
                                $valor_ventaD += $venta;
                                $valor_igvD += $igv;
                                $valor_totalD +=$total;}	
								
								
                                if ($tipo_oper == 'V') {
                                    if ($tipo_persona == '0') {
                                        $nombre = $valor->PERSC_Nombre . " " . $valor->PERSC_ApellidoPaterno . " " . $valor->PERSC_ApellidoMaterno;
                                        $ruc = $valor->PERSC_Ruc;
                                    } else {
                                        $nombre = $valor->EMPRC_RazonSocial;
                                        $ruc = $valor->EMPRC_Ruc;
                                    }
                                } else {
                                    if ($tipo_proveedor == '0') {
                                        $nombre = $valor->PERSC_Nombre . " " . $valor->PERSC_ApellidoPaterno . " " . $valor->PERSC_ApellidoMaterno;
                                        $ruc = $valor->PERSC_Ruc;
                                    } else {
                                        $nombre = $valor->EMPRC_RazonSocial;
                                        $ruc = $valor->EMPRC_Ruc;
                                    }
                                }
                            } else {

                                $nombre = "ANULADO";
                                $ruc = "";
                                $venta = "";
                                $igv = "";
                                $total = "";
                            }


                            $class = $indice % 2 == 0 ? 'itemParTabla' : 'itemImparTabla';
                            ?>
                            <tr class="<?php echo $class; ?>">
                                <td><div align="center"><?php echo $fecha; ?></div></td>
                                <td><div align="left"><?php if ($tipo == 'F')
                        echo "Factura";
                    else
                        echo "Boleta"
                        ?></div></td>
                                <td><div align="center"><?php echo $serie; ?></div></td>
                                <td><div align="center"><?php echo $numero; ?></div></td>
                                <td><div align="center"><?php echo $nombre; ?></div></td>
                                <td><div align="center"><?php echo $ruc; ?></div></td>
                                <td><div align="center"><?php if ($venta != NULL)
                                    echo $venta;
                                else
                                    echo "0.00";
                            ?></div></td>
                                <td><div align="center"><?php if ($igv != NULL)
                        echo $igv;
                    else
                        echo "0.00";
                    ?></div></td>
                                <td><div align="center"><?php echo $tipo_Moneda;?>&nbsp;<?php echo $total; ?></div></td>
                            </tr>
                            <?php
                        }
                        ?>
                       <tr>
                            <td colspan="6"></td>

                            <td><div align="center"><?php echo $valor_ventaS; ?></div></td>
                            <td><div align="center"><?php echo $valor_igvS; ?></div></td>
                            <td><div align="center">S/.<?php echo number_format($valor_totalS, 2); ?></div></td>
							
							
                        </tr>
						 <tr>
                            <td colspan="6"></td>

                            <td><div align="center"><?php echo $valor_ventaD; ?></div></td>
                            <td><div align="center"><?php echo $valor_igvD; ?></div></td>
                            <td><div align="center">US$ <?php echo number_format($valor_totalD, 2); ?></div></td>
							
							
                        </tr>
    <?php
}
else {
    ?>
                    </table>

                    <table width="100%" cellspacing="0" cellpadding="3" border="0" class="fuente8">
                        <tbody>
                            <tr>
                                <td width="100%" class="mensaje">No hay ning&uacute;n registro que cumpla con los criterios de b&uacute;squeda</td>
                            </tr>
                        </tbody>
                    </table>
    <?php
}
?>
            </div>
<!--            <div style="margin-top: 15px;"><?php echo $paginacion; ?></div>-->
            <input type="hidden" id="iniciopagina" name="iniciopagina">
            <input type="hidden" id="cadena_busqueda" name="cadena_busqueda">
<!--            <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url(); ?>">-->

        </div>
    </div>
 </div>    