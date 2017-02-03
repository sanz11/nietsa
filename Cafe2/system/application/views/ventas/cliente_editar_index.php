<html>
<head>
   <title><?php echo TITULO; ?></title>
   <link href="<?php echo base_url(); ?>css/estilos.css" type="text/css" rel="stylesheet">
    <script type="text/javascript" src="<?php echo base_url();?>js/jquery.js"></script>
   <script type="text/javascript" src="<?php echo base_url();?>js/funciones.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>js/domwindow.js"></script>
   <script type="text/javascript" src="<?php echo base_url();?>js/ventas/cliente_popup.js"></script>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <script type="text/javascript">
   $(document).ready(function() {

	   redireccionarcloce = $("#redireccionarcloce").val();
	   if(redireccionarcloce != ""){
		   parent.$.fancybox.close(); 
	   }
	   
   });
        
   </script>
</head>
<body>

   
<div id="ventana">
    <div id="pagina">
        <div align="center">
            <div id="tituloForm" class="header"  style="width:500px; top:0px;"><?php echo $tituloclienteeditar; ?></div>
            <div id="frmBusqueda" style="width:500px; top:0px" >
                <form name="frmclienteeditar" id="frmclienteeditar"  class="frmclienteeditar" method="POST" action="<?php echo base_url();?>index.php/ventas/cliente/modificarclienteeditar">
                <input type="text" value="<?php echo $redireccionarcloce; ?>" id="redireccionarcloce" hidden>
                    <div id="tipoPersona">
                        <table class="fuente8_2" width="100%" cellspacing="0" cellpadding="3" border="0">
                            <tr <?php echo $display; ?>>
                                <td width="28%">Tipo Persona (*)</td>
                                <td>
                                    <input type="radio" id="tipo_persona" name="tipo_persona" value="0"  />Persona Natural
                                    <input type="radio" id="tipo_persona" name="tipo_persona" value="1" checked='checked' />Persona Jur&iacute;dica
                                </td>
                            </tr>
                        </table>
                    </div>
					  <div id="datosPersona" style="<?php echo $display_datosPersona; ?>">
                        <table class="fuente8_2" width="100%" cellspacing="0" cellpadding="3" border="0" >
                                <tr>
                                  <td width="28%">N° Documento</td>
                                  <td><select id="tipo_documento" name="tipo_documento" class="comboMedio"  disabled>
                                           <?php echo $tipo_documento; ?>
                                      </select>
                                      <input type="text" value="<?php echo $numero_documento; ?>" class="cajaGeneral" name="numero_documento"  maxlength="8" id="numero_documento"  disabled/>
                                      <label id="numero_documento_msg" class="etiqueta_error"></label>
                                  </td>
                                </tr>
                                <tr>
                                <td>R.U.C.</td>
		                           <td>
									  <input type="text"  class="cajaGeneral" size="9" maxlength="11" value="<?php echo $ruc_persona; ?>" name="ruc_persona" id="ruc_persona" disabled/>
                                  </td>
                                </tr>
                                <tr>
                                  <td> Nombres&nbsp;(*) </td>
                                  <td>
                                      <input  type="text" class="cajaGrande"  name="nombres" value="<?php echo $nombres ;?>" id="nombres" maxlength="150" disabled/>
                                  </td>
                                </tr>
                               
							    <tr>
                                    <td>Apellidos Paterno&nbsp;(*)</td>
                                    <td><input NAME="paterno" type="text" class="cajaGrande" value="<?php echo $paterno ;?>" id="paterno" size="45" maxlength="45" disabled/></td>
                                </tr>
                                <tr>
                                    <td>Apellidos Materno</td>
                                    <td><input NAME="materno" type="text" class="cajaGrande" value="<?php echo $materno ;?>" id="materno" size="45" maxlength="45" disabled/></td>
                                </tr>
                        </table>
                     </div>
                     <div id="datosEmpresa" style="<?php echo $display_datosEmpresa; ?>">
                           <table class="fuente8_2" width="100%" cellspacing="0" cellpadding="3" border="0" >
                            <tr>
                              <td width="28%">Tipo Documento</td>
                              <td>
                                  <select name="cboTipoCodigo" id="cboTipoCodigo" class="comboMedio" disabled>
                                  <?php echo $tipocodigo; ?>
                                  </select>  
                                  <input id="ruc" type="text" class="cajaGeneral" value="<?php echo $ruc; ?>" name="ruc" size="10" maxlength="11" onkeypress="return numbersonly('ruc',event);" disabled/>
                                  <label id="ruc_msg" class="etiqueta_error" ></label>
                              </td>
                            </tr>
                            <tr>
                                <td>Nombre o Raz&oacute;n Social (*)</td>
                                <td><input  type="text" class="cajaGrande" name="razon_social" id="razon_social"  value="<?php echo $razon_social; ?>" disabled/></td>
                            </tr>
                        </table>
                    </div>
                    
                  <div id="divDireccion" >
                                <table width="100%" class="fuente8_2" cellspacing="0" cellpadding="3" border="0" >
                                    <tr>
                                      <td width="28%">Direcci&oacute;n fiscal</td>
                                      <td>
                                          <input name="direccion" type="text" class="cajaGrande" id="direccion" value="<?php echo $direccion; ?>" size="45" maxlength="100" />
                                      </td>
                                   </tr>
                                    <tr>
                                        <td>Tel&eacute;fono </td>
                                        <td><input id="telefono" value="<?php echo $telefono; ?>" name="telefono" type="text" class="cajaPequena" maxlength="15" />
                                         &nbsp;M&oacute;vil
                                        <input id="movil" name="movil" value="<?php echo $movil; ?>" type="text" class="cajaPequena" maxlength="15" />
                                      
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Correo electr&oacute;nico  </td>
                                        <td><input name="email" value="<?php echo $correo; ?>" type="text" class="cajaGrande" id="email" size="35" maxlength="50" /></td>
                                    </tr>
                                    <tr>
                                        <td>Direcci&oacute;n web </td>
                                        <td>
                                                <input name="web" value="<?php echo $web; ?>" type="text" class="cajaGrande" id="web" size="45" maxlength="50" />
                                        </td>
                                    </tr>
                                    <tr>
										  <td width="16%">Categoría</td>
										  <td colspan="3">
											 <select id="categoria" name="categoria" class="comboMedio" >
											 <?php echo $cbo_categoria; ?>
											 </select>
										  </td>
									</tr>
                         </table>
                  </div>
                    <div style="margin-top:20px;margin-bottom:10px; text-align: center" >
                        <a href="javascript:;" id="imgeditarCliente"><img src="<?php echo base_url(); ?>images/botonaceptar.jpg" width="85" height="22" class="imgBoton" title="Editar" /></a>
                        <a href="javascript:;" id="cerrarCliente"><img src="<?php echo base_url(); ?>images/botoncancelar.jpg" width="85" height="22" class="imgBoton" title="Cancelar" /></a>
                    </div>
                     <input type="hidden" id="tipo" name="tipo" value="<?php echo $tipo_persona; ?>" >
                        <input type="hidden" id="id" name="id" value="<?php echo $id; ?>" >
                </form>
            </div>
        </div>
    </div>
</div>


</body>
</html>

