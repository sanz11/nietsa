<html>
<head>
   <title><?php echo TITULO;?></title>
   <link href="<?php echo base_url();?>css/estilos.css" type="text/css" rel="stylesheet">
    <script type="text/javascript" src="<?php echo base_url();?>js/jquery.js"></script>
   <script type="text/javascript" src="<?php echo base_url();?>js/funciones.js"></script>
   <script type="text/javascript" src="<?php echo base_url();?>js/almacen/producto.js"></script>

   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   
</head>
<body>
<div align="center">  
   <?php echo $form_open;?>
    <div id="frmBusqueda" style="width:80%">
        
        
        
    <table class="fuente8" width="100%" cellspacing=0 cellpadding=3 border=0>					
        <tr class="cabeceraTabla" height="25px">
            <td align="center" colspan="3">PUBLICAR PRODUCTOS</td>
        </tr>
       </table>
    </div>
    <div id="frmBusqueda" style="width:80%;">
    <table class="fuente8" width="100%" id="tabla_resultado" name="tabla_resultado"  align="center" cellspacing="1" cellpadding="3" border="0" >
       <?php 
               foreach( $producto as $valores){
                 echo  "
                      <label  style='display:none' id='producto' >
            <input type='checkbox'  id='producto' name='producto[]' value='".$valores."'  checked  />
                     </label > ";
                      
                  
                   
               }
         ?>  
        <tr>
               <td>Tipo de Precio:</td>
               <td>
                   <select name="precio2" id="precio2">
                   <option value="0" >::SELECCIONE::</option>
                   <option value="1">PRECIO 1</option>
                   <option value="2">PRECIO 2</option>
                   <option value="3">PRECIO 3</option>
                   <option value="4">PRECIO 4</option>
                   </select>
                   
                   
               </td>
           </tr>
           <tr>
               <td>Categoria de la Página:</td>
               <td><?php echo $cboCateg; ?></td>
           </tr>
         
    </table>
    </div>
    <br />
    <div id="divBotones" style="text-align: center; float:left;margin-left: auto;margin-right: auto;width: 98%;margin-top:15px;">
        <img id="loading" src="<?php echo base_url();?>images/loading.gif"  style="visibility: hidden" />
      
        <a href="javascript:;" id="imgGuardarPro"><img src="<?php echo base_url();?>images/botonaceptar.jpg" width="85" height="22" class="imgBoton"></a>
        <a href="javascript:;" id="imgCancelarProducto"><img src="<?php echo base_url();?>images/botoncancelar.jpg" width="85" height="22" class="imgBoton"></a>
        <?php echo $form_hidden;?>
    </div>
    <?php echo $form_close;?>
</body>
</html>
