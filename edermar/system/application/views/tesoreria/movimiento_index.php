
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-ui-1.8.17.custom.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.metadata.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.validate.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>js/tesoreria/movimiento.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.columns.min.js"></script>


<div id="pagina">
    <div id="zonaContenido">
    		<form id="formmoviminetoindex" name="formmoviminetoindex">
                    <div align="center">
                <?php if($nombres!=""){
?>
                        <div id="tituloForm" class="header"><?php echo $titulo;?></div>
                        
                        <div id="zonaContenido">
                        <table class="fuente8" width="98%" cellspacing=0 cellpadding="6" border="0">
                                <tr>
                                  <td>Nombre de Caja</td>
                                  
                                  <td><input type="text" style="width:40%;" id="nombres" value="<?php echo $nombres;?>"  disabled>
                                  <input type="text" value="<?php echo $codigo;?>" id="tdcajacodigo" hidden></td>                                  
                                </tr>
                                <tr>
                                    <td>Tipo de Caja</td>
                                    <td id="tdtipocada"><?php echo $tipoCaja;?></td>
								</tr>
                                <tr>
                                    <td>Observaciones</td>
                                    <td id="tdobservacionescaja"><?php echo $observaciones;?></td>
                                </tr>                              
                        </table>
		  	</div>
		  	<div class="acciones">
    					<div id="botonBusqueda">
        					<ul id="limpiarMovimiento" class="lista_botones"><li id="limpiar">Limpiar</li></ul>
                             <ul id="ingresoDineroMovimiento" class="lista_botones"><li id="entradadinero">Ingreso de Dinero</li></ul>
        					<ul id="ingresoSalidaMovimiento" class="lista_botones"><li id="salidadinero">Salida de Dinero</li></ul>
    					</div>
					</div>
		  	
		  	
		  	
<!-- 		  	/*****/ -->
		  	
		  	
		  	
		  	 <div id="frmBusqueda" style="height:250px; overflow: auto">

            <div class="fuente8" align="left" style="color:white;font-weight:bold;">
                <span style="border:1px solid green;background-color:green;">&nbsp;INGRESO&nbsp;</span>
                <span style="border:1px solid red;background-color:red;">&nbsp;SALIDA&nbsp;</span>
            </div>
            
            
            <table class="fuente8" width="100%" border="0" ID="Table1">
                <tr class="cabeceraTabla">
                    <td width="3%">
                        <div align="center">ITEM</div>
                    </td>
                    <td width="20%">
                        <div align="center">NOMBRE DE CAJA</div>
                    </td>
                    <td width="6%">
                        <div align="center">MONEDA</div>
                    </td>
                    <td width="5%">
                        <div align="center">MONTO</div>
                    </td>
                    <td width="10%">
                        <div align="center">FECHA DE SISTEMA</div>
                    </td>
                    <td width="6%">
                        <div align="center">CUENTA CONTABLE</div>
                    </td>
                    <td width="6%">
                        <div align="center">MOVIMIENTO DE DINERO</div>
                    </td>
                    <td width="6%">
                        <div align="center">ACCIONES</div>
                    </td>
                </tr>
				<tr>
                 <?php
                                        $i=1;
                                        
                                        foreach($lista as $indice=>$valor){
                                                $class = $indice%2==0?'itemParTabla':'itemImparTabla';
                                                ?>
                                                <tr class="<?php echo $class;?>">
                                                        <td  width="3%"><div align="center"><?php echo $valor[0];?></div></td>
                                                        <td><div align="left"><?php echo $valor[1];?></div></td>
                                                        <td><div align="left"><?php echo $valor[2];?></div></td>
                                                        <td><div align="left"><?php echo $valor[3];?></div></td>
                                                        <td><div align="left"><?php echo $valor[4];?></div></td>
                                                        <td><div align="left"><?php echo $valor[5];?></div></td>
                                                        <td><div align="left"><?php echo $valor[6];?></div></td>
                                                        <td><div align="left"><?php echo $valor[7];?></div></td>
                                                </tr>
                                                <?php
                                                $i++;
                                                }
                                        ?>    
				</tr>                                                             
                </table>
        </div>
<!-- 		  	/*****************************************/ -->
		  	
		  	<?php
                    }else{
                        ?>
 <div id="tituloForm" class="header"><?php echo $titulo;?></div>
                        
                        <div id="zonaContenido">
                          <table class="fuente8" cellspacing=0 cellpadding=3 border=0 style="width:100%;float:left;" >
                                    <tr>
                                            <td style="width:20%;">Nombre De Caja</td>
                                            <td>
                                            	<select id="cboNombreCaja" name="cboNombreCaja" class="comboMedio">
                            	 					<?php echo $cboNombreCaja; ?>
                            	 	 			</select>
                            	 	 		</td>
                                    </tr>
                                    <tr>
                                    	<td>Estados</td>
                                    	<td>
                                    		<select id="estado" name="estado" class="comboMedio" >
                                    			<option value="sele" >::Seleccionar::</option>
                                    			<option value="0" > DESHABILITADO </option>
                                    			<option value="1" > HABILITADO </option>
                                    			<option value="2" > AMBOS </option>
                                    		</select>
                                    	</td>
                                    </tr>
           	               </table>
           			   </div>
           			   <div class="acciones">
    					<div id="botonBusqueda">
        					<ul id="limpiarMovimiento" class="lista_botones"><li id="limpiar">Limpiar</li></ul>
        					<ul id="buscarMovimiento" class="lista_botones"><li id="buscar">Buscar</li></ul>
        					<ul id="ingresoDineroMovimiento" class="lista_botones"><li id="entradadinero">Ingreso de Dinero</li></ul>
        					<ul id="ingresoSalidaMovimiento" class="lista_botones"><li id="salidadinero">Salida de Dinero</li></ul>
    					</div>
					</div>
					
					
<!-- 					/*************************************************************************************/ -->
					
					
					       <table class="fuente8" width="100%" border="0" id="tablaregisnombrecaja">
                <tr class="cabeceraTabla">
                    <td width="3%">
                        <div align="center">ITEM</div>
                    </td>
                    <td width="20%">
                        <div align="center">NOMBRE DE CAJA</div>
                    </td>
                    <td width="6%">
                        <div align="center">MONEDA</div>
                    </td>
                    <td width="5%">
                        <div align="center">MONTO</div>
                    </td>
                    <td width="10%">
                        <div align="center">FECHA DE SISTEMA</div>
                    </td>
                    <td width="6%">
                        <div align="center">CUENTA CONTABLE</div>
                    </td>
                    <td width="6%">
                        <div align="center">MOVIMIENTO DE DINERO</div>
                    </td>
                    <td width="6%">
                        <div align="center">ACCIONES</div>
                    </td>
                </tr>
                <tr>

                 <?php
                                        $i=1;
                                        
                                        foreach($lista as $indice=>$valor){
                                                $class = $indice%2==0?'itemParTabla':'itemImparTabla';
                                                ?>
                                                <tr class="<?php echo $class;?>">
                                                        <td  width="3%"><div align="center"><?php echo $valor[0];?></div></td>
                                                        <td><div align="left"><?php echo $valor[1];?></div></td>
                                                        <td><div align="left"><?php echo $valor[2];?></div></td>
                                                        <td><div align="left"><?php echo $valor[3];?></div></td>
                                                        <td><div align="left"><?php echo $valor[4];?></div></td>
                                                        <td><div align="left"><?php echo $valor[5];?></div></td>
                                                        <td><div align="left"><?php echo $valor[6];?></div></td>
                                                         <td><div align="center"><?php echo $valor[7];?> </div></td>
                                                </tr>
                                                <?php
                                                $i++;
                                                }
                                        ?>
                 </tr>                                                
                </table>

					<!-- 					/*************************************************************************************/ -->
					
                        <?php }  ?>
        	</div>	
        </form>
    </div>
</div>