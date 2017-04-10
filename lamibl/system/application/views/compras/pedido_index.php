<?php
$nombre_persona = $this->session->userdata('nombre_persona');
$persona        = $this->session->userdata('persona');
$usuario        = $this->session->userdata('usuario');
$url            = base_url()."index.php";
if(empty($persona)) header("location:$url");
?>

<script type="text/javascript" src="<?php echo base_url();?>js/jquery.js"></script>	
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.metadata.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.validate.js"></script>			
<script type="text/javascript" src="<?php echo base_url();?>js/compras/pedido.js"></script>

<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script language="javascript">

$(document).ready(function(){
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
	                $("#ruc_cliente").val(ui.item.ruc)
	                $("#cliente").val(ui.item.codigo);
	                $("#nombre_cliente").val(ui.item.nombre);
	            },

	            minLength: 2

	        });
});
</script>		
<div id="pagina">
    <div id="zonaContenido">
                <div align="center">
                        <div id="tituloForm" class="header">Buscar PEDIDO </div>
                        <div id="frmBusqueda">
                        <form id="form_busqueda" name="form_busqueda" method="post" action="<?php echo $action;?>">
                            <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
                                    <tr>
                                            <td width="16%">Numero de  O. Pedido </td>
                                            <td width="68%"><input id="txtNumDoc" type="text" class="cajaPequena" NAME="txtNumDoc" maxlength="15" value="<?php echo $numdoc; ?>" onkeypress="return numbersonly(this,event,'.');">
                                            <td width="5%">&nbsp;</td>
                                            <td width="5%">&nbsp;</td>
                                            <td width="6%" align="right"></td>
                                    </tr>
                                    <tr>
                                           <td align='left'>Cliente</td>
                                           <td align='left'>
                                              <input type="hidden" name="cliente" value="<?php echo $cliente; ?>" id="cliente" size="5" />
                                              <input type="text" name="ruc_cliente" value="<?php echo $ruc_cliente; ?>" class="cajaGeneral" id="ruc_cliente" size="10" maxlength="11"  onkeypress="return numbersonly(this,event,'.');" readonly="readonly" />
                                              <input type="text" name="nombre_cliente" tabindex="-1" value="<?php echo $nombre_cliente; ?>"  class="cajaGrande cajaSoloLectura" id="nombre_cliente" size="40" />
                                           </td>
                                    </tr>
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
                                     
                            </table>
                        </form>
                  </div>
                  <div class="acciones">
                    <div id="botonBusqueda">
                           <ul id="imprimirPedido" class="lista_botones"><li id="imprimir">Imprimir</li></ul>
                           <ul id="nuevoPedido" class="lista_botones"><li id="nuevo">Nuevo Pedido</li></ul>
                           <ul id="limpiarPedido" class="lista_botones"><li id="limpiar">Limpiar</li></ul>
                           <ul id="buscarPedido" class="lista_botones"><li id="buscar">Buscar</li></ul>
                    </div>
                  <div id="lineaResultado">
                      <table class="fuente7" width="100%" cellspacing=0 cellpadding=3 border="0">
                            <tr>
                            <td width="100%" align="left">N de pedidos encontrados:&nbsp;<?php echo $registros;?> </td>
                            <td width="50%" align="right">&nbsp;</td>
                      </table>
                  </div>
                  </div>
                        <div id="cabeceraResultado" class="header">
                                <?php echo $titulo_tabla; ?> </div>

                      
                        <div id="frmResultado">
                        <table class="fuente8" width="100%" cellspacing="0" cellpadding="3" border="0" ID="Table1">
                                        <tr class="cabeceraTabla">
                                                <td width="8%">ITEM</td>
												<td width="8%">SERIE</td>
												 <td width="8%">NUMERO</td>
												<td width="30%">RAZON SOCIAL</td>
                                                <td width="20%">OBRA</td>
                                                <td width="8%">PRESUPUESTO</td>
                                                <td width="5%">&nbsp;</td>
                                                <td width="5%">&nbsp;</td>
                                                 <td width="5%">ACCIONES</td>
                                                <td width="5%">&nbsp;</td>
                                        </tr>
                                        <?php
                                        $i=1;
                                        if(count($lista)>0){
                                        foreach($lista as $indice=>$valor){
                                                $class = $indice%2==0?'itemParTabla':'itemImparTabla';
                                                ?>
                                                <tr class="<?php echo $class;?>">
                                                        <td><div align="center"><?php echo $valor[0];?></div></td>
                                                        <td><div align="left"><?php echo $valor[1];?></div></td>
														 <td><div align="left"><?php echo $valor[2];?></div></td>
                                                        <td><div align="center"><?php echo $valor[3];?></div></td>
                                                        <td><div align="center"><?php echo $valor[4];?></div></td>
                                                        <?php if($valor[9]!="-"){?>
                                                        <td><div align="center" style="color:white; background:blue; padding:1px 0; cursor:no-drop;"><?php echo $valor[9];?></div></td>
                                                         <?php }else{?>
                                                        	<td><div align="center"></div></td>
                                                           <?php }?>   
                                                        <?php if($valor[8]==1){?>
                                                        	<td><div align="center"><?php echo $valor[5];?></div></td>
                                                        <?php }else{?>
                                                        	<td><div align="center"></div></td>
                                                           <?php }?>
                                                        <td><div align="center"><?php echo $valor[10];?></div></td>
                                                        <td><div align="center"><?php echo $valor[6];?></div></td>
                                                        <td><div align="center"><?php echo $valor[7];?></div></td>
                                                        
                                                </tr>
                                                <?php
                                                $i++;
                                                }
                                        }
                                        else{
                                        ?>
                                        <table width="100%" cellspacing="0" cellpadding="3" border="0" class="fuente8">
                                                <tbody>
                                                        <tr>
                                                            <td width="100%" class="mensaje">No hay ning&uacute;n pedido que cumpla con los criterios de b&uacute;squeda</td>
                                                        </tr>
                                                </tbody>
                                        </table>
                                        <?php
                                        }
                                        ?>
                        </table>
                        <input type="hidden" id="iniciopagina" name="iniciopagina">
                        <input type="hidden" id="cadena_busqueda" name="cadena_busqueda">
                </div>
            <div style="margin-top: 15px;"><?php echo $paginacion;?></div>
            <input type="text" style="visibility:hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
        </div>
    </div>
</div>