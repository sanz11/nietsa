<html>
<head>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/ventas/comprobante.js"></script>

</head>
<body>
<div id="pagina">
    <div id="zonaContenido">
        <div align="center">
            <div id="tituloForm" class="header"><?php echo $titulo_busqueda; ?></div>
            <form id="form_busqueda" name="form_busqueda" method="post"
                  action="<?php echo base_url(); ?>index.php/ventas/comprobante/comprobantes">
                <div id="frmBusqueda">
                    
                </div>
                <div class="acciones">
                    <div id="botonBusqueda">
                        <ul id="nuevasimulaCompro" class="lista_botones">
                            <li id="nuevo">Simular un Comprobante</li>
                        </ul>  
                    </div>
                    <div id="lineaResultado">
                        <table class="fuente7" width="100%" cellspacing="0" cellpadding="3" border="0">
                            <tr>
                                <td width="100%" align="left">Cantidad de comprobantes :  <?php echo $registros;?>
                                <td width="50%" align="right">&nbsp;</td>
                        </table>
                    </div>
                </div>
             
                <div id="contenedor-busqueda" >
                    <div id="frmResultado">
                        <table class="fuente8" width="100%" cellspacing="0" cellpadding="3" border="0" id="Table1">
                            <tr class="cabeceraTabla">
                                <td width="4%">ITEM</td>
                                <td width="10%">FECHA</td>
                                <td width="5%">SERIE</td>
                                <td width="6%">NUMERO</td>
                                <td width="20%">CLIENTE</td>
                                <td width="5%">PDF</td>
                                <td width="6%">ELIMINAR</td>
						 	</tr>
						 	
						 	<?php  foreach($lista as $indice=>$valor)
                    {
                        $class = $indice%2==0?'itemParTabla':'itemImparTabla';
                        ?>
                        <tr>
                            <td><div align="center"><?php echo $valor[0];?></div></td>
                            <td><div align="CENTER"><?php echo $valor[1];?></div></td>
                            <td><div align="center"><?php echo $valor[2];?></div></td>
                            <td><div align="center"><?php echo $valor[3];?></div></td>
                            <td><div align="center"><?php echo $valor[4];?></div></td>
                            <td><div align="center"><?php echo $valor[5];?></div></td>
                            <td><div align="center"><?php echo $valor[6];?></div></td>
                            
                        </tr>
                        <?php
                        }  ?>
						 	
						 </table>
                    </div>
                    <input type="hidden" id="iniciopagina" name="iniciopagina">
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>