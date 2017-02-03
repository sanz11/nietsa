<?php

$nombre_persona = $this->session->userdata('nombre_persona');

$persona = $this->session->userdata('persona');

$usuario = $this->session->userdata('usuario');

$url = base_url() . "index.php";

if (empty($persona))

    header("location:$url");

?>
<html>
    <head>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-ui-1.8.17.custom.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/funciones.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/ventas/comprobante.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
        <script type="text/javascript">		
            $(document).ready(function() {
<?php
if ($tipo_oper == 'V'):
    switch ($tipo_docu) {
        case 'F':
            ?> 
                                setLimite(<?php echo VENTAS_FACTURA; ?>)	
            <?php
            break;
        case 'B':
            ?>
                                setLimite(<?php echo VENTAS_BOLETA; ?>)	
            <?php
            break;
        case 'N':
            ?>
                                setLimite(<?php echo VENTAS_COMPROBANTE; ?>)	
            <?php
            break;
        default:
            break;
    } elseif ($tipo_oper == 'C') :
    switch ($tipo_docu) {
        case 'F':
            ?> 
                                setLimite(<?php echo COMPRAS_FACTURA; ?>)	
            <?php
            break;
        case 'B':
            ?>
                                setLimite(<?php echo COMPRAS_BOLETA; ?>)	
            <?php
            break;
        default:
            break;
    }
endif;
?>
  if($('#tdc').val()==''){
            alert("Antes de registrar comprobantes debe ingresar Tipo de Cambio")
            top.location="<?php echo base_url(); ?>index.php/index/inicio";
        }
        base_url  = $("#base_url").val();
        tipo_oper = $("#tipo_oper").val();
        almacen = $("#cboCompania").val();
        $("a#linkVerCliente, a#linkSelecCliente, a#linkVerProveedor, a#linkSelecProveedor").fancybox({
            'width'          : 700,
            'height'         : 550,
            'autoScale'	 : false,
            'transitionIn'   : 'none',
            'transitionOut'  : 'none',
            'showCloseButton': true,
            'modal'          : false,
            'type'           : 'iframe'

        });

        $(" #linkSelecProducto").fancybox({
            'width'	         : 800,
            'height'         : 500,
            'autoScale'	 : false,
            'transitionIn'   : 'none',
            'transitionOut'  : 'none',
            'showCloseButton': true,
            'modal'          : false,
            'type'	         : 'iframe'

        });

        $("a#linkVerProducto").fancybox({
            'width'          : 800,
            'height'         : 650,
            'autoScale'	 : false,
            'transitionIn'   : 'none',
            'transitionOut'  : 'none',
            'showCloseButton': true,
            'modal'          : true,
            'type'	     : 'iframe'
        });

        $("#linkVerImpresion").fancybox({
            'transitionIn'   : 'none',
            'transitionOut'  : 'none',
            'showCloseButton': true,
            'modal'          : true

        });

        $(".verDocuRefe").fancybox({
            'width'          : 670,
            'height'         : 420,
            'autoScale'      : false,
            'transitionIn'   : 'none',
            'transitionOut'  : 'none',
            'showCloseButton': true,
            'modal'          : false,
            'type'	     : 'iframe',
            'onStart'        : function(){

                if(tipo_oper=='V'){
                    if($('#cliente').val()==''){
                        alert('Debe seleccionar el cliente.');
                        $('#nombre_cliente').focus();
                        return false;
                    }else{
						//alert($('.verDocuRefe::checked').val());
						if($('.verDocuRefe::checked').val()=='G' )
						baseurl= base_url+'index.php/almacen/guiarem/ventana_muestra_guiarem/'+tipo_oper+'/'+$('#cliente').val()+'/SELECT_HEADER/F/'+almacen+'/G';
						else if($('.verDocuRefe::checked').val()=='P' )					
						baseurl=base_url+'index.php/ventas/presupuesto/ventana_muestra_presupuestoCom/'+tipo_oper+'/'+$('#cliente').val()+'/SELECT_HEADER/<?php echo $tipo_docu; ?>/'+almacen+'/P';
						else if($('.verDocuRefe::checked').val()=='O' )					
						baseurl=base_url+'index.php/compras/ocompra/ventana_muestra_ocompraCom/'+tipo_oper+'/'+$('#cliente').val()+'/SELECT_HEADER/<?php echo $tipo_docu; ?>/'+almacen+'/O';
						else if($('.verDocuRefe::checked').val()=='R' )					
						baseurl=base_url+'index.php/ventas/comprobante/ventana_muestra_recurrentes/'+tipo_oper+'/'+$('#cliente').val()+'/SELECT_HEADER/<?php echo $tipo_docu; ?>/'+almacen+'/R';
												//alert(baseurl);
											
                        $('.verDocuRefe::checked').attr('href', baseurl );
					
					}
                }else{

                    if($('#proveedor').val()==''){
                        alert('Debe seleccionar el proveedor.');
                        $('#nombre_proveedor').focus();
                        return false;
                    }else{
                       if($('.verDocuRefe::checked').val()=='G' )
						baseurl= base_url+'index.php/almacen/guiarem/ventana_muestra_guiarem/'+tipo_oper+'/'+$('#proveedor').val()+'/SELECT_HEADER/F/'+almacen+'/G';
						else if($('.verDocuRefe::checked').val()=='P' )		
							if( tipo_oper =='V' )
						baseurl=base_url+'index.php/ventas/presupuesto/ventana_muestra_presupuestoCom/'+tipo_oper+'/'+$('#proveedor').val()+'/SELECT_HEADER/<?php echo $tipo_docu; ?>/'+almacen+'/P';
							else 
						baseurl=base_url+'index.php/compras/presupuesto/ventana_muestra_presupuestoCom/'+tipo_oper+'/'+$('#proveedor').val()+'/SELECT_HEADER/<?php echo $tipo_docu; ?>/'+almacen+'/P';
						else if($('.verDocuRefe::checked').val()=='O' )					
						baseurl=base_url+'index.php/compras/ocompra/ventana_muestra_ocompraCom/'+tipo_oper+'/'+$('#proveedor').val()+'/SELECT_HEADER/<?php echo $tipo_docu; ?>/'+almacen+'/O';
						else if($('.verDocuRefe::checked').val()=='R' )					
						baseurl=base_url+'index.php/ventas/comprobante/ventana_muestra_recurrentes/'+tipo_oper+'/'+$('#proveedor').val()+'/SELECT_HEADER/<?php echo $tipo_docu; ?>/'+almacen+'/R';
						//alert(baseurl);
											
                        $('.verDocuRefe::checked').attr('href', baseurl );
						}
                }                         
            }
        });
  
    });

    $(function() {
        $("#buscar_producto").autocomplete({
            //flag = $("#flagBS").val();
            source: function(request, response){
                $.ajax({ 
                  url: "<?php echo base_url(); ?>index.php/almacen/producto/autocomplete/"+$("#flagBS").val()+"/"+$("#compania").val(),
                    type: "POST",
                    data:  { 
                        term: $("#buscar_producto").val()
                    },
                    dataType: "json", 
                    success: function(data){
                        response(data);
                    }
                });
            }, 
            select: function(event, ui){
                $("#buscar_producto").val(ui.item.codinterno);
                $("#producto").val(ui.item.codigo)
                $("#codproducto").val(ui.item.codinterno);
                $("#costo").val(ui.item.pcosto);
                $("#cantidad").focus();
                listar_unidad_medida_producto(ui.item.codigo);
                // obtener_producto_desde_codigo(n);
                // return false;
            },
            minLength: 2
        });
                    //****** nuevo para ruc
        $("#buscar_cliente").autocomplete({
            //flag = $("#flagBS").val();
            source: function(request, response){
                $.ajax({ 
                    url: "<?php echo base_url(); ?>index.php/ventas/cliente/autocomplete_ruc/",
                    type: "POST",
                    data:  { 
                        term: $("#buscar_cliente").val()
                    },
                    dataType: "json", 
                    success: function(data){                        
                        response(data);                        
                    }
                });
            },
            select: function(event, ui){
                //$("#nombre_cliente").val(ui.item.codinterno);
                $("#nombre_cliente").val(ui.item.nombre);                
                $("#cliente").val(ui.item.codigo);
                $("#ruc_cliente").val(ui.item.ruc);
                $("#buscar_producto").focus();
            },
            minLength: 4
        });

        /* Descativado hasta corregir vico 22082013 - quien es vico? (fixed) */
         $("#nombre_cliente").autocomplete({
            //flag = $("#flagBS").val();
            source: function(request, response){
                $.ajax({ 
                    url: "<?php echo base_url(); ?>index.php/ventas/cliente/autocomplete/",
                    type: "POST",
                    data:  { 
                        term: $("#nombre_cliente").val()
                    },
                    dataType: "json", 
                    success: function(data){                        
                        response(data);                        
                    }

                });

            }, 

            select: function(event, ui){
                //$("#nombre_cliente").val(ui.item.codinterno);
                $("#buscar_cliente").val(ui.item.ruc);
                $("#cliente").val(ui.item.codigo);
                $("#ruc_cliente").val(ui.item.ruc);
                $("#buscar_producto").focus();
            },
            minLength: 3
        });
 /* Descativado hasta corregir vico 22082013  */
         $("#nombre_proveedor").autocomplete({
            //flag = $("#flagBS").val();
            source: function(request, response){
                $.ajax({ 
                    url: "<?php echo base_url(); ?>index.php/compras/proveedor/autocomplete/",
                    type: "POST",
                    data:  { 
                        term: $("#nombre_proveedor").val()
                    },
                    dataType: "json", 
                    success: function(data){
                        response(data);
                    }
                });
            }, 
            select: function(event, ui){
                //$("#nombre_proveedor").val(ui.item.codinterno);
                $("#buscar_proveedor").val(ui.item.ruc)
                $("#proveedor").val(ui.item.codigo);
				$("#ruc_proveedor").val(ui.item.ruc);
                $("#buscar_producto").focus();
            },
            minLength: 2
        });
	
	//****** nuevo para ruc PROVEEDOR
        $("#buscar_proveedor").autocomplete({
            //flag = $("#flagBS").val();
            source: function(request, response){
                $.ajax({ 
                    url: "<?php echo base_url(); ?>index.php/compras/proveedor/autocomplete_ruc/",
                    type: "POST",
                    data:  { 
                        term: $("#buscar_proveedor").val()
                    },
                    dataType: "json", 
                    success: function(data){                        
                        response(data);                        
                    }
                });
            },
            select: function(event, ui){
                //$("#nombre_cliente").val(ui.item.codinterno);
                $("#nombre_proveedor").val(ui.item.nombre);                
                $("#proveedor").val(ui.item.codigo);
                $("#ruc_proveedor").val(ui.item.ruc);
                $("#buscar_producto").focus();
            },
            minLength: 4
        });	
		
		
		
		    });
    
    /*-----------------------------------*/

    function seleccionar_cliente(codigo,ruc,razon_social){
        $("#cliente").val(codigo);
        $("#ruc_cliente").val(ruc);
        $("#nombre_cliente").val(razon_social);
    }
    function seleccionar_proveedor(codigo,ruc,razon_social){
        $("#proveedor").val(codigo);
        $("#ruc_proveedor").val(ruc);
        $("#nombre_proveedor").val(razon_social);
    }

    function seleccionar_producto(producto,cod_interno,familia,stock,costo,flagGenInd){
        $("#codproducto").val(cod_interno);
        $("#producto").val(producto);
        $("#cantidad").focus();
        $("#stock").val(stock);
        $("#costo").val(costo);
        $("#flagGenInd").val(flagGenInd);
        listar_unidad_medida_producto(producto);

    }

    function seleccionar_documento_detalle(producto,codproducto,nombre_producto,cantidad,flagBS,flagGenInd,unidad_medida,nombre_medida,precio_conigv,precio_sinigv,precio,igv,importe,stock,costo){
        agregar_fila(producto,codproducto,nombre_producto,cantidad,flagBS,flagGenInd,unidad_medida,nombre_medida,precio_conigv,precio_sinigv,precio,igv,importe,stock,costo);

    }
    function seleccionar_guiarem(guia,serieguia,numeroguia){
                agregar_todo(guia);
                //alert(guia);
                serienumero="Numero de guia :"+serieguia+ " - " + numeroguia;
                $("#dRef").val(guia);
                $("#serieguiaver").html(serienumero);
                $("#serieguiaver").show(2000);
				$("#serieguiaverPre").hide(2000);
				$("#serieguiaverOC").hide(2000);
				$("#serieguiaverRecu").hide(2000);
				$('#ordencompra').val('');
            }
			
	function seleccionar_presupuesto(guia,serieguia,numeroguia){
		tipo_oper = $("#tipo_oper").val();
                agregar_todopresupuesto(guia,tipo_oper);
                serienumero="Numero de PRESUPUESTO :"+serieguia+ " - " + numeroguia;
                $("#serieguiaverPre").html(serienumero);
                $("#serieguiaverPre").show(2000);
                $("#serieguiaver").hide(2000);
				$("#serieguiaverOC").hide(2000);
				$("#serieguiaverRecu").hide(2000);
				$("#docurefe_codigo").val('');
				$("#dRef").val('');
				$('#ordencompra').val('');
				$("#numero_ref").val('');
            }			
	function seleccionar_comprobante_recu(guia,serieguia,numeroguia){
                agregar_todo_recu(guia);
                //alert(guia);
                serienumero="Numero de Comprobante :"+serieguia+ " - " + numeroguia;
                $("#serieguiaverRecu").html('documento recurrente:'+serienumero);
                $("#serieguiaverRecu").show(2000);
                $("#serieguiaver").hide(2000);
                $("#serieguiaverPre").hide(2000);
				$("#serieguiaverOC").hide(2000);
				$("#numero_ref").val('');
				$("#dRef").val('');
				$('#ordencompra').val('');
				$("#docurefe_codigo").val('');
            }		
        
 function valida()

    {

        if(document.forms[0].seriep.value.length>2)

        {

            document.forms[0].presupuesto.focus();

            return false;

        }

        else

            return true;

    }
	function tdc_cambiar(){
			//alert($('#fecha').val());
               $.ajax({ 
                  url: "<?php echo base_url(); ?>index.php/maestros/tipocambio/buscar_json",
                    type: "POST",
                    data:  {
                        fecha : $('#fecha').val()
                    },
                    success: function(data){
					if(data==0){
                        alert('error Tipo de cambio en esta fecha no ingresada');
						$('#fecha').val('<?php echo date('d/m/Y');?>');
						tdc_cambiar();
                    }else{
					$('#tdc').val(data);}
					}
                }); 
			}
    // End -->

        

        </script>

    </head>

    <body>

        <input type="hidden" name="codigoguia" id="codigoguia" value="<?php echo $guia; ?>"/>

        <?php

//echo date("Y-m-d H:i:s");

// stylo para ocultar botones combos, etc

        $style = "";

        if (FORMATO_IMPRESION == 8) {

            $style = "display:none;";

        }

        ?>

        <!-- Inicio -->
		<input name="compania" type="hidden" id="compania" value="<?php echo $compania; ?>">
        <div id="VentanaTransparente" style="display:none;">

            <div class="overlay_absolute"></div>

            <div id="cargador" style="z-index:2000">

                <table width="100%" height="100%" border="0" class="fuente8">

                    <tr valign="middle">

                        <td> Por Favor Espere    </td>

                        <td><img src="<?php echo base_url(); ?>images/cargando.gif"  border="0" title="CARGANDO" /><a href="#" id="hider2"></a>	</td>

                    </tr>

                </table>

            </div>

        </div>

        <!-- Fin -->		

        <form id="<?php echo $formulario; ?>" method="post" action="<?php echo $url_action; ?>">

            <div id="zonaContenido" align="center">

                <?php echo validation_errors("<div class='error'>", '</div>'); ?>

                <div id="tituloForm" class="header" style="height: 20px">

                    <?php echo $titulo; ?>

                    <?php

                    if ($tipo_docu != 'N') {

                        if ($codigo == '') {

                            ?>

                            <select id="cboTipoDocu" name="cboTipoDocu" class="comboMedio"  >

                                <option value="F" <?php if ($tipo_docu == 'F') echo 'selected="selected"'; ?>>FACTURA</option>

                                <option value="B" <?php if ($tipo_docu == 'B') echo 'selected="selected"'; ?>>BOLETA</option>

                            </select>

                            <?php

                        }

                    }else {

                        ?><input type="hidden" value="N" id="cboTipoDocu"  name="cboTipoDocu"/><?php }; ?>

                </div>

                <div id="frmBusqueda">

                    <table class="fuente8" width="100%" cellspacing="0" cellpadding="5" border="0">

                        <tr>

                            <td width="8%">N&uacute;mero * </td>

                            <td width="60%" valign="middle">
                                <input class="cajaGeneral" name="serie" type="text" id="serie" size="4" maxlength="5" value="<?php echo $serie; ?>" />&nbsp;
                                <input class="cajaGeneral" name="numero" type="text" id="numero" size="10" maxlength="10" value="<?php echo $numero; ?>" />
                                <?php if ($tipo_oper == 'V') { ?>
                                    <a href="javascript:;" id="linkVerSerieNum" <?php if ($codigo != '') echo 'style="display:none"' ?>>
                                        <p class="boleta" style="display:none"><?php 
                                        echo $serie_suger_b . '-' .  $numero_suger_b ?> 
                                        </p>
                                        <p class="factura" style="display:none"><?php echo $serie_suger_f . '-' . $numero_suger_f ?>
                                        </p>
                                        <p class="comprobante" style="display:none"><?php echo $serie_suger_f . '-' . $numero_suger_f ?>
                                        </p>
                                        <image src="<?php echo base_url(); ?>images/flecha.png" border="0" alt="Serie y número sugerido" title="Serie y número sugerido" />
                                    </a>
                                <?php } ?>

                                <label style="margin-left:20px;">IGV</label>
                                <input NAME="igv" type="text" class="cajaGeneral cajaSoloLectura" id="igv" size="2" maxlength="2" value="<?php echo $igv; ?>" onkeypress="return numbersonly(this,event,'.');" onblur="modifica_igv_total();" readonly="readonly" /> %
                                <input type="hidden" name="descuento" id="descuento" value="" />
                            </td>
                               <!-- <td width="8%" valign="middle">Presupuesto</td>-->
                                <td width="5%" valign="middle">
								<?php if ($tipo_oper == 'V'){ ?>
								<label for="P"><img src="<?php echo base_url() ?>images/presupuesto.png" class="imgBoton" /></label>
								<?php }else{?>
								<label for="P"><img src="<?php echo base_url() ?>images/cotizacion.png" class="imgBoton" /></label>
								<?php }?>
								<input type="radio" name="referenciar" id="P" value="P" href="javascript:;" class="verDocuRefe" style="display:none;">
								<div id="serieguiaverPre" name="serieguiaverPre" style="background-color: #cc7700; color:fff; padding:5px;display:none" ></div>
											
								</td>
								
								<!--<td width="8%" >O. <?php //if ($tipo_oper == 'C') echo 'Compra'; else echo 'Venta'; ?> </td>-->
								<td width="5%" >
								<?php if ($tipo_oper == 'V'){ ?>
								<label for="O"><img src="<?php echo base_url() ?>images/oventa.png" class="imgBoton" /></label>
								<?php }else{?>
								<label for="O"><img src="<?php echo base_url() ?>images/ocompra.png" class="imgBoton" /></label>
								<?php }?>
								<input type="radio" name="referenciar" id="O" value="O" href="javascript:;" class="verDocuRefe" style="display:none;">
								<div id="serieguiaverOC" name="serieguiaverOC" style="background-color: #cc7700; color:fff; padding:5px;display:none" ></div>
								<input type="hidden" name="ordencompra" id="ordencompra" size="5" value="<?php echo $ordencompra; ?>" />
								</td>
                            <td width="5%" valign="middle">Fecha</td>
                            <td width="30%" valign="middle"><input name="fecha" type="text" class="cajaGeneral cajaSoloLectura" id="fecha" value="<?php echo $hoy; ?>" size="10" maxlength="10" readonly="readonly" onchange="tdc_cambiar()" />
                                <img height="16" border="0" width="16" id="Calendario1" name="Calendario1" src="<?php echo base_url(); ?>images/calendario.png" />
                                <script type="text/javascript">
                                    Calendar.setup({
                                        inputField     :    "fecha",      // id del campo de texto
                                        ifFormat       :    "%d/%m/%Y",       // formaClienteto de la fecha, cuando se escriba en el campo de texto
                                        button         :    "Calendario1" // el id del botón que lanzará el calendario
										});
                                </script>
                            </td>
                        </tr>
                        <tr>
                            <?php if ($tipo_oper == 'V') { ?>
                                <td>Cliente *</td>
                                <td valign="middle">
                                    <?php

                                    if ($tipo_docu != 'F' && $cliente != 1662) {

                                        ?>
                                        <input type="hidden" name="cliente" id="cliente" size="5" value="<?php echo $cliente ?>" />
                                        <input placeholder="ruc" name="buscar_cliente" type="text" class="cajaGeneral" id="buscar_cliente" size="10" title="Ingrese parte del nombre o el nro. de documento, luego presione ENTER." />&nbsp;
                                        <input type="hidden" name="ruc_cliente" class="cajaGeneral" id="ruc_cliente" size="10" maxlength="11" onblur="obtener_cliente();" value="00000000000" onkeypress="return numbersonly(this,event,'.');" />
                                        <input placeholder="razon social" type="text" name="nombre_cliente" class="cajaGeneral" id="nombre_cliente" size="37" maxlength="50"  value="<?php echo $nombre_cliente; ?>" />
									    <?php
                                    } else {
                                        ?>
                                        <input type="hidden" name="cliente" id="cliente" size="5" value="<?php echo $cliente ?>" />
                                        <input placeholder="ruc" name="buscar_cliente" type="text" class="cajaGeneral" id="buscar_cliente" size="10" title="Ingrese parte del nombre o el nro. de documento, luego presione ENTER." />&nbsp;
                                        <input type="hidden" name="ruc_cliente" class="cajaGeneral" id="ruc_cliente" size="10" maxlength="11" onblur="obtener_cliente();" value="<?php echo $ruc_cliente; ?>" onkeypress="return numbersonly(this,event,'.');" />
                                        <input placeholder="razon social" type="text" name="nombre_cliente" class="cajaGeneral" id="nombre_cliente" size="37" maxlength="50"  value="<?php echo $nombre_cliente; ?>" />
									   <?php
                                    }
                                    ?>

                                    <a href="<?php echo base_url(); ?>index.php/ventas/cliente/ventana_selecciona_cliente/" id="linkSelecCliente"></a>

                                </td>

                            <?php } else { ?>

                                <td>Proveedor *</td>
                                <td valign="middle">
                                    <input type="hidden" name="proveedor" id="proveedor" size="5" value="<?php echo $proveedor ?>" />
                                    <input name="buscar_proveedor" type="text" class="cajaGeneral" id="buscar_proveedor" size="10" title="Ingrese parte del nombre o el nro. de documento, luego presione ENTER." />&nbsp;
                                    <input type="hidden" name="ruc_proveedor" class="cajaGeneral" id="ruc_proveedor" size="10" maxlength="11" onblur="obtener_proveedor();" value="<?php echo $ruc_proveedor; ?>" onkeypress="return numbersonly(this,event,'.');" />
                                    <input type="text" name="nombre_proveedor" class="cajaGeneral cajaSoloLectura" id="nombre_proveedor" size="25" maxlength="50"  value="<?php echo $nombre_proveedor; ?>" />
                                    <!--<a href="<?php echo base_url(); ?>index.php/compras/proveedor/ventana_busqueda_proveedor/" id="linkVerProveedor"><img height='16' width='16' src='<?php echo base_url(); ?>/images/ver.png' title='Buscar' border='0' /></a>-->
                                    <a href="<?php echo base_url(); ?>index.php/compras/proveedor/ventana_selecciona_proveedor/" id="linkSelecProveedor"></a>
                                </td>
                            <?php } ?>
                            <td valign="middle">Moneda *</td>
                            <td valign="middle">
                                <select name="moneda" id="moneda" class="comboPequeno" style="width:150px;"><?php echo $cboMoneda; ?></select>
                            </td>
							<!--<td valign="middle">Guia remision *</td>-->
                            <td valign="middle">
							<label for="G"><img src="<?php echo base_url() ?>images/gremision.png" class="imgBoton" /></label>
							<input type="radio" name="referenciar" id="G" value="G" href="javascript:;" class="verDocuRefe" style="display:none;">
							<input type="hidden" id="dRef" name="dRef" >
							<div id="serieguiaver" name="serieguiaver" style="background-color: #cc7700; color:fff; padding:5px;display:none" ></div>
					
                            </td>
							<!--<td valign="middle">Doc. Recurrente*</td>-->
                            <td valign="middle">
							<label for="R"><img src="<?php echo base_url() ?>images/docrecurrente.png" class="imgBoton" /></label>
							<input type="radio" name="referenciar" id="R" value="R" href="javascript:;" class="verDocuRefe" style="display:none;">
							<div id="serieguiaverRecu" name="serieguiaverRecu" style="background-color: #cc7700; color:fff; padding:5px;display:none" ></div>
									
                            </td>
                        </tr>
                        <tr>
                            <td>TDC</td>
                            <td>
                                <input NAME="tdc" type="text" class="cajaGeneral cajaSoloLectura" id="tdc" size="3" value="<?php echo $tdc; ?>" onkeypress="return numbersonly(this,event,'.');" readonly="readonly" />
                                <span  <?php
                            if ($tipo_oper == 'C') {
                                echo 'style="display:none;"';
                            }
                            ?>>
                                   Vendedor <select name="vendedor" id="vendedor" class="comboMedio" style="width:208px;"><?php echo $cboVendedor; ?></select>
                                </span>
                            </td>
                            <td>Forma Pago</td>
                            <td><select name="forma_pago" id="forma_pago" class="comboMedio"><?php echo $cboFormaPago; ?></select></td>
                            <td>Almacen *</td>
                            <td><?php echo $cboAlmacen; ?></td>
                        </tr>
                    </table>
                </div>	
                <div id="frmBusqueda"  <?php echo $hidden; ?>>
                    <table class="fuente8" width="100%" cellspacing='0' cellpadding='3' border='0'>
                        <tr>
                            <td width="8%">
                                <select name="flagBS" id="flagBS" style="width:68px;" ass="comboMedio" onchange="limpiar_campos_producto()">
                                    <option value="B" selected="selected" title="Producto">P</option>
                                    <option value="S" title="Servicio">S</option>
                                </select>
                            </td>
                            <td width="37%">
                                <input name="producto" type="hidden" class="cajaGeneral" id="producto" />
                                <input name="buscar_producto" type="text" class="cajaGeneral" id="buscar_producto" size="10" title="Ingrese parte del nombre o el nro. de serie del producto, luego presione ENTER." />&nbsp;
                                <input name="codproducto" type="hidden" class="cajaGeneral" id="codproducto" size="10" maxlength="20" onblur="obtener_producto();" />
                                <input name="nombre_producto" type="text" class="cajaGeneral cajaSoloLectura" id="nombre_producto" size="39" readonly="readonly" />
                                <input name="stock" type="hidden" id="stock"/>
                                <input name="costo" type="hidden" id="costo" />
                                <input name="flagGenInd" type="hidden" id="flagGenInd" />
                                <!--<a href="<?php echo base_url(); ?>index.php/almacen/producto/ventana_busqueda_producto/" id="linkVerProducto"><img height='16' width='16' src='<?php echo base_url(); ?>/images/ver.png' title='Buscar' border='0' /></a>-->
                                <a href="<?php echo base_url(); ?>index.php/almacen/producto/ventana_selecciona_producto/" id="linkSelecProducto"></a>
                            </td>
                            <td width="6%">Cantidad</td>
                            <td width="24%">
                                <input name="cantidad" type="text" class="cajaGeneral" id="cantidad" size="3" maxlength="10" onkeypress="return numbersonly(this,event,'.');" />
                                <select name="unidad_medida" id="unidad_medida" class="comboMedio" <?php if ($tipo_oper == 'V') echo 'onchange="listar_precios_x_producto_unidad();"'; ?>><option value="0">::Seleccione::</option></select>
                            </td>
                            <td width="16%">
                                <select <?php if ($tipo_oper != 'V') echo 'style="display:none;"'; ?> name="precioProducto" id="precioProducto" class="comboPequeno" onchange="mostrar_precio();" style="width:84px;">
                                    <option value="0">::Seleccion::</option>
                                </select>
                                <input name="precio" type="text" class="cajaGeneral" id="precio" size="5" maxlength="10" onkeypress="return numbersonly(this,event,'.');" title="<?php if ($tipo_docu != 'B' && $tipo_docu != 'N' && $contiene_igv == true) echo 'Precio con IGV'; ?>" />
                            </td>
                            <td width="10%">
                                <div align="right"><a href="javascript:;" onClick="agregar_producto_comprobante();"><img src="<?php echo base_url(); ?>images/botonagregar.jpg" border="1" align="absbottom"></a></div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div id="frmBusqueda" style="height:250px; overflow: auto">
                    <table class="fuente8" width="100%" cellspacing="0" cellpadding="3" border="1" ID="Table1">
                        <tr class="cabeceraTabla">
                            <td width="3%"><div align="center">&nbsp;</div></td>
                            <td width="4%"><div align="center">ITEM</div></td>
                            <td width="9%"><div align="center">C&Oacute;DIGO</div></td>
                            <td width="36%"><div align="center">DESCRIPCI&Oacute;N</div></td>
                            <td width="15%"><div align="center">CANTIDAD</div></td>
                            <td width="6%"><div align="center">PU C/IGV</div></td>
                            <td width="6%"><div align="center">PU S/IGV</div></td>
							<td width="6%"><div align="center">PRECIO</div></td>
                            <!--<td width="6%"><div align="center">DSCTO</div></td>-->
                            <?php if ($tipo_docu != 'B' && $tipo_docu != 'N') { ?>
                                <td style="display:none;" width="6%"><div align="center">IGV</div></td>
                            <?php } ?>
                            <td width="6%" style="display:none;" ><div  align="center">IMPORTE</div></td>
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
                                    if (($indice + 1) % 2 == 0) {
                                        $clase = "itemParTabla";
                                    } else {
                                        $clase = "itemImparTabla";
                                    }
                                    ?>
                                    <tr id="<?php echo $indice ?>" t-doc="<?php echo $tipo_docu ?>" class="<?php echo $clase; ?>">
                                        <td width="3%"><div align="center"><font color="red"><strong><a href="javascript:;" onclick="eliminar_producto_comprobante(<?php echo $indice; ?>);"><span style="border:1px solid red;background: #ffffff;">&nbsp;X&nbsp;</span></a></strong></font></div></td>
                                        <td width="4%"><div align="center"><?php echo $indice + 1; ?></div></td>
                                        <td width="9%"><div align="center"><?php echo $codigo_interno; ?></div></td>
                                        <td><div align="left"><input type="text" class="cajaGeneral" style="width:390px;" maxlength="250" name="proddescri[<?php echo $indice; ?>]" id="proddescri[<?php echo $indice; ?>]" value="<?php echo $nombre_producto; ?>" /></div></td>
                                        <?php if ($tipo_docu != 'B' && $tipo_docu != 'N') { ?>
                                            <td width="12%"><div align="left"><input type="text" size="1" maxlength="10" class="cajaGeneral" name="prodcantidad[<?php echo $indice; ?>]" id="prodcantidad[<?php echo $indice; ?>]" value="<?php echo $prodcantidad; ?>" onblur="calcula_importe(<?php echo $indice; ?>);" onkeypress="return numbersonly(this,event,'.');" /><?php echo $nombre_unidad; ?>

                                                </div></td>
                                            <td width="6%"><div align="center"><input type="text" size="5" maxlength="10" class="cajaGeneral" name="prodpu_conigv[<?php echo $indice; ?>]" id="prodpu_conigv[<?php echo $indice; ?>]" value="<?php echo $prodpu_conigv; ?>" onblur="modifica_pu_conigv(<?php echo $indice; ?>);" onkeypress="return numbersonly(this,event,'.');" /></div></td>
                                            <td width="6%"><div align="center"><input type="text" size="5" maxlength="10" class="cajaGeneral" name="prodpu[<?php echo $indice; ?>]" id="prodpu[<?php echo $indice; ?>]" value="<?php echo $prodpu; ?>" onblur="modifica_pu(<?php echo $indice; ?>);" onkeypress="return numbersonly(this,event,'.');" />
                                                    <td width="6%"><div align="center"><input type="text" size="5" maxlength="10" class="cajaGeneral cajaSoloLectura" name="prodprecio[<?php echo $indice; ?>]" id="prodprecio[<?php echo $indice; ?>]" value="<?php echo $prodsubtotal; ?>" readonly="readonly" /></div></td>
                                                <?php } else { ?>
                                                    <td width="12%"><div align="left"><input type="text" size="7" maxlength="10" class="cajaGeneral" name="prodcantidad[<?php echo $indice; ?>]" id="prodcantidad[<?php echo $indice; ?>]" value="<?php echo $prodcantidad; ?>" onblur="calcula_importe(<?php echo $indice; ?>);" onkeypress="return numbersonly(this,event,'.');" /><?php echo $nombre_unidad; ?>
													</div></td>
                                                    <td width="6%"><div align="center"><input type="text" size="5" maxlength="10" class="cajaGeneral" name="prodpu_conigv[<?php echo $indice; ?>]" id="prodpu_conigv[<?php echo $indice; ?>]" value="<?php echo $prodpu_conigv; ?>" onblur="modifica_pu_conigv(<?php echo $indice; ?>);" onkeypress="return numbersonly(this,event,'.');" /></div></td>
                                                    <td width="6%"><div align="center"><input type="text" size="5" maxlength="10" class="cajaGeneral" name="prodpu[<?php echo $indice; ?>]" id="prodpu[<?php echo $indice; ?>]" value="<?php echo $prodpu; ?>" onblur="modifica_pu(<?php echo $indice; ?>);" onkeypress="return numbersonly(this,event,'.');" />
													<td width="6%"><div align="center"><input type="text" size="5" maxlength="10" class="cajaGeneral cajaSoloLectura" name="prodprecio[<?php echo $indice; ?>]" id="prodprecio[<?php echo $indice; ?>]" value="<?php echo $prodsubtotal; ?>" readonly="readonly" /></div></td>
                                          
													<td width="6%" style="display:none" ><div align="center"><input type="text" size="5" maxlength="10" class="cajaGeneral" name="prodprecio_conigv[<?php echo $indice; ?>]" id="prodprecio_conigv[<?php echo $indice; ?>]" value="<?php echo $prodsubtotal_conigv; ?>" readonly="readonly" /></div></td>
                                                <?php } ?>
                                                <?php if ($tipo_docu != 'B' && $tipo_docu != 'N') { ?>
                                                    <td width="6%" style="display:none;" >
                                                        <div align="center">  
                                                            <input type="text" size="5" class="cajaGeneral cajaSoloLectura" name="prodigv[<?php echo $indice; ?>]" id="prodigv[<?php echo $indice; ?>]" readonly="readonly" value="<?php echo $prodigv; ?>" />   
                                                        </div>
                                                    </td>
                                                <?php } ?>
                                                <td width="6%" style="display:none;" >
                                                    <div align="center">
														<input type="hidden" size="5" class="cajaGeneral cajaSoloLectura" name="prodigv[<?php echo $indice; ?>]" id="prodigv[<?php echo $indice; ?>]" readonly="readonly" value="<?php echo $prodigv; ?>" />   
                                                        <input type="hidden" name="detaccion[<?php echo $indice; ?>]" id="detaccion[<?php echo $indice; ?>]" value="m"/>
                                                        <input type="hidden" name="prodigv100[<?php echo $indice; ?>]" id="prodigv100[<?php echo $indice; ?>]" value="<?php echo $igv; ?>"/>
                                                        <input type="hidden" name="detacodi[<?php echo $indice; ?>]" id="detacodi[<?php echo $indice; ?>]" value="<?php echo $detacodi; ?>"/>
                                                        <input type="hidden" name="flagBS[<?php echo $indice; ?>]" id="flagBS[<?php echo $indice; ?>]" value="<?php echo $flagBS; ?>" />
                                                        <input type="hidden" name="prodcodigo[<?php echo $indice; ?>]" id="prodcodigo[<?php echo $indice; ?>]" value="<?php echo $prodproducto; ?>"/>
                                                        <input type="hidden"  name="produnidad[<?php echo $indice; ?>]" id="produnidad[<?php echo $indice; ?>]" value="<?php echo $unidad_medida; ?>"/>
                                                        <input type="hidden" name="flagGenIndDet[<?php echo $indice; ?>]" id="flagGenIndDet[<?php echo $indice; ?>]" value="<?php echo $GenInd; ?>" />
                                                        <input type="hidden" name="prodstock[<?php echo $indice; ?>]" id="prodstock[<?php echo $indice; ?>]" value=""/>
                                                        <input type="hidden" name="prodcosto[<?php echo $indice; ?>]" id="prodcosto[<?php echo $indice; ?>]" value="<?php echo $costo; ?>" />
                                                        <input type="hidden" name="proddescuento100[<?php echo $indice; ?>]" id="proddescuento100[<?php echo $indice; ?>]" value="<?php echo $descuento; ?>" />
                                                        <?php
                                                        if ($tipo_docu != 'B' && $tipo_docu != 'N') {
                                                            if ($tipo_oper == 'C') {
                                                                ?>
                                                                <input type="text" size="1"  class="proddescuento"  name="proddescuento[<?php echo $indice; ?>]" id="proddescuento[<?php echo $indice; ?>]" value="<?php echo $proddescuento; ?>" onblur="calcula_importe2(<?php echo $indice; ?>);" />
                                                            <?php } else {
                                                                ?>
                                                                <input type="hidden"  name="proddescuento[<?php echo $indice; ?>]" id="proddescuento[<?php echo $indice; ?>]" value="<?php echo $proddescuento; ?>" onblur="calcula_importe2(<?php echo $indice; ?>);" />   
                                                                <?php
                                                           }
                                                        } else {
                                                            ?>
                                                          <input type="hidden"  name="proddescuento[<?php echo $indice; ?>]" id="proddescuento[<?php echo $indice; ?>]" value="<?php echo $proddescuento; ?>" onblur="calcula_importe2(<?php echo $indice; ?>);" />   
                                                        <?php } ?>
                                                        <input type="text" size="5"  class="cajaGeneral cajaSoloLectura" name="prodimporte[<?php echo $indice; ?>]" id="prodimporte[<?php echo $indice; ?>]" readonly="readonly" value="<?php echo $prodtotal; ?>"/>
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
                    <table  width="100%" border="0" align="right" cellpadding=3 cellspacing=0 class="fuente8">
                        <tr>
                            <td width="80%" rowspan="5" align="left">
                                <table  width="100%" border="0" align="right" cellpadding=3 cellspacing=0 class="fuente8">
                                    <tr>
                                        <td width="14%" height="30">Modo de impresión</td>
                                        <td width="50%"><select name="modo_impresion" <?php if ($tipo_docu == 'B' || $tipo_docu == 'N') echo 'disabled="disabled"'; ?> id="modo_impresion" class="comboGrande" style="width:307px">
                                                <option <?php if ($modo_impresion == '1') echo 'selected="selected"'; ?> value="1">LOS PRECIOS DE LOS PRODUCTOS DEBEN INCLUIR IGV</option>
                                                <option <?php if ($modo_impresion == '2') echo 'selected="selected"'; ?> value="2">LOS PRECIOS DE LOS PRODUCTOS NO DEBEN INCLUIR IGV</option>
                                            </select>
                                        <!--stv  -->
                                        &nbsp;&nbsp;Num Ref Guia Remision&nbsp;<input class="cajaGeneral" name="docurefe_codigo" type="text" id="docurefe_codigo" size="14" maxlength="26" value="<?php echo $docurefe_codigo; ?>" />
                                        <!--  ////  -->


                                        </td>

                                        <td width="7%" style="display: none;">Estado</td>

                                        <td style="display: none;"><select name="estado" id="estado" class="comboPequeno">

                                                <option <?php if ($estado == '1') echo 'selected="selected"'; ?> value="1">Activo</option>

                                                <option <?php if ($estado == '0') echo 'selected="selected"'; ?> value="0">Anulado</option>

                                            </select></td>

                                    </tr>

                                    <tr>

                                        <td colspan="4">Observación</td>

                                    </tr>

                                    <tr>

                                        <td colspan="4"><textarea id="observacion" name="observacion" class="cajaTextArea" style="width:97%; height:70px;"><?php echo $observacion; ?></textarea></td>

                                    </tr>

                                </table>

                            </td>

                            <td width="10%" class="busqueda">Sub-total</td>

                            <?php if ($tipo_docu != 'B' && $tipo_docu != 'N' ) { ?>

                                <td width="10%" align="right"><div align="right"><input class="cajaTotales" name="preciototal" type="text" id="preciototal" size="12" align="right" <?php

                            if ($tipo_oper == 'V') {

                                echo 'readonly="readonly"';

                            }

                                ?> value="<?php echo round($preciototal, 2); ?>" onKeyPress="return numbersonly(this,event,'.');" ></div></td>

                                <?php } else { ?>

                               <td width="10%" align="right"><div align="right"><input class="cajaTotales" name="preciototal" type="text" id="preciototal" size="12" align="right" <?php

                                if ($tipo_oper == 'V'  ) {

                                    echo 'readonly="readonly"';

                                }

                                   ?> value="<?php echo round($preciototal, 2); ?>" onKeyPress="return numbersonly(this,event,'.');" ></div></td>

                                <?php } ?>

                        </tr>

                        <?php if ($tipo_oper == 'C') { ?>

                            <tr>

                                <td class="busqueda">Descto %</td>

                                <td align="right" width="10%"><input type="text" onchange="descuento_porcentaje()" name="porcentaje" id="porcentaje" class="cajaTotales" value="0" <?php

                        if ($tipo_oper == 'V') {

                            echo 'readonly="readonly"';

                        }

                            ?>  onKeyPress="return numbersonly(this,event,'.');" ></td>

                            </tr>

                        <?php } ?>

                        <tr>

                            <td class="busqueda">Descuento</td>

                            <?php if ($tipo_docu != 'B' && $tipo_docu != 'N') { ?>

                                <td align="right"><div align="right"><input class="cajaTotales" name="descuentotal" type="text" id="descuentotal" readonly=""  size="12" align="right"  value="<?php echo round($descuentotal, 2); ?>"></div></td>

                            <?php } else { ?>

                                <td align="right"><div align="right"><input class="cajaTotales" name="descuentotal_conigv" type="text" readonly="" id="descuentotal_conigv" size="12" align="right"  value="<?php echo round($descuentotal_conigv, 2); ?>"></div></td>

                            <?php } ?>

                        </tr>

                        <?php //if ($tipo_docu != 'B' && $tipo_docu != 'N') { ?>

                            <tr>

                                <td class="busqueda">IGV</td>

                                <td align="right"><div align="right"><input class="cajaTotales" name="igvtotal" type="text" id="igvtotal" size="12" align="right" <?php

                        if ($tipo_oper == 'V') {

                            echo 'readonly="readonly"';

                        }

                            ?> value="<?php echo round($igvtotal, 2); ?>" /></div></td>

                            </tr>

                        <?php // } ?>

                        <?php if ($tipo_oper == 'V') { ?>

                            <tr>

                                <td class="busqueda">VISA</td>

                                <td align="right"><div align="right"><input class="cajaTotales" name="visa" onchange="incremento_visa()" type="text" id="visa" size="12" align="right" value="<?php //echo round($igvtotal, 2); ?>" onKeyPress="return numbersonly(this,event,'.');" /></div></td>

                            </tr>

                        <?php } ?>

                        <tr>

                            <td class="busqueda">Precio Total</td>

                            <td align="right"><div align="right"><input class="cajaTotales" name="importetotal" type="text" id="importetotal" size="12" align="right" <?php

                        if ($tipo_oper == 'V') {

                            echo 'readonly="readonly"';

                        }

                        ?> value="<?php echo round($importetotal, 2); ?>"  onKeyPress="return numbersonly(this,event,'.');" /></div></td>

                        </tr>                                

                    </table>



                </div>	

                <br />

                <div id="botonBusqueda2" style="padding-top:20px;">

                    <img id="loading" src="<?php echo base_url(); ?>images/loading.gif"  style="visibility: hidden" />

                    <a href="javascript:;" id="grabarComprobante"><img src="<?php echo base_url(); ?>images/botonaceptar.jpg" width="85" height="22" class="imgBoton" ></a>

                    <a href="javascript:;" id="limpiarComprobante"><img src="<?php echo base_url(); ?>images/botonlimpiar.jpg" width="69" height="22" class="imgBoton" ></a>

                    <a href="javascript:;" id="cancelarComprobante"><img src="<?php echo base_url(); ?>images/botoncancelar.jpg" width="85" height="22" class="imgBoton" ></a>

                    <?php echo $oculto ?>

                </div>



            </div>

            <?php

            if ($cambio_comp == 1 && $total_det != 0) {

                if ($tipo_docu != "B" && $tipo_docu != "N") {

                    ?>

                    <script lang="javascript" type="text/javascript">

                        calcular_importe_todos(<?= $total_det ?>)

                    </script>

                    <?php

                } else {

                    ?>

                    <script lang="javascript" type="text/javascript">

                        modificar_pu_conigv_todos(<?= $total_det ?>)

                    </script>

                    <?php

                }

            }

            ?>

        </form>

        <a id="linkVerImpresion" href="#ventana"></a>

        <div id="ventana" style="display: none;" >

            <div id="imprimir" style="padding:20px; text-align: center">

                <span style="font-weight: bold;">

                    <?php if ($tipo_docu == 'F') echo 'FACTURA'; else echo 'BOLETA'; ?>

                    <br/>

                    <input type="text" name="ser_imp" id="ser_imp" readonly="readonly" style="border: 0px; font: bold 10pt helvetica;" value="fsd" class="cajaGeneral" maxlength="3" size="3">-

                    <input type="text" name="num_imp" id="num_imp" readonly="readonly" style="border: 0px; font: bold 10pt helvetica;" value="lknmlk" class="cajaGeneral" maxlength="10" size="10">

                </span>

                <br/>

                <a href="javascript:;" id="imprimirComprobante"><img src="<?php echo base_url(); ?>images/impresora.jpg" class="imgBoton"  alt="Imprimir"></a>

                <br/>

                <br/>

                <a href="javascript:;" id="cancelarImprimirComprobante"><img src="<?php echo base_url(); ?>images/botoncancelar.jpg" width="85" height="22" class="imgBoton" ></a>

            </div>      

        </div>

    </body>

</html>