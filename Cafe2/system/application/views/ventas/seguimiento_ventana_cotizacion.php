<?php
$nombre_persona = $this->session->userdata('nombre_persona');
$persona = $this->session->userdata('persona');
$usuario = $this->session->userdata('usuario');

$url = base_url() . "index.php";
?>
<html>
    <head>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-ui-1.8.17.custom.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/funciones.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/ventas/presupuesto.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/ui-lightness/jquery-ui-1.8.18.custom.css" type="text/css"/>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/funciones.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-ui.custom.min.js"></script>
        <script type="text/javascript">
		$( function() {
    $( "#SEGUIPRE_FechaSistema" ).datepicker();
  } );
  	   
		function Guardar_seguimeinto_cotiz(){
		codigo=$("#PRESUP_Codigo").val();
		var base_url=$("#base_url").val();
		url=base_url+"index.php/ventas/presupuesto/gaurdar_seguimiento_cotizacion";
		dataString  = $('#frmPresupuestoseguimeinto').serialize();
				//alert(dataString);
        $.post(url,dataString,function(data){
        listarDetalle(codigo);			
        });						
		}
		function eliminar(codigo){
			codigo2=$("#PRESUP_Codigo").val();
		var base_url=$("#base_url").val();
		url=base_url+"index.php/ventas/presupuesto/eliminardetalleseguimi";
		dataString  = 'codigo='+codigo;
		$.post(url,dataString,function(data){
        	listarDetalle(codigo2);			
        });		
		}
function listarDetalle(codigo){
	 var base_url=$("#base_url").val();
	 		var table="";
	var url=base_url+"index.php/ventas/presupuesto/mostrar_seguimiento_table/"+codigo;
	//$("#tableDetalleSeguimeinto").html("");
	 $.getJSON(url, function(result){
	 	$.each(result, function(i, field){
	 		var primerMesanje=$("#primerMesanje").val();
	 		if(primerMesanje==1){
	 		table+='<tr><td width="6%">1</td><td width="20%" >Correo Enviado</td>';
	        table+='<td width="14%"></td><td width="50%"></td><td width="10%"></td>';
	 		}
			table+='<tr>';
			if(primerMesanje==1){
			table+='<td width="6%">'+(i+2)+'</td>';	
		}else{
			table+='<td width="6%">'+(i+1)+'</td>';
		}
			
			table+="<td width='20%' style='background-color: "+field.STATE_Color+"'>"+field.STATE_Estado+"</td>";
			table+="<td width='14%'>"+field.SEGUIPRE_FechaSistema+"</td>";
			table+="<td width='50%'>"+field.SEGUIPRE_Comentario+"</td>";
			table+='<td width="10%">';
		    table+='<a href="#" onclick="eliminar('+field.SEGUIPRE_Codigo+')">';
			table+='<img src="<?=base_url()?>images/eliminar.png" width="16" height="16" border="0" title="Eliminar">';
		    table+='</a></td>';
			table+='</tr>';
			$("#tableDetalleSeguimeinto").html(table);
        });
    });
}		
        </script>
    </head>
    <body >	       		        
        <div id="VentanaTransparente" style="width:100%;background:rgb(39, 39, 39);">
           <h4 style="color:white;text-align: center;"><?php echo $titulo; ?></h4>
        </div>
    <div id="VentanaTransparente" style="width:100%; height: 100%; background-color: #f5f5f5;float:left">
        <input type="text" name="base_url" id="base_url" value="<?=base_url()?>" hidden>
		<form id="frmPresupuestoseguimeinto" method="post" >
		<div hidden>Consultar : <input type="text" id="consultar" name="consultar" value="0" >
		Tipo : <input type="text" id="tipo" name="tipo" value="0" >
		</div>
		<input type="text" name="primerMesanje" id="primerMesanje" value="<?=$primerMesanje?>" hidden>
		<input name="COMPA_Codigo" type="hidden" id="COMPA_Codigo" value="<?php echo $compania; ?>" hidden>
		 <input type="hidden" value="<?php echo $codigo; ?>"  name="PRESUP_Codigo" id="PRESUP_Codigo" >
			<table border="0" width="100%" CELLPADDING="5">
				<tr>
					<td colspan="4">Comentario</td>
				</tr>
				<tr>
					<td colspan="4"><textarea id="SEGUIPRE_Comentario" name="SEGUIPRE_Comentario" style="width:100%;height:100px;float:left;"></textarea></td>					
				</tr>
				<tr>
					<td>State</td>
					<td><select name="STATE_Codigo" id="STATE_Codigo"><?=$listState?></select></td>
					<td>Reporte Final</td>
					<td><select name="reportefinal" id="reportefinal"><?php  echo $cbreportefinal; ?></select></td>
				</tr>
				<tr>
									<td>Fecha</td>
					<td><input name="SEGUIPRE_FechaSistema" id="SEGUIPRE_FechaSistema" type="text" name="" value="<?=$hoy?>"></td>
				</tr>
			</table>
			<a onclick="Guardar_seguimeinto_cotiz()" style="cursor: pointer;float:right;margin-right:10px;" id="enviarcorreo" >
				<img src="<?php echo base_url(); ?>images/botonaceptar.jpg">
				</a>
					<img id="loading" src="<?php echo base_url(); ?>images/loading.gif"  style="visibility: hidden" />
		<a onclick="javascript:parent.$.fancybox.close();" style="cursor: pointer;float:right;margin-right:10px;"  >
			<img src="<?php echo base_url(); ?>images/botoncancelar.jpg">
		</a>
		
        <table width="100%" style="background-color: #3b3b3b;color: white" >
        	<tr>
        	<td width="6%">ITEM</td>
        	<td width="20%">ESTADO</td>
        	<td width="14%">FECHA</td>
        	<td width="50%">COMETARIO</td>
        	<td width="10%">ESTADO</td>          	
        	</tr>
        </table>
        <table width="100%" id="tableDetalleSeguimeinto">
        <?php
if($primerMesanje==1){
	?>
 <tr>
	<td width="6%">1</td>
	<td width="20%" >Correo Enviado</td>
	<td width="14%"></td>
	<td width="50%"></td>	
	<td width="10%">
		
	</td>	
</tr>
	<?php
}
        ?>
       
        	<?php
if (count($listTable)) {
	foreach ($listTable as $key => $value) {
		?>
<tr>
 <?php
if($primerMesanje==1){
	?>
	<td width="6%"><?=($key+2)?></td>
	<?php	
	}else{
		?>
<td width="6%"><?=($key+1)?></td>
		<?php
		}
		?>
	<td width="20%" style="background-color: <?=$value->STATE_Color?>"><?=$value->STATE_Estado?></td>
	<td width="14%"><?=$value->SEGUIPRE_FechaSistema?></td>
	<td width="50%"><?=$value->SEGUIPRE_Comentario?></td>	
	<td width="10%">
		<a href="#" onclick="eliminar(<?=$value->SEGUIPRE_Codigo?>)">
			<img src="<?=base_url()?>images/eliminar.png" width="16" height="16" border="0" title="Eliminar">
		</a>
	</td>	
</tr>
		<?php
	}
}
        	?>
        </table>

			</form>
	</div>
    </body>
</html>