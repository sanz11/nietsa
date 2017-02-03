<script type="text/javascript"
	src="<?php echo base_url();?>js/jquery.metadata.js"></script>
<script type="text/javascript"
	src="<?php echo base_url();?>js/jquery.validate.js"></script>
<script type="text/javascript"
	src="<?php echo base_url();?>js/maestros/state.js"></script>
<script type="text/javascript"
	src="<?php echo base_url();?>js/colorpicker.js"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/colorPicker.css"  />
		

<div id="pagina">
	<div id="zonaContenido">
		<div align="center">
			<div id="tituloForm" class="header"></div>
			<div id="frmBusqueda">
				<form id="form_state" name="form_state" method="post">

					<table style="width: 100%;" cellspacing="10" cellpadding="5"
						border="0">
						<!-- Lo cambiaremos por CSS -->
						<tr>
							<td align='left'>Estado</td>
							<td align='left'><input id="txtEstado" name="txtEstado" type="text" ></td>

							<td align='left' rowspan="2">Descripcion</td>
							<td align='left' rowspan="2">
								<textarea rows="5" cols="40" id="txtdescripcion" name="txtdescripcion"></textarea>
							</td>
						</tr>
						<tr>
							<td align='left'>Documento</td>
							<td align='left'><select id="cbodocumento" name="cbodocumento"><?php echo $cboDocumento; ?></select></td>

						</tr>
						<tr>
						<td>Color</td>
						<td>
							<input type="text" id="txtcolor" name="txtcolor" onclick="startColorPicker(this)" onkeyup="maskedHex(this)">
						</td>
						</tr>

					</table>
				</form>
			</div>
			<div class="acciones">
				<div id="botonBusqueda">
					<ul id="limpiarState" class="lista_botones">
						<li id="limpiar">Limpiar</li>
					</ul>
					<ul id="buscarState" class="lista_botones">
						<li id="buscar">Buscar</li>
					</ul>
					<ul id="nuevaArea" class="lista_botones">
						<li id="nuevo">Agregar State</li>
					</ul>
				</div>
				<div id="lineaResultado">
					<table class="fuente7" width="100%" cellspacing=0 cellpadding=3	border="0">
						<tr>
							<td width="50%" align="left">N de cargos encontrados:&nbsp;</td>
						</tr>
					</table>
				</div>
			</div>
			<div id="cabeceraResultado" class="header"></div>
			<div id="divpueba"></div>
			<div id="idtablacontenido">
				<table class="fuente8" border="0" ID="Table1">
					<tr class="cabeceraTabla">
						<td width="5%">ITEM</td>
						<td width="5%">ESTADO</td>
						<td width="5%">DOCUMENTO</td>
						<td width="5%">DESCRIPCION</td>
						<td width="5%">ACCIONES</td>
					</tr>
					
                 <?php
                                        $i=1;
                                        
                                        foreach($lista as $indice=>$valor){
                                                $class = $indice%2==0?'itemParTabla':'itemImparTabla';
                                                ?>
                                                <tr class="<?php echo $class;?>">
                                                        <td  width="3%"><div align="center"><?php echo $valor[0];?></div></td>
                                                        <td><div align="left"><?php echo $valor[1];?></div></td>
                                                        <td><div align="left"><?php echo $valor[2];?></div></td>
														<td><div align="left"><?php echo $valor[3];?></div></td>
                                                        <td><div align="center"><?php echo $valor[4];?></div></td>
                                                </tr>
                                                <?php
                                                $i++;
                                                }
                                        ?>    
				          
				</table>
				
			</div>

		</div>
	</div>
</div>