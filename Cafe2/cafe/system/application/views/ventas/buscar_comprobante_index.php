<div id="contenedor-busqueda" >
    <div id="frmResultado">
        <table class="fuente8" width="100%" cellspacing="0" cellpadding="3" border="0" ID="Table1">
            <tr class="cabeceraTabla">
                <td width="4%">ITEM</td>
                <td width="5%">FECHA</td>
                <td width="5%">SERIE</td>
                <td width="6%">NUMERO</td>
                <td width="9%">GUIA REMISION</td>
                <td width="13%">DOC. REFERENCIA</td>
                <td>RAZON SOCIAL</td>
                <td width="9%">TOTAL</td>
                <td width="4%">ESTADO</td>
                <td width="4%">&nbsp;</td>
                <?php if ($tipo_oper == 'V') { ?>
                    <td width="4%">&nbsp;</td>
                    <td width="4%">&nbsp;</td>
                    <?php if ($tipo_docu == 'N') {
                        ?>
                        <td width="4%">&nbsp;</td>
                    <?php
                    }
                    ?>
                <?php
                } else {
                    ?>
                    <td width="4%">&nbsp;</td>
                    <td width="4%">&nbsp;</td>
                <?php
                }
                ?>
                <td width="8%">&nbsp;</td>
            </tr>
            <?php
            if (count($lista) > 0) {
                foreach ($lista as $indice => $valor) {
                    $class = $indice % 2 == 0 ? 'itemParTabla' : 'itemImparTabla';
                    ?>
                    <tr class="<?php echo $class; ?>">
                        <td>
                            <div align="center"><?php echo $valor[0]; ?></div>
                        </td>
                        <td>
                            <div align="center"><?php echo $valor[1]; ?></div>
                        </td>
                        <td>
                            <div align="center"><?php
                                if ($valor[13] == 2)
                                    echo '---';
                                else
                                    echo $valor[2];
                                ?></div>
                        </td>
                        <td>
                            <div align="center"><?php
                                if ($valor[13] == 2)
                                    echo '------';
                                else
                                    echo $valor[3];
                                ?></div>
                        </td>
                        <td>
                            <div align="center"><?php echo $valor[4]; ?></div>
                        </td>
                        <td>
                            <div align="center"><?php echo $valor[5]; ?></div>
                        </td>
                        <td>
                            <div align="left"><?php echo $valor[6]; ?></div>
                        </td>
                        <td>
                            <div align="right"><?php echo $valor[7]; ?></div>
                        </td>
                        <td>
                            <div align="center"><?php echo $valor[8]; ?></div>
                        </td>
                        <td>
                            <div align="center"><?php echo $valor[9]; ?></div>
                        </td>
                        <?php if ($tipo_oper == 'V') { // 10 y 11 - Imprimir y PDF  ?>
                            <?php if ($valor[10] != "") { ?>
                                <td>
                                    <div align="center"><?php echo $valor[10]; ?></div>
                                </td>
                            <?php } ?>
                            <td colspan="<?php echo $valor[16]; ?>" >
                                <div align="center"><?php echo $valor[11]; ?></div>
                            </td>
                            <?php
                            if ($tipo_docu == 'N') {
                                ?>
                                <td width="4%" colspan="5">
                                    <?php
                                    if ($valor[13] == 1)
                                        if ($valor[15] == '' || $valor[15] == NULL || $valor[15] == 0)
                                            echo '<a href="' . base_url() . 'index.php/ventas/comprobante/canje_documento/' . $valor[14] . '" class="canjear_doc">Canjear</a>';
                                    ?>
                                </td>
                            <?php
                            }
                            ?>
                        <?php } else { ?>
                            <?php if ($valor[10] != "") { ?>
                                <td>
                                    <div align="center"><?php echo $valor[10]; ?></div>
                                </td>
                            <?php } ?>
                            <td colspan="<?php echo $valor[16]; ?>">
                                <div align="center"><?php echo $valor[11]; ?></div>
                            </td>
                        <?php } ?>
                        <?php if ($valor[12] != "") { ?>
                            <td>
                                <div align="center"><?php echo $valor[12]; ?></div>
                            </td>
                        <?php } ?>
                    </tr>


                <?php
                }
            } else {
                ?>

                <tr>
                    <td colspan="16">
                        <table width="100%" cellspacing="0" cellpadding="3" border="0" class="fuente8">
                            <tbody>
                            <tr>
                                <td width="100%" class="mensaje">No hay ning&uacute;n registro que cumpla
                                    con los criterios de b&uacute;squeda
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            <?php
            }
            ?>

            <tr height="28" class="itemImparTabla">
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="left"></div>
                </td>
                <td>
                    <div align="left"></div>
                </td>
                <td>
                    <div align="left"></div>
                </td>
                <td>
                    <div align="right"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
            </tr>

            <tr height="28" class="itemParTabla">
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="left"></div>
                </td>
                <td>
                    <div align="left"></div>
                </td>
                <td>
                    <div align="left"></div>
                </td>
                <td>
                    <div align="right"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
            </tr>

            <tr height="28" class="itemImparTabla">
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="left"></div>
                </td>
                <td>
                    <div align="left"></div>
                </td>
                <td>
                    <div align="left"></div>
                </td>
                <td>
                    <div align="right"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
            </tr>

            <tr height="28" class="itemParTabla">
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="left"></div>
                </td>
                <td>
                    <div align="left"></div>
                </td>
                <td>
                    <div align="left"></div>
                </td>
                <td>
                    <div align="right"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
            </tr>

            <tr height="28" class="itemImparTabla">
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="left"></div>
                </td>
                <td>
                    <div align="left"></div>
                </td>
                <td>
                    <div align="left"></div>
                </td>
                <td>
                    <div align="right"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
            </tr>

            <tr height="28" class="itemParTabla">
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="left"></div>
                </td>
                <td>
                    <div align="left"></div>
                </td>
                <td>
                    <div align="left"></div>
                </td>
                <td>
                    <div align="right"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
            </tr>

            <tr height="28" class="itemImparTabla">
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="left"></div>
                </td>
                <td>
                    <div align="left"></div>
                </td>
                <td>
                    <div align="left"></div>
                </td>
                <td>
                    <div align="right"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
            </tr>

            <tr height="28" class="itemParTabla">
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="left"></div>
                </td>
                <td>
                    <div align="left"></div>
                </td>
                <td>
                    <div align="left"></div>
                </td>
                <td>
                    <div align="right"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
            </tr>

            <tr height="28" class="itemImparTabla">
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="left"></div>
                </td>
                <td>
                    <div align="left"></div>
                </td>
                <td>
                    <div align="left"></div>
                </td>
                <td>
                    <div align="right"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
            </tr>

            <tr height="28" class="itemParTabla">
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="left"></div>
                </td>
                <td>
                    <div align="left"></div>
                </td>
                <td>
                    <div align="left"></div>
                </td>
                <td>
                    <div align="right"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
            </tr>

            <tr height="28" class="itemImparTabla">
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="left"></div>
                </td>
                <td>
                    <div align="left"></div>
                </td>
                <td>
                    <div align="left"></div>
                </td>
                <td>
                    <div align="right"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
            </tr>

            <tr height="28" class="itemParTabla">
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="left"></div>
                </td>
                <td>
                    <div align="left"></div>
                </td>
                <td>
                    <div align="left"></div>
                </td>
                <td>
                    <div align="right"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
            </tr>

            <tr height="28" class="itemImparTabla">
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="left"></div>
                </td>
                <td>
                    <div align="left"></div>
                </td>
                <td>
                    <div align="left"></div>
                </td>
                <td>
                    <div align="right"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
                <td>
                    <div align="center"></div>
                </td>
            </tr>


        </table>
    </div>
    <div style="margin-top: 15px;"><?php echo $paginacion; ?></div>
    <input type="hidden" id="iniciopagina" name="iniciopagina">
    <?php echo $oculto ?>
</div>