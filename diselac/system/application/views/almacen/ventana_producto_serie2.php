<html>
<head>
   <title><?php echo TITULO;?></title>
   <link href="<?php echo base_url();?>css/estilos.css" type="text/css" rel="stylesheet">
    <script type="text/javascript" src="<?php echo base_url();?>js/jquery.js"></script>
   <script type="text/javascript" src="<?php echo base_url();?>js/funciones.js"></script>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
   <script>
        
        $(document).ready(function(){
            var base_url=$('#base_url').val();
            var cantidad=$('#cantidad').val();
            
            $('#imgGuardarSerie').click(function(){
               $('#frmProductoSerie').submit();
            });
            
            $('#imgCancelarSerie').click(function(){
               window.close();
            });
            
            $('#tblDisponibles a.add').live('click',function(){
                if($('#tblSeleccionados input[name^="accion"][value="n"]').length==cantidad){
                    alert('La cantidad de series ha seleccionar esta completa');
                    return false;
                }
                var codigo=$(this).attr('id');
                var numero=$(this).attr('name');
                var fila='';
                
                fila='<tr class="itemParTabla">';
                var n = document.getElementById('tblSeleccionados').rows.length;
                fila+='<td align="left"><input type="text" class="cajaMedia" value="'+numero+'" /></td>';
                fila+='<td align="right">';
                fila+='<a href="javascript:;" class="remove" name="'+numero+'" id="'+codigo+'"><img src="'+base_url+'images/volver.png" width="16" height="16" border="0" title="Retirar de la Lista"/></a>';
                fila+='<input type="hidden" value="n" name="accion['+n+']" id="accion['+n+']" />';
                fila+='<input type="hidden" value="'+codigo+'" name="serie['+n+']" id="serie['+n+']" />';
                fila+='</td>';
                fila+='</tr>';
                $("#tblSeleccionados").append(fila);
                $(this).parent().parent().remove();
                $("#limpiarSerieDisp").click();
            });
            
            $("#buscarSerieDisp").click(function(){
                var text_busc=$('#txtSerieDisp').val();
                if(text_busc.length>=4){
                    $.each($('input[id^="serieDisp"]'), function(i,item){
                        var texto=$(item).val();
                        if(texto.indexOf(text_busc)==-1){
                            $(item).attr('title','e');
                            $(item).parent().parent().hide();
                        }
                    });
                    $('input[id^="serieDisp"][title!="e"]:first').focus();
                }
            });
            
            $('#txtSerieDisp').keyup(function(e){
               var key=e.keyCode || e.which;
                if(key==13){
                    $('input[id^="serieDisp"]').attr('title', '').parent().parent().show();
                    $("#buscarSerieDisp").click();
                }else
                    if(key==27)
                        $("#limpiarSerieDisp").click();
                    else{
                        var obj=$(this);
                        $.each($('input[id^="serieDisp"]'), function(i,item){
                            var texto=$(item).val();
                            if(texto==obj.val())
                                $(item).parent().next().find('img').click();
                        });
                    }
                
            });
            
            $('input[id^="serieDisp"]').live('keyup',function(e){
               var key=e.keyCode || e.which;
                if (key==13){
                    
                    if($('#tblSeleccionados input[name^="accion"][value="n"]').length==cantidad){
                        alert('La cantidad de series ha seleccionar esta completa');
                        return false;
                    }
                    var temp=$(this).attr('id').split('_');
                    var codigo=temp[1];
                    var numero=$(this).val();
                    var fila='';

                    fila='<tr class="itemParTabla">';
                    var n = document.getElementById('tblSeleccionados').rows.length;
                    fila+='<td align="left"><input type="text" class="cajaMedia" value="'+numero+'" /></td>';
                    fila+='<td align="right">';
                    fila+='<a href="javascript:;" class="remove" name="'+numero+'" id="'+codigo+'"><img src="'+base_url+'images/volver.png" width="16" height="16" border="0" title="Retirar de la Lista"/></a>';
                    fila+='<input type="hidden" value="n" name="accion['+n+']" id="accion['+n+']" />';
                    fila+='<input type="hidden" value="'+codigo+'" name="serie['+n+']" id="serie['+n+']" />';
                    fila+='</td>';
                    fila+='</tr>';
                    $("#tblSeleccionados").append(fila);
                    $(this).parent().parent().remove();
                    $("#limpiarSerieDisp").click();
                }else
                    if(key==38)
                        $(this).parent().parent().prev().find('input[id^="serieDisp"][title!="e"]').focus();
                    else
                        if(key==40)
                            $(this).parent().parent().next().find('input[id^="serieDisp"][title!="e"]').focus();
            });
            
            
            
            $("#limpiarSerieDisp").click(function(){
                $('input[id^="serieDisp"]').attr('title', '').parent().parent().show();
                $('#txtSerieDisp').val('').focus();
            });
           
            $('#tblSeleccionados a.remove').live('click',function(){
                var codigo=$(this).attr('id');
                var numero=$(this).attr('name');
                var fila='';
                
                fila='<tr class="itemParTabla">';
                fila+='<td align="left"><input type="text" class="cajaMedia" name="serieDisp_'+codigo+'" id="serieDisp_'+codigo+'" value="'+numero+'"  /></td>';
                fila+='<td align="right"><a href="javascript:;" class="add" name="'+numero+'" id="'+codigo+'"><img src="'+base_url+'images/ir.png" width="16" height="16" border="0" title="Seleccionar este Número de Serie"/></a></td>';
                fila+='</tr>';
                $("#tblDisponibles").append(fila);
                
                $(this).next().val('e');
                $(this).parent().parent().fadeOut('fast');
            });
            
            $("#buscarSerieSelec").click(function(){
                var text_busc=$('#txtSerieSelec').val();
                $.each($('#tblSeleccionados a.remove'), function(i,item){
                    var texto=$(item).attr('name');
                    if(texto.indexOf(text_busc)==-1)
                        $(item).parent().parent().hide();
                });
                
            });
            
            $("#limpiarSerieSelec").click(function(){                
                $('#txtSerieSelec').val('');
                $.each($('#tblSeleccionados input[name^="accion"]'), function(i,item){
                    if($(item).val()=='n')
                        $(item).parent().parent().show();
                });
            });
            
            $('#txtSerieDisp').focus();
            
        }); 
   </script>
<body>
<div align="center">  
<?php echo $form_open;?>
    <div id="frmBusqueda" style="width:95%">
    <table class="fuente8" width="100%" cellspacing=0 cellpadding=3 border=0>					
        <tr class="cabeceraTabla" height="25px">
            <td align="center" colspan="3"><?php echo $nombre_producto; ?></td>
        </tr>
       </table>
    </div>
    <div id="frmResultado" style="width:95%;">
    <div style="width:49%; float:left; margin-right: 1%; height: 400px; overflow: auto;">
        <p class="fuente8" style="color:#AEAE00;"><b>NUMEROS DE SERIE DISPONIBLES</b></p>
        <table id="tblDisponibles" class="fuente8" align="center" width="100%" cellspacing="0" cellpadding="2" border="0">
        <tbody>
            <tr align="center" class="cabeceraTabla">
                <td width="40%" align="left"><input id="txtSerieDisp" type="text" class="cajaMedia" name="txtSerieDisp" maxlength="30" value=""/></td>
                <td align="right">
                    <a href="javascript:;" id="buscarSerieDisp"><img  src="<?php echo base_url();?>images/botonbuscar.jpg" class="imgBoton" /></a>
                    <a href="javascript:;" id="limpiarSerieDisp"><img src="<?php echo base_url();?>images/botonlimpiar.jpg" class="imgBoton" /></a>
                </td>
            </tr>
            <?php
            for($i=0;$i<count($series_disponib);$i++){
            ?>
            <tr class="itemParTabla">
                <td align="left"><input type="text" class="cajaMedia" name="serieDisp_<?php echo $series_disponib[$i]->SERIP_Codigo; ?>" id="serieDisp_<?php echo $series_disponib[$i]->SERIP_Codigo; ?>" value="<?php echo $series_disponib[$i]->SERIC_Numero; ?>"  /></td>
                <td align="right"><a href="javascript:;" class="add" id="<?php echo $series_disponib[$i]->SERIP_Codigo; ?>" name="<?php echo $series_disponib[$i]->SERIC_Numero; ?>"><img src="<?php echo base_url(); ?>images/ir.png" width="16" height="16" border="0" title="Seleccionar este Número de Serie"/></a></td>
            </tr>
            <?php } ?>
        </tbody>
        </table>
    </div>
    <div style="width:49%; float:left; margin-left: 1%; height: 400px; overflow: auto;">
        <p class="fuente8" style="color:#CA4200;"><b>NUMERO DE SERIE SELECCIONADOS</b></p>
        <table id="tblSeleccionados" class="fuente8" align="center" width="100%" cellspacing="0" cellpadding="2" border="0">
        <tbody>
            <tr align="center" class="cabeceraTabla">
                <td width="40%" align="left"><input id="txtSerieSelec" type="text" class="cajaMedia" NAME="txtSerieSelec" maxlength="30" value=""/></td>
                <td align="right">
                    <a href="javascript:;" id="buscarSerieSelec"><img  src="<?php echo base_url();?>images/botonbuscar.jpg" class="imgBoton" /></a>
                    <a href="javascript:;" id="limpiarSerieSelec"><img src="<?php echo base_url();?>images/botonlimpiar.jpg" class="imgBoton" /></a>
                </td>
            </tr>
            <?php
            for($i=0;$i<count($series_selec);$i++){
            ?>
            <tr class="itemParTabla">
                <td align="left"><input type="text" class="cajaMedia" value="<?php echo $series_selec[$i]->SERIC_Numero;?>" /></td>
                <td align="right"><a href="javascript:;" class="remove" id="<?php echo $series_selec[$i]->SERIP_Codigo; ?>" name="<?php echo $series_selec[$i]->SERIC_Numero; ?>" ><img src="<?php echo base_url(); ?>images/volver.png" width="16" height="16" border="0" title="Retirar de la Lista"/></a>
                <input type="hidden" value="n" name="accion[<?php echo $i+1; ?>]" id="accion[<?php echo $i+1; ?>]" />
                <input type="hidden" value="<?php echo $series_selec[$i]->SERIP_Codigo;?>" name="serie[<?php echo $i+1; ?>]" id="serie[<?php echo $i+1; ?>]" />
                </td>
            </tr>
            <?php
            }
            ?>
        </tbody>
        </table>
    </div>

    <div id="divBotones" style="text-align: center; float:left;margin-left: auto;margin-right: auto;width: 98%;margin-top:15px;">
        <a href="javascript:;" id="imgGuardarSerie"><img src="<?php echo base_url();?>images/botonaceptar.jpg" width="85" height="22" class="imgBoton"></a>
        <a href="javascript:;" id="imgCancelarSerie"><img src="<?php echo base_url();?>images/botoncancelar.jpg" width="85" height="22" class="imgBoton"></a>
        <?php echo $form_hidden;?>
    </div>
</div>
<?php echo $form_close;?>
</body>
</html>
