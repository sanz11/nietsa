<html>
	<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">	
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
			                        url: "<?php echo base_url(); ?>index.php/almacen/producto/autocomplete/" + $("#flagBS").val() + "/" + $("#compania").val()+"/"+$("#almacen").val(),
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
			                	isEncuentra=verificarProductoDetalle(ui.item.codigo,ui.item.almacenProducto);
			                    if(!isEncuentra){
				                    $("#buscar_producto").val(ui.item.codinterno);
				                    $("#producto").val(ui.item.codigo);
				                    $("#codproducto").val(ui.item.codinterno);
				                    $("#costo").val(ui.item.pcosto);
				                    $("#stock").val(ui.item.stock);
				                    $("#flagGenInd").val(ui.item.flagGenInd);
				                    $("#almacenProducto").val(ui.item.almacenProducto);
				                    $("#cantidad").focus();
				                    listar_unidad_medida_producto(ui.item.codigo);
			                        //verificar_Inventariado_producto();
			                    }else{
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
			                    }
			                },
			                minLength: 3
			            });
			            
            	  $("#ruc_cliente").autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: "<?php echo base_url(); ?>index.php/ventas/cliente/autocomplete_ruc/",
                        type: "POST",
                        data: {
                            term: $("#ruc_cliente").val()
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

                    codigoem=ui.item.codigoEmpresa;
                    get_contacto(codigoem);
                    
                    codigo=ui.item.codigo;
                    get_obra(codigo);
                },
                minLength: 2
            });

            /* Descativado hasta corregir vico 22082013 - quien es vico? (fixed) - pregunto lo mismo que es vicio(ABAc). */

          //  AUTOCOMENTADO EN CLIENTE BUSCAR
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
                    $("#buscar_producto").focus();

                    codigoem=ui.item.codigoEmpresa;
                   get_contacto(codigoem);
                    
                    codigo=ui.item.codigo;
                    get_obra(codigo);
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
					$('#contacto').html('');
					$('#contacto').append("<option value='0'>::Seleccione::</option>");
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
					$('#obra').html('');
					$('#obra').append("<option value='0'>::Seleccione::</option>");
					$.each(c,function(i,item){
						$('#obra').append("<option value='"+item.PROYP_Codigo+"'>"+item.proyecto+"</option>");
					});
			});
		}		


		function buscar_contacto(){
			obra = $("#obra").val();
			 var url= "<?php echo base_url(); ?>index.php/compras/pedido/obtenercontacto_obra";
			
			 $.ajax({url: url,type: "POST",
				 data:{
					 codigo:obra
					 },  
				 dataType: "json", 
				 success: function(data){
						$("#contacto").html("");
					 fila = "";
				 $.each(data, function (i, item) {
					
			         fila+= "<option value='"+item.codigo+"' >" + item.nombre + "</option>";
			         			            
				 });
				 $("#contacto").html(fila);
				  
			 }	
			        
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
					   <table id="customised" class="fuente8">
					   
					   <tr>
							 <td >N&uacute;mero*</td>
  				<td>
                    <?php
                     echo '<input type="text" name="serie" id="serie" value="'.$serie.'" class="cajaGeneral cajaSoloLectura" size="3" maxlength="3" placeholder="Serie" /> ';
                    echo '<input type="text" name="numero" id="numero" value="'.$numero.'" class="cajaGeneral cajaSoloLectura" size="10" maxlength="6" placeholder="Numero"  /> ';
                                echo '<a href="javascript:;" id="linkVerSerieNum"' . ($codigo != '' ? 'style="display:none"' : '') . '><p style="display:none">' . $serie_suger . '-' . $numero_suger . '</p><image src="' . base_url() . 'images/flecha.png" border="0" alt="Serie y número sugerido" title="Serie y número sugerido" /></a>';
                      ?>  
							<td >
								Fecha: <?php echo $fechai?>
                                        <img src="<?php echo base_url();?>images/calendario.png" name="Calendario1" id="Calendario1" width="16" height="16" border="0" onMouseOver="this.style.cursor='pointer'" title="Calendario"/>
                                        <script type="text/javascript">
                                            Calendar.setup({
                                                inputField     :    "fechai",      // id del campo de texto
                                                ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
                                                button         :    "Calendario1"   // el id del bot�0‡1�0…6n que lanzar�0‡1�0„3 el calendario
                                            });
                                        </script>
							</td>
							<td>
								Moneda:	
								<select id="moneda" name="moneda" >
									<?php echo $combomoneda;?>	
								</select>
							</td>
							<td>
								OBRA:	
								
								<?php echo $cboObra;?>	
							</td>
					   </tr>
					    <tr>
							<td>
								Cliente *:
							</td>
							<td colspan="2">
								
								 <input type="text" name="cliente" id="cliente" size="5" hidden value="<?php echo $cliente; ?>"/>
                        <input type="text" name="ruc_cliente" class="cajaGeneral" id="ruc_cliente" size="10"
                               maxlength="11" placeholder="Ruc"  onkeypress="return numbersonly(this,event,'.');" value="<?php echo $ruc_cliente; ?>" />
                        <input type="text" name="nombre_cliente" class="cajaGeneral cajaSoloLectura" id="nombre_cliente"
                               size="40" maxlength="50" placeholder="Nombre cliente" value="<?php echo $nombre_cliente; ?>"  />
                        

                         <a href="<?php echo base_url(); ?>index.php/ventas/cliente_ventana_busqueda/" id="linkSelecCliente"></a>
                    </td>
							<td>
								Contacto:	
								<?php echo $cboContacto;?>
							</td>
<!-- 							<td><select id="contacto2">Seleccionar</select></td> -->
							<td>
								I.G.V:	<input style="width:30px" type="text" name="igv" id="igv" size="5" value="<?php echo $igv; ?>" readonly  />%
								Descuento:<input type="text" name="descuento" id="descuento" size="5" value="<?php echo $descuento; ?>" onblur="modifica_descuento_total();"/>%
							</td>
					   </tr>
					   
					   <tr>
							<td >
								 <select name="flagBS" id="flagBS" style="width:68px;" class="comboMedio"
                                onchange="limpiar_campos_producto()">
									<option value="B" selected="selected" title="Producto">P</option>
									<option value="S" title="Servicio">S</option>
								</select>
							</td>
							<td colspan="2">
								
								 <input name="producto" type="hidden" class="cajaGeneral" id="producto"/>
								<input name="buscar_producto" type="text" class="cajaGeneral" id="buscar_producto" size="10"
                               placeholder="producto"/>&nbsp;
								<input name="codproducto" type="hidden" class="cajaGeneral" id="codproducto" size="10"
                               maxlength="20" onblur="obtener_producto();"/>
								<input NAME="nombre_producto" type="text" class="cajaGeneral cajaSoloLectura"
                               placeholder="Descripcion producto"
                               id="nombre_producto" size="40" readonly="readonly"/>
								<input name="stock" type="hidden" id="stock"/>
								<input name="costo" type="hidden" id="costo"/>
								<input name="flagGenInd" type="hidden" id="flagGenInd"/>
								<input name="almacenProducto" type="hidden" id="almacenProducto"/>
                        </td>
							<td colspan="1">
								Cantidad
								 <input NAME="cantidad" type="text" class="cajaGeneral" id="cantidad" value="" size="3"
                               maxlength="5" onKeyPress="return numbersonly(this,event,'.');"/>
								<select name="unidad_medida" id="unidad_medida" onchange="listar_precios_x_producto_unidad();"
                                class="comboMedio"  >
								<option value="0">::Seleccione::</option>
								</select>
						</td>
							<td colspan="1">
							 <select name="precioProducto" id="precioProducto" class="comboPequeno"
                                onchange="mostrar_precio();" style="width:84px;">
                            <option value="0">::Seleccion::</option>
							</select>
								PU 
								 <input NAME="precio" type="text" class="cajaGeneral" id="precio" size="5" maxlength="10"
                               onkeypress="return numbersonly(this,event,'.');" title="Precio con IGV"/>
                    
								<a href="javascript:;" onClick="agregar_producto_pedido();"><img     src="<?php echo base_url(); ?>images/botonagregar.jpg" class="imgBoton" align="absbottom"></a>
							</td>
					   </tr>
					   </table>			
                       </div>
				   </div>	
				  
				  <div id="frmBusqueda" style="height:250px; overflow: auto">
            	  	<table class="fuente8" width="100%" cellspacing="0" cellpadding="3" border="1" ID="Table1">
                <tr class="cabeceraTabla">
                    <td width="3%">
                        <div align="center">&nbsp;</div>
                    </td>
                    <td width="4%">
                        <div align="center">ITEM</div>
                    </td>
                    <td width="10%">
                        <div align="center">C&Oacute;DIGO</div>
                    </td>
                    <td>
                        <div align="center">DESCRIPCI&Oacute;N</div>
                    </td>
                    <td width="10%">
                        <div align="center">CANTIDAD</div>
                    </td>
                    <td width="6%">
                        <div align="center">PU C/IGV</div>
                    </td>
                    <td width="6%">
                        <div align="center">PU S/IGV</div>
                    </td>
                    <td width="6%">
                        <div align="center">PRECIO</div>
                    </td>
                    <td width="6%">
                        <div align="center">I.G.V.</div>
                    </td>
                    <td width="6%">
                        <div align="center">IMPORTE</div>
                    </td>
                </tr>
            </table>
		          	<div>
                    	<table id="tblDetallePedido" class="fuente8" width="100%" border="0">
                    <?php
                    if (count($detalle_pedido) > 0) {
                        foreach ($detalle_pedido as $indice => $value) {
                        	$codigousuario = $value->PROD_CodigoUsuario;
                        	$nombre_producto = $value->PROD_Nombre;
                        	$cantidad = $value->PEDIDETC_Cantidad;
                        	$pu_CIGV =  $value->PEDIDETC_PCIGV;
                        	$pu_SIGV =$value->PEDIDETC_PSIGV;
                        	$PRECIO = $value->PEDIDETC_Precio;
                        	$detacodi= $value->PEDIDETP_Codigo;
                        	$proddescuento = $value->PEDIDETC_Descuento;
                        	$IGV =$value->PEDIDETC_IGV;
                        	$IMPORTE = $value->PEDIDETC_Importe;
                        	
//                             $detacodi = $value->OCOMDEP_Codigo;
                            
                            $prodproducto = $value->PROD_Codigo;
                            $nombre_unidad = $value->UNDMED_Descripcion;

                            if (($indice + 1) % 2 == 0) {
                                $clase = "itemParTabla";
                            } else {
                                $clase = "itemImparTabla";
                            }
                            ?>
                            <tr class="<?php echo $clase; ?>">
                                <td width="3%">
                                    <div align="center">
                                    <font color="red">
	                                    <strong>
		                                    <a href="javascript:;" onClick="eliminar_producto_pedido(<?php echo $indice; ?>);">
		                                    	<span style="border:1px solid red;background: #ffffff;">&nbsp;X&nbsp;</span>
		                                    </a>
	                                    </strong>
                                    </font>
                                    </div>
                                </td>
                                <td width="4%">
                                    <div align="center"><?php echo $indice + 1; ?></div>
                                </td>
                                <td width="10%">
                                    <div align="center">
                                        <?php echo $codigousuario; ?>
                                        <input type="hidden" class="cajaMinima"
                                               name="prodcodigo[<?php echo $indice; ?>]"
                                               id="prodcodigo[<?php echo $indice; ?>]"
                                               value="<?php echo $prodproducto; ?>"/>
                                       
                                    </div>
                                </td>
                                <td>
                                    <div align="left">
                                        <input type="text" class="cajaGeneral" style="width:395px;" maxlength="250"
                                               name="proddescri[<?php echo $indice; ?>]"
                                               id="proddescri[<?php echo $indice; ?>]"
                                               value="<?php echo $nombre_producto; ?>"/>
                                    </div>
                                </td>
                                <td width="10%">
                                    <div align="left">
                                        <input type="text" class="cajaGeneral" size="1" maxlength="5"
                                               name="prodcantidad[<?php echo $indice; ?>]"
                                               id="prodcantidad[<?php echo $indice; ?>]"
                                               value="<?php echo $cantidad; ?>"
                                               onblur="calcula_importe('<?php echo $indice; ?>');modifica_pu_conigv('<?php echo $indice; ?>');"
                                               onKeyPress="return numbersonly(this,event,'.');"/> <?php echo $nombre_unidad; ?>
                                    </div>
                                </td>
                                <td width="6%">
                                    <div align="center"><input type="text" size="5" maxlength="10" class="cajaGeneral"
                                                               name="prodpu_conigv[<?php echo $indice; ?>]"
                                                               id="prodpu_conigv[<?php echo $indice; ?>]"
                                                               value="<?php echo $pu_CIGV; ?>"
                                                               onblur="modifica_pu_conigv(<?php echo $indice; ?>);"
                                                               onkeypress="return numbersonly(this,event,'.');"/></div>
                                </td>
                                <td width="6%">
                                    <div align="center"><input type="text" size="5" maxlength="10" class="cajaGeneral"
                                                               name="prodpu[<?php echo $indice; ?>]"
                                                               id="prodpu[<?php echo $indice; ?>]"
                                                               value="<?php echo $pu_SIGV; ?>"
                                                               onblur="modifica_pu(<?php echo $indice; ?>);"
                                                               onkeypress="return numbersonly(this,event,'.');"/>
                                                               
                                        <td width="6%">
                                            <div align="center"><input type="text" size="5" maxlength="10"
                                                                       class="cajaGeneral cajaSoloLectura"
                                                                       name="prodprecio[<?php echo $indice; ?>]"
                                                                       id="prodprecio[<?php echo $indice; ?>]"
                                                                       value="<?php echo $PRECIO; ?>"
                                                                       readonly="readonly"/></div>
                                        </td>
                                        <td width="6%">
                                            <div align="center"><input type="text" size="5" maxlength="10"
                                                                       class="cajaGeneral cajaSoloLectura"
                                                                       name="prodigv[<?php echo $indice; ?>]"
                                                                       id="prodigv[<?php echo $indice; ?>]"
                                                                       readonly="readonly"
                                                                       value="<?php echo $IGV; ?>"/></div>
                                        </td>
                                        
                                        <td width="6%">
                                            <div align="center">

                                                <input type="hidden" name="detaccion[<?php echo $indice; ?>]"
                                                       id="detaccion[<?php echo $indice; ?>]" value="m"/>
                                                       
                                                <input type="hidden" name="detacodi[<?php echo $indice; ?>]" id="detacodi[<?php echo $indice; ?>]" value="<?php echo $detacodi; ?>" />
                                                        
                                                <input type="hidden" name="prodigv100[<?php echo $indice; ?>]"
                                                       id="prodigv100[<?php echo $indice; ?>]"
                                                       value="<?php echo $igv; ?>"/>
                                                
                                                <input type="hidden" name="prodstock[<?php echo $indice; ?>]"
                                                       id="prodstock[<?php echo $indice; ?>]" value=""/>
                                               
                                                <input type="hidden" name="proddescuento100[<?php echo $indice; ?>]"
                                                       id="proddescuento100[<?php echo $indice; ?>]"
                                                       value="<?php echo $descuento; ?>"/>
                                                <input type="hidden" name="proddescuento[<?php echo $indice; ?>]" id="proddescuento[<?php echo $indice; ?>]" value="<?php echo $proddescuento; ?>" onblur="calcula_importe2(<?php echo $indice; ?>);" />
                                             
                                                <input type="text" size="5" maxlength="10"
                                                       class="cajaGeneral cajaSoloLectura"
                                                       name="prodimporte[<?php echo $indice; ?>]"
                                                       id="prodimporte[<?php echo $indice; ?>]" readonly="readonly"
                                                       value="<?php echo $IMPORTE; ?>"/>
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
        		
        			<br/>
        		<br>
        			  <div id="zonaContenid">
		  <div align="center">
				<div id="frmBusqueda">
				
				<div id="frmBusqueda3">
            		<table border="0" align="center" cellpadding='3' cellspacing='0' class="fuente8" id="tablecustom">
                		
                            	<tr>
                                	<td style="text-align:right;">Importe Bruto</td>
                                	<td width="10%" >
                                    		<div align="right"><input class="cajaTotales" name="importebruto" type="text"
                                                              id="importebruto" size="12" 
                                                              readonly="readonly"
                                                              value="<?php echo round($importebruto, 2); ?>"/></div>
                                	</td>
                            	
                                	<td class="busqueda" style="text-align:right">Descuento</td>
                                	<td >
                                    	<div ><input class="cajaTotales" name="descuentotal" type="text"
                                                              id="descuentotal" size="12" 
                                                              readonly="readonly"
                                                              value="<?php echo round($descuentotal, 2); ?>"/></div>
                                	</td>
                               <td class="busqueda" style="text-align:right;">Valor de Venta</td>
                                <td >
                                    <div><input class="cajaTotales" name="vventa" type="text"
                                                              id="vventa" size="12"  readonly="readonly"
                                                              value="<?php echo round($vventa, 2); ?>"/></div>
                                </td>
                            	
                                <td class="busqueda" style="text-align:right;">IGV</td>
                                <td >
                                    <div><input class="cajaTotales" name="igvtotal" type="text"
                                                              id="igvtotal" size="12"  readonly="readonly"
                                                              value="<?php echo round($igvtotal, 2); ?>"/></div>
                                </td>
                           
                                <td class="busqueda" style="text-align:right;">Precio Total</td>
                                <td >
                                    <div><input class="cajaTotales" name="preciototal" type="text"
                                                              id="preciototal" size="12" 
                                                              readonly="readonly"
                                                              value="<?php echo round($preciototal, 2); ?>"/></div>
                                </td>
                            </tr>
            </table>

        		  </div>
        			<br/>

				<div style="margin:10px 0 10px 0; clear:both">
            		<img id="loading" src="<?php echo base_url(); ?>images/loading.gif" style="visibility: hidden"/>
            			<a href="javascript:;" id="imgGuardarPedido"><img src="<?php echo base_url(); ?>images/botonaceptar.jpg"
                                                           width="85" height="22" class="imgBoton"></a>
           			 <a href="javascript:;" id="limpiarnewPedido"><img src="<?php echo base_url(); ?>images/botonlimpiar.jpg"
                                                            width="69" height="22" class="imgBoton"></a>
            		<a href="javascript:;" id="imgCancelarPedido"><img src="<?php echo base_url(); ?>images/botoncancelar.jpg"
                                                             width="85" height="22" class="imgBoton"></a>
       		 	</div>
		  	</div>
		  	</div>
		  		</div>
		  		<?php echo $oculto ?>

			</form>
				</div>
				</div>
				
		  
		  </div>
		  
	
	</div>
	
	
	<style type="text/css">
#popup {
    left: 0;
    position: absolute;
    top: 0;
    width: 100%;
    z-index: 1001;
}

.content-popup {
    margin:0px auto;
    margin-top:150px;
    position:relative;
    padding:10px;
    width:300px;
    min-height:150px;
    border-radius:4px;
    background-color:#FFFFFF;
    box-shadow: 0 2px 5px #666666;
}

.content-popup h2 {
    color:#48484B;
    border-bottom: 1px solid #48484B;
    margin-top: 0;
    padding-bottom: 4px;
   
}

.popup-overlay {
    left: 0;
    position: absolute;
    top: 0;
    width: 100%;
    z-index: 999;
    display:none;
    background-color: #777777;
    cursor: pointer;
    opacity: 0.7;
}

.close {
    position: absolute;
    right: 15px;
}
#btnInventario{
    size: 20px;
width: 200px;
height: 50px;
    border-radius: 33px 33px 33px 33px;
-moz-border-radius: 33px 33px 33px 33px;
-webkit-border-radius: 33px 33px 33px 33px;
border: 0px solid #000000;
background-color:rgba(199, 255, 206, 1);

}

					   #customised{
						   
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
					   #zonaContenid{
					   border-top: 15px solid white;
					   }
					   #tablecustom td{
					   width:10% !important;
					   }
					   
</style>
</html>