
<html>
<head>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-ui-1.8.17.custom.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/funciones.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/ventas/comprobante.js"></script>
    <script src="<?php echo base_url(); ?>js/jquery.columns.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>js/fancybox/jquery.fancybox-1.3.4.css"        media="screen"/>
    <script type="text/javascript">
        $(document).ready(function () {
			

            base_url = $("#base_url").val();
            tipo_oper = $("#tipo_oper").val();
            almacen = $("#cboCompania").val();

            $("a#linkVerCliente, a#linkSelecCliente").fancybox({
                'width': 800,
                'height': 550,
                'autoScale': false,
                'transitionIn': 'none',
                'transitionOut': 'none',
                'showCloseButton': true,
                'modal': false,
                'type': 'iframe'

            });

            $(" #linkSelecProducto").fancybox({
                'width': 800,
                'height': 500,
                'autoScale': false,
                'transitionIn': 'none',
                'transitionOut': 'none',
                'showCloseButton': true,
                'modal': false,
                'type': 'iframe'

            });

            $("a#linkVerProducto").fancybox({
                'width': 800,
                'height': 650,
                'autoScale': false,
                'transitionIn': 'none',
                'transitionOut': 'none',
                'showCloseButton': true,
                'modal': true,
                'type': 'iframe'
            });

    
           

        });

//AUTOCOMPLETO DE PRODUCTOS
 $(function () {
            $("#buscar_producto").autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: "<?php echo base_url(); ?>index.php/almacen/producto/autocomplete/" + $("#flagBS").val() + "/1/"+$("#almacen").val(),
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
                minLength: 1
            });


//****** nuevo para ruc
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
                    $("#buscar_producto").focus();
                },
                minLength: 2
            });


 


        });

        /*--------------------------------------------------*/

        function seleccionar_cliente(codigo, ruc, razon_social) {
            $("#cliente").val(codigo);
            $("#buscar_cliente").val(ruc);
            $("#nombre_cliente").val(razon_social);
        }
        
     

        function seleccionar_producto(producto, cod_interno, familia, stock, costo, flagGenInd,codigoAlmacenProducto) {
        	/**si el producto tiene almacen : es que no esta inventariado en ese almacen , se le asigna el almacen general de cabecera**/
            if(codigoAlmacenProducto==0){
            	codigoAlmacenProducto=$("#almacen").val();
             }
            /**fin de asignacion**/
        	/**verificamos si se e3ncuentra en la lista**/
        	isEncuentra=verificarProductoDetalle(producto,codigoAlmacenProducto);
            if(!isEncuentra){
	            $("#codproducto").val(cod_interno);
	            $("#producto").val(producto);
	            $("#cantidad").focus();
	            $("#stock").val(stock);
	            $("#costo").val(costo);
	            $("#flagGenInd").val(flagGenInd);
	            $("#almacenProducto").val(codigoAlmacenProducto);
	            listar_unidad_medida_producto(producto);
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
            	$("#buscar_producto").focus();
            	alert("El producto ya se encuentra ingresado en la lista de detalles.");
          }

        }

   

    </script>

</head>
<body>
<form id="grabarcomprobantealterno" method="post" >
    <div id="zonaContenido" align="center">
        <div id="frmBusqueda">
            <table class="fuente8" width="100%" cellspacing="5" cellpadding="5" >
                <tr>
                    <td width="8%">N&uacute;mero*</td>
                    <td width="60%" valign="middle">                  
                    
                        <input class="cajaGeneral" name="serie" type="text" id="serie" size="3" maxlength="3" />&nbsp;
                        <input class="cajaGeneral" name="numero" type="text" id="numero" size="6" maxlength="6" />
                        
                        <label style="margin-left:20px;">IGV</label>
                        <input NAME="igv" type="text" class="cajaGeneral cajaSoloLectura" id="igv" size="2" maxlength="2" value="<?php echo $igv; ?>"
                               onkeypress="return numbersonly(this,event,'.');" onblur="modifica_igv_total();" readonly="readonly"/> %
                    </td>
                </tr>
                <tr>
                  
                        <td>Cliente*</td>
                        <td valign="middle">
                          
                                <input type="hidden" name="cliente" id="cliente" size="5" placeholder="Codigo del Cliente" value="<?php echo $cliente ?>"/>
                                <input placeholder="ruc" name="buscar_cliente" type="text" class="cajaGeneral"
                                  id="buscar_cliente" size="10" value="<?php echo $ruc_cliente; ?>" />&nbsp;
                                <input type="hidden" name="ruc_cliente" class="cajaGeneral" id="ruc_cliente" size="10"
                                       maxlength="11" onblur="obtener_cliente();" value="<?php echo $ruc_cliente; ?>"
                                       onkeypress="return numbersonly(this,event,'.');"/>
                                <input placeholder="razon social" type="text" name="nombre_cliente" class="cajaGeneral"
                                       id="nombre_cliente" size="37" maxlength="50"
                                       value="<?php echo $nombre_cliente; ?>"/>
                            <a href="<?php echo base_url(); ?>index.php/ventas/cliente/ventana_selecciona_cliente/" id="linkSelecCliente"></a>
                        </td>

                    <td valign="middle">Moneda*</td>
                    <td valign="middle" id="idTdMoneda">
                        <select name="moneda" id="moneda" class="comboPequeno"
                                style="width:150px;"><?php echo $cboMoneda; ?>
                       	</select>
                    </td>
                  
                </tr>
                <tr>
                    <td>TDC</td>
                    <td>
				       <input NAME="tdc" type="text" class="cajaGeneral cajaSoloLectura" id="tdc" size="3"
				         value="<?php echo $tdc; ?>" onkeypress="return numbersonly(this,event,'.');"
				                               readonly="readonly"/>
                  
					Vendedor
					<select  class="cajaGeneral" id="cmbVendedor" name="cmbVendedor">
					    <?=$cmbVendedor?>
					</select>
					
                    </td>
                
                <td>Almacen*</td>
                    <td><?php echo $cboAlmacen; ?></td>
                </tr>
                
            </table>
        </div>
        
        <div id="frmBusqueda" >
            <table class="fuente8" width="100%" cellspacing='0' cellpadding='3' border='0'>
                <tr>
                    <td width="8%">
                        <select name="flagBS" id="flagBS" style="width:68px;" ass="comboMedio"
                                onchange="limpiar_campos_producto();verificarServicio(this);">
                            <option value="B" selected="selected" title="Producto">P</option>
                            <option value="S" title="Servicio">S</option>
                        </select>
                    </td>
                    <td width="37%">
                        <input name="producto" type="hidden" class="cajaGeneral" id="producto" placeholder="CODIGO DEL PRODUCTO"/>
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
                        <a href="<?php echo base_url(); ?>index.php/almacen/producto/ventana_selecciona_producto/" id="linkSelecProducto"></a>
                    </td>
                    
                    <td width="6%">Cantidad</td>
                    <td width="24%">
                        <input name="cantidad" type="text" class="cajaGeneral" id="cantidad" size="3" maxlength="10"
                               onkeypress="return numbersonly(this,event,'.');"/>
                        <select name="unidad_medida" id="unidad_medida"
                                class="comboMedio" <?php if ($tipo_oper == 'V') echo 'onchange="listar_precios_x_producto_unidad();"'; ?>>
                            <option value="0">::Seleccione::</option>
                        </select>
                    </td>
                    <td width="16%">
					 <select  name="precioProducto" id="precioProducto" class="comboPequeno" onchange="mostrar_precio();"  style="width:84px;">
					      <option value="0">::Seleccion::</option>
					 </select>
                        <input name="precio" type="text" class="cajaGeneral" id="precio" size="5" maxlength="10" onkeypress="return numbersonly(this,event,'.');"/>
                    </td>
                    <td width="10%">
                        <div align="right"><a href="javascript:;" id="idDivAgregarProducto" onClick="agregar_producto_comprobante();"><img
                                    src="<?php echo base_url(); ?>images/botonagregar.jpg" border="1"  ></a>
                        </div>
                    </td>
                </tr>
            </table>
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
                    <td width="9%">
                        <div align="center">C&Oacute;DIGO</div>
                    </td>
                    <td width="36%">
                        <div align="center">DESCRIPCI&Oacute;N</div>
                    </td>
                    <td width="15%">
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
                       
                </tr>
            </table>
            <div>
                <table id="tblDetalleComprobante" class="fuente8" width="100%" border="0">
                    <?php

                    if (count($detalle_comprobante) > 0) {

                        foreach ($detalle_comprobante as $indice => $valor) {

                            $detacodi = $valor->CPDEP_Codigo;
                            $flagBS = $valor->flagBS;
                            $prodproducto = $valor->PROD_Codigo;
                            $unidad_medida = $valor->UNDMED_Codigo;
                            $codigo_interno = $valor->PROD_CodigoInterno;
                            $nombre_producto = $valor->PROD_Nombre;
                            $nombre_unidad = $valor->UNDMED_Simbolo;
                            $costo = $valor->CPDEC_Costo;
                            $GenInd = $valor->CPDEC_GenInd;
                            $prodcantidad = $valor->CPDEC_Cantidad;
                            $prodpu = $valor->CPDEC_Pu;
                            $prodsubtotal = $valor->CPDEC_Subtotal;
                            $proddescuento = $valor->CPDEC_Descuento;
                            $prodigv = $valor->CPDEC_Igv;
                            $prodtotal = $valor->CPDEC_Total;
                            $prodpu_conigv = $valor->CPDEC_Pu_ConIgv;
                            $prodsubtotal_conigv = $valor->CPDEC_Subtotal_ConIgv;
                            $proddescuento_conigv = $valor->CPDEC_Descuento_ConIgv;
                            $almacenProducto=$valor->ALMAP_Codigo;
                            $codigoGuiaremAsociadaDetalle=$valor->GUIAREMP_Codigo;
                            $readonly="";
                            if($codigoGuiaremAsociadaDetalle!=0)
                            	$readonly="readonly";
                            
                            if (($indice + 1) % 2 == 0) {
                                $clase = "itemParTabla";
                            } else {
                                $clase = "itemImparTabla";
                            }
                            ?>
                            
                            <tr id="<?php echo $indice ?>" t-doc="<?php echo $tipo_docu ?>"
                                class="<?php echo $clase; ?>"
                               style="<?php if($codigoGuiaremAsociadaDetalle!=0){
                                	echo  "background-color:".$colorGuiar[$codigoGuiaremAsociadaDetalle].";color:#000000;";
                                }?>">
                                <td width="3%">
   <div align="center">
   
   <?php  if(count($listaGuiaremAsociados)==0){ ?>
   		<font color="red"><strong><a href="javascript:;"
         onclick="eliminar_producto_comprobante(<?php echo $indice; ?>);">
		<span
   			style="border:1px solid red;background: #ffffff;">&nbsp;X&nbsp;</span></a>
			</strong>
		</font>
		
		<?php } ?>
        </div>
                                </td>
   <td width="4%">
   <div align="center"><?php echo $indice + 1; ?></div>
      </td>
                                <td width="9%">
      <div align="center"><?php echo $codigo_interno; ?></div>
                                </td>
                                <td>
    <div align="left"><input type="text" class="cajaGeneral" style="width:390px;"
   maxlength="250" name="proddescri[<?php echo $indice; ?>]"
    id="proddescri[<?php echo $indice; ?>]"
   value="<?php echo $nombre_producto; ?>"/></div>
                                </td>
       <?php if ($tipo_docu != 'B' && $tipo_docu != 'N') { ?>
                                <td width="12%">
 <div align="left"><input type="text" size="1" maxlength="10" class="cajaGeneral"
     name="prodcantidad[<?php echo $indice; ?>]"
      id="prodcantidad[<?php echo $indice; ?>]"
      value="<?php echo $prodcantidad; ?>"
       onblur="calcula_importe(<?php echo $indice; ?>);"
       onkeypress="return numbersonly(this,event,'.');"  <?php echo $readonly; ?> /><?php echo $nombre_unidad; ?>

 	<?php if($GenInd=='I') {?>
 		<?php if($codigoGuiaremAsociadaDetalle!=0 ||  $isProvieneCanje){ ?>
 		
 			<?php if(!$isProvieneCanje){ ?>
 			<!-- Guiade remision mostra -->
 				<a href="javascript:;" id="imgEditarSeries<?php echo $indice; ?>" onclick="ventana_producto_serieMostrar(10,<?php echo $codigoGuiaremAsociadaDetalle; ?>,<?php echo $prodproducto; ?>,<?php echo $almacenProducto; ?>)" ><img src="<?php echo base_url(); ?>images/flag-green_icon.png" width="20" height="20" class="imgBoton"></a>
            <?php }else{ ?> 
             <!-- mostrar detalles de comprante que genraron la factura o boleta -->
             <a href="javascript:;" id="imgEditarSeries<?php echo $indice; ?>" onclick="ventana_producto_serieMostrar(<?php echo $tipoOperCodigo; ?>,<?php echo $codigo; ?>,<?php echo $prodproducto; ?>,<?php echo $almacenProducto; ?>)" ><img src="<?php echo base_url(); ?>images/flag-green_icon.png" width="20" height="20" class="imgBoton"></a>
 
            <?php } ?>
               	
 		<?php }else{?>
    		<a href="javascript:;" id="imgEditarSeries<?php echo $indice; ?>" onclick="ventana_producto_serie(<?php echo $indice; ?>)" ><img src="<?php echo base_url(); ?>images/flag-green_icon.png" width="20" height="20" class="imgBoton"></a>
		<?php } ?>
   <?php } ?>
   
      </div>
        </td>
       <td width="6%">
        <div align="center">
        <input type="text" size="5" maxlength="10" class="cajaGeneral" name="prodpu_conigv[<?php echo $indice; ?>]"
        id="prodpu_conigv[<?php echo $indice; ?>]"
        value="<?php echo $prodpu_conigv; ?>"
        onblur="modifica_pu_conigv(<?php echo $indice; ?>);"
        onkeypress="return numbersonly(this,event,'.');" <?php echo $readonly; ?>/></div>
                                </td>
    <td width="6%">
    <div align="center"><input type="text" size="5" maxlength="10" class="cajaGeneral"
         name="prodpu[<?php echo $indice; ?>]"
     id="prodpu[<?php echo $indice; ?>]"
     value="<?php echo $prodpu; ?>"
    onblur="modifica_pu(<?php echo $indice; ?>);"
     onkeypress="return numbersonly(this,event,'.');" <?php echo $readonly; ?>/>
        <td width="6%">
     <div align="center">
<input type="text" size="5" maxlength="10"
         class="cajaGeneral cajaSoloLectura"
          name="prodprecio[<?php echo $indice; ?>]"
        id="prodprecio[<?php echo $indice; ?>]"
        value="<?php echo $prodsubtotal; ?>"
          readonly="readonly"/></div>
     </td>
     <?php } else { ?>
    <td width="12%">
   <div align="left"><input type="text" size="7" maxlength="10"
   class="cajaGeneral"
    name="prodcantidad[<?php echo $indice; ?>]"
    id="prodcantidad[<?php echo $indice; ?>]"
    value="<?php echo $prodcantidad; ?>"
     onblur="calcula_importe(<?php echo $indice; ?>);"
    onkeypress="return numbersonly(this,event,'.');" <?php echo $readonly; ?>/>
    <?php echo $nombre_unidad; ?>

   
   	<?php if($GenInd=='I') {?>
 		<?php if($codigoGuiaremAsociadaDetalle!=0){ ?>
 			<a href="javascript:;" id="imgEditarSeries<?php echo $indice; ?>" onclick="ventana_producto_serieMostrar(10,<?php echo $codigoGuiaremAsociadaDetalle; ?>,<?php echo $prodproducto; ?>,<?php echo $almacenProducto; ?>)" ><img src="<?php echo base_url(); ?>images/flag-green_icon.png" width="20" height="20" class="imgBoton"></a>
            
 		<?php }else{?>
    		<a href="javascript:;" id="imgEditarSeries<?php echo $indice; ?>" onclick="ventana_producto_serie(<?php echo $indice; ?>)" ><img src="<?php echo base_url(); ?>images/flag-green_icon.png" width="20" height="20" class="imgBoton"></a>
		<?php } ?>
   <?php } ?>
    </div>
    
    </td>
 <td width="6%">
 <div align="center"><input type="text" size="5" maxlength="10"
 class="cajaGeneral"
   name="prodpu_conigv[<?php echo $indice; ?>]"
  id="prodpu_conigv[<?php echo $indice; ?>]"
  value="<?php echo $prodpu_conigv; ?>"
  onblur="modifica_pu_conigv(<?php echo $indice; ?>);"
  onkeypress="return numbersonly(this,event,'.');" <?php echo $readonly; ?>/>
   </div>
 </td>
  <td width="6%">
 <div align="center"><input type="text" size="5" maxlength="10"
      class="cajaGeneral"
         name="prodpu[<?php echo $indice; ?>]"
     id="prodpu[<?php echo $indice; ?>]"
      value="<?php echo $prodpu; ?>"
       onblur="modifica_pu(<?php echo $indice; ?>);"
  onkeypress="return numbersonly(this,event,'.');" <?php echo $readonly; ?>/>
   <td width="6%">
             <div align="center">

     <input type="text" size="5" maxlength="10"
             class="cajaGeneral cajaSoloLectura"
              name="prodprecio[<?php echo $indice; ?>]"   id="prodprecio[<?php echo $indice; ?>]"
              value="<?php echo $prodsubtotal; ?>"
                 readonly="readonly"/></div>
                                                </td>

                                                <td width="6%" style="display:none">
            <div align="center"><input type="text" size="5" maxlength="10"
            class="cajaGeneral" name="prodprecio_conigv[<?php echo $indice; ?>]"
            id="prodprecio_conigv[<?php echo $indice; ?>]"
              value="<?php echo $prodsubtotal_conigv; ?>"
                   readonly="readonly"/></div>
 </td>
 <?php } ?>
  <?php if ($tipo_docu != 'B' && $tipo_docu != 'N') { ?>
  <td width="6%" style="display:none;">
    <div align="center">
     <input type="text" size="5"
         class="cajaGeneral cajaSoloLectura"
        name="prodigv[<?php echo $indice; ?>]"
           id="prodigv[<?php echo $indice; ?>]"
         readonly="readonly" value="<?php echo $prodigv; ?>"/>
         </div>
           </td>
      <?php } ?>
  <td width="6%" style="display:none;">
   <div align="center">
    <input type="hidden" size="5"
   class="cajaGeneral cajaSoloLectura"
      name="prodigv[<?php echo $indice; ?>]"
      id="prodigv[<?php echo $indice; ?>]" readonly="readonly"
   value="<?php echo $prodigv; ?>"/>
 <input type="hidden" name="detaccion[<?php echo $indice; ?>]"
  id="detaccion[<?php echo $indice; ?>]" value="m"/>
 <input type="hidden" name="prodigv100[<?php echo $indice; ?>]"
   id="prodigv100[<?php echo $indice; ?>]"
   value="<?php echo $igv; ?>"/>
    <input type="hidden" name="detacodi[<?php echo $indice; ?>]"
     id="detacodi[<?php echo $indice; ?>]"
    value="<?php echo $detacodi; ?>"/>
        <input type="hidden" name="flagBS[<?php echo $indice; ?>]"
        id="flagBS[<?php echo $indice; ?>]" value="<?php echo $flagBS; ?>"/>
    <input type="hidden" name="prodcodigo[<?php echo $indice; ?>]"
        id="prodcodigo[<?php echo $indice; ?>]" value="<?php echo $prodproducto; ?>"/>
       <input type="hidden" name="produnidad[<?php echo $indice; ?>]"
               id="produnidad[<?php echo $indice; ?>]" value="<?php echo $unidad_medida; ?>"/>
     <input type="hidden"  name="flagGenIndDet[<?php echo $indice; ?>]"
            id="flagGenIndDet[<?php echo $indice; ?>]" value="<?php echo $GenInd; ?>"/>
     <input type="hidden" name="prodstock[<?php echo $indice; ?>]"
               id="prodstock[<?php echo $indice; ?>]" value=""/>
    <input type="hidden" name="prodcosto[<?php echo $indice; ?>]"
            id="prodcosto[<?php echo $indice; ?>]"
          value="<?php echo $costo; ?>"/>
          
    <input type="hidden" name="almacenProducto[<?php echo $indice; ?>]"
            id="almacenProducto[<?php echo $indice; ?>]"
          value="<?php echo $almacenProducto; ?>"/>      
     <input type="hidden"  name="proddescuento100[<?php echo $indice; ?>]"
           id="proddescuento100[<?php echo $indice; ?>]"
        value="<?php echo $descuento; ?>"/>
        
        <?php if($codigoGuiaremAsociadaDetalle!=0 || ($flagBS=='S' && count($listaGuiaremAsociados)>0)){ ?>
     <!--  /**se agrega la guia de remision asociada***/ -->   
		<input type="hidden" name="codigoGuiarem[<?php echo $indice; ?>]" id="codigoGuiarem[<?php echo $indice; ?>]" value="<?php echo $codigoGuiaremAsociadaDetalle; ?>">
       <!--             /**fin de agregar la guia de remision**/-->
        <?php } ?>
        
        
       <?php
             if ($tipo_docu != 'B' && $tipo_docu != 'N') {
     if ($tipo_oper == 'C') {
                                                                ?>
           <input type="text" size="1" class="proddescuento"
           name="proddescuento[<?php echo $indice; ?>]"
    id="proddescuento[<?php echo $indice; ?>]"
 value="<?php echo $proddescuento; ?>"
 onblur="calcula_importe2(<?php echo $indice; ?>);"/>
 <?php } else {
?>
 <input type="hidden"
    name="proddescuento[<?php echo $indice; ?>]"
   id="proddescuento[<?php echo $indice; ?>]"
   value="<?php echo $proddescuento; ?>"
  onblur="calcula_importe2(<?php echo $indice; ?>);"/>
    <?php
   }
    } else {
 ?>
<input type="hidden"  name="proddescuento[<?php echo $indice; ?>]"
 id="proddescuento[<?php echo $indice; ?>]"
 value="<?php echo $proddescuento; ?>"
  onblur="calcula_importe2(<?php echo $indice; ?>);"/>
   <?php } ?>
    <input type="text" size="5" class="cajaGeneral cajaSoloLectura"
   name="prodimporte[<?php echo $indice; ?>]"
    id="prodimporte[<?php echo $indice; ?>]"
    readonly="readonly" value="<?php echo $prodtotal; ?>"/>
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
            <table width="100%" border="0" align="right" cellpadding=3 cellspacing=0 class="fuente8">
                <tr>
                    <td width="80%" rowspan="5" align="left">
                        <table width="100%" border="0" align="right" cellpadding=3 cellspacing=0 class="fuente8"
                               style="width: 736px;">
                      

                            <tr>

                                <td colspan="4">Observación</td>

                            </tr>

                            <tr>

     <td colspan="4"><textarea id="observacion" name="observacion" class="cajaTextArea"
   style="width:97%; height:70px;"><?php echo $observacion; ?></textarea>
                                </td>

                            </tr>

                        </table>

                    </td>

                    <td width="10%" class="busqueda">Sub-total</td>

                    <?php if ($tipo_docu != 'B' && $tipo_docu != 'N') { ?>

                        <td width="10%" align="right">
  <div align="right">Precio &nbsp;
  <input class="cajaTotales" name="preciototal" type="text"
     id="preciototal" size="12" align="right" <?php

                                if ($tipo_oper == 'V') {

                                    echo 'readonly="readonly"';

                                }

                                ?> value="<?php echo round($preciototal, 2); ?>"
              onKeyPress="return numbersonly(this,event,'.');"></div>
                        </td>

                    <?php } else { ?>

                        <td width="10%" align="right">
                            <div align="right"><input class="cajaTotales" name="preciototal" type="text"
             id="preciototal" size="12" align="right" <?php

                                if ($tipo_oper == 'V') {

                                    echo 'readonly="readonly"';

                                }

                                ?> value="<?php echo round($preciototal, 2); ?>"
       onKeyPress="return numbersonly(this,event,'.');"></div>
                        </td>

                    <?php } ?>

                </tr>

                <?php if ($tipo_oper == 'C') { ?>

                    <tr>

                        <td class="busqueda">Descto %</td>

                        <td align="right" width="10%"><input type="text" onchange="descuento_porcentaje()"
           name="porcentaje" id="porcentaje" class="cajaTotales"
              value="0" <?php

                            if ($tipo_oper == 'V') {

                                echo 'readonly="readonly"';

                            }

                            ?>  onKeyPress="return numbersonly(this,event,'.');"></td>

                    </tr>

                <?php } ?>

                <tr>

                    <td class="busqueda">Descuento</td>

                    <?php if ($tipo_docu != 'B' && $tipo_docu != 'N') { ?>

                        <td align="right">
                            <div align="right"><input class="cajaTotales" name="descuentotal" type="text"
     id="descuentotal" readonly="" size="12" align="right"
        value="<?php echo round($descuentotal, 2); ?>"></div>
                        </td>

                    <?php } else { ?>

                        <td align="right">
                            <div align="right"><input class="cajaTotales" name="descuentotal_conigv" type="text"
   readonly="" id="descuentotal_conigv" size="12" align="right"
    value="<?php echo round($descuentotal_conigv, 2); ?>"></div>
                        </td>

                    <?php } ?>

                </tr>

                <?php //if ($tipo_docu != 'B' && $tipo_docu != 'N') { ?>

                <tr>

                    <td class="busqueda">IGV</td>

                    <td align="right">
                        <div align="right"><input class="cajaTotales" name="igvtotal" type="text" id="igvtotal"
                                                  size="12" align="right" <?php

                            if ($tipo_oper == 'V') {

                                echo 'readonly="readonly"';

                            }

                            ?> value="<?php echo round($igvtotal, 2); ?>"/></div>
                    </td>

                </tr>

                <?php // } ?>

                <?php if ($tipo_oper == 'V') { ?>

                    <tr>

                        <td class="busqueda">VISA</td>

                        <td align="right">
                            <div align="right"><input class="cajaTotales" name="visa" onchange="incremento_visa()"
  type="text" id="visa" size="12" align="right"
 value="<?php //echo round($igvtotal, 2); ?>"
 onKeyPress="return numbersonly(this,event,'.');"/></div>
                        </td>

                    </tr>

                <?php } ?>

                <tr>

                    <td class="busqueda">Precio Total</td>

                    <td align="right">
                        <div align="right"><input class="cajaTotales" name="importetotal" type="text" id="importetotal"
       size="12" align="right" <?php

                            if ($tipo_oper == 'V') {

                                echo 'readonly="readonly"';

                            }

                            ?> value="<?php echo round($importetotal, 2); ?>"
    onKeyPress="return numbersonly(this,event,'.');"/></div>
                    </td>

                </tr>

            </table>


        </div>
        <br/>
        <div id="botonBusqueda2" style="padding-top:20px;">
            <a href="javascript:;" id="grabarComprobanteAlterna"><img src="<?php echo base_url(); ?>images/botonaceptar.jpg"  width="85" height="22" class="imgBoton"></a>
            <a href="javascript:;" id="cancelarComprobanteAlterna"><img src="<?php echo base_url(); ?>images/botoncancelar.jpg"  width="85" height="22" class="imgBoton"></a>
        </div>
    </div>


</form>



</body>

</html>