<html>
    <head>
        <title><?php echo TITULO; ?></title>
        <link href="<?php echo base_url(); ?>css/estilos.css" type="text/css" rel="stylesheet"/>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/almacen/serie.js"></script> 
        <script type="text/javascript" src="<?php echo base_url(); ?>js/funciones.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/almacen/producto.js"></script>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <script type="text/javascript">
            function grabarSeries(stock,item,codigo){
                var bd=0;
                var series="";
                //var hdseries=""
                for(i=1;i<=stock;i++){
                    if($("#serie"+i).val()==""){
                        bd=1;
                        alert('Debe ingresar todas las series');
                        series="";
                        //hdseries="";
                        break;            
                    }
                    else{
                        if(i>1){
                            series+=",";
                            //hdseries+=",";
                        }
                        series+=$("#serie"+i).val()
                        /*if($("#hdserie"+i).val()!=''){
                            hdseries+=$("#hdserie"+i).val()
                        }else{
                            hdseries="-";
                        }*/
                    }        
                }
    
                if(bd==0){ 
                    /*var array_series=series.split(",");
        for(var i=0;i<array_series.length;i++){*/
                    //dataString        = "codigo="+codigo+"&series="+array_series[i];
                    //parent.guardar_series(codigo,series,hdseries)
                    parent.guardar_series(codigo,series)
                    /*dataString        = "codigo="+codigo+"&series="+series;
                    url = base_url+"index.php/almacen/producto/guardarseries";
                    parent.$.post(url,dataString,function(data){*/
                    parent.$.fancybox.close(); 
                    //});  
                    // }
        
                }
    
            }    
        </script>
    </head>
    <body>
        <div align="center">  
            <div id="tituloForm" class="header" style="width:95%">SERIES POR PRODUCTO</div>
            <div id="frmBusqueda" style="width:95%">
                <table class="fuente8" width="100%" cellspacing=0 cellpadding=3 border=0>					
                    <tr>
                        <td width="8%">Producto: </td>
                        <td>
                            <?php
                            $stock = "";
                            $item = "";
                            foreach ($lista as $indice => $valor) {
                                echo $valor[0];
                                $stock = $valor[2];
                                $item = $valor[3];
                                $codigo = $valor[4];
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" colspan="2">
                            <a href="javascript:;" id="cerrarSerie"><img src="<?php echo base_url(); ?>images/botoncerrar.jpg" class="imgBoton" /></a>
                        </td>
                    </tr>
                </table>
            </div>

            <div id="frmResultado" style="width:95%;overflow: auto; margin-top:10px">
                <table class="fuente8" width="100%" id="tabla_resultado" name="tabla_resultado"  align="center" cellspacing="0" cellpadding="3" border="0" >
                    <tr class="cabeceraTabla">
                        <td></td>
                        <td><div align="center"><b>SERIES</b></div></td>

                    </tr>
                    <?php
                    foreach ($lista as $indice => $valor) {
                        echo $valor[1];
                    }
                    ?>

                </table>
                <?php //echo $oculto;   ?>   
            </div>
            <div id="frmResultado" style="width:95%;  overflow: auto;">
                <img id="loading" src="<?php echo base_url(); ?>images/loading.gif" style="display:none" />
                <a href="javascript:;" onclick="grabarSeries(<?php echo $stock; ?>,<?php echo $item; ?>,<?php echo $codigo; ?>)" id="grabarSeries"><img src="<?php echo base_url(); ?>images/botonaceptar.jpg" width="85" height="22" class="imgBoton" ></a>
                    <?php //echo $oculto;   ?>   
            </div>
        </div>
    </body>
</html>
