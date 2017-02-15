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
				
				
				/*setInterval(function() {
					var cliente=$("#cliente").val()
					
					if(cliente.length>0){
						$.post("<?php echo base_url(); ?>index.php/compras/pedido/contacto", {
							cliente : cliente
						}, function(data) {
							$('#contacto').html(data);
						});
						}
					},600);*/
					
					
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
               
	                    $("#buscar_producto").val(ui.item.codinterno);
	                    $("#producto").val(ui.item.codigo);
	                    $("#codproducto").val(ui.item.codinterno);
	                    $("#costo").val(ui.item.pcosto);
	                    $("#stock").val(ui.item.stock);
	                    $("#flagGenInd").val(ui.item.flagGenInd);
	                    $("#almacenProducto").val(ui.item.almacenProducto);
	                    $("#cantidad").focus();
	                    listar_unidad_medida_producto(ui.item.codigo);
                  
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
			
		
        
		
		$("a#linkVerCliente, a#linkSelecCliente, a#linkVerProveedor, a#linkSelecProveedor, a#linkedicliente").fancybox({
                'width': 800,
                'height': 550,
                'autoScale': false,
                'transitionIn': 'none',
                'transitionOut': 'none',
                'showCloseButton': true,
                'modal': false,
                'type': 'iframe'

            });
		

        });
		function seleccionar_cliente(codigo, ruc, razon_social,empresa) {
            $("#cliente").val(codigo);
            $("#ruc_cliente").val(ruc);
            $("#nombre_cliente").val(razon_social);
			get_contacto(empresa);
			get_obra(codigo);

        }
		
		function get_contacto(empresa) {
			//alert(codigo);
			$.post("<?php echo base_url(); ?>index.php/compras/pedido/contacto", {
							"codigoempre" : empresa
				}, function(data) {
					//alert("hola"+data);
					var c = JSON.parse(data);
					$.each(c,function(i,item){
						$('#contacto').append("<option value='"+item.PERSP_Codigo+"'>"+item.PERSC_Nombre+"</option>");
					});
			});
		}
		function get_obra(codigo) {
			//alert(codigo);
			$.post("<?php echo base_url(); ?>index.php/compras/pedido/obra", {
							"codigoempre" : codigo
				}, function(data) {
					//alert("hola"+data);
					var c = JSON.parse(data);
					$.each(c,function(i,item){
						$('#obra').append("<option value='"+item.PROYP_Codigo+"'>"+item.proyecto+"</option>");
					});
			});
		}		
						
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
					   <table id="customised">
					   
					   <tr>
							<td>
								Serie:
							</td>
							<td>
								<input class ="f1"name="serie"type="text" id="numero_documento" size="15" maxlength="4" value="<?php echo $serie;?>" onkeypress="return numbersonly('numero_documento',event);">
							</td>
							<td >
								Número: <input class="f1" name="numero"  type="text" id="numero_documento" size="15" maxlength="8" value="<?php echo $numero;?>" onkeypress="return numbersonly('numero_documento',event);">
							</td>
							<td>
								Fecha: <?php echo $fechai?>
                                        <img src="<?php echo base_url();?>images/calendario.png" name="Calendario1" id="Calendario1" width="16" height="16" border="0" onMouseOver="this.style.cursor='pointer'" title="Calendario"/>
                                        <script type="text/javascript">
                                            Calendar.setup({
                                                inputField     :    "fechai",      // id del campo de texto
                                                ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
                                                button         :    "Calendario1"   // el id del botón que lanzará el calendario
                                            });
                                        </script>
							</td>
							<td>
								OBRA:	<?php echo $cboObra;?>	
							</td>
					   </tr>
					    <tr>
							<td>
								Cliente *:
							</td>
							<td colspan="2">
								
								 <input type="text" name="cliente" id="cliente" size="5" hidden value=""/>
                        <input type="text" name="ruc_cliente" class="cajaGeneral" id="ruc_cliente" size="10"
                               maxlength="11" placeholder="Ruc"  onkeypress="return numbersonly(this,event,'.');" value="" />
                        <input type="text" name="nombre_cliente" class="cajaGeneral cajaSoloLectura" id="nombre_cliente"
                               size="40" maxlength="50" placeholder="Nombre cliente" value="" />
                        

                         <a href="<?php echo base_url(); ?>index.php/ventas/cliente_ventana_busqueda/" id="linkSelecCliente"></a>
                    </td>
							<td>
								Contacto:	<?php echo $cboContacto;?>
							</td>
							<td>
								I.G.V:	<input type="text" name="igv" id="igv" size="5" value="<?php echo $igv; ?>" readonly disabled />%
							</td>
					   </tr>
					   <tr>
							<td>
								Art&iacute;culo;
							</td>
							<td colspan="2">
								
								<input name="producto" type="hidden" class="cajaGeneral" id="producto"/>
								<input name="buscar_producto" type="text" class="cajaGeneral" id="buscar_producto" size="10" placeholder="Producto" title="Ingrese parte del nombre o el nro. de serie del producto, luego presione ENTER."/>&nbsp;
								<input name="codproducto" type="hidden" class="cajaGeneral" id="codproducto" size="10" maxlength="20" onblur="obtener_producto();"/>
								<input name="nombre_producto" type="text" class="cajaGeneral cajaSoloLectura"id="nombre_producto" size="39" readonly="readonly" placeholder="Descripcion producto" />
								<input name="stock" type="hidden" id="stock"/>
								<input name="costo" type="hidden" id="costo"/>
								<input name="flagGenInd" type="hidden" id="flagGenInd"/>
								<input name="almacenProducto" type="hidden" id="almacenProducto"/>
							</td>
							<td colspan="1">
								Cantidad
								<input NAME="cantidad" type="text" class="cajaGeneral"  id="cantidad" value="" size="3" maxlength="5" onkeypress="return numbersonly(this,event,'.');" />
								<select name="unidad_medida" id="unidad_medida" class="comboMedio" onchange="obtener_precio_producto();"><option value="">::Seleccione::</option></select>
							</td>
							<td colspan="1">
								PU 
								<?php if($tipo_docu!='B' && $contiene_igv==true) echo ' (Con IGV)'?>
								&nbsp;&nbsp;<input NAME="precio" type="text" class="cajaGeneral" id="precio" size="5" maxlength="10" onkeypress="return numbersonly(this,event,'.');" />
							    <a href="javascript:;" onClick="agregar_producto_presupuesto();"><img src="<?php echo base_url();?>images/botonagregar.jpg" border="1" align="absbottom"></a>
								
							</td>
					   </tr>
					   </table>			
                        </div>
				 </div>	
					<div id="frmBusqueda" style="height:250px; overflow: auto">
							<table class="fuente8" width="100%" cellspacing="0" cellpadding="3" border="1" ID="Table1">
						<tr class="cabeceraTabla">
							<td width="3%"><div align="center">&nbsp;</div></td>
                            <td width="4%"><div align="center">ITEM</div></td>
                            <td width="10%"><div align="center">C&Oacute;DIGO</div></td>
                            <td><div align="center">DESCRIPCI&Oacute;N</div></td>
                            <td width="10%"><div align="center">CANTIDAD</div></td>
                            <td width="6%"><div align="center">PU C/IGV</div></td>
                            <td width="6%"><div align="center">PU S/IGV</div></td>
                            <td width="6%"><div align="center">PRECIO</div></td>
                            <td width="6%"><div align="center">I.G.V.</div></td>
                            <td width="6%"><div align="center">IMPORTE</div></td>
						</tr>
							</table>
						<div>
							<table id="tblDetalleCotizacion" class="fuente8" width="100%" border="0">
								<?php
								if(count($array_detalle) > 0){
									foreach($array_detalle as $indice=>$value){
										?>
										 <tr class="<?php echo $clase; ?>">
                                        <td width="3%"><div align="center"><font color="red"><strong><a href="javascript:;" onclick="eliminar_producto_presupuesto(<?php echo $indice; ?>);"><span style="border:1px solid red;background: #ffffff;">&nbsp;X&nbsp;</span></a></strong></font></div></td>
                                        <td width="4%"><div align="center"><?php echo $indice + 1; ?></div></td>
                                        <td width="10%"><div align="center"><?php echo $codigo_interno; ?></div></td>
                                        <td><div align="left"><input type="text" class="cajaGeneral" style="width:395px;" maxlength="250" name="proddescri[<?php echo $indice; ?>]" id="proddescri[<?php echo $indice; ?>]" value="<?php echo $nombre_producto; ?>" /></div></td>
                                        <?php //if ($tipo_docu != 'B') { ?>
                                            <td width="10%"><div align="left"><input type="text" size="1" maxlength="10" class="cajaGeneral" name="prodcantidad[<?php echo $indice; ?>]" id="prodcantidad[<?php echo $indice; ?>]" value="<?php echo $prodcantidad; ?>" onblur="calcula_importe(<?php echo $indice; ?>);" onkeypress="return numbersonly(this,event,'.');" /><?php echo $nombre_unidad; ?></div></td>
                                            <td width="6%"><div align="center"><input type="text" size="5" maxlength="10" class="cajaGeneral" name="prodpu_conigv[<?php echo $indice; ?>]" id="prodpu_conigv[<?php echo $indice; ?>]" value="<?php echo $prodpu_conigv; ?>" onblur="modifica_pu_conigv(<?php echo $indice; ?>);" onkeypress="return numbersonly(this,event,'.');" /></div></td>
                                            <td width="6%"><div align="center"><input type="text" size="5" maxlength="10" class="cajaGeneral" name="prodpu[<?php echo $indice; ?>]" id="prodpu[<?php echo $indice; ?>]" value="<?php echo $prodpu; ?>" onblur="modifica_pu(<?php echo $indice; ?>);" onkeypress="return numbersonly(this,event,'.');" />
                                                    <td width="6%"><div align="center"><input type="text" size="5" maxlength="10" class="cajaGeneral cajaSoloLectura" name="prodprecio[<?php echo $indice; ?>]" id="prodprecio[<?php echo $indice; ?>]" value="<?php echo $prodsubtotal; ?>" readonly="readonly" />
                                                        </div></td>
                                               <!-- <?php //} else { ?>
                                                    <td width="6%"><div align="left"><input type="text" size="1" maxlength="10" class="cajaGeneral" name="prodcantidad[<?php echo $indice; ?>]" id="prodcantidad[<?php echo $indice; ?>]" value="<?php echo $prodcantidad; ?>" onblur="calcula_importe_conigv(<?php echo $indice; ?>);" onkeypress="return numbersonly(this,event,'.');" /><?php echo $nombre_unidad; ?></div></td>
                                                    <td width="6%"><div align="center"><input type="text" size="5" maxlength="10" class="cajaGeneral" name="prodpu_conigv[<?php echo $indice; ?>]" id="prodpu_conigv[<?php echo $indice; ?>]" value="<?php echo $prodpu_conigv; ?>" onblur="calcula_importe_conigv(<?php echo $indice; ?>);" onkeypress="return numbersonly(this,event,'.');" /></div></td>
                                                    <td width="6%"><div align="center"><input type="text" size="5" maxlength="10" class="cajaGeneral cajaSoloLectura" name="prodprecio_conigv[<?php echo $indice; ?>]" id="prodprecio_conigv[<?php echo $indice; ?>]" value="<?php echo $prodsubtotal_conigv; ?>" readonly="readonly" /></div></td>
                                                <?php //} ?>    -->
                                                <?php //if ($tipo_docu != 'B') { ?>
                                                    <td width="6%">
                                                        <div align="center"><input type="text" size="5" maxlength="10" class="cajaGeneral cajaSoloLectura" name="prodigv[<?php echo $indice; ?>]" id="prodigv[<?php echo $indice; ?>]" readonly="readonly" value="<?php echo $prodigv; ?>" /></div>
                                                    </td>
                                                <?php //} ?>
                                                <td width="6%">
                                                    <div align="center">
                                                        <input type="hidden" name="detaccion[<?php echo $indice; ?>]" id="detaccion[<?php echo $indice; ?>]" value="m">
                                                        <input type="hidden" name="prodigv100[<?php echo $indice; ?>]" id="prodigv100[<?php echo $indice; ?>]" value="<?php echo $igv; ?>" />
                                                        <input type="hidden" name="detacodi[<?php echo $indice; ?>]" id="detacodi[<?php echo $indice; ?>]" value="<?php echo $detacodi; ?>" />
                                                        <input type="hidden" name="flagBS[<?php echo $indice; ?>]" id="flagBS[<?php echo $indice; ?>]" value="<?php echo $flagBS; ?>" />
                                                        <input type="hidden" name="prodcodigo[<?php echo $indice; ?>]" id="prodcodigo[<?php echo $indice; ?>]" value="<?php echo $prodproducto; ?>" />
                                                        <input type="hidden"  name="produnidad[<?php echo $indice; ?>]" id="produnidad[<?php echo $indice; ?>]" value="<?php echo $unidad_medida; ?>" />
                                                        <input type="hidden" name="proddescuento100[<?php echo $indice; ?>]" id="proddescuento100[<?php echo $indice; ?>]" value="<?php echo $descuento; ?>" />
                                                        <?php //if ($tipo_docu != 'B') { ?>
                                                            <input type="hidden" name="proddescuento[<?php echo $indice; ?>]" id="proddescuento[<?php echo $indice; ?>]" value="<?php echo $proddescuento; ?>" onblur="calcula_importe2(<?php echo $indice; ?>);" />
                                                        <?php //} else { ?>
                                                          <!--  <input type="hidden" name="proddescuento_conigv[<?php echo $indice; ?>]" id="proddescuento_conigv[<?php echo $indice; ?>]" value="<?php echo $proddescuento_conigv; ?>" onblur="calcula_importe2_conigv(<?php echo $indice; ?>);" />-->
                                                        <?php //} ?>
                                                            <input type="text" size="5" maxlength="10" class="cajaGeneral cajaSoloLectura" name="prodimporte[<?php echo $indice; ?>]" id="prodimporte[<?php echo $indice; ?>]" readonly="readonly" value="<?php echo number_format($prodtotal,2); ?>" />
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
	 <style>
					   #customised{
						   font-size: 15px;
						   text-align:left;
						   margin-top:-40px;
					   }
					   #customised td{
						   padding:8px 5px;
					   }
					    #customised input{
						   height:15px;
					   }
					   #customised select{
						   width:150px;
						   height:20px;
					   }
					   .f1{
						  width:70px; 
					   }
					   </style>
</html>