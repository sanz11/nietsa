<link rel="stylesheet" href="<?php echo base_url(); ?>css/ui-lightness/jquery-ui-1.8.18.custom.css" type="text/css"/>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-ui-1.8.17.custom.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/funciones.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/estilos.css" type="text/css"/>
<!-- Calendario -->
<script type="text/javascript" src="<?php echo base_url(); ?>js/calendario/calendar.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/calendario/calendar-es.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/calendario/calendar-setup.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/calendario/calendar-win2k-2.css" type="text/css" media="all"
      title="win2k-cold-1"/>

<!-- Calendario -->


<script type="text/javascript" src="<?php echo base_url(); ?>js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>js/fancybox/jquery.fancybox-1.3.4.css"
      media="screen"/>
<style>
    .cajaPadding {

        padding: 2px 10px;

    }

    .tb_listado td {

        padding-top: 1px;

        padding-bottom: 1px;

    }

    input, select {

        margin: 0;

        height: 22px !important;

    }

    .tb_titulo {

        font-weight: bold;

        padding-left: 20px;

        text-align: right;

        padding-right: 20px;
        text-transform: uppercase;

    }

    .cajaCalendar {

        width: 90px !important;

        cursor: pointer;

        background: url('<?php echo base_url(); ?>images/calendar.png') #FFF 70px center no-repeat;

    }

    #agregar_ {
        padding: 3px 10px;
        color: #FFF;
        font-weight: bold;
        font-size: 11px;
        font-family: Arial;
        border-radius: 4px;
        background: #727272;
        margin-left: 6px;
        cursor: pointer;

    }

    #agregar_:hover {
        background: #000;
    }

    .cajaBusquedaGrande {

        width: 300px;

        cursor: pointer;

        padding-right: 25px !important;

        background: url('<?php echo base_url(); ?>images/search.png') #FFF 280px center no-repeat;

    }

    .tb_detalle {
        margin: 0 auto;
        border-collapse: collapse;

    }

    .tb_detalle thead td {
        padding: 4px 5px;
        border: 1px solid #000;
    }

    .ui-autocomplete {
        padding: 0;
        margin: 0;
        width: 500px;
        list-style: none;
    }

    .ui-autocomplete a {
        color: #000;
        font-family: Arial;
        font-size: 8pt;
        display: block;
        padding: 4px 10px;
    }

    .ui-autocomplete a:hover {
        color: #000;
        font-weight: bold;;

    }

    .ui-state-hover {
        background: black !important;
        color: #FFF !important;
        border: 0px !important;
    }

    #tituloForm, #frmBusqueda {
        width: 796px;
    }

</style>
<div id="pagina">
    <div id="zonaContenido">
        <script>

            $(document).ready(function () {
            	base_url = $("#base_url").val();
                busqueda(0);

                $('#cancelarEnfermedad').click(function () {
                    parent.$.fancybox.close();
                });

                $('#grabarEnfermedad').click(function () {

                });

//                 $('#cantidad').keypress(function (e) {
//                     if (e.which == 13) {
//                         agregar_recurso();
//                     }
//                 });

                $('#cantidad').bind('blur', function (e) {
                    flagGenInd = $("#flagGenInd").val();
                    if (flagGenInd == 'I') {
                        ventana_producto_serie_1();
                    }
                });




                
            });

            function busqueda_producto() {
                $("#productoDescripcion").autocomplete({
                    source: function (request, response) {

                        $.ajax({

                            url: "<?php echo base_url(); ?>index.php/almacen/inventario/encuentrax_producto",

                            type: "POST",
                            data: {
                                term: $("#productoDescripcion").val(),
                                codigoInventario:$("#cod_inventario").val()
                            },
                            dataType: "json",
                            success: function (data) {
                                response(data);
                            },
                            error: function (data) {
                                alert("consulte con el administrador");
                            }
                        });
                    },
                    select: function (event, ui) {
                        $("#cod_producto").val(ui.item.codigo);
                        $("#producto").val(ui.item.codigo);
                        $("#flagGenInd").val(ui.item.flagGenInd);
                        $("#cantidad").focus();
                        $("#cantidad").select();
                        // busqueda_producto(n);
                        // return false;
                    },
                    minLength: 1
                });
            }

            /**
             * Metodo para ejecutar todos los productos inventados
             * @param c_pag
             */
            function busqueda(c_pag) {

                var url = '<?php echo base_url(); ?>index.php/almacen/inventario/cargar_detalle/<?php echo $cod_inventario; ?>/' + c_pag;
                //var dataString = $('#frmGuardar').serialize();

                $.ajax({
                    type: "GET",
                    url: url,
                    beforeSend: function (data) {
                        $('#cargando_datos').show();
                    },
                    error: function (data) {
                        $('#cargando_datos').hide();
                        alert('No se puedo completar la operaciï¿½ï¿½n - Revise los campos ingresados.')
                    },
                    success: function (data) {
                        $('#divResultado').html(data);
                        $('#cargando_datos').hide();

                    }
                });
            }

            function paginacion_jquery(url) {
                var parts = url.split("/");
                var c_pag = parts[parts.length - 1];
                busqueda(c_pag);
            }


            function modificar_detalle(cod_detalle, ubicacion) {
                var url = '<?php echo base_url() ?>index.php/almacen/inventario/editar_detalle/';
                var cantidad = $('#c_' + ubicacion).find('.detalle_cantidad').val();
                var costo = $('#c_' + ubicacion).find('.detalle_costo').val();

                producto = "prodcodigo["+ubicacion+"]"
                flagGI = "flagGenInd["+ubicacion+"]";
				var codigoProducto=document.getElementById(producto).value;
				var flagGenInd=document.getElementById(flagGI).value;
				isSalir=false;
				if(flagGenInd=='I'){
				/**verificamos si las cantidades son iguales que las series**/

					isResultadoVerificacion=verificarCantidadProductoSerie(ubicacion,cantidad);
					if(isResultadoVerificacion){
						if(confirm("cantidad por producto y serie no coinciden. Desea continuar de todas maneras?")){
	                 		isSalir=false;
	                 	}else{
	                 		isSalir=true;
	                 	}
					}

				}
				/***fin de verificacion***/
	
				if(isSalir==false){
	                var dataString ='cod_detalle='+cod_detalle+'&cantidad='+cantidad+'&cod_inventario=<?php echo $cod_inventario; ?>&p_costo='+costo+'&codigoProducto='+codigoProducto+'&flagGenInd='+flagGenInd+'&codigoAlmacen=<?php echo $codigoAlmacen; ?>';
					$.ajax({
	                    type: "POST",
	                    url: url,
	                    async: false,
	                    data: dataString,
	                    beforeSend: function (data) {
	                        $('#cargando_datos').show();
	                    },
	                    error: function (data) {
	                        $('#cargando_datos').hide();
	                        alert('No se puedo completar la operaciï¿½ï¿½n - Revise los campos ingresados.')
	                    },
	                    success: function (data) {
	                        $('#cargando_datos').hide();
	                        $('#divResultado').html(data)
	                    }
	                });



				}    
            }

            function eliminar_detalle(cod_detalle,ubicacion) {


                var rpta = confirm('MENSAJE: Esta seguro(a) de eliminar este registro?');

                if (rpta === false)
                    return false;
                producto = "prodcodigo["+ubicacion+"]"
                flagGI = "flagGenInd["+ubicacion+"]";
				var codigoProducto=document.getElementById(producto).value;
				var flagGenInd=document.getElementById(flagGI).value;
				
                var url = '<?php echo base_url() ?>index.php/almacen/inventario/eliminar_detalle/';
                var dataString = 'cod_detalle=' + cod_detalle + '&cod_inventario=<?php echo $cod_inventario; ?>'+'&codigoProducto='+codigoProducto+'&flagGenInd='+flagGenInd+'&codigoAlmacen=<?php echo $codigoAlmacen; ?>';

                $.ajax({
                    type: "POST",
                    url: url,
                    data: dataString,
                    //       dataType: "json",
                    beforeSend: function (data) {
                        $('#cargando_datos').show();
                    },
                    error: function (data) {
                        console.log(data);
                        $('#cargando_datos').hide();
                        alert('No se puedo completar la operacion - Revise los campos ingresados.')
                    },
                    success: function (data) {
                        $('#cargando_datos').hide();
                        $('#divResultado').html(data)
                    }
                });
            }


            function generar_movimiento(cod_detalle,ubicacion) {
            	var cantidad = $('#c_' + ubicacion).find('.detalle_cantidad').val();
                var costo = $('#c_' + ubicacion).find('.detalle_costo').val();

                producto = "prodcodigo["+ubicacion+"]"
                flagGI = "flagGenInd["+ubicacion+"]";
 				var codigoProducto=document.getElementById(producto).value;
 				var flagGenInd=document.getElementById(flagGI).value;
 				isSalir=false;
            	if(flagGenInd=='I'){
    				/**verificamos si las cantidades son iguales que las series**/
					isResultadoVerificacion=verificarCantidadProductoSerie(ubicacion,cantidad);
	    			if(isResultadoVerificacion){
		    			alert("cantidad por producto y serie no coinciden.");
	                 	isSalir=true;
	                 }   

    			}
    			/***fin de verificacion***/

            	if(isSalir==false){
	                	
	                var rpta = confirm('MENSAJE: Esta seguro(a) de generar los movimientos para este articulo?');
	
	                if (rpta === false)
	                    return false;
	
	
	                
	                var url = '<?php echo base_url() ?>index.php/almacen/inventario/generar_movimiento/' + cod_detalle + '/<?php echo $cod_inventario ?>';
	                // var dataString = 'cod_detalle='+cod_detalle+'&cod_inventario=<?php echo $cod_inventario; ?>';
	
	                $.ajax({
	                    type: "GET",
	                    url: url,
	                    async: false,
	                    // data: dataString,
	                    //       dataType: "json",
	                    beforeSend: function (data) {
	                        $('#cargando_datos').show();
	                    },
	                    error: function (data) {
	                        alert(data);
	                        console.log(data);
	                        $('#cargando_datos').hide();
	                        alert('No se puedo completar la operaciï¿½ï¿½n - Revise los campos ingresados.')
	                    },
	                    success: function (data) {
	                        $('#cargando_datos').hide();
	                        $('#divResultado').html(data)
	                    }
	                });
            	}
            }




			/**gcbq verificacion de cantidad mismo que la cantidad de series**/
			function verificarCantidadProductoSerie(ubicacion,cantidad){
				 	producto = "prodcodigo["+ubicacion+"]"
	                flagGI = "flagGenInd["+ubicacion+"]";
	                codigoAlmacen="almacenProducto["+ubicacion+"]";
	                isValor=false;
					var codigoProducto=document.getElementById(producto).value;
					var flagGenInd=document.getElementById(flagGI).value;
					var codigoAlmacenReal=document.getElementById(codigoAlmacen).value;
					if(flagGenInd=='I'){
					/**verificamos si las cantidades son iguales que las series**/
						urlVerificacion = base_url + "index.php/ventas/comprobante/verificacionCantidadJson";
		                $.ajax({
		                    type: "POST",
		                    async: false,
		                    url: urlVerificacion,
		                    data: {valorProductoJ:codigoProducto,valorCantidadJ:cantidad,almacen:codigoAlmacenReal},
		                    beforeSend: function (data) {
		                    },  
		                    error: function (data) {
		                        $('img#loading').css('visibility', 'hidden');
		                        console.log(data);
		                        alert('No se puedo completar la operación - Revise los campos ingresados.')
		                    },
		                    success: function (data) {
		                        $('img#loading').css('visibility', 'hidden');
		                        if(data==0){
			                        isValor=true;
		                        	return false;
		                        }else{
		                        	isValor=false;
		                        	return false;
		                        }		
		                    }
		                 });

					}
					return isValor;
					/***fin de verificacion***/
			}		



            

            function agregar_recurso() {

                var codigo = $('#cod_producto').val();
                var cantidad = $('#cantidad').val();
                var costo = $('#p_costo').val();
                
                var codigoAlmacen = $('#almacen').val();
                
                if (codigo === '') {
                    alert('ERROR: No se ha seleccionado un producto valido.');
                    return false;
                }

                if (cantidad === '' || cantidad === 0) {
                    alert('ERROR: No se ha ingesado una cantidad valida.');
                    return false;
                }

                if(costo <= 0 || costo == null || isNaN(costo)){
                	costo=0;
                   // alert('ERROR: No puede ingresar el costo, vuelva a intentarlo.');
                  //  return false;
                }


                var url = $('#frmGuardar').attr('action');
                var dataString = $('#frmGuardar').serialize();
                /**vamos al metodo de producto serie para eliminar el de la secciontemporal y agregar el de la seccion Real**/
                var urlPrevio = base_url+"index.php/almacen/producto/agregarSeriesProductoSessionReal/"+codigo+"/"+codigoAlmacen;
                $.ajax({
                    type: "GET",
                    url: urlPrevio,
                    async: false,
                    beforeSend: function (data) {
                        $('#cargando_datos').show();
                    },
                    success: function (data) {
                    }
                });
                
                $.ajax({
                    type: "POST",
                    url: url,
                    async: false,
                    data: dataString,
                    //       dataType: "json",
                    beforeSend: function (data) {
                        $('#cargando_datos').show();
                    },
                    error: function (data) {
                        console.log("Error");
                        $('#cargando_datos').hide();
                        alert('No se puedo completar la operacion - Revise los campos ingresados.');
                    },
                    success: function (data) {
                        console.log("grabo");
                        $('#producto').val("");
                        $('#cod_producto').val("");
                        $('#productoDescripcion').val("");
                        $('#cantidad').val("");
                        $('#p_costo').val("");
                        $('#flagGenInd').val("");
                        $('#cargando_datos').hide();
                        $('#divResultado').html(data);
                    }
                });
                $('#producto').focus();
                $('#producto').select();
            }

        </script>

        <div align="center">
            <div id="tituloForm" class="header"><?php echo $titulo; ?></div>
            <div id="frmBusqueda">
             <input name="base_url" type="hidden" id="base_url" value="<?php echo base_url(); ?>" />
             
             
              <input type="hidden" name="tipo_oper" id="tipo_oper" value="<?php echo $tipo_oper;?>" />
                <table class="" border="0" style="width: 100%; font: 12px helvetica">
                    <tr>
                        <td style="width: 10%; text-align: left" class="">
                            Nro. Documento:
                        </td>
                        <td style="width: 30%; text-align: left">
                            <input type="text" style="width: 40px;" class="cajaPadding cajaPequena" name="serie"
                                   id="serie" readonly="" value="<?php echo $serie; ?>">
                            <input type="text" style="width: 60px;" class="cajaPadding cajaPequena" name="numero"
                                   id="numero" readonly="" value="<?php echo $numero; ?>">
                        </td>
                        <td style="width: 20%; text-align: left">
                            Fecha Inicio:
                            <input name="fecha_inicio" value="<?php echo $fecha_registro ?>" readonly="" type="text"
                                   class="cajaPequena cajaCalendar cajaPadding" id="fecha_inicio"
                                   readonly="readonly"/>
                        </td>
                    </tr>

                    <tr>
                        <td style="text-align: left">
                            Titulo:
                        </td>
                        <td colspan="5">
                            <input style="width: 300px" value="<?php echo $titulo; ?>" name="titulo" readonly=""
                                   id="titulo" type="text" class="cajaPadding cajaGrande">
                        </td>
                    </tr>
                </table>

                <form id="frmGuardar" method="post" action="<?php echo $action; ?>">
                
                    <table class="" border="0" style="width: 100%; font: 12px helvetica">
                        <tr>
                            <td style="width: 17%; text-align: left">
                                Producto:
                            </td>
                            <td colspan="3">
                                <input type="hidden" name="cod_inventario" id="cod_inventario"
                                       value="<?php echo $cod_inventario ?>">
                                <input name="almacen" type="hidden" id="almacen" value="<?php echo $codigoAlmacen; ?>" />
                                <input type="hidden" id="almacenProducto" value="<?php echo $codigoAlmacen; ?>" />
                                
                                <input type="hidden" name="cod_producto" id="cod_producto" value="">
                                <input type="hidden" name="producto" id="producto" value="">
								<input name="flagGenInd" type="hidden" id="flagGenInd"/>
                                <input type="text" name="productoDescripcion"
                                       onfinishinput="busqueda_producto();"
                                       value="" id="productoDescripcion"
                                       class="cajaGrande cajaPadding cajaBusquedaGrande">
                
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: left">
                                Cantidad:
                            </td>
                            <td>
                                <input type="text" id="cantidad" name="cantidad" style="width: 50px"
                                       class="cajaPadding cajaPequena">
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: left">
                                P./Costo:
                            </td>
                            <td>
                                <input type="text" id="p_costo" name="p_costo" style="width: 50px"
                                       class="cajaPadding cajaPequena">
                            </td>
                            <td width="40%">
                                <a href="javascript:;"
                                   onclick="agregar_recurso();">
                                    <img src="<?php echo base_url(); ?>images/botonagregar.jpg"
                                         border="1" align="absbottom">
                                </a>
                            </td>
                            <td width="20%">
                                <a href="#" id="cerrar_inventario_input"><img
                                        src="<?php echo base_url(); ?>images/botoncancelar.jpg"
                                        width="85" height="22" border="1"></a>
                            </td>
                        </tr>
                    </table>
                </form>
                <table style="position: relative; height: 310px; vertical-align: top; width: 100%">
                    <tr>
                        <td colspan="3">
                            <div id="cargando_datos" style="display: none;position: absolute;

                                     width: 100%; height: 100%; left: 0; top: 0px;

                                     z-index: 9999">

                                <div align="center" style="background: #FFF;

                                         z-index: 9999;

                                         position: relative;

                                         top: 40%; margin: 0 auto; width: 140px; height: 32px;padding: 30px 40px; border: 1px solid #cccccc;"
                                     class="fuente8">

                                    <b>ESPERE POR FAVOR...</b><br>

                                    <img src="<?php echo base_url() ?>images/cargando.gif" border='0'/>

                                </div>

                            </div>
                            <div id="divResultado">
                                <table class="">
                                    <thead>
                                    <tr class="">
                                        <td style="width: 50px">ITEM</td>
                                        <td style="width: 550px;">ARTICULO</td>
                                        <td style="width: 70px">CANTIDAD</td>
                                        <td style="width: 20px"></td>
                                        <td style="width: 20px"></td>
                                        <td style="width: 20px"></td>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>

                </table>
            </div>
        </div>
    </div>
</div>