<script type="text/javascript" src="<?php echo base_url();?>js/jquery.js"></script>	
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.metadata.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.validate.js"></script>			
<script type="text/javascript" src="<?php echo base_url();?>js/compras/pedido.js"></script>
<div id="pagina">
    <div id="zonaContenido">
                <div align="center">
                        <div id="tituloForm" class="header">Buscar PEDIDO </div>
                        <div id="frmBusqueda">
                        <form id="form_busqueda" name="form_busqueda" method="post" action="<?php echo $action;?>">
                            <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
                                    <tr>
                                            <td width="16%">N. de Documento </td>
                                            <td width="68%"><input id="txtNumDoc" type="text" class="cajaPequena" NAME="txtNumDoc" maxlength="15" value="<?php echo $numdoc; ?>">
                                            <td width="5%">&nbsp;</td>
                                            <td width="5%">&nbsp;</td>
                                            <td width="6%" align="right"></td>
                                    </tr>
                                    <tr>
                                            <td>Observacion </td>
                                            <td><input id="txtNombre" name="txtNombre" type="text" class="cajaGrande" maxlength="45" value="<?php echo $nombre; ?>"></td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                    </tr>
                                     
                            </table>
                        </form>
                  </div>
                  <div class="acciones">
                    <div id="botonBusqueda">
                           <ul id="imprimirPedido" class="lista_botones"><li id="imprimir">Imprimir</li></ul>
                           <ul id="nuevoPedido" class="lista_botones"><li id="nuevo">Nuevo Pedido</li></ul>
                           <ul id="limpiarPedido" class="lista_botones"><li id="limpiar">Limpiar</li></ul>
                           <ul id="buscarPedido" class="lista_botones"><li id="buscar">Buscar</li></ul>
                    </div>
                  <div id="lineaResultado">
                      <table class="fuente7" width="100%" cellspacing=0 cellpadding=3 border="0">
                            <tr>
                            <td width="100%" align="left">N de pedidos encontrados:&nbsp;<?php echo $registros;?> </td>
                            <td width="50%" align="right">&nbsp;</td>
                      </table>
                  </div>
                  </div>
                        <div id="cabeceraResultado" class="header">
                                <?php echo $titulo_tabla; ?> </div>

                      
                        <div id="frmResultado">
                        <table class="fuente8" width="100%" cellspacing="0" cellpadding="3" border="0" ID="Table1">
                                        <tr class="cabeceraTabla">
                                                <td width="8%">ITEM</td>
												<td width="8%">SERIE</td>
												 <td width="8%">NUMERO</td>
												<td width="13%">RAZON SOCIAL</td>
                                                <td width="38%">OBRA</td>
                                                <td width="5%">ACCIONES</td>
                                                <td width="5%">&nbsp;</td>
                                        </tr>
                                        <?php
                                        $i=1;
                                        if(count($lista)>0){
                                        foreach($lista as $indice=>$valor){
                                                $class = $indice%2==0?'itemParTabla':'itemImparTabla';
                                                ?>
                                                <tr class="<?php echo $class;?>">
                                                        <td><div align="center"><?php echo $valor[0];?></div></td>
                                                        <td><div align="left"><?php echo $valor[1];?></div></td>
														 <td><div align="left"><?php echo $valor[2];?></div></td>
                                                        <td><div align="center"><?php echo $valor[3];?></div></td>
                                                        <td><div align="center"><?php echo $valor[4];?></div></td>
                                                        <td><div align="center"><?php echo $valor[5];?></div></td>
                                                        <td><div align="center"><?php echo $valor[6];?></div></td>
                                                        
                                                </tr>
                                                <?php
                                                $i++;
                                                }
                                        }
                                        else{
                                        ?>
                                        <table width="100%" cellspacing="0" cellpadding="3" border="0" class="fuente8">
                                                <tbody>
                                                        <tr>
                                                            <td width="100%" class="mensaje">No hay ning&uacute;n pedido que cumpla con los criterios de b&uacute;squeda</td>
                                                        </tr>
                                                </tbody>
                                        </table>
                                        <?php
                                        }
                                        ?>
                        </table>
                        <input type="hidden" id="iniciopagina" name="iniciopagina">
                        <input type="hidden" id="cadena_busqueda" name="cadena_busqueda">
                </div>
            <div style="margin-top: 15px;"><?php echo $paginacion;?></div>
            <input type="text" style="visibility:hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
        </div>
    </div>
</div>