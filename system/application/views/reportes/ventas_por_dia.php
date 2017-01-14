<?php

  
  function getMes($mes)
  {
    $mes = str_pad((int) $mes,2,"0",STR_PAD_LEFT);
    switch ($mes) 
    {
        case "01": return "ENE";
        case "02": return "FEB";
        case "03": return "MAR";
        case "04": return "ABR";
        case "05": return "MAY";
        case "06": return "JUN";
        case "07": return "JUL";
        case "08": return "AGO";
        case "09": return "SET";
        case "10": return "OCT";
        case "11": return "NOV";
        default: return "DIC";
    }
  }
  
  function getMonths($start, $end) {
      $startParsed = date_parse_from_format('Y-m-d', $start);
      $startMonth = $startParsed['month'];
      $startYear = $startParsed['year'];

      $endParsed = date_parse_from_format('Y-m-d', $end);
      $endMonth = $endParsed['month'];
      $endYear = $endParsed['year'];

      return ($endYear - $startYear) * 12 + ($endMonth - $startMonth) + 1;
  }
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script>
  $(document).ready(function(){
      base_url = $("#base_url").val();
    $(".fuente8 tbody tr:odd").addClass("itemParTabla");
    $(".fuente8 tbody tr:even").addClass("itemImparTabla");
    
    $(".fecha").datepicker({ dateFormat: "yy-mm-dd" });
    
    $("#reporte").click(function(){
    
      if($('#fecha_inicio').val() == "" || $('#fecha_fin').val() == "")
      {

        alert("Ingrese ambas fechas");
      }else{
        var startDate = new Date($('#fecha_inicio').val());
        var endDate = new Date($('#fecha_fin').val());

        if (startDate > endDate){
          alert("Rango de Fechas inválido");
        }else
        {
          $("#generar_reporte").submit();
        }
      }
    });
  });
    function factura(oper,tipo,codigo){
	var op;
	if(oper==0){
		op="C";
	}else{
		op="V";
	}
		switch(tipo){
			case 1:
				var url = base_url+"index.php/ventas/comprobante/comprobante_ver_pdf_conmenbrete_formato1/"+op+"/"+codigo+"/N/0";
				break;
			case 2:
				var url = base_url+"index.php/ventas/comprobante/comprobante_ver_pdf_conmenbrete_formato11/"+op+"/"+codigo+"/F/0";
				break;
		}
		
        window.open(url,'',"width=800,height=600,menubars=no,resizable=no;");
    }
    function boleta(oper,codigo){
		if(oper==0){
			var url = base_url+"index.php/ventas/comprobante/comprobante_ver_pdf_conmenbrete_formato1_boleta/C/"+codigo+"/B/0";
		}
		if(oper==1){
			var url = base_url+"index.php/ventas/comprobante/comprobante_ver_pdf_conmenbrete_formato1_boleta/V/"+codigo+"/B/0";
		}
       
        window.open(url,'',"width=800,height=600,menubars=no,resizable=no;");
    }
</script>
<div id="pagina">
    <div id="zonaContenido">
		<div align="center">
    <div id="tituloForm" class="header">REPORTES DE VENTAS POR DIA</div>
    <div id="frmBusqueda">
      <form method="post" action="" id="generar_reporte">
        Desde: <input type="text" id="fecha_inicio" name="fecha_inicio" readonly class="fecha" value="<?php echo ((isset($_POST['reporte'])) ? $_POST['fecha_inicio'] : ''); ?>"> Hasta: <input type="text" id="fecha_fin" name="fecha_fin" class="fecha" readonly value="<?php echo ((isset($_POST['reporte'])) ? $_POST['fecha_fin'] : ''); ?>"> <input type="hidden" name="reporte" value=""><input type="button" id="reporte" value="Generar">
      </form>
      <?php if(isset($_POST['reporte'])): ?>

      <br><br><br>
      Reporte de ventas por familia desde <?php echo $fecha_inicio; ?> hasta el <?php echo $fecha_fin; ?><br/>
			<table class="fuente8" cellspacing="0" cellpadding="3" border="0" id="Table1">
      <thead>
        <tr class="cabeceraTablaResultado"><th colspan="5">Resumen</th></tr>
        <tr class="cabeceraTabla">
            <th>Fecha</th>
            <th colspan="2">Nro Factura</th>
            <th> Venta S/.</th>
            <th> Venta US$.</th>
            
        </tr>
      </thead>
      <tbody>
      <?php 
	  $total = 0;
	  $total2 = 0;

	  ?>
      <?php $total_filas = count($resumen); ?>
      <?php foreach($resumen as $fila): ?>
        <?php 
		
		if( $fila['MONED_Codigo']==2 ){
		//$total += $fila['VENTAS']*$fila['CPC_TDC']; 
		$total2 += $fila['VENTAS']; 
		
		}else{ 
		
		$total += $fila['VENTAS'];
		//$total2 += $fila['VENTAS']/$fila['CPC_TDC']; 
		
		}
		
		
		
		
		?>
        <?php
		if($fila['CPC_TipoOperacion']=="C"){
		$operacion=0;
		}else{
		$operacion=1;
		};
		if($fila['TIPO']=='N'){
		$fila['TIPO']=1;
		}
		if($fila['TIPO']=='F'){
		$fila['TIPO']=2;
		}
            echo "<tr>
                    <td>{$fila['FECHA']}</td>
                    <td>
                        {$fila['SERIE']}-{$fila['NUMERO']}
                    </td>
                    <td>";
            if($fila['TIPO']=="B")
                echo "<a href='javascript:;' onclick='boleta({$operacion},{$fila['CODIGO']})'target='_parent'>
                        <img src='".base_url()."images/pdf.png' width='12px'/>
                      </a>";
            else
                echo "<a href='javascript:;' onclick='factura({$operacion},".$fila['TIPO'].",{$fila['CODIGO']})' target='_parent'>
                        <img src='".base_url()."images/pdf.png' width='12px'/>
                      </a>";
            echo"   </td>";
			if( $fila['MONED_Codigo']==2 ){
			
			echo "<td></td>"; 
			echo "<td align='right'>".number_format($fila['VENTAS'],2,'.','')."</td>";
			}else{
			
			echo "<td align='right'>".number_format($fila['VENTAS'],2,'.','')."</td>";
			echo "<td align='right'></td>";
			}
                 
                   

				   "</tr>"; 
        ?>
      <?php endforeach; ?>
        <tr>
            <td colspan="3">TOTAL</td>
            <td align="right"><?php echo number_format($total,2,'.',''); ?></td>
            <td align="right"><?php echo number_format($total2,2,'.',''); ?></td>
        </tr>
      </tbody>
      </table>
      
      <?php endif; ?>
      <?php echo $oculto?>
    </div>
		</div>
    </div>
</div>