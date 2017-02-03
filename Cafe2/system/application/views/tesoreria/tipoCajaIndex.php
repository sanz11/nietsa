<?php
$nombre_persona = $this->session->userdata('nombre_persona');
$persona = $this->session->userdata('persona');
$usuario = $this->session->userdata('usuario');
$url = base_url() . "index.php";
if (empty($persona))
    header("location:$url");
$CI = get_instance();
?>
<html>
    <head>

        <script type="text/javascript" src="<?php echo base_url(); ?>js/tesoreria/tipocaja.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />

    </head>
    <body>
        <div id="pagina">
            <div id="zonaContenido">
                <div align="center">
                    <div id="tituloForm" class="header"><?php echo $titulo_busqueda; ?></div>
 
 <form id="form_busqueda" name="form_busquedaCuenta" method="post" action="<?php echo base_url(); ?>index.php/tesoreria/tipocaja/tipocajas">
 <div id="frmBusqueda" >
   <table class="fuente8" width="98%" cellspacing="0" cellpadding="3" border="0">
      <tr>
       <td align='left' width="10%">Fecha inicial</td>
     <td align='left' width="90%">
       <input name="fechai" id="fechai" value="<?php echo $fechai; ?>" type="text" class="cajaGeneral" size="10" maxlength="10" autofocus/>
        <img src="<?php echo base_url(); ?>images/calendario.png" name="Calendario1" id="Calendario1" width="16" height="16" border="0" onMouseOver="this.style.cursor='pointer'" title="Calendario"/>
     <script type="text/javascript">
   Calendar.setup({
     inputField     :    "fechai",      // id del campo de texto
    ifFormat       :    "%d/%m/%Y",       // formato de la fecha, cuando se escriba en el campo de texto
    button         :    "Calendario1"   // el id del botón que lanzará el calendario
   });
    </script>
 <label style="margin-left: 90px;">Fecha final</label>
  <input name="fechaf" id="fechaf" value="<?php echo $fechaf; ?>" type="text" class="cajaGeneral" size="10" maxlength="10" />
   <img src="<?php echo base_url(); ?>images/calendario.png" name="Calendario2" id="Calendario2" width="16" height="16" border="0" onMouseOver="this.style.cursor='pointer'" title="Calendario2"/>
  <script type="text/javascript">
  Calendar.setup({
  inputField     :    "fechaf",      // id del campo de texto
    ifFormat       :    "%d/%m/%Y",       // formato de la fecha, cuando se escriba en el campo de texto
    button         :    "Calendario2"   // el id del botón que lanzará el calendario
    });
   </script>
    </td>   
  <tr>
   <td align='left'>Tipo</td>
        <td align='left'>
          <select name="txtTipo" id="txtTipo" class="comboGrande" style="font-size: 15px">
          <?php
if($txtCodigoT=="" || $txtCodigoT==3){
  ?>
<option value="3" selected="selected">TODOS</option>
<option value="1">Tipo Caja 1</option>
<option value="2">Tipo Caja 2</option>
  <?php
}elseif ($txtCodigoT==1) {
?>
<option value="3" >TODOS</option>
<option value="1" selected="selected">Tipo Caja 1</option>
<option value="2">Tipo Caja 2</option>
<?php
}else{
 ?>
<option value="3" >TODOS</option>
<option value="1" >Tipo Caja 1</option>
<option value="2" selected="selected">Tipo Caja 2</option>
 <?php 
}
?>
</select>
<input type="hidden" name="txtCodigoT" id="txtCodigoT" value="<?=$txtCodigoT?>">                           
  </td>
  </tr>
   </table>
   </div>
<div class="acciones">
<div id="botonBusqueda">
 <!--<ul id="imprimirTipocaja"  class="lista_botones"><li id="imprimir">Imprimir</li></ul>-->
<ul id="nuevoTipocaja"     class="lista_botones"> <li id="nuevo">  Nuevo Caja </li></ul>
<ul id="limpiarTipocaja"   class="lista_botones"><li id="limpiar">Limpiar</li></ul>
<ul id="buscarTipocaja" onkeypress="{if (event.keyCode==13)fireMyFunction()}"   class="lista_botones"><li id="buscar">Buscar</li></ul>
 </div>
                        <div id="lineaResultado">
 <table class="fuente7" width="100%" cellspacing="0" cellpadding="3" border="0">
                                <tr>
 <td width="50%" align="left">numero de tipo caja <?=$registros; ?> </td>
                            </table>
                        </div>
</div>
                        <div id="cabeceraResultado" class="header"><?php
                                    echo $titulo_tabla;
                                    ?></div>
                        <div id="frmResultado">
<table class="fuente8" width="100%" cellspacing="0" cellpadding="3" border="0" ID="Table1" >
          <tr class="cabeceraTabla">
              <td width="4%">ITEM</td>
               <td width="4%">Fecha</td>
              <td width="8%">Descripción</td>
                                   
              <td width="2%"></td>
                                    
               <td width="3%">Estado</td>
              <td width="5%">Acciones</td>
          </tr>
                                <?php
 if (count($lista) > 0) {
  foreach ($lista as $indice => $valor) {
    $class = $indice%2==0?'itemParTabla':'itemImparTabla';
    ?>
<tr class="<?php echo $class;?>">
  <td align="center">
    <?=$valor[0]?>
  </td>
  <td align="center">
    <?=mysql_to_human($valor[7])?>
  </td>
  <td align="center">
    <?=$valor[1]?>
  </td>
  <td align="center">
    <?=$valor[3]?>
  </td>
  
  <td align="center">
   <?=$valor[13]?>&nbsp;&nbsp;
    
  </td>
  <td align="center">
   <?=$valor[10]?>&nbsp;&nbsp;
    <?=$valor[11]?>&nbsp;&nbsp;
    <?=$valor[12]?>
  </td>
</tr>
    <?php
    }
   } else {
                                    ?>
                                    <tr>
                                        <td colspan="12">
                                            <table width="100%" cellspacing="0" cellpadding="3" border="0" class="fuente8">
                                                <tbody>
                                                <tr>
                                                    <td width="100%" class="mensaje">No hay ning&uacute;n registro que cumpla con los criterios de b&uacute;squeda</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </table>
                        </div>
                        <div style="margin-top: 15px;"><?php echo $paginacion; ?></div>
                        <input type="hidden" id="iniciopagina" name="iniciopagina">
                        <?php echo $oculto ?>
                    </form>
                </div>
            </div>
        </div>
<div id="cajaFlotante" style="display: none;">
    <div class="content-popup">
   <div class="close"><a href="#" id="close"><img src="<?=base_url()?>images/icono_desaprobar.png"/></a></div>
        <div>
          <h2>VISTA DE TIPO DE CAJA</h2>
        
    <p> <n>Descripción: </n><span id="tipCa_Descripcion"></span></p>
    <p><n>Abreviatura:</n> <span id="tipCa_Abreviaturas"></span></p>
    <p><n>Tipo caja: </n><span id="tipCa_Tipo"></span></p>
    <p><n>Fecha Registro:</n><span id="tipCa_FechaRegsitro"></span></p>
    <p><n>Fecha Modificación:</n><span id="tipCa_fechaModificacion"></span></p>
    <p><n>Usuario Registro: </n><span id="UsuarioModificado"></span></p>
    <p><n>Usuario Modificado:</n><span id="UsuarioRegistro"></span> </p>
    <img  src="<?=base_url()?>images/botoncancelar.jpg">
        </div>
    </div>
</div>
<style type="text/css">
  
#cajaFlotante {
  left: 0;
    position: absolute;
    top:0;
    width: 100%;
    z-index: 1001;
}

.content-popup {
  margin:0px auto;
  margin-top:10%;
  position:relative;
  padding:10px;
  width:30%;
  min-height:20%;
  border-radius:4px;
  background-color:#FFFFFF;
  box-shadow: 0 2px 5px #666666;
}

.content-popup h2 {
  color:#48484B;
  border-bottom: 1px solid #48484B;
    margin-top: 0;
    padding-bottom: 4px;
}

.popup-overlay {
  left: 0;
    position: absolute;
    top: 0;
    width: 100%;
    z-index: 999;
  display:none;
  background-color: #777777;
    cursor: pointer;
    opacity: 0.7;
}

.close {
  position: absolute;
  right: 15px;
}
</style>
    </body>
</html>