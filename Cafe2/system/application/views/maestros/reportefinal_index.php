<script type="text/javascript"
	src="<?php echo base_url();?>js/jquery.metadata.js"></script>
<script type="text/javascript"
	src="<?php echo base_url();?>js/jquery.validate.js"></script>
<script type="text/javascript"
	src="<?php echo base_url();?>js/maestros/state.js"></script>
<script type="text/javascript"
	src="<?php echo base_url();?>js/colorpicker.js"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/colorPicker.css"  />
		
<script>

var base_url
jQuery(document).ready(function(){
    base_url   = $("#base_url").val();
    
   $("#nueva_reportefinal").click(function(){
	   
	   txtreportefinal = $("#txtreportefinal").val();
     	txtdescripcion = $("#txtdescripcion").val();
     	cbodocumento = $("#cbodocumento").val();
     	
      	 var url= "<?php echo base_url(); ?>index.php/maestros/state/guardar_reportefinal";
  		 $.ajax({url: url,type: "POST",
  			 data:{
  				 reportefinal:txtreportefinal,
  				descripcion:txtdescripcion,
  				cbodocumento:cbodocumento
  				 },
  		   dataType: "json",
  		    success: function(data){
  		    	$("#table_reportefinal").html("");

						fila ="<table border='2'>";
						fila+="<tr>";
						fila+="<td>NOMBRE</td>";
						fila+="<td>DOCUMENTO</td>";
						fila+="<td>DESCRIPCION</td>";
						fila+="</tr>";
  			 $.each(data, function (i, item) {

  						fila+="<tr>";
  						fila+="<td>"+item.nombre+"</td>";
  						fila+="<td>"+item.documento+"</td>";
  						fila+="<td>"+item.descripcion+"</td>";
  						fila+="</tr>";					
  						
  		     });
  						fila+="</table>";
				 $("#table_reportefinal").append(fila);
  		     }	
  		        
  		    }); 
		    

       
   });

});

</script>
<div id="pagina">
	<div id="zonaContenido">
		<div align="center">
			<div id="frmBusqueda">
				<form id="form_reportefinal" name="form_reportefinal" method="post">

					<table style="width: 100%;" cellspacing="10" cellpadding="5"
						border="0">
						<!-- Lo cambiaremos por CSS -->
						<tr>
							<td align='left'>Reporte Final</td>
							<td align='left'><input id="txtreportefinal" name="txtreportefinal" type="text" ></td>

							<td align='left' rowspan="2">Descripcion</td>
							<td align='left' rowspan="2">
								<textarea rows="5" cols="40" id="txtdescripcion" name="txtdescripcion"></textarea>
							</td>
						</tr>
						<tr>
							<td align='left'>Documento</td>
							<td align='left'><select id="cbodocumento" name="cbodocumento"><?php echo $cboDocumento; ?></select></td>

						</tr>
					</table>
				</form>
				
				
			</div>
			<div class="acciones">
				<div id="botonBusqueda">
					<ul id="limpiar_reportefinal" class="lista_botones">
						<li id="limpiar">Limpiar</li>
					</ul>
					<ul id="buscar_reportefinal" class="lista_botones">
						<li id="buscar">Buscar</li>
					</ul>
					<ul id="nueva_reportefinal" class="lista_botones">
						<li id="nuevo">Agregar State</li>
					</ul>
				</div>
				<div id="lineaResultado">
					<table class="fuente7" width="100%" cellspacing=0 cellpadding=3	border="0">
						<tr>
							<td width="50%" align="left">N de cargos encontrados:&nbsp;</td>
						</tr>
					</table>
				</div>
				<table border="2">
				<tr>
					<td>Nombre</td>
					<td>Documento</td>
					<td>Descripcion</td>
				</tr>
				</table>
				<div id="table_reportefinal"></div>
				
				
				
			</div>
			

		</div>
	</div>
</div>