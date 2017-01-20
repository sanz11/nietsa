<?php
$nombre_persona = $this->session->userdata('nombre_persona');
$persona        = $this->session->userdata('persona');
$usuario        = $this->session->userdata('usuario');
$url            = base_url()."index.php";
if(empty($persona)) header("location:$url");
?>
<html>
	<head>	
        <script type="text/javascript" src="<?php echo base_url();?>js/ventas/presupuesto.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
        <script language="javascript">
        
            $(document).ready(function(){
                $("a#linkVerCliente, a#linkVerProducto").fancybox({
                        'width'          : 700,
                        'height'         : 450,
                        'autoScale'	 : false,
                        'transitionIn'   : 'none',
                        'transitionOut'  : 'none',
                        'showCloseButton': true,
                        'modal'          : true,
                        'type'	     : 'iframe'
                });  
				  $(".enviarcorreo").fancybox({
                       'width'          : 670,
						'height'         : 420,
						'autoScale'      : false,
						'transitionIn'   : 'none',
						'transitionOut'  : 'none',
						'showCloseButton': true,
						'modal'          : false,
						'type'	     : 'iframe'
                });  
				 
				//agregado autocompletar gcbq
		  $("#nombre_producto").autocomplete({
             source: function(request, response){
                $.ajax({ 
					//contiene flagbs-bien o servicio	
                    //url: "<?php echo base_url(); ?>index.php/almacen/producto/autocomplete/"+$("#flagBS").val()+"/"+$("#compania").val(),
					
					url: "<?php echo base_url(); ?>index.php/almacen/producto/autocomplete/B/"+$("#compania").val(),
                    type: "POST",
                    data:  { term: $("#nombre_producto").val() },
                    dataType: "json", 
                    success: function(data){  response(data); }
                });
            }, 
            select: function(event, ui){
								$("#buscar_producto").val(ui.item.codinterno);
                $("#producto").val(ui.item.codigo)
                $("#codproducto").val(ui.item.codinterno);
            },

            minLength: 2

        });
		 
         $("#nombre_cliente").autocomplete({
		 source: function(request, response){
                $.ajax({  url: "<?php echo base_url(); ?>index.php/ventas/cliente/autocomplete/",
                    type: "POST",
                    data:  {  term: $("#nombre_cliente").val()},
                    dataType: "json", 
                    success: function(data){response(data);}
                });
            }, 

            select: function(event, ui){
                $("#buscar_cliente").val(ui.item.ruc)
                $("#cliente").val(ui.item.codigo);
                $("#ruc_cliente").val(ui.item.ruc);
            },

            minLength: 2

        });
						/////////////////7
            }); 
            function seleccionar_cliente(codigo,ruc,razon_social, empresa, persona){
                $("#cliente").val(codigo);
                $("#ruc_cliente").val(ruc);
                $("#nombre_cliente").val(razon_social);
            }
            function seleccionar_producto(codigo,interno,familia,stock,costo){
                $("#producto").val(codigo);
                $("#codproducto").val(interno);
                
                base_url   = $("#base_url").val();
                url          = base_url+"index.php/almacen/producto/listar_unidad_medida_producto/"+codigo;
                $.getJSON(url,function(data){
                      $.each(data, function(i,item){
                            nombre_producto = item.PROD_Nombre;
                      });
                      $("#nombre_producto").val(nombre_producto);
                });
            }
           
            var cursor;
            if (document.all) {
            // Está utilizando EXPLORER
            cursor='hand';
            } else {
            // Está utilizando MOZILLA/NETSCAPE
            cursor='pointer';
            }
			
			
		
        </script>		
	</head>
	<body>
	<br>
		<div id="pagina">
			<div id="zonaContenido">
			<div align="center">
				<div id="tituloForm" class="header"><?php echo $titulo_busqueda;?></div>
				<form id="form_busqueda" name="form_busqueda" method="post" action="<?php echo base_url();?>index.php/ventas/presupuesto/presupuestos">
                                    <div id="frmBusqueda" >
					<table class="fuente8" width="98%" cellspacing="0" cellpadding="3" border="0">
						<tr>
							<td align='left' width="10%">Fecha inicial</td>
							<td align='left' width="90%">
                                                            <input name="fechai" id="fechai" value="<?php echo $fechai; ?>" type="text" class="cajaGeneral" size="10" maxlength="10"/>
                                                            <img src="<?php echo base_url();?>images/calendario.png" name="Calendario1" id="Calendario1" width="16" height="16" border="0" onMouseOver="this.style.cursor='pointer'" title="Calendario"/>
                                                            <script type="text/javascript">
                                                                Calendar.setup({
                                                                    inputField     :    "fechai",      // id del campo de texto
                                                                    ifFormat       :    "%d/%m/%Y",       // formato de la fecha, cuando se escriba en el campo de texto
                                                                    button         :    "Calendario1"   // el id del botón que lanzará el calendario
                                                                });
                                                            </script>
                                                            <label style="margin-left: 90px;">Fecha final</label>
                                                            <input name="fechaf" id="fechaf" value="<?php echo $fechaf; ?>" type="text" class="cajaGeneral" size="10" maxlength="10" />
                                                            <img src="<?php echo base_url();?>images/calendario.png" name="Calendario2" id="Calendario2" width="16" height="16" border="0" onMouseOver="this.style.cursor='pointer'" title="Calendario2"/>
                                                            <script type="text/javascript">
                                                                Calendar.setup({
                                                                    inputField     :    "fechaf",      // id del campo de texto
                                                                    ifFormat       :    "%d/%m/%Y",       // formato de la fecha, cuando se escriba en el campo de texto
                                                                    button         :    "Calendario2"   // el id del botón que lanzará el calendario
                                                                });
                                                            </script>
                                                        </td>
						</tr>
						<tr>
                                                    <td align='left'>Número</td>
                                                    <td align='left'>
                                                        <?php 
                                                        switch($tipo_codificacion){
                                                            case '1': echo '<input type="text" name="numero" id="numero" value="'.$numero.'" class="cajaGeneral"size="10" maxlength="10"  />'; break;
                                                            case '2': echo '<input type="text" name="serie" id="serie" value="'.$serie.'" class="cajaGeneral" size="3" maxlength="10"  /> ';
                                                                      echo '<input type="text" name="numero" id="numero" value="'.$numero.'" class="cajaGeneral" size="10" maxlength="10"  /> '; break;
                                                            case '3': echo '<input type="text" name="codigo_usuario" id="codigo_usuario" value="'.$codigo_usuario.'" class="cajaGeneral" size="20" maxlength="50"  />'; break;
                                                        }
                                                        ?>
                                                    </td>
						</tr>
						<tr>
                                                    <td align='left'>Cliente</td>
                                                    <td align='left'>
                                                        <input type="hidden" name="cliente" value="<?php echo $cliente; ?>" id="cliente" size="5" />
                                                        <input type="text" name="ruc_cliente" value="<?php echo $ruc_cliente; ?>" class="cajaGeneral" id="ruc_cliente" size="10" maxlength="11" onblur="obtener_cliente();" onkeypress="return numbersonly(this,event,'.');" readonly="readonly" />
                                                        <input type="text" name="nombre_cliente" tabindex="-1" value="<?php echo $nombre_cliente; ?>"  class="cajaGrande cajaSoloLectura" id="nombre_cliente" size="40" onclick="document.form_busqueda.reset();" />
                                                        <a href="<?php echo base_url();?>index.php/ventas/cliente/ventana_busqueda_cliente/" id="linkVerCliente" tabindex="-1" ><img height='16' tabindex="-1" width='16' src='<?php echo base_url(); ?>/images/ver.png' title='Buscar' border='0' /></a>
                                                    </td>
						</tr>
						<tr>
                                                    <td align='left'>Artículo</td>
                                                    <td align='left'>
                                                        <input name="compania" type="hidden" id="compania" value="<?php echo $compania; ?>">
										<input name="producto" type="hidden" class="cajaPequena" id="producto" size="10" maxlength="11" />
										<input name="codproducto" type="text" class="cajaGeneral" id="codproducto" size="10" maxlength="20" value="<?php echo $codproducto; ?>" onblur="obtener_producto();" readonly="readonly" />
										<input name="buscar_producto" type="hidden" class="cajaGeneral" id="buscar_producto" size="40" />
										<input name="nombre_producto" type="text" value="<?php echo $nombre_producto; ?>" class="cajaGrande cajaSoloLectura" id="nombre_producto" size="40"  />
										                <a href="<?php echo base_url();?>index.php/almacen/producto/ventana_busqueda_producto/" id="linkVerProducto" tabindex="-1" ><img height='16' tabindex="-1" width='16' src='<?php echo base_url(); ?>/images/ver.png' title='Buscar' border='0' /></a>
                                                    </td>
						</tr>
					</table>
			  </div>
<div class="acciones">
			 	<div id="botonBusqueda"><!--<ul id="imprimirPresupuesto" class="lista_botones"><li id="imprimir">Imprimir</li></ul>-->
                                        <ul id="nuevaPresupuesto_factura" class="lista_botones"><li id="nuevo">Nuevo Presupuesto (General)</li></ul>
										<!--<ul id="nuevaPresupuesto_boleta" class="lista_botones"><li id="nuevo">Nuevo Presupuesto (Boleta)</li></ul>-->
                                        <ul id="limpiarPresupuesto" class="lista_botones"><li id="limpiar">Limpiar</li></ul>
                                        <ul onkeypress="{if (event.keyCode==13)fireMyFunction()}" id="buscarPresupuesto" class="lista_botones" tabindex="0"><li id="buscar">Buscar</li></ul> 
				</div>
			  <div id="lineaResultado">
			  <table class="fuente7" width="100%" cellspacing="0" cellpadding="3" border="0">
			  	<tr>
				<td width="50%" align="left">N de presupuestos encontrados:&nbsp;<?php echo $registros;?> </td>
			  </table>
				</div>
</div>
				<div id="cabeceraResultado" class="header"><?php echo $titulo_tabla;;?></div>
				<div id="frmResultado">
				<table class="fuente8" width="100%" cellspacing="0" cellpadding="3" border="0" ID="Table1">
                                <tr class="cabeceraTabla">
                                <td width="5%">ITEM</td>
                                <td width="5%">FECHA</td>
                                <td width="5%">SERIE</td>
                                <td width="5%">NUMERO</td>
                                <td width="7%">CODIGO</td>
                                <td width="26%">RAZON SOCIAL</td>
                                <td width="5%" >MENSAJE ENVIADOS</td>
                                <td width="10%">TOTAL</td>
								<td width="4%">ESTADO</td>
                                <td width="3%">&nbsp;</td>
                                <td width="3%">&nbsp;</td>
                                <td width="3%">&nbsp;</td>
                                <td width="3%">&nbsp;</td>
								<td width="3%">Enviar</td>
								<td width="3%">Eliminar</td>
                                <td width="3%">USUARIO</td>
                                </tr>					
                                <?php
                                if(count($lista)>0){
                                foreach($lista as $indice=>$valor){
                                  $class = $indice%2==0?'itemParTabla':'itemImparTabla';
                                ?>
                                <tr class="<?php echo $class;?>">
                                <td><div align="center"><?php echo $valor[0];?></div></td>
                                <td><div align="center"><?php echo $valor[1];?></div></td>
                                <td><div align="center"><?php echo $valor[2];?></div></td>
                                <td><div align="center"><?php echo $valor[3];?></div></td>
                                <td><div align="left"><?php echo strtoupper($valor[4]);?></div></td>
                                <td><div align="left"><?php echo $valor[5];?></div></td>
                                <td><div align="center" ><?php echo $valor[14];?></div></td>
                                <td><div align="right"><?php echo $valor[7];?></div></td>
                                <td><div align="center"><?php echo $valor[8];?></div></td>
                                <td><div align="center"><?php echo $valor[9];?></div></td>
                                <td><div align="center"><?php echo $valor[10];?></div></td>
                                <td><div align="center"><?php echo $valor[11];?></div></td>
                                <td><div align="center"><?php echo $valor[12];?></div></td>
								<td><div align="center"><?php echo $valor[13];?></div></td>
								<td><div align="center"><?php echo $valor[15];?></div></td>
                                <td><div align="center"><?php echo $valor[16];?></div></td>
                                </tr>
                                <?php
                                 }
                                }
                                else{
                                ?>
                                    <table width="100%" cellspacing="0" cellpadding="3" border="0" class="fuente8">
                                        <tbody>
                                            <tr>
                                              <td width="100%" class="mensaje">No hay ning&uacute;n registro que cumpla con los criterios de b&uacute;squeda</td>
                                            </tr>
                                        </tbody>
                                    </table>	
                                    <?php
                                    }
                                    ?>
				</table>
				</div>
				<div style="margin-top: 15px;"><?php echo $paginacion;?></div>
				<input type="hidden" id="iniciopagina" name="iniciopagina">
				<?php echo $oculto?>
			</form>
			</div>
		  </div>			
		</div>
	</body>
</html>