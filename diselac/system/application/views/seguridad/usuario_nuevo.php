<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.metadata.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.validate.js"></script>   
<script type="text/javascript" src="<?php echo base_url(); ?>js/seguridad/usuario.js"></script> 

<div id="pagina">
    <div id="zonaContenido">
        <div align="center">
            <div id="tituloForm" class="header"><?php echo $titulo; ?></div>
            <div id="frmBusqueda">
                <?php echo validation_errors("<div class='error'>", '</div>'); ?>
                <form id="<?php echo $formulario; ?>" method="post" action="<?php echo $action; ?>">
                    <div id="datosGenerales">
                        <table class="fuente8" width="98%" cellspacing=0 cellpadding="6" border="0">
                            <tr>
                                <td>
                                    <input type="hidden" id="idPersona" value="<?php echo $idPersona; ?>" name="idPersona"/>
                                    Empleado
                                </td>
                                <td>
                                    <select name="directivo" id="directivo" class="cboDirectivo" style="width:150px;"><?php echo $cboDirectivo; ?></select>
                                </td>
                            </tr>
                            <?php
                            foreach ($campos as $indice => $valor) {
                                ?>
                                <tr>
                                    <td width="16%"><?php echo $campos[$indice]; ?></td>
                                    <td><?php echo $valores[$indice] ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <td colspan="2">                                   
                                    <a href="javascript:;"  id="nuevoRegistro">Nuevo <image src="<?php echo base_url(); ?>images/add.png" name="agregarFila" id="agregarFila" border="0" alt="Agregar" /></a>
                                    <table id="tblEstablec" width="50%" class="fuente8" cellspacing="0" cellpadding="6" border="1">
                                        <tr align="center" bgcolor="#BBBB20" height="10px;">
                                            <td>Establecimiento</td>
                                            <td>Rol</td>
                                            <td>Default</td>
                                            <td>Borrar</td>
                                        </tr>
                                        <?php
                                        if (count($lista) > 0) {
                                            foreach ($lista as $indice => $valor) {
                                                $class = $indice % 2 == 0 ? 'itemParTabla' : 'itemImparTabla';
                                                ?>
                                                <tr class="<?php echo $class; ?>">
                                                    <td><div align="left"><?php echo $valor[0]; ?></div></td>
                                                    <td><div align="left"><?php echo $valor[1]; ?></div></td>
                                                    <td><div align="center"><?php echo $valor[2]; ?></div></td>
                                                    <td><div align="center"><?php echo $valor[3]; ?></div></td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div style="margin-top:20px; text-align: center">
                        <img id="loading" src="<?php echo base_url(); ?>images/loading.gif"  style="visibility: hidden" />
                        <a href="javascript:;" id="grabarUsuario"><img src="<?php echo base_url(); ?>images/botonaceptar.jpg" width="85" height="22" class="imgBoton" ></a>
                        <a href="javascript:;" id="limpiarUsuario"><img src="<?php echo base_url(); ?>images/botonlimpiar.jpg" width="69" height="22" class="imgBoton" ></a>
                        <a href="javascript:;" id="cancelarUsuario"><img src="<?php echo base_url(); ?>images/botoncancelar.jpg" width="85" height="22" class="imgBoton"></a>
                            <?php echo $oculto ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>