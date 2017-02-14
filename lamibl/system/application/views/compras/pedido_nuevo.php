<html>
	<head>	
        <script type="text/javascript" src="<?php echo base_url();?>js/jquery.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/jquery.validate.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/compras/pedido.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/funciones.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
		<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-ui.custom.min.js"></script>
		<script src="<?php echo base_url(); ?>js/jquery.columns.min.js"></script>
		
		
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
				
				$(function () {
					  $("#buscar_producto").autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: "<?php echo base_url(); ?>index.php/almacen/producto/autocomplete/B/" + $("#compania").val()+"/"+$("#almacen").val(),
                        type: "POST",
                        data: {
                            term: $("#buscar_producto").val()
                        },
                        dataType: "json",
                        success: function (data) {
                            response(data);
                        }
                    });
                },
                select: function (event, ui) {
                	/**si el producto tiene almacen : es que no esta inventariado en ese almacen , se le asigna el almacen general de cabecera**/
                    if(ui.item.almacenProducto==0){
                    	ui.item.almacenProducto=$("#almacen").val();
                    }
                    /**fin de asignacion**/
                //	isEncuentra=verificarProductoDetalle(ui.item.codigo,ui.item.almacenProducto);
                  //  if(!isEncuentra){
	                    $("#buscar_producto").val(ui.item.codinterno);
	                    $("#producto").val(ui.item.codigo);
	                    $("#codproducto").val(ui.item.codinterno);
	                    $("#costo").val(ui.item.pcosto);
	                    $("#stock").val(ui.item.stock);
	                    $("#flagGenInd").val(ui.item.flagGenInd);
	                    $("#almacenProducto").val(ui.item.almacenProducto);
	                    $("#cantidad").focus();
	                    listar_unidad_medida_producto(ui.item.codigo);
                   /* }else{
                    	$("#buscar_producto").val("");
     	                $("#producto").val("");
     	                $("#codproducto").val("");
     	                $("#costo").val("");
     	                $("#stock").val("");
     	                $("#flagGenInd").val("");
     	               	$("#nombre_producto").val("");
     	                $("#almacenProducto").val("");
                    	$("#buscar_producto").val("");
                    	alert("El producto ya se encuentra ingresado en la lista de detalles.");
                    	return !isEncuentra;
                    }*/
                },
                minLength: 1
            });
            	  $("#buscar_cliente").autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: "<?php echo base_url(); ?>index.php/ventas/cliente/autocomplete_ruc/",
                        type: "POST",
                        data: {
                            term: $("#buscar_cliente").val()
                        },
                        dataType: "json",
                        success: function (data) {
                            response(data);
                        }
                    });
                },
                select: function (event, ui) {
                   $("#nombre_cliente").val(ui.item.nombre);
                    $("#cliente").val(ui.item.codigo);
                    $("#ruc_cliente").val(ui.item.ruc);
                    $("#buscar_producto").focus();
                },
                minLength: 2
            });

            /* Descativado hasta corregir vico 22082013 - quien es vico? (fixed) - pregunto lo mismo que es vicio(ABAc). */

            //AUTOCOMENTADO EN CLIENTE BUSCAR
            $("#nombre_cliente").autocomplete({
                //flag = $("#flagBS").val();
                source: function (request, response) {
                    $.ajax({
                        url: "<?php echo base_url(); ?>index.php/ventas/cliente/autocomplete/",
                        type: "POST",
                        data: {
                            term: $("#nombre_cliente").val()
                        },
                        dataType: "json",
                        success: function (data) {
                            response(data);
                        }
                    });

                },

                select: function (event, ui) {
                    $("#buscar_cliente").val(ui.item.ruc);
                    $("#cliente").val(ui.item.codigo);
                    $("#ruc_cliente").val(ui.item.ruc);
                     listar_contactos(ui.item.codigoEmpresa);
                    $("#buscar_producto").focus();
                },
                minLength: 2
    				
            });
			});
			
			function seleccionar_producto(codigo,interno,familia,stock,costo){
				$("#producto").val(codigo);
				$("#codproducto").val(interno);
				$("#cantidad").focus();
				listar_unidad_medida_producto(codigo);
			}
			
		
        function seleccionar_cliente(codigo, ruc, razon_social) {
            $("#cliente").val(codigo);
            $("#buscar_cliente").val(ruc);
            $("#nombre_cliente").val(razon_social);

        }

        });
		</script>
		
	</head>
	<body>
	<?php
		$tipo_docu = 'B';
	?>
<!-- Inicio -->
<input value='<?php echo $compania; ?>' name="compania" type="hidden" id="compania" />
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
								<li><label for="nombre_pedido" class="error">Por favor ingrese la nombre del pedido.</label></li>
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
                        	<td width="10%">Número de<br> Documento</td>
                                  <td width="25%"><input name="numero_documento" class="cajaPequena" type="text" class="cajaMedia" id="numero_documento" size="15" maxlength="8" value="<?php echo $numero_documento;?>" onkeypress="return numbersonly('numero_documento',event);">
                                  </td>
                        	<td align='left' width="10%">Fecha </td>
                                    <td align='left' width="35%">
                                        <?php echo $fechai?>
                                        <img src="<?php echo base_url();?>images/calendario.png" name="Calendario1" id="Calendario1" width="16" height="16" border="0" onMouseOver="this.style.cursor='pointer'" title="Calendario"/>
                                        <script type="text/javascript">
                                            Calendar.setup({
                                                inputField     :    "fechai",      // id del campo de texto
                                                ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
                                                button         :    "Calendario1"   // el id del botón que lanzará el calendario
                                            });
                                        </script>
                                    </td>
                        </tr>
                        <tr>
                         <td>Nombre de <br> Requerimiento&nbsp;(*)</td>
                                  <td>
                                 <input id="nombre_pedido" type="text" class="cajaGrande" name="nombre_pedido" maxlength="45" value="<?php echo $nombre_pedido; ?>">
                                  </td>
                        
                        
                            <td>Hora</td>
                                    <td>
                                  <!--  <input class="timepicker text-center" jt-timepicker="" time="model.time" time-string="model.timeString" default-time="model.options.defaultTime" time-format="model.options.timeFormat" start-time="model.options.startTime" min-time="model.options.minTime" max-time="model.options.maxTime" interval="model.options.interval" dynamic="model.options.dynamic" scrollbar="model.options.scrollbar" dropdown="model.options.dropdown"> -->
                                   <input type="time" id="hora" name="hora" class="cajaPequena" value="<?php echo $hora; ?>" class="ui-spinner-input" autocomplete="off" role="spinbutton" aria-valuenow="1">
                                   </td>
                                  <script type="text/javascript">
                                  	
                                  /*	$('.timepicker').timepicker({
										    timeFormat: 'h:mm p',
										    interval: 60,
										    minTime: '1:00am',
										    maxTime: '12:00pm',
										    defaultTime: '11',
										    startTime: '10:00',
										    dynamic: false,
										    dropdown: true,
										    scrollbar: true
										});*/
                                  </script>
                        		</tr>
                                <tr>
                                <td>Cliente *</td>
                                <td  valign="middle">
                        	 <input type="hidden" name="cliente" id="cliente" size="5"
                                       value="<?php echo $cliente; ?>"/>
                                <input placeholder="ruc" name="buscar_cliente" type="text" class="cajaGeneral"
                                       id="buscar_cliente" size="10" value="<?php echo $ruc_cliente; ?>"
                                       title="Ingrese parte del nombre o el nro. de documento, luego presione ENTER."/>&nbsp;
                                <input type="hidden" name="ruc_cliente" class="cajaGeneral" id="ruc_cliente" size="10"
                                       maxlength="11" onblur="obtener_cliente();" value="<?php echo $ruc_cliente; ?>"
                                       onkeypress="return numbersonly(this,event,'.');"/>
                                <input placeholder="razon social" type="text" name="nombre_cliente" class="cajaGeneral"
                                       id="nombre_cliente" size="37" maxlength="50"
                                       value="<?php echo $nombre_cliente; ?>"/>
                                        <a href="<?php echo base_url(); ?>index.php/ventas/cliente/ventana_selecciona_cliente/"
                               id="linkSelecCliente"></a>
                        </td>
                  
                                    <td width="16%">Centro de Costo&nbsp;(*)</td>
                                    <td>
                                        <select id="centro_costo" name="centro_costo" class="comboMedio">
                                           <?php echo $centro_costo;?>
                                        </select>
                                    </td>
                                
                                </tr>
                                <tr>
                                              <td>Contacto </td>
		    <td><?php echo $cboContacto;?>
                     <!--   <a href="<?php echo base_url();?>index.php/maestros/persona/persona_ventana_mostrar/<?php if($contacto!=''){ $temp=explode('-', $contacto);  echo $temp[0];} else echo '1';  ?>" <?php if($contacto=='') echo 'style="display:none;"'; ?> id="linkVerPersona"><img height='16' id="" width='16' src='<?php echo base_url(); ?>/images/ver.png' title='Más Información' border='0' /></a>-->
                   </td>
                                  <td>Tipo de Requerimiento</td>
                                  <td>
                                      <select name="tipo_pedido" id="tipo_pedido" class="comboMedio">
                                        <option value="0">:: Seleccione ::</option>
                                        <option value="I" <?php if($tipo_pedido == 'I'): echo 'selected'; endif; ?>>Interno</option>
                                        <option selected value="E" <?php if($tipo_pedido == 'E'): echo 'selected'; endif; ?>>Externo</option>
                                      </select>
                                  </td>
                                </tr>
                                
							<!--	<tr>
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
                                </tr>-->
                        </table>
                        </div>
				 </div>	
					<div id="frmBusqueda" style="height:250px; overflow: auto">
						<table class="fuente8" width="100%" cellspacing=0 cellpadding=3 border=0>
							<tr>
								<td width="6%">Art&iacute;culo</td>
								<td width="38%">

									 <input name="producto" type="hidden" class="cajaGeneral" id="producto"/>
                        <input name="buscar_producto" type="text" class="cajaGeneral" id="buscar_producto" size="10" placeholder="Producto"
                               title="Ingrese parte del nombre o el nro. de serie del producto, luego presione ENTER."/>&nbsp;
                        <input name="codproducto" type="hidden" class="cajaGeneral" id="codproducto" size="10"
                               maxlength="20" onblur="obtener_producto();"/>
                        <input name="nombre_producto" type="text" class="cajaGeneral cajaSoloLectura"
                               id="nombre_producto" size="39" readonly="readonly" placeholder="Descripcion producto" />
                        <input name="stock" type="hidden" id="stock"/>
                        <input name="costo" type="hidden" id="costo"/>
                        <input name="flagGenInd" type="hidden" id="flagGenInd"/>
                        <input name="almacenProducto" type="hidden" id="almacenProducto"/>
								<!--	<a href="<?php echo base_url();?>index.php/almacen/producto/ventana_busqueda_producto/" id="linkVerProducto"><img height='16' width='16' src='<?php echo base_url(); ?>/images/ver.png' title='Buscar' border='0' /></a>-->
								</td>
								<td width="6%">Detalle</td>
								<td width="45%" rowspan="2"><textarea style="margin: 0px; width: 360px; height: 30px;" id="detalle" name="detalle"></textarea></td>
									
							</tr>
							<tr>
								<td width="6%">Cantidad</td>
								<td width="25%">
									<input NAME="cantidad" type="text" class="cajaGeneral"  id="cantidad" value="" size="3" maxlength="5" onkeypress="return numbersonly(this,event,'.');" />
								<select name="unidad_medida" id="unidad_medida" class="comboMedio" onchange="obtener_precio_producto();"><option value="">::Seleccione::</option></select>
									</td>
									<td  style="display:none;">
										PU <?php if($tipo_docu!='B' && $contiene_igv==true) echo ' (Con IGV)'?>
										 &nbsp;&nbsp;<input NAME="precio" type="text" class="cajaGeneral" id="precio" size="5" maxlength="10" onkeypress="return numbersonly(this,event,'.');" />
									</td>
									<td></td>
							<td width="15%">
								   <div align="right" style="margin-right: 5px;"><a href="javascript:;" onClick="agregar_producto_presupuesto();"><img src="<?php echo base_url();?>images/botonagregar.jpg" border="1" align="absbottom"></a></div>
										</td>
						  </tr>
						</table>
							<table class="fuente8" width="100%" cellspacing="0" cellpadding="3" border="1" ID="Table1">
								<tr class="cabeceraTabla">
									 <td width="3%"><div align="center">&nbsp;</div></td> 
									<td width="3%"><div align="center">ITEM</div></td>
									<td width="7%"><div align="center">C&Oacute;DIGO</div></td>
									<td width="40%"><div  align="center">DESCRIPCI&Oacute;N</div></td>
									<td width="40%"><div align="center">DETALLE</div></td>
									<td width="7%"><div align="center">CANTIDAD</div></td>
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
													<input type="text" class="cajaGeneral" style="width:100%;" name="proddescri[<?=$indice?>]" id="proddescri[<?=$indice?>]" value="<?=$value[1];?>" />
													<td width="40%"><div align="left"><input type="text" class="cajaGeneral" style="width:100%;" maxlength="250" name="proddetalle[<?=$indice?>]" id="proddetalle[<?=$indice?>]" value="<?=$value[5];?>" /></div></td>
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
												<div style="float:left;margin-right: 10px;"><textarea id="observacion_final" name="observacion_final" class="fuente8" cols="130" rows="3"></textarea></div>
										</td>
										
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
						
						<div style="margin-top:100px; text-align: right;" class="fuente8">
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
		</div>
	</body>
</html>