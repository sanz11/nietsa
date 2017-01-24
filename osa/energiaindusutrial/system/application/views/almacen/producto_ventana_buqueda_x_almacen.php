<html>
<head>
   <title><?php echo TITULO;?></title>
   <link href="<?php echo base_url();?>css/estilos.css" type="text/css" rel="stylesheet">
   <link rel="stylesheet" href="<?php echo base_url();?>css/theme.css" type="text/css">
    <script type="text/javascript" src="<?php echo base_url();?>js/jquery.js"></script>
   <script type="text/javascript" src="<?php echo base_url();?>js/jquery.metadata.js"></script>
   <script type="text/javascript" src="<?php echo base_url();?>js/jquery.validate.js"></script>
   <script type="text/javascript" src="<?php echo base_url();?>js/funciones.js"></script>
   <script type="text/javascript" src="<?php echo base_url();?>js/almacen/producto.js"></script>   
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <script type="text/javascript">
        function seleccionar_producto(codigo,interno,familia,stock,costo,flagGenInd){
            parent.seleccionar_producto(codigo,interno,familia,stock,costo,flagGenInd);
            parent.$.fancybox.close(); 
        }
   </script>
</head>
<body>
<div align="center">
<form name="form_busqueda" id="form_busqueda" method="post" action="" >
   <div id="frmResultado"  style="width:95%">
  <table class="fuente8" width="100%" id="tabla_resultado" name="tabla_resultado"  align="center" border="0" cellpadding="4">
        <tr class="cabeceraTabla">
            <td width="5%"><div align="center"><b>Item</b></div></td>
            <td width="17%"><div align="center"><b>C&oacute;digo</b></div></td>
            <td width="51%"><div align="center"><b>Nombre</b></div></td>
            <td width="20%"><div align="center"><b>FAMILIA</b></div></td>
            <td width="10%"><div align="center"><b>STOCK</b></div></td>
            <td width="7%"><div align="center"></div></td>
        </tr>
       <?php
       $indice = 0;
       foreach($lista as $valor){
            $classfila          = $indice%2==0?"itemImparTabla":"itemParTabla";
            $codigo             = $valor[5];
            $interno            =  $valor[1];
            $nombre             = $valor[2];
            $familia            = $valor[3];
            $stock              = $valor[6];
            $costo              = $valor[7];
            $flagGenInd         = $valor[8];
       ?>
         <tr class="<?php echo $classfila;?>">
            <td><div align="center"><?php echo $valor[0];?></div></td>
           <td><div align="center"><?php echo $valor[1];?></div></td>
           <td><div align="left"><?php echo $valor[2];?></div></td>
           <td><div align="center"><?php echo $valor[3];?></div></td>
           <td><div align="right"><?php echo round($valor[6],2);?></div></td>
           <td><div align="center"><a href="#" onclick="seleccionar_producto('<?php echo $codigo;?>','<?php echo $interno;?>','<?php echo $familia?>','<?php echo $stock;?>','<?php echo $costo;?>','<?php echo $flagGenInd;?>');"><img src="<?php echo base_url();?>images/convertir.png" border="0" title="Seleccionar"></a></div></td>
       </tr>
       <?php
       $indice++;
       }
       ?>
</table>
</div>
    <br/>
<table width="100%" border="0">
  <tr>
    <td>
       <div align="center"><a href="#" onclick="parent.$.fancybox.close(); "><img src="<?php echo base_url();?>images/botoncerrar.jpg" width="70" height="22"  border="1" ></a></div>
    </td>
  </tr>
</table>
</form>
</div>
</body>
</html>