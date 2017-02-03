<script type="text/javascript" src="<?php echo base_url(); ?>js/almacen/almacen.js"></script>
<div id="pagina">
    <div id="zonaContenido">
        <div align="center">
            <div id="tituloForm" class="header"><?php echo $titulo_busqueda; ?></div>
            <div id="frmBusqueda">
                <table class="fuente8" width="98%" cellspacing=0 cellpadding="5" border=0>
                	<tr>
                		<td width="100px">Tipo de Almacen</td>
                		<td><input type="text" id="txtdescripcion"  value="<?php echo $txtdescripcion; ?> " name="txtdescripcion" style="width:35% " ></td>
                	</tr>
                </table>
            </div>
            <div class="acciones">
                <div id="botonBusqueda">
                    <ul id="nuevotipoalmacen" class="lista_botones">
                        <li id="nuevo">Nuevo Almacen</li>
                    </ul>
                    <ul id="limpiartipoalmacen" class="lista_botones">
                        <li id="limpiar">Limpiar</li>
                    </ul>
                    <ul id="buscartipoalmacen" class="lista_botones">
                        <li id="buscar">Buscar</li>
                    </ul>
                </div>
            </div>
            <div id="cabeceraResultado" class="header"><?php echo $titulo_tabla; ?></div>
            <div id="frmResultado">
				<table class="fuente8" width="98%" cellspacing=0 cellpadding="5" border=1>
                	<tr>
                		<th width="3%">N.</th>
                		<th>DESCRIPCION</th>
                		<th width="5%">ACCIONES</th>
                	</tr>
                	
                	<?php   $i = 1;
                 		   		if (count($lista) > 0) {
                      			  foreach ($lista as $indice => $valor) { ?>
                      			  <tr>
                      			<td><?php echo $valor[0]; ?></td>
                      			<td><?php echo $valor[1]; ?></td>
                      			<td><?php echo $valor[2]; ?></td>
                      			</tr>  
                      			  <?php }
                 		   		}?>
                </table>
            </div>
        </div>
    </div>
</div>