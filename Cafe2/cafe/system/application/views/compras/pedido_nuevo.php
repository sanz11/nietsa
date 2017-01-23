<html>
	<head>	
        <script type="text/javascript" src="<?php echo base_url();?>js/jquery.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/jquery.validate.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/compras/pedido.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/funciones.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
		
		<script type="text/javascript">
			$(document).ready(function(){
				
				$("a#linkVerProducto").fancybox({
					'width'          : 800,
					'height'         : 650,
					'autoScale'	 : false,
					'transitionIn'   : 'none',
					'transitionOut'  : 'none',
					'showCloseButton': false,
					'modal'          : true,
					'type'	     : 'iframe'
				});
				
			});
			
			function seleccionar_producto(codigo,interno,familia,stock,costo){
				$("#producto").val(codigo);
				$("#codproducto").val(interno);
				$("#cantidad").focus();
				listar_unidad_medida_producto(codigo);
			}
			
		</script>
		
	</head>
	<body>
	<?php
		$tipo_docu = 'B';
	?>
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
                                  <td>Número de Documento</td>
                                  <td><input name="numero_documento" type="text" class="cajaMedia" id="numero_documento" size="15" maxlength="8" value="<?php echo $numero_documento;?>" onkeypress="return numbersonly('numero_documento',event);">
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
					<div id="frmBusqueda" style="height:250px; overflow: auto">
						<table class="fuente8" width="100%" cellspacing=0 cellpadding=3 border=0>
							<tr>
								<td width="6%">Art&iacute;culo</td>
								<td width="38%">
									<input name="producto" type="hidden" class="cajaGeneral" id="producto" />
									<input name="codproducto" type="text" class="cajaGeneral" id="codproducto" size="10" maxlength="20" onblur="obtener_producto();" />&nbsp;
									<input NAME="nombre_producto" type="text" class="cajaGeneral cajaSoloLectura" id="nombre_producto" size="40" readonly="readonly" />
									<a href="<?php echo base_url();?>index.php/almacen/producto/ventana_busqueda_producto/" id="linkVerProducto"><img height='16' width='16' src='<?php echo base_url(); ?>/images/ver.png' title='Buscar' border='0' /></a>
								</td>
								<td width="6%">Cantidad</td>
								<td width="25%">
									<input NAME="cantidad" type="text" class="cajaGeneral"  id="cantidad" value="" size="3" maxlength="5" onkeypress="return numbersonly(this,event,'.');" />
								<select name="unidad_medida" id="unidad_medida" class="comboMedio" onchange="obtener_precio_producto();"><option value="">::Seleccione::</option></select>
									</td>
									<td width="15%" style="display:none;">
										PU <?php if($tipo_docu!='B' && $contiene_igv==true) echo ' (Con IGV)'?>
										 &nbsp;&nbsp;<input NAME="precio" type="text" class="cajaGeneral" id="precio" size="5" maxlength="10" onkeypress="return numbersonly(this,event,'.');" />
									</td>
								<td width="15%">
								   <div align="right"><a href="javascript:;" onClick="agregar_producto_presupuesto();"><img src="<?php echo base_url();?>images/botonagregar.jpg" border="1" align="absbottom"></a></div>
										</td>
						  </tr>
						</table>
							<table class="fuente8" width="100%" cellspacing="0" cellpadding="3" border="1" ID="Table1">
								<tr class="cabeceraTabla">
									<td width="3%"><div align="center">&nbsp;</div></td>
									<td width="4%"><div align="center">ITEM</div></td>
									<td width="10%"><div align="center">C&Oacute;DIGO</div></td>
									<td><div align="center">DESCRIPCI&Oacute;N</div></td>
									<td width="10%"><div align="center">CANTIDAD</div></td>
								</tr>
							</table>
						<div>
							<table id="tblDetalleCotizacion" class="fuente8" width="100%" border="0">
								<?php
								if(count($array_detalle) > 0){
									foreach($array_detalle as $indice=>$value){
										?>
										<tr>
											<td width="3%">
											<div align="center"><font color="red"><strong><a href="javascript:;" onclick="eliminar_producto_presupuesto(<?php echo $indice;?>);"><span style="border:1px solid red;background: #ffffff;">&nbsp;X&nbsp;</span></a></strong></font></div></td>
											<td width="4%"><div align="center"><?=$indice+1;?></div></td>
											<td width="10%">
												<div align="center">
													<input type="hidden" name="prodcodigo[<?=$indice?>]" id="prodcodigo[<?=$indice?>]" value="<?= $value[0];?>" />
													<?=$value[0];?>
													<input type="hidden" name="produnidad[<?=$indice?>]" id="produnidad[<?=$indice?>]" value="<?= $value[3];?>"/>
													<input type="hidden" name="eliminado[<?php echo $indice;?>]" id="eliminado[<?php echo $indice;?>]" value="no"/>
												</div>
											</td>
											<td>
												<div align="left">
													<input type="text" class="cajaGeneral" style="width:395px;" name="proddescri[<?=$indice?>]" id="proddescri[<?=$indice?>]" value="<?=$value[1];?>" />
												</div>
											</td>
											<td width="10%">
												<div align="center">
													<input type="text" class="cajaGeneral" size="1" name="prodcantidad[<?=$indice?>]" id="prodcantidad[<?=$indice?>]" value="<?=$value[2];?>" /><?= $value[4];?>
												</div>
											</td>
										</tr>
										<?php
									}
								}
								
								?>
							</table>
							</div>					
						</div>	
						<div id="frmBusqueda3">
						<br>
							<table width="100%" border="0" align="right" cellpadding="3" cellspacing="0" class="fuente8">
								<tr>
										<td width="80%" rowspan="4" align="left">
												<div style="float: left;padding-left:6px;padding-top: 0px;height:30px;width: 100px;">OBSERVACION</div>
												<div style="float:left;margin-right: 10px;"><textarea id="observacion" name="observacion" class="fuente8" cols="130" rows="3"></textarea></div>
										</td>
										<td width="10%" class="busqueda">&nbsp;</td>
										<td width="10%" align="right">&nbsp;</td>
								</tr>
							</table>
						
									<table width="100%" border="0" align="right" cellpadding=3 cellspacing=0 class="fuente8" style="display:none;">
									<tr>
										<td width="10%" valign="top">
											<table  style ="display:none;" width="100%" border="0" align="right" cellpadding=3 cellspacing=0 class="fuente8" style="margin-top:20px;">
											   <tr>
												<td>Sub-total</td>
												<?php if($tipo_docu!='B'){ ?>
												<td width="10%" align="right"><div align="right"><input class="cajaTotales" name="preciototal" type="text" id="preciototal" size="12" align="right" readonly="readonly" value="<?php echo round($preciototal,2);?>" /></div></td>
												<?php }else{ ?>
												<td width="10%" align="right"><div align="right"><input class="cajaTotales" name="preciototal_conigv" type="text" id="preciototal_conigv" size="12" align="right" readonly="readonly" value="<?php echo round($preciototal_conigv,2);?>" /></div></td>
												<?php } ?>
												</tr>
												<tr>
												<td>Descuento</td>
												<?php if($tipo_docu!='B'){ ?>
													<td align="right"><div align="right"><input class="cajaTotales" name="descuentotal" type="text" id="descuentotal" size="12" align="right" readonly="readonly" value="<?php echo round($descuentotal,2);?>" /></div></td>
												<?php }else{ ?>
													<td align="right"><div align="right"><input class="cajaTotales" name="descuentotal_conigv" type="text" id="descuentotal_conigv" size="12" align="right" readonly="readonly" value="<?php echo round($descuentotal_conigv,2);?>" /></div></td>
												<?php } ?>
												</tr>
												<?php if($tipo_docu!='B'){ ?>
												<tr>
													<td>IGV</td>
													<td align="right"><div align="right"><input class="cajaTotales" name="igvtotal" type="text" id="igvtotal" size="12" align="right" readonly="readonly" value="<?php echo round($igvtotal,2);?>" /></div></td>
												</tr>
												<?php } ?>
												<tr>
													<td>Precio Total</td>
													<td align="right"><div align="right"><input class="cajaTotales" name="importetotal" type="text" id="importetotal" size="12" align="right" readonly="readonly" value="<?php echo round($importetotal,2);?>" /></div></td>
												</tr> 
											</table>
										</td>
									</tr>
								</table>
						</div>		
						<br />
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
					</div>					
			  </form>
		  </div>
		  </div>
		</div></div>
	</body>
</html>