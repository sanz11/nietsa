<html>
	<head>	
        <script type="text/javascript" src="<?php echo base_url();?>js/jquery.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/jquery.metadata.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/jquery.validate.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/maestros/empresa.js"></script>		
		<script type="text/javascript" src="<?php echo base_url();?>js/funciones.js"></script>	
                <script type="text/javascript">
		function cargar_ubigeo_complementario(departamento,provincia,distrito,valor,seccion,n){
			if(seccion=="sucursal"){
				a = "dptoSucursal["+n+"]";
				b = "provSucursal["+n+"]";
				c = "distSucursal["+n+"]";
				d = "distritoSucursal["+n+"]"
				document.getElementById(a).value = departamento;
				document.getElementById(b).value = provincia;
				document.getElementById(c).value = distrito;
				document.getElementById(d).value = valor;
			}
		}
		</script>
                <style>
                    .cab1{
                        background-color: #5F5F5F;
                        color: #ffffff;
                        font-weight: bold;
                    }
                </style>
	</head>
	<body>
<!-- Inicio -->
<div id="VentanaTransparente" style="display:none;">
  <div class="overlay_absolute"></div>
  <div id="cargador" style="z-index:2000">
    <table width="100%" height="100%" border="0" class="fuente8">
		<tr valign="middle">
			<td> Por Favor Espere    </td>
			<td><img src="<?php echo base_url();?>images/cargando.gif"  border="0" title="CARGANDO" /><a href="#" id="hider2"></a>	</td>
		</tr>
    </table>
  </div>
</div>
<!-- Fin -->	
		<div id="pagina">
			<div id="zonaContenido">
				<div align="center">
				<div id="tituloForm" class="header"><?php echo $titulo;?></div>
				<div id="frmBusqueda">
				<form id="frmEmpresa" name="frmProveedor" method="post" action="">
					<div id="container" class="container">
						<ol>
						<h4>Primero debe completar los siguientes campos antes de enviar.</h4>						
							<div id="containerEmpresa">
								<li><label for="ruc" class="error">Por favor ingrese su ruc con sólo campos numéricos.</label></li>
								<li><label for="razon_social" class="error">Por favor ingrese un nombre o razon social.</label></li>
							</div>
						</ol>
					</div>					
                    <div align="left"class="fuente8" style="float:left;height:20px;border: 0px solid #000;margin-top:7px;margin-left: 15px;width: 300px;">
                        <a href="#" id="idGeneral">General&nbsp;&nbsp;&nbsp;</a>
                        <a href="#" id="idSucursales">|&nbsp;Sucursales&nbsp;&nbsp;&nbsp;|</a>&nbsp;
                        <a href="#" id="idContactos">Cont&aacute;ctos&nbsp;&nbsp;&nbsp;</a>&nbsp;
                        <a href="#" id="idAreas" style="display:none;">&Aacute;reas</a>
                    </div>
                    <div id="nuevoRegistro" style="display:none;float:right;width:150px;height:20px;border:0px solid #000;margin-top:7px;"><a href="#">Nuevo <image src="<?php echo base_url();?>images/add.png" name="agregarFila" id="agregarFila" border="0" alt="Agregar"></a></div><br><br>				
		       <div id="datosGenerales">
                       <div id="datosEmpresa">
                           <table class="fuente8" width="98%" cellspacing=0 cellpadding="4" border="0">
                            <tr>
                              <td width="16%">Tipo de Código (*)</td>
                              <td colspan="3">
                                <select name="cboTipoCodigo" id="cboTipoCodigo" class="comboMedio">
                                <?php echo $tipocodigo; ?>
                                </select>
                              </td>
                            </tr>
                            <tr>
                              <td width="16%">RUC / NIC (*)</td>
                              <td colspan="3">
                                    <!--<input id="ruc" type="text" class="cajaPequena" NAME="ruc" maxlength="11" value="<?php echo $datos->ruc;?>" onkeypress="return numbersonly('numero_documento',event);" onblur="c(<?php echo $datos->id; ?>, <?php echo $datos->tipo; ?>);">-->
                                    <input id="ruc" type="text" class="cajaPequena" NAME="ruc" value="<?php echo $datos->ruc;?>" onkeypress="return numbersonly('numero_documento',event);">
                              </td>
                            </tr>
                            <tr>
                                <td width="16%">Nombre o Raz&oacute;n Social(*)</td>
                                <td colspan="3"><input name="razon_social" type="text" class="cajaGrande" id="razon_social" maxlength="150" value="<?php echo $datos->nombre;?>"></td>
                            </tr>
                            <tr>
                                <td width="16%">Sector Comercial</td>
                                <td colspan="3"><select id="sector_comercial" name="sector_comercial" class="comboMedio" style="width:240px">
                                                <?php echo $cbo_sectorComercial; ?>
                                                </select></td>
                            </tr>
                        </table>
                       </div>
        		<div id="divDireccion">

                        <table class="fuente8" width="98%" cellspacing="0" cellpadding="4" border="0">
                          <tr height="10px">
                            <td colspan="4"><hr></td>
                          </tr>
                            <tr>
							  <td>Departamento&nbsp;</td>
                              <td colspan="3">
							  	<div id="divUbigeo">
                                    <select id="cboDepartamento" name="cboDepartamento" class="comboMedio" onchange="cargar_provincia(this);">
                                        <?php echo $cbo_dpto;?>
                                    </select>&nbsp;	&nbsp;
                                    Provincia&nbsp;&nbsp;	&nbsp;
                                    <select id="cboProvincia" name="cboProvincia" class="comboMedio" onchange="cargar_distrito(this);">
                                        <?php echo $cbo_prov;?>
                                    </select>&nbsp;	&nbsp;
                                    Distrito&nbsp;&nbsp;	&nbsp;
                                    <select id="cboDistrito" name="cboDistrito" class="comboMedio">
                                        <?php echo $cbo_dist;?>
                                    </select>
								</div>
                              </td>
                          </tr>
                            <tr>
                              <td width="16%">Direcci&oacute;n fiscal</td>
                              <td colspan="3"><input NAME="direccion" type="text" class="cajaSuperGrande" id="direccion" size="45" maxlength="250" value="<?php echo $datos->direccion;?>" />
                              TIPO VIA / NOMBRE VIA / N° / INTERIOR / ZONA
                              </td>
                           </tr>
                          <tr height="10px">
                            <td colspan="4"><hr></td>
                          </tr>
                          <tr>
                            <td colspan="4">
                                <table width="100%" class="fuente8" cellspacing=0 cellpadding=3 border="0">
                                    <tr>
                                        <td width="16%">Tel&eacute;fono </td>
                                        <td><input id="telefono" name="telefono" type="text" class="cajaPequena" maxlength="15" value="<?php echo $datos->telefono;?>"></td>
                                        <td>M&oacute;vil</td>
                                        <td><input id="movil" name="movil" type="text" class="cajaPequena" maxlength="15" value="<?php echo $datos->movil;?>"></td>
                                        <td>Fax</td>
                                        <td><input id="fax" name="fax" type="text" class="cajaPequena" maxlength="15" value="<?php echo $datos->fax;?>"></td>
                                    </tr>
                                    <tr>
                                        <td>Correo electr&oacute;nico  </td>
                                        <td><input NAME="email" type="text" class="cajaGrande" id="email" size="35" maxlength="50" value="<?php echo $datos->email;?>"></td>
                                        <td>Direcci&oacute;n web </td>
                                        <td colspan="3">
                                                <input NAME="web" type="text" class="cajaGrande" id="web" size="45" maxlength="50" value="<?php echo $datos->web;?>">
                                        </td>
                                    </tr>
                                </table>
                            </td>
                          </tr>
                          <tr height="10px">
                            <td colspan="4"><hr></td>
                          </tr>
                          <tr>
                              <td width="16%">Cta. Cte. Soles</td>
                              <td colspan="3">
                                 <input NAME="ctactesoles" type="text" class="cajaMedia" id="ctactesoles" size="45" maxlength="50" value="<?php echo $datos->ctactesoles;?>" />
                              </td>
                          </tr>
                          <tr>
                              <td width="16%">Cta. Cte. Dolares</td>
                              <td colspan="3">
                                 <input NAME="ctactedolares" type="text" class="cajaMedia" id="ctactedolares" size="45" maxlength="50" value="<?php echo $datos->ctactedolares;?>" />
                              </td>
                          </tr>
                        </table>
                  </div>
				 </div>	  
                  <div id="datosContactos" style="display:none;">
                    <table id="tablaContacto" class="fuente8" width="98%" cellspacing="0" cellpadding="6" border="0">
                        <tr align="center" class="cab1" height="10px;">
                            <td>Nro</td>
                            <td>Nombre del Contacto</td>
                            <td>Area</td>
                            <td>Cargo</td>
                            <td>Telefonos</td>
                            <td>E-mail</td>
                            <td>Borrar</td>
                            <td>Editar</td>
                        </tr>
						<?php
						$kk=1;
						$cantidad = count($listado_empresaContactos);
						if($cantidad>0){
							foreach($listado_empresaContactos as $indice=>$valor){
							 $persona  = $valor->ECONC_Persona;
							 $telefono = $valor->ECONC_Telefono==''?'&nbsp;':$valor->ECONC_Telefono;
							 $movil    = $valor->ECONC_Movil ;
							 $email    = $valor->ECONC_Email==''?'&nbsp;':$valor->ECONC_Email;
							 if($movil!='') $telefono = $telefono."&nbsp;/".$movil;
							?>
								<tr bgcolor="#ffffff">
									<td align="center"><?php echo $kk;?></td>
									<td align="left"><?php echo $valor->PERSC_Nombre.' '.$valor->PERSC_ApellidoPaterno .' '.$valor->PERSC_ApellidoMaterno;?></td>
									<td><?php echo $valor->AREAC_Descripcion;?></td>
									<td><?php echo $valor->CARGC_Descripcion;?></td>
									<td><?php echo $telefono;?></td>
									<td><?php echo $email; ?></td>
									<td align="center" <?php if($modo=='insertar') echo "style='display:none;'";?>>
										<a href="#" onclick="eliminar_contacto(<?php echo $persona;?>);"><img src="<?php echo base_url();?>images/delete.gif" border="0"></a>
									</td>
									<td align="center" <?php if($modo=='insertar') echo "style='display:none;'";?>>
										<div id="idEdit"><a href="#" onclick="editar_contacto(<?php echo $persona;?>);"><img src="<?php echo base_url();?>images/edit.gif" border="0"></a></div>
										<div id="idSave" style="display:none;"><a href="#"><img src="<?php echo base_url();?>images/save.gif" border="0"></a></div>
									</td>
								</tr>						
							<?php
							$kk++;
							}
						}
						?>
                                        </table>
					<?php
					$displayContactos = $cantidad!=0?"display:none;":"";
					?>
                                   <div id="msgRegistros" style="width:98%;text-align:center;height:20px;border:1px solid #000;<?php echo $displayContactos;?>">NO EXISTEN REGISTROS</div>
				  </div>
                  <div id="datosSucursales" style="display:none;">
                    <table id="tablaSucursal" width="98%" class="fuente8" width="98%" cellspacing="0" cellpadding="6" border="0">
                        <tr align="center" class="cab1" height="10px;">
                            <td width="30">Nro</td>
                            <td width="70">Nombre</td>
                            <td width="120">Tipo Establecimiento</td>							
                            <td width="350">Direccion Sucursal (*)</td>
                            <td width="200">Departamento / Provincia / Distrito</td>
                            <td>Borrar</td>
                            <td>Editar</td>
                        </tr>
						<?php
						$kk=1;
						$cantidad2 = count($listado_empresaSucursal);
						if($cantidad2>0){
							foreach($listado_empresaSucursal as $indice=>$valor){
								$sucursal = $valor->EESTABP_Codigo;
								?>
									<tr bgcolor="#ffffff">
										<td align="center"><?php echo $kk;?></td>
										<td align="left"><?php echo $valor->EESTABC_Descripcion;?></td>
										<td><?php echo $valor->TESTC_Descripcion;?></td>							
										<td align="left"><?php echo $valor->EESTAC_Direccion;?></td>
										<td><?php echo $valor->UBIGC_Descripcion;?></td>
										<td align="center" <?php if($modo=='insertar') echo "style='display:none;'";?>>
											<a href="#" onclick="eliminar_sucursal(<?php echo $sucursal;?>);"><img src="<?php echo base_url();?>images/delete.gif" border="0"></a>
										</td>
										<td align="center" <?php if($modo=='insertar') echo "style='display:none;'";?>>
											<div id="idEdit">
												<a href="#" onclick="editar_sucursal(<?php echo $sucursal;?>);"><img src="<?php echo base_url();?>images/edit.gif" border="0"></a>
											</div>
											<div id="idSave" style="display:none;"><a href="#"><img src="<?php echo base_url();?>images/save.gif" border="0"></a></div>
										</td>
									</tr>						
								<?php
								$kk++;
							}
						}
    						?>
                                        </table>
					<?php
					$displaySucursal = $cantidad2!='0'?"display:none;":"";
					?>
                                        <div id="msgRegistros2" style="width:98%;text-align:center;height:20px;border:1px solid #000;<?php echo $displaySucursal;?>">NO EXISTEN REGISTROS</div>
				  </div>
				<div style="margin-top:20px; text-align: center">
                                        <a href="#" id="imgGuardarEmpresa"><img src="<?php echo base_url();?>images/botonaceptar.jpg" width="85" height="22" class="imgBoton" onMouseOver="style.cursor=cursor"></a>
					<a href="#" id="imgLimpiarEmpresa"><img src="<?php echo base_url();?>images/botonlimpiar.jpg" width="69" height="22" class="imgBoton" onMouseOver="style.cursor=cursor"></a>
					<a href="#" id="imgCancelarEmpresa"><img src="<?php echo base_url();?>images/botoncancelar.jpg" width="85" height="22" class="imgBoton" onMouseOver="style.cursor=cursor"></a>
					<input id="accion" name="accion" value="alta" type="hidden">
					<input id="modo" name="modo" type="hidden" value="<?php echo $modo;?>">
					<input type="hidden" name="opcion" id="opcion" value="1">
					<input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
                                        <input type="hidden" name="empresa_persona" id="empresa_persona" value="<?php echo $datos->id; ?>" />
                                </div>
			  </form>
		  </div>
		  </div>
		</div>
	</body>
</html>