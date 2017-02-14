<html>
<head>
   <title><?php echo TITULO;?></title>
   <link href="<?php echo base_url();?>css/estilos.css" type="text/css" rel="stylesheet"/>
   <script type="text/javascript" src="<?php echo base_url();?>js/jquery.js"></script>
   <script type="text/javascript" src="<?php echo base_url();?>js/almacen/serie.js"></script> 
   <script type="text/javascript" src="<?php echo base_url();?>js/funciones.js"></script>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<div align="center">  
    <div id="tituloForm" class="header" style="width:95%">NUMERO DE SERIE</div>
    <div id="frmBusqueda" style="width:95%">
    <table class="fuente8" width="100%" cellspacing=0 cellpadding=3 border=0>					
        <tr>
        <td width="8%">Buscar </td>
        <td><input id="txtSerie" type="text" class="cajaMedia" name="txtSerie" value="<?php echo $serie; ?>"/></td>
        </tr>
        <tr>
          <td align="right" colspan="2"><a href="javascript:;" id="buscarSerie"><img  src="<?php echo base_url();?>images/botonbuscar.jpg" class="imgBoton" /></a>
                           <a href="javascript:;" id="limpiarSerie"><img src="<?php echo base_url();?>images/botonlimpiar.jpg" class="imgBoton" /></a>
                           <a href="javascript:;" id="cerrarSerie"><img src="<?php echo base_url();?>images/botoncerrar.jpg" class="imgBoton" /></a>
          </td>
          </tr>
       </table>
    </div>
    <div id="frmResultado" style="width:95%; height: 250px; overflow: auto; margin-top:10px">
    <table class="fuente8" width="100%" id="tabla_resultado" name="tabla_resultado"  align="center" cellspacing="0" cellpadding="3" border="0" >
           <tr class="cabeceraTabla">
                <td width="5%"><div align="center"><b>ITEM</b></div></td>
                <td width="20%"><div align="center"><b>ALMACEN</b></div></td>
                <td><div align="center"><b>PRODUCTO</b></div></td>
                <td width="14%"><div align="center"><b>NRO. DE SERIE</b></div></td>
              <!--  <td width="4%"><div align="center">MOV</div></td>-->
           </tr>
           <?php
            foreach($lista as $indice=>$valor){
                $class = $indice%2==0?'itemParTabla':'itemImparTabla';
                ?>
                <tr class="<?php echo $class;?>">
                    <td align="center"><?php echo $valor[0]?></td>
                    <td align="left"><?php echo $valor[1]; ?></td>
                    <td align="left"><?php echo $valor[2]; ?></td>
                    <td align="left"><?php echo $valor[3]; ?></td>
                   <!-- <td align="center"><?php echo $valor[4]; ?></td>-->
                </tr>
                <?php
            }
            ?>
    </table>
    <?php echo $oculto;?>   
    </div>
    <div id="frmResultado" style="width:95%; height: 140px; overflow: auto;">
    <img id="loading" src="<?php echo base_url();?>images/loading.gif" style="display:none" />
    <table class="fuente8" width="100%" id="tblMovimientoSerie" align="center" cellspacing="0" cellpadding="3" border="0" style="display:none" >
           <tr class="cabeceraTabla">
                <td colspan="6">MOVIMIENTOS DE LA SERIE: </td>
           </tr>
            <tr class="cabeceraTabla">
                <td width="5%"><div align="center"><b>ITEM</b></div></td>
                <td width="10%"><div align="center"><b>FECHA</b></div></td>
                <td width="10%"><div align="center"><b>TIPO</b></div></td>
                <td width="17%"><div align="center"><b>MOTIVO</b></div></td>
                <td><div align="center">CLIENTE/PROVEEDOR</div></td>
                <td width="5%"><div align="center">NUM DOC</div></td>
           </tr>
    </table>
    <?php echo $oculto;?>   
    </div>
</body>
</html>
