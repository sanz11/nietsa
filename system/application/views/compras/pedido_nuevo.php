<html>
	<head>	
        <script type="text/javascript" src="<?php echo base_url();?>js/jquery.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/jquery.metadata.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/jquery.validate.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/compras/pedido.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/funciones.js"></script>
	</head>
	<body>
<!-- Inicio -->
<div id="VentanaTransparente" style="display:none;">
  <div class="overlay_absolute"></div>
  <div id="cargador" style="z-index:2000">
    <table width="100%" height="100%" border="0" class="fuente8">
		<tr valign="middle">
			<td> Por Favor Espere    </td>
			<td><img src="<?php echo base_url();?>images/cargando.gif"  border="0" title="CARGANDO" /><a href="#" id="hider2"></a>	</td>
		</tr>
    </table>
  </div>
</div>
	<div id="pagina">
			<div id="zonaContenido">
				<div align="center">
				<div id="tituloForm" class="header"><?php echo $titulo;?></div>
				<div id="frmBusqueda">
				<form id="frmPedido" name="frmPedido" method="post" action="">
					<div id="container" class="container">
						<ol>
						<h4>Primero debe completar los siguientes campos antes de enviar.</h4>						
							<div id="containerPedido">
								<li><label for="observacion" class="error">Por favor ingrese la observacion del pedido.</label></li>
								<li><label for="centro_costo" class="error">Por favor seleccione un centro de costo.</label></li>
								<li><label for="responsable_value" class="error">Por favor seleccione un responsable.</label></li>
							</div>
						</ol>
					</div>
                    <div id="nuevoRegistro" style="display:none;float:right;width:150px;height:20px;border:0px solid #000;margin-top:7px;"><a href="#">Nuevo <image src="<?php echo base_url();?>images/add.png" name="agregarFila" id="agregarFila" border="0" alt="Agregar"></a></div><br><br>				
					<div id="datosGenerales">
                       <div id="datosPedido" >
                        <table class="fuente8" width="98%" cellspacing="0" cellpadding="4" border="0">
                                <tr>
                                    <td width="16%">Centro de Costo&nbsp;(*)</td>
                                    <td>
                                        <select id="centro_costo" name="centro_costo" class="comboMedio">
                                           <?php echo $centro_costo;?>
                                        </select>
                                    </td>
                                  <td style="visibility:hidden;">Número de Documento</td>
                                  <td style="visibility:hidden;"><input name="numero_documento" type="text" class="cajaMedia" id="numero_documento" size="15" maxlength="8" value="<?php echo $numero_documento;?>" onkeypress="return numbersonly('numero_documento',event);">
                                  </td>
                                </tr>
                                <tr>
                                  <td>Observacion&nbsp;(*)</td>
                                  <td>
                                      <input id="observacion" type="text" class="cajaGrande" name="observacion" maxlength="45" value="<?php echo $observacion;?>">
                                  </td>
                                  <td>Tipo de Pedido</td>
                                  <td>
                                      <select name="tipo_pedido" id="tipo_pedido">
                                        <option value="0">:: Seleccione ::</option>
                                        <option value="I" <?php if($tipo_pedido == 'I'): echo 'selected'; endif; ?>>Interno</option>
                                        <option value="E" <?php if($tipo_pedido == 'E'): echo 'selected'; endif; ?>>Externo</option>
                                      </select>
                                  </td>
                                </tr>
								<tr>
                                  <td>Tipo de Documento de Regerencia(*)</td>
                                  <td>
										<select name="tipo_documento" id="tipo_documento">
											<option value="0">:: Seleccione ::</option>
											<?php
											echo $combo;
											?>
										</select>
                                  </td>
                                  <td>N&uacute;mero de Referencia</td>
                                  <td>
                                      <input id="num_refe" type="text" class="cajaMedia" name="num_refe" maxlength="45" value="<?php echo $num_refe;?>">
                                  </td>
                                </tr>
                        </table>
                        </div>
				 </div>	  
				<div style="margin-top:20px; text-align: center">
                                        <a href="#" id="imgGuardarPedido"><img src="<?php echo base_url();?>images/botonaceptar.jpg" width="85" height="22" class="imgBoton" onMouseOver="style.cursor=cursor"></a>
					<a href="#" id="imgLimpiarPedido"><img src="<?php echo base_url();?>images/botonlimpiar.jpg" width="69" height="22" class="imgBoton" onMouseOver="style.cursor=cursor"></a>
					<a href="#" id="imgCancelarPedido"><img src="<?php echo base_url();?>images/botoncancelar.jpg" width="85" height="22" class="imgBoton" onMouseOver="style.cursor=cursor"></a>
					<input id="accion" name="accion" value="alta" type="hidden">
					<input type="hidden" name="modo" id="modo" value="<?php echo $modo; ?>">
					<input type="hidden" name="opcion" id="opcion" value="1">
					<input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
					<input type="hidden" id="id" name="id" value="<?php echo $id;?>">
                                </div>
			  </form>
		  </div>
		  </div>
		</div></div>
	</body>
</html>