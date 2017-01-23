<?php
ini_set('error_reporting', 1);

include("system/application/libraries/cezpdf.php");
include("system/application/libraries/class.backgroundpdf.php");


class Guiarem extends controller
{

    private $_hoy;

    public function __construct()
    {
        parent::Controller();
        $this->load->model('almacen/guiarem_model');
        $this->load->model('almacen/guiasa_model');
        $this->load->model('almacen/guiain_model');
        $this->load->model('almacen/guiaremdetalle_model');
        $this->load->model('almacen/guiasadetalle_model');
        $this->load->model('almacen/guiaindetalle_model');
        $this->load->model('almacen/almacen_model');
        $this->load->model('almacen/seriemov_model');
        $this->load->model('almacen/Serie_model');
        $this->load->model('almacen/seriedocumento_model');
        $this->load->model('almacen/almacenproducto_model');
        $this->load->model('almacen/almacenproductoserie_model');
        $this->load->model('almacen/producto_model');
        $this->load->model('almacen/unidadmedida_model');
        $this->load->model('almacen/tipomovimiento_model');
        $this->load->model('maestros/documento_model');
        $this->load->model('maestros/compania_model');
        $this->load->model('maestros/ubigeo_model');
        $this->load->model('maestros/empresa_model');
        $this->load->model('maestros/companiaconfiguracion_model');
        $this->load->model('maestros/companiaconfidocumento_model');
        $this->load->model('maestros/moneda_model');
        $this->load->model('maestros/emprestablecimiento_model');
        $this->load->model('compras/ocompra_model');
        $this->load->model('compras/cotizacion_model');
        $this->load->model('compras/proveedor_model');
        $this->load->model('ventas/cliente_model');
        $this->load->model('ventas/presupuesto_model');
        $this->load->model('ventas/comprobante_model');
        $this->load->model('seguridad/usuario_model');
        $this->load->model('almacen/marca_model');
        $this->load->helper('form', 'url');
        $this->load->helper('utf_helper');
        $this->load->helper('util_helper');
        $this->load->helper('my_almacen');
        $this->load->library('pagination');
        $this->load->library('form_validation');
        $this->somevar['rol'] = $this->session->userdata('rol');
        $this->somevar['user'] = $this->session->userdata('user');
        $this->somevar['compania'] = $this->session->userdata('compania');
        $this->somevar['empresa'] = $this->session->userdata('empresa');
        $this->somevar['establec'] = $this->session->userdata('establec');
        date_default_timezone_set('America/Lima');
        $this->_hoy = mdate("%Y-%m-%d ", time());

    }

    public function listar($tipo_oper = 'V', $j = 0, $limpia = '')
    {
        $this->load->library('layout', 'layout');
        $data['compania'] = $this->somevar['compania'];
        $this->session->unset_userdata('serie');
        if ($limpia == '1') {
            $this->session->unset_userdata('fechai');
            $this->session->unset_userdata('fechaf');
            $this->session->unset_userdata('serie');
            $this->session->unset_userdata('numero');
            $this->session->unset_userdata('cliente');
            $this->session->unset_userdata('ruc_cliente');
            $this->session->unset_userdata('nombre_cliente');
            $this->session->unset_userdata('proveedor');
            $this->session->unset_userdata('ruc_proveedor');
            $this->session->unset_userdata('nombre_proveedor');
            $this->session->unset_userdata('producto');
            $this->session->unset_userdata('codproducto');
            $this->session->unset_userdata('nombre_producto');
        }
        $filter = new stdClass();
        if (count($_POST) > 0) {
            $filter->fechai = $this->input->post('fechai');
            $filter->fechaf = $this->input->post('fechaf');
            $filter->serie = $this->input->post('serie');
            $filter->numero = $this->input->post('numero');
            $filter->cliente = $this->input->post('cliente');
            $filter->ruc_cliente = $this->input->post('ruc_cliente');
            $filter->nombre_cliente = $this->input->post('nombre_cliente');
            $filter->proveedor = $this->input->post('proveedor');
            $filter->ruc_proveedor = $this->input->post('ruc_proveedor');
            $filter->nombre_proveedor = $this->input->post('nombre_proveedor');
            $filter->producto = $this->input->post('producto');
            $filter->codproducto = $this->input->post('codproducto');
            $filter->nombre_producto = $this->input->post('nombre_producto');
            $this->session->set_userdata(array('fechai' => $filter->fechai, 'fechaf' => $filter->fechaf, 'serie' => $filter->serie, 'numero' => $filter->numero, 'cliente' => $filter->cliente, 'ruc_cliente' => $filter->ruc_cliente, 'nombre_cliente' => $filter->nombre_cliente, 'proveedor' => $filter->proveedor, 'ruc_proveedor' => $filter->ruc_proveedor, 'nombre_proveedor' => $filter->nombre_proveedor, 'producto' => $filter->producto, 'codproducto' => $filter->codproducto, 'nombre_producto' => $filter->nombre_producto));
        } else {
            $filter->fechai = $this->session->userdata('fechai');
            $filter->fechaf = $this->session->userdata('fechaf');
            $filter->serie = $this->session->userdata('serie');
            $filter->numero = $this->session->userdata('numero');
            $filter->cliente = $this->session->userdata('cliente');
            $filter->ruc_cliente = $this->session->userdata('ruc_cliente');
            $filter->nombre_cliente = $this->session->userdata('nombre_cliente');
            $filter->proveedor = $this->session->userdata('proveedor');
            $filter->ruc_proveedor = $this->session->userdata('ruc_proveedor');
            $filter->nombre_proveedor = $this->session->userdata('nombre_proveedor');
            $filter->producto = $this->session->userdata('producto');
            $filter->codproducto = $this->session->userdata('codproducto');
            $filter->nombre_producto = $this->session->userdata('nombre_producto');
        }
        $data['fechai'] = $filter->fechai;
        $data['fechaf'] = $filter->fechaf;
        $data['serie'] = $filter->serie;
        $data['numero'] = $filter->numero;
        $data['cliente'] = $filter->cliente;
        $data['ruc_cliente'] = $filter->ruc_cliente;
        $data['nombre_cliente'] = $filter->nombre_cliente;
        $data['proveedor'] = $filter->proveedor;
        $data['ruc_proveedor'] = $filter->ruc_proveedor;
        $data['nombre_proveedor'] = $filter->nombre_proveedor;
        $data['producto'] = $filter->producto;
        $data['codproducto'] = $filter->codproducto;
        $data['nombre_producto'] = $filter->nombre_producto;

        $data['registros'] = $this->guiarem_model->buscar_totalFilas($tipo_oper, $filter);
        $data['cantidad']=$this->guiarem_model->countFilas($tipo_oper, $filter);
       
        $conf['base_url'] = site_url('almacen/guiarem/listar/' . $tipo_oper);
        $conf['per_page'] = 20;
        $conf['num_links'] = 4;
        $conf['first_link'] = "&lt;&lt;";
        $conf['last_link'] = "&gt;&gt;";
        $conf['total_rows'] = $data['registros'];
        $conf['total_rows']=$data['cantidad'];
        $conf['uri_segment'] = 5;
        $offset = $j;
        $listado = $this->guiarem_model->buscar($tipo_oper, $filter, $conf['per_page'], $offset);
        
        $item = $j + 1;
        $lista = array();
        if (count($listado) > 0) {
            foreach ($listado as $indice => $valor) {
                
                $letraParaConvertir = "GR"; 
                $arrayConversorDeNumero = $this->documento_model->obtenerAbreviatura($letraParaConvertir);  
                foreach ($arrayConversorDeNumero as $valueConvert) {
                    $ConversorDeNumero = $valueConvert->DOCUP_Codigo;
                }


                $codigo = $valor->GUIAREMP_Codigo;
                //$list_com = $this->comprobante_model->obtener_comprobante_ref2($codigo);
                $estadoAsociacion='';
                $listaGuiaremAsociados=$this->guiarem_model->buscarGuiaremComprobante($codigo,$estadoAsociacion);
                if (count($listaGuiaremAsociados) > 0) {
                	$tipo_o = $listaGuiaremAsociados[0]->CPC_TipoOperacion;
                	$tipo_d = $listaGuiaremAsociados[0]->CPC_TipoDocumento;
                	$comp_id = $listaGuiaremAsociados[0]->CPP_Codigo;
                	$comp = $listaGuiaremAsociados[0]->CPC_Serie . '-' . $listaGuiaremAsociados[0]->CPC_Numero;
                	if ($tipo_d == "F") {
                		$comprobante = '<a href="' . base_url() . 'index.php/ventas/comprobante/comprobante_ver/' . $comp_id . '/' . $tipo_o . '/' . $tipo_d . '" id="comprobante" name="comprobante">' . $comp . '</a>';
                		$boleta = '';
                	} else {
                		$comprobante = '';
                		$boleta = '<a href="' . base_url() . 'index.php/ventas/comprobante/comprobante_ver/' . $comp_id . '/' . $tipo_o . '/' . $tipo_d . '" id="comprobante" name="comprobante">' . $comp . '</a>';
                	}
                } else {
                	$comprobante = "";
                	$boleta = "";
                }
                 
                
                
                
                
                $fecha = mysql_to_human($valor->GUIAREMC_FechaTraslado);
                $serie = $valor->GUIAREMC_Serie;
                $numero = $valor->GUIAREMC_Numero;
                $codigo_usuario = $valor->GUIAREMC_CodigoUsuario;
                $nombre_almacen = $valor->ALMAC_Descripcion;
                $numeroref = $valor->GUIAREMC_NumeroRef;
                $nombre = $valor->nombre;
                $estado = $valor->GUIAREMC_FlagEstado;
                $oc = $valor->OCOMP_Codigo;
                $TipoGuia=$valor->GUIAREMC_TipoGuia;
                $img_estado = "";
                
                
                
                
                if($TipoGuia!=1){
	                if ($this->somevar['rol'] == '4') {
	                    $editar = "<a href='javascript:;' onclick='editar_guiarem(" . $codigo . ")'><img src='" . base_url() . "images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
	                }
	                else {
	                    $editar = "<img src='" . base_url() . "images/icono_aprobar.png' width='16' height='16' border='0' title='Aprobado' style='cursor: pointer'>";
	                }
	
	                if($numeroref != ""){
	                    $editar = '<a href="#" onClick="relacionado_comprobante('."'.$numeroref.'".')" ><img src="'.base_url().'images/relacion_comprobante.png" width="16" height="16" border="0" title="Relacionado" /></a>';
	                }
	
	                if ($estado == '2' && $tipo_oper == 'V' && $numeroref == '')
	                    $ver = "<a href='javascript:;' onclick='comprobante_ver_pdf_conmenbrete(" . $codigo.", ".$ConversorDeNumero . ")'><img src='" . base_url() . "images/icono_imprimir.png' width='16' height='16' border='0' title='Imprimir'></a>";
	                else
	                    $ver = '';
	                    $num = 1;
	                    $tipo_oper2 = $tipo_oper;
	                $ver2 = "<a href='javascript:;' onclick='comprobante_ver_pdf_conmenbrete(" . $codigo .",".$ConversorDeNumero.",".$num.",".'"V"'.")'><img src='" . base_url() . "images/pdf.png' width='16' height='16' border='0' title='Ver PDF'></a>";
	                 
	                if ($estado == '2' && $numeroref == '')
	                    $disparador = "<a href='javascript:;' onclick='disparador(" . $codigo . ")' >Por Aprobar</a>";
	                else
	                    $disparador = "";
		
	
	                
	                
	                if ($oc != '') {
	                    $datos_ocompra = $this->ocompra_model->obtener_ocompra($oc);
	                    $orden_compra = '<a href="' . base_url() . 'index.php/compras/ocompra/ver_ocompra/' . $oc . '/' . $tipo_oper . '" id="ocompra" name="ocompra">' . $datos_ocompra[0]->OCOMC_Serie . '-' . $datos_ocompra[0]->OCOMC_Numero . '</a>';
	                } else {
	                    $orden_compra = "";
	                }
	
	                if ($oc != "" || count($list_com) > 0 || $numeroref != "") {
	                    $eliminar = "<img src='" . base_url() . "images/icono-factura.gif' height='16px' alt='Activo' title='Relacionado' />";
	                } else {
	                    $eliminar = ($estado == '1' || $estado == '2' ? "<a href='" . base_url() . "index.php/seguridad/usuario/ventana_confirmacion_usuario2/guiarem/" . $codigo . "' id='linkVerProveedor'><img src='" . base_url() . "images/eliminar.png' alt='Activo' title='Eliminar' /></a> " : "<img src='" . base_url() . "images/inactive.png' alt='Anulado' title='Eliminar' />");
	                		
	                }
	
	                if($estado != '0'){
	                		$view_estado = "<a href='#' ><img src='" . base_url() . "images/active.png' alt='Activo' title='Activo' /></a>";
	                }else{
	                    $view_estado = "<img src='" . base_url() . "images/inactive.png' alt='Activo' title='Inactivo' />";
	                }
                }else{
                	
                	/**si se puede editar**/
                	if($estado==2)
                		$editar = "<a href='javascript:;' onclick='editar_guiarem(" . $codigo . ")'><img src='" . base_url() . "images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
                	else 
                		$editar ='';
                	
                	$img=0;
                	if($estado==1)
                		$ver = "<a href='javascript:;' onclick='comprobante_ver_pdf_conmenbrete(" . $codigo.", ".$ConversorDeNumero .",".$img.")'><img src='" . base_url() . "images/icono_imprimir.png' width='16' height='16' border='0' title='Imprimir'></a>";
                	else
                		$ver ="";
                	$img=1;
                	$ver2 = "<a href='javascript:;' onclick='comprobante_ver_pdf_conmenbrete(" . $codigo.", ".$ConversorDeNumero.",".$img.",".'"V"'.")'><img src='" . base_url() . "images/pdf.png' width='16' height='16' border='0' title='Ver PDF'></a>";
                	$disparador = "";
                	$eliminar ="";
                	$orden_compra = "";
                	
                	
                	if($estado==2)
                		$view_estado = "<a href='#' ><img src='" . base_url() . "images/proceso.png' alt='Activo' title='Activo' /></a>";
                	else
                		$view_estado = "<a href='#' ><img src='" . base_url() . "images/active.png' alt='Activo' title='Activo' /></a>";
                
                }
                
                
                
                $lista[] = array($item++, $fecha, $serie,$this->getOrderNumeroSerie($numero), $codigo_usuario, $nombre_almacen, $nombre, $img_estado, $editar, $ver, $ver2, $eliminar, $orden_compra, $comprobante, $boleta, $disparador, $view_estado);//comprobante, boleta
           
            
            }
        }

        $data['lista'] = $lista;
        $data['titulo_busqueda'] = "Buscar GUIA DE REMISI&Oacute;N";
        $data['titulo_tabla'] = "Relaci&oacute;n de GUIAS DE REMISION";
        $data['accion'] = base_url() . 'index.php/almacen/guiarem/listar/' . $tipo_oper . '/0/';
        $data['oculto'] = form_hidden(array('base_url' => base_url(), 'tipo_oper' => $tipo_oper));
        $data['tipo_oper'] = $tipo_oper;
        $this->pagination->initialize($conf);
        $data['paginacion'] = $this->pagination->create_links();
        $this->layout->view('almacen/guiarem_index', $data);
    }


    public function nueva($tipo_oper = 'V')
    {

        $this->load->library('layout', 'layout');
        /**gcbq limpiamos la session de series guardadas**/
        unset($_SESSION['serie']);
        unset($_SESSION['serieReal']);
        unset($_SESSION['serieRealBD']);
        /**fin de limpiar session***/

        $data_confi = $this->companiaconfiguracion_model->obtener($this->somevar['compania']);
        $tipo = 10;
		$data_confi_docu = $this->companiaconfidocumento_model->obtener($data_confi[0]->COMPCONFIP_Codigo, 10);
		$data_confi1 = $this->configuracion_model->obtener_numero_documento($this->somevar['compania'], $tipo);
       
        $compania = $this->somevar['compania'];
        $data['compania'] = $compania;
        $usuario = $this->somevar['user'];
        $datos_usuario = $this->usuario_model->obtener($usuario);
        $nombre_usuario = $datos_usuario->PERSC_Nombre . " " . $datos_usuario->PERSC_ApellidoPaterno;
        $data['guia'] = "";
        $data['titulo'] = "NUEVA GUIA DE REMISION";
        $data['codigo'] = "";
        $data['tipo_oper'] = $tipo_oper;
        $data['contiene_igv'] = (($data_confi[0]->COMPCONFIC_PrecioContieneIgv == '1') ? true : false);
        $data['form_open'] = form_open(base_url() . 'index.php/almacen/guiarem/grabar', array("name" => "frmGuiarem", "id" => "frmGuiarem"));
        $data['oculto'] = form_hidden(array("base_url" => base_url(), 'tipo_oper' => $tipo_oper, "guiarem_id" => '', 'guiasa_id' => '', "centro_costo" => 1, "accion" => "n", 'contiene_igv' => ($data['contiene_igv'] == true ? '1' : '0'), "igv" => $data_confi[0]->COMPCONFIC_Igv, "tipo_codificacion" => $data_confi_docu[0]->COMPCONFIDOCP_Tipo));
        $data['serie'] = "";
        $data['numero'] = "";
        $data['codigo_usuario'] = "";
        $data['fecha'] = form_input(array("name" => "fecha", "id" => "fecha", "class" => "cajaPequena cajaSoloLectura", "readonly" => "readonly", "maxlength" => "10", "value" => mysql_to_human($this->_hoy)));
        $data['nombre_usuario'] = form_input(array("name" => "nombre_usuario", "id" => "nombre_usuario", "class" => "cajaMedia", "readonly" => "readonly", "maxlength" => "30", "value" => $nombre_usuario));
        $data['recepciona_nombres'] = form_input(array("name" => "recepciona_nombres", "id" => "recepciona_nombres", "class" => "cajaGeneral", "size" => "27", "maxlength" => "150"));
        $data['recepciona_dni'] = form_input(array("name" => "recepciona_dni", "id" => "recepciona_dni", "class" => "cajaGeneral", "size" => "10", "maxlength" => "8"));
        $atributos = array('width' => 600,
            'height' => 400,
            'scrollbars' => 'yes',
            'status' => 'yes',
            'resizable' => 'yes',
            'screenx' => '0',
            'screeny' => '0');
        $contenido = "<img height='16' width='16' src='" . base_url() . "images/ver.png' title='Buscar' border='0'>";
        $data['vercliente'] = anchor_popup('ventas/cliente/ventana_busqueda_cliente', $contenido, $atributos);
        $data['verproducto'] = "<a href='#' id='verCliente' onclick='busqueda_producto_x_almacen();'>" . $contenido . "</a>";
        $data['hidden'] = "";
        $data['cliente'] = "";
        $data['ruc_cliente'] = "";
        $data['nombre_cliente'] = "";
        $data['proveedor'] = "";
        $data['nombre_proveedor'] = "";
        $data['ruc_proveedor'] = "";
        $data['detalle'] = array();
        $filterin = new stdClass();
        $filterin->TIPOMOVC_Tipo = 2;
        $lista_almacen = $this->almacen_model->seleccionar();
        $lista_miEstablec = $this->emprestablecimiento_model->obtener($this->somevar['establec']);
        $direccion_miEstablec = $lista_miEstablec[0]->EESTAC_Direccion . ' ' . $lista_miEstablec[0]->distrito . ' - ' . $lista_miEstablec[0]->provincia . ' - ' . $lista_miEstablec[0]->departamento;

        $data['cboAlmacen'] = form_dropdown("almacen", $lista_almacen, obtener_val_x_defecto($lista_almacen), " class='cajaGrande' id='almacen'");
        $data['cboDocumento'] = form_dropdown("referencia", $this->documento_model->seleccionar('1'), "1", " class='comboMedio' style='width:140px' id='referencia'");
        $data['cboTipoMov'] = form_dropdown("tipo_movimiento", $this->tipomovimiento_model->seleccionar($filterin), "0", " class='comboMedio' id='tipo_movimiento'");
        $data['otro_motivo'] = form_input(array("name" => "otro_motivo", "id" => "otro_motivo", "class" => "cajaMedia", "style" => "width:auto", "maxlength" => "250"));
        $data['cboEmpresaTrans'] = form_dropdown("empresa_transporte", $this->empresa_model->seleccionar(), "1", " class='comboGrande' id='empresa_transporte' style='width:300px'");
        $data['cboMoneda'] = form_dropdown("moneda", $this->moneda_model->seleccionar(), "1", " class='comboMedio' id='moneda' style='width:120px'");
        ///aumentado stv
        //$data['cboPresupuesto'] = $this->OPTION_generador($this->presupuesto_model->listar_presupuestos_noguiarem('F', '1689'), 'PRESUP_Codigo', array('PRESUC_Numero', 'nombre'), '', array('', '::Seleccione::'), ' / ');
        ////
        //$data['cboPresupuesto'] = $this->OPTION_generador($this->presupuesto_model->listar_presupuestos_noguiarem_cualquiera(), 'PRESUP_Codigo', array('PRESUC_Numero', 'nombre'), '', array('', '::Seleccione::'), ' / ');
        $data['cboFactura'] = ""; //$this->OPTION_generador($this->comprobante_model->listar_comprobantes_factura('V', 'F'), 'CPP_Codigo', array('CPC_Serie', 'CPC_Numero'), '', array('', '::Seleccione::'), ' / ');
        $data['cboCotizacion'] = ""; //form_dropdown("cotizacion", $this->cotizacion_model->seleccionar2(), "", " class='comboMedio' id='cotizacion' onchange='obtener_detalle_cotizacion();'");
        $data['form_close'] = form_close();
        ////////stv
        $data['seriecom'] = form_input(array("name" => "seriecom", "id" => "seriecom", "class" => "cajaGeneral", "size" => "5", "maxlength" => "10"));
        ////////
        $data['numero_ref'] = '';
        $data['ordencompra'] = '';
        $data['numero_ocompra'] = form_input(array("name" => "numero_ocompra", "id" => "numero_ocompra", "class" => "cajaGeneral", "size" => "23", "maxlength" => "50"));
        ///aumentado stv
        $datos_ocompra = $this->ocompra_model->obtener_ocompra(1);
        if (count($datos_ocompra) > 0) {
            $nombre_proveedor = '';
            $data['cboOrdencompra'] = "<option value='" . $datos_ocompra[0]->OCOMP_Codigo . "' selected='selected'>" . $datos_ocompra[0]->OCOMC_Numero . "-" . $nombre_proveedor . "</option>";
        }
        /////        
        ////bloqueado stv
        $data['cboOrdencompra'] = $this->OPTION_generador($this->ocompra_model->listar_ocompras_nocomprobante($tipo_oper), 'OCOMP_Codigo', array('OCOMC_Numero', 'nombre'), '', array('', '::Seleccione::'), ' - ');
        ///        
        $data['fecha_traslado'] = form_input(array("name" => "fecha_traslado", "id" => "fecha_traslado", "class" => "cajaPequena cajaSoloLectura", "maxlength" => "10", "value" => date('d/m/Y')));
        $data['nombre_conductor'] = form_input(array("name" => "nombre_conductor", "id" => "nombre_conductor", "class" => "cajaGeneral", "size" => "27", "maxlength" => "150"));
        $data['marca'] = form_input(array("name" => "marca", "id" => "marca", "class" => "cajaGeneral", "size" => "27", "maxlength" => "100"));
        $data['placa'] = form_input(array("name" => "placa", "id" => "placa", "class" => "cajaPequena", "maxlength" => "20"));
        $data['registro_mtc'] = form_input(array("name" => "registro_mtc", "id" => "registro_mtc", "class" => "cajaPequena", "maxlength" => "20"));
        $data['certificado'] = form_input(array("name" => "certificado", "id" => "certificado", "class" => "cajaPequena", "maxlength" => "10"));
        $data['licencia'] = form_input(array("name" => "licencia", "id" => "licencia", "class" => "cajaPequena", "maxlength" => "10"));
        $data['observacion'] = form_textarea(array("name" => "observacion", "id" => "observacion", "class" => "fuente8", "cols" => "108", "rows" => "3"));
        $data['punto_partida'] = form_input(array("name" => "punto_partida", "id" => "punto_partida", "class" => "cajaMedia", "size" => "50", "maxlength" => "250", "value" => ($tipo_oper == 'V' ? $direccion_miEstablec : '')));
        $data['punto_llegada'] = form_input(array("name" => "punto_llegada", "id" => "punto_llegada", "class" => "cajaMedia", "size" => "58", "maxlength" => "250", "value" => ($tipo_oper == 'C' ? $direccion_miEstablec : '')));
        $data['estado'] = form_dropdown("estado", array("1" => "Activo", "0" => "Anulado"), "1", " class='comboPequeno' id='estado'");
        $data['flagEstado'] =2;
        $data['observacion'] = "";
        $data['descuento'] = "0";
        $data['igv'] = $data_confi[0]->COMPCONFIC_Igv;
        $data['hidden'] = "";
        $data['preciototal'] = "";
        $data['descuentotal'] = "";
        $data['igvtotal'] = "";
        $data['importetotal'] = "";
        $data['modo'] = "insertar";
        $data['tipoGuia']=0;
/*
        $data['tipo_codificacion'] = $data_confi_docu[0]->COMPCONFIDOCP_Tipo;
        $data['serie_suger'] = $data_confi1[0]->CONFIC_Serie;
        $data['numero_suger'] = $data_confi1[0]->CONFIC_Numero + 1;
        $data['serie_suger'] = $data_confi1[0]->CONFIC_Serie;
        $data['numero_suger_c'] = $data_confi1[0]->CONFIC_Numero + 1;
      */ 
        if ($tipo_oper == 'V') {
            $serie = $data_confi_docu[0]->COMPCONFIDOCP_Serie;
 			$cofiguracion_datos = $this->configuracion_model->obtener_numero_documento($compania, $tipo);
            $data['tipo_codificacion'] = $data_confi_docu[0]->COMPCONFIDOCP_Tipo;
            $data['serie_suger'] = $cofiguracion_datos[0]->CONFIC_Serie;
            $data['numero_suger'] =$this->getOrderNumeroSerie($cofiguracion_datos[0]->CONFIC_Numero + 1);
        }

        if ($tipo_oper == 'C') {
            $serie = $data_confi_docu[0]->COMPCONFIDOCP_Serie;

            $data['tipo_codificacion'] = $data_confi_docu[0]->COMPCONFIDOCP_Tipo;
            $data['serie_suger'] = $data_confi1[0]->CONFIC_Serie;
            $data['numero_suger_c'] =$data_confi1[0]->CONFIC_Numero + 1;
        }

        $this->layout->view('almacen/guiarem_nueva', $data);

    }


    public function editar($codigo, $tipo_oper = 'V')
    {

        $data_confi = $this->companiaconfiguracion_model->obtener($this->somevar['compania']);
        $data_confi_docu = $this->companiaconfidocumento_model->obtener($data_confi[0]->COMPCONFIP_Codigo, 10);
        $this->load->library('layout', 'layout');
        unset($_SESSION['serie']);
        $modo = "modificar";
        $datos_guiarem = $this->guiarem_model->obtener($codigo);
        $tipo_movimiento = $datos_guiarem[0]->TIPOMOVP_Codigo;
        $otro_motivo = $datos_guiarem[0]->GUIAREMC_OtroMotivo;
        $empresa_transporte = $datos_guiarem[0]->EMPRP_Codigo;
        $almacen = $datos_guiarem[0]->ALMAP_Codigo;
        $usuario = $datos_guiarem[0]->USUA_Codigo;
        $referencia = $datos_guiarem[0]->DOCUP_Codigo;
        $cliente = $datos_guiarem[0]->CLIP_Codigo;
        $proveedor = $datos_guiarem[0]->PROVP_Codigo;
        $recepciona_nombres = $datos_guiarem[0]->GUIAREMC_PersReceNombre;
        $recepciona_dni = $datos_guiarem[0]->GUIAREMC_PersReceDNI;
        $numero_ref = $datos_guiarem[0]->GUIAREMC_NumeroRef;
        $numero_ocompra = $datos_guiarem[0]->GUIAREMC_OCompra;
        $serie = $datos_guiarem[0]->GUIAREMC_Serie;
        $numero = $datos_guiarem[0]->GUIAREMC_Numero;
        $codigo_usuario = $datos_guiarem[0]->GUIAREMC_CodigoUsuario;
        $fecha_traslado = $datos_guiarem[0]->GUIAREMC_FechaTraslado;
        $observacion = $datos_guiarem[0]->GUIAREMC_Observacion;
        $placa = $datos_guiarem[0]->GUIAREMC_Placa;
        $marca = $datos_guiarem[0]->GUIAREMC_Marca;
        $registro_mtc = $datos_guiarem[0]->GUIAREMC_RegistroMTC;
        $certificado = $datos_guiarem[0]->GUIAREMC_Certificado;
        $licencia = $datos_guiarem[0]->GUIAREMC_Licencia;
        $nombre_conductor = $datos_guiarem[0]->GUIAREMC_NombreConductor;
        $ocompra = $datos_guiarem[0]->OCOMP_Codigo;
        $tipoGuia=$datos_guiarem[0]->GUIAREMC_TipoGuia;
        
        if ($tipo_oper == 'V')
            $guiasa_id = $datos_guiarem[0]->GUIASAP_Codigo;
        else
            $guiasa_id = $datos_guiarem[0]->GUIAINP_Codigo;

        $fecha = $datos_guiarem[0]->GUIAREMC_Fecha;

        $ruc_cliente = '';
        $nombre_cliente = '';
        $nombre_proveedor = '';
        $ruc_proveedor = '';

        if ($cliente != '' && $cliente != '0') {
            $datos_cliente = $this->cliente_model->obtener($cliente);
            if ($datos_cliente) {
                $nombre_cliente = $datos_cliente->nombre;
                $ruc_cliente = $datos_cliente->ruc;
            }
        } elseif ($proveedor != '' && $proveedor != '0') {
            $datos_proveedor = $this->proveedor_model->obtener($proveedor);
            if ($datos_proveedor) {
                $nombre_proveedor = $datos_proveedor->nombre;
                $ruc_proveedor = $datos_proveedor->ruc;
            }
        }

        $datos_usuario = $this->usuario_model->obtener($usuario);
        $nombre_usuario = $datos_usuario->PERSC_Nombre . " " . $datos_usuario->PERSC_ApellidoPaterno;
        $punto_partida = $datos_guiarem[0]->GUIAREMC_PuntoPartida;
        $punto_llegada = $datos_guiarem[0]->GUIAREMC_PuntoLlegada;
        $estado = $datos_guiarem[0]->GUIAREMC_FlagEstado;
        $moneda = $datos_guiarem[0]->MONED_Codigo;
        $presupuesto = $datos_guiarem[0]->PRESUP_Codigo;
        $subtotal = $datos_guiarem[0]->GUIAREMC_subtotal;
        $descuento = $datos_guiarem[0]->GUIAREMC_descuento;
        $igv = $datos_guiarem[0]->GUIAREMC_igv;
        $total = $datos_guiarem[0]->GUIAREMC_total;
        $igv100 = $datos_guiarem[0]->GUIAREMC_igv100;
        $descuento100 = $datos_guiarem[0]->GUIAREMC_descuento100;

        
        /**ponemos en en estado seleccionado presupuesto**/
        if($presupuesto!=null && trim($presupuesto)!="" &&  $presupuesto!=0){
        	$estadoSeleccion=1;
        	$codigoPresupuesto=$presupuesto;
        	/**1:sdeleccionado,0:deseleccionado**/
        	$this->presupuesto_model->modificarTipoSeleccion($codigoPresupuesto,$estadoSeleccion);
        }
        /**fin de poner**/
        
        
        
        $data['titulo'] = "EDITAR GUIA DE REMISION";
        $data['compania'] = $this->somevar['compania'];
        $data['codigo'] = $codigo;
        $data['tipo_oper'] = $tipo_oper;
        $data['contiene_igv'] = (($data_confi[0]->COMPCONFIC_PrecioContieneIgv == '1') ? true : false);
        $data['form_open'] = form_open(base_url() . 'index.php/almacen/guiarem/grabar', array("name" => "frmGuiarem", "id" => "frmGuiarem", "onsubmit" => "return valida_guiarem();"));
        $data['oculto'] = form_hidden(array('accion' => "m", 'guiarem_id' => $codigo, 'guiasa_id' => $guiasa_id, 'modo' => $modo, 'base_url' => base_url(), 'tipo_oper' => $tipo_oper, 'contiene_igv' => ($data['contiene_igv'] == true ? '1' : '0'), "igv" => $data_confi[0]->COMPCONFIC_Igv));
        $data['serie'] = $serie;
        $data['numero'] = $numero;
        $data['codigo_usuario'] = $codigo_usuario;
        $data['fecha'] = form_input(array("name" => "fecha", "id" => "fecha", "class" => "cajaPequena cajaSoloLectura", "readonly" => "readonly", "maxlength" => "10", "value" => mysql_to_human($fecha)));
        $data['nombre_usuario'] = form_input(array("name" => "nombre_usuario", "id" => "nombre_usuario", "class" => "cajaMedia", "readonly" => "readonly", "maxlength" => "30", "value" => $nombre_usuario));
        $data['recepciona_nombres'] = form_input(array("name" => "recepciona_nombres", "id" => "recepciona_nombres", "class" => "cajaGeneral", "size" => "27", "maxlength" => "150", "value" => $recepciona_nombres));
        $data['recepciona_dni'] = form_input(array("name" => "recepciona_dni", "id" => "recepciona_dni", "class" => "cajaGeneral", "size" => "10", "maxlength" => "8", "value" => $recepciona_dni));

        $atributos = array('width' => 600, 'height' => 400, 'scrollbars' => 'yes', 'status' => 'yes', 'resizable' => 'yes', 'screenx' => '0', 'screeny' => '0');

        $contenido = "<img id='verCliente' height='16' width='16' src='" . base_url() . "images/ver.png' title='Buscar' border='0'>";

        $data['vercliente'] = anchor_popup('ventas/cliente/ventana_busqueda_cliente', $contenido, $atributos);
        $data['verproducto'] = "<a href='#' id='verCliente' onclick='busqueda_producto_x_almacen();'>" . $contenido . "</a>";
        $data['hidden'] = "";
        $data['cliente'] = $cliente;
        $data['ruc_cliente'] = $ruc_cliente;
        $data['nombre_cliente'] = $nombre_cliente;
        $data['proveedor'] = $proveedor;
        $data['ruc_proveedor'] = $ruc_proveedor;
        $data['nombre_proveedor'] = $nombre_proveedor;
        $data['flagEstado'] = $estado;
        
        $filterin = new stdClass();
        $filterin->TIPOMOVC_Tipo = 2;

        //el tipo_oper asigna la varriable-----------------------------------------
        $data['guia'] = $guiasa_id;
        /////
        
        $disableAlmacen=$tipoGuia==1?"disabled":"id='almacen'";
        
        $data['almacen'] =$almacen;
        $data['cboAlmacen'] = form_dropdown("almacen", $this->almacen_model->seleccionar(), $almacen, " class='comboMedio' $disableAlmacen");
        
        $data['cboDocumento'] = form_dropdown("referencia", $this->documento_model->seleccionar('1'), $referencia, " class='comboMedio' style='width:140px' id='referencia'");
        $data['cboDirEntrega'] = form_dropdown("dir_entrega", array("" => "::Seleccione::"), "", " class='comboMedio' id='dir_entrega'");
        $data['cboTipoMov'] = form_dropdown("tipo_movimiento", $this->tipomovimiento_model->seleccionar($filterin), $tipo_movimiento, " class='comboMedio' id='tipo_movimiento'");
        $data['otro_motivo'] = form_input(array("name" => "otro_motivo", "id" => "otro_motivo", "class" => "cajaGeneral", "style" => "width:117px", "maxlength" => "250", "value" => $otro_motivo));
        $data['cboEmpresaTrans'] = form_dropdown("empresa_transporte", $this->empresa_model->seleccionar(), $empresa_transporte, " class='comboGrande' id='empresa_transporte' style='width:300px'");
        
        $disableMoneda=$tipoGuia==1?'disabled':"id='moneda'";
        $data['moneda'] =$moneda;
        $data['cboMoneda'] = form_dropdown("moneda", $this->moneda_model->seleccionar(), $moneda, " class='comboMedio'  style='width:120px' $disableMoneda");
        
        $data['cboPresupuesto'] = $this->OPTION_generador($this->presupuesto_model->listar_presupuestos_noguiarem('F', $codigo), 'PRESUP_Codigo', array('PRESUC_Numero', 'nombre'), $presupuesto, array('', '::Seleccione::'), ' / ');
        ////////stv
        $data['seriecom'] = form_input(array("name" => "seriecom", "id" => "seriecom", "class" => "cajaGeneral", "size" => "5", "maxlength" => "10"));
        ////////
        $data['numero_ref'] = $numero_ref;
        $data['numero_ocompra'] = form_input(array("name" => "numero_ocompra", "id" => "numero_ocompra", "class" => "cajaGeneral", "size" => "23", "maxlength" => "50", "value" => $numero_ocompra));

        //$data['cboOrdencompra']   = $this->OPTION_generador($this->ocompra_model->obtener_ocompra($ocompra), 'OCOMP_Codigo', array('OCOMC_Numero','nombre'),'', array('','::Seleccione::'), ' - ');

       

        //print_r($datos_ocompra);

       // if (count($datos_ocompra) > 0)
       //     $data['cboOrdencompra'] = "<option value='" . $datos_ocompra[0]->OCOMP_Codigo . "' selected='selected'>" . $datos_ocompra[0]->OCOMC_Numero . "-" . $nombre_proveedor . "</option>";
        
    
            $data['ordencompra'] = $ocompra;
            /**verificamos si orden de compra existe **/
            if($ocompra!=null && $ocompra!=0 && trim($ocompra)!=""){
            	$datosOrdenCompra=$this->ocompra_model->obtener_ocompra($ocompra);
            	$data['serieOC'] = $datosOrdenCompra[0]->OCOMC_Serie;
            	$data['numeroOC']= $datosOrdenCompra[0]->OCOMC_Numero;
            	$data['valorOC']=($tipo_oper=="V")?"0":"1";
            }
            /**fin de verificacion**/
            $data['presupuesto_codigo'] = $presupuesto;
            /**verificamos si presupuesto o cotizacion  existe **/
            if($presupuesto!=null && $presupuesto!=0 && trim($presupuesto)!=""){
            	$datosOrdenCompra=$this->presupuesto_model->obtener_presupuesto($presupuesto);
            	$data['seriePre'] = $datosOrdenCompra[0]->PRESUC_Serie;
            	$data['numeroPre']= $datosOrdenCompra[0]->PRESUC_Numero;
            }
            /**fin de verificacion**/
            
        $data['modo'] = "modificar";

        //$data['cboOrdencompra']   = $this->OPTION_generador($this->ocompra_model->obtener_ocompra($codigo), 'OCOMP_Codigo', array('OCOMC_Numero','nombre'),'', array('','::Seleccione::'), ' - ');

        $data['fecha_traslado'] = form_input(array("name" => "fecha_traslado", "id" => "fecha_traslado", "class" => "cajaPequena", "maxlength" => "10", "readonly" => "readonly", "value" => mysql_to_human($fecha_traslado==null?date('Y-m-d'):$fecha_traslado)));
        $data['nombre_conductor'] = form_input(array("name" => "nombre_conductor", "id" => "nombre_conductor", "class" => "cajaGeneral", "size" => "27", "maxlength" => "150", "value" => $nombre_conductor));
        $data['marca'] = form_input(array("name" => "marca", "id" => "marca", "class" => "cajaGeneral", "size" => "27", "maxlength" => "100", "value" => $marca));
        $data['placa'] = form_input(array("name" => "placa", "id" => "placa", "class" => "cajaPequena", "maxlength" => "20", "value" => $placa));
        $data['registro_mtc'] = form_input(array("name" => "registro_mtc", "id" => "registro_mtc", "class" => "cajaPequena", "maxlength" => "20", "value" => $registro_mtc));
        $data['certificado'] = form_input(array("name" => "certificado", "id" => "certificado", "class" => "cajaPequena", "maxlength" => "10", "value" => $certificado));
        $data['licencia'] = form_input(array("name" => "licencia", "id" => "licencia", "class" => "cajaPequena", "maxlength" => "10", "value" => $licencia));
        $data['observacion'] = form_textarea(array("name" => "observacion", "id" => "observacion", "class" => "fuente8", "cols" => "108", "rows" => "3", "value" => $observacion));
        $data['punto_partida'] = form_input(array("name" => "punto_partida", "id" => "punto_partida", "class" => "cajaGeneral", "size" => "30", "maxlength" => "250", "value" => $punto_partida));
        $data['punto_llegada'] = form_input(array("name" => "punto_llegada", "id" => "punto_llegada", "class" => "cajaGeneral", "size" => "40", "maxlength" => "250", "value" => $punto_llegada));
        $data['estado'] = form_dropdown("estado", array("1" => "Activo", "0" => "Anulado"), $estado, " class='comboPequeno' id='estado'");

        $data['observacion'] = $observacion;
        $data['descuento'] = $descuento100;
        $data['igv'] = $igv100;
        $data['preciototal'] = $subtotal;
        $data['descuentotal'] = $descuento;
        $data['igvtotal'] = $igv;
        $data['importetotal'] = $total;
        $data['form_close'] = form_close();
        $data['serie_suger'] = "";
        $data['numero_suger'] = "";
        $data['tipoGuia'] =$tipoGuia;
        $data['cboCotizacion'] = form_dropdown("cotizacion", $this->cotizacion_model->seleccionar2(), "", " class='comboMedio' id='cotizacion' onchange='obtener_detalle_cotizacion();'");

        /* Detalle */

        $detalle = $this->guiaremdetalle_model->obtener2($codigo);
        unset($_SESSION['serie']);
        unset($_SESSION['serieReal']);
        unset($_SESSION['serieRealBD']);
        
        
        $detalle_guiarem = array();

        if (count($detalle) > 0) {

            foreach ($detalle as $indice => $valor) {

                $detacodi = $valor->GUIAREMDETP_Codigo;
                $producto = $valor->PRODCTOP_Codigo;
                $unidad = $valor->UNDMED_Codigo;
                $cantidad = $valor->GUIAREMDETC_Cantidad;
                $pu = $valor->GUIAREMDETC_Pu;
                $subtotal = $valor->GUIAREMDETC_Subtotal;
                $igv = $valor->GUIAREMDETC_Igv;
                $descuento = $valor->GUIAREMDETC_Descuento;
                $total = $valor->GUIAREMDETC_Total;
                $pu_conigv = $valor->GUIAREMDETC_Pu_ConIgv;
                $costo = $valor->GUIAREMDETC_Costo;
                $almacenProducto = $valor->ALMAP_Codigo;
                $venta = $valor->GUIAREMDETC_Venta;
                $peso = $valor->GUIAREMDETC_Peso;
                $GenInd = $valor->GUIAREMDETC_GenInd;
                $descri = str_replace('"', "''", $valor->GUIAREMDETC_Descripcion);
                $datos_producto = $this->producto_model->obtener_producto($producto);
                $datos_unidad = $this->unidadmedida_model->obtener($unidad);
                $nombre_producto = $datos_producto[0]->PROD_Nombre;
                $codigo_interno = $datos_producto[0]->PROD_CodigoUsuario;
                if ($datos_unidad)
                    $nombre_unidad = $datos_unidad[0]->UNDMED_Descripcion;
                else
                    $nombre_unidad = "SERV";
                $objeto = new stdClass();
                $objeto->GUIAREMDETP_Codigo = $detacodi;
                $objeto->PROD_Codigo = $producto;
                $objeto->PROD_CodigoInterno = $codigo_interno;
                $objeto->GUIAREMDETC_Cantidad = $cantidad;
                $objeto->GUIAREMDETC_Pu = $pu;
                $objeto->GUIAREMDETC_Subtotal = $subtotal;
                $objeto->GUIAREMDETC_Descuento = $descuento;
                $objeto->GUIAREMDETC_Igv = $igv;
                $objeto->GUIAREMDETC_Total = $total;
                $objeto->GUIAREMDETC_Pu_ConIgv = $pu_conigv;
                $objeto->GUIAREMDETC_Costo = $costo;
                $objeto->ALMAP_Codigo =$almacenProducto;
                $objeto->GUIAREMDETC_Venta = $venta;
                $objeto->GUIAREMDETC_Peso = $peso;
                $objeto->UNDMED_Codigo = $unidad;
                $objeto->PROD_Nombre = $nombre_producto;
                $objeto->UNDMED_Simbolo = $nombre_unidad;
                $objeto->GUIAREMDETC_GenInd = $GenInd;
                $objeto->GUIAREMDETC_Descripcion = $descri;
                $detalle_guiarem[] = $objeto;
                
                
                
                /**gcbq verificamos si el detalle dee comprobante contiene productos individuales**/
               			/**verificamos si es individual**/
                		if($GenInd!=null && trim($GenInd)=="I"){
                			/**obtenemos serie de ese producto **/+
                			$producto_id=$producto;
                			$filterSerie== new stdClass();
                			$filterSerie->PROD_Codigo=$producto_id;
                			$filterSerie->SERIC_FlagEstado='1';
                			$filterSerie->DOCUP_Codigo=10;
                			$filterSerie->SERDOC_NumeroRef=$codigo;
                			$filterSerie->ALMAP_Codigo=$almacenProducto;
                			$listaSeriesProducto=$this->seriedocumento_model->buscar($filterSerie,null,null);
                			if($listaSeriesProducto!=null  &&  count($listaSeriesProducto)>0){
                				$reg = array();
                				$regBD = array();
                				foreach($listaSeriesProducto as $serieValor){
                					/**lo ingresamos como se ssion ah 2 variables 1:session que se muestra , 2:sesion que queda intacta bd
                					 * cuando se actualice la session  1 se compra con la session 2.**/
                					$filter = new stdClass();
                					$filter->serieNumero= $serieValor->SERIC_Numero;
                					$filter->serieCodigo= $serieValor->SERIP_Codigo;
                					$filter->serieDocumentoCodigo=$serieValor->SERDOC_Codigo;
                					$reg[] =$filter;
                
                
                					$filterBD = new stdClass();
                					$filterBD->SERIC_Numero= $serieValor->SERIC_Numero;
                					$filterBD->SERIP_Codigo= $serieValor->SERIP_Codigo;
                					$filterBD->SERDOC_Codigo=$serieValor->SERDOC_Codigo;
                					$regBD[] =$filterBD;
                					
                					/**si es venta lo seleccionamos en almacenproduyctoserie capaz exita perdida de datos**/
                					if($tipo_oper=='V'){
                						$this->almacenproductoserie_model->seleccionarSerieBD($codigoSerie,1);
                					}
                					/**fin de seleccion verificacion**/
                				}
                				$_SESSION['serieReal'][$almacenProducto][$producto_id] = $reg;
                				$_SESSION['serieRealBD'][$almacenProducto][$producto_id] = $regBD;
                			}
                		}
                /**fin de procewso de realizaciom**/
                
            }
        }

        $data['detalle'] = $detalle_guiarem;
        $data['tipo_codificacion'] = $data_confi_docu[0]->COMPCONFIDOCP_Tipo;

        $this->layout->view('almacen/guiarem_nueva', $data);

    }

    public function guiarem_ver($codigo, $tipo_oper = 'V')
    {

        $data_confi = $this->companiaconfiguracion_model->obtener($this->somevar['compania']);
        $data_confi_docu = $this->companiaconfidocumento_model->obtener($data_confi[0]->COMPCONFIP_Codigo, 10);

        unset($_SESSION['serie']);
        $modo = "modificar";
        $datos_guiarem = $this->guiarem_model->obtener($codigo);
        $tipo_movimiento = $datos_guiarem[0]->TIPOMOVP_Codigo;
        $otro_motivo = $datos_guiarem[0]->GUIAREMC_OtroMotivo;
        $empresa_transporte = $datos_guiarem[0]->EMPRP_Codigo;
        $almacen = $datos_guiarem[0]->ALMAP_Codigo;
        $usuario = $datos_guiarem[0]->USUA_Codigo;
        $referencia = $datos_guiarem[0]->DOCUP_Codigo;
        $cliente = $datos_guiarem[0]->CLIP_Codigo;
        $proveedor = $datos_guiarem[0]->PROVP_Codigo;
        $recepciona_nombres = $datos_guiarem[0]->GUIAREMC_PersReceNombre;
        $recepciona_dni = $datos_guiarem[0]->GUIAREMC_PersReceDNI;
        $numero_ref = $datos_guiarem[0]->GUIAREMC_NumeroRef;
        $numero_ocompra = $datos_guiarem[0]->GUIAREMC_OCompra;
        $serie = $datos_guiarem[0]->GUIAREMC_Serie;
        $numero = $datos_guiarem[0]->GUIAREMC_Numero;
        $codigo_usuario = $datos_guiarem[0]->GUIAREMC_CodigoUsuario;
        $fecha_traslado = $datos_guiarem[0]->GUIAREMC_FechaTraslado;
        $observacion = $datos_guiarem[0]->GUIAREMC_Observacion;
        $placa = $datos_guiarem[0]->GUIAREMC_Placa;
        $marca = $datos_guiarem[0]->GUIAREMC_Marca;
        $registro_mtc = $datos_guiarem[0]->GUIAREMC_RegistroMTC;
        $certificado = $datos_guiarem[0]->GUIAREMC_Certificado;
        $licencia = $datos_guiarem[0]->GUIAREMC_Licencia;
        $nombre_conductor = $datos_guiarem[0]->GUIAREMC_NombreConductor;
        $ocompra = $datos_guiarem[0]->OCOMP_Codigo;
        if ($tipo_oper == 'V')
            $guiasa_id = $datos_guiarem[0]->GUIASAP_Codigo;
        else
            $guiasa_id = $datos_guiarem[0]->GUIAINP_Codigo;

        $fecha = $datos_guiarem[0]->GUIAREMC_Fecha;

        $ruc_cliente = '';
        $nombre_cliente = '';
        $nombre_proveedor = '';
        $ruc_proveedor = '';

        if ($cliente != '' && $cliente != '0') {
            $datos_cliente = $this->cliente_model->obtener($cliente);
            if ($datos_cliente) {
                $nombre_cliente = $datos_cliente->nombre;
                $ruc_cliente = $datos_cliente->ruc;
            }
        } elseif ($proveedor != '' && $proveedor != '0') {
            $datos_proveedor = $this->proveedor_model->obtener($proveedor);
            if ($datos_proveedor) {
                $nombre_proveedor = $datos_proveedor->nombre;
                $ruc_proveedor = $datos_proveedor->ruc;
            }
        }

        $datos_usuario = $this->usuario_model->obtener($usuario);
        $nombre_usuario = $datos_usuario->PERSC_Nombre . " " . $datos_usuario->PERSC_ApellidoPaterno;
        $punto_partida = $datos_guiarem[0]->GUIAREMC_PuntoPartida;
        $punto_llegada = $datos_guiarem[0]->GUIAREMC_PuntoLlegada;
        $estado = $datos_guiarem[0]->GUIAREMC_FlagEstado;
        $moneda = $datos_guiarem[0]->MONED_Codigo;
        $presupuesto = $datos_guiarem[0]->PRESUP_Codigo;
        $subtotal = $datos_guiarem[0]->GUIAREMC_subtotal;
        $descuento = $datos_guiarem[0]->GUIAREMC_descuento;
        $igv = $datos_guiarem[0]->GUIAREMC_igv;
        $total = $datos_guiarem[0]->GUIAREMC_total;
        $igv100 = $datos_guiarem[0]->GUIAREMC_igv100;
        $descuento100 = $datos_guiarem[0]->GUIAREMC_descuento100;

        $data['titulo'] = "VISTA PREVIA DE LA GUIA DE REMISION";
        $data['codigo'] = $codigo;
        $data['tipo_oper'] = $tipo_oper;
        $data['contiene_igv'] = (($data_confi[0]->COMPCONFIC_PrecioContieneIgv == '1') ? true : false);
        $data['form_open'] = form_open(base_url() . 'index.php/almacen/guiarem/grabar', array("name" => "frmGuiarem", "id" => "frmGuiarem", "onsubmit" => "return valida_guiarem();"));
        $data['oculto'] = form_hidden(array('accion' => "m", 'guiarem_id' => $codigo, 'guiasa_id' => $guiasa_id, 'modo' => $modo, 'base_url' => base_url(), 'tipo_oper' => $tipo_oper, 'contiene_igv' => ($data['contiene_igv'] == true ? '1' : '0'), "igv" => $data_confi[0]->COMPCONFIC_Igv));
        $data['serie'] = $serie;
        $data['numero'] = $numero;
        $data['codigo_usuario'] = $codigo_usuario;
        $data['fecha'] = form_input(array("name" => "fecha", "id" => "fecha", "class" => "cajaPequena cajaSoloLectura", "readonly" => "readonly", "maxlength" => "10", "value" => mysql_to_human($fecha)));
        $data['nombre_usuario'] = form_input(array("name" => "nombre_usuario", "id" => "nombre_usuario", "class" => "cajaMedia", "readonly" => "readonly", "maxlength" => "30", "value" => $nombre_usuario));
        $data['recepciona_nombres'] = form_input(array("name" => "recepciona_nombres", "id" => "recepciona_nombres", "class" => "cajaGeneral", "size" => "27", "maxlength" => "150", "value" => $recepciona_nombres));
        $data['recepciona_dni'] = form_input(array("name" => "recepciona_dni", "id" => "recepciona_dni", "class" => "cajaGeneral", "size" => "10", "maxlength" => "8", "value" => $recepciona_dni));

        $atributos = array('width' => 600, 'height' => 400, 'scrollbars' => 'yes', 'status' => 'yes', 'resizable' => 'yes', 'screenx' => '0', 'screeny' => '0');

        $contenido = "<img id='verCliente' height='16' width='16' src='" . base_url() . "images/ver.png' title='Buscar' border='0'>";

        $data['vercliente'] = anchor_popup('ventas/cliente/ventana_busqueda_cliente', $contenido, $atributos);
        $data['verproducto'] = "<a href='#' id='verCliente' onclick='busqueda_producto_x_almacen();'>" . $contenido . "</a>";
        $data['hidden'] = "";
        $data['cliente'] = $cliente;
        $data['ruc_cliente'] = $ruc_cliente;
        $data['nombre_cliente'] = $nombre_cliente;
        $data['proveedor'] = $proveedor;
        $data['ruc_proveedor'] = $ruc_proveedor;
        $data['nombre_proveedor'] = $nombre_proveedor;

        $filterin = new stdClass();
        $filterin->TIPOMOVC_Tipo = 2;

        //el tipo_oper asigna la varriable-----------------------------------------
        $data['guia'] = $guiasa_id;
        /////

        $data['cboAlmacen'] = form_dropdown("almacen", $this->almacen_model->seleccionar(), $almacen, " class='comboMedio' id='almacen'");
        $data['cboDocumento'] = form_dropdown("referencia", $this->documento_model->seleccionar('1'), $referencia, " class='comboMedio' style='width:140px' id='referencia'");
        $data['cboDirEntrega'] = form_dropdown("dir_entrega", array("" => "::Seleccione::"), "", " class='comboMedio' id='dir_entrega'");
        $data['cboTipoMov'] = form_dropdown("tipo_movimiento", $this->tipomovimiento_model->seleccionar($filterin), $tipo_movimiento, " class='comboMedio' id='tipo_movimiento'");
        $data['otro_motivo'] = form_input(array("name" => "otro_motivo", "id" => "otro_motivo", "class" => "cajaGeneral", "style" => "width:117px", "maxlength" => "250", "value" => $otro_motivo));
        $data['cboEmpresaTrans'] = form_dropdown("empresa_transporte", $this->empresa_model->seleccionar(), $empresa_transporte, " class='comboGrande' id='empresa_transporte' style='width:300px'");
        $data['cboMoneda'] = form_dropdown("moneda", $this->moneda_model->seleccionar(), $moneda, " class='comboMedio' id='moneda' style='width:120px'");
        $data['cboPresupuesto'] = $this->OPTION_generador($this->presupuesto_model->listar_presupuestos_noguiarem('F', $codigo), 'PRESUP_Codigo', array('PRESUC_Numero', 'nombre'), $presupuesto, array('', '::Seleccione::'), ' / ');
        ////////stv
        $data['seriecom'] = form_input(array("name" => "seriecom", "id" => "seriecom", "class" => "cajaGeneral", "size" => "5", "maxlength" => "10"));
        ////////
        $data['numero_ref'] = form_input(array("name" => "numero_ref", "id" => "numero_ref", "class" => "cajaGeneral", "size" => "19", "maxlength" => "15", "value" => $numero_ref));
        $data['numero_ocompra'] = form_input(array("name" => "numero_ocompra", "id" => "numero_ocompra", "class" => "cajaGeneral", "size" => "23", "maxlength" => "50", "value" => $numero_ocompra));

        //$data['cboOrdencompra']   = $this->OPTION_generador($this->ocompra_model->obtener_ocompra($ocompra), 'OCOMP_Codigo', array('OCOMC_Numero','nombre'),'', array('','::Seleccione::'), ' - ');

        $datos_ocompra = $this->ocompra_model->obtener_ocompra($ocompra);

        //print_r($datos_ocompra);

        if (count($datos_ocompra) > 0)
            $data['cboOrdencompra'] = "<option value='" . $datos_ocompra[0]->OCOMP_Codigo . "' selected='selected'>" . $datos_ocompra[0]->OCOMC_Numero . "-" . $nombre_proveedor . "</option>";
        $data['modo'] = "modificar";

        //$data['cboOrdencompra']   = $this->OPTION_generador($this->ocompra_model->obtener_ocompra($codigo), 'OCOMP_Codigo', array('OCOMC_Numero','nombre'),'', array('','::Seleccione::'), ' - ');

        $data['fecha_traslado'] = form_input(array("name" => "fecha_traslado", "id" => "fecha_traslado", "class" => "cajaPequena", "maxlength" => "10", "readonly" => "readonly", "value" => mysql_to_human($fecha_traslado)));
        $data['nombre_conductor'] = form_input(array("name" => "nombre_conductor", "id" => "nombre_conductor", "class" => "cajaGeneral", "size" => "27", "maxlength" => "150", "value" => $nombre_conductor));
        $data['marca'] = form_input(array("name" => "marca", "id" => "marca", "class" => "cajaGeneral", "size" => "27", "maxlength" => "100", "value" => $marca));
        $data['placa'] = form_input(array("name" => "placa", "id" => "placa", "class" => "cajaPequena", "maxlength" => "20", "value" => $placa));
        $data['registro_mtc'] = form_input(array("name" => "registro_mtc", "id" => "registro_mtc", "class" => "cajaPequena", "maxlength" => "20", "value" => $registro_mtc));
        $data['certificado'] = form_input(array("name" => "certificado", "id" => "certificado", "class" => "cajaPequena", "maxlength" => "10", "value" => $certificado));
        $data['licencia'] = form_input(array("name" => "licencia", "id" => "licencia", "class" => "cajaPequena", "maxlength" => "10", "value" => $licencia));
        $data['observacion'] = form_textarea(array("name" => "observacion", "id" => "observacion", "class" => "fuente8", "cols" => "108", "rows" => "3", "value" => $observacion));
        $data['punto_partida'] = form_input(array("name" => "punto_partida", "id" => "punto_partida", "class" => "cajaGeneral", "size" => "57", "maxlength" => "250", "value" => $punto_partida));
        $data['punto_llegada'] = form_input(array("name" => "punto_llegada", "id" => "punto_llegada", "class" => "cajaGeneral", "size" => "58", "maxlength" => "250", "value" => $punto_llegada));
        $data['estado'] = form_dropdown("estado", array("1" => "Activo", "0" => "Anulado"), $estado, " class='comboPequeno' id='estado'");

        $data['observacion'] = $observacion;
        $data['descuento'] = $descuento100;
        $data['igv'] = $igv100;
        $data['preciototal'] = $subtotal;
        $data['descuentotal'] = $descuento;
        $data['igvtotal'] = $igv;
        $data['importetotal'] = $total;
        $data['form_close'] = form_close();
        $data['serie_suger'] = "";
        $data['numero_suger'] = "";
        $data['cboCotizacion'] = form_dropdown("cotizacion", $this->cotizacion_model->seleccionar2(), "", " class='comboMedio' id='cotizacion' onchange='obtener_detalle_cotizacion();'");

        /* Detalle */

        $detalle = $this->guiaremdetalle_model->obtener2($codigo);

        $detalle_guiarem = array();

        if (count($detalle) > 0) {

            foreach ($detalle as $indice => $valor) {

                $detacodi = $valor->GUIAREMDETP_Codigo;
                $producto = $valor->PRODCTOP_Codigo;
                $unidad = $valor->UNDMED_Codigo;
                $cantidad = $valor->GUIAREMDETC_Cantidad;
                $pu = $valor->GUIAREMDETC_Pu;
                $subtotal = $valor->GUIAREMDETC_Subtotal;
                $igv = $valor->GUIAREMDETC_Igv;
                $descuento = $valor->GUIAREMDETC_Descuento;
                $total = $valor->GUIAREMDETC_Total;
                $pu_conigv = $valor->GUIAREMDETC_Pu_ConIgv;
                $costo = $valor->GUIAREMDETC_Costo;
                $venta = $valor->GUIAREMDETC_Venta;
                $peso = $valor->GUIAREMDETC_Peso;
                $GenInd = $valor->GUIAREMDETC_GenInd;
                $descri = str_replace('"', "''", $valor->GUIAREMDETC_Descripcion);
                $datos_producto = $this->producto_model->obtener_producto($producto);
                $datos_unidad = $this->unidadmedida_model->obtener($unidad);
                $nombre_producto = $datos_producto[0]->PROD_Nombre;
                $codigo_interno = $datos_producto[0]->PROD_CodigoUsuario;
                if ($datos_unidad)
                    $nombre_unidad = $datos_unidad[0]->UNDMED_Descripcion;
                else
                    $nombre_unidad = "SERV";
                $objeto = new stdClass();
                $objeto->GUIAREMDETP_Codigo = $detacodi;
                $objeto->PROD_Codigo = $producto;
                $objeto->PROD_CodigoInterno = $codigo_interno;
                $objeto->GUIAREMDETC_Cantidad = $cantidad;
                $objeto->GUIAREMDETC_Pu = $pu;
                $objeto->GUIAREMDETC_Subtotal = $subtotal;
                $objeto->GUIAREMDETC_Descuento = $descuento;
                $objeto->GUIAREMDETC_Igv = $igv;
                $objeto->GUIAREMDETC_Total = $total;
                $objeto->GUIAREMDETC_Pu_ConIgv = $pu_conigv;
                $objeto->GUIAREMDETC_Costo = $costo;
                $objeto->GUIAREMDETC_Venta = $venta;
                $objeto->GUIAREMDETC_Peso = $peso;
                $objeto->UNDMED_Codigo = $unidad;
                $objeto->PROD_Nombre = $nombre_producto;
                $objeto->UNDMED_Simbolo = $nombre_unidad;
                $objeto->GUIAREMDETC_GenInd = $GenInd;
                $objeto->GUIAREMDETC_Descripcion = $descri;

                $detalle_guiarem[] = $objeto;

            }
        }
        $data['detalle'] = $detalle_guiarem;
        $data['tipo_codificacion'] = $data_confi_docu[0]->COMPCONFIDOCP_Tipo;
        $this->load->view('almacen/guiarem_ver', $data);
    }


    public function grabar()
    {

        $this->load->helper('my_guiarem');
        $guiarem_id = $this->input->post("guiarem_id");
        
        
        if($guiarem_id==null || $guiarem_id==0 || trim($guiarem_id)==""){
	        $data_confi = $this->companiaconfiguracion_model->obtener($this->somevar['compania']);
	    	$data_confi_docu = $this->companiaconfidocumento_model->obtener($data_confi[0]->COMPCONFIP_Codigo, 10);
	        $tipo_codificacion = $data_confi_docu[0]->COMPCONFIDOCP_Tipo;
	        //echo $guiarem_id; exit;
	
	        switch ($tipo_codificacion) {
	
	            case '2':
	
	                if ($this->input->post('serie') == '')
	                    exit('{"result":"error", "campo":"serie"}');
	
	                if ($this->input->post('numero') == '')
	                    exit('{"result":"error", "campo":"numero"}');
	                break;
	
	            case '3':
	
	                if ($this->input->post('codigo_usuario') == '')
	                    exit('{"result":"error", "campo":"codigo_usuario"}');
	                break;
	
	        }
        }

        $tipo_oper = $this->input->post('tipo_oper');

        if ($this->input->post('almacen') == '' || $this->input->post('almacen') == '0')
            exit('{"result":"error", "campo":"almacen"}');

        if ($tipo_oper == 'V' && $tipo_oper == '')
            exit('{"result":"error", "campo":"ruc_cliente"}');

        if ($tipo_oper == 'C' && $tipo_oper == '')
            exit('{"result":"error", "campo":"ruc_proveedor}');

        if ($this->input->post('tipo_movimiento') == '' || $this->input->post('tipo_movimiento') == '0')
            exit('{"result":"error", "campo":"tipo_movimiento"}');

        if ($this->input->post('fecha_traslado') == '')
            exit('{"result":"error", "campo":"fecha_traslado"}');

        if ($this->input->post('fecha_traslado') == '')
            exit('{"result":"error", "campo":"fecha_traslado"}');

        if ($this->input->post('tipo_movimiento') == '13' && $this->input->post('otro_motivo') == '')
            exit('{"result":"error", "campo":"otro_motivo"}');

        if ($this->input->post('punto_partida') == '')
            exit('{"result":"error", "campo":"punto_partida"}');

        if ($this->input->post('punto_llegada') == '')
            exit('{"result":"error", "campo":"punto_llegada"}');

        if ($this->input->post('estado') == '0' && $this->input->post('observacion') == '')
            exit('{"result":"error", "campo":"observacion"}');

        if ($this->input->post('moneda') == '0' || $this->input->post('moneda') == '')
            exit('{"result":"error", "campo":"moneda"}');


        //VERIFICO SI TODAS LAS SERIES HAN SIDO INGRESADAS

        $prodcodigo = $this->input->post('prodcodigo');
        $flagGenInd = $this->input->post('flagGenIndDet');
        $prodcantidad = $this->input->post('prodcantidad');
        $proddescri = $this->input->post('proddescri');
        $guia_id = $this->input->post("guiasa_id");  
        
        if ($this->input->post("serie"))
            $serie = $this->input->post("serie");

       $numero = NULL;

        if ($this->input->post("numero"))
            $numero = $this->input->post("numero");
        //$filter->GUIAREMC_Numero=$this->input->post('numero');

        $codigo_usuario = NULL;

        if ($this->input->post("codigo_usuario"))
            $codigo_usuario = $this->input->post("codigo_usuario");

        $almacen = $this->input->post("almacen");
        if ($tipo_oper == 'V')
            $cliente = $this->input->post("cliente");
        else
            $proveedor = $this->input->post("proveedor");


        $moneda = strtoupper($this->input->post("moneda"));
        $recepciona_nombres = strtoupper($this->input->post("recepciona_nombres"));
        $recepciona_dni = $this->input->post("recepciona_dni");
        $referencia = $this->input->post("referencia");
        $numero_ref = $this->input->post("numero_ref");
        $numero_ocompra = $this->input->post("numeroOrden");
        $tipo_movimiento = $this->input->post("tipo_movimiento");
        $otro_motivo = $this->input->post("otro_motivo");
        $punto_partida = $this->input->post("punto_partida");
        $punto_llegada = $this->input->post("punto_llegada");
        $fecha_traslado = $this->input->post("fecha_traslado");
        $fecha = date('d/m/Y', time());
        $empresa_transporte = $this->input->post("empresa_transporte");
        $nombre_conductor = $this->input->post("nombre_conductor");
        $marca = $this->input->post("marca");
        $placa = $this->input->post("placa");
        $registro_mtc = $this->input->post("registro_mtc");
        $certificado = $this->input->post("certificado");
        $licencia = $this->input->post("licencia");
        $observacion = $this->input->post("observacion");
        $accion = $this->input->post("accion");
        $prodcodigo = $this->input->post('prodcodigo');
        $produnidad = $this->input->post('produnidad');
        $prodcantidad = $this->input->post('prodcantidad');
        $prodpu = $this->input->post('prodpu');
        $prodprecio = $this->input->post('prodprecio');
        $proddescuento = $this->input->post('proddescuento');
        $prodigv = $this->input->post('prodigv');
        $prodimporte = $this->input->post('prodimporte');
        $prodpu_conigv = $this->input->post('prodpu_conigv');
        $prodigv100 = $this->input->post('prodigv100');
        $proddescuento100 = $this->input->post('proddescuento100');
        $prodcosto = $this->input->post('prodcosto');
        $prodventa = $this->input->post('prodventa');
        $proddescri = $this->input->post('proddescri');
        $detaccion = $this->input->post('detaccion');
        $detacodi = $this->input->post('detacodi');
        $flagGenInd = $this->input->post('flagGenIndDet');
        $estado = $this->input->post('flagEstado');
        $presupuesto = $this->input->post("presupuesto_codigo");
        $ordencompra = $this->input->post("ordencompra");
        $tipoGuia= $this->input->post("tipoGuia");
        $almacenProducto=$this->input->post("almacenProducto");
        $detobserv = "";

        $filter = new stdClass();

        $filter->MONED_Codigo = $moneda;
        $filter->OCOMP_Codigo=null;
        if ($ordencompra != '')
            $filter->OCOMP_Codigo = $ordencompra;
        
        $filter->GUIAREMC_TipoOperacion = $tipo_oper;
        
        $filter->PRESUP_Codigo = NULL;
        if ($presupuesto != '')
            $filter->PRESUP_Codigo = $presupuesto;

        $filter->TIPOMOVP_Codigo = $tipo_movimiento;
        $filter->GUIAREMC_OtroMotivo = strtoupper($otro_motivo);
        $filter->GUIAREMC_Serie = $serie;
        $filter->GUIAREMC_Numero = $numero;
        $filter->GUIAREMC_CodigoUsuario = $codigo_usuario;
        $filter->ALMAP_Codigo = NULL;

        if ($almacen != ''){
            $filter->ALMAP_Codigo = $almacen;
        }	       

        $filter->USUA_Codigo = $this->somevar['user'];
        $filter->COMPP_Codigo = $this->somevar['compania'];
        $filter->DOCUP_Codigo = NULL;

        if ($referencia != '')
            $filter->DOCUP_Codigo = $referencia;

        if ($tipo_oper == 'V')
            $filter->CLIP_Codigo = $cliente;
        else
            $filter->PROVP_Codigo = $proveedor;
        
        $filter->GUIAREMC_PersReceNombre = $recepciona_nombres;
        $filter->GUIAREMC_PersReceDNI = $recepciona_dni;
        $filter->GUIAREMC_NumeroRef = $numero_ref;
        $filter->GUIAREMC_OCompra = $numero_ocompra;
        $filter->GUIAREMC_FechaTraslado = human_to_mysql($fecha_traslado);
        $filter->GUIAREMC_PuntoPartida = strtoupper($punto_partida);
        $filter->GUIAREMC_PuntoLlegada = strtoupper($punto_llegada);
        $filter->GUIAREMC_Fecha = human_to_mysql($fecha);
        $filter->EMPRP_Codigo = NULL;

        if ($empresa_transporte != '')
            $filter->EMPRP_Codigo = $empresa_transporte;

        $filter->GUIAREMC_Marca = strtoupper($marca);
        $filter->GUIAREMC_Placa = strtoupper($placa);
        $filter->GUIAREMC_RegistroMTC = strtoupper($registro_mtc);
        $filter->GUIAREMC_Certificado = strtoupper($certificado);
        $filter->GUIAREMC_Licencia = strtoupper($licencia);
        $filter->GUIAREMC_NombreConductor = strtoupper($nombre_conductor);
        $filter->GUIAREMC_Observacion = strtoupper($observacion);
        $filter->GUIAREMC_descuento100 = $this->input->post('descuento');
        $filter->GUIAREMC_igv100 = $this->input->post('igv');
        $filter->GUIAREMC_subtotal = $this->input->post('preciototal');
        $filter->GUIAREMC_descuento = $this->input->post('descuentotal');
        $filter->GUIAREMC_igv = $this->input->post('igvtotal');
        $filter->GUIAREMC_total = $this->input->post('importetotal');
        $this->configuracion_model->modificar_configuracion($this->somevar['compania'], 10, $numero, $serie1 = null);


        if ($guiarem_id == "") {
            if ($accion == "m") {
                $this->guiaremdetalle_model->eliminar2($guiarem_id);
            }

        }

        if (isset($guiarem_id) && $guiarem_id > 0) {
            unset($filter->GUIAREMC_FechaRegistro);
            /**tipo guia interna:1 cambiamos de estado a estado:1**/
            if($tipoGuia==1){
            	$filter->GUIAREMC_FlagEstado = 1;
            }
            $this->guiarem_model->modificar($guiarem_id, $filter);
            /**INTERNA:1 si es interna no se elimina **/
            if($tipoGuia==0){
            	$this->guiaremdetalle_model->eliminar2($guiarem_id);
            }
            
        } else {
            $filter->GUIAREMC_FlagEstado = $estado;
            $guiarem_id = $this->guiarem_model->insertar($filter);
        }


        // gcbq ---orden de compra total bienes que existe 
        if ($ordencompra != "") {
            $cantidad_entregada_total = 0;
            $cantidad_total_ingresada = 0;
            $cant_total = 0;
            $detalle = $this->ocompra_model->obtener_detalle_ocompra($ordencompra);
            if (is_array($detalle) > 0) {
                foreach ($detalle as $valor2) {
                    $cant_total += $valor2->OCOMDEC_Cantidad;
                }
            }
        }
        ///////////////
        /**INTERNA:1  si es interna no se modifica solo lo puede hacer la factura que lo creo**/
	if($tipoGuia==0){
	        if (is_array($prodcodigo)) {
	
	            foreach ($prodcodigo as $indice => $valor) {
	
						
	                $producto = $prodcodigo[$indice];
	                $codigoAlmacenProducto=$almacenProducto[$indice];
	                $unidad1 = $produnidad[$indice];
	
	                if ($unidad1 == "") {
	                    $unidad = NULL;
	                } else {
	                    $unidad = $unidad1;
	                }
	
	                $cantidad = $prodcantidad[$indice];
	                $costo = $prodcosto[$indice];
	                $venta = $prodventa[$indice];
	                $descri = $proddescri[$indice];
	                $accion = $detaccion[$indice];
	                $detflag = $flagGenInd[$indice];
	
	                //gcbq agrgar flagestado de terminado ocompra 
	                if ($ordencompra != '' && $accion!="e") {
	
	                    $cantidad_entregada = calcular_cantidad_entregada_x_producto($tipo_oper, $tipo_oper,$ordencompra, $prodcodigo[$indice]);
						$cantidad_entregada_total += $cantidad_entregada;
						$cantidad_total_ingresada += $prodcantidad[$indice];
	                    if ($cant_total <= $cantidad_entregada_total + $cantidad_total_ingresada) {
	                        $this->ocompra_model->modificar_flagTerminado($this->input->post('ordencompra'), "1");
	                    }
	                    if ($cant_total > $cantidad_entregada_total + $cantidad_total_ingresada) {
	                        $this->ocompra_model->modificar_flagTerminado($this->input->post('ordencompra'), "0");
	                    }
	                }
	                ///////////////////
	
	
	                $observ = "Insertar";
	                $filter2 = new stdClass();
	                $filter2->GUIAREMP_Codigo = $guiarem_id;
	                $filter2->PRODCTOP_Codigo = $producto;
	                $filter2->UNDMED_Codigo = $unidad;
	                $filter2->GUIAREMDETC_Cantidad = $cantidad;
	                $filter2->GUIAREMDETC_Pu = $prodpu[$indice];
	                $filter2->GUIAREMDETC_Subtotal = $prodprecio[$indice];
	                $filter2->GUIAREMDETC_Descuento = $proddescuento[$indice];
	                $filter2->GUIAREMDETC_Igv = $prodigv[$indice];
	                $filter2->GUIAREMDETC_Total = $prodimporte[$indice];
	                $filter2->GUIAREMDETC_Pu_ConIgv = $prodpu_conigv[$indice];
	                $filter2->GUIAREMDETC_Descuento100 = $proddescuento100[$indice];
	                $filter2->GUIAREMDETC_Igv100 = $prodigv100[$indice];
	                $filter2->GUIAREMDETC_Costo = $costo;
	                $filter2->GUIAREMDETC_Venta = $venta;
	                $filter2->GUIAREMDETC_Peso = "";
	                $filter2->GUIAREMDETC_GenInd = $detflag;
	                $filter2->GUIAREMDETC_Descripcion = strtoupper($descri);
	                $filter2->ALMAP_Codigo=$codigoAlmacenProducto;
	                
	                if ($guiarem_id == "") {
	                } else {
	                	if($accion!="e"){
	                    	$this->guiaremdetalle_model->insertar($filter2);
		                    $producto_id=$valor;
		                    /**gcbq insertar serie de cada producto**/
	 	                    if($flagGenInd[$indice]=='I'){
		                    	if($producto_id!=null){
		                    		/**obtenemos las series de session por producto***/
		                    		$seriesProducto=$this->session->userdata('serieReal');
		                    		$serieReal = $seriesProducto;
		                    		if ($seriesProducto!=null && count($seriesProducto) > 0 && $seriesProducto!= "") {
		                    			/***pongo todos en estado cero de las series asociadas a ese producto**/
		                    			$seriesProductoBD=$this->session->userdata('serieRealBD');
		                    			$serieBD = $seriesProductoBD;
		                    			if($serieBD!=null && count($serieBD)>0){
		                    				foreach ($serieBD as $alm1BD => $arrAlmacenBD) {
		                    					if($alm1BD==$codigoAlmacenProducto){
		                    						foreach ($arrAlmacenBD as $ind1BD => $arrserieBD){
				                    					if ($ind1BD == $producto_id) {
				                    						foreach ($arrserieBD as $keyBD => $valueBD) {
				                    							/**cambiamos a ewstado 0**/
				                    							$filterSerie== new stdClass();
				                    							if($tipo_oper == 'C'){
				                    								$filterSerie->SERIC_FlagEstado='0';
				                    								$this->serie_model->modificar($valueBD->SERIP_Codigo,$filterSerie);
				                    							}
				                    							$filterSerieD= new stdClass();
				                    							$filterSerieD->SERDOC_FlagEstado='0';
				                    							$this->seriedocumento_model->modificar($valueBD->SERDOC_Codigo,$filterSerieD);
				                    							
				                    							/**TIPO OPERACION VENTA SE DESHABILITAN LAS SERIES SELECCIONADAS POR EL COMPROBANTE**/
				                    							if($tipo_oper == 'V'){
				                    								/**eliminamos los registros en estadoSeleccion cero:0:desleccionado**/
				                    								$this->almacenproductoserie_model->seleccionarSerieBD($serieCodigo,0);
				                    							}
				                    							/**FIN DE DESELECCIONAR***/
				                    						}
				                    						break;
				                    					}
		                    						}
		                    						break;
		                    					}
		                    				}
		                    			}
		                    			/**fin de poner estado cero**/
		                    			foreach ($serieReal  as $alm2 => $arrAlmacen2) {
		                    				if($alm2==$codigoAlmacenProducto){
		                    					foreach ($arrAlmacen2 as $ind2 => $arrserie2){
				                    				if ($ind2 == $producto_id) {
				                    					foreach ($arrserie2 as $i => $serie) {
				                    						/**INSERTAMOS EN SERIE**/
				                    						$filterSerie== new stdClass();
				                    						if($tipo_oper=='C'){
					                    						$filterSerie->PROD_Codigo=$producto_id;
					                    						$filterSerie->SERIC_Numero=$serie->serieNumero;
					                    						if($serie->serieCodigo!=null && $serie->serieCodigo!=0)
					                    							$filterSerie->SERIC_FechaModificacion=date("Y-m-d H:i:s");
					                    						else
					                    							$filterSerie->SERIC_FechaRegistro=date("Y-m-d H:i:s");
					                    								 
					                    							$filterSerie->SERIC_FlagEstado='1';
					                    							if($serie->serieCodigo!=null && $serie->serieCodigo!=0){
					                    								$this->serie_model->modificar($serie->serieCodigo,$filterSerie);
					                    								
					                    								$filterSerieD= new stdClass();
					                    								$filterSerieD->SERDOC_FlagEstado='1';
					                    								$this->seriedocumento_model->modificar($serie->serieDocumentoCodigo,$filterSerieD);
					                    							}else{
					                    								$filterSerie->ALMAP_Codigo=$codigoAlmacenProducto;
					                    								$codigoSerie=$this->serie_model->insertar($filterSerie);
					                    								/**insertamso serie documento**/
					                    								/**DOCUMENTO COMPROBANTE**/
					                    								$filterSerieD= new stdClass();
					                    								$filterSerieD->SERDOC_Codigo=null;
					                    								$filterSerieD->SERIP_Codigo=$codigoSerie;
					                    								/**10:documento guiaremision**/
					                    								$filterSerieD->DOCUP_Codigo=10;
					                    								$filterSerieD->SERDOC_NumeroRef=$guiarem_id;
					                    								/**1:ingreso**/
					                    								$filterSerieD->TIPOMOV_Tipo=1;
					                    								$filterSerieD->SERDOC_FechaRegistro=date("Y-m-d H:i:s");
					                    								$filterSerieD->SERDOC_FlagEstado='1';
					                    								$this->seriedocumento_model->insertar($filterSerieD);
					                    								/**FIN DE INSERTAR EN SERIE**/
					                    							}
				                    						}
				                    						/**FIN DE INSERTAR EN SERIE**/
				                    						/**ACTUALIZAMOS  EN SERIE  CON EL DOCUMENTO Y NUMERO DE REFERENCIA**/
				                    						if($tipo_oper=='V'){
				                    							if($serie->serieDocumentoCodigo!=null && $serie->serieDocumentoCodigo!=0){
				                    								$filterSerie->SERDOC_FlagEstado='1';
				                    								$this->seriedocumento_model->modificar($serie->serieDocumentoCodigo,$filterSerie);
				                    							}else{
				                    								/**insertamso serie documento**/
				                    								/**DOCUMENTO COMPROBANTE**/
				                    								$filterSerieD= new stdClass();
				                    								$filterSerieD->SERDOC_Codigo=null;
				                    								$filterSerieD->SERIP_Codigo=$serie->serieCodigo;
				                    								$filterSerieD->DOCUP_Codigo=10;
				                    								$filterSerieD->SERDOC_NumeroRef=$guiarem_id;
				                    								/**2:ingreso**/
				                    								$filterSerieD->TIPOMOV_Tipo=2;
				                    								$filterSerieD->SERDOC_FechaRegistro=date("Y-m-d H:i:s");
				                    								$filterSerieD->SERDOC_FlagEstado='1';
				                    								$this->seriedocumento_model->insertar($filterSerieD);
				                    								/**FIN DE INSERTAR EN SERIE**/
				                    							}
				                    							/**los registros en estadoSeleccion 1:seleccionado**/
				                    							$this->almacenproductoserie_model->seleccionarSerieBD($serie->serieCodigo,1);
				                    						}				
				                    					}
				                    					break;
				                    				}
		                    					}
		                    					break;
		                    				}
		                    			}
		                    			//if($estado=='2'){
		                    				if($tipo_oper == 'C'){
		                    					/**eliminamos los registros en estado cero**/
		                    					$this->seriedocumento_model->eliminarEstadoDocumentoSerie(10,$guiarem_id);
		                    				}
		                    				
		                    				if($tipo_oper == 'V'){
		                    					/**eliminamos los registros en estado cero solo de serieDocumento**/
		                    					$this->seriedocumento_model->eliminarDocumento($guiarem_id,10);
		                    				}
		                    				
		                    			//}
		                    			 
		                    		}
		                    	}
	 	                    }
		                    /**fin de insertar serie**/
	                	}else{
	                		
	                		$producto_id=$valor;
	                		/**gcbq insertar serie de cada producto**/
	                		if($flagGenInd[$indice]='I'){
	                			/***pongo todos en estado cero de las series asociadas a ese producto**/
	                			$seriesProductoBD=$this->session->userdata('serieRealBD');
	                			$serieBD = $seriesProductoBD;
	                			if($serieBD!=null && count($serieBD)>0){
	                				foreach ($serieBD as $alm1BD => $arrAlmaBD) {
	                					if($alm1BD ==$codigoAlmacenProducto){
	                						foreach ($arrAlmaBD as $ind1BD => $arrserieBD) {
	                							if ($ind1BD == $producto_id) {
	                								foreach ($arrserieBD as $keyBD => $valueBD) {
	                									$serieCodigo=$valueBD->SERIP_Codigo;
	                									/**cambiamos a ewstado 0**/
	                									$filterSerie== new stdClass();
	                		
	                									/**SI ES COMPRA SE MODIFICA EL ESTADO***/
	                									if($tipo_oper == 'C'){
	                										$filterSerie->SERIC_FlagEstado='0';
	                										$this->serie_model->modificar($serieCodigo,$filterSerie);
	                									}
	                									 
	                									/**si es venta solamente cambia de estado seridocumento**/
	                									$filterSerieD= new stdClass();
	                									$filterSerieD->SERDOC_FlagEstado='0';
	                									$this->seriedocumento_model->modificar($valueBD->SERDOC_Codigo,$filterSerieD);
	                		
	                									/**TIPO OPERACION VENTA SE DESHABILITAN LAS SERIES SELECCIONADAS POR EL COMPROBANTE**/
	                									if($tipo_oper == 'V'){
	                										/**eliminamos los registros en estadoSeleccion cero:0:desleccionado**/
	                										$this->almacenproductoserie_model->seleccionarSerieBD($serieCodigo,0);
	                									}
	                									/**FIN DE DESELECCIONAR***/
	                								}
	                							}
	                						}
	                					}
	                				}
	                				if($tipo_oper == 'C'){
	                					/**eliminamos los registros en estado cero**/
	                					$this->seriedocumento_model->eliminarEstadoDocumentoSerie(10,$guiarem_id);
	                				}
	                				
	                				if($tipo_oper == 'V'){
	                					/**eliminamos los registros en estado cero solo de serieDocumento**/
	                					$this->seriedocumento_model->eliminarDocumento($guiarem_id,10);
	                				}
	                		
	                		
	                		
	                			}
	                			/**fin de poner estado cero**/
	                		}
	                		$codigoDetalle=$detacodi[$indice];
	                		if($codigoDetalle!=0 && trim($codigoDetalle)!=""){
	                			if($estado!=null && $estado==2){
	                				$this->guiaremdetalle_model->eliminar($codigoDetalle);
	                			}else{
	                				$objetoM=new stdClass();
	                				$objetoM->GUIAREMDETC_FlagEstado=0;
	                				$this->guiaremdetalle_model->modificar($codigoDetalle,$objetoM);
	                			}
	                		}
	                		
	                	}
	                }
	                //$this->cotizacion_model->modificar_detcotizacion_flagCompra($detcotizacion->COTDEP_Codigo);
	
	            }
	        }
	
			/**verificamos si el estado de la guiarem se encuentra en estado 1 ya ejecuto el disparador**/
	        if($estado!=null && $estado==1){
	        	if($guiarem_id!=null && $guiarem_id!=0){
	        		if($query = $this->db->query("CALL GUIAREM_COMPROBANTE_MODIFICAR($guiarem_id)"))
	        		{
	        			exit('{"result":"ok", "codigo":"' . $guiarem_id . '"}');
	        		}else{
	        			exit('{"result":"error", "campo":"otro_motivo"}');
	        		}
	        	}
	        }
   		}
   		exit('{"result":"ok", "codigo":"' . $guiarem_id . '"}');
    }

    public function disparador($codigo, $tipo_oper = 'V')
    {
    	if($codigo!=null && $codigo!=0){
    		if($query = $this->db->query("CALL GUIAREM_DISPARADOR($codigo)"))
    		{
    			print_r($query->row());
    		}else{
    			show_error('Error!');
    		}
    	}
        redirect('almacen/guiarem/listar/' . $tipo_oper);
    }


    public function buscar_guias_x_orden($tipo_oper, $orden)
    {

        $datosOrden = $this->ocompra_model->obtener_ocompra($orden);
        $lista = array();
        $data = array();
        if (count($datosOrden) > 0) {
            switch ($tipo_oper) {
                case 'C':
                    $data = $this->guiarem_model->buscar_x_orden('C', 'C', $datosOrden[0]->OCOMP_Codigo);
                    break;
                case 'V':
                    $data = $this->guiarem_model->buscar_x_orden('V', 'V', $datosOrden[0]->OCOMP_Codigo);
                    break;
            }
        }

        if (count($data) > 0) {

            foreach ($data as $value) {

                $filter = new stdClass();

                $filter->codigo = $value->GUIAREMP_Codigo;

                $filter->serie = $value->GUIAREMC_Serie;

                $filter->numero = $value->GUIAREMC_Numero;

                if ($tipo_oper == 'C') {

                    $razon = $this->proveedor_model->obtener($value->PROVP_Codigo);

                } else if ($tipo_oper == 'C') {

                    $razon = $this->cliente_model->obtener($value->CLIP_Codigo);

                }

                $filter->razon = $razon->nombre;

                $filter->total = $value->GUIAREMDETC_Total;

                //print_r($filter);exit;

                $lista[] = $filter;

            }

        }

        echo json_encode($lista);

    }

    public function ver_guias_x_orden_producto($tipo_orden, $tipo_guia, $cod_orden, $cod_prod)
    {


        $guias = $this->guiarem_model->buscar_x_producto_orden($tipo_orden, $tipo_guia, $cod_orden, $cod_prod);
        $producto = $this->producto_model->obtener_producto($cod_prod);
        $lista_detalles = array();

        if (count($guias) > 0) {

            foreach ($guias as $key => $value) {
                $serie = $value->GUIAREMC_Serie;
                $numero = $value->GUIAREMC_Numero;
                $fecha = mysql_to_human($value->GUIAREMC_Fecha);
                if ($value->PROVP_Codigo != '')
                    $datos_prove = $this->proveedor_model->obtener($value->PROVP_Codigo);
                else
                    $datos_prove = $this->cliente_model->obtener($value->CLIP_Codigo);

                $razon = $datos_prove->nombre;
                $cantidad = $value->GUIAREMDETC_Cantidad;
                $objeto = new stdClass();
                $objeto->serie = $serie;
                $objeto->numero = $numero;
                $objeto->fecha = $fecha;
                $objeto->cantidad = $cantidad;
                $objeto->razon = $razon;
                $lista_detalles[] = $objeto;

            }

        }


        $data['lista_detalles'] = $lista_detalles;
        $data['producto'] = $producto;
        $this->load->view("almacen/guiarem_x_orden_producto", $data);

    }


    public function eliminar()
    {

        $guiarem_id = $this->input->post('codigo');
        $guiarem = $this->guiarem_model->obtener($guiarem_id);
        $guiasa_id = $guiarem[0]->GUIASAP_Codigo;
        $this->guiaremdetalle_model->eliminar2($guiarem_id);
        $this->guiarem_model->eliminar($guiarem_id);
        $this->guiasadetalle_model->eliminar2($guiasa_id);
        $this->guiasa_model->eliminar($guiasa_id);
        echo true;

    }


    public function obtener_detalle_guiarem($guiarem, $tipo_oper = 'V', $almacen = 1)
    {

        $detalle = $this->guiaremdetalle_model->listar($guiarem);
        $lista_detalles = array();
        $datos_guiarem = $this->guiarem_model->obtener($guiarem);
        $moneda = $datos_guiarem[0]->MONED_Codigo;
        $serie = $datos_guiarem[0]->GUIAREMC_Serie;
        $numero = $datos_guiarem[0]->GUIAREMC_Numero;
        $codigo_usuario = $datos_guiarem[0]->GUIAREMC_CodigoUsuario;
        $cliente = $datos_guiarem[0]->CLIP_Codigo;
        $proveedor = $datos_guiarem[0]->PROVP_Codigo;
        if ($tipo_oper == 'V')
            $datos = $this->cliente_model->obtener($cliente);
        else if ($tipo_oper == 'C')
            $datos = $this->proveedor_model->obtener($proveedor);

        if ($datos) {
            $ruc = $datos->ruc;
            $razon_social = $datos->nombre;
        } else {
            $ruc = "";
            $razon_social = "";
        }


        if (count($detalle) > 0) {
        	
            foreach ($detalle as $indice => $valor) {
                $detacod = $valor->GUIAREMDETP_Codigo;
                $producto = $valor->PRODCTOP_Codigo;
                $unidad_medida = $valor->UNDMED_Codigo;
                $cantidad = $valor->GUIAREMDETC_Cantidad;
                $flagGenInd = $valor->GUIAREMDETC_GenInd;
                $pu = $valor->GUIAREMDETC_Pu;
                $subtotal = $valor->GUIAREMDETC_Subtotal;
                $igv = $valor->GUIAREMDETC_Igv;
                $descuento = $valor->GUIAREMDETC_Descuento;
                $total = $valor->GUIAREMDETC_Total;
                $pu_conigv = $valor->GUIAREMDETC_Pu_ConIgv;
                $datos_producto = $this->producto_model->obtener_producto($producto);
                $codigo_interno = $datos_producto[0]->PROD_CodigoInterno;
                $flagBS = $datos_producto[0]->PROD_FlagBienServicio;
                $costo = $datos_producto[0]->PROD_UltimoCosto;
                $almacenProducto = $datos_guiarem[0]->ALMAP_Codigo;
                $datos_almaprod = $this->almacenproducto_model->obtener($almacen, $producto);
                if ($datos_almaprod)
                    $stock = $datos_almaprod[0]->ALMPROD_Stock;
                else
                    $stock = "";

                $nombre_producto = str_replace('"', "''", $valor->GUIAREMDETC_Descripcion);
                $datos_umedida = $this->unidadmedida_model->obtener($unidad_medida);
                $nombre_unidad = $datos_umedida[0]->UNDMED_Descripcion;

               
                $objeto = new stdClass();
                $objeto->GUIAREMDETP_Codigo = $detacod;
                $objeto->PROD_Codigo = $producto;
                $objeto->PROD_CodigoInterno = $codigo_interno;
                $objeto->UNDMED_Codigo = $unidad_medida;
                $objeto->UNDMED_Descripcion = $nombre_unidad;
                $objeto->PROD_Nombre = $nombre_producto;
                $objeto->GUIAREMDETC_Cantidad = $cantidad;
                $objeto->GUIAREMDETC_Pu = $pu;
                $objeto->GUIAREMDETC_Subtotal = $subtotal;
                $objeto->GUIAREMDETC_Descuento = $descuento;
                $objeto->GUIAREMDETC_Igv = $igv;
                $objeto->GUIAREMDETC_Total = $total;
                $objeto->GUIAREMDETC_Pu_ConIgv = $pu_conigv;
                $objeto->Ruc = $ruc;
                $objeto->RazonSocial = $razon_social;
                $objeto->CLIP_Codigo = $cliente;
                $objeto->PROVP_Codigo=$proveedor;
                $objeto->MONED_Codigo = $moneda;
                $objeto->GUIAREMC_Serie = $serie;
                $objeto->GUIAREMC_Numero = $numero;
                $objeto->GUIAREMC_CodigoUsuario = $codigo_usuario;
                $objeto->ALMAP_Codigo =$almacenProducto;
                $objeto->GUIAREMDETC_GenInd =$flagGenInd;
                
                $objeto->onclick = $producto . ",'" . $codigo_interno . "','" . $nombre_producto . "'," . $cantidad . ",'" . $flagBS . "','" . $flagGenInd . "'," . $unidad_medida . ",'" . $nombre_unidad . "'," . $pu_conigv . "," . $pu . "," . $subtotal . "," . $igv . "," . $total . "," . $stock . "," . $costo;
			 	$lista_detalles[] = $objeto;
            }

        } else {

            $objeto = new stdClass();
            $objeto->GUIAREMDETP_Codigo = '';
            $objeto->Ruc = $ruc;
            $objeto->RazonSocial = $razon_social;
            $objeto->CLIP_Codigo = $cliente;
            $objeto->MONED_Codigo = $moneda;
            $objeto->GUIAREMC_Serie = $serie;
            $objeto->GUIAREMC_Numero = $numero;
            $objeto->GUIAREMC_CodigoUsuario = $codigo_usuario;
            $lista_detalles[] = $objeto;
        }
        $resultado = json_encode($lista_detalles);
        echo $resultado;

    }


    public function guiarem_ver_pdf($codigo, $tipo_oper = 'V')
    {

        $img = 1;


        switch (FORMATO_IMPRESION) {

            case 1: //Formato para ferresat

                $this->guiarem_ver_pdf_conmenbrete_formato1($codigo, $tipo_oper, $img);

//			   $this->guiarem_ver_pdf_formato1($codigo, $tipo_oper);

                break;

            case 2:  //Formato para jimmyplat

                $this->guiarem_ver_pdf_formato2($codigo, $tipo_oper);

                break;

            case 3:  //Formato para instrumentos y systemas

                $this->guiarem_ver_pdf_formato3($codigo, $tipo_oper);

                break;

            case 4:  //Formato para ferremax

                $this->guiarem_ver_pdf_formato4($codigo, $tipo_oper);

                break;

            case 5:  //Formato para G Y C

                if ($_SESSION['compania'] == "1") {

                    $this->guiarem_ver_pdf_formato5($codigo, $tipo_oper);

                } else {

                    $this->guiarem_ver_pdf_formato6($codigo, $tipo_oper);

                }

                break;

            case 6:  //DISTRIBUIDORA C Y L

                $this->guiarem_ver_pdf_formato7($codigo, $tipo_oper);

                break;

            case 8:  //	PARA IMPACTO EL METODO TERMINADO EN 8_1 ES PARA LA COMP�?ÑIA 1 Y 8_2 PARA LA COMPAÑIA 2 

                // if($_SESSION['compania'] == "1"){

                $this->guiarem_ver_pdf_formato8_1($codigo, $tipo_oper);

                // }else{

                // $this->guiarem_ver_pdf_formato8_2($codigo, $tipo_oper); 

                // }

                break;

            default:
                guiarem_ver_pdf_formato1($codigo, $tipo_oper);

                break;

        }

    }


    public function guiarem_ver_pdf_conmenbrete($codigo, $tipo_oper = 'V')
    {

        $img = "";

        switch (FORMATO_IMPRESION) {

            case 1: //Formato para ferresat

                $this->guiarem_ver_pdf_conmenbrete_formato11($codigo, $tipo_oper, $img);

                break;

            case 2:  //Formato para jimmyplat

                $this->guiarem_ver_pdf_conmenbrete_formato2($codigo, $tipo_oper);

                break;

            case 3:  //Formato para instrumentos y systemas

                $this->guiarem_ver_pdf_conmenbrete_formato3($codigo, $tipo_oper);

                break;

            case 4:  //Formato para ferremax

                $this->guiarem_ver_pdf_conmenbrete_formato4($codigo, $tipo_oper);

                break;

            case 5:  //DISTRIBUIDORA G Y C

                if ($_SESSION['compania'] == "1") {

                    /* DISTRIBUIDORA G Y C */

                    $this->guiarem_ver_pdf_conmenbrete_formato5($codigo, $tipo_oper);

                } else {

                    /* DISTRIBUIDORA G Y C electro data */

                    $this->guiarem_ver_pdf_conmenbrete_formato6($codigo, $tipo_oper);

                }

                break;

            case 6:  //DISTRIBUIDORA C Y L

                $this->guiarem_ver_pdf_conmenbrete_formato7($codigo, $tipo_oper);

                break;

            case 7:  //FAMYSERFE

                $this->guiarem_ver_pdf_conmenbrete_formato8($codigo, $tipo_oper);

                break;

            case 8:  //COMPAÑIA IMPACTO EL CASO 8_1 ES PARA LA COMPAÑIA 1 Y EL 2 ES PARA LA COMÑAIA DDO

                // if($_SESSION['compania'] == "1"){

                $this->guiarem_ver_pdf_conmenbrete_formato8_1($codigo, $tipo_oper);

                // }else{

                // $this->guiarem_ver_pdf_conmenbrete_formato8_2($codigo, $tipo_oper); 

                // }

                break;

            default:
                guiarem_ver_pdf_conmenbrete_formato1($codigo, $tipo_oper, $img);

                break;

        }

    }


    public function guiarem_ver_pdf_formato1($codigo, $tipo_oper)
    {

        //$this->load->library('cezpdf');

        //$this->load->helper('pdf_helper');

        $datos_guiarem = $this->guiarem_model->obtener($codigo);

        $datos_detalle_guiarem = $this->guiaremdetalle_model->obtener2($codigo);

        $tipo_movimiento = $datos_guiarem[0]->TIPOMOVP_Codigo;

        $referencia = $datos_guiarem[0]->DOCUP_Codigo;

        $cliente = $datos_guiarem[0]->CLIP_Codigo;


        $proveedor = $datos_guiarem[0]->PROVP_Codigo;

        $guiasap = $datos_guiarem[0]->GUIASAP_Codigo;

        $guiainp = $datos_guiarem[0]->GUIAINP_Codigo;

        $numero_ref = $datos_guiarem[0]->GUIAREMC_NumeroRef;

        $numero_ocompra = $datos_guiarem[0]->GUIAREMC_OCompra;

        $serie = $datos_guiarem[0]->GUIAREMC_Serie;

        $numero = $datos_guiarem[0]->GUIAREMC_Numero;

        $fecha_traslado = mysql_to_human($datos_guiarem[0]->GUIAREMC_FechaTraslado);

        $observacion = $datos_guiarem[0]->GUIAREMC_Observacion;

        $marca = $datos_guiarem[0]->GUIAREMC_Marca;

        $placa = $datos_guiarem[0]->GUIAREMC_Placa;

        $registro_mtc = $datos_guiarem[0]->GUIAREMC_RegistroMTC;

        $certificado = $datos_guiarem[0]->GUIAREMC_Certificado;

        $licencia = $datos_guiarem[0]->GUIAREMC_Licencia;

        $nombre_conductor = $datos_guiarem[0]->GUIAREMC_NombreConductor;

        $punto_partida = $datos_guiarem[0]->GUIAREMC_PuntoPartida;

        $arr_punt_part = explode('/', $punto_partida);

        $punto_llegada = $datos_guiarem[0]->GUIAREMC_PuntoLlegada;

        $arr_punt_lleg = explode('/', $punto_llegada);

        $empresa_transporte = $datos_guiarem[0]->EMPRP_Codigo;

        $fecha = mysql_to_human($datos_guiarem[0]->GUIAREMC_Fecha);

        $otro_motivo = $datos_guiarem[0]->GUIAREMC_OtroMotivo;


        $nombre_emprtrans = "";

        $ruc_emprtrans = "";

        if ($empresa_transporte != '') {

            $datos_emprtrans = $this->empresa_model->obtener_datosEmpresa($empresa_transporte);

            if (count($datos_emprtrans) > 0) {

                $ruc_emprtrans = $datos_emprtrans[0]->EMPRC_Ruc;

                $nombre_emprtrans = $datos_emprtrans[0]->EMPRC_RazonSocial;

            }

        }

        $nombre_tipodoc = '';

        if ($referencia != '') {

            $datos_doc = $this->documento_model->obtener($referencia);

            $nombre_tipodoc = $datos_doc[0]->DOCUC_Descripcion;

        }


        /* Datos del cliente */

        if ($tipo_oper == "C") {

            $cliente = $proveedor;

        }

        $datos_cliente = $this->cliente_model->obtener($cliente);

        $razon_social = utf8_decode($datos_cliente->nombre);

        $tipo_doc = ($datos_cliente->tipo == '0' ? 'D.N.1' : 'R.U.C.');

        $ruc = $datos_cliente->ruc;

        $distrito_cliente = $datos_cliente->distrito;

        $provincia_cliente = $datos_cliente->provincia;

        $departamento_cliente = $datos_cliente->departamento;


        $razon_social2 = '';

        if (strlen($razon_social) > 26) {

            $razon_social2 = substr($razon_social, 26);

            $razon_social = substr($razon_social, 0, 26);

        }

        $nombre_emprtrans2 = '';

        if (strlen($nombre_emprtrans) > 27) {

            $nombre_emprtrans2 = substr($nombre_emprtrans, 27);

            $nombre_emprtrans = substr($nombre_emprtrans, 0, 27);

        }

        $otro_motivo2 = '';

        if (strlen($otro_motivo) > 18) {

            $otro_motivo2 = substr($otro_motivo, 18);

            $otro_motivo = substr($otro_motivo, 0, 18);

        }


        /* Cabecera */

        //prep_pdf();


        $this->cezpdf = new Cezpdf('a4');

        $this->cezpdf->selectFont('system/application/libraries/fonts/Helvetica-Bold.afm');


        $this->cezpdf->ezText('', '', array("leading" => 108));


        $this->cezpdf->ezText($fecha, 10, array("leading" => 15, "left" => 30));

        $this->cezpdf->ezText($fecha_traslado, 10, array("leading" => 0, "left" => 190));


        $this->cezpdf->ezText(utf8_decode_seguro($arr_punt_part[0]), 10, array("leading" => 45, "left" => 25));

        $this->cezpdf->ezText(utf8_decode_seguro(isset($arr_punt_part[1]) ? $arr_punt_part[1] : ''), 10, array("leading" => 0, "left" => 160));

        $this->cezpdf->ezText(utf8_decode_seguro(isset($arr_punt_lleg[0]) ? $arr_punt_lleg[0] : ''), 10, array("leading" => 0, "left" => 315));

        $this->cezpdf->ezText(utf8_decode_seguro(isset($arr_punt_lleg[1]) ? substr($arr_punt_lleg[1], 0, 15) : ''), 10, array("leading" => 0, "left" => 445));

        $this->cezpdf->ezText(utf8_decode_seguro(isset($arr_punt_part[2]) ? $arr_punt_part[2] : ''), 10, array("leading" => 18, "left" => 5));

        $this->cezpdf->ezText(utf8_decode_seguro(isset($arr_punt_part[3]) ? substr($arr_punt_part[3], 0, 15) : ''), 10, array("leading" => 0, "left" => 110));

        $this->cezpdf->ezText(utf8_decode_seguro(isset($arr_punt_part[4]) ? substr($arr_punt_part[4], 0, 12) : ''), 10, array("leading" => 0, "left" => 197));

        $this->cezpdf->ezText(utf8_decode_seguro(isset($arr_punt_lleg[2]) ? substr($arr_punt_lleg[2], 0, 20) : ''), 10, array("leading" => 0, "left" => 290));

        $this->cezpdf->ezText(utf8_decode_seguro(isset($arr_punt_lleg[3]) ? substr($arr_punt_lleg[3], 0, 15) : ''), 10, array("leading" => 0, "left" => 395));

        $this->cezpdf->ezText(utf8_decode_seguro(isset($arr_punt_lleg[4]) ? $arr_punt_lleg[4] : ''), 9, array("leading" => 0, "left" => 490));

        $this->cezpdf->ezText(utf8_decode_seguro(substr((isset($arr_punt_part[5]) ? $arr_punt_part[5] : ''), 0, 12)), 10, array("leading" => 18, "left" => 25));

        $this->cezpdf->ezText(utf8_decode_seguro(substr((isset($arr_punt_part[6]) ? $arr_punt_part[6] : ''), 0, 8)), 10, array("leading" => 0, "left" => 100));

        $this->cezpdf->ezText(utf8_decode_seguro(substr((isset($arr_punt_part[7]) ? $arr_punt_part[7] : ''), 0, 8)), 10, array("leading" => 0, "left" => 200));

        $this->cezpdf->ezText(utf8_decode_seguro(substr((isset($arr_punt_lleg[5]) ? $arr_punt_lleg[5] : ''), 0, 8)), 10, array("leading" => 0, "left" => 315));

        $this->cezpdf->ezText(utf8_decode_seguro(substr((isset($arr_punt_lleg[6]) ? $arr_punt_lleg[6] : ''), 0, 20)), 10, array("leading" => 0, "left" => 383));

        $this->cezpdf->ezText(utf8_decode_seguro(substr((isset($arr_punt_lleg[7]) ? $arr_punt_lleg[7] : ''), 0, 20)), 10, array("leading" => 0, "left" => 492));


        $this->cezpdf->ezText(($razon_social2 != '' ? $razon_social . '-' : $razon_social), 10, array("leading" => 43, "left" => 122));

        $this->cezpdf->ezText($marca . ($placa != '' ? ' / ' . $placa : ''), 10, array("leading" => 0, "left" => 400));

        $this->cezpdf->ezText($razon_social2, 10, array("leading" => 10, "left" => -10));

        $this->cezpdf->ezText($ruc, 11, array("leading" => 9, "left" => 22));

        $this->cezpdf->ezText($certificado, 10, array("leading" => 0, "left" => 410));

        $this->cezpdf->ezText($tipo_doc . '   ' . $ruc, 10, array("leading" => 18, "left" => 152));

        $this->cezpdf->ezText($licencia, 10, array("leading" => 0, "left" => 388));


        $this->cezpdf->ezText('', '', array("leading" => 35));


        /* Detalle */

        $db_data = array();

        if (count($datos_detalle_guiarem) > 0) {

            foreach ($datos_detalle_guiarem as $indice => $valor) {

                $producto = $valor->PRODCTOP_Codigo;

                $unidad = $valor->UNDMED_Codigo;

                $costo = $valor->GUIAREMDETC_Costo;

                $venta = $valor->GUIAREMDETC_Venta;

                $peso = $valor->GUIAREMDETC_Peso;

                $descri = $valor->GUIAREMDETC_Descripcion;

                $datos_producto = $this->producto_model->obtener_producto($producto);

                $datos_unidad = $this->unidadmedida_model->obtener($unidad);

                $prod_nombre = $datos_producto[0]->PROD_Nombre;

                $prod_codigo = $datos_producto[0]->PROD_CodigoInterno;

                $prod_unidad = $datos_unidad[0]->UNDMED_Simbolo;

                $prod_cantidad = $valor->GUIAREMDETC_Cantidad;

                //---------------------------------------------------------------------------	

                if ($tipo_oper == "C") {

                    $datos_serie = $this->seriemov_model->buscar_x_guiainp($guiainp, $producto);

                } else {

                    $datos_serie = $this->seriemov_model->buscar_x_guiasap($guiasap, $producto);

                }

                if (count($datos_serie) > 0) {

                    $ser = "";

                    foreach ($datos_serie as $indices => $valor) {

                        $seriecodigo = $valor->SERIC_Numero;

                        $ser = $ser . " *" . $seriecodigo;

                    }

                }

                //------------------------------------------------------------------------------		


                $db_data[] = array(

                    'col1' => utf8_decode_seguro($descri),

                    'col2' => $prod_unidad,

                    'col3' => $prod_cantidad,

                    'col4' => $ser

                );

                $ser = "";

            }

        }

        $this->cezpdf->ezTable($db_data, '', '', array(

            'showLines' => 0,

            'shaded' => 0,

            'showHeadings' => 0,

            'xPos' => 'center',

            'fontSize' => 11,

            'cols' => array(

                'col1' => array('width' => 320, 'justification' => 'left'),

                'col2' => array('width' => 60, 'justification' => 'center'),

                'col3' => array('width' => 55, 'justification' => 'center'),

                'col4' => array('width' => 110, 'justification' => 'center')

            )

        ));


        $this->cezpdf->addText(35, 220, 10, utf8_decode_seguro($observacion));

        $this->cezpdf->addText(55, 182, 10, utf8_decode_seguro($nombre_emprtrans2 != '' ? $nombre_emprtrans . '-' : $nombre_emprtrans));

        $this->cezpdf->addText(20, 172, 10, utf8_decode_seguro($nombre_emprtrans2));

        $this->cezpdf->addText(50, 157, 10, $ruc_emprtrans);

        $this->cezpdf->addText(55, 117, 10, utf8_decode_seguro(strtoupper($nombre_tipodoc)));

        $this->cezpdf->addText(55, 97, 10, $numero_ref);


        $posx = 0;

        $posy = 0;

        switch ($tipo_movimiento) {

            case 1:
                $posx = 227;

                $posy = 185;

                break;

            case 2:
                $posx = 227;

                $posy = 176;

                break;

            case 3:
                $posx = 227;

                $posy = 160;

                break;

            case 4:
                $posx = 227;

                $posy = 151;

                break;

            case 5:
                $posx = 227;

                $posy = 142;

                break;

            case 6:
                $posx = 227;

                $posy = 133;

                break;

            case 7:
                $posx = 227;

                $posy = 117;

                break;

            case 8:
                $posx = 227;

                $posy = 108;

                break;

            case 9:
                $posx = 227;

                $posy = 99;

                break;

            case 10:
                $posx = 373;

                $posy = 185;

                break;

            case 11:
                $posx = 373;

                $posy = 177;

                break;

            case 12:
                $posx = 373;

                $posy = 169;

                break;

            case 13:
                $posx = 373;

                $posy = 160;

                break;

        }

        $this->cezpdf->addText($posx, $posy, 14, 'x');

        if ($tipo_movimiento == 13) {

            $this->cezpdf->addText(383, 154, 8, ($otro_motivo2 != '' ? $otro_motivo . '-' : $otro_motivo));

            $this->cezpdf->addText(383, 145, 8, $otro_motivo2);

        }

        $this->cezpdf->addText(368, 140, 10, utf8_decode_seguro('N° DE O.COMPRA:'));

        $this->cezpdf->addText(368, 120, 10, utf8_decode_seguro($numero_ocompra));


        $cabecera = array('Content-Type' => 'application/pdf', 'Content-Disposition' => 'nama_file.pdf', 'Expires' => '0', 'Pragma' => 'cache', 'Cache-Control' => 'private');

        $this->cezpdf->ezStream($cabecera);

    }


    public function guiarem_ver_pdf_formato2($codigo, $tipo_oper)
    {

        $datos_guiarem = $this->guiarem_model->obtener($codigo);

        $datos_detalle_guiarem = $this->guiaremdetalle_model->obtener2($codigo);

        $tipo_movimiento = $datos_guiarem[0]->TIPOMOVP_Codigo;

        $referencia = $datos_guiarem[0]->DOCUP_Codigo;

        $cliente = $datos_guiarem[0]->CLIP_Codigo;

        $numero_ref = $datos_guiarem[0]->GUIAREMC_NumeroRef;

        $serie = $datos_guiarem[0]->GUIAREMC_Serie;

        $numero = $datos_guiarem[0]->GUIAREMC_Numero;

        $fecha_traslado = mysql_to_human($datos_guiarem[0]->GUIAREMC_FechaTraslado);

        $observacion = $datos_guiarem[0]->GUIAREMC_Observacion;

        $marca = $datos_guiarem[0]->GUIAREMC_Marca;

        $placa = $datos_guiarem[0]->GUIAREMC_Placa;

        $registro_mtc = $datos_guiarem[0]->GUIAREMC_RegistroMTC;

        $certificado = $datos_guiarem[0]->GUIAREMC_Certificado;

        $licencia = $datos_guiarem[0]->GUIAREMC_Licencia;

        $nombre_conductor = $datos_guiarem[0]->GUIAREMC_NombreConductor;

        $punto_partida = $datos_guiarem[0]->GUIAREMC_PuntoPartida;

        $punto_llegada = $datos_guiarem[0]->GUIAREMC_PuntoLlegada;

        $empresa_transporte = $datos_guiarem[0]->EMPRP_Codigo;

        $fecha = mysql_to_human($datos_guiarem[0]->GUIAREMC_Fecha);

        $otro_motivo = $datos_guiarem[0]->GUIAREMC_OtroMotivo;


        $nombre_emprtrans = "";

        $ruc_emprtrans = "";

        if ($empresa_transporte != '') {

            $datos_emprtrans = $this->empresa_model->obtener_datosEmpresa($empresa_transporte);

            if (count($datos_emprtrans) > 0) {

                $ruc_emprtrans = $datos_emprtrans[0]->EMPRC_Ruc;

                $nombre_emprtrans = $datos_emprtrans[0]->EMPRC_RazonSocial;

            }

        }


        $nombre_tipodoc = '';

        if ($referencia != '') {

            $datos_doc = $this->documento_model->obtener($referencia);

            if (count($datos_doc))

                $nombre_tipodoc = $datos_doc[0]->DOCUC_Inicial;

        }


        /* Datos del cliente */

        $datos_cliente = $this->cliente_model->obtener($cliente);

        $razon_social = utf8_decode($datos_cliente->nombre);

        $ruc = $datos_cliente->ruc;


        $punto_partida2 = '';

        if (strlen($punto_partida) > 48) {

            $punto_partida2 = substr($punto_partida, 48);

            $punto_partida = substr($punto_partida, 0, 48);

        }

        $punto_llegada2 = '';

        if (strlen($punto_llegada) > 43) {

            $punto_llegada2 = substr($punto_llegada, 43);

            $punto_llegada = substr($punto_llegada, 0, 43);

        }

        /* $razon_social2='';

          if(strlen($razon_social)>15){

          $razon_social2=substr($razon_social,15);

          $razon_social=substr($razon_social,0,15);



          } */

        /* $nombre_emprtrans2='';

          if(strlen($nombre_emprtrans)>34){

          $nombre_emprtrans2=substr($nombre_emprtrans,34);

          $nombre_emprtrans=substr($nombre_emprtrans,0,34);

          } */


        /* Cabecera */

        //prep_pdf();

        $this->cezpdf = new Cezpdf('a4');

        //$this->cezpdf = new backgroundPDF('a4', 'portrait', 'image', array('img'=>'images/img_db/jimmyplast_fondo_guiarem.jpg')); 


        $this->cezpdf->ezText('', '', array("leading" => 102));


        /* Datos de Cabecera */


        $this->cezpdf->ezText(($punto_partida2 != '' ? utf8_decode_seguro($punto_partida) . '-' : utf8_decode_seguro($punto_partida)), 9, array("left" => 16));

        $this->cezpdf->ezText(($punto_llegada2 != '' ? utf8_decode_seguro($punto_llegada) . '-' : utf8_decode_seguro($punto_llegada)), 9, array("leading" => 0, "left" => 310));

        $this->cezpdf->ezText(utf8_decode_seguro(substr($punto_partida2, 0, 52)), 9, array("leading" => 12, "left" => 16));

        $this->cezpdf->ezText(substr(utf8_decode_seguro($punto_llegada2), 0, 50), 9, array("leading" => 0, "left" => 310));

        $this->cezpdf->ezText($fecha_traslado, 9, array("leading" => 16, "left" => 143));

        //$this->cezpdf->ezText((utf8_decode_seguro($razon_social2)!='' ? utf8_decode_seguro($razon_social).'-' : utf8_decode_seguro($razon_social)),9, array("leading"=>0,"left"=>450));

        $this->cezpdf->ezText(utf8_decode_seguro($razon_social), 9, array("leading" => 10, "left" => 310));

        $this->cezpdf->ezText($ruc, 9, array("leading" => 20, "left" => 320)); //-5


        $this->cezpdf->ezText($marca . ($placa != '' ? '/' . $placa : ''), 9, array("leading" => 32, "left" => 127));

        $this->cezpdf->ezText($nombre_emprtrans, 9, array("leading" => -3, "left" => 320)); //+2

        $this->cezpdf->ezText($certificado, 9, array("leading" => 13, "left" => 138));

        $this->cezpdf->ezText($licencia, 9, array("leading" => 13, "left" => 135));

        $this->cezpdf->ezText($ruc_emprtrans, 9, array("leading" => 0, "left" => 400));


        $this->cezpdf->ezText('', '', array("leading" => 30)); //+5

        //$this->cezpdf->ezText('','', array("leading"=>25));


        /* Detalle */

        $db_data = array();

        if (count($datos_detalle_guiarem) > 0) {

            foreach ($datos_detalle_guiarem as $indice => $valor) {

                $producto = $valor->PRODCTOP_Codigo;

                $unidad = $valor->UNDMED_Codigo;

                $costo = $valor->GUIAREMDETC_Costo;

                $venta = $valor->GUIAREMDETC_Venta;

                $peso = $valor->GUIAREMDETC_Peso;

                $descri = $valor->GUIAREMDETC_Descripcion;

                $datos_producto = $this->producto_model->obtener_producto($producto);

                $datos_unidad = $this->unidadmedida_model->obtener($unidad);

                $prod_nombre = $datos_producto[0]->PROD_Nombre;

                $prod_codigo = $datos_producto[0]->PROD_CodigoUsuario;

                $prod_unidad = $datos_unidad[0]->UNDMED_Simbolo;

                $prod_cantidad = $valor->GUIAREMDETC_Cantidad;

                $db_data[] = array(

                    'col0' => '',

                    'col1' => $prod_cantidad,

                    'col2' => $prod_unidad,

                    'col3' => utf8_decode_seguro($descri),

                    'col4' => ''

                );

            }

        }

        $this->cezpdf->ezTable($db_data, '', '', array(

            'showLines' => 0,

            'shaded' => 0,

            'showHeadings' => 0,

            'xPos' => 'center',

            'fontSize' => '10',

            'cols' => array(

                'col0' => array('width' => 30, 'justification' => 'center'),

                'col1' => array('width' => 50, 'justification' => 'center'),

                'col2' => array('width' => 60, 'justification' => 'center'),

                'col3' => array('width' => 300, 'justification' => 'left'),

                'col4' => array('width' => 140, 'justification' => 'center')

            )

        ));

        if ($nombre_tipodoc != '')

            $this->cezpdf->addText(200, 127, 9, strtoupper($nombre_tipodoc) . ' / ' . $numero_ref);

        //$this->cezpdf->addText(200,127,9,  strtoupper($nombre_tipodoc).' / '.$numero_ref);


        $posx = 0;

        $posy = 0;

        //echo $tipo_movimiento;exit;

        /*

          case 1:  $posx=87; $posy=112; break;

          case 2:  $posx=79; $posy=95; break;

          case 3:  $posx=79; $posy=75; break;

         */

        switch ($tipo_movimiento) {

            //case 1:  $posx=105; $posy=70; break;

            //case 1:  $posx=87; $posy=112; break;

            case 1:
                $posx = 86;

                $posy = 112;

                break;

            case 2:
                $posx = 86;

                $posy = 90;

                break;

            case 3:
                $posx = 86;

                $posy = 75;

                break;

            //case 4:  $posx=214; $posy=112; break;

            case 4:
                $posx = 195;

                $posy = 112;

                break;

            case 5:
                $posx = 195;

                $posy = 95;

                break;

            case 6:
                $posx = 195;

                $posy = 75;

                break;

            //case 7:  $posx=341; $posy=112; break;

            case 7:
                $posx = 330;

                $posy = 112;

                break;

            case 8:
                $posx = 330;

                $posy = 95;

                break;

            case 9:
                $posx = 330;

                $posy = 75;

                break;

            //case 10:  $posx=414; $posy=112; break;

            case 10:
                $posx = 435;

                $posy = 112;

                break;

            case 11:
                $posx = 435;

                $posy = 90;

                break;

            case 12:
                $posx = 435;

                $posy = 75;

                break;

            //case 13:  $posx=87; $posy=52; break;

            case 13:
                $posx = 86;

                $posy = 65;

                break;

        }

        $this->cezpdf->addText($posx, $posy, 14, 'x');

        if ($posx != 0 && $posy != 0)

            $this->cezpdf->addText(150, 65, 9, $otro_motivo);


        $cabecera = array('Content-Type' => 'application/pdf', 'Content-Disposition' => 'nama_file.pdf', 'Expires' => '0', 'Pragma' => 'cache', 'Cache-Control' => 'private');

        $this->cezpdf->ezStream($cabecera);

    }


    public function guiarem_ver_pdf_formato3($codigo, $tipo_oper)
    {

        $datos_guiarem = $this->guiarem_model->obtener($codigo);

        $datos_detalle_guiarem = $this->guiaremdetalle_model->obtener2($codigo);

        $tipo_movimiento = $datos_guiarem[0]->TIPOMOVP_Codigo;

        $referencia = $datos_guiarem[0]->DOCUP_Codigo;

        $cliente = $datos_guiarem[0]->CLIP_Codigo;

        $receciona_nombres = strtoupper($datos_guiarem[0]->GUIAREMC_PersReceNombre);

        $receciona_dni = $datos_guiarem[0]->GUIAREMC_PersReceDNI;

        $numero_ref = $datos_guiarem[0]->GUIAREMC_NumeroRef;

        $serie = $datos_guiarem[0]->GUIAREMC_Serie;

        $numero = $datos_guiarem[0]->GUIAREMC_Numero;

        $fecha_traslado = mysql_to_human($datos_guiarem[0]->GUIAREMC_FechaTraslado);

        $observacion = $datos_guiarem[0]->GUIAREMC_Observacion;

        $marca = $datos_guiarem[0]->GUIAREMC_Marca;

        $placa = $datos_guiarem[0]->GUIAREMC_Placa;

        $registro_mtc = $datos_guiarem[0]->GUIAREMC_RegistroMTC;

        $certificado = $datos_guiarem[0]->GUIAREMC_Certificado;

        $licencia = $datos_guiarem[0]->GUIAREMC_Licencia;

        $nombre_conductor = $datos_guiarem[0]->GUIAREMC_NombreConductor;

        $punto_partida = $datos_guiarem[0]->GUIAREMC_PuntoPartida;

        $punto_llegada = $datos_guiarem[0]->GUIAREMC_PuntoLlegada;

        $empresa_transporte = $datos_guiarem[0]->EMPRP_Codigo;

        $fecha = mysql_to_human($datos_guiarem[0]->GUIAREMC_Fecha);

        $otro_motivo = $datos_guiarem[0]->GUIAREMC_OtroMotivo;


        $nombre_emprtrans = "";

        $ruc_emprtrans = "";

        if ($empresa_transporte != '') {

            $datos_emprtrans = $this->empresa_model->obtener_datosEmpresa($empresa_transporte);

            if (count($datos_emprtrans) > 0) {

                $ruc_emprtrans = $datos_emprtrans[0]->EMPRC_Ruc;

                $nombre_emprtrans = $datos_emprtrans[0]->EMPRC_RazonSocial;

            }

        }


        $nombre_tipodoc = '';

        if ($referencia != '') {

            $datos_doc = $this->documento_model->obtener($referencia);

            if (count($datos_doc))

                $nombre_tipodoc = $datos_doc[0]->DOCUC_Inicial;

        }


        /* Datos del cliente */

        $datos_cliente = $this->cliente_model->obtener($cliente);

        $razon_social = utf8_decode($datos_cliente->nombre);

        $ruc = $datos_cliente->ruc;


        $punto_partida2 = '';

        if (strlen($punto_partida) > 38) {

            //$punto_partida2=substr($punto_partida,38);

            //$punto_partida=substr($punto_partida,0,38);

            $temp = dividir_texto($punto_partida, 38);

            $punto_partida = $temp['texto1'];

            $punto_partida2 = $temp['texto2'];

        }

        $punto_llegada2 = '';

        if (strlen($punto_llegada) > 38) {

            //$punto_llegada2=substr($punto_llegada,38);

            //$punto_llegada=substr($punto_llegada,0,38);

            $temp = dividir_texto($punto_llegada, 38);

            $punto_llegada = $temp['texto1'];

            $punto_llegada2 = $temp['texto2'];

        }

        if ($receciona_nombres != '') {

            $razon_social = $receciona_nombres;

            $ruc = 'DNI:  ' . $receciona_dni;

        }

        $razon_social2 = '';

        if (strlen($razon_social) > 18) {

            //$razon_social2=substr($razon_social,18);

            //$razon_social=substr($razon_social,0,18);

            $temp = dividir_texto($razon_social, 18);

            $razon_social = $temp['texto1'];

            $razon_social2 = $temp['texto2'];

        }

        $nombre_emprtrans2 = '';

        if (strlen($nombre_emprtrans) > 34) {

            //$nombre_emprtrans2=substr($nombre_emprtrans,34);

            //$nombre_emprtrans=substr($nombre_emprtrans,0,34);

            $temp = dividir_texto($nombre_emprtrans, 34);

            $nombre_emprtrans = $temp['texto1'];

            $nombre_emprtrans2 = $temp['texto2'];

        }


        /* Cabecera */

        //prep_pdf();

        $this->cezpdf = new Cezpdf('a4');

        //$this->cezpdf = new backgroundPDF('a4', 'portrait', 'image', array('img'=>'images/img_db/instrume_fondo_guiarem.jpg')); 


        $this->cezpdf->ezText('', '', array("leading" => 135));


        /* Datos de Cabecera */


        $this->cezpdf->ezText(utf8_decode_seguro($punto_partida), 9, array("left" => 53));

        $this->cezpdf->ezText(utf8_decode_seguro($punto_llegada), 9, array("leading" => 0, "left" => 338));

        $this->cezpdf->ezText(utf8_decode_seguro(substr($punto_partida2, 0, 52)), 9, array("leading" => 15, "left" => -12));

        $this->cezpdf->ezText(substr(utf8_decode_seguro($punto_llegada2), 0, 50), 9, array("leading" => 0, "left" => 270));

        $this->cezpdf->ezText($fecha_traslado, 9, array("leading" => 19, "left" => 93));

        $this->cezpdf->ezText(utf8_decode_seguro($razon_social), 9, array("leading" => -3, "left" => 430));

        $this->cezpdf->ezText(utf8_decode_seguro($razon_social2), 9, array("leading" => 11, "left" => 270));

        $this->cezpdf->ezText($ruc, 9, array("leading" => 12, "left" => 335));


        $this->cezpdf->ezText($marca . ($placa != '' ? ' / ' . $placa : ''), 9, array("leading" => 34, "left" => 87));

        $this->cezpdf->ezText(utf8_decode_seguro($nombre_emprtrans), 9, array("leading" => 0, "left" => 360));

        $this->cezpdf->ezText($certificado, 9, array("leading" => 14, "left" => 112));

        $this->cezpdf->ezText(substr(utf8_decode_seguro($nombre_emprtrans2), 0, 56), 9, array("leading" => 0, "left" => 270));

        $this->cezpdf->ezText($licencia, 9, array("leading" => 16, "left" => 115));

        $this->cezpdf->ezText($ruc_emprtrans, 9, array("leading" => 0, "left" => 340));


        $this->cezpdf->ezText('', '', array("leading" => 32));


        /* Detalle */

        $db_data = array();

        if (count($datos_detalle_guiarem) > 0) {

            foreach ($datos_detalle_guiarem as $indice => $valor) {

                $producto = $valor->PRODCTOP_Codigo;

                $marca_prod = $this->producto_model->obtener_marca_modelo_por_producto($producto);

                $unidad = $valor->UNDMED_Codigo;

                $costo = $valor->GUIAREMDETC_Costo;

                $venta = $valor->GUIAREMDETC_Venta;

                $peso = $valor->GUIAREMDETC_Peso;

                $descri = $valor->GUIAREMDETC_Descripcion;

                $datos_producto = $this->producto_model->obtener_producto($producto);

                $datos_unidad = $this->unidadmedida_model->obtener($unidad);

                $prod_nombre = $datos_producto[0]->PROD_Nombre;

                $prod_codigo = $datos_producto[0]->PROD_CodigoUsuario;

                $prod_unidad = $datos_unidad[0]->UNDMED_Simbolo;

                $prod_cantidad = $valor->GUIAREMDETC_Cantidad;

                $db_data[] = array(

                    'col0' => $prod_codigo,

                    'col1' => utf8_decode_seguro(substr($descri, 0, 45)) . " / " . $marca_prod[0]->MARCC_Descripcion . " / " . $marca_prod[0]->PROD_Modelo,

                    'col2' => $prod_cantidad,

                    'col3' => $prod_unidad,

                    'col4' => ''

                );

            }

        }

        $this->cezpdf->ezTable($db_data, '', '', array(

            'showLines' => 0,

            'shaded' => 0,

            'showHeadings' => 0,

            'xPos' => 'center',

            'fontSize' => '9',

            'cols' => array(

                'col0' => array('width' => 75, 'justification' => 'center'),

                'col1' => array('width' => 275, 'justification' => 'left'),

                'col2' => array('width' => 45, 'justification' => 'center'),

                'col3' => array('width' => 90, 'justification' => 'center'),

                'col4' => array('width' => 80, 'justification' => 'center')

            )

        ));

        if ($nombre_tipodoc != '')

            $this->cezpdf->addText(200, 220, 9, strtoupper($nombre_tipodoc) . ' / ' . $numero_ref);


        $posx = 0;

        $posy = 0;

        switch ($tipo_movimiento) {

            case 1:
                $posx = 110;

                $posy = 180;

                break;

            case 2:
                $posx = 110;

                $posy = 165;

                break;

            case 3:
                $posx = 110;

                $posy = 150;

                break;

            case 4:
                $posx = 250;

                $posy = 180;

                break;

            case 5:
                $posx = 250;

                $posy = 165;

                break;

            case 6:
                $posx = 250;

                $posy = 150;

                break;

            case 7:
                $posx = 420;

                $posy = 180;

                break;

            case 8:
                $posx = 420;

                $posy = 165;

                break;

            case 9:
                $posx = 420;

                $posy = 150;

                break;

            case 10:
                $posx = 530;

                $posy = 180;

                break;

            case 11:
                $posx = 530;

                $posy = 165;

                break;

            case 12:
                $posx = 530;

                $posy = 150;

                break;

        }

        if ($posx != 0 && $posy != 0)

            $this->cezpdf->addText($posx, $posy, 14, 'x');

        else

            $this->cezpdf->addText(75, 150, 9, $otro_motivo);


        $cabecera = array('Content-Type' => 'application/pdf', 'Content-Disposition' => 'nama_file.pdf', 'Expires' => '0', 'Pragma' => 'cache', 'Cache-Control' => 'private');

        $this->cezpdf->ezStream($cabecera);

    }


    public function guiarem_ver_pdf_formato4($codigo, $tipo_oper)
    {

        //$this->load->library('cezpdf');

        //$this->load->helper('pdf_helper');

        $datos_guiarem = $this->guiarem_model->obtener($codigo);

        $datos_detalle_guiarem = $this->guiaremdetalle_model->obtener2($codigo);

        $tipo_movimiento = $datos_guiarem[0]->TIPOMOVP_Codigo;

        $referencia = $datos_guiarem[0]->DOCUP_Codigo;

        $cliente = $datos_guiarem[0]->CLIP_Codigo;

        $numero_ref = $datos_guiarem[0]->GUIAREMC_NumeroRef;

        $serie = $datos_guiarem[0]->GUIAREMC_Serie;

        $numero = $datos_guiarem[0]->GUIAREMC_Numero;

        $fecha_traslado = mysql_to_human($datos_guiarem[0]->GUIAREMC_FechaTraslado);

        $observacion = $datos_guiarem[0]->GUIAREMC_Observacion;

        $marca = $datos_guiarem[0]->GUIAREMC_Marca;

        $placa = $datos_guiarem[0]->GUIAREMC_Placa;

        $registro_mtc = $datos_guiarem[0]->GUIAREMC_RegistroMTC;

        $certificado = $datos_guiarem[0]->GUIAREMC_Certificado;

        $licencia = $datos_guiarem[0]->GUIAREMC_Licencia;

        $nombre_conductor = $datos_guiarem[0]->GUIAREMC_NombreConductor;

        $punto_partida = $datos_guiarem[0]->GUIAREMC_PuntoPartida;

        $punto_llegada = $datos_guiarem[0]->GUIAREMC_PuntoLlegada;

        $empresa_transporte = $datos_guiarem[0]->EMPRP_Codigo;

        $fecha = mysql_to_human($datos_guiarem[0]->GUIAREMC_Fecha);

        $otro_motivo = $datos_guiarem[0]->GUIAREMC_OtroMotivo;


        $nombre_emprtrans = "";

        $ruc_emprtrans = "";

        if ($empresa_transporte != '') {

            $datos_emprtrans = $this->empresa_model->obtener_datosEmpresa($empresa_transporte);

            if (count($datos_emprtrans) > 0) {

                $ruc_emprtrans = $datos_emprtrans[0]->EMPRC_Ruc;

                $nombre_emprtrans = $datos_emprtrans[0]->EMPRC_RazonSocial;

            }

        }


        $nombre_tipodoc = '';

        if ($referencia != '') {

            $datos_doc = $this->documento_model->obtener($referencia);

            $nombre_tipodoc = $datos_doc[0]->DOCUC_Descripcion;

        }


        /* Datos del cliente */

        $datos_cliente = $this->cliente_model->obtener($cliente);

        $razon_social = utf8_decode($datos_cliente->nombre);

        $tipo_doc = ($datos_cliente->tipo == '0' ? 'D.N.1' : 'R.U.C.');

        $ruc = $datos_cliente->ruc;

        $dni = $datos_cliente->dni;

        $distrito_cliente = $datos_cliente->distrito;

        $provincia_cliente = $datos_cliente->provincia;

        $departamento_cliente = $datos_cliente->departamento;


        /* Cabecera */

        //prep_pdf();


        $this->cezpdf = new Cezpdf('a4');

        $this->cezpdf->selectFont('system/application/libraries/fonts/Helvetica-Bold.afm');


        $this->cezpdf->ezText('', '', array("leading" => 84));


        $this->cezpdf->ezText($fecha, 10, array("leading" => 19, 'left' => 50));

        $this->cezpdf->ezText($fecha_traslado, 10, array("leading" => 0, 'left' => 250));

        $this->cezpdf->ezText(utf8_decode_seguro($punto_partida), 10, array("leading" => 15, 'left' => 50));

        $this->cezpdf->ezText(utf8_decode_seguro($punto_llegada), 10, array("leading" => 23, 'left' => 50));


        $this->cezpdf->ezText(utf8_decode_seguro($razon_social), 10, array("leading" => 15, 'left' => 50));

        //$this->cezpdf->ezText(utf8_decode_seguro($ruc),11, array("leading"=>0,'left'=>465));

        $this->cezpdf->addText(497, 652, 12, $ruc);


        if ($nombre_emprtrans != '') {

            $this->cezpdf->ezText(utf8_decode_seguro($nombre_emprtrans), 10, array("leading" => 20, 'left' => 50));

            $this->cezpdf->ezText($ruc_emprtrans, 11, array("leading" => 0, 'left' => 465));

        } else

            $this->cezpdf->ezText(utf8_decode_seguro($nombre_conductor), 10, array("leading" => 25, 'left' => 50));


        $this->cezpdf->ezText(utf8_decode_seguro($marca . ($placa != '' ? ' / ' . $placa : '')), 10, array("leading" => 13, 'left' => 50));

        $this->cezpdf->ezText(utf8_decode_seguro($certificado), 10, array("leading" => 0, 'left' => 290));

        $this->cezpdf->ezText(utf8_decode_seguro($licencia), 10, array("leading" => 0, 'left' => 480));


        $this->cezpdf->ezText('', '', array("leading" => 35));


        /* Detalle */

        $db_data = array();

        if (count($datos_detalle_guiarem) > 0) {

            foreach ($datos_detalle_guiarem as $indice => $valor) {

                $producto = $valor->PRODCTOP_Codigo;

                $marca_prod = $this->producto_model->obtener_marca_modelo_por_producto($producto);

                $unidad = $valor->UNDMED_Codigo;

                $costo = $valor->GUIAREMDETC_Costo;

                $venta = $valor->GUIAREMDETC_Venta;

                $peso = $valor->GUIAREMDETC_Peso;

                $descri = $valor->GUIAREMDETC_Descripcion;

                $datos_producto = $this->producto_model->obtener_producto($producto);

                $datos_unidad = $this->unidadmedida_model->obtener($unidad);

                $prod_nombre = $datos_producto[0]->PROD_Nombre;

                $prod_codigo = $datos_producto[0]->PROD_CodigoInterno;

                $prod_unidad = $datos_unidad[0]->UNDMED_Simbolo;

                $prod_cantidad = $valor->GUIAREMDETC_Cantidad;

                $db_data[] = array(

                    'col0' => $prod_codigo,

                    'col1' => utf8_decode_seguro(substr($descri, 0, 45)) . " / " . $marca_prod[0]->MARCC_Descripcion . " / " . $marca_prod[0]->PROD_Modelo,

                    'col2' => $prod_unidad,

                    'col3' => $prod_cantidad,

                    'col4' => ''

                );

            }

        }

        $this->cezpdf->ezTable($db_data, '', '', array(

            'showLines' => 0,

            'shaded' => 0,

            'showHeadings' => 0,

            'xPos' => 'center',

            'fontSize' => 10,

            'cols' => array(

                'col0' => array('width' => 70, 'justification' => 'left'),

                'col1' => array('width' => 345, 'justification' => 'left'),

                'col2' => array('width' => 80, 'justification' => 'center'),

                'col3' => array('width' => 65, 'justification' => 'center'),

                'col4' => array('width' => 25, 'justification' => 'center'),

            )

        ));


        //$this->cezpdf->addText(0,80,9, $nombre_tipodoc.' '.$numero_ref);

        $this->cezpdf->addText(0, 87, 10, $nombre_tipodoc);

        $this->cezpdf->addText(0, 76, 11, $numero_ref);


        /* $posx=0;

          $posy=0;

          switch($tipo_movimiento){

          case 1:  $posx=307; $posy=104; break;

          case 2:  $posx=307; $posy=95; break;

          case 3:  $posx=307; $posy=86; break;

          case 4:  $posx=307; $posy=76; break;

          case 5:  $posx=307; $posy=67; break;

          case 6:  $posx=307; $posy=57; break;

          case 7:  $posx=307; $posy=48; break;

          case 8:  $posx=307; $posy=39; break;

          case 9:  $posx=420; $posy=104; break;

          case 10:  $posx=420; $posy=95; break;

          case 11:  $posx=420; $posy=86; break;

          case 12:  $posx=420; $posy=76; break;

          case 13:  $posx=420; $posy=67; break;

          case 14:  $posx=420; $posy=57; break;

          case 15:  $posx=420; $posy=48; break;

          case 16:  $posx=420; $posy=39; break;

          }

          $this->cezpdf->addText($posx,$posy,10,'x');

          if($tipo_movimiento==16)

          $this->cezpdf->addText(331,39,7,utf8_decode_seguro(substr($otro_motivo,0,19)));

         */

        $this->cezpdf->addText(415, 47, 15, $tipo_movimiento);


        $cabecera = array('Content-Type' => 'application/pdf', 'Content-Disposition' => 'nama_file.pdf', 'Expires' => '0', 'Pragma' => 'cache', 'Cache-Control' => 'private');

        $this->cezpdf->ezStream($cabecera);

    }


    public function guiarem_ver_pdf_conmenbrete_formato1($codigo, $tipo_oper, $img)
    {
//**************************************************************************   

        $this->load->library('cezpdf');
        $this->load->helper('pdf_helper');

        if ($_SESSION['empresa'] == '3') {
//3 = dragon yuan
//2 = dragoket


            $hoy = date("Y-m-d");

            $datos_guiarem = $this->guiarem_model->obtener($codigo);
            $tipo_movimiento = $datos_guiarem[0]->TIPOMOVP_Codigo;
            $otro_motivo = $datos_guiarem[0]->GUIAREMC_OtroMotivo;
            $empresa_transporte = $datos_guiarem[0]->EMPRP_Codigo;
            $almacen = $datos_guiarem[0]->ALMAP_Codigo;
            $usuario = $datos_guiarem[0]->USUA_Codigo;
            $referencia = $datos_guiarem[0]->DOCUP_Codigo;
            $cliente = $datos_guiarem[0]->CLIP_Codigo;
            $proveedor = $datos_guiarem[0]->PROVP_Codigo;
            $recepciona_nombres = $datos_guiarem[0]->GUIAREMC_PersReceNombre;
            $recepciona_dni = $datos_guiarem[0]->GUIAREMC_PersReceDNI;
            $numero_ref = $datos_guiarem[0]->GUIAREMC_NumeroRef;
            $numero_ocompra = $datos_guiarem[0]->GUIAREMC_OCompra;
            $serie = $datos_guiarem[0]->GUIAREMC_Serie;
            $numero = $datos_guiarem[0]->GUIAREMC_Numero;
            $codigo_usuario = $datos_guiarem[0]->GUIAREMC_CodigoUsuario;
            $fecha_traslado = $datos_guiarem[0]->GUIAREMC_FechaTraslado;
            $observacion = $datos_guiarem[0]->GUIAREMC_Observacion;
            $placa = $datos_guiarem[0]->GUIAREMC_Placa;
            $marca = $datos_guiarem[0]->GUIAREMC_Marca;
            $registro_mtc = $datos_guiarem[0]->GUIAREMC_RegistroMTC;
            $certificado = $datos_guiarem[0]->GUIAREMC_Certificado;
            $licencia = $datos_guiarem[0]->GUIAREMC_Licencia;
            $nombre_conductor = $datos_guiarem[0]->GUIAREMC_NombreConductor;
            $ocompra = $datos_guiarem[0]->OCOMP_Codigo;
            $estado = $datos_guiarem[0]->GUIAREMC_FlagEstado;


            if ($estado == 2) {
                $filter = new stdClass();
                $filter->GUIAREMC_FlagEstado = 1;
                $this->guiarem_model->modificar($codigo, $filter);


                $detalle = $this->guiaremdetalle_model->obtener2($codigo);
                $detalle_guiarem = array();
                if (count($detalle) > 0) {
                    foreach ($detalle as $indice => $valor) {
                        $detacodi = $valor->GUIAREMDETP_Codigo;
                        $producto = $valor->PRODCTOP_Codigo;
                        $unidad = $valor->UNDMED_Codigo;
                        $cantidad = $valor->GUIAREMDETC_Cantidad;
                        $pu = $valor->GUIAREMDETC_Pu;
                        $subtotal = $valor->GUIAREMDETC_Subtotal;
                        $igv = $valor->GUIAREMDETC_Igv;
                        $descuento = $valor->GUIAREMDETC_Descuento;
                        $total = $valor->GUIAREMDETC_Total;
                        $pu_conigv = $valor->GUIAREMDETC_Pu_ConIgv;
                        $costo = $valor->GUIAREMDETC_Costo;
                        $venta = $valor->GUIAREMDETC_Venta;
                        $peso = $valor->GUIAREMDETC_Peso;
                        $GenInd = $valor->GUIAREMDETC_GenInd;
                        $descri = str_replace('"', "''", $valor->GUIAREMDETC_Descripcion);
                        $datos_producto = $this->producto_model->obtener_producto($producto);
                        $datos_unidad = $this->unidadmedida_model->obtener($unidad);
                        $nombre_producto = $datos_producto[0]->PROD_Nombre;
                        $codigo_interno = $datos_producto[0]->PROD_CodigoUsuario;

                        if ($datos_unidad) {

                            $nombre_unidad = $datos_unidad[0]->UNDMED_Descripcion;

                        } else {

                            $nombre_unidad = "SERV";

                        }

                    }

                }

            }


            if ($tipo_oper == "V") {
                $datos_guiarem = $this->guiarem_model->obtener($codigo);
                $datos_detalle_guiarem = $this->guiaremdetalle_model->obtener2($codigo);
                $tipo_movimiento = $datos_guiarem[0]->TIPOMOVP_Codigo;
                $referencia = $datos_guiarem[0]->DOCUP_Codigo;
                $guiasap = $datos_guiarem[0]->GUIASAP_Codigo;
                $guiainp = $datos_guiarem[0]->GUIAINP_Codigo;
                $motivo_trans = $datos_guiarem[0]->TIPOMOVP_Codigo;
                $cliente = $datos_guiarem[0]->CLIP_Codigo;
                $proveedor = $datos_guiarem[0]->PROVP_Codigo;
                $numero_ref = $datos_guiarem[0]->GUIAREMC_NumeroRef;
                $numero_ocompra = $datos_guiarem[0]->GUIAREMC_OCompra;
                $serie = $datos_guiarem[0]->GUIAREMC_Serie;
                $numero = $datos_guiarem[0]->GUIAREMC_Numero;
                $fecha_traslado = mysql_to_human($datos_guiarem[0]->GUIAREMC_FechaTraslado);
                $observacion = $datos_guiarem[0]->GUIAREMC_Observacion;
                $marca = $datos_guiarem[0]->GUIAREMC_Marca;
                $placa = $datos_guiarem[0]->GUIAREMC_Placa;
                $registro_mtc = $datos_guiarem[0]->GUIAREMC_RegistroMTC;
                $certificado = $datos_guiarem[0]->GUIAREMC_Certificado;
                $licencia = $datos_guiarem[0]->GUIAREMC_Licencia;
                $nombre_conductor = $datos_guiarem[0]->GUIAREMC_NombreConductor;
                $punto_partida = $datos_guiarem[0]->GUIAREMC_PuntoPartida;
                $arr_punt_part = explode('/', $punto_partida);
                $punto_llegada = $datos_guiarem[0]->GUIAREMC_PuntoLlegada;
                $arr_punt_lleg = explode('/', $punto_llegada);
                $empresa_transporte = $datos_guiarem[0]->EMPRP_Codigo;
                $fecha = mysql_to_human($datos_guiarem[0]->GUIAREMC_Fecha);
                $otro_motivo = $datos_guiarem[0]->GUIAREMC_OtroMotivo;
                $total = $datos_guiarem[0]->GUIAREMC_total;
                $datos_moneda = $this->moneda_model->obtener($datos_guiarem[0]->MONED_Codigo);
                $moneda_nombre = (count($datos_moneda) > 0 ? $datos_moneda[0]->MONED_Descripcion : 'NUEVOS SOLES');
                $moneda_simbolo = (count($datos_moneda) > 0 ? $datos_moneda[0]->MONED_Simbolo : 'S/.');
                $nombre_emprtrans = "";
                $ruc_emprtrans = "";
                if ($empresa_transporte != '') {
                    $datos_emprtrans = $this->empresa_model->obtener_datosEmpresa($empresa_transporte);
                    if (count($datos_emprtrans) > 0) {
                        $ruc_emprtrans = $datos_emprtrans[0]->EMPRC_Ruc;
                        $nombre_emprtrans = $datos_emprtrans[0]->EMPRC_RazonSocial;
                    }
                }

                $mot = "";

                switch ($motivo_trans) {

                    case 1:

                        $mot = 1;

                        break;

                    case 2:

                        $mot = 0;

                        break;

                    case 3:

                        $mot = 2;

                        break;

                    case 4:

                        $mot = 4;

                        break;

                    case 5:

                        $mot = 5;

                        break;

                    case 6:

                        $mot = 6;

                        break;

                    case 7:

                        $mot = 9;

                        break;

                    case 8:

                        $mot = 13;

                        break;

                }

                $nombre_tipodoc = '';

                if ($referencia != '') {
                    $datos_doc = $this->documento_model->obtener($referencia);
                    $nombre_tipodoc = $datos_doc[0]->DOCUC_Descripcion;

                }


                /* Datos del cliente */

                $datos_cliente = $this->cliente_model->obtener($cliente);
                $razon_social = utf8_decode($datos_cliente->nombre);
                $tipo_doc = ($datos_cliente->tipo == '0' ? 'D.N.1' : 'R.U.C.');
                $ruc = $datos_cliente->ruc;
                $dni = $datos_cliente->dni;
                $distrito_cliente = $datos_cliente->distrito;
                $provincia_cliente = $datos_cliente->provincia;
                $departamento_cliente = $datos_cliente->departamento;

                $nombre_emprtrans2 = '';
                if (strlen($nombre_emprtrans) > 29) {
                    $nombre_emprtrans2 = substr($nombre_emprtrans, 29);
                    $nombre_emprtrans = substr($nombre_emprtrans, 0, 29);
                }

                $otro_motivo2 = '';

                if (strlen($otro_motivo) > 18) {
                    $otro_motivo2 = substr($otro_motivo, 18);
                    $otro_motivo = substr($otro_motivo, 0, 18);
                }

                if ($img == 1) {

                   //$notimg = "guia_remision.jpg";

                } else {

                    //$notimg = "guia_remision.jpg";

                }


                if ($_SESSION['compania'] == '3') {
                    //dragon yuan mafgdalena        

                    $this->cezpdf = new backgroundPDF('a4', 'portrait', 'image', array('img' => 'images/img_db/' . $notimg));
                    $posiciongeneralx = 0;
                    $posiciongeneraly = 2;
                    $posicionX = 0;
                    $posicionY = -8;
                    $this->cezpdf->addText(88, '', 9, '');

                    if ($img == 0) {
                        /* INICIO SERIE Y NUMERO DE GUIA DE REMISION */
                        $this->cezpdf->addText($posicionX + 410, $posicionY + 720, 18, $serie);
                        $this->cezpdf->addText($posicionX + 454, $posicionY + 720, 18, $numero);
                        /* FIN SERIE Y NUMERO DE GUIA DE REMISION */
                    } else {

                        $this->cezpdf->addText($posicionX + 436, $posicionY + 745, 18, "");
                        $this->cezpdf->addText($posicionX + 480, $posicionY + 745, 18, "");

                    }

                    //FECHA DE EMISION
                    $this->cezpdf->addText($posicionX + 89 + $posiciongeneralx, $posicionY + 743 + $posiciongeneraly, 9, substr($fecha , 0, 2));
                    $this->cezpdf->addText($posicionX + 115 + $posiciongeneralx, $posicionY + 743 + $posiciongeneraly, 9, substr($fecha, 3, 2));
                    $this->cezpdf->addText($posicionX + 150 + $posiciongeneralx, $posicionY + 743 + $posiciongeneraly, 9, substr($fecha, 8, 4));
                    //FECHA DE TRASLADO
                    //$this->cezpdf->addText($posicionX + 260, $posicionY + 673, 9, $fecha_traslado);

                    //FECHA DE TRASLADO
                    $this->cezpdf->addText($posicionX + 259 + $posiciongeneralx, $posicionY + 743 + $posiciongeneraly, 9, substr($fecha_traslado, 0, 2));
                    $this->cezpdf->addText($posicionX + 282 + $posiciongeneralx, $posicionY + 743 + $posiciongeneraly, 9, substr($fecha_traslado, 3, 2));
                    $this->cezpdf->addText($posicionX + 316 + $posiciongeneralx, $posicionY + 743 + $posiciongeneraly, 9, substr($fecha_traslado, 8, 4));


                    //DIRECCION DE PARTIDA
                    $this->cezpdf->addText($posicionX + 33 + $posiciongeneralx, $posicionY + 716 + $posiciongeneraly, 8, utf8_decode_seguro(substr($arr_punt_part[0], 0, 70)));


                    // DIRECCION DE DESTINO
                    $direccion_destino = substr($arr_punt_lleg[0], 0, 70);
                    $this->cezpdf->addText($posicionX + 33 + $posiciongeneralx, $posicionY + 692 + $posiciongeneraly, 8, utf8_decode_seguro(isset($direccion_destino) ? $direccion_destino : ''));
                    // NOMBRE DE EMP. TRANSPORTISTA
                    $this->cezpdf->addText($posicionX + 90 + $posiciongeneralx, $posicionY + 471 + $posiciongeneraly, 8, utf8_decode_seguro($nombre_emprtrans));

//            $this->cezpdf->addText($posicionX + 266, $posicionY + 631, 6, utf8_decode_seguro($nombre_conductor));
                    // RUC DE EMP. TRANSPORTISTA
                    $this->cezpdf->addText($posicionX + 330 + $posiciongeneralx, $posicionY + 471 + $posiciongeneraly, 8, $ruc_emprtrans);
                    // MARCA
                    $this->cezpdf->addText($posicionX + 410 + $posiciongeneralx, $posicionY + 682 + $posiciongeneraly, 7, $marca);
                    // PLACA
                    $this->cezpdf->addText($posicionX + 470 + $posiciongeneralx, $posicionY + 682 + $posiciongeneraly, 7, $placa);
                    // CERTIFICADO
                    $this->cezpdf->addText($posicionX + 410 + $posiciongeneralx, $posicionY + 670 + $posiciongeneraly, 7, $certificado);
                    // LICENCIA
                    $this->cezpdf->addText($posicionX + 410 + $posiciongeneralx, $posicionY + 658 + $posiciongeneraly, 7, $licencia);
                    // RAZON SOCIAL DEL DESTINATARIO
                    $this->cezpdf->addText($posicionX + 73 + $posiciongeneralx, $posicionY + 665 + $posiciongeneraly, 8, $razon_social);

//            $this->cezpdf->addText($posicionX + 32, $posicionY + 80, 8, $nombre_conductor);
                    // RUC DEL DESTINATARIO
                    $this->cezpdf->addText($posicionX + 110 + $posiciongeneralx, $posicionY + 652 + $posiciongeneraly, 8, $ruc);
                    $this->cezpdf->addText($posicionX + 262 + $posiciongeneralx, $posicionY + 652 + $posiciongeneraly, 8, $dni);
                    // $this->cezpdf->addText($posicionX + 68, $posicionY + 616, 9, "x");

                    /* Detalle */
                    $db_data = array();
                    if (count($datos_detalle_guiarem) > 0) {
                        foreach ($datos_detalle_guiarem as $indice => $valor) {
                            $producto = $valor->PRODCTOP_Codigo;
                            $unidad = $valor->UNDMED_Codigo;
                            $costo = $valor->GUIAREMDETC_Costo;
                            $venta = $valor->GUIAREMDETC_Venta;
                            $peso = $valor->GUIAREMDETC_Peso;
                            $descri = $valor->GUIAREMDETC_Descripcion;
                            //$descri = str_replace('\\', '', $descri);
                            $datos_producto = $this->producto_model->obtener_producto($producto);
                            $datos_unidad = $this->unidadmedida_model->obtener($unidad);
                            $prod_cod = $datos_producto[0]->PROD_Codigo;
                            $prod_nombre = $datos_producto[0]->PROD_Nombre;
                            $prod_codigo = $datos_producto[0]->PROD_CodigoUsuario;
                            $prod_unidad = $datos_unidad[0]->UNDMED_Descripcion;
                            $prod_cantidad = $valor->GUIAREMDETC_Cantidad;
                            //------------------------------------------------------------------------------        

                            $array_producto = explode("/", $descri);

                            ///NOMBRE DE LOS PRODUCTO
                            $this->cezpdf->addText($posicionX + 40 + $posiciongeneralx, $posicionY + 616 + $posiciongeneraly, 8, utf8_decode_seguro($descri));   //$array_producto[0]
                            ///PRODUCTO UNITARIO
                            $this->cezpdf->addText($posicionX + 375 + $posiciongeneralx, $posicionY + 616 + $posiciongeneraly, 6, utf8_decode_seguro($prod_unidad));
                            ///PRODUCTO CANTIDAD
                            $this->cezpdf->addTextWrap($posicionX + 420 + $posiciongeneralx, $posicionY + 616 + $posiciongeneraly, 20, 8, $prod_cantidad, 'right');


                            $ser = "";

                            $c = 0;


                            $posicionX = 0;


                            $posicionY -= 19;

                        }

                    }

                    $posicionY = 0;

                    $this->cezpdf->addText(600 + $posiciongeneralx, 100 + $posiciongeneraly, 9, utf8_decode_seguro($nombre_emprtrans2 != '' ? $nombre_emprtrans . ' k' : $nombre_emprtrans . ' L'));


                    $posx = 0;

                    $posy = 0;

                    switch ($tipo_movimiento) {

                        case 1:
                            $posx = 37;
                            $posy = 428;
                            break;

                        case 2:
                            $posx = 37;
                            $posy = 419;
                            break;

                        case 3:
                            $posx = 37;
                            $posy = 411;
                            break;

                        case 4:
                            $posx = 37;
                            $posy = 404;
                            break;
                        /* es nuéstro caso */
                        case 5:
                            $posx = 149;
                            $posy = 437;
                            break;

                        case 6:
                            $posx = 149;
                            $posy = 429;
                            break;

                        case 7:
                            $posx = 149;
                            $posy = 414;
                            break;

                        case 8:
                            $posx = 149;
                            $posy = 405;
                            break;

                        case 9:
                            $posx = 261;
                            $posy = 436;
                            break;

                        case 10:
                            $posx = 262;
                            $posy = 421;
                            break;

                        case 11:
                            $posx = 262;
                            $posy = 413;
                            break;

                        case 12:
                            $posx = 262;
                            $posy = 405;
                            break;

                        case 13:
                            $posx = 352;
                            $posy = 435;
                            break;

                    }

                    $this->cezpdf->addText($posx + $posiciongeneralx, $posy + $posiciongeneraly - 10, 14, 'x');


                    $this->cezpdf->ezText(' ', 9, array("leading" => 1200, "left" => 0));
                    $this->cezpdf->addText($posicionX + 90, $posicionY + 705, 8, 'ESTA LISTA CORRESPONDE A');
                    $this->cezpdf->addText($posicionX + 90, $posicionY + 685, 8, 'FACTURA');
                    $this->cezpdf->addText($posicionX + 90, $posicionY + 665, 8, 'BOLETA');
                    $this->cezpdf->addText($posicionX + 90, $posicionY + 645, 8, 'GUIA DE REMISION');
                    $this->cezpdf->addText($posicionX + 250, $posicionY + 645, 8, $serie);


                    $this->cezpdf->addText($posicionX + 275, $posicionY + 585, 8, 'LISTA DE IMEIS');

                    $valortotal = strlen($observacion);
                    // strlen se obtiene la longitud de caracteres
                    $exacta = round($valortotal / 96);
                    // obtiene el numero entero de la operacion
                    for ($i = 0; $i < $exacta; $i++) {
                        $this->cezpdf->addText($posicionX + 100, $posicionY + 560 - ($i * 13), 8, substr($observacion, $i * 96, 96));
                    }


                } else {
                    //dragon yuan andahuaylas


                    $this->cezpdf = new backgroundPDF('a4', 'portrait', 'image', array('img' => 'images/img_db/' . $notimg));
                    $posicionX = 7;
                    $posicionY = -5;
                    $this->cezpdf->addText(88, '', 9, '');

                    if ($img == 0) {
                        /* INICIO SERIE Y NUMERO DE GUIA DE REMISION */
                        $this->cezpdf->addText($posicionX + 410, $posicionY + 720, 18, $serie);
                        $this->cezpdf->addText($posicionX + 454, $posicionY + 720, 18, $numero);
                        /* FIN SERIE Y NUMERO DE GUIA DE REMISION */
                    } else {

                        $this->cezpdf->addText($posicionX + 436, $posicionY + 745, 18, "");

                        $this->cezpdf->addText($posicionX + 480, $posicionY + 745, 18, "");

                    }

                    //FECHA DE EMISION
                    $this->cezpdf->addText($posicionX + 89, $posicionY + 741, 9, substr($fecha, 0, 2));
                    $this->cezpdf->addText($posicionX + 115, $posicionY + 741, 9, substr($fecha, 3, 2));
                    $this->cezpdf->addText($posicionX + 150, $posicionY + 741, 9, substr($fecha, 8, 4));
                    //FECHA DE TRASLADO
                    //$this->cezpdf->addText($posicionX + 260, $posicionY + 673, 9, $fecha_traslado);

                    //FECHA DE TRASLADO
                    $this->cezpdf->addText($posicionX + 259, $posicionY + 741, 9, substr($fecha_traslado, 0, 2));
                    $this->cezpdf->addText($posicionX + 282, $posicionY + 741, 9, substr($fecha_traslado, 3, 2));
                    $this->cezpdf->addText($posicionX + 318, $posicionY + 741, 9, substr($fecha_traslado, 8, 4));


                    //DIRECCION DE PARTIDA
                    $this->cezpdf->addText($posicionX + 33, $posicionY + 716, 8, utf8_decode_seguro(substr($arr_punt_part[0], 0, 70)));

//

//        $this->cezpdf->addText($posicionX + 62, $posicionY + 663, 8, utf8_decode_seguro(isset($arr_punt_part[1]) ? $arr_punt_part[1] . '321321321' : '9999999999999999'));

//

                    // DIRECCION DE DESTINO
                    $direccion_destino = substr($arr_punt_lleg[0], 0, 70);
                    $this->cezpdf->addText($posicionX + 33, $posicionY + 692, 8, utf8_decode_seguro(isset($direccion_destino) ? $direccion_destino : ''));

                    // RAZON SOCIAL DEL DESTINATARIO
                    $this->cezpdf->addText($posicionX + 73, $posicionY + 665, 8, $razon_social);

//            $this->cezpdf->addText($posicionX + 32, $posicionY + 80, 8, $nombre_conductor);
                    // RUC DEL DESTINATARIO
                    $this->cezpdf->addText($posicionX + 110, $posicionY + 651, 8, $ruc);
                    $this->cezpdf->addText($posicionX + 262, $posicionY + 651, 8, $dni);
                    // $this->cezpdf->addText($posicionX + 68, $posicionY + 616, 9, "x");

                    /* Detalle */
                    $db_data = array();
                    if (count($datos_detalle_guiarem) > 0) {
                        foreach ($datos_detalle_guiarem as $indice => $valor) {
                            $producto = $valor->PRODCTOP_Codigo;
                            $unidad = $valor->UNDMED_Codigo;
                            $costo = $valor->GUIAREMDETC_Costo;
                            $venta = $valor->GUIAREMDETC_Venta;
                            $peso = $valor->GUIAREMDETC_Peso;
                            $descri = $valor->GUIAREMDETC_Descripcion;
                            // $descri = str_replace('\\', '', $descri);
                            $datos_producto = $this->producto_model->obtener_producto($producto);
                            $datos_unidad = $this->unidadmedida_model->obtener($unidad);
                            $prod_cod = $datos_producto[0]->PROD_Codigo;
                            $prod_nombre = $datos_producto[0]->PROD_Nombre;
                            $prod_codigo = $datos_producto[0]->PROD_CodigoUsuario;
                            $prod_unidad = $datos_unidad[0]->UNDMED_Descripcion;
                            $prod_cantidad = $valor->GUIAREMDETC_Cantidad;
                            //------------------------------------------------------------------------------        

                            $array_producto = explode("/", $descri);

                            $this->cezpdf->addText($posicionX + 40, $posicionY + 616, 8, utf8_decode_seguro($descri));
                            ///PRODUCTO UNITARIO
                            $this->cezpdf->addText($posicionX + 372, $posicionY + 616, 6, utf8_decode_seguro($prod_unidad));

                            //  $this->cezpdf->addText($posicionX + 85, $posicionY + 540, 9, $prod_unidad);
                            ///PRODUCTO CANTIDAD
                            $this->cezpdf->addTextWrap($posicionX + 430, $posicionY + 616, 20, 8, $prod_cantidad, 'right');


                            $ser = "";

                            $c = 0;


                            $posicionY -= 19;

                        }

                    }

                    $posicionY = 0;

                    $this->cezpdf->addText(600, 100, 9, utf8_decode_seguro($nombre_emprtrans2 != '' ? $nombre_emprtrans . ' k' : $nombre_emprtrans . ' L'));


                    $posx = 0;

                    $posy = 0;

                    switch ($tipo_movimiento) {

                        case 1:
                            $posx = 44;
                            $posy = 425;
                            break;

                        case 2:
                            $posx = 44;
                            $posy = 412;
                            break;

                        case 3:
                            $posx = 44;
                            $posy = 405;
                            break;

                        case 4:
                            $posx = 44;
                            $posy = 395;
                            break;
                        /* es nuéstro caso */
                        case 5:
                            $posx = 151;
                            $posy = 435;
                            break;

                        case 6:
                            $posx = 151;
                            $posy = 425;
                            break;

                        case 7:
                            $posx = 151;
                            $posy = 405;
                            break;

                        case 8:
                            $posx = 149;
                            $posy = 395;
                            break;

                        case 9:
                            $posx = 261;
                            $posy = 435;
                            break;

                        case 10:
                            $posx = 262;
                            $posy = 412;
                            break;

                        case 11:
                            $posx = 262;
                            $posy = 405;
                            break;

                        case 12:
                            $posx = 262;
                            $posy = 395;
                            break;

                        case 13:
                            $posx = 352;
                            $posy = 435;
                            break;

                    }

                    $this->cezpdf->addText($posx, $posy, 14, 'x');


                    $this->cezpdf->ezText(' ', 9, array("leading" => 1200, "left" => 0));
                    $this->cezpdf->addText($posicionX + 90, $posicionY + 705, 8, 'ESTA LISTA CORRESPONDE A');
                    $this->cezpdf->addText($posicionX + 90, $posicionY + 685, 8, 'FACTURA');
                    $this->cezpdf->addText($posicionX + 90, $posicionY + 665, 8, 'BOLETA');
                    $this->cezpdf->addText($posicionX + 90, $posicionY + 645, 8, 'GUIA DE REMISION');
                    $this->cezpdf->addText($posicionX + 250, $posicionY + 645, 8, $serie);


                    $this->cezpdf->addText($posicionX + 275, $posicionY + 585, 8, 'LISTA DE IMEIS');

                    $valortotal = strlen($observacion);
                    // strlen se obtiene la longitud de caracteres
                    $exacta = round($valortotal / 96);
                    // obtiene el numero entero de la operacion
                    for ($i = 0; $i < $exacta; $i++) {
                        $this->cezpdf->addText($posicionX + 100, $posicionY + 560 - ($i * 13), 8, substr($observacion, $i * 96, 96));
                    }


                }


            } else {
                $datos_guiarem = $this->guiarem_model->obtener($codigo);
                $datos_detalle_guiarem = $this->guiaremdetalle_model->obtener2($codigo);
                $tipo_movimiento = $datos_guiarem[0]->TIPOMOVP_Codigo;
                $referencia = $datos_guiarem[0]->DOCUP_Codigo;
                $guiasap = $datos_guiarem[0]->GUIASAP_Codigo;
                $guiainp = $datos_guiarem[0]->GUIAINP_Codigo;
                $motivo_trans = $datos_guiarem[0]->TIPOMOVP_Codigo;
                $cliente = $datos_guiarem[0]->CLIP_Codigo;
                $proveedor = $datos_guiarem[0]->PROVP_Codigo;
                $numero_ref = $datos_guiarem[0]->GUIAREMC_NumeroRef;
                $numero_ocompra = $datos_guiarem[0]->GUIAREMC_OCompra;
                $serie = $datos_guiarem[0]->GUIAREMC_Serie;
                $numero = $datos_guiarem[0]->GUIAREMC_Numero;
                $fecha_traslado = mysql_to_human($datos_guiarem[0]->GUIAREMC_FechaTraslado);
                $observacion = $datos_guiarem[0]->GUIAREMC_Observacion;
                $marca = $datos_guiarem[0]->GUIAREMC_Marca;
                $placa = $datos_guiarem[0]->GUIAREMC_Placa;
                $registro_mtc = $datos_guiarem[0]->GUIAREMC_RegistroMTC;
                $certificado = $datos_guiarem[0]->GUIAREMC_Certificado;
                $licencia = $datos_guiarem[0]->GUIAREMC_Licencia;
                $nombre_conductor = $datos_guiarem[0]->GUIAREMC_NombreConductor;
                $punto_partida = $datos_guiarem[0]->GUIAREMC_PuntoPartida;
                $arr_punt_part = explode('/', $punto_partida);
                $punto_llegada = $datos_guiarem[0]->GUIAREMC_PuntoLlegada;
                $arr_punt_lleg = explode('/', $punto_llegada);
                $empresa_transporte = $datos_guiarem[0]->EMPRP_Codigo;
                $fecha = mysql_to_human($datos_guiarem[0]->GUIAREMC_Fecha);
                $otro_motivo = $datos_guiarem[0]->GUIAREMC_OtroMotivo;
                $total = $datos_guiarem[0]->GUIAREMC_total;
                $nombre_emprtrans = "";
                $ruc_emprtrans = "";

                $datos_moneda = $this->moneda_model->obtener($datos_guiarem[0]->MONED_Codigo);
                $moneda_nombre = (count($datos_moneda) > 0 ? $datos_moneda[0]->MONED_Descripcion : 'NUEVOS SOLES');
                $moneda_simbolo = (count($datos_moneda) > 0 ? $datos_moneda[0]->MONED_Simbolo : 'S/.');


                if ($empresa_transporte != '') {

                    $datos_emprtrans = $this->empresa_model->obtener_datosEmpresa($empresa_transporte);

                    if (count($datos_emprtrans) > 0) {

                        $ruc_emprtrans = $datos_emprtrans[0]->EMPRC_Ruc;
                        $nombre_emprtrans = $datos_emprtrans[0]->EMPRC_RazonSocial;
                    }
                }

                $mot = "";

                switch ($motivo_trans) {

                    case 1:

                        $mot = 1;

                        break;

                    case 2:

                        $mot = 0;

                        break;

                    case 3:

                        $mot = 2;

                        break;

                    case 4:

                        $mot = 4;

                        break;

                    case 5:

                        $mot = 5;

                        break;

                    case 6:

                        $mot = 6;

                        break;

                    case 7:

                        $mot = 9;

                        break;

                    case 8:

                        $mot = 13;

                        break;

                }


                $nombre_tipodoc = '';

                if ($referencia != '') {

                    $datos_doc = $this->documento_model->obtener($referencia);

                    $nombre_tipodoc = $datos_doc[0]->DOCUC_Descripcion;

                }

                /* Datos del proveedor */


                $datos_proveedor = $this->proveedor_model->obtener_proveedor_info($proveedor);
                $razon_social = utf8_decode($datos_proveedor->nombre);
                $tipo_doc = ($datos_proveedor->tipo == '0' ? 'D.N.1' : 'R.U.C.');
                $ruc = $datos_proveedor->ruc;
                $distrito_cliente = $datos_proveedor->distrito;
                $provincia_cliente = $datos_proveedor->provincia;
                $departamento_cliente = $datos_proveedor->departamento;

                $razon_social2 = '';

                if (strlen($razon_social) > 26) {
                    $razon_social2 = substr($razon_social, 0);
                    $razon_social = substr($razon_social, 0);
                }

                $nombre_emprtrans2 = '';

                if (strlen($nombre_emprtrans) > 29) {
                    $nombre_emprtrans2 = substr($nombre_emprtrans, 29);
                    $nombre_emprtrans = substr($nombre_emprtrans, 0, 29);

                }

                $otro_motivo2 = '';

                if (strlen($otro_motivo) > 18) {
                    $otro_motivo2 = substr($otro_motivo, 18);
                    $otro_motivo = substr($otro_motivo, 0, 18);
                }

                if ($img == 1) {

                    $notimg = "";

                } else {

                    $notimg = "guia_remision_proveedor.jpg";

                }

                /* Cabecera */

                $this->cezpdf = new backgroundPDF('a4', 'portrait', 'image', array('img' => 'images/img_db/' . $notimg));

                $posicionX = 0;

                $posicionY = 0;

                $this->cezpdf->addText(88, '', 9, '');

                if ($img == 0) {

                    $this->cezpdf->addText($posicionX + 440, $posicionY + 723, 18, $serie);

                    $this->cezpdf->addText($posicionX + 480, $posicionY + 723, 18, $numero);

                } else {

                    $this->cezpdf->addText($posicionX + 436, $posicionY + 745, 18, "");

                    $this->cezpdf->addText($posicionX + 480, $posicionY + 745, 18, "");

                }


                $this->cezpdf->addText($posicionX + 35, $posicionY + 639, 9, $fecha);


                //direccion destino

                $direccion_destino = substr($arr_punt_lleg[0], 0, 37);

                $this->cezpdf->addText($posicionX + 75, $posicionY + 670, 8, utf8_decode_seguro(isset($direccion_destino) ? $direccion_destino : ''));


                /* Detalle */

                $db_data = array();

                if (count($datos_detalle_guiarem) > 0) {

                    foreach ($datos_detalle_guiarem as $indice => $valor) {

                        $producto = $valor->PRODCTOP_Codigo;
                        $unidad = $valor->UNDMED_Codigo;
                        $costo = $valor->GUIAREMDETC_Costo;
                        $venta = $valor->GUIAREMDETC_Venta;
                        $peso = $valor->GUIAREMDETC_Peso;
                        $descri = $valor->GUIAREMDETC_Descripcion;
                        $descri = str_replace('\\', '', $descri);
                        $datos_producto = $this->producto_model->obtener_producto($producto);
                        $datos_unidad = $this->unidadmedida_model->obtener($unidad);
                        $prod_cod = $datos_producto[0]->PROD_Codigo;
                        $prod_nombre = $datos_producto[0]->PROD_Nombre;
                        $prod_codigo = $datos_producto[0]->PROD_CodigoInterno;
                        $prod_unidad = $datos_unidad[0]->UNDMED_Simbolo;
                        $prod_cantidad = $valor->GUIAREMDETC_Cantidad;

                        //------------------------------------------------------------------------------        


                        $array_producto = explode("/", $descri);
                        $this->cezpdf->addText($posicionX + 20, $posicionY + 540, 9, $prod_unidad);
                        $this->cezpdf->addText($posicionX + 170, $posicionY + 550, 9, utf8_decode_seguro($array_producto[0]));
                        $this->cezpdf->addText($posicionX + 85, $posicionY + 540, 9, $prod_unidad);
                        $this->cezpdf->addText($posicionX + 50, $posicionY + 545, 9, $prod_cantidad);


                        //--------------------------    

                        if ($tipo_oper == "C") {

                            $datos_serie = $this->seriemov_model->buscar_x_guiainp($guiainp, $prod_cod);
                        } else {
                            $datos_serie = $this->seriemov_model->buscar_x_guiasap($guiasap, $prod_cod);
                        }

                        $ser = "";

                        $c = 0;

                        if (count($datos_serie) > 0) {

                            foreach ($datos_serie as $indices => $valor) {

                                $c += 1;

                                $seriecodigo = $valor->SERIC_Numero;

                                $ser = $ser . " / " . $seriecodigo;

                                if ($c == 7) {

                                    $this->cezpdf->addText(90 + $posicionX += 30, $posicionY + 620, 8, "" . $ser);

                                    $posicionY -= 10;

                                    $posicionX -= 30;

                                    $ser = "";

                                    $c = 0;

                                }

                            }

                            $this->cezpdf->addText(90 + $posicionX += 30, $posicionY + 620, 8, "" . $ser);
                            $posicionY -= 10;
                        }

                        $posicionX -= 30;
                        //--------------------- 

                        //$this->cezpdf->addText($posicionX + 10, $posicionY + 610, 9, utf8_decode_seguro($nombre_emprtrans2 != '' ? $nombre_emprtrans . '-' : $nombre_emprtrans ));
                        $this->cezpdf->addText($posicionX + 538, $posicionY + 550, 9, $moneda_simbolo . ' ' . $datos_detalle_guiarem[0]->GUIAREMDETC_Total);

                        $posicionY -= 20;
                    }
                }

                $posicionY = 0;

                $this->cezpdf->addText(494, 425, 8, $moneda_simbolo . ' ' . $total);

                // $this->cezpdf->addText(300, 500, 9, utf8_decode_seguro($ser));

                $this->cezpdf->addText(600, 700, 9, utf8_decode_seguro($nombre_emprtrans2 != '' ? $nombre_emprtrans : $nombre_emprtrans));

                $this->cezpdf->addText(400, 500, 9, utf8_decode_seguro($nombre_emprtrans2));

                $this->cezpdf->addText(47, 138, 9, $ruc_emprtrans);
                // tipo de doc= FACTURA.
                //  $this->cezpdf->addText(40, 127, 9, utf8_decode_seguro(strtoupper($nombre_tipodoc)));
                $this->cezpdf->addText(40, 115, 9, utf8_decode_seguro($numero_ref));
                $posx = 0;
                $posy = 0;
                switch ($tipo_movimiento) {

                    case 1:
                        $posx = 221;

                        $posy = 167;

                        break;

                    case 2:
                        $posx = 221;

                        $posy = 158;

                        break;

                    case 3:
                        $posx = 221;

                        $posy = 142;

                        break;

                    case 4:
                        $posx = 221;

                        $posy = 133;

                        break;

                    case 5:
                        $posx = 221;

                        $posy = 124;

                        break;

                    case 6:
                        $posx = 221;

                        $posy = 115;

                        break;

                    case 7:
                        $posx = 221;

                        $posy = 99;

                        break;

                    case 8:
                        $posx = 221;

                        $posy = 90;

                        break;

                    case 9:
                        $posx = 221;

                        $posy = 81;

                        break;

                    case 10:
                        $posx = 367;

                        $posy = 167;

                        break;

                    case 11:
                        $posx = 367;

                        $posy = 159;

                        break;

                    case 12:
                        $posx = 367;

                        $posy = 151;

                        break;

                    case 13:
                        $posx = 367;

                        $posy = 142;

                        break;

                }

                //$this->cezpdf->addText($posx, $posy, 14, 'x');
                if ($tipo_movimiento == 13) {
                    $this->cezpdf->addText(377, 136, 7, ($otro_motivo2 != '' ? $otro_motivo . '-' : $otro_motivo));
                    $this->cezpdf->addText(377, 127, 7, $otro_motivo2);
                }

            }


            $cabecera = array('Content-Type' => 'application/pdf', 'Content-Disposition' => 'nama_file.pdf', 'Expires' => '0', 'Pragma' => 'cache', 'Cache-Control' => 'private');

            $this->cezpdf->ezStream($cabecera);


        } else {
// DRAGOTEK


            $hoy = date("Y-m-d");

            $datos_guiarem = $this->guiarem_model->obtener($codigo);

            $tipo_movimiento = $datos_guiarem[0]->TIPOMOVP_Codigo;

            $otro_motivo = $datos_guiarem[0]->GUIAREMC_OtroMotivo;

            $empresa_transporte = $datos_guiarem[0]->EMPRP_Codigo;

            $almacen = $datos_guiarem[0]->ALMAP_Codigo;

            $usuario = $datos_guiarem[0]->USUA_Codigo;

            $referencia = $datos_guiarem[0]->DOCUP_Codigo;

            $cliente = $datos_guiarem[0]->CLIP_Codigo;

            $proveedor = $datos_guiarem[0]->PROVP_Codigo;

            $recepciona_nombres = $datos_guiarem[0]->GUIAREMC_PersReceNombre;

            $recepciona_dni = $datos_guiarem[0]->GUIAREMC_PersReceDNI;

            $numero_ref = $datos_guiarem[0]->GUIAREMC_NumeroRef;

            $numero_ocompra = $datos_guiarem[0]->GUIAREMC_OCompra;

            $serie = $datos_guiarem[0]->GUIAREMC_Serie;

            $numero = $datos_guiarem[0]->GUIAREMC_Numero;

            $codigo_usuario = $datos_guiarem[0]->GUIAREMC_CodigoUsuario;

            $fecha_traslado = $datos_guiarem[0]->GUIAREMC_FechaTraslado;

            $observacion = $datos_guiarem[0]->GUIAREMC_Observacion;

            $placa = $datos_guiarem[0]->GUIAREMC_Placa;

            $marca = $datos_guiarem[0]->GUIAREMC_Marca;

            $registro_mtc = $datos_guiarem[0]->GUIAREMC_RegistroMTC;

            $certificado = $datos_guiarem[0]->GUIAREMC_Certificado;

            $licencia = $datos_guiarem[0]->GUIAREMC_Licencia;

            $nombre_conductor = $datos_guiarem[0]->GUIAREMC_NombreConductor;

            $ocompra = $datos_guiarem[0]->OCOMP_Codigo;


            $estado = $datos_guiarem[0]->GUIAREMC_FlagEstado;


            if ($estado == 2) {
                $filter = new stdClass();
                $filter->GUIAREMC_FlagEstado = 1;
                $this->guiarem_model->modificar($codigo, $filter);


                ////////bloqueado stv
//            if ($tipo_oper == 'V') {
//
//                //Datos cabecera de la guiasa.
//
//                $filter3 = new stdClass();
//
//                $filter3->TIPOMOVP_Codigo = $tipo_movimiento;
//
//                $filter3->ALMAP_Codigo = $almacen;
//
//                $filter3->CLIP_Codigo = $cliente;
//
//                $filter3->GUIASAC_Fecha = $hoy;
//
//                $filter3->GUIASAC_Observacion = $observacion;
//
//                $filter3->USUA_Codigo = $this->somevar['user'];
//
//                $guia_id = $this->guiasa_model->insertar($filter3);
//
//                $filter->GUIASAP_Codigo = $guia_id;
//
//            } else {
//
//                //Datos cabecera de la guiain.
//
//                $filter3 = new stdClass();
//
//                $filter3->TIPOMOVP_Codigo = $tipo_movimiento;
//
//                $filter3->ALMAP_Codigo = $almacen;
//
//                $filter3->PROVP_Codigo = $proveedor;
//
//                $filter3->DOCUP_Codigo = 10;
//
//                $filter3->GUIAINC_Fecha = $hoy;
//
//                $filter3->GUIAINC_FechaModificacion = $hoy;
//
//                $filter3->USUA_Codigo = $this->somevar['user'];
//
//                $guia_id = $this->guiain_model->insertar($filter3);
//
//                $filter->GUIAINP_Codigo = $guia_id;
//
//            }
//
//
//
//
//            $a_filter = new stdClass();
//
//            if ($tipo_oper == 'V')
//
//                $a_filter->GUIASAP_Codigo = $guia_id;
//
//            else
//
//                $a_filter->GUIAINP_Codigo = $guia_id;
//
//
//
//            $this->guiarem_model->modificar($codigo, $a_filter);
//
                ////////////////


                $detalle = $this->guiaremdetalle_model->obtener2($codigo);
                $detalle_guiarem = array();
                if (count($detalle) > 0) {
                    foreach ($detalle as $indice => $valor) {
                        $detacodi = $valor->GUIAREMDETP_Codigo;
                        $producto = $valor->PRODCTOP_Codigo;
                        $unidad = $valor->UNDMED_Codigo;
                        $cantidad = $valor->GUIAREMDETC_Cantidad;
                        $pu = $valor->GUIAREMDETC_Pu;
                        $subtotal = $valor->GUIAREMDETC_Subtotal;
                        $igv = $valor->GUIAREMDETC_Igv;
                        $descuento = $valor->GUIAREMDETC_Descuento;
                        $total = $valor->GUIAREMDETC_Total;
                        $pu_conigv = $valor->GUIAREMDETC_Pu_ConIgv;
                        $costo = $valor->GUIAREMDETC_Costo;
                        $venta = $valor->GUIAREMDETC_Venta;
                        $peso = $valor->GUIAREMDETC_Peso;
                        $GenInd = $valor->GUIAREMDETC_GenInd;
                        $descri = str_replace('"', "''", $valor->GUIAREMDETC_Descripcion);
                        $datos_producto = $this->producto_model->obtener_producto($producto);
                        $datos_unidad = $this->unidadmedida_model->obtener($unidad);
                        $nombre_producto = $datos_producto[0]->PROD_Nombre;
                        $codigo_interno = $datos_producto[0]->PROD_CodigoUsuario;

                        if ($datos_unidad)

                            $nombre_unidad = $datos_unidad[0]->UNDMED_Descripcion;

                        else

                            $nombre_unidad = "SERV";


                        ///////bloqueado stv
//                    $filter4 = new stdClass();
//
//                    if ($tipo_oper == 'V') {
//
//                        $filter4->GUIASAP_Codigo = $guia_id;
//
//                        $filter4->PRODCTOP_Codigo = $producto;
//
//                        $filter4->UNDMED_Codigo = $unidad;
//
//                        $filter4->GUIASADETC_Cantidad = $cantidad;
//
//                        $filter4->GUIASADETC_Costo = $costo;
//
//                        $filter4->GUIASADETC_GenInd = $GenInd;
//
//                        $filter4->GUIASADETC_Descripcion = $descri;
//
//                        $this->guiasadetalle_model->insertar($filter4);
//
//                    } else {
//
//                        $filter4->GUIAINP_Codigo = $guia_id;
//
//                        $filter2->GUIAREMP_Codigo = $codigo;
//
//                        $filter4->PRODCTOP_Codigo = $producto;
//
//                        $filter4->UNDMED_Codigo = $unidad;
//
//                        $filter4->GUIAINDETC_Cantidad = $cantidad;
//
//                        $filter4->GUIAINDETC_Costo = '';
//
//                        $filter4->GUIIAINDETC_GenInd = $GenInd;
//
//                        $this->guiaindetalle_model->insertar($filter4);
//
//                    }
                        ///////////////


                    }

                }

            }


            if ($tipo_oper == "V") {
                $datos_guiarem = $this->guiarem_model->obtener($codigo);
                $datos_detalle_guiarem = $this->guiaremdetalle_model->obtener2($codigo);
                $tipo_movimiento = $datos_guiarem[0]->TIPOMOVP_Codigo;
                $referencia = $datos_guiarem[0]->DOCUP_Codigo;
                $guiasap = $datos_guiarem[0]->GUIASAP_Codigo;
                $guiainp = $datos_guiarem[0]->GUIAINP_Codigo;
                $motivo_trans = $datos_guiarem[0]->TIPOMOVP_Codigo;
                $cliente = $datos_guiarem[0]->CLIP_Codigo;
                $proveedor = $datos_guiarem[0]->PROVP_Codigo;
                $numero_ref = $datos_guiarem[0]->GUIAREMC_NumeroRef;
                $numero_ocompra = $datos_guiarem[0]->GUIAREMC_OCompra;
                $serie = $datos_guiarem[0]->GUIAREMC_Serie;
                $numero = $datos_guiarem[0]->GUIAREMC_Numero;
                $fecha_traslado = mysql_to_human($datos_guiarem[0]->GUIAREMC_FechaTraslado);
                $observacion = $datos_guiarem[0]->GUIAREMC_Observacion;
                $marca = $datos_guiarem[0]->GUIAREMC_Marca;
                $placa = $datos_guiarem[0]->GUIAREMC_Placa;
                $registro_mtc = $datos_guiarem[0]->GUIAREMC_RegistroMTC;
                $certificado = $datos_guiarem[0]->GUIAREMC_Certificado;
                $licencia = $datos_guiarem[0]->GUIAREMC_Licencia;
                $nombre_conductor = $datos_guiarem[0]->GUIAREMC_NombreConductor;

                $punto_partida = $datos_guiarem[0]->GUIAREMC_PuntoPartida;
                $arr_punt_part = explode('-', $punto_partida);

                $a=$arr_punt_part[3];
                $a1=$arr_punt_part[2];
                $a2=$arr_punt_part[1];
                $a3=$arr_punt_part[0];

                $punto_llegada = $datos_guiarem[0]->GUIAREMC_PuntoLlegada;
                $arr_punt_lleg = explode('-', $punto_llegada);

                $b=$arr_punt_lleg[3];
                $b1=$arr_punt_lleg[2];
                $b2=$arr_punt_lleg[1];
                $b3=$arr_punt_lleg[0];

                $empresa_transporte = $datos_guiarem[0]->EMPRP_Codigo;
                $fecha = mysql_to_human($datos_guiarem[0]->GUIAREMC_Fecha);
                $otro_motivo = $datos_guiarem[0]->GUIAREMC_OtroMotivo;
                $total = $datos_guiarem[0]->GUIAREMC_total;
                $datos_moneda = $this->moneda_model->obtener($datos_guiarem[0]->MONED_Codigo);
                $moneda_nombre = (count($datos_moneda) > 0 ? $datos_moneda[0]->MONED_Descripcion : 'NUEVOS SOLES');
                $moneda_simbolo = (count($datos_moneda) > 0 ? $datos_moneda[0]->MONED_Simbolo : 'S/.');
                $nombre_emprtrans = "";
                $ruc_emprtrans = "";
                if ($empresa_transporte != '') {
                    $datos_emprtrans = $this->empresa_model->obtener_datosEmpresa($empresa_transporte);
                    if (count($datos_emprtrans) > 0) {
                        $ruc_emprtrans = $datos_emprtrans[0]->EMPRC_Ruc;
                        $nombre_emprtrans = $datos_emprtrans[0]->EMPRC_RazonSocial;
                    }
                }

                $mot = "";

                switch ($motivo_trans) {

                    case 1:

                        $mot = 1;

                        break;

                    case 2:

                        $mot = 0;

                        break;

                    case 3:

                        $mot = 2;

                        break;

                    case 4:

                        $mot = 4;

                        break;

                    case 5:

                        $mot = 5;

                        break;

                    case 6:

                        $mot = 6;

                        break;

                    case 7:

                        $mot = 9;

                        break;

                    case 8:

                        $mot = 13;

                        break;

                }

                $nombre_tipodoc = '';

                if ($referencia != '') {
                    $datos_doc = $this->documento_model->obtener($referencia);
                    $nombre_tipodoc = $datos_doc[0]->DOCUC_Descripcion;

                }


                /* Datos del cliente */

                $datos_cliente = $this->cliente_model->obtener($cliente);
                $razon_social = utf8_decode($datos_cliente->nombre);
                $tipo_doc = ($datos_cliente->tipo == '0' ? 'D.N.1' : 'R.U.C.');
                $ruc = $datos_cliente->ruc;
                $dni = $datos_cliente->dni;
                $distrito_cliente = $datos_cliente->distrito;
                $provincia_cliente = $datos_cliente->provincia;
                $departamento_cliente = $datos_cliente->departamento;
//            $razon_social2 = '';

//            if (strlen($razon_social) > 26) {

//                $razon_social2 = substr($razon_social, 0);

//                $razon_social = substr($razon_social, 0);

//            }

                $nombre_emprtrans2 = '';
                if (strlen($nombre_emprtrans) > 29) {
                    $nombre_emprtrans2 = substr($nombre_emprtrans, 29);
                    $nombre_emprtrans = substr($nombre_emprtrans, 0, 29);
                }

                $otro_motivo2 = '';

                if (strlen($otro_motivo) > 18) {
                    $otro_motivo2 = substr($otro_motivo, 18);
                    $otro_motivo = substr($otro_motivo, 0, 18);
                }


                if ($_SESSION['compania'] == '2') {
//2 = TIENDA MESA REDONDA YES 


                    if ($img == 1) {
                        $notimg = "guia_tek_anda.jpg";
                    } else {
                        $notimg = "";

                    }

                    /* Cabecera */

//            prep_pdf();

                    //$this->cezpdf = new backgroundPDF('a4', 'portrait', 'image', array('img'=>'images/img_db/ferresat_fondo_guiarem.jpg')); 

                    $this->cezpdf = new backgroundPDF('a4', 'portrait', 'image', array('img' => 'images/img_db/' . $notimg));

                    $posicionX = 3;

                    $posicionY = -23;

                    $this->cezpdf->addText(88, '', 9, '');
                    if ($img == 0) {

                        $this->cezpdf->addText($posicionX + 350, $posicionY + 720, 18, $serie);
                        $this->cezpdf->addText($posicionX + 455, $posicionY + 720, 18, $numero);

                    } else {

                        $this->cezpdf->addText($posicionX + 436, $posicionY + 745, 18, "");
                        $this->cezpdf->addText($posicionX + 480, $posicionY + 745, 18, "");

                    }
                    $this->cezpdf->addText($posicionX + 130, $posicionY + 660, 8, substr($fecha , 0, 2));
                    $this->cezpdf->addText($posicionX + 116, $posicionY + 742, 8, substr($fecha, 3, 2));
                    $this->cezpdf->addText($posicionX + 150, $posicionY + 742, 8, substr($fecha, 8, 2));
//fecha traslado
                    //FECHA DE TRASLADO
             

                    //direccion partida

                    $this->cezpdf->addText($posicionX + 35, $posicionY + 716, 8, utf8_decode_seguro(substr($arr_punt_part[0], 0, 65)));

//


//        $this->cezpdf->addText($posicionX + 62, $posicionY + 663, 8, utf8_decode_seguro(isset($arr_punt_part[1]) ? $arr_punt_part[1] . '321321321' : '9999999999999999'));

//

                    //direccion destino

                    $direccion_destino = substr($arr_punt_lleg[0], 0, 55);

                    $this->cezpdf->addText($posicionX + 35, $posicionY + 691, 7, utf8_decode_seguro(isset($direccion_destino) ? $direccion_destino : ''));

                    //empresa de transporte
                    $this->cezpdf->addText($posicionX + 85, $posicionY + 123, 7, utf8_decode_seguro($nombre_emprtrans));

                    //$this->cezpdf->addText($posicionX + 266, $posicionY + 100, 6, utf8_decode_seguro($nombre_conductor));

                    $this->cezpdf->addText($posicionX + 340, $posicionY + 123, 8, $ruc_emprtrans);
                    $this->cezpdf->addText($posicionX + 489, $posicionY + 689, 7, $placa);
                    $this->cezpdf->addText($posicionX + 416, $posicionY + 676, 7, $certificado);
                    $this->cezpdf->addText($posicionX + 405, $posicionY + 665, 7, $licencia);
                    $this->cezpdf->addText($posicionX + 412, $posicionY + 689, 7, $marca);
                    //Destinatario
                    $this->cezpdf->addText($posicionX + 70, $posicionY + 671, 8, $razon_social);
//          $this->cezpdf->addText($posicionX + 32, $posicionY + 80, 8, $nombre_conductor);
                    $this->cezpdf->addText($posicionX + 110, $posicionY + 658, 8, $ruc);
                    $this->cezpdf->addText($posicionX + 262, $posicionY + 658, 8, $dni);
//          $this->cezpdf->addText($posicionX + 68, $posicionY + 616, 9, "x");

                    /* Detalle */

                    $db_data = array();
                    $prod_nombreimei = '';
                    if (count($datos_detalle_guiarem) > 0) {

                        foreach ($datos_detalle_guiarem as $indice => $valor) {

                            $producto = $valor->PRODCTOP_Codigo;

                            $unidad = $valor->UNDMED_Codigo;

                            $costo = $valor->GUIAREMDETC_Costo;

                            $venta = $valor->GUIAREMDETC_Venta;

                            $peso = $valor->GUIAREMDETC_Peso;

                            $descri = $valor->GUIAREMDETC_Descripcion;

                            //$descri = str_replace('\\', '', $descri);

                            $datos_producto = $this->producto_model->obtener_producto($producto);

                            $datos_unidad = $this->unidadmedida_model->obtener($unidad);

                            $prod_cod = $datos_producto[0]->PROD_Codigo;

                            $prod_nombre = $datos_producto[0]->PROD_Nombre;

                            $prod_nombreimei = $prod_nombre . ' / ' . $prod_nombreimei;

                            $prod_codigo = $datos_producto[0]->PROD_CodigoUsuario;

                            $prod_unidad = $datos_unidad[0]->UNDMED_Descripcion;

                            $prod_cantidad = $valor->GUIAREMDETC_Cantidad;

                            //------------------------------------------------------------------------------        

                            $array_producto = explode("/", $descri);

                            //$db_data[] = array(

                            //     'col1' => utf8_decode_seguro($descri),

                            //     'col2' => $prod_unidad,

                            //     'col3' => $prod_cantidad,

                            //     'col4' => ''

                            // );

                            //   $this->cezpdf->addText($posicionX + 20, $posicionY + 540, 9, $prod_unidad);
                            //stv
                            //$this->cezpdf->addText($posicionX + 28, $posicionY + 600, 6, utf8_decode_seguro($prod_codigo));
                            ///$prod_unidad
                            $this->cezpdf->addText($posicionX + 36, $posicionY + 623, 8, utf8_decode_seguro($descri));   //$array_producto[0]
                            ///stv
                            $this->cezpdf->addText($posicionX + 370, $posicionY + 623, 6, utf8_decode_seguro($prod_unidad));
                            ///
                            // $this->cezpdf->addText($posicionX + 85, $posicionY + 540, 9, $prod_unidad);

                            $this->cezpdf->addTextWrap($posicionX + 410, $posicionY + 623, 35, 9, $prod_cantidad, 'right');


                            $ser = "";

                            $c = 0;

//                   
//                    }


                            $posicionY -= 19;

                        }

                    }

                    $posicionY = 0;

//            $this->cezpdf->addText(480, 425, 8, $moneda_simbolo . ' ' . $total);

                    // $this->cezpdf->addText(300, 500, 9, utf8_decode_seguro($ser));

                    $this->cezpdf->addText(600, 100, 9, utf8_decode_seguro($nombre_emprtrans2 != '' ? $nombre_emprtrans . ' k' : $nombre_emprtrans . ' L'));

                    //    $this->cezpdf->addText(400, 500, 9, utf8_decode_seguro($nombre_emprtrans2));

                    //  $this->cezpdf->addText(47, 138, 9, $ruc_emprtrans);

                    //   $this->cezpdf->addText(40, 127, 9, utf8_decode_seguro(strtoupper($nombre_tipodoc)));

                    //num_factura   bloqueado stv
                    //$this->cezpdf->addText(40, 115, 9, utf8_decode_seguro($numero_ref));

                    $posx = 0;

                    $posy = 0;

                    switch ($tipo_movimiento) {

                        case 1:
                            $posx = 37;
                            $posy = 54;
                            break;

                        case 2:
                            $posx = 37;
                            $posy = 46;
                            break;

                        case 3:
                            $posx = 37;
                            $posy = 38;
                            break;

                        case 4:
                            $posx = 37;
                            $posy = 32;
                            break;

                        case 5:
                            $posx = 165;
                            $posy = 60;
                            break;

                        case 6:
                            $posx = 165;
                            $posy = 54;
                            break;

                        case 7:
                            $posx = 165;
                            $posy = 33;
                            break;

                        case 8:
                            $posx = 165;
                            $posy = 22;
                            break;

                        case 9:
                            $posx = 270;
                            $posy = 87;
                            break;

                        case 10:
                            $posx = 270;
                            $posy = 68;
                            break;

                        case 11:
                            $posx = 270;
                            $posy = 56;
                            break;

                        case 12:
                            $posx = 270;
                            $posy = 47;
                            break;

                        case 13:
                            $posx = 365;
                            $posy = 88;
                            break;

                    }

                    $this->cezpdf->addText($posx, $posy, 14, 'x');


                    $this->cezpdf->ezText(' ', 9, array("leading" => 1200, "left" => 0));
                    $this->cezpdf->addText(90, 705, 8, 'ESTA LISTA CORRESPONDE A');
                    $this->cezpdf->addText(90, 685, 8, 'FACTURA');
                    $this->cezpdf->addText(250, 685, 8, $numero_ref);

                    /*$this->cezpdf->addText(90, 665, 8, 'BOLETA');
            $this->cezpdf->addText(250, 665, 8, $numero_ref);*/

                    $this->cezpdf->addText(90, 645, 8, 'GUIA DE REMISION');
                    $this->cezpdf->addText(250, 645, 8, $numero . ' Nro ' . $serie);


                    $this->cezpdf->addText(275, 585, 8, 'LISTA DE IMEIS');

                    $this->cezpdf->addText(90, 620, 8, utf8_decode_seguro($prod_nombreimei));


                    $valortotal = strlen($observacion);
                    // strlen se obtiene la longitud de caracteres
                    $exacta = round($valortotal / 112);
                    // obtiene el numero entero de la operacion
                    for ($i = 0; $i < $exacta; $i++) {
                        $this->cezpdf->addText(90, 560 - ($i * 10), 7, substr($observacion, $i * 112, 112));
                    }


                } else {
//  1= MAGDALENA DEL MAR - YES  GUIA IMPRIMIR

                    if ($img == 1) {
                      $notimg = "";
                    } else {
                       
                        $notimg = "guia_remision.jpg";

                    }

                    //modificar casa
                    /* Cabecera */

//            prep_pdf();
                        //
                    //$this->cezpdf = new backgroundPDF('a4', 'portrait', 'image', array('img'=>'images/img_db/ferresat_fondo_guiarem.jpg')); 

                    $this->cezpdf = new backgroundPDF('a4', 'portrait', 'image', array('img' => 'images/img_db/' . $notimg));
                    //$this->cezpdf->addText(500,200,30,'HOLAAAA');
                    $posiciongeneralx = 0;
                    $posiciongeneraly = -2;
                    $posicionX = -30;
                    $posicionY = +10;

                    $this->cezpdf->addText(88, '', 9, '');

                    if ($img == 0) {

                        $this->cezpdf->addText($posicionX + 350, $posicionY + 720, 18, $serie);

                        $this->cezpdf->addText($posicionX + 455, $posicionY + 720, 18, $numero);

                    } else {

                        $this->cezpdf->addText($posicionX + 436, $posicionY + 700, 18, "$serie");

                        $this->cezpdf->addText($posicionX + 480, $posicionY + 700, 18, "$numero");

                    }

                    $this->cezpdf->addText($posicionX + 135 + $posiciongeneralx, $posicionY + 660+ $posiciongeneraly, 8, substr($fecha, 0, 2).' / ');

                    $this->cezpdf->addText($posicionX + 148 + $posiciongeneralx, $posicionY + 660 + $posiciongeneraly, 8, substr($fecha, 3, 2).' / ');

                    $this->cezpdf->addText($posicionX + 165+ $posiciongeneralx, $posicionY + 660+ $posiciongeneraly, 8, substr($fecha, 8, 2));

                    //FECHA DE TRASLADO IMPRIMIR GUIAREM
                    $this->cezpdf->addText($posicionX + 450 + $posiciongeneralx, $posicionY + 660 + $posiciongeneraly, 8, substr($fecha_traslado, 0, 2).' / ');
                    $this->cezpdf->addText($posicionX + 470+ $posiciongeneralx, $posicionY + 660 + $posiciongeneraly, 8, substr($fecha_traslado, 3, 2).' / ');
                    $this->cezpdf->addText($posicionX + 485+ $posiciongeneralx, $posicionY + 660 + $posiciongeneraly, 8, substr($fecha_traslado, 8, 4));
                    //$this->cezpdf->addText($posicionX + 330, $posicionY + 673, 9, $fecha_traslado);

                    //direccion partida imprimir guiarem

                /* $this->cezpdf->addText($posicionX + 70, $posicionY + 630 + $posiciongeneraly, 8, utf8_decode_seguro(substr($arr_punt_part[0], 0, 60)));*/

                   $this->cezpdf->addTextWrap($posicionX + 130, $posicionY + 596,200, 7, utf8_decode_seguro(substr($a3, 0, 37)));
                    $this->cezpdf->addTextWrap($posicionX +50, $posicionY + 596,200, 7, utf8_decode_seguro(substr($a2, 0, 37)));

                    $this->cezpdf->addTextWrap($posicionX + 155, $posicionY + 587,200, 8, utf8_decode_seguro(substr($a1, 0, 37)));
                    $this->cezpdf->addTextWrap($posicionX + 245, $posicionY + 587,200, 8, utf8_decode_seguro(substr($a, 0, 37)));
                   


//

//        $this->cezpdf->addText($posicionX + 62, $posicionY + 663, 8, utf8_decode_seguro(isset($arr_punt_part[1]) ? $arr_punt_part[1] . '321321321' : '9999999999999999'));

//

                 

                    //$direccion_destino = substr($arr_punt_lleg[0], 0, 64);
//DIRECCION
                    //$this->cezpdf->addText($posicionX + 360 + $posiciongeneralx, $posicionY + 630 + $posiciongeneraly, 8, utf8_decode_seguro(isset($direccion_destino) ? $direccion_destino : ''));
//direccion destino imprimir
                    $direccion_destino = substr($arr_punt_lleg[0], 0, 37);
                   $this->cezpdf->addTextWrap($posicionX + 335, $posicionY + 596,200, 7, utf8_decode_seguro(isset($direccion_destino) ? $direccion_destino : ''));

                    $this->cezpdf->addTextWrap($posicionX + 440, $posicionY + 588,200, 7, utf8_decode_seguro(substr($b2, 0, 37)));

                    $this->cezpdf->addTextWrap($posicionX + 525, $posicionY + 588,200, 7, utf8_decode_seguro(substr($b1, 0, 37)));
              


                    //empresa de transporte
                    $this->cezpdf->addText($posicionX + 85 + $posiciongeneralx, $posicionY + 482 + $posiciongeneraly, 7, utf8_decode_seguro($nombre_emprtrans));

                    //$this->cezpdf->addText($posicionX + 230, $posicionY + 580, 8, utf8_decode_seguro($nombre_conductor));

                    $this->cezpdf->addText($posicionX + 340 + $posiciongeneralx, $posicionY + 479 + $posiciongeneraly, 8, $ruc_emprtrans);

                    $this->cezpdf->addText($posicionX +475+ $posiciongeneralx, $posicionY + 550 + $posiciongeneraly, 7, $placa);

                    $this->cezpdf->addText($posicionX + 180 + $posiciongeneralx, $posicionY +550 + $posiciongeneraly, 7, $certificado); //

                    $this->cezpdf->addText($posicionX + 170 + $posiciongeneralx, $posicionY + 565 + $posiciongeneraly, 7, $licencia); //

                    $this->cezpdf->addText($posicionX + 420+ $posiciongeneralx, $posicionY + 550 + $posiciongeneraly,7, $marca);


//




                    //Destinatario
                    $this->cezpdf->addText($posicionX + 50 + $posiciongeneralx, $posicionY + 530 + $posiciongeneraly, 8, $razon_social);

                    $this->cezpdf->addText($posicionX + 75 + $posiciongeneralx, $posicionY + 515 + $posiciongeneraly, 8, $ruc);

                 //  $this->cezpdf->addText($posicionX + 230, $posicionY + 565, 8, $nombre_conductor);

                   // $this->cezpdf->addText($posicionX + 262 + $posiciongeneralx, $posicionY + 634 + $posiciongeneraly, 8, $dni);
                    // $this->cezpdf->addText($posicionX + 68, $posicionY + 616, 9, "x");

                    /* Detalle */

                    $db_data = array();
                    if (count($datos_detalle_guiarem) > 0) {

                        foreach ($datos_detalle_guiarem as $indice => $valor) {

                            $producto = $valor->PRODCTOP_Codigo;

                            $unidad = $valor->UNDMED_Codigo;

                            $costo = $valor->GUIAREMDETC_Costo;

                            $venta = $valor->GUIAREMDETC_Venta;

                            $peso = $valor->GUIAREMDETC_Peso;

                            $descri = $valor->GUIAREMDETC_Descripcion;

                            //   $descri = str_replace('\\', '', $descri);

                            $datos_producto = $this->producto_model->obtener_producto($producto);

                            $datos_unidad = $this->unidadmedida_model->obtener($unidad);

                            $prod_cod = $datos_producto[0]->PROD_Codigo;

                            $prod_nombre = $datos_producto[0]->PROD_Nombre;

                            $prod_codigo = $datos_producto[0]->PROD_CodigoUsuario;

                            $prod_unidad = $datos_unidad[0]->UNDMED_Descripcion;

                            $prod_cantidad = $valor->GUIAREMDETC_Cantidad;

                            //------------------------------------------------------------------------------        

                            $array_producto = explode("/", $descri);

                            //$db_data[] = array(

                            //     'col1' => utf8_decode_seguro($descri),

                            //     'col2' => $prod_unidad,

                            //     'col3' => $prod_cantidad,

                            //     'col4' => ''

                            // );

                            //   $this->cezpdf->addText($posicionX + 20, $posicionY + 540, 9, $prod_unidad);
                            //stv
                            $this->cezpdf->addText($posicionX + 55, $posicionY + 470, 8, utf8_decode_seguro($prod_codigo));
                            ///$prod_unidad
                            $this->cezpdf->addText($posicionX + 135+ $posiciongeneralx, $posicionY + 470+ $posiciongeneraly, 8, utf8_decode_seguro(substr($descri, 0, 70)));   //$array_producto[0]

                                                                                                                                ;
                            ///stv unidad
                            $this->cezpdf->addText($posicionX + 495 + $posiciongeneralx, $posicionY + 470 + $posiciongeneraly, 6, utf8_decode_seguro($prod_unidad));

                            ///

                            // $this->cezpdf->addText($posicionX + 85, $posicionY + 540, 9, $prod_unidad);

                            $this->cezpdf->addTextWrap($posicionX + 450 + $posiciongeneralx, $posicionY + 470 + $posiciongeneraly, 35, 9, $prod_cantidad, 'right');

                            //--------------------------    

//                    if ($tipo_oper == "C") {

//                        $datos_serie = $this->seriemov_model->buscar_x_guiainp($guiainp, $prod_cod);

//                    } else {

//                        $datos_serie = $this->seriemov_model->buscar_x_guiasap($guiasap, $prod_cod);

//                    }

                            $ser = "";

                            $c = 0;

//                    if (count($datos_serie) > 0) {

//                        foreach ($datos_serie as $indices => $valor) {

//                            $c+=1;

//                            $seriecodigo = $valor->SERIC_Numero;

//                            $ser = $ser . " / " . $seriecodigo;

//                            if ($c == 7) {

//

//                                $this->cezpdf->addText(90 + $posicionX +=30, $posicionY + 620, 8, "" . $ser);

//                                $posicionY-=10;

//                                $posicionX -=30;

//                                $ser = "";

//                                $c = 0;

//                            }

//                        }

//                        $this->cezpdf->addText(90 + $posicionX +=30, $posicionY + 620, 8, "" . $ser);

//

//                        $posicionY-=10;

//                    }

                            //$posicionX = 0;


                            //--------------------- 

                            //$this->cezpdf->addText($posicionX + 10, $posicionY + 610, 9, utf8_decode_seguro($nombre_emprtrans2 != '' ? $nombre_emprtrans . '-' : $nombre_emprtrans ));


//                    $this->cezpdf->addText($posicionX + 500, $posicionY + 548, 9, $moneda_simbolo . ' ' . $valor->GUIAREMDETC_Total);


                            $posicionY -= 15;

                        }

                    }

                    $posicionY = 0;

//            $this->cezpdf->addText(480, 425, 8, $moneda_simbolo . ' ' . $total);

                    // $this->cezpdf->addText(300, 500, 9, utf8_decode_seguro($ser));

                    $this->cezpdf->addText(600 + $posiciongeneralx, 100 + $posiciongeneraly, 9, utf8_decode_seguro($nombre_emprtrans2 != '' ? $nombre_emprtrans . ' k' : $nombre_emprtrans . ' L'));

                    //    $this->cezpdf->addText(400, 500, 9, utf8_decode_seguro($nombre_emprtrans2));

                    //  $this->cezpdf->addText(47, 138, 9, $ruc_emprtrans);

                    //   $this->cezpdf->addText(40, 127, 9, utf8_decode_seguro(strtoupper($nombre_tipodoc)));

                    //num_factura   bloqueado stv
                    //$this->cezpdf->addText(40, 115, 9, utf8_decode_seguro($numero_ref));

                    $posx = 0;

                    $posy = 0;

                    switch ($tipo_movimiento) {

                        case 1:
                            $posx = 37;

                            $posy = 434;

                            break;

                        case 2:
                            $posx = 37;

                            $posy = 418;

                            break;

                        case 3:
                            $posx = 95;

                            $posy = 434;

                            break;

                        case 4:
                            $posx = 95;

                            $posy = 418;

                            break;

                        case 5:
                            $posx = 244;

                            $posy = 432;

                            break;

                        case 6:
                            $posx = 244;

                            $posy = 416;

                            break;

                        case 7:
                            $posx = 360;

                            $posy = 432;

                            break;

                        case 8:
                            $posx = 360;

                            $posy = 416;

                            break;

                        case 9:
                            $posx = 428;

                            $posy = 432;

                            break;

                        case 10:
                            $posx = 428;

                            $posy = 416;

                            break;

                        case 11:
                            $posx = 492;

                            $posy = 432;

                            break;

                        case 12:
                            $posx = 492;

                            $posy = 416;

                            break;

                        case 13:
                            $posx = 37;

                            $posy = 400;

                            break;

                    }

                    //$this->cezpdf->addText($posx + 55  +$posiciongeneralx, $posy +42 + $posiciongeneraly, 14, 'x');

                   /* $this->cezpdf->ezText(' ', 9, array("leading" => 1200, "left" => 0));
                    $this->cezpdf->addText(90, 705, 8, 'ESTA LISTA CORRESPONDE A');
                    $this->cezpdf->addText(90, 685, 8, 'FACTURA');
                    $this->cezpdf->addText(250, 685, 8, $numero_ref);

                    /*$this->cezpdf->addText(90, 665, 8, 'BOLETA');
            $this->cezpdf->addText(250, 665, 8, $numero_ref);*/

                   /* $this->cezpdf->addText(90, 645, 8, 'GUIA DE REMISION');
                    $this->cezpdf->addText(250, 645, 8, $numero . ' Nro ' . $serie);


                    $this->cezpdf->addText(275, 585, 8, 'LISTA DE IMEIS');

                    $this->cezpdf->addText(90, 620, 8, utf8_decode_seguro($prod_nombreimei));


                    $valortotal = strlen($observacion);
                    // strlen se obtiene la longitud de caracteres
                    $exacta = round($valortotal / 112);
                    // obtiene el numero entero de la operacion
                    for ($i = 0; $i < $exacta; $i++) {
                        $this->cezpdf->addText(90, 560 - ($i * 10), 7, substr($observacion, $i * 112, 112));
                    }*/


                }


            } else {
                $datos_guiarem = $this->guiarem_model->obtener($codigo);
                $datos_detalle_guiarem = $this->guiaremdetalle_model->obtener2($codigo);
                $tipo_movimiento = $datos_guiarem[0]->TIPOMOVP_Codigo;
                $referencia = $datos_guiarem[0]->DOCUP_Codigo;
                $guiasap = $datos_guiarem[0]->GUIASAP_Codigo;
                $guiainp = $datos_guiarem[0]->GUIAINP_Codigo;
                $motivo_trans = $datos_guiarem[0]->TIPOMOVP_Codigo;
                $cliente = $datos_guiarem[0]->CLIP_Codigo;
                $proveedor = $datos_guiarem[0]->PROVP_Codigo;
                $numero_ref = $datos_guiarem[0]->GUIAREMC_NumeroRef;
                $numero_ocompra = $datos_guiarem[0]->GUIAREMC_OCompra;
                $serie = $datos_guiarem[0]->GUIAREMC_Serie;
                $numero = $datos_guiarem[0]->GUIAREMC_Numero;
                $fecha_traslado = mysql_to_human($datos_guiarem[0]->GUIAREMC_FechaTraslado);
                $observacion = $datos_guiarem[0]->GUIAREMC_Observacion;
                $marca = $datos_guiarem[0]->GUIAREMC_Marca;
                $placa = $datos_guiarem[0]->GUIAREMC_Placa;
                $registro_mtc = $datos_guiarem[0]->GUIAREMC_RegistroMTC;
                $certificado = $datos_guiarem[0]->GUIAREMC_Certificado;
                $licencia = $datos_guiarem[0]->GUIAREMC_Licencia;
                $nombre_conductor = $datos_guiarem[0]->GUIAREMC_NombreConductor;
                $punto_partida = $datos_guiarem[0]->GUIAREMC_PuntoPartida;
                $arr_punt_part = explode('/', $punto_partida);
                $punto_llegada = $datos_guiarem[0]->GUIAREMC_PuntoLlegada;
                $arr_punt_lleg = explode('/', $punto_llegada);
                $empresa_transporte = $datos_guiarem[0]->EMPRP_Codigo;
                $fecha = mysql_to_human($datos_guiarem[0]->GUIAREMC_Fecha);
                $otro_motivo = $datos_guiarem[0]->GUIAREMC_OtroMotivo;
                $total = $datos_guiarem[0]->GUIAREMC_total;
                $nombre_emprtrans = "";
                $ruc_emprtrans = "";

                $datos_moneda = $this->moneda_model->obtener($datos_guiarem[0]->MONED_Codigo);
                $moneda_nombre = (count($datos_moneda) > 0 ? $datos_moneda[0]->MONED_Descripcion : 'NUEVOS SOLES');
                $moneda_simbolo = (count($datos_moneda) > 0 ? $datos_moneda[0]->MONED_Simbolo : 'S/.');


                if ($empresa_transporte != '') {

                    $datos_emprtrans = $this->empresa_model->obtener_datosEmpresa($empresa_transporte);

                    if (count($datos_emprtrans) > 0) {

                        $ruc_emprtrans = $datos_emprtrans[0]->EMPRC_Ruc;
                        $nombre_emprtrans = $datos_emprtrans[0]->EMPRC_RazonSocial;
                    }
                }

                $mot = "";

                switch ($motivo_trans) {

                    case 1:

                        $mot = 1;

                        break;

                    case 2:

                        $mot = 0;

                        break;

                    case 3:

                        $mot = 2;

                        break;

                    case 4:

                        $mot = 4;

                        break;

                    case 5:

                        $mot = 5;

                        break;

                    case 6:

                        $mot = 6;

                        break;

                    case 7:

                        $mot = 9;

                        break;

                    case 8:

                        $mot = 13;

                        break;

                }


                $nombre_tipodoc = '';

                if ($referencia != '') {

                    $datos_doc = $this->documento_model->obtener($referencia);

                    $nombre_tipodoc = $datos_doc[0]->DOCUC_Descripcion;

                }

                /* Datos del proveedor */


                $datos_proveedor = $this->proveedor_model->obtener_proveedor_info($proveedor);
                $razon_social = utf8_decode($datos_proveedor->nombre);
                $tipo_doc = ($datos_proveedor->tipo == '0' ? 'D.N.1' : 'R.U.C.');
                $ruc = $datos_proveedor->ruc;
                $distrito_cliente = $datos_proveedor->distrito;
                $provincia_cliente = $datos_proveedor->provincia;
                $departamento_cliente = $datos_proveedor->departamento;

                $razon_social2 = '';

                if (strlen($razon_social) > 26) {
                    $razon_social2 = substr($razon_social, 0);
                    $razon_social = substr($razon_social, 0);
                }

                $nombre_emprtrans2 = '';

                if (strlen($nombre_emprtrans) > 29) {
                    $nombre_emprtrans2 = substr($nombre_emprtrans, 29);
                    $nombre_emprtrans = substr($nombre_emprtrans, 0, 29);

                }

                $otro_motivo2 = '';

                if (strlen($otro_motivo) > 18) {
                    $otro_motivo2 = substr($otro_motivo, 18);
                    $otro_motivo = substr($otro_motivo, 0, 18);
                }

                if ($img == 1) {

                    $notimg = "";

                } else {

                    $notimg = "guia_remision_proveedor.jpg";

                }

                /* Cabecera */

                $this->cezpdf = new backgroundPDF('a4', 'portrait', 'image', array('img' => 'images/img_db/' . $notimg));

                $posicionX = 0;

                $posicionY = 0;

                $this->cezpdf->addText(88, '', 9, '');

                if ($img == 0) {

                    $this->cezpdf->addText($posicionX + 440, $posicionY + 723, 18, $serie);

                    $this->cezpdf->addText($posicionX + 480, $posicionY + 723, 18, $numero);

                } else {

                    $this->cezpdf->addText($posicionX + 436, $posicionY + 745, 18, "");

                    $this->cezpdf->addText($posicionX + 480, $posicionY + 745, 18, "");

                }


                $this->cezpdf->addText($posicionX + 35, $posicionY + 639, 9, $fecha);

                //    $this->cezpdf->addText($posicionX + 70, $posicionY + 643, 9, $fecha_traslado);

                //direccion partida

                // $this->cezpdf->addText($posicionX + 90, $posicionY + 670, 8, utf8_decode_seguro(substr($arr_punt_part[0], 0, 37)));

                //direccion destino

                $direccion_destino = substr($arr_punt_lleg[0], 0, 37);

                $this->cezpdf->addText($posicionX + 75, $posicionY + 670, 8, utf8_decode_seguro(isset($direccion_destino) ? $direccion_destino : ''));

                //   $this->cezpdf->addText($posicionX + 578, $posicionY + 200, 10, utf8_decode_seguro($mot));

                $this->cezpdf->addText($posicionX + 60, $posicionY + 686, 8, "FMYSERFE S.A.C");

                $this->cezpdf->addText($posicionX + 45, $posicionY + 655, 8, "20543886671");

                //$this->cezpdf->addText($posicionX + 70, $posicionY + 658, 8, $razon_social2);

                //$this->cezpdf->addText($posicionX + 40, $posicionY + 655, 8, $ruc);


                /* Detalle */

                $db_data = array();

                if (count($datos_detalle_guiarem) > 0) {

                    foreach ($datos_detalle_guiarem as $indice => $valor) {

                        $producto = $valor->PRODCTOP_Codigo;
                        $unidad = $valor->UNDMED_Codigo;
                        $costo = $valor->GUIAREMDETC_Costo;
                        $venta = $valor->GUIAREMDETC_Venta;
                        $peso = $valor->GUIAREMDETC_Peso;
                        $descri = $valor->GUIAREMDETC_Descripcion;
                        $descri = str_replace('\\', '', $descri);
                        $datos_producto = $this->producto_model->obtener_producto($producto);
                        $datos_unidad = $this->unidadmedida_model->obtener($unidad);
                        $prod_cod = $datos_producto[0]->PROD_Codigo;
                        $prod_nombre = $datos_producto[0]->PROD_Nombre;
                        $prod_codigo = $datos_producto[0]->PROD_CodigoInterno;
                        $prod_unidad = $datos_unidad[0]->UNDMED_Simbolo;
                        $prod_cantidad = $valor->GUIAREMDETC_Cantidad;

                        //------------------------------------------------------------------------------        


                        $array_producto = explode("/", $descri);
                        $this->cezpdf->addText($posicionX + 20, $posicionY + 540, 9, $prod_unidad);
                        $this->cezpdf->addText($posicionX + 170, $posicionY + 550, 9, utf8_decode_seguro($array_producto[0]));
                        $this->cezpdf->addText($posicionX + 85, $posicionY + 540, 9, $prod_unidad);
                        $this->cezpdf->addText($posicionX + 50, $posicionY + 545, 9, $prod_cantidad);


                        //-------CCCCCC

                        if ($tipo_oper == "C") {

                            $datos_serie = $this->seriemov_model->buscar_x_guiainp($guiainp, $prod_cod);
                        } else {
                            $datos_serie = $this->seriemov_model->buscar_x_guiasap($guiasap, $prod_cod);
                        }

                        $ser = "";

                        $c = 0;

                        if (count($datos_serie) > 0) {

                            foreach ($datos_serie as $indices => $valor) {

                                $c += 1;

                                $seriecodigo = $valor->SERIC_Numero;

                                $ser = $ser . " / " . $seriecodigo;

                                if ($c == 7) {

                                    $this->cezpdf->addText(90 + $posicionX += 30, $posicionY + 620, 8, "" . $ser);

                                    $posicionY -= 10;

                                    $posicionX -= 30;

                                    $ser = "";

                                    $c = 0;

                                }

                            }

                            $this->cezpdf->addText(90 + $posicionX += 30, $posicionY + 620, 8, "" . $ser);
                            $posicionY -= 10;
                        }

                        $posicionX -= 30;
                        //--------------------- 

                        //$this->cezpdf->addText($posicionX + 10, $posicionY + 610, 9, utf8_decode_seguro($nombre_emprtrans2 != '' ? $nombre_emprtrans . '-' : $nombre_emprtrans ));
                        $this->cezpdf->addText($posicionX + 538, $posicionY + 550, 9, $moneda_simbolo . ' ' . $datos_detalle_guiarem[0]->GUIAREMDETC_Total);

                        $posicionY -= 20;
                    }
                }

                $posicionY = 0;

                $this->cezpdf->addText(494, 425, 8, $moneda_simbolo . ' ' . $total);

                // $this->cezpdf->addText(300, 500, 9, utf8_decode_seguro($ser));

                $this->cezpdf->addText(600, 700, 9, utf8_decode_seguro($nombre_emprtrans2 != '' ? $nombre_emprtrans : $nombre_emprtrans));

                $this->cezpdf->addText(400, 500, 9, utf8_decode_seguro($nombre_emprtrans2));

                $this->cezpdf->addText(47, 138, 9, $ruc_emprtrans);
                // tipo de doc= FACTURA.
                //  $this->cezpdf->addText(40, 127, 9, utf8_decode_seguro(strtoupper($nombre_tipodoc)));
                $this->cezpdf->addText(40, 115, 9, utf8_decode_seguro($numero_ref));
                $posx = 0;
                $posy = 0;
                switch ($tipo_movimiento) {

                    case 1:
                        $posx = 221;

                        $posy = 167;

                        break;

                    case 2:
                        $posx = 221;

                        $posy = 158;

                        break;

                    case 3:
                        $posx = 221;

                        $posy = 142;

                        break;

                    case 4:
                        $posx = 221;

                        $posy = 133;

                        break;

                    case 5:
                        $posx = 221;

                        $posy = 124;

                        break;

                    case 6:
                        $posx = 221;

                        $posy = 115;

                        break;

                    case 7:
                        $posx = 221;

                        $posy = 99;

                        break;

                    case 8:
                        $posx = 221;

                        $posy = 90;

                        break;

                    case 9:
                        $posx = 221;

                        $posy = 81;

                        break;

                    case 10:
                        $posx = 367;

                        $posy = 167;

                        break;

                    case 11:
                        $posx = 367;

                        $posy = 159;

                        break;

                    case 12:
                        $posx = 367;

                        $posy = 151;

                        break;

                    case 13:
                        $posx = 367;

                        $posy = 142;

                        break;

                }

                //$this->cezpdf->addText($posx, $posy, 14, 'x');
                if ($tipo_movimiento == 13) {
                    $this->cezpdf->addText(377, 136, 7, ($otro_motivo2 != '' ? $otro_motivo . '-' : $otro_motivo));
                    $this->cezpdf->addText(377, 127, 7, $otro_motivo2);
                }

                // $this->cezpdf->addText(40, 110, 10, utf8_decode_seguro('N° DE O.COMPRA:'));

                //$this->cezpdf->addText(140, 140, 10, utf8_decode_seguro($numero_ocompra));

            }


            //  $this->cezpdf->addText(70, 70, 9, utf8_decode_seguro($nombre_emprtrans2 != '' ? $nombre_emprtrans : $nombre_emprtrans));

            // $this->cezpdf->addText(70, 60, 9, utf8_decode_seguro($marca . ' ' . $placa));

            //$this->cezpdf->addText(70, 50, 9, utf8_decode_seguro($nombre_conductor . ' ' . $licencia));


            $cabecera = array('Content-Type' => 'application/pdf', 'Content-Disposition' => 'nama_file.pdf', 'Expires' => '0', 'Pragma' => 'cache', 'Cache-Control' => 'private');

            $this->cezpdf->ezStream($cabecera);

        }
//***********************************************************************************        

    }


    public function guiarem_ver_pdf_conmenbrete_formato11($codigo, $tipo_oper, $img) {

//        $this->load->library('cezpdf');
//
//        $this->load->helper('pdf_helper');
//**************************************************************************
    if($_SESSION['empresa']=='3'){
            //3 = dragon yuan
            //2 = dragoket

            if ($tipo_oper == "V") {
                $datos_guiarem = $this->guiarem_model->obtener($codigo);
                $datos_detalle_guiarem = $this->guiaremdetalle_model->obtener2($codigo);
                $tipo_movimiento = $datos_guiarem[0]->TIPOMOVP_Codigo;
                $referencia = $datos_guiarem[0]->DOCUP_Codigo;
                $guiasap = $datos_guiarem[0]->GUIASAP_Codigo;
                $guiainp = $datos_guiarem[0]->GUIAINP_Codigo;
                $motivo_trans = $datos_guiarem[0]->TIPOMOVP_Codigo;
                $cliente = $datos_guiarem[0]->CLIP_Codigo;
                $proveedor = $datos_guiarem[0]->PROVP_Codigo;
                $numero_ref = $datos_guiarem[0]->GUIAREMC_NumeroRef;
                $numero_ocompra = $datos_guiarem[0]->GUIAREMC_OCompra;
                $serie = $datos_guiarem[0]->GUIAREMC_Serie;
                $numero = $datos_guiarem[0]->GUIAREMC_Numero;
                $fecha_traslado = mysql_to_human($datos_guiarem[0]->GUIAREMC_FechaTraslado);
                $observacion = $datos_guiarem[0]->GUIAREMC_Observacion;
                $marca = $datos_guiarem[0]->GUIAREMC_Marca;
                $placa = $datos_guiarem[0]->GUIAREMC_Placa;
                $registro_mtc = $datos_guiarem[0]->GUIAREMC_RegistroMTC;
                $certificado = $datos_guiarem[0]->GUIAREMC_Certificado;
                $licencia = $datos_guiarem[0]->GUIAREMC_Licencia;
                $nombre_conductor = $datos_guiarem[0]->GUIAREMC_NombreConductor;
                $punto_partida = $datos_guiarem[0]->GUIAREMC_PuntoPartida;
                $arr_punt_part = explode('/', $punto_partida);
                $punto_llegada = $datos_guiarem[0]->GUIAREMC_PuntoLlegada;
                $arr_punt_lleg = explode('/', $punto_llegada);
                $empresa_transporte = $datos_guiarem[0]->EMPRP_Codigo;
                $fecha = mysql_to_human($datos_guiarem[0]->GUIAREMC_Fecha);
                $otro_motivo = $datos_guiarem[0]->GUIAREMC_OtroMotivo;
                $total = $datos_guiarem[0]->GUIAREMC_total;
                $datos_moneda = $this->moneda_model->obtener($datos_guiarem[0]->MONED_Codigo);
                $moneda_nombre = (count($datos_moneda) > 0 ? $datos_moneda[0]->MONED_Descripcion : 'NUEVOS SOLES');
                $moneda_simbolo = (count($datos_moneda) > 0 ? $datos_moneda[0]->MONED_Simbolo : 'S/.');
                $nombre_emprtrans = "";
                $ruc_emprtrans = "";

                if ($empresa_transporte != '') {
                    $datos_emprtrans = $this->empresa_model->obtener_datosEmpresa($empresa_transporte);
                    if (count($datos_emprtrans) > 0) {
                        $ruc_emprtrans = $datos_emprtrans[0]->EMPRC_Ruc;
                        $nombre_emprtrans = $datos_emprtrans[0]->EMPRC_RazonSocial;
                    }
                }

                $mot = "";

                switch ($motivo_trans) {
                    case 1:
                        $mot = 1;
                        break;

                    case 2:
                        $mot = 0;
                        break;

                    case 3:
                        $mot = 2;
                        break;

                    case 4:
                        $mot = 4;
                        break;

                    case 5:
                        $mot = 5;
                        break;

                    case 6:
                        $mot = 6;
                        break;

                    case 7:
                        $mot = 9;
                        break;

                    case 8:
                        $mot = 13;
                        break;

                }

                $nombre_tipodoc = '';

                if ($referencia != '') {
                    $datos_doc = $this->documento_model->obtener($referencia);
                    $nombre_tipodoc = $datos_doc[0]->DOCUC_Descripcion;
                }

                /* Datos del cliente */
                $datos_cliente = $this->cliente_model->obtener($cliente);
                $razon_social = utf8_decode($datos_cliente->nombre);
                $tipo_doc = ($datos_cliente->tipo == '0' ? 'D.N.1' : 'R.U.C.');
                $ruc = $datos_cliente->ruc;
                $distrito_cliente = $datos_cliente->distrito;
                $provincia_cliente = $datos_cliente->provincia;
                $departamento_cliente = $datos_cliente->departamento;

//            $razon_social2 = '';
//            if (strlen($razon_social) > 26) {
//                $razon_social2 = substr($razon_social, 0);
//                $razon_social = substr($razon_social, 0);
//            }

                $nombre_emprtrans2 = '';
                if (strlen($nombre_emprtrans) > 29) {
                    $nombre_emprtrans2 = substr($nombre_emprtrans, 29);
                    $nombre_emprtrans = substr($nombre_emprtrans, 0, 29);
                }

                $otro_motivo2 = '';
                if (strlen($otro_motivo) > 18) {
                    $otro_motivo2 = substr($otro_motivo, 18);
                    $otro_motivo = substr($otro_motivo, 0, 18);
                }

                if ($img == 1) {
                    $notimg = "";
                } else {
                    if($_SESSION['compania']=='3'){
                        //dragonyuan magdalenma
                        $notimg = "dragonYuan_guia_remision.jpg";
                    }else{

                        $notimg = "guia_yuan_andahuaylas.jpg";

                    }

                }

                /* Cabecera */
//            prep_pdf();
                //$this->cezpdf = new backgroundPDF('a4', 'portrait', 'image', array('img'=>'images/img_db/ferresat_fondo_guiarem.jpg'));

                if($_SESSION['compania']=='3'){
//dragon yuan mafgdalena

                    $this->cezpdf = new backgroundPDF('a4', 'portrait', 'image', array('img' => 'images/img_db/' . $notimg));
                    $posicionX = 4;
                    $posicionY = -10;
                    $this->cezpdf->addText(88, '', 9, '');

                    if ($img == 0) {
                        /* INICIO SERIE Y NUMERO DE GUIA DE REMISION */
                        $this->cezpdf->addText($posicionX +410, $posicionY +720, 18, $serie);
                        $this->cezpdf->addText($posicionX +454, $posicionY +720, 18,$numero);
                        /* FIN SERIE Y NUMERO DE GUIA DE REMISION */
                    } else {
                        $this->cezpdf->addText($posicionX + 436, $posicionY + 745, 18, "");
                        $this->cezpdf->addText($posicionX + 480, $posicionY + 745, 18, "");
                    }

                    //FECHA DE EMISION
                    $this->cezpdf->addText($posicionX + 80, $posicionY +745, 9, substr($fecha,0,2));
                    $this->cezpdf->addText($posicionX + 105, $posicionY +745, 9, substr($fecha,3,2));
                    $this->cezpdf->addText($posicionX + 143, $posicionY +745, 9, substr($fecha,8,4));
                    //FECHA DE TRASLADO
                    //$this->cezpdf->addText($posicionX + 260, $posicionY + 673, 9, $fecha_traslado);

                    //FECHA DE TRASLADO
                    $this->cezpdf->addText($posicionX + 254, $posicionY +745, 9, substr($fecha_traslado,0,2));
                    $this->cezpdf->addText($posicionX + 277, $posicionY +745, 9, substr($fecha_traslado,3,2));
                    $this->cezpdf->addText($posicionX + 310, $posicionY +745, 9, substr($fecha_traslado,8,4));

                    //DIRECCION DE PARTIDA
                    $this->cezpdf->addText($posicionX +33, $posicionY +718, 8, utf8_decode_seguro(substr($arr_punt_part[0], 0, 37)));

                    //$this->cezpdf->addText($posicionX + 62, $posicionY + 663, 8, utf8_decode_seguro(isset($arr_punt_part[1]) ? $arr_punt_part[1] . '321321321' : '9999999999999999'));

                    // DIRECCION DE DESTINO
                    $direccion_destino = substr($arr_punt_lleg[0], 0, 37);
                    $this->cezpdf->addText($posicionX +33, $posicionY +692, 8, utf8_decode_seguro(isset($direccion_destino) ? $direccion_destino : ''));
                    // NOMBRE DE EMP. TRANSPORTISTA
                    $this->cezpdf->addText($posicionX +90, $posicionY +465, 8, utf8_decode_seguro($nombre_emprtrans));

//            $this->cezpdf->addText($posicionX + 266, $posicionY + 631, 6, utf8_decode_seguro($nombre_conductor));
                    // RUC DE EMP. TRANSPORTISTA
                    $this->cezpdf->addText($posicionX +330, $posicionY +465, 8, $ruc_emprtrans);
                    // MARCA
                    $this->cezpdf->addText($posicionX +410, $posicionY +682, 7, $marca);
                    // PLACA
                    $this->cezpdf->addText($posicionX +470, $posicionY +682, 7, $placa);
                    // CERTIFICADO
                    $this->cezpdf->addText($posicionX +410, $posicionY +670, 7, $certificado);
                    // LICENCIA
                    $this->cezpdf->addText($posicionX +410, $posicionY +658, 7, $licencia);
                    // RAZON SOCIAL DEL DESTINATARIO
                    $this->cezpdf->addText($posicionX +73, $posicionY +665, 8, $razon_social);

//            $this->cezpdf->addText($posicionX + 32, $posicionY + 80, 8, $nombre_conductor);
                    // RUC DEL DESTINATARIO
                    $this->cezpdf->addText($posicionX +110, $posicionY +652, 8, $ruc);

                    // $this->cezpdf->addText($posicionX + 68, $posicionY + 616, 9, "x");

                    /* Detalle */
                    $db_data = array();
                    if (count($datos_detalle_guiarem) > 0) {
                        foreach ($datos_detalle_guiarem as $indice => $valor) {
                            $producto = $valor->PRODCTOP_Codigo;
                            $unidad = $valor->UNDMED_Codigo;
                            $costo = $valor->GUIAREMDETC_Costo;
                            $venta = $valor->GUIAREMDETC_Venta;
                            $peso = $valor->GUIAREMDETC_Peso;
                            $descri = $valor->GUIAREMDETC_Descripcion;
                            $descri = str_replace('\\', '', $descri);
                            $datos_producto = $this->producto_model->obtener_producto($producto);
                            $datos_unidad = $this->unidadmedida_model->obtener($unidad);
                            $prod_cod = $datos_producto[0]->PROD_Codigo;
                            $prod_nombre = $datos_producto[0]->PROD_Nombre;
                            $prod_codigo = $datos_producto[0]->PROD_CodigoUsuario;
                            $prod_unidad = $datos_unidad[0]->UNDMED_Descripcion;
                            $prod_cantidad = $valor->GUIAREMDETC_Cantidad;
                            //------------------------------------------------------------------------------

                            $array_producto = explode("/", $descri);

                            //$db_data[] = array(
                            //     'col1' => utf8_decode_seguro($descri),
                            //     'col2' => $prod_unidad,
                            //     'col3' => $prod_cantidad,
                            //     'col4' => ''
                            // );

                            //   $this->cezpdf->addText($posicionX + 20, $posicionY + 540, 9, $prod_unidad);
                            //stv
                            //$this->cezpdf->addText($posicionX + 28, $posicionY + 600, 6, utf8_decode_seguro($prod_codigo));
                            ///NOMBRE DE LOS PRODUCTO
                            $this->cezpdf->addText($posicionX +40, $posicionY +616, 8, utf8_decode_seguro($prod_nombre));   //$array_producto[0]
                            ///PRODUCTO UNITARIO
                            $this->cezpdf->addText($posicionX +364, $posicionY +616, 6, utf8_decode_seguro($prod_unidad));

                            //  $this->cezpdf->addText($posicionX + 85, $posicionY + 540, 9, $prod_unidad);
                            ///PRODUCTO CANTIDAD
                            $this->cezpdf->addTextWrap($posicionX + 430, $posicionY + 616, 20, 8, $prod_cantidad,'right');

                            //--------------------------
//                    if ($tipo_oper == "C") {
//                        $datos_serie = $this->seriemov_model->buscar_x_guiainp($guiainp, $prod_cod);
//                    } else {
//                        $datos_serie = $this->seriemov_model->buscar_x_guiasap($guiasap, $prod_cod);
//                    }

                            $ser = "";
                            $c = 0;
//                    if (count($datos_serie) > 0) {
//                        foreach ($datos_serie as $indices => $valor) {
//                            $c+=1;
//                            $seriecodigo = $valor->SERIC_Numero;
//                            $ser = $ser . " / " . $seriecodigo;
//                            if ($c == 7) {

//
//                                $this->cezpdf->addText(90 + $posicionX +=30, $posicionY + 620, 8, "" . $ser);
//                                $posicionY-=10;
//                                $posicionX -=30;
//                                $ser = "";
//                                $c = 0;
//                            }
//                        }

//                        $this->cezpdf->addText(90 + $posicionX +=30, $posicionY + 620, 8, "" . $ser);
//                        $posicionY-=10;

//                    }

                            //$posicionX = 0;
                            //---------------------
                            //$this->cezpdf->addText($posicionX + 10, $posicionY + 610, 9, utf8_decode_seguro($nombre_emprtrans2 != '' ? $nombre_emprtrans . '-' : $nombre_emprtrans ));
                            //$this->cezpdf->addText($posicionX + 500, $posicionY + 548, 9, $moneda_simbolo . ' ' . $valor->GUIAREMDETC_Total);



                            $posicionY-=19;
                        }
                    }

                    $posicionY = 0;

//            $this->cezpdf->addText(480, 425, 8, $moneda_simbolo . ' ' . $total);

                    // $this->cezpdf->addText(300, 500, 9, utf8_decode_seguro($ser));

                    $this->cezpdf->addText(600, 100, 9, utf8_decode_seguro($nombre_emprtrans2 != '' ? $nombre_emprtrans . ' k' : $nombre_emprtrans . ' L'));

                    //    $this->cezpdf->addText(400, 500, 9, utf8_decode_seguro($nombre_emprtrans2));

                    //  $this->cezpdf->addText(47, 138, 9, $ruc_emprtrans);

                    //   $this->cezpdf->addText(40, 127, 9, utf8_decode_seguro(strtoupper($nombre_tipodoc)));

                    //num_factura   bloqueado stv
                    //$this->cezpdf->addText(40, 115, 9, utf8_decode_seguro($numero_ref));


                    $posx = 0;

                    $posy = 0;

                    switch ($tipo_movimiento) {
                        case 1: $posx = 29;
                            $posy = 411;
                            break;

                        case 2: $posx = 29;
                            $posy = 402;
                            break;

                        case 3: $posx = 29;
                            $posy = 394;
                            break;

                        case 4: $posx = 29;
                            $posy = 387;
                            break;
                        /* es nuéstro caso */
                        case 5: $posx = 144;
                            $posy = 422;
                            break;

                        case 6: $posx = 144;
                            $posy = 414 ;
                            break;

                        case 7: $posx = 144;
                            $posy = 399;
                            break;

                        case 8: $posx = 144;
                            $posy = 390;
                            break;
//////////////////////////////////////////
                        case 9: $posx = 261;
                            $posy = 421;
                            break;

                        case 10: $posx = 261;
                            $posy = 406;
                            break;

                        case 11: $posx = 261;
                            $posy = 398;
                            break;

                        case 12: $posx = 261;
                            $posy = 390;
                            break;

                        case 13: $posx = 352;
                            $posy = 437;
                            break;

                    }

                    $this->cezpdf->addText($posx, $posy, 14, 'x');

                    /*if ($tipo_movimiento == 13) {

                        $this->cezpdf->addText(377, 136, 7, ($otro_motivo2 != '' ? $otro_motivo . '-' : $otro_motivo));

                        $this->cezpdf->addText(377, 127, 7, $otro_motivo2);

                    }*/

                    // $this->cezpdf->addText(40, 140, 10, utf8_decode_seguro('N° DE O.COMPRA:'));

                    //$this->cezpdf->addText(140, 140, 10, utf8_decode_seguro($numero_ocompra));





                }else{

                    $this->cezpdf = new backgroundPDF('a4', 'portrait', 'image', array('img' => 'images/img_db/' . $notimg));
                    $posicionX = 4;
                    $posicionY = -10;
                    $this->cezpdf->addText(88, '', 9, '');

                    if ($img == 0) {
                        /* INICIO SERIE Y NUMERO DE GUIA DE REMISION */
                        $this->cezpdf->addText($posicionX +410, $posicionY +720, 18, $serie);
                        $this->cezpdf->addText($posicionX +454, $posicionY +720, 18, $numero);
                        /* FIN SERIE Y NUMERO DE GUIA DE REMISION */
                    } else {
                        $this->cezpdf->addText($posicionX + 436, $posicionY + 745, 18, "");
                        $this->cezpdf->addText($posicionX + 480, $posicionY + 745, 18, "");
                    }

                    //FECHA DE EMISION
                    $this->cezpdf->addText($posicionX + 89, $posicionY +741, 9, substr($fecha,0,2));
                    $this->cezpdf->addText($posicionX + 115, $posicionY +741, 9, substr($fecha,3,2));
                    $this->cezpdf->addText($posicionX + 150, $posicionY +741, 9, substr($fecha,8,4));
                    //FECHA DE TRASLADO
                    //$this->cezpdf->addText($posicionX + 260, $posicionY + 673, 9, $fecha_traslado);

                    //FECHA DE TRASLADO
                    $this->cezpdf->addText($posicionX + 259, $posicionY +741, 9, substr($fecha_traslado,0,2));
                    $this->cezpdf->addText($posicionX + 282, $posicionY +741, 9, substr($fecha_traslado,3,2));
                    $this->cezpdf->addText($posicionX + 315, $posicionY +741, 9, substr($fecha_traslado,8,4));

                    //DIRECCION DE PARTIDA
                    $this->cezpdf->addText($posicionX +33, $posicionY +716, 8, utf8_decode_seguro(substr($arr_punt_part[0], 0, 37)));

                    //$this->cezpdf->addText($posicionX + 62, $posicionY + 663, 8, utf8_decode_seguro(isset($arr_punt_part[1]) ? $arr_punt_part[1] . '321321321' : '9999999999999999'));

                    // DIRECCION DE DESTINO
                    $direccion_destino = substr($arr_punt_lleg[0], 0, 37);
                    $this->cezpdf->addText($posicionX +33, $posicionY +692, 8, utf8_decode_seguro(isset($direccion_destino) ? $direccion_destino : ''));
                    // NOMBRE DE EMP. TRANSPORTISTA
                    $this->cezpdf->addText($posicionX +90, $posicionY +471, 8, utf8_decode_seguro($nombre_emprtrans));

//            $this->cezpdf->addText($posicionX + 266, $posicionY + 631, 6, utf8_decode_seguro($nombre_conductor));
                    // RUC DE EMP. TRANSPORTISTA
                    $this->cezpdf->addText($posicionX +330, $posicionY +471, 8, $ruc_emprtrans);
                    // MARCA
                    $this->cezpdf->addText($posicionX +410, $posicionY +682, 7, $marca);
                    // PLACA
                    $this->cezpdf->addText($posicionX +470, $posicionY +682, 7, $placa);
                    // CERTIFICADO
                    $this->cezpdf->addText($posicionX +410, $posicionY +670, 7, $certificado);
                    // LICENCIA
                    $this->cezpdf->addText($posicionX +410, $posicionY +658, 7, $licencia);
                    // RAZON SOCIAL DEL DESTINATARIO
                    $this->cezpdf->addText($posicionX +73, $posicionY +665, 8, $razon_social);

//            $this->cezpdf->addText($posicionX + 32, $posicionY + 80, 8, $nombre_conductor);
                    // RUC DEL DESTINATARIO
                    $this->cezpdf->addText($posicionX +110, $posicionY +652, 8, $ruc);

                    // $this->cezpdf->addText($posicionX + 68, $posicionY + 616, 9, "x");

                    /* Detalle */
                    $db_data = array();
                    if (count($datos_detalle_guiarem) > 0) {
                        foreach ($datos_detalle_guiarem as $indice => $valor) {
                            $producto = $valor->PRODCTOP_Codigo;
                            $unidad = $valor->UNDMED_Codigo;
                            $costo = $valor->GUIAREMDETC_Costo;
                            $venta = $valor->GUIAREMDETC_Venta;
                            $peso = $valor->GUIAREMDETC_Peso;
                            $descri = $valor->GUIAREMDETC_Descripcion;
                            $descri = str_replace('\\', '', $descri);
                            $datos_producto = $this->producto_model->obtener_producto($producto);
                            $datos_unidad = $this->unidadmedida_model->obtener($unidad);
                            $prod_cod = $datos_producto[0]->PROD_Codigo;
                            $prod_nombre = $datos_producto[0]->PROD_Nombre;
                            $prod_codigo = $datos_producto[0]->PROD_CodigoUsuario;
                            $prod_unidad = $datos_unidad[0]->UNDMED_Descripcion;
                            $prod_cantidad = $valor->GUIAREMDETC_Cantidad;
                            //------------------------------------------------------------------------------

                            $array_producto = explode("/", $descri);

                            //$db_data[] = array(
                            //     'col1' => utf8_decode_seguro($descri),
                            //     'col2' => $prod_unidad,
                            //     'col3' => $prod_cantidad,
                            //     'col4' => ''
                            // );

                            //   $this->cezpdf->addText($posicionX + 20, $posicionY + 540, 9, $prod_unidad);
                            //stv
                            //$this->cezpdf->addText($posicionX + 28, $posicionY + 600, 6, utf8_decode_seguro($prod_codigo));
                            ///NOMBRE DE LOS PRODUCTO
                            $this->cezpdf->addText($posicionX +40, $posicionY +616, 8, utf8_decode_seguro($prod_nombre));   //$array_producto[0]
                            ///PRODUCTO UNITARIO
                            $this->cezpdf->addText($posicionX +364, $posicionY +616, 6, utf8_decode_seguro($prod_unidad));

                            //  $this->cezpdf->addText($posicionX + 85, $posicionY + 540, 9, $prod_unidad);
                            ///PRODUCTO CANTIDAD
                            $this->cezpdf->addTextWrap($posicionX + 430, $posicionY + 616, 20, 8, $prod_cantidad,'right');

                            //--------------------------
//                    if ($tipo_oper == "C") {
//                        $datos_serie = $this->seriemov_model->buscar_x_guiainp($guiainp, $prod_cod);
//                    } else {
//                        $datos_serie = $this->seriemov_model->buscar_x_guiasap($guiasap, $prod_cod);
//                    }

                            $ser = "";
                            $c = 0;
//                    if (count($datos_serie) > 0) {
//                        foreach ($datos_serie as $indices => $valor) {
//                            $c+=1;
//                            $seriecodigo = $valor->SERIC_Numero;
//                            $ser = $ser . " / " . $seriecodigo;
//                            if ($c == 7) {

//
//                                $this->cezpdf->addText(90 + $posicionX +=30, $posicionY + 620, 8, "" . $ser);
//                                $posicionY-=10;
//                                $posicionX -=30;
//                                $ser = "";
//                                $c = 0;
//                            }
//                        }

//                        $this->cezpdf->addText(90 + $posicionX +=30, $posicionY + 620, 8, "" . $ser);
//                        $posicionY-=10;

//                    }

                            $posicionX = 0;
                            //---------------------
                            //$this->cezpdf->addText($posicionX + 10, $posicionY + 610, 9, utf8_decode_seguro($nombre_emprtrans2 != '' ? $nombre_emprtrans . '-' : $nombre_emprtrans ));
                            //$this->cezpdf->addText($posicionX + 500, $posicionY + 548, 9, $moneda_simbolo . ' ' . $valor->GUIAREMDETC_Total);



                            $posicionY-=19;
                        }
                    }

                    $posicionY = 0;

//            $this->cezpdf->addText(480, 425, 8, $moneda_simbolo . ' ' . $total);

                    // $this->cezpdf->addText(300, 500, 9, utf8_decode_seguro($ser));

                    $this->cezpdf->addText(600, 100, 9, utf8_decode_seguro($nombre_emprtrans2 != '' ? $nombre_emprtrans . ' k' : $nombre_emprtrans . ' L'));

                    //    $this->cezpdf->addText(400, 500, 9, utf8_decode_seguro($nombre_emprtrans2));

                    //  $this->cezpdf->addText(47, 138, 9, $ruc_emprtrans);

                    //   $this->cezpdf->addText(40, 127, 9, utf8_decode_seguro(strtoupper($nombre_tipodoc)));

                    //num_factura   bloqueado stv
                    //$this->cezpdf->addText(40, 115, 9, utf8_decode_seguro($numero_ref));

                    $posx = 0;

                    $posy = 0;

                    switch ($tipo_movimiento) {
                        case 1: $posx = 37;
                            $posy = 430;
                            break;

                        case 2: $posx = 37;
                            $posy = 421;
                            break;

                        case 3: $posx = 37;
                            $posy = 413;
                            break;

                        case 4: $posx = 37;
                            $posy = 406;
                            break;
                        /* es nuéstro caso */
                        case 5: $posx = 149;
                            $posy = 439;
                            break;

                        case 6: $posx = 149;
                            $posy = 431 ;
                            break;

                        case 7: $posx = 149;
                            $posy = 416;
                            break;

                        case 8: $posx = 149;
                            $posy = 407;
                            break;

                        case 9: $posx = 261;
                            $posy = 438;
                            break;

                        case 10: $posx = 262;
                            $posy = 423;
                            break;

                        case 11: $posx = 262;
                            $posy = 415;
                            break;

                        case 12: $posx = 262;
                            $posy = 407;
                            break;

                        case 13: $posx = 352;
                            $posy = 437;
                            break;

                    }

                    $this->cezpdf->addText($posx, $posy, 14, 'x');

                    /*if ($tipo_movimiento == 13) {

                        $this->cezpdf->addText(377, 136, 7, ($otro_motivo2 != '' ? $otro_motivo . '-' : $otro_motivo));

                        $this->cezpdf->addText(377, 127, 7, $otro_motivo2);

                    }*/

                    // $this->cezpdf->addText(40, 140, 10, utf8_decode_seguro('N° DE O.COMPRA:'));

                    //$this->cezpdf->addText(140, 140, 10, utf8_decode_seguro($numero_ocompra));




                    $this->cezpdf->ezText(' ', 9, array("leading" => 1200, "left" => 0));
                    $this->cezpdf->addText($posicionX + 90, $posicionY + 705, 8, 'ESTA LISTA CORRESPONDE A');
                    $this->cezpdf->addText($posicionX + 90, $posicionY + 685, 8, 'FACTURA');
                    $this->cezpdf->addText($posicionX + 90, $posicionY + 665, 8, 'BOLETA');
                    $this->cezpdf->addText($posicionX + 90, $posicionY + 645, 8, 'GUIA DE REMISION');
                    $this->cezpdf->addText($posicionX + 250, $posicionY + 645, 8, $serie);


                    $this->cezpdf->addText($posicionX+275, $posicionY+585, 8, 'LISTA DE IMEIS');

                    $valortotal=strlen($observacion);
                    // strlen se obtiene la longitud de caracteres
                    $exacta=round($valortotal/96);
                    // obtiene el numero entero de la operacion
                    for($i=0;$i<$exacta;$i++){
                        $this->cezpdf->addText($posicionX+100, $posicionY+560-($i*13), 8, substr($observacion,$i*96,96));
                    }

                }





            } else {

                $datos_guiarem = $this->guiarem_model->obtener($codigo);
                $datos_detalle_guiarem = $this->guiaremdetalle_model->obtener2($codigo);
                $tipo_movimiento = $datos_guiarem[0]->TIPOMOVP_Codigo;
                $referencia = $datos_guiarem[0]->DOCUP_Codigo;
                $guiasap = $datos_guiarem[0]->GUIASAP_Codigo;
                $guiainp = $datos_guiarem[0]->GUIAINP_Codigo;
                $motivo_trans = $datos_guiarem[0]->TIPOMOVP_Codigo;
                $cliente = $datos_guiarem[0]->CLIP_Codigo;
                $proveedor = $datos_guiarem[0]->PROVP_Codigo;
                $numero_ref = $datos_guiarem[0]->GUIAREMC_NumeroRef;
                $numero_ocompra = $datos_guiarem[0]->GUIAREMC_OCompra;
                $serie = $datos_guiarem[0]->GUIAREMC_Serie;
                $numero = $datos_guiarem[0]->GUIAREMC_Numero;
                $fecha_traslado = mysql_to_human($datos_guiarem[0]->GUIAREMC_FechaTraslado);
                $observacion = $datos_guiarem[0]->GUIAREMC_Observacion;
                $marca = $datos_guiarem[0]->GUIAREMC_Marca;
                $placa = $datos_guiarem[0]->GUIAREMC_Placa;
                $registro_mtc = $datos_guiarem[0]->GUIAREMC_RegistroMTC;
                $certificado = $datos_guiarem[0]->GUIAREMC_Certificado;
                $licencia = $datos_guiarem[0]->GUIAREMC_Licencia;
                $nombre_conductor = $datos_guiarem[0]->GUIAREMC_NombreConductor;
                $punto_partida = $datos_guiarem[0]->GUIAREMC_PuntoPartida;
                $arr_punt_lleg = explode('/', $punto_partida);
                $punto_llegada = $datos_guiarem[0]->GUIAREMC_PuntoLlegada;
                $arr_punt_part = explode('/', $punto_llegada);
                $empresa_transporte = $datos_guiarem[0]->EMPRP_Codigo;
                $fecha = mysql_to_human($datos_guiarem[0]->GUIAREMC_Fecha);
                $otro_motivo = $datos_guiarem[0]->GUIAREMC_OtroMotivo;
                $total = $datos_guiarem[0]->GUIAREMC_total;
                $nombre_emprtrans = "";
                $ruc_emprtrans = "";


                $datos_moneda = $this->moneda_model->obtener($datos_guiarem[0]->MONED_Codigo);
                $moneda_nombre = (count($datos_moneda) > 0 ? $datos_moneda[0]->MONED_Descripcion : 'NUEVOS SOLES');
                $moneda_simbolo = (count($datos_moneda) > 0 ? $datos_moneda[0]->MONED_Simbolo : 'S/.');

                if ($empresa_transporte != '') {
                    $datos_emprtrans = $this->empresa_model->obtener_datosEmpresa($empresa_transporte);
                    if (count($datos_emprtrans) > 0) {
                        $ruc_emprtrans = $datos_emprtrans[0]->EMPRC_Ruc;
                        $nombre_emprtrans = $datos_emprtrans[0]->EMPRC_RazonSocial;
                    }
                }

                $mot = "";
                switch ($motivo_trans) {

                    case 1:
                        $mot = 1;
                        break;

                    case 2:
                        $mot = 0;
                        break;

                    case 3:
                        $mot = 2;
                        break;

                    case 4:
                        $mot = 4;
                        break;

                    case 5:
                        $mot = 5;
                        break;

                    case 6:
                        $mot = 6;
                        break;

                    case 7:
                        $mot = 9;
                        break;

                    case 8:
                        $mot = 13;

                        break;

                }



                $nombre_tipodoc = '';

                if ($referencia != '') {

                    $datos_doc = $this->documento_model->obtener($referencia);

                    $nombre_tipodoc = $datos_doc[0]->DOCUC_Descripcion;

                }



                /* Datos del proveedor */



                $datos_proveedor = $this->proveedor_model->obtener_proveedor_info($proveedor);

                $razon_social = utf8_decode($datos_proveedor->nombre);

                $tipo_doc = ($datos_proveedor->tipo == '0' ? 'D.N.1' : 'R.U.C.');

                $ruc = $datos_proveedor->ruc;

                $distrito_cliente = $datos_proveedor->distrito;

                $provincia_cliente = $datos_proveedor->provincia;

                $departamento_cliente = $datos_proveedor->departamento;





                $razon_social2 = '';

                if (strlen($razon_social) > 26) {

                    $razon_social2 = substr($razon_social, 0);

                    $razon_social = substr($razon_social, 0);

                }
                $nombre_emprtrans2 = '';

                if (strlen($nombre_emprtrans) > 29) {

                    $nombre_emprtrans2 = substr($nombre_emprtrans, 29);

                    $nombre_emprtrans = substr($nombre_emprtrans, 0, 29);

                }

                $otro_motivo2 = '';

                if (strlen($otro_motivo) > 18) {

                    $otro_motivo2 = substr($otro_motivo, 18);

                    $otro_motivo = substr($otro_motivo, 0, 18);

                }



//*************************************************************************************************************
                if ($img == 1) {
                   // $notimg = "";
                    $notimg = "guia_remision.jpg";
                } else {
                    $notimg = "guia_remision.jpg";

                }


                /* Cabecera */

//            prep_pdf();

                //$this->cezpdf = new backgroundPDF('a4', 'portrait', 'image', array('img'=>'images/img_db/ferresat_fondo_guiarem.jpg'));

                $this->cezpdf = new backgroundPDF('a4', 'portrait', 'image', array('img' => 'images/img_db/' . $notimg));

                $posicionX = 0;

                $posicionY = 0;

                $this->cezpdf->addText(88, '', 9, '');

                if ($img == 0) {

                    $this->cezpdf->addText($posicionX + 430, $posicionY + 690, 18, $serie);

                    $this->cezpdf->addText($posicionX + 474, $posicionY + 690, 18, $numero);

                } else {

                    $this->cezpdf->addText($posicionX + 436, $posicionY + 745, 18, "");

                    $this->cezpdf->addText($posicionX + 480, $posicionY + 745, 18, "");

                }

                $this->cezpdf->addText($posicionX + 198, $posicionY + 670, 9, substr($fecha,0,2));

                $this->cezpdf->addText($posicionX + 230, $posicionY + 670, 9, substr($fecha,3,2));

                $this->cezpdf->addText($posicionX + 266, $posicionY + 670, 9, substr($fecha,6,4));

                //$this->cezpdf->addText($posicionX + 330, $posicionY + 673, 9, $fecha_traslado);

                //direccion partida

                $this->cezpdf->addText($posicionX + 440, $posicionY + 530, 8, utf8_decode_seguro(substr($arr_punt_part[0], 0, 37)));

//

//        $this->cezpdf->addText($posicionX + 62, $posicionY + 663, 8, utf8_decode_seguro(isset($arr_punt_part[1]) ? $arr_punt_part[1] . '321321321' : '9999999999999999'));

//

                //direccion destino

                $direccion_destino = substr($arr_punt_lleg[0], 0, 37);


                $this->cezpdf->addText($posicionX + 46, $posicionY + 530, 7, utf8_decode_seguro(isset($direccion_destino) ? $direccion_destino : ''));

                $this->cezpdf->addText($posicionX + 430, $posicionY + 554, 6, utf8_decode_seguro($nombre_emprtrans));

//            $this->cezpdf->addText($posicionX + 266, $posicionY + 631, 6, utf8_decode_seguro($nombre_conductor));

                $this->cezpdf->addText($posicionX + 430, $posicionY + 506, 8, $ruc_emprtrans);

                $this->cezpdf->addText($posicionX + 522, $posicionY + 506, 7, $placa);

//            $this->cezpdf->addText($posicionX + 390, $posicionY + 630, 7, $certificado);

                //$this->cezpdf->addText($posicionX + 396, $posicionY + 594, 7, $licencia);

//            $this->cezpdf->addText($posicionX + 260, $posicionY + 650, 7, $marca);

                $this->cezpdf->addText($posicionX + 46, $posicionY + 554, 8, $razon_social);

//            $this->cezpdf->addText($posicionX + 32, $posicionY + 80, 8, $nombre_conductor);

                $this->cezpdf->addText($posicionX + 50, $posicionY + 506, 8, $ruc);

                // $this->cezpdf->addText($posicionX + 68, $posicionY + 616, 9, "x");

                /* Detalle */

                $db_data = array();

                if (count($datos_detalle_guiarem) > 0) {

                    foreach ($datos_detalle_guiarem as $indice => $valor) {

                        $producto = $valor->PRODCTOP_Codigo;

                        $unidad = $valor->UNDMED_Codigo;

                        $costo = $valor->GUIAREMDETC_Costo;

                        $venta = $valor->GUIAREMDETC_Venta;

                        $peso = $valor->GUIAREMDETC_Peso;

                        $descri = $valor->GUIAREMDETC_Descripcion;

                        $descri = str_replace('\\', '', $descri);

                        $datos_producto = $this->producto_model->obtener_producto($producto);

                        $datos_unidad = $this->unidadmedida_model->obtener($unidad);

                        $prod_cod = $datos_producto[0]->PROD_Codigo;

                        $prod_nombre = $datos_producto[0]->PROD_Nombre;

                        $prod_codigo = $datos_producto[0]->PROD_CodigoUsuario;

                        $prod_unidad = $datos_unidad[0]->UNDMED_Descripcion;

                        $prod_cantidad = $valor->GUIAREMDETC_Cantidad;

                        //------------------------------------------------------------------------------

                        $array_producto = explode("/", $descri);

                        //$db_data[] = array(

                        //     'col1' => utf8_decode_seguro($descri),

                        //     'col2' => $prod_unidad,

                        //     'col3' => $prod_cantidad,

                        //     'col4' => ''

                        // );

                        //   $this->cezpdf->addText($posicionX + 20, $posicionY + 540, 9, $prod_unidad);
                        //stv
                        //$this->cezpdf->addText($posicionX + 28, $posicionY + 600, 6, utf8_decode_seguro($prod_codigo));
                        ///$prod_unidad
                        $this->cezpdf->addText($posicionX + 100, $posicionY + 450, 8, utf8_decode_seguro($prod_nombre));   //$array_producto[0]


                        ///stv
                        $this->cezpdf->addText($posicionX + 52, $posicionY + 450, 6, utf8_decode_seguro($prod_unidad));

                        ///

                        //  $this->cezpdf->addText($posicionX + 85, $posicionY + 540, 9, $prod_unidad);

                        $this->cezpdf->addText($posicionX + 22, $posicionY + 450, 9, $prod_cantidad);

                        //--------------------------

//                    if ($tipo_oper == "C") {

//                        $datos_serie = $this->seriemov_model->buscar_x_guiainp($guiainp, $prod_cod);

//                    } else {

//                        $datos_serie = $this->seriemov_model->buscar_x_guiasap($guiasap, $prod_cod);

//                    }

                        $ser = "";

                        $c = 0;

//                    if (count($datos_serie) > 0) {

//                        foreach ($datos_serie as $indices => $valor) {

//                            $c+=1;

//                            $seriecodigo = $valor->SERIC_Numero;

//                            $ser = $ser . " / " . $seriecodigo;

//                            if ($c == 7) {

//

//                                $this->cezpdf->addText(90 + $posicionX +=30, $posicionY + 620, 8, "" . $ser);

//                                $posicionY-=10;

//                                $posicionX -=30;

//                                $ser = "";

//                                $c = 0;

//                            }

//                        }

//                        $this->cezpdf->addText(90 + $posicionX +=30, $posicionY + 620, 8, "" . $ser);

//

//                        $posicionY-=10;

//                    }

                        $posicionX = 0;



                        //---------------------

                        //$this->cezpdf->addText($posicionX + 10, $posicionY + 610, 9, utf8_decode_seguro($nombre_emprtrans2 != '' ? $nombre_emprtrans . '-' : $nombre_emprtrans ));



//                    $this->cezpdf->addText($posicionX + 500, $posicionY + 548, 9, $moneda_simbolo . ' ' . $valor->GUIAREMDETC_Total);



                        $posicionY-=16;

                    }

                }

                $posicionY = 0;

//            $this->cezpdf->addText(480, 425, 8, $moneda_simbolo . ' ' . $total);

                // $this->cezpdf->addText(300, 500, 9, utf8_decode_seguro($ser));

                $this->cezpdf->addText(600, 100, 9, utf8_decode_seguro($nombre_emprtrans2 != '' ? $nombre_emprtrans . ' k' : $nombre_emprtrans . ' L'));

                //    $this->cezpdf->addText(400, 500, 9, utf8_decode_seguro($nombre_emprtrans2));

                //  $this->cezpdf->addText(47, 138, 9, $ruc_emprtrans);

                //   $this->cezpdf->addText(40, 127, 9, utf8_decode_seguro(strtoupper($nombre_tipodoc)));

                //num_factura   bloqueado stv
                //$this->cezpdf->addText(40, 115, 9, utf8_decode_seguro($numero_ref));

                $posx = 0;

                $posy = 0;

                switch ($tipo_movimiento) {

                    case 1: $posx = 68;

                        $posy = 616;

                        break;

                    case 2: $posx = 68;

                        $posy = 616;

                        break;

                    case 3: $posx = 68;

                        $posy = 595;

                        break;

                    case 4: $posx = 195;

                        $posy = 616;

                        break;

                    case 5: $posx = 383;

                        $posy = 616;

                        break;

                    case 6: $posx = 383;

                        $posy = 584;

                        break;

                    case 7: $posx = 195;

                        $posy = 595;

                        break;

                    case 8: $posx = 560;

                        $posy = 584;

                        break;

                    case 9: $posx = 560;

                        $posy = 616;

                        break;

                    case 10: $posx = 560;

                        $posy = 584;

                        break;

                    case 11: $posx = 560;

                        $posy = 584;

                        break;

                    case 12: $posx = 560;

                        $posy = 584;

                        break;

                    case 13: $posx = 560;

                        $posy = 584;

                        break;

                }

                $this->cezpdf->addText($posx, $posy, 14, 'x');

            }

            //  $this->cezpdf->addText(70, 70, 9, utf8_decode_seguro($nombre_emprtrans2 != '' ? $nombre_emprtrans : $nombre_emprtrans));

            // $this->cezpdf->addText(70, 60, 9, utf8_decode_seguro($marca . ' ' . $placa));

            //$this->cezpdf->addText(70, 50, 9, utf8_decode_seguro($nombre_conductor . ' ' . $licencia));





            $cabecera = array('Content-Type' => 'application/pdf', 'Content-Disposition' => 'nama_file.pdf', 'Expires' => '0', 'Pragma' => 'cache', 'Cache-Control' => 'private');

            $this->cezpdf->ezStream($cabecera);




        }else{
//DRAGOTEK
//        $this->load->library('cezpdf');
//
//        $this->load->helper('pdf_helper');
            //02-08-2016
            if ($tipo_oper == "V") {
                //$codigo=5;
                $datos_guiarem = $this->guiarem_model->obtener($codigo);

                $datos_detalle_guiarem = $this->guiaremdetalle_model->obtener2($codigo);

                $tipo_movimiento = $datos_guiarem[0]->TIPOMOVP_Codigo;

                $referencia = $datos_guiarem[0]->DOCUP_Codigo;

                $guiasap = $datos_guiarem[0]->GUIASAP_Codigo;

                $guiainp = $datos_guiarem[0]->GUIAINP_Codigo;

                $motivo_trans = $datos_guiarem[0]->TIPOMOVP_Codigo;

                $cliente = $datos_guiarem[0]->CLIP_Codigo;

                $proveedor = $datos_guiarem[0]->PROVP_Codigo;

                $numero_ref = $datos_guiarem[0]->GUIAREMC_NumeroRef;

                $numero_ocompra = $datos_guiarem[0]->GUIAREMC_OCompra;

                $serie = $datos_guiarem[0]->GUIAREMC_Serie;

                $numero = $datos_guiarem[0]->GUIAREMC_Numero;

                $fecha_traslado = mysql_to_human($datos_guiarem[0]->GUIAREMC_FechaTraslado);

                $observacion = $datos_guiarem[0]->GUIAREMC_Observacion;

                $marca = $datos_guiarem[0]->GUIAREMC_Marca;

                $placa = $datos_guiarem[0]->GUIAREMC_Placa;

                $registro_mtc = $datos_guiarem[0]->GUIAREMC_RegistroMTC;

                $certificado = $datos_guiarem[0]->GUIAREMC_Certificado;

                $licencia = $datos_guiarem[0]->GUIAREMC_Licencia;

                $nombre_conductor = $datos_guiarem[0]->GUIAREMC_NombreConductor;

                $punto_partida = $datos_guiarem[0]->GUIAREMC_PuntoPartida;

                $arr_punt_part = explode('-', $punto_partida);
                $a=$arr_punt_part[3];
                $a1=$arr_punt_part[2];
                $a2=$arr_punt_part[1];
                $a3=$arr_punt_part[0];
                $punto_llegada = $datos_guiarem[0]->GUIAREMC_PuntoLlegada;

                $arr_punt_lleg = explode('-', $punto_llegada);
                $b=$arr_punt_lleg[3];
                $b1=$arr_punt_lleg[2];
                $b2=$arr_punt_lleg[1];
                $b3=$arr_punt_lleg[0];

                $empresa_transporte = $datos_guiarem[0]->EMPRP_Codigo;

                $fecha = mysql_to_human($datos_guiarem[0]->GUIAREMC_Fecha);

                $otro_motivo = $datos_guiarem[0]->GUIAREMC_OtroMotivo;

                $total = $datos_guiarem[0]->GUIAREMC_total;

                $almacen = $datos_guiarem[0]->ALMAP_Codigo;

                $datos_moneda = $this->moneda_model->obtener($datos_guiarem[0]->MONED_Codigo);

                $moneda_nombre = (count($datos_moneda) > 0 ? $datos_moneda[0]->MONED_Descripcion : 'NUEVOS SOLES');

                $moneda_simbolo = (count($datos_moneda) > 0 ? $datos_moneda[0]->MONED_Simbolo : 'S/.');

                $nombre_emprtrans = "";

                $ruc_emprtrans = "";

                if ($empresa_transporte != '') {

                    $datos_emprtrans = $this->empresa_model->obtener_datosEmpresa($empresa_transporte);

                    if (count($datos_emprtrans) > 0) {

                        $ruc_emprtrans = $datos_emprtrans[0]->EMPRC_Ruc;

                        $nombre_emprtrans = $datos_emprtrans[0]->EMPRC_RazonSocial;

                    }

                }

                $mot = "";

                switch ($motivo_trans) {

                    case 1:

                        $mot = 1;

                        break;

                    case 2:

                        $mot = 0;

                        break;

                    case 3:

                        $mot = 2;

                        break;

                    case 4:

                        $mot = 4;

                        break;

                    case 5:

                        $mot = 5;

                        break;

                    case 6:

                        $mot = 6;

                        break;

                    case 7:

                        $mot = 9;

                        break;

                    case 8:

                        $mot = 13;

                        break;

                }

                $nombre_tipodoc = '';

                if ($referencia != '') {

                    $datos_doc = $this->documento_model->obtener($referencia);

                    $nombre_tipodoc = $datos_doc[0]->DOCUC_Descripcion;

                }

                /* Datos del cliente */

                $datos_cliente = $this->cliente_model->obtener($cliente);

                $razon_social = utf8_decode($datos_cliente->nombre);

                $tipo_doc = ($datos_cliente->tipo == '0' ? 'D.N.1' : 'R.U.C.');

                $ruc = $datos_cliente->ruc;

                $distrito_cliente = $datos_cliente->distrito;

                $provincia_cliente = $datos_cliente->provincia;

                $departamento_cliente = $datos_cliente->departamento;

//            $razon_social2 = '';

//            if (strlen($razon_social) > 26) {

//                $razon_social2 = substr($razon_social, 0);

//                $razon_social = substr($razon_social, 0);

//            }

                $nombre_emprtrans2 = '';

                if (strlen($nombre_emprtrans) > 29) {

                    $nombre_emprtrans2 = substr($nombre_emprtrans, 29);

                    $nombre_emprtrans = substr($nombre_emprtrans, 0, 29);

                }

                $otro_motivo2 = '';

                if (strlen($otro_motivo) > 18) {

                    $otro_motivo2 = substr($otro_motivo, 18);

                    $otro_motivo = substr($otro_motivo, 0, 18);

                }





                if($_SESSION['compania']=='2'){
//2 = TIENDA MESA REDONDA

                    if ($img == 1) {
                        $notimg = "";
                    } else {
                        $notimg = "guia_tek_anda.jpg";
                    }

                    /* Cabecera */

//            prep_pdf(); -



                    //$this->cezpdf = new backgroundPDF('a4', 'portrait', 'image', array('img'=>'images/img_db/ferresat_fondo_guiarem.jpg'));

                    $this->cezpdf = new backgroundPDF('a4', 'portrait', 'image', array('img' => 'images/img_db/' . $notimg));

                    $posicionX = 18;
                    $posicionY = -10;

                    $this->cezpdf->addText(88, '', 9, '');


                    if ($img == 0) {

                        $this->cezpdf->addTextWrap($posicionX + 380, $posicionY + 707,200, 22, $serie."/");
                        $this->cezpdf->addTextWrap($posicionX + 455, $posicionY + 707,200, 22, $numero);

                    } else {
                        
                        $this->cezpdf->addText($posicionX + 436, $posicionY + 745, 18, "$serie");
                        $this->cezpdf->addText($posicionX + 480, $posicionY + 745, 18, "$numero");
                    }


                    $this->cezpdf->addTextWrap($posicionX + 60, $posicionY + 20,200, 9, substr($fecha,0,2));
                    $this->cezpdf->addTextWrap($posicionX + 80, $posicionY + 690,200, 9, substr($fecha,3,2));
                    $this->cezpdf->addTextWrap($posicionX + 100, $posicionY + 690,200, 9, substr($fecha,8,2));

                    //$this->cezpdf->addText($posicionX + 330, $posicionY + 673, 9, $fecha_traslado);

                    //direccion partida

                  $this->cezpdf->addTextWrap($posicionX + 35, $posicionY + 643,200, 8, utf8_decode_seguro(substr($a3, 0, 37)));
                    $this->cezpdf->addTextWrap($posicionX + 35, $posicionY + 615,200, 8, utf8_decode_seguro(substr($a2, 0, 37)));
                    $this->cezpdf->addTextWrap($posicionX + 130, $posicionY + 615,200, 8, utf8_decode_seguro(substr($a1, 0, 37)));
                    $this->cezpdf->addTextWrap($posicionX + 210, $posicionY + 615,200, 8, utf8_decode_seguro(substr($a, 0, 37)));

//

//        $this->cezpdf->addText($posicionX + 62, $posicionY + 663, 8, utf8_decode_seguro(isset($arr_punt_part[1]) ? $arr_punt_part[1] . '321321321' : '9999999999999999'));

//

                    //direccion destino

                     // $direccion_destino = substr($arr_punt_lleg[0], 0, 37);

                    //$this->cezpdf->addTextWrap($posicionX + 300, $posicionY + 645,200, 7, utf8_decode_seguro(isset($direccion_destino) ? $direccion_destino : ''));

                    $this->cezpdf->addTextWrap($posicionX + 320, $posicionY + 643,200, 7, utf8_decode_seguro(substr($b3, 0, 37)));
                    $this->cezpdf->addTextWrap($posicionX + 320, $posicionY + 615,200, 7, utf8_decode_seguro(substr($b2, 0, 37)));
                    $this->cezpdf->addTextWrap($posicionX + 420, $posicionY + 615,200, 7, utf8_decode_seguro(substr($b1, 0, 37)));
                    $this->cezpdf->addTextWrap($posicionX + 500, $posicionY + 615,200, 7, utf8_decode_seguro(substr($b, 0, 37)));


                    //empresa de transporte
                    $this->cezpdf->addText($posicionX + 85, $posicionY + 123, 7, utf8_decode_seguro($nombre_emprtrans));
                    $this->cezpdf->addTextWrap($posicionX+350, $posicionY + 690,35, 9, $nombre_emprtrans,'right');
                    $this->cezpdf->addText($posicionX+350, $posicionY + 690, 14, $nombre_emprtrans);
                    //$this->cezpdf->addText($posicionX + 266, $posicionY + 100, 6, utf8_decode_seguro($nombre_conductor));

                    $this->cezpdf->addTextWrap($posicionX + 340, $posicionY + 123,200, 8, $ruc_emprtrans);
//            $this->cezpdf->addTextWrap($posicionX + 489, $posicionY + 689,200, 7, $placa);


                    $this->cezpdf->addTextWrap($posicionX + 412, $posicionY + 580,200, 7, utf8_decode($marca." / ".$placa));
                    $this->cezpdf->addTextWrap($posicionX + 418, $posicionY + 560,200, 7, $certificado);
                    $this->cezpdf->addTextWrap($posicionX + 412, $posicionY + 540,200, 7, $licencia);
//Destinatario
                    $this->cezpdf->addText($posicionX + 130, $posicionY + 580, 8, $razon_social);
//          $this->cezpdf->addText($posicionX + 32, $posicionY + 80, 8, $nombre_conductor);
                    $this->cezpdf->addText($posicionX + 60, $posicionY + 540, 8, $ruc);
//          $this->cezpdf->addText($posicionX + 68, $posicionY + 616, 9, "x");

                    /* Detalle */

                    $db_data = array();

                    if (count($datos_detalle_guiarem) > 0) {
                        $i=1;
                        foreach ($datos_detalle_guiarem as $valor) {

                            $producto = $valor->PRODCTOP_Codigo;

                            $unidad = $valor->UNDMED_Codigo;

                            $costo = $valor->GUIAREMDETC_Costo;

                            $venta = $valor->GUIAREMDETC_Venta;

                            $peso = $valor->GUIAREMDETC_Peso;

                            $descri = $valor->GUIAREMDETC_Descripcion;

                            $descri = str_replace('\\', '', $descri);

                            $datos_producto = $this->producto_model->obtener_producto($producto);

                            $datos_unidad = $this->unidadmedida_model->obtener($unidad);

                            $prod_cod = $datos_producto[0]->PROD_Codigo;

                            $prod_nombre = $datos_producto[0]->PROD_Nombre;

                            $prod_codigo = $datos_producto[0]->PROD_CodigoUsuario;

                            $prod_unidad = $datos_unidad[0]->UNDMED_Descripcion;

                            $prod_cantidad = $valor->GUIAREMDETC_Cantidad;

                            //------------------------------------------------------------------------------

                            $array_producto = explode("/", $descri);


                            //$db_data[] = array(

                            //     'col1' => utf8_decode_seguro($descri),

                            //     'col2' => $prod_unidad,

                            //     'col3' => $prod_cantidad,

                            //     'col4' => ''

                            // );

                            //   $this->cezpdf->addText($posicionX + 20, $posicionY + 540, 9, $prod_unidad);
                            //stv
                            //$this->cezpdf->addText($posicionX + 28, $posicionY + 600, 6, utf8_decode_seguro($prod_codigo));
                            ///$prod_unidad
                            //$this->cezpdf->addText($posicionX + 20, $posicionY + 490, 8, utf8_decode_seguro($prod_nombre));   //$array_producto[0]
                            ///stv
                            //$this->cezpdf->addText($posicionX + 400, $posicionY + 490, 6, utf8_decode_seguro($prod_unidad));
                            ///
                            // $this->cezpdf->addText($posicionX + 85, $posicionY + 540, 9, $prod_unidad);

                            $this->cezpdf->addTextWrap($posicionX-15, $posicionY + 490,35, 9, $i,'right');
                            $this->cezpdf->addTextWrap($posicionX+350, $posicionY + 490,35, 9, $prod_cantidad,'right');
                            $this->cezpdf->addTextWrap($posicionX+50, $posicionY + 490,200, 9, $prod_nombre,'left');
                            $this->cezpdf->addTextWrap($posicionX+440, $posicionY + 490,200, 9, $prod_unidad,'right');



                            $ser = "";

                            $c = 0;

//
//                    }





                            $posicionY-=24;
                            $i++;
                        }

                    }

                    $posicionY = 0;

//            $this->cezpdf->addText(480, 425, 8, $moneda_simbolo . ' ' . $total);

                    // $this->cezpdf->addText(300, 500, 9, utf8_decode_seguro($ser));

                    $this->cezpdf->addText(600, 100, 9, utf8_decode_seguro($nombre_emprtrans2 != '' ? $nombre_emprtrans . ' k' : $nombre_emprtrans . ' L'));

                    //    $this->cezpdf->addText(400, 500, 9, utf8_decode_seguro($nombre_emprtrans2));

                    //  $this->cezpdf->addText(47, 138, 9, $ruc_emprtrans);

                    //   $this->cezpdf->addText(40, 127, 9, utf8_decode_seguro(strtoupper($nombre_tipodoc)));

                    //num_factura   bloqueado stv
                    //$this->cezpdf->addText(40, 115, 9, utf8_decode_seguro($numero_ref));

                    $posx = 0;

                    $posy = 0;

                    switch ($tipo_movimiento) {

                        case 1: $posx = 55;
                            $posy = 70;
                            break;

                        case 2: $posx = 55;
                            $posy = 62;
                            break;

                        case 3: $posx = 55;
                            $posy = 54;
                            break;

                        case 4: $posx = 55;
                            $posy = 46;
                            break;

                        case 5: $posx = 165;
                            $posy = 81;
                            break;

                        case 6: $posx = 165;
                            $posy = 71;
                            break;

                        case 7: $posx = 165;
                            $posy = 56;
                            break;

                        case 8: $posx = 165;
                            $posy = 46;
                            break;

                        case 9: $posx = 275;
                            $posy = 80;
                            break;

                        case 10: $posx = 276;
                            $posy = 64;
                            break;

                        case 11: $posx = 276;
                            $posy = 55;
                            break;

                        case 12: $posx = 277;
                            $posy = 46;
                            break;

                        case 13: $posx = 367;
                            $posy = 78;
                            break;

                    }

                    $this->cezpdf->addText($posx +390, $posy-10, 14, 'x');





                    /*            if ($tipo_oper == "V") {
                                $datos_guiarem = $this->guiarem_model->obtener($codigo);
                                $datos_detalle_guiarem = $this->guiaremdetalle_model->obtener2($codigo);
                                $tipo_movimiento = $datos_guiarem[0]->TIPOMOVP_Codigo;


                                $this->cezpdf = new backgroundPDF('a4', 'portrait', 'image', array('img' => 'images/img_db/' . $notimg));
                                $posicionX = 18;
                                $posicionY = -10;

                                $this->cezpdf->addText(88, '', 9, '');
                                if ($img == 0) {
                                    $this->cezpdf->addText($posicionX + 350, $posicionY + 720, 18, $serie);
                                    $this->cezpdf->addText($posicionX + 455, $posicionY + 720, 18, $numero);
                                } else {
                                    $this->cezpdf->addText($posicionX + 436, $posicionY + 745, 18, "");
                                    $this->cezpdf->addText($posicionX + 480, $posicionY + 745, 18, "");
                                }*/



//            $this->cezpdf->ezText(' ', 9, array("leading" => 1200, "left" => 0));
//            $this->cezpdf->addText($posicionX + 90, $posicionY + 705, 8, 'ESTA LISTA CORRESPONDE A');
//            $this->cezpdf->addText($posicionX + 90, $posicionY + 685, 8, 'FACTURA');
//            $this->cezpdf->addText($posicionX + 90, $posicionY + 665, 8, 'BOLETA');
//            $this->cezpdf->addText($posicionX + 90, $posicionY + 645, 8, 'GUIA DE REMISION');
//            $this->cezpdf->addText($posicionX + 250, $posicionY + 645, 8, $serie);
//
//
//            $this->cezpdf->addText($posicionX+275, $posicionY+585, 8, 'LISTA DE IMEIS');

                    $valortotal=strlen($observacion);
                    // strlen se obtiene la longitud de caracteres
                    $exacta=round($valortotal/96);
                    // obtiene el numero entero de la operacion
                    for($i=0;$i<$exacta;$i++){
                        $this->cezpdf->addText($posicionX+100, $posicionY+560-($i*13), 8, substr($observacion,$i*96,96));
                    }


                    /*            if (count($datos_detalle_guiarem) > 0) {

                                    foreach ($observacion as $indice => $valor_obser) {

                                        $producto = $valor_obser->PRODCTOP_Codigo;*/





                    /*
                                $posx = 0;

                                $posy = 0;

                                switch ($tipo_movimiento) {

                                    case 1: $posx = 55;
                                        $posy = 70;
                                        break;

                                    case 2: $posx = 55;
                                        $posy = 62;
                                        break;

                                    case 3: $posx = 55;
                                        $posy = 54;
                                        break;

                                }

                                $this->cezpdf->addText($posx, $posy, 14, 'x');*/






                } else {
//2 = TIENDA MESA REDONDA GUIA PDF
                    //03-08-2016
                    if ($img == 1) {
                        $notimg = "guia_tek_anda.jpg";
                    } else {
                        $notimg = "guia_tek_anda.jpg";
                    }

                    /* Cabecera */

//            prep_pdf();

                    //$this->cezpdf = new backgroundPDF('a4', 'portrait', 'image', array('img'=>'images/img_db/ferresat_fondo_guiarem.jpg'));

                    $this->cezpdf = new backgroundPDF('a4', 'portrait', 'image', array('img' => 'images/img_db/' . $notimg));

            //$this->cezpdf->addText(200,200,110,'HOfdgfdLAAAA');
            $posiciongeneralx = 0;
                    $posiciongeneraly = -2;
                    $posicionX = 18;
                    $posicionY = -10;

                    $this->cezpdf->addText(88, '', 9, '');


                    if ($img == 0) {
    //GUIAREM VENTA SERIE NUMERO PDF
                        //02-08-2016
                        $this->cezpdf->addTextWrap($posicionX + 370, $posicionY + 720,200, 20, $serie."-");
                        $this->cezpdf->addTextWrap($posicionX + 410, $posicionY + 720,200, 20,$this->getOrderNumeroSerie($numero));

                    } else {

                        $this->cezpdf->addText($posicionX + 436, $posicionY + 745, 18, "$serie");
                        $this->cezpdf->addText($posicionX + 480, $posicionY + 745, 18, "$numero");
                    }


                //codigo de pdf de venta para la pos\
                    //GUIA PDF FECHA 
                $this->cezpdf->addTextWrap($posicionX + 120, $posicionY + 679,200, 9, 
                    substr($fecha,0,2).' / ');
                $this->cezpdf->addTextWrap($posicionX + 137, $posicionY + 679,200, 9,
                 substr($fecha,3,2).' / ');
                 $this->cezpdf->addTextWrap($posicionX + 155, $posicionY + 679,200, 9, 
                    substr($fecha,8,2));

                    //$this->cezpdf->addText($posicionX + 330, $posicionY + 673, 9, $fecha_traslado);

                    //direccion partida

                   $this->cezpdf->addTextWrap($posicionX + 80, $posicionY + 617,200, 7, utf8_decode_seguro(substr($a3, 0, 37)));
                    $this->cezpdf->addTextWrap($posicionX + 3, $posicionY + 617,200, 7, utf8_decode_seguro(substr($a2, 0, 37)));

                    $this->cezpdf->addTextWrap($posicionX + 130, $posicionY + 607,200, 8, utf8_decode_seguro(substr($a1, 0, 37)));
                    $this->cezpdf->addTextWrap($posicionX + 200, $posicionY + 607,200, 8, utf8_decode_seguro(substr($a, 0, 37)));

//

//        $this->cezpdf->addText($posicionX + 62, $posicionY + 663, 8, utf8_decode_seguro(isset($arr_punt_part[1]) ? $arr_punt_part[1] . '321321321' : '9999999999999999'));

//

                    //direccion destino pdf
                    $direccion_destino = substr($arr_punt_lleg[0], 0, 37);
                   $this->cezpdf->addTextWrap($posicionX + 280, $posicionY + 617,200, 7, utf8_decode_seguro(isset($direccion_destino) ? $direccion_destino : ''));

                    //DIRECCION DE DOMI
                    //$this->cezpdf->addTextWrap($posicionX + 320, $posicionY + 600,200, 7, utf8_decode_seguro(substr($b3, 0, 37)));
                    $this->cezpdf->addTextWrap($posicionX + 400, $posicionY + 607,200, 7, utf8_decode_seguro(substr($b2, 0, 37)));
                    $this->cezpdf->addTextWrap($posicionX + 490, $posicionY + 607,200, 7, utf8_decode_seguro(substr($b1, 0, 37)));
                    $this->cezpdf->addTextWrap($posicionX + 500, $posicionY + 660,200, 7, utf8_decode_seguro(substr($b, 0, 37)));


                    //empresa de transporte
                    $this->cezpdf->addText($posicionX + 85, $posicionY + 123, 7, utf8_decode_seguro($nombre_emprtrans));
                    $this->cezpdf->addTextWrap($posicionX+350, $posicionY + 690,35, 9, $nombre_emprtrans,'right');
                    $this->cezpdf->addText($posicionX+350, $posicionY + 690, 14, $nombre_emprtrans);
                    //$this->cezpdf->addText($posicionX + 266, $posicionY + 100, 6, utf8_decode_seguro($nombre_conductor));

                    $this->cezpdf->addTextWrap($posicionX + 340, $posicionY + 123,200, 8, $ruc_emprtrans);
        //            $this->cezpdf->addTextWrap($posicionX + 489, $posicionY + 689,200, 7, $placa);


                    $this->cezpdf->addTextWrap($posicionX + 370, $posicionY + 566,200, 7, utf8_decode($marca." / ".$placa));
                    $this->cezpdf->addTextWrap($posicionX + 150, $posicionY + 595,200, 7, $certificado);
                    $this->cezpdf->addTextWrap($posicionX + 150, $posicionY + 583,200, 7, $licencia);
//Destinatario quia de remision venta pdf
                    $this->cezpdf->addText($posicionX +10, $posicionY + 550, 8, $razon_social);
//         $this->cezpdf->addText($posicionX + 32, $posicionY + 80, 8, $nombre_conductor);
                    $this->cezpdf->addText($posicionX + 18, $posicionY + 532, 8, $ruc);
//          $this->cezpdf->addText($posicionX + 68, $posicionY + 616, 9, "x");

                    /* Detalle */

                    $db_data = array();

                    if (count($datos_detalle_guiarem) > 0) {
                        $i=1;
                        foreach ($datos_detalle_guiarem as $valor) {

                            $producto = $valor->PRODCTOP_Codigo;

                            $unidad = $valor->UNDMED_Codigo;

                            $costo = $valor->GUIAREMDETC_Costo;

                            $venta = $valor->GUIAREMDETC_Venta;

                            $peso = $valor->GUIAREMDETC_Peso;

                            $descri = $valor->GUIAREMDETC_Descripcion;

                            $descri = str_replace('\\', '', $descri);

                            $datos_producto = $this->producto_model->obtener_producto($producto);

                            $datos_unidad = $this->unidadmedida_model->obtener($unidad);

                            $prod_cod = $datos_producto[0]->PROD_Codigo;

                            $prod_nombre = $datos_producto[0]->PROD_Nombre;

                            $prod_codigo = $datos_producto[0]->PROD_CodigoUsuario;

                            $prod_unidad = $datos_unidad[0]->UNDMED_Descripcion;

                            $prod_cantidad = $valor->GUIAREMDETC_Cantidad;

                            //------------------------------------------------------------------------------

                            $array_producto = explode("/", $descri);

                            //$db_data[] = array(

                            //     'col1' => utf8_decode_seguro($descri),

                            //     'col2' => $prod_unidad,

                            //     'col3' => $prod_cantidad,

                            //     'col4' => ''

                            // );

                            //   $this->cezpdf->addText($posicionX + 20, $posicionY + 540, 9, $prod_unidad);
                            //stv
                            //$this->cezpdf->addText($posicionX + 28, $posicionY + 600, 6, utf8_decode_seguro($prod_codigo));
                            ///$prod_unidad
                            //$this->cezpdf->addText($posicionX + 20, $posicionY + 490, 8, utf8_decode_seguro($prod_nombre));   //$array_producto[0]
                            ///stv
                            //$this->cezpdf->addText($posicionX + 400, $posicionY + 490, 6, utf8_decode_seguro($prod_unidad));
                            ///
                            // $this->cezpdf->addText($posicionX + 85, $posicionY + 540, 9, $prod_unidad);

                            $this->cezpdf->addTextWrap($posicionX-10, $posicionY + 490,35, 9, $i,'right');
                            $this->cezpdf->addTextWrap($posicionX+400, $posicionY + 490,35, 9, $prod_cantidad,'right');
                            $this->cezpdf->addTextWrap($posicionX+120, $posicionY + 490,200, 9, $prod_nombre,'left');
                            $this->cezpdf->addTextWrap($posicionX+270, $posicionY + 490,200, 9, $prod_unidad,'right');



                            $ser = "";

                            $c = 0;

//
//                    }





                            $posicionY-=24;
                            $i++;
                        }

                    }

                    $posicionY = 0;

//            $this->cezpdf->addText(480, 425, 8, $moneda_simbolo . ' ' . $total);

                    // $this->cezpdf->addText(300, 500, 9, utf8_decode_seguro($ser));

                    $this->cezpdf->addText(600, 100, 9, utf8_decode_seguro($nombre_emprtrans2 != '' ? $nombre_emprtrans . ' k' : $nombre_emprtrans . ' L'));

                    //    $this->cezpdf->addText(400, 500, 9, utf8_decode_seguro($nombre_emprtrans2));

                    //  $this->cezpdf->addText(47, 138, 9, $ruc_emprtrans);

                    //   $this->cezpdf->addText(40, 127, 9, utf8_decode_seguro(strtoupper($nombre_tipodoc)));

                    //num_factura   bloqueado stv
                    //$this->cezpdf->addText(40, 115, 9, utf8_decode_seguro($numero_ref));

                    $posx = 0;

                    $posy = 0;

                    switch ($tipo_movimiento) {

                        case 1: $posx = 55;
                            $posy = 70;
                            break;

                        case 2: $posx = 55;
                            $posy = 62;
                            break;

                        case 3: $posx = 55;
                            $posy = 54;
                            break;

                        case 4: $posx = 55;
                            $posy = 46;
                            break;

                        case 5: $posx = 165;
                            $posy = 81;
                            break;

                        case 6: $posx = 165;
                            $posy = 71;
                            break;

                        case 7: $posx = 165;
                            $posy = 56;
                            break;

                        case 8: $posx = 165;
                            $posy = 46;
                            break;

                        case 9: $posx = 275;
                            $posy = 80;
                            break;

                        case 10: $posx = 276;
                            $posy = 64;
                            break;

                        case 11: $posx = 276;
                            $posy = 55;
                            break;

                        case 12: $posx = 277;
                            $posy = 46;
                            break;

                        case 13: $posx = 367;
                            $posy = 78;
                            break;

                    }

                  //  $this->cezpdf->addText($posx +390, $posy-10, 14, 'x');





                    /*            if ($tipo_oper == "V") {
                                $datos_guiarem = $this->guiarem_model->obtener($codigo);
                                $datos_detalle_guiarem = $this->guiaremdetalle_model->obtener2($codigo);
                                $tipo_movimiento = $datos_guiarem[0]->TIPOMOVP_Codigo;


                                $this->cezpdf = new backgroundPDF('a4', 'portrait', 'image', array('img' => 'images/img_db/' . $notimg));
                                $posicionX = 18;
                                $posicionY = -10;

                                $this->cezpdf->addText(88, '', 9, '');
                                if ($img == 0) {
                                    $this->cezpdf->addText($posicionX + 350, $posicionY + 720, 18, $serie);
                                    $this->cezpdf->addText($posicionX + 455, $posicionY + 720, 18, $numero);
                                } else {
                                    $this->cezpdf->addText($posicionX + 436, $posicionY + 745, 18, "");
                                    $this->cezpdf->addText($posicionX + 480, $posicionY + 745, 18, "");
                                }*/



//            $this->cezpdf->ezText(' ', 9, array("leading" => 1200, "left" => 0));
//            $this->cezpdf->addText($posicionX + 90, $posicionY + 705, 8, 'ESTA LISTA CORRESPONDE A');
//            $this->cezpdf->addText($posicionX + 90, $posicionY + 685, 8, 'FACTURA');
//            $this->cezpdf->addText($posicionX + 90, $posicionY + 665, 8, 'BOLETA');
//            $this->cezpdf->addText($posicionX + 90, $posicionY + 645, 8, 'GUIA DE REMISION');
//            $this->cezpdf->addText($posicionX + 250, $posicionY + 645, 8, $serie);
//
//
//            $this->cezpdf->addText($posicionX+275, $posicionY+585, 8, 'LISTA DE IMEIS');

                    $valortotal=strlen($observacion);
                    // strlen se obtiene la longitud de caracteres
                    $exacta=round($valortotal/96);
                    // obtiene el numero entero de la operacion
                    for($i=0;$i<$exacta;$i++){
                        $this->cezpdf->addText($posicionX+100, $posicionY+560-($i*13), 8, substr($observacion,$i*96,96));
                    }


                    /*            if (count($datos_detalle_guiarem) > 0) {

                                    foreach ($observacion as $indice => $valor_obser) {

                                        $producto = $valor_obser->PRODCTOP_Codigo;*/





                    /*
                                $posx = 0;

                                $posy = 0;

                                switch ($tipo_movimiento) {

                                    case 1: $posx = 55;
                                        $posy = 70;
                                        break;

                                    case 2: $posx = 55;
                                        $posy = 62;
                                        break;

                                    case 3: $posx = 55;
                                        $posy = 54;
                                        break;

                                }

                                $this->cezpdf->addText($posx, $posy, 14, 'x');*/






                }





            } else {

                $datos_guiarem = $this->guiarem_model->obtener($codigo);

                $datos_detalle_guiarem = $this->guiaremdetalle_model->obtener2($codigo);

                $tipo_movimiento = $datos_guiarem[0]->TIPOMOVP_Codigo;

                $referencia = $datos_guiarem[0]->DOCUP_Codigo;

                $guiasap = $datos_guiarem[0]->GUIASAP_Codigo;

                $guiainp = $datos_guiarem[0]->GUIAINP_Codigo;

                $motivo_trans = $datos_guiarem[0]->TIPOMOVP_Codigo;

                $cliente = $datos_guiarem[0]->CLIP_Codigo;

                $proveedor = $datos_guiarem[0]->PROVP_Codigo;

                $numero_ref = $datos_guiarem[0]->GUIAREMC_NumeroRef;

                $numero_ocompra = $datos_guiarem[0]->GUIAREMC_OCompra;

                $serie = $datos_guiarem[0]->GUIAREMC_Serie;

                $numero = $datos_guiarem[0]->GUIAREMC_Numero;

                $fecha_traslado = mysql_to_human($datos_guiarem[0]->GUIAREMC_FechaTraslado);

                $observacion = $datos_guiarem[0]->GUIAREMC_Observacion;

                $marca = $datos_guiarem[0]->GUIAREMC_Marca;

                $placa = $datos_guiarem[0]->GUIAREMC_Placa;

                $registro_mtc = $datos_guiarem[0]->GUIAREMC_RegistroMTC;

                $certificado = $datos_guiarem[0]->GUIAREMC_Certificado;

                $licencia = $datos_guiarem[0]->GUIAREMC_Licencia;

                $nombre_conductor = $datos_guiarem[0]->GUIAREMC_NombreConductor;

                $punto_partida = $datos_guiarem[0]->GUIAREMC_PuntoPartida;

                $arr_punt_lleg = explode('/', $punto_partida);

                $punto_llegada = $datos_guiarem[0]->GUIAREMC_PuntoLlegada;

                $arr_punt_part = explode('/', $punto_llegada);

                $empresa_transporte = $datos_guiarem[0]->EMPRP_Codigo;

                $fecha = mysql_to_human($datos_guiarem[0]->GUIAREMC_Fecha);

                $otro_motivo = $datos_guiarem[0]->GUIAREMC_OtroMotivo;

                $total = $datos_guiarem[0]->GUIAREMC_total;

                $nombre_emprtrans = "";

                $ruc_emprtrans = "";



                $datos_moneda = $this->moneda_model->obtener($datos_guiarem[0]->MONED_Codigo);

                $moneda_nombre = (count($datos_moneda) > 0 ? $datos_moneda[0]->MONED_Descripcion : 'NUEVOS SOLES');

                $moneda_simbolo = (count($datos_moneda) > 0 ? $datos_moneda[0]->MONED_Simbolo : 'S/.');



                if ($empresa_transporte != '') {

                    $datos_emprtrans = $this->empresa_model->obtener_datosEmpresa($empresa_transporte);

                    if (count($datos_emprtrans) > 0) {

                        $ruc_emprtrans = $datos_emprtrans[0]->EMPRC_Ruc;

                        $nombre_emprtrans = $datos_emprtrans[0]->EMPRC_RazonSocial;

                    }

                }

                $mot = "";

                switch ($motivo_trans) {

                    case 1:

                        $mot = 1;

                        break;

                    case 2:

                        $mot = 0;

                        break;

                    case 3:

                        $mot = 2;

                        break;

                    case 4:

                        $mot = 4;

                        break;

                    case 5:

                        $mot = 5;

                        break;

                    case 6:

                        $mot = 6;

                        break;

                    case 7:

                        $mot = 9;

                        break;

                    case 8:

                        $mot = 13;

                        break;

                }



                $nombre_tipodoc = '';

                if ($referencia != '') {

                    $datos_doc = $this->documento_model->obtener($referencia);

                    $nombre_tipodoc = $datos_doc[0]->DOCUC_Descripcion;

                }



                /* Datos del proveedor */



                $datos_proveedor = $this->proveedor_model->obtener_proveedor_info($proveedor);

                $razon_social = utf8_decode($datos_proveedor->nombre);

                $tipo_doc = ($datos_proveedor->tipo == '0' ? 'D.N.1' : 'R.U.C.');

                $ruc = $datos_proveedor->ruc;

                $distrito_cliente = $datos_proveedor->distrito;

                $provincia_cliente = $datos_proveedor->provincia;

                $departamento_cliente = $datos_proveedor->departamento;





                $razon_social2 = '';

                if (strlen($razon_social) > 26) {

                    $razon_social2 = substr($razon_social, 0);

                    $razon_social = substr($razon_social, 0);

                }
                $nombre_emprtrans2 = '';

                if (strlen($nombre_emprtrans) > 29) {

                    $nombre_emprtrans2 = substr($nombre_emprtrans, 29);

                    $nombre_emprtrans = substr($nombre_emprtrans, 0, 29);

                }

                $otro_motivo2 = '';

                if (strlen($otro_motivo) > 18) {

                    $otro_motivo2 = substr($otro_motivo, 18);

                    $otro_motivo = substr($otro_motivo, 0, 18);

                }
//PDF COMPRAS GUIA
                if ($img == 1) {
                    //$notimg = "";
                    $notimg = "guia_remision_proveedor_1.jpg";
                } else {
                    $notimg = "guia_remision_proveedor_1.jpg";
                }

                /* Cabecera */

//            prep_pdf();

                //$this->cezpdf = new backgroundPDF('a4', 'portrait', 'image', array('img'=>'images/img_db/ferresat_fondo_guiarem.jpg'));

                $this->cezpdf = new backgroundPDF('a4', 'portrait', 'image', array('img' => 'images/img_db/' . $notimg));

                $posicionX = 0;

                $posicionY = 180;

                $this->cezpdf->addText(88, '', 9, '');

                if ($img == 0) {
//NO
                    $this->cezpdf->addTextWrap($posicionX + 400, $posicionY + 528,100, 18, $serie);

                    $this->cezpdf->addTextWrap($posicionX + 450, $posicionY + 528,100, 18, $numero);

                } else {

                    $this->cezpdf->addTextWrap($posicionX + 436, $posicionY + 590,100, 18, $serie);

                    $this->cezpdf->addTextWrap($posicionX + 480, $posicionY + 590,100, 18, $numero);

                }

                $this->cezpdf->addTextWrap($posicionX + 100, $posicionY + 490,100, 9, substr($fecha,0,2).' / ');

                $this->cezpdf->addTextWrap($posicionX + 120, $posicionY + 490,100, 9, substr($fecha,3,2).' / ');

                $this->cezpdf->addTextWrap($posicionX + 140, $posicionY + 490,100, 9, substr($fecha,6,4));

                //$this->cezpdf->addText($posicionX + 330, $posicionY + 673, 9, $fecha_traslado);

                //direccion partida

                //$this->cezpdf->addTextWrap($posicionX + 310, $posicionY + 518,300, 6.5, utf8_decode_seguro(substr($arr_punt_part[0], 0, 80)));

//

//        $this->cezpdf->addText($posicionX + 62, $posicionY + 663, 8, utf8_decode_seguro(isset($arr_punt_part[1]) ? $arr_punt_part[1] . '321321321' : '9999999999999999'));

//

                //direccion destino

                $direccion_destino = substr($arr_punt_lleg[0], 0, 80);

                //$this->cezpdf->addTextWrap($posicionX + 46, $posicionY + 518,300, 7, utf8_decode_seguro(isset($direccion_destino) ? $direccion_destino : ''));

                $this->cezpdf->addText($posicionX + 430, $posicionY + 350, 6, utf8_decode_seguro($nombre_emprtrans));

//            $this->cezpdf->addText($posicionX + 266, $posicionY + 631, 6, utf8_decode_seguro($nombre_conductor));

              //  $this->cezpdf->addText($posicionX + 420, $posicionY + 506, 8, $ruc_emprtrans);

                  $this->cezpdf->addText($posicionX + 480, $posicionY + 375, 7, $placa);

//            $this->cezpdf->addText($posicionX + 390, $posicionY + 630, 7, $certificado);

                //$this->cezpdf->addText($posicionX + 396, $posicionY + 594, 7, $licencia);

                $this->cezpdf->addText($posicionX + 400, $posicionY + 375, 7, $marca);
//apellido y nombre/la razon social
                $this->cezpdf->addText($posicionX + 35, $posicionY + 360, 8, $razon_social);

//            $this->cezpdf->addText($posicionX + 32, $posicionY + 80, 8, $nombre_conductor);

               // $this->cezpdf->addText($posicionX + 490, $posicionY + 640, 12, $ruc);
                $this->cezpdf->addText($posicionX + 45, $posicionY + 343, 8, $ruc);

                // $this->cezpdf->addText($posicionX + 68, $posicionY + 616, 9, "x");

                /* Detalle 201.240.194.49*/

                $db_data = array();

                if (count($datos_detalle_guiarem) > 0) {

                    foreach ($datos_detalle_guiarem as $indice => $valor) {

                        $producto = $valor->PRODCTOP_Codigo;

                        $unidad = $valor->UNDMED_Codigo;

                        $costo = $valor->GUIAREMDETC_Costo;

                        $venta = $valor->GUIAREMDETC_Venta;

                        $peso = $valor->GUIAREMDETC_Peso;

                        $descri = $valor->GUIAREMDETC_Descripcion;

                        $descri = str_replace('\\', '', $descri);

                        $datos_producto = $this->producto_model->obtener_producto($producto);

                        $datos_unidad = $this->unidadmedida_model->obtener($unidad);

                        $prod_cod = $datos_producto[0]->PROD_Codigo;

                        $prod_nombre = $datos_producto[0]->PROD_Nombre;

                        $prod_codigo = $datos_producto[0]->PROD_CodigoUsuario;

                        $prod_unidad = $datos_unidad[0]->UNDMED_Descripcion;

                        $prod_cantidad = $valor->GUIAREMDETC_Cantidad;

                        //------------------------------------------------------------------------------

                        $array_producto = explode("/", $descri);

                        //$db_data[] = array(

                        //     'col1' => utf8_decode_seguro($descri),

                        //     'col2' => $prod_unidad,

                        //     'col3' => $prod_cantidad,

                        //     'col4' => ''

                        // );

                        //   $this->cezpdf->addText($posicionX + 20, $posicionY + 540, 9, $prod_unidad);
                        //stv
                        $this->cezpdf->addTextWrap($posicionX + 20, $posicionY + 300,100, 8, utf8_decode_seguro($prod_codigo));
                        ///$prod_unidad
                        $this->cezpdf->addTextWrap($posicionX + 140, $posicionY + 300,100, 8, utf8_decode_seguro($prod_nombre));   //$array_producto[0]


                        ///stv
                        $this->cezpdf->addTextWrap($posicionX + 75, $posicionY + 300,100, 6, utf8_decode_seguro($prod_unidad));

                        ///

                        //  $this->cezpdf->addText($posicionX + 85, $posicionY + 540, 9, $prod_unidad);

                        $this->cezpdf->addTextWrap($posicionX + 55, $posicionY + 300,100, 9, $prod_cantidad);

                        //--------------------------

//                    if ($tipo_oper == "C") {

//                        $datos_serie = $this->seriemov_model->buscar_x_guiainp($guiainp, $prod_cod);

//                    } else {

//                        $datos_serie = $this->seriemov_model->buscar_x_guiasap($guiasap, $prod_cod);

//                    }

                        $ser = "";

                        $c = 0;

////                    if (count($datos_serie) > 0) {
//
////                        foreach ($datos_serie as $indices => $valor) {
//
////                            $c+=1;
//
////                            $seriecodigo = $valor->SERIC_Numero;
//
////                            $ser = $ser . " / " . $seriecodigo;
//
////                            if ($c == 7) {
//
////
//
////                                $this->cezpdf->addText(90 + $posicionX +=30, $posicionY + 620, 8, "" . $ser);
//
////                                $posicionY-=10;
//
////                                $posicionX -=30;
//
////                                $ser = "";
//
////                                $c = 0;
//
////                            }
//
////                        }
//
////                        $this->cezpdf->addText(90 + $posicionX +=30, $posicionY + 620, 8, "" . $ser);
//
////
//
////                        $posicionY-=10;
//
////                    }
//
//                    $posicionX = 0;
//
//
//
//                    //---------------------
//
//                    //$this->cezpdf->addText($posicionX + 10, $posicionY + 610, 9, utf8_decode_seguro($nombre_emprtrans2 != '' ? $nombre_emprtrans . '-' : $nombre_emprtrans ));
//
//
//
////                    $this->cezpdf->addText($posicionX + 500, $posicionY + 548, 9, $moneda_simbolo . ' ' . $valor->GUIAREMDETC_Total);



                        $posicionY-=16;

                    }

                }

                $posicionY = 0;

                $this->cezpdf->addText(500, 120, 8, $moneda_simbolo . ' ' . $total);

                // $this->cezpdf->addText(300, 500, 9, utf8_decode_seguro($ser));

                $this->cezpdf->addText(600, 100, 9, utf8_decode_seguro($nombre_emprtrans2 != '' ? $nombre_emprtrans . ' k' : $nombre_emprtrans . ' L'));

                //    $this->cezpdf->addText(400, 500, 9, utf8_decode_seguro($nombre_emprtrans2));

                //  $this->cezpdf->addText(47, 138, 9, $ruc_emprtrans);

                //   $this->cezpdf->addText(40, 127, 9, utf8_decode_seguro(strtoupper($nombre_tipodoc)));

                //num_factura   bloqueado stv
                //$this->cezpdf->addText(40, 115, 9, utf8_decode_seguro($numero_ref));

                $posx = 0;

                $posy = 0;

                switch ($tipo_movimiento) {

                    case 1: $posx = 68;

                        $posy = 616;

                        break;

                    case 2: $posx = 68;

                        $posy = 616;

                        break;

                    case 3: $posx = 68;

                        $posy = 595;

                        break;

                    case 4: $posx = 195;

                        $posy = 616;

                        break;

                    case 5: $posx = 383;

                        $posy = 616;

                        break;

                    case 6: $posx = 383;

                        $posy = 584;

                        break;

                    case 7: $posx = 195;

                        $posy = 595;

                        break;

                    case 8: $posx = 560;

                        $posy = 584;

                        break;

                    case 9: $posx = 560;

                        $posy = 616;

                        break;

                    case 10: $posx = 560;

                        $posy = 584;

                        break;

                    case 11: $posx = 560;

                        $posy = 584;

                        break;

                    case 12: $posx = 560;

                        $posy = 584;

                        break;

                    case 13: $posx = 560;

                        $posy = 584;

                        break;

                }
                $posy=616;
              //  $this->cezpdf->addText($posx+510, $posy+90, 14, 'x');

            }

            //  $this->cezpdf->addText(70, 70, 9, utf8_decode_seguro($nombre_emprtrans2 != '' ? $nombre_emprtrans : $nombre_emprtrans));

            // $this->cezpdf->addText(70, , 9, utf8_decode_seguro($marca . ' ' . $placa));

            //$this->cezpdf->addText(70, 50, 9, utf8_decode_seguro($nombre_conductor . ' ' . $licencia));

            $cabecera = array('Content-Type' => 'application/pdf', 'Content-Disposition' => 'nama_file.pdf', 'Expires' => '0', 'Pragma' => 'cache', 'Cache-Control' => 'private');

            $this->cezpdf->ezStream($cabecera);


        }

    }


    public function guiarem_ver_pdf_conmenbrete_formato2($codigo, $tipo_oper)
    {

        //$this->load->library('cezpdf');

        //$this->load->helper('pdf_helper');

        $datos_guiarem = $this->guiarem_model->obtener($codigo);

        $datos_detalle_guiarem = $this->guiaremdetalle_model->obtener2($codigo);

        $tipo_movimiento = $datos_guiarem[0]->TIPOMOVP_Codigo;

        $referencia = $datos_guiarem[0]->DOCUP_Codigo;

        $cliente = $datos_guiarem[0]->CLIP_Codigo;

        $numero_ref = $datos_guiarem[0]->GUIAREMC_NumeroRef;

        $serie = $datos_guiarem[0]->GUIAREMC_Serie;

        $numero = $datos_guiarem[0]->GUIAREMC_Numero;

        $fecha_traslado = mysql_to_human($datos_guiarem[0]->GUIAREMC_FechaTraslado);

        $observacion = $datos_guiarem[0]->GUIAREMC_Observacion;

        $marca = $datos_guiarem[0]->GUIAREMC_Marca;

        $placa = $datos_guiarem[0]->GUIAREMC_Placa;

        $registro_mtc = $datos_guiarem[0]->GUIAREMC_RegistroMTC;

        $certificado = $datos_guiarem[0]->GUIAREMC_Certificado;

        $licencia = $datos_guiarem[0]->GUIAREMC_Licencia;

        $nombre_conductor = $datos_guiarem[0]->GUIAREMC_NombreConductor;

        $punto_partida = $datos_guiarem[0]->GUIAREMC_PuntoPartida;

        $arr_punt_part = explode('/', $punto_partida);

        $punto_llegada = $datos_guiarem[0]->GUIAREMC_PuntoLlegada;

        $arr_punt_lleg = explode('/', $punto_llegada);

        $empresa_transporte = $datos_guiarem[0]->EMPRP_Codigo;

        $fecha = mysql_to_human($datos_guiarem[0]->GUIAREMC_Fecha);

        $otro_motivo = $datos_guiarem[0]->GUIAREMC_OtroMotivo;


        $nombre_emprtrans = "";

        $ruc_emprtrans = "";

        if ($empresa_transporte != '') {

            $datos_emprtrans = $this->empresa_model->obtener_datosEmpresa($empresa_transporte);

            if (count($datos_emprtrans) > 0) {

                $ruc_emprtrans = $datos_emprtrans[0]->EMPRC_Ruc;

                $nombre_emprtrans = $datos_emprtrans[0]->EMPRC_RazonSocial;

            }

        }


        $datos_doc = $this->documento_model->obtener($referencia);

        $nombre_tipodoc = $datos_doc[0]->DOCUC_Descripcion;


        /* Datos del cliente */

        $datos_cliente = $this->cliente_model->obtener($cliente);

        $razon_social = utf8_decode($datos_cliente->nombre);

        $tipo_doc = ($datos_cliente->tipo == '0' ? 'D.N.1' : 'R.U.C.');

        $ruc = $datos_cliente->ruc;

        $distrito_cliente = $datos_cliente->distrito;

        $provincia_cliente = $datos_cliente->provincia;

        $departamento_cliente = $datos_cliente->departamento;


        $razon_social2 = '';

        if (strlen($razon_social) > 26) {

            $razon_social2 = substr($razon_social, 26);

            $razon_social = substr($razon_social, 0, 26);

        }

        $nombre_emprtrans2 = '';

        if (strlen($nombre_emprtrans) > 29) {

            $nombre_emprtrans2 = substr($nombre_emprtrans, 29);

            $nombre_emprtrans = substr($nombre_emprtrans, 0, 29);

        }

        $otro_motivo2 = '';

        if (strlen($otro_motivo) > 18) {

            $otro_motivo2 = substr($otro_motivo, 18);

            $otro_motivo = substr($otro_motivo, 0, 18);

        }


        /* Cabecera */

        //prep_pdf();


        $this->cezpdf = new backgroundPDF('a4', 'portrait', 'image', array('img' => 'images/img_db/ferresat_fondo_guiarem.jpg'));


        $this->cezpdf->ezText('', '', array("leading" => 88));
//NO
        $this->cezpdf->ezText($serie, 18, array("leading" => 20, 'left' => 350));

        $this->cezpdf->ezText($numero, 18, array("leading" => 0, 'left' => 425));


        $this->cezpdf->ezText($fecha, 9, array("leading" => 15, "left" => 30));

        $this->cezpdf->ezText($fecha_traslado, 9, array("leading" => 0, "left" => 180));


        $this->cezpdf->ezText(utf8_decode_seguro($arr_punt_part[0]), 9, array("leading" => 45, "left" => 25));

        $this->cezpdf->ezText(utf8_decode_seguro(isset($arr_punt_part[1]) ? $arr_punt_part[1] : ''), 9, array("leading" => 0, "left" => 155));

        $this->cezpdf->ezText(utf8_decode_seguro(isset($arr_punt_lleg[0]) ? $arr_punt_part[0] : ''), 9, array("leading" => 0, "left" => 310));

        $this->cezpdf->ezText(utf8_decode_seguro(isset($arr_punt_lleg[1]) ? $arr_punt_part[1] : ''), 9, array("leading" => 0, "left" => 440));

        $this->cezpdf->ezText(utf8_decode_seguro(isset($arr_punt_part[2]) ? $arr_punt_part[2] : ''), 9, array("leading" => 18, "left" => 5));

        $this->cezpdf->ezText(utf8_decode_seguro(isset($arr_punt_part[3]) ? substr($arr_punt_part[3], 0, 15) : ''), 9, array("leading" => 0, "left" => 110));

        $this->cezpdf->ezText(utf8_decode_seguro(isset($arr_punt_part[4]) ? substr($arr_punt_part[4], 0, 12) : ''), 9, array("leading" => 0, "left" => 195));

        $this->cezpdf->ezText(utf8_decode_seguro(isset($arr_punt_lleg[2]) ? $arr_punt_lleg[2] : ''), 9, array("leading" => 0, "left" => 285));

        $this->cezpdf->ezText(utf8_decode_seguro(isset($arr_punt_lleg[3]) ? substr($arr_punt_lleg[3], 0, 15) : ''), 9, array("leading" => 0, "left" => 385));

        $this->cezpdf->ezText(utf8_decode_seguro(isset($arr_punt_lleg[4]) ? $arr_punt_lleg[4] : ''), 9, array("leading" => 0, "left" => 500));

        $this->cezpdf->ezText(utf8_decode_seguro("LOS OLIV"), 9, array("leading" => 18, "left" => 25));

        $this->cezpdf->ezText(utf8_decode_seguro("LIMA"), 9, array("leading" => 0, "left" => 90));

        $this->cezpdf->ezText(utf8_decode_seguro("LIMA"), 9, array("leading" => 0, "left" => 190));

        $this->cezpdf->ezText(utf8_decode_seguro(substr($distrito_cliente, 0, 8)), 9, array("leading" => 0, "left" => 310));

        $this->cezpdf->ezText(utf8_decode_seguro(substr($provincia_cliente, 0, 20)), 9, array("leading" => 0, "left" => 373));

        $this->cezpdf->ezText(utf8_decode_seguro(substr($departamento_cliente, 0, 20)), 9, array("leading" => 0, "left" => 472));


        $this->cezpdf->ezText(($razon_social2 != '' ? $razon_social . '-' : $razon_social), 9, array("leading" => 45, "left" => 120));

        $this->cezpdf->ezText($marca . ($placa != '' ? ' / ' . $placa : ''), 9, array("leading" => 0, "left" => 380));

        $this->cezpdf->ezText($razon_social2, 9, array("leading" => 10, "left" => -10));

        $this->cezpdf->ezText($ruc, 9, array("leading" => 10, "left" => 15));

        $this->cezpdf->ezText($certificado, 9, array("leading" => 0, "left" => 390));

        $this->cezpdf->ezText($tipo_doc . '   ' . $ruc, 9, array("leading" => 18, "left" => 132));

        $this->cezpdf->ezText($licencia, 9, array("leading" => 0, "left" => 368));


        $this->cezpdf->ezText('', '', array("leading" => 35));


        /* Detalle */

        $db_data = array();

        if (count($datos_detalle_guiarem) > 0) {

            foreach ($datos_detalle_guiarem as $indice => $valor) {

                $producto = $valor->PRODCTOP_Codigo;

                $unidad = $valor->UNDMED_Codigo;

                $costo = $valor->GUIAREMDETC_Costo;

                $venta = $valor->GUIAREMDETC_Venta;

                $peso = $valor->GUIAREMDETC_Peso;

                $descri = $valor->GUIAREMDETC_Descripcion;

                $descri = str_replace('\\', '', $descri);

                $datos_producto = $this->producto_model->obtener_producto($producto);

                $datos_unidad = $this->unidadmedida_model->obtener($unidad);

                $prod_nombre = $datos_producto[0]->PROD_Nombre;

                $prod_codigo = $datos_producto[0]->PROD_CodigoInterno;

                $prod_unidad = $datos_unidad[0]->UNDMED_Simbolo;

                $prod_cantidad = $valor->GUIAREMDETC_Cantidad;

                $db_data[] = array(

                    'col1' => utf8_decode_seguro(substr($descri, 0, 45)),

                    'col2' => $prod_unidad,

                    'col3' => $prod_cantidad,

                    'col4' => ''

                );

            }

        }

        $this->cezpdf->ezTable($db_data, '', '', array(

            'width' => 545,

            'showLines' => 0,

            'shaded' => 0,

            'showHeadings' => 0,

            'xPos' => 'center',

            'fontSize' => '9',

            'cols' => array(

                'col1' => array('width' => 310, 'justification' => 'left'),

                'col2' => array('width' => 60, 'justification' => 'center'),

                'col3' => array('width' => 55, 'justification' => 'center'),

                'col4' => array('width' => 120, 'justification' => 'center')

            )

        ));


        //$this->cezpdf->addText(53, 167, 9, utf8_decode_seguro($nombre_emprtrans2 != '' ? $nombre_emprtrans . '-' : $nombre_emprtrans));

        //$this->cezpdf->addText(20, 152, 9, utf8_decode_seguro($nombre_emprtrans2));

        $this->cezpdf->addText(47, 138, 9, $ruc_emprtrans);

        $this->cezpdf->addText(42, 97, 9, utf8_decode_seguro(strtoupper($nombre_tipodoc)));

        $this->cezpdf->addText(42, 77, 9, $numero_ref);


        $posx = 0;

        $posy = 0;

        switch ($tipo_movimiento) {

            case 1:
                $posx = 221;

                $posy = 167;

                break;

            case 2:
                $posx = 221;

                $posy = 158;

                break;

            case 3:
                $posx = 221;

                $posy = 142;

                break;

            case 4:
                $posx = 221;

                $posy = 133;

                break;

            case 5:
                $posx = 221;

                $posy = 124;

                break;

            case 6:
                $posx = 221;

                $posy = 115;

                break;

            case 7:
                $posx = 221;

                $posy = 99;

                break;

            case 8:
                $posx = 221;

                $posy = 90;

                break;

            case 9:
                $posx = 221;

                $posy = 81;

                break;

            case 10:
                $posx = 367;

                $posy = 167;

                break;

            case 11:
                $posx = 367;

                $posy = 159;

                break;

            case 12:
                $posx = 367;

                $posy = 151;

                break;

            case 13:
                $posx = 367;

                $posy = 142;

                break;

        }

        $this->cezpdf->addText($posx, $posy, 14, 'x');

        if ($tipo_movimiento == 13) {

            $this->cezpdf->addText(377, 136, 7, ($otro_motivo2 != '' ? $otro_motivo . '-' : $otro_motivo));

            $this->cezpdf->addText(377, 127, 7, $otro_motivo2);

        }


        $cabecera = array('Content-Type' => 'application/pdf', 'Content-Disposition' => 'nama_file.pdf', 'Expires' => '0', 'Pragma' => 'cache', 'Cache-Control' => 'private');

        $this->cezpdf->ezStream($cabecera);

    }


    public function guiarem_ver_pdf_conmenbrete_formato3($codigo, $tipo_oper)
    {

        $datos_guiarem = $this->guiarem_model->obtener($codigo);

        $datos_detalle_guiarem = $this->guiaremdetalle_model->obtener2($codigo);

        $tipo_movimiento = $datos_guiarem[0]->TIPOMOVP_Codigo;

        $referencia = $datos_guiarem[0]->DOCUP_Codigo;

        $cliente = $datos_guiarem[0]->CLIP_Codigo;

        $receciona_nombres = strtoupper($datos_guiarem[0]->GUIAREMC_PersReceNombre);

        $receciona_dni = $datos_guiarem[0]->GUIAREMC_PersReceDNI;

        $numero_ref = $datos_guiarem[0]->GUIAREMC_NumeroRef;

        $serie = $datos_guiarem[0]->GUIAREMC_Serie;

        $numero = $datos_guiarem[0]->GUIAREMC_Numero;

        $fecha_traslado = mysql_to_human($datos_guiarem[0]->GUIAREMC_FechaTraslado);

        $observacion = $datos_guiarem[0]->GUIAREMC_Observacion;

        $marca = $datos_guiarem[0]->GUIAREMC_Marca;

        $placa = $datos_guiarem[0]->GUIAREMC_Placa;

        $registro_mtc = $datos_guiarem[0]->GUIAREMC_RegistroMTC;

        $certificado = $datos_guiarem[0]->GUIAREMC_Certificado;

        $licencia = $datos_guiarem[0]->GUIAREMC_Licencia;

        $nombre_conductor = $datos_guiarem[0]->GUIAREMC_NombreConductor;

        $punto_partida = $datos_guiarem[0]->GUIAREMC_PuntoPartida;

        $punto_llegada = $datos_guiarem[0]->GUIAREMC_PuntoLlegada;

        $empresa_transporte = $datos_guiarem[0]->EMPRP_Codigo;

        $fecha = mysql_to_human($datos_guiarem[0]->GUIAREMC_Fecha);

        $otro_motivo = $datos_guiarem[0]->GUIAREMC_OtroMotivo;


        $nombre_emprtrans = "";

        $ruc_emprtrans = "";

        if ($empresa_transporte != '') {

            $datos_emprtrans = $this->empresa_model->obtener_datosEmpresa($empresa_transporte);

            if (count($datos_emprtrans) > 0) {

                $ruc_emprtrans = $datos_emprtrans[0]->EMPRC_Ruc;

                $nombre_emprtrans = $datos_emprtrans[0]->EMPRC_RazonSocial;

            }

        }


        $nombre_tipodoc = '';

        if ($referencia != '') {

            $datos_doc = $this->documento_model->obtener($referencia);

            if (count($datos_doc))

                $nombre_tipodoc = $datos_doc[0]->DOCUC_Inicial;

        }


        /* Datos del cliente */

        $datos_cliente = $this->cliente_model->obtener($cliente);

        $razon_social = utf8_decode($datos_cliente->nombre);

        $ruc = $datos_cliente->ruc;


        $punto_partida2 = '';

        if (strlen($punto_partida) > 38) {

            //$punto_partida2=substr($punto_partida,38);

            //$punto_partida=substr($punto_partida,0,38);

            $temp = dividir_texto($punto_partida, 38);

            $punto_partida = $temp['texto1'];

            $punto_partida2 = $temp['texto2'];

        }

        $punto_llegada2 = '';

        if (strlen($punto_llegada) > 38) {

            //$punto_llegada2=substr($punto_llegada,38);

            //$punto_llegada=substr($punto_llegada,0,38);

            $temp = dividir_texto($punto_llegada, 38);

            $punto_llegada = $temp['texto1'];

            $punto_llegada2 = $temp['texto2'];

        }

        if ($receciona_nombres != '') {

            $razon_social = $receciona_nombres;

            $ruc = 'DNI:  ' . $receciona_dni;

        }

        $razon_social2 = '';

        if (strlen($razon_social) > 18) {

            //$razon_social2=substr($razon_social,18);

            //$razon_social=substr($razon_social,0,18);

            $temp = dividir_texto($razon_social, 18);

            $razon_social = $temp['texto1'];

            $razon_social2 = $temp['texto2'];

        }

        $nombre_emprtrans2 = '';

        if (strlen($nombre_emprtrans) > 34) {

            //$nombre_emprtrans2=substr($nombre_emprtrans,34);

            //$nombre_emprtrans=substr($nombre_emprtrans,0,34);

            $temp = dividir_texto($nombre_emprtrans, 34);

            $nombre_emprtrans = $temp['texto1'];

            $nombre_emprtrans2 = $temp['texto2'];

        }


        /* Cabecera */

        //prep_pdf();

        //$this->cezpdf = new Cezpdf('a4');

        $this->cezpdf = new backgroundPDF('a4', 'portrait', 'image', array('img' => 'images/img_db/instrume_fondo_guiarem.jpg'));


        $this->cezpdf->ezText($serie . '-' . $numero, 18, array("leading" => 80, 'left' => 350));

        /* Datos de Cabecera */


        $this->cezpdf->ezText(utf8_decode_seguro($punto_partida), 9, array("leading" => 55, "left" => 53));

        $this->cezpdf->ezText(utf8_decode_seguro($punto_llegada), 9, array("leading" => 0, "left" => 338));

        $this->cezpdf->ezText(utf8_decode_seguro(substr($punto_partida2, 0, 52)), 9, array("leading" => 15, "left" => -12));

        $this->cezpdf->ezText(substr(utf8_decode_seguro($punto_llegada2), 0, 50), 9, array("leading" => 0, "left" => 270));

        $this->cezpdf->ezText($fecha_traslado, 9, array("leading" => 19, "left" => 93));

        $this->cezpdf->ezText(utf8_decode_seguro($razon_social), 9, array("leading" => 0, "left" => 430));

        $this->cezpdf->ezText(utf8_decode_seguro($razon_social2), 9, array("leading" => 11, "left" => 270));

        $this->cezpdf->ezText($ruc, 9, array("leading" => 12, "left" => 335));


        $this->cezpdf->ezText($marca . ($placa != '' ? '/' . $placa : ''), 9, array("leading" => 34, "left" => 87));

        $this->cezpdf->ezText(utf8_decode_seguro($nombre_emprtrans), 9, array("leading" => 0, "left" => 360));

        $this->cezpdf->ezText($certificado, 9, array("leading" => 14, "left" => 112));

        $this->cezpdf->ezText(substr(utf8_decode_seguro($nombre_emprtrans2), 0, 56), 9, array("leading" => 0, "left" => 270));

        $this->cezpdf->ezText($licencia, 9, array("leading" => 16, "left" => 115));

        $this->cezpdf->ezText($ruc_emprtrans, 9, array("leading" => 0, "left" => 340));


        $this->cezpdf->ezText('', '', array("leading" => 29));


        /* Detalle */

        $db_data = array();

        if (count($datos_detalle_guiarem) > 0) {

            foreach ($datos_detalle_guiarem as $indice => $valor) {

                $producto = $valor->PRODCTOP_Codigo;

                $marca_prod = $this->producto_model->obtener_marca_modelo_por_producto($producto);

                $unidad = $valor->UNDMED_Codigo;

                $costo = $valor->GUIAREMDETC_Costo;

                $venta = $valor->GUIAREMDETC_Venta;

                $peso = $valor->GUIAREMDETC_Peso;

                $descri = $valor->GUIAREMDETC_Descripcion;

                $descri = str_replace('\\', '', $descri);

                $datos_producto = $this->producto_model->obtener_producto($producto);

                $datos_unidad = $this->unidadmedida_model->obtener($unidad);

                $prod_nombre = $datos_producto[0]->PROD_Nombre;

                $prod_codigo = $datos_producto[0]->PROD_CodigoUsuario;

                $prod_unidad = $datos_unidad[0]->UNDMED_Simbolo;

                $prod_cantidad = $valor->GUIAREMDETC_Cantidad;

                $db_data[] = array(

                    'col0' => $prod_codigo,

                    'col1' => utf8_decode_seguro(substr($descri, 0, 45)) . " / " . $marca_prod[0]->MARCC_Descripcion . " / " . $marca_prod[0]->PROD_Modelo,

                    'col2' => $prod_cantidad,

                    'col3' => $prod_unidad,

                    'col4' => ''

                );

            }

        }

        $this->cezpdf->ezTable($db_data, '', '', array(

            'showLines' => 0,

            'shaded' => 0,

            'showHeadings' => 0,

            'xPos' => 'center',

            'fontSize' => '9',

            'cols' => array(

                'col0' => array('width' => 75, 'justification' => 'center'),

                'col1' => array('width' => 275, 'justification' => 'left'),

                'col2' => array('width' => 45, 'justification' => 'center'),

                'col3' => array('width' => 90, 'justification' => 'center'),

                'col4' => array('width' => 80, 'justification' => 'center')

            )

        ));

        if ($nombre_tipodoc != '')

            $this->cezpdf->addText(200, 220, 9, strtoupper($nombre_tipodoc) . ' / ' . $numero_ref);


        $posx = 0;

        $posy = 0;

        switch ($tipo_movimiento) {

            case 1:
                $posx = 110;

                $posy = 180;

                break;

            case 2:
                $posx = 110;

                $posy = 165;

                break;

            case 3:
                $posx = 110;

                $posy = 150;

                break;

            case 4:
                $posx = 250;

                $posy = 180;

                break;

            case 5:
                $posx = 250;

                $posy = 165;

                break;

            case 6:
                $posx = 250;

                $posy = 150;

                break;

            case 7:
                $posx = 420;

                $posy = 180;

                break;

            case 8:
                $posx = 420;

                $posy = 165;

                break;

            case 9:
                $posx = 420;

                $posy = 150;

                break;

            case 10:
                $posx = 530;

                $posy = 180;

                break;

            case 11:
                $posx = 530;

                $posy = 165;

                break;

            case 12:
                $posx = 530;

                $posy = 150;

                break;

        }

        if ($posx != 0 && $posy != 0)

            $this->cezpdf->addText($posx, $posy, 14, 'x');

        else

            $this->cezpdf->addText(75, 150, 9, $otro_motivo);


        $cabecera = array('Content-Type' => 'application/pdf', 'Content-Disposition' => 'nama_file.pdf', 'Expires' => '0', 'Pragma' => 'cache', 'Cache-Control' => 'private');

        $this->cezpdf->ezStream($cabecera);

    }


    public function guiarem_ver_pdf_conmenbrete_formato4($codigo, $tipo_oper)
    {

        //$this->load->library('cezpdf');

        //$this->load->helper('pdf_helper');

        $datos_guiarem = $this->guiarem_model->obtener($codigo);

        $datos_detalle_guiarem = $this->guiaremdetalle_model->obtener2($codigo);

        $tipo_movimiento = $datos_guiarem[0]->TIPOMOVP_Codigo;

        $referencia = $datos_guiarem[0]->DOCUP_Codigo;

        $cliente = $datos_guiarem[0]->CLIP_Codigo;

        $numero_ref = $datos_guiarem[0]->GUIAREMC_NumeroRef;

        $serie = $datos_guiarem[0]->GUIAREMC_Serie;

        $numero = $datos_guiarem[0]->GUIAREMC_Numero;

        $fecha_traslado = mysql_to_human($datos_guiarem[0]->GUIAREMC_FechaTraslado);

        $observacion = $datos_guiarem[0]->GUIAREMC_Observacion;

        $marca = $datos_guiarem[0]->GUIAREMC_Marca;

        $placa = $datos_guiarem[0]->GUIAREMC_Placa;

        $registro_mtc = $datos_guiarem[0]->GUIAREMC_RegistroMTC;

        $certificado = $datos_guiarem[0]->GUIAREMC_Certificado;

        $licencia = $datos_guiarem[0]->GUIAREMC_Licencia;

        $nombre_conductor = $datos_guiarem[0]->GUIAREMC_NombreConductor;

        $punto_partida = $datos_guiarem[0]->GUIAREMC_PuntoPartida;

        $punto_llegada = $datos_guiarem[0]->GUIAREMC_PuntoLlegada;

        $empresa_transporte = $datos_guiarem[0]->EMPRP_Codigo;

        $fecha = mysql_to_human($datos_guiarem[0]->GUIAREMC_Fecha);

        $otro_motivo = $datos_guiarem[0]->GUIAREMC_OtroMotivo;


        $nombre_emprtrans = "";

        $ruc_emprtrans = "";

        if ($empresa_transporte != '') {

            $datos_emprtrans = $this->empresa_model->obtener_datosEmpresa($empresa_transporte);

            if (count($datos_emprtrans) > 0) {

                $ruc_emprtrans = $datos_emprtrans[0]->EMPRC_Ruc;

                $nombre_emprtrans = $datos_emprtrans[0]->EMPRC_RazonSocial;

            }

        }


        $datos_doc = $this->documento_model->obtener($referencia);

        $nombre_tipodoc = $datos_doc[0]->DOCUC_Descripcion;


        /* Datos del cliente */

        $datos_cliente = $this->cliente_model->obtener($cliente);

        $razon_social = utf8_decode($datos_cliente->nombre);

        $tipo_doc = ($datos_cliente->tipo == '0' ? 'D.N.1' : 'R.U.C.');

        $ruc = $datos_cliente->ruc;

        $dni = $datos_cliente->dni;

        $distrito_cliente = $datos_cliente->distrito;

        $provincia_cliente = $datos_cliente->provincia;

        $departamento_cliente = $datos_cliente->departamento;


        $punto_partida2 = '';

        if (strlen($punto_partida) > 50) {

            $punto_partida2 = substr($punto_partida, 50);

            $punto_partida = substr($punto_partida, 0, 50);

        }

        $punto_llegada2 = '';

        if (strlen($punto_llegada) > 48) {

            $punto_llegada2 = substr($punto_llegada, 48);

            $punto_llegada = substr($punto_llegada, 0, 48);

        }

        $razon_social2 = '';

        if (strlen($razon_social) > 52) {

            $razon_social2 = substr($razon_social, 52);

            $razon_social = substr($razon_social, 0, 52);

        }


        /* Cabecera */

        //prep_pdf();


        $this->cezpdf = new backgroundPDF('a4', 'portrait', 'image', array('img' => 'images/img_db/ferremax_fondo_guiarem.jpg'));

        $this->cezpdf->ezText('', '', array("leading" => 95));

        $this->cezpdf->ezText($serie, 18, array("leading" => 20, 'left' => 340));

        $this->cezpdf->ezText($numero, 18, array("leading" => 0, 'left' => 435));


        $this->cezpdf->ezText(substr($fecha, 0, 2), 9, array("leading" => 15, 'left' => 55));

        $this->cezpdf->ezText(substr($fecha, 3, 2), 9, array("leading" => 0, 'left' => 90));

        $this->cezpdf->ezText(substr($fecha, 8, 2), 9, array("leading" => 0, 'left' => 120));

        $this->cezpdf->ezText(substr($fecha_traslado, 0, 2), 9, array("leading" => 0, 'left' => 245));

        $this->cezpdf->ezText(substr($fecha_traslado, 3, 2), 9, array("leading" => 0, 'left' => 270));

        $this->cezpdf->ezText(substr($fecha_traslado, 8, 2), 9, array("leading" => 0, 'left' => 295));

        $this->cezpdf->ezText(utf8_decode_seguro($punto_partida . ($punto_partida2 != '' ? '-' : '')), 9, array("leading" => 30, 'left' => -10));

        $this->cezpdf->ezText(utf8_decode_seguro($punto_llegada . ($punto_llegada2 != '' ? '-' : '')), 9, array("leading" => 0, 'left' => 280));

        $this->cezpdf->ezText(utf8_decode_seguro($punto_partida2), 9, array("leading" => 13, 'left' => -10));

        $this->cezpdf->ezText(utf8_decode_seguro($punto_llegada2), 9, array("leading" => 0, 'left' => 280));

        $this->cezpdf->ezText('LIMA', 9, array("leading" => 10, 'left' => 15));

        $this->cezpdf->ezText('LIMA', 9, array("leading" => 0, 'left' => 110));

        $this->cezpdf->ezText('ATE', 9, array("leading" => 0, 'left' => 205));

        $this->cezpdf->ezText(utf8_decode_seguro($departamento_cliente), 9, array("leading" => 0, 'left' => 305));

        $this->cezpdf->ezText(utf8_decode_seguro($provincia_cliente), 9, array("leading" => 0, 'left' => 400));

        $this->cezpdf->addText(520, 630, 9, $distrito_cliente);

        $this->cezpdf->ezText(utf8_decode_seguro($razon_social . ($razon_social2 != '' ? '-' : '')), 9, array("leading" => 25, 'left' => -10));

        $this->cezpdf->ezText(utf8_decode_seguro($marca), 9, array("leading" => 8, 'left' => 305));

        $this->cezpdf->ezText(utf8_decode_seguro($placa), 9, array("leading" => 0, 'left' => 400));

        $this->cezpdf->ezText(utf8_decode_seguro($registro_mtc), 9, array("leading" => 0, 'left' => 495));

        $this->cezpdf->ezText(utf8_decode_seguro($razon_social2), 9, array("leading" => 6, 'left' => -10));

        $this->cezpdf->ezText(utf8_decode_seguro($ruc), 9, array("leading" => 15, 'left' => 15));

        $this->cezpdf->ezText($dni, 9, array("leading" => 0, 'left' => 165));

        $this->cezpdf->ezText(utf8_decode_seguro($nombre_conductor), 9, array("leading" => -1, 'left' => 305));

        $this->cezpdf->ezText(utf8_decode_seguro($licencia), 9, array("leading" => -1, 'left' => 490));


        $this->cezpdf->ezText('', '', array("leading" => 25));


        /* Detalle */

        $db_data = array();

        if (count($datos_detalle_guiarem) > 0) {

            foreach ($datos_detalle_guiarem as $indice => $valor) {

                $producto = $valor->PRODCTOP_Codigo;

                $unidad = $valor->UNDMED_Codigo;

                $costo = $valor->GUIAREMDETC_Costo;

                $venta = $valor->GUIAREMDETC_Venta;

                $peso = $valor->GUIAREMDETC_Peso;

                $descri = $valor->GUIAREMDETC_Descripcion;

                $descri = str_replace('\\', '', $descri);

                $datos_producto = $this->producto_model->obtener_producto($producto);

                $datos_unidad = $this->unidadmedida_model->obtener($unidad);

                $prod_nombre = $datos_producto[0]->PROD_Nombre;

                $prod_codigo = $datos_producto[0]->PROD_CodigoInterno;

                $prod_unidad = $datos_unidad[0]->UNDMED_Simbolo;

                $prod_cantidad = $valor->GUIAREMDETC_Cantidad;

                $db_data[] = array(

                    'col0' => $prod_codigo,

                    'col1' => utf8_decode_seguro(substr($descri, 0, 45)),

                    'col2' => $prod_unidad,

                    'col3' => $prod_cantidad

                );

            }

        }

        $this->cezpdf->ezTable($db_data, '', '', array(

            'width' => 555,

            'showLines' => 0,

            'shaded' => 0,

            'showHeadings' => 0,

            'xPos' => 'center',

            'fontSize' => 8,

            'cols' => array(

                'col0' => array('width' => 70, 'justification' => 'left'),

                'col1' => array('width' => 355, 'justification' => 'left'),

                'col2' => array('width' => 70, 'justification' => 'center'),

                'col3' => array('width' => 65, 'justification' => 'center')

            )

        ));


        $this->cezpdf->addText(45, 97, 9, substr(utf8_decode_seguro($nombre_emprtrans), 0, 28));

        $this->cezpdf->addText(45, 84, 9, $ruc_emprtrans);

        if ($referencia == 8) {

            $this->cezpdf->addText(59, 56, 9, 'x');

            $this->cezpdf->addText(92, 53, 9, $numero_ref);

        } elseif ($referencia == 9) {

            $this->cezpdf->addText(59, 42, 9, 'x');

            $this->cezpdf->addText(92, 41, 9, $numero_ref);

        }


        $posx = 0;

        $posy = 0;

        switch ($tipo_movimiento) {

            case 1:
                $posx = 307;

                $posy = 104;

                break;

            case 2:
                $posx = 307;

                $posy = 95;

                break;

            case 3:
                $posx = 307;

                $posy = 86;

                break;

            case 4:
                $posx = 307;

                $posy = 76;

                break;

            case 5:
                $posx = 307;

                $posy = 67;

                break;

            case 6:
                $posx = 307;

                $posy = 57;

                break;

            case 7:
                $posx = 307;

                $posy = 48;

                break;

            case 8:
                $posx = 307;

                $posy = 39;

                break;

            case 9:
                $posx = 420;

                $posy = 104;

                break;

            case 10:
                $posx = 420;

                $posy = 95;

                break;

            case 11:
                $posx = 420;

                $posy = 86;

                break;

            case 12:
                $posx = 420;

                $posy = 76;

                break;

            case 13:
                $posx = 420;

                $posy = 67;

                break;

            case 14:
                $posx = 420;

                $posy = 57;

                break;

            case 15:
                $posx = 420;

                $posy = 48;

                break;

            case 16:
                $posx = 420;

                $posy = 39;

                break;

        }

        $this->cezpdf->addText($posx, $posy, 10, 'x');

        if ($tipo_movimiento == 16)

            $this->cezpdf->addText(331, 39, 7, utf8_decode_seguro(substr($otro_motivo, 0, 19)));


        $cabecera = array('Content-Type' => 'application/pdf', 'Content-Disposition' => 'nama_file.pdf', 'Expires' => '0', 'Pragma' => 'cache', 'Cache-Control' => 'private');

        $this->cezpdf->ezStream($cabecera);

    }


    public function guiarem_ver_pdf_conmenbrete_formato5($codigo, $tipo_oper)
    {

        //$this->load->library('cezpdf');

        //$this->load->helper('pdf_helper');

        $datos_guiarem = $this->guiarem_model->obtener($codigo);

        $datos_detalle_guiarem = $this->guiaremdetalle_model->obtener2($codigo);

        $tipo_movimiento = $datos_guiarem[0]->TIPOMOVP_Codigo;

        $referencia = $datos_guiarem[0]->DOCUP_Codigo;

        $cliente = $datos_guiarem[0]->CLIP_Codigo;

        $numero_ref = $datos_guiarem[0]->GUIAREMC_NumeroRef;

        $serie = $datos_guiarem[0]->GUIAREMC_Serie;

        $numero = $datos_guiarem[0]->GUIAREMC_Numero;

        $fecha_traslado = mysql_to_human($datos_guiarem[0]->GUIAREMC_FechaTraslado);

        $observacion = $datos_guiarem[0]->GUIAREMC_Observacion;

        $marca = $datos_guiarem[0]->GUIAREMC_Marca;

        $placa = $datos_guiarem[0]->GUIAREMC_Placa;

        $registro_mtc = $datos_guiarem[0]->GUIAREMC_RegistroMTC;

        $certificado = $datos_guiarem[0]->GUIAREMC_Certificado;

        $licencia = $datos_guiarem[0]->GUIAREMC_Licencia;

        $nombre_conductor = $datos_guiarem[0]->GUIAREMC_NombreConductor;

        $punto_partida = $datos_guiarem[0]->GUIAREMC_PuntoPartida;

        $punto_llegada = $datos_guiarem[0]->GUIAREMC_PuntoLlegada;

        $empresa_transporte = $datos_guiarem[0]->EMPRP_Codigo;

        $fecha = mysql_to_human($datos_guiarem[0]->GUIAREMC_Fecha);

        $otro_motivo = $datos_guiarem[0]->GUIAREMC_OtroMotivo;


        $nombre_emprtrans = "";

        $ruc_emprtrans = "";

        if ($empresa_transporte != '') {

            $datos_emprtrans = $this->empresa_model->obtener_datosEmpresa($empresa_transporte);

            if (count($datos_emprtrans) > 0) {

                $ruc_emprtrans = $datos_emprtrans[0]->EMPRC_Ruc;

                $nombre_emprtrans = $datos_emprtrans[0]->EMPRC_RazonSocial;

            }

        }


        $datos_doc = $this->documento_model->obtener($referencia);

        $nombre_tipodoc = $datos_doc[0]->DOCUC_Descripcion;


        /* Datos del cliente */

        $datos_cliente = $this->cliente_model->obtener($cliente);

        $razon_social = utf8_decode($datos_cliente->nombre);

        $tipo_doc = ($datos_cliente->tipo == '0' ? 'D.N.1' : 'R.U.C.');

        $ruc = $datos_cliente->ruc;

        $dni = $datos_cliente->dni;

        $distrito_cliente = $datos_cliente->distrito;

        $provincia_cliente = $datos_cliente->provincia;

        $departamento_cliente = $datos_cliente->departamento;


        $punto_partida2 = '';

        if (strlen($punto_partida) > 50) {

            $punto_partida2 = substr($punto_partida, 50);

            $punto_partida = substr($punto_partida, 0, 50);

        }

        $punto_llegada2 = '';

        if (strlen($punto_llegada) > 48) {

            $punto_llegada2 = substr($punto_llegada, 48);

            $punto_llegada = substr($punto_llegada, 0, 48);

        }

        $razon_social2 = '';

        if (strlen($razon_social) > 52) {

            $razon_social2 = substr($razon_social, 52);

            $razon_social = substr($razon_social, 0, 52);

        }


        /* Cabecera */

        //prep_pdf();


        $this->cezpdf = new backgroundPDF('a4', 'portrait', 'image', array('img' => 'images/img_db/cyg_fondo_guiarem.jpg'));

        $this->cezpdf->ezText('', '', array("leading" => 50));

        $this->cezpdf->ezText($serie, 18, array("leading" => 20, 'left' => 320));

        $this->cezpdf->ezText($numero, 18, array("leading" => 0, 'left' => 425));


        $this->cezpdf->ezText('', '', array("leading" => 38));


        $this->cezpdf->ezText(substr($fecha, 0, 2) . " / ", 8, array("leading" => 15, 'left' => 40));

        $this->cezpdf->ezText(substr($fecha, 3, 2) . " / ", 8, array("leading" => 0, 'left' => 55));

        $this->cezpdf->ezText(substr($fecha, 8, 2), 8, array("leading" => 0, 'left' => 70));

        $this->cezpdf->ezText(substr($fecha_traslado, 0, 2) . " / ", 8, array("leading" => 0, 'left' => 280));

        $this->cezpdf->ezText(substr($fecha_traslado, 3, 2) . " / ", 8, array("leading" => 0, 'left' => 295));

        $this->cezpdf->ezText(substr($fecha_traslado, 8, 2), 8, array("leading" => 0, 'left' => 310));

        $this->cezpdf->ezText(utf8_decode_seguro($punto_partida . ($punto_partida2 != '' ? '-' : '')), 8, array("leading" => 30, 'left' => 20));

        $this->cezpdf->ezText(utf8_decode_seguro($punto_llegada . ($punto_llegada2 != '' ? '-' : '')), 8, array("leading" => 0, 'left' => 300));

        $this->cezpdf->ezText(utf8_decode_seguro($punto_partida2), 8, array("leading" => 13, 'left' => -10));

        $this->cezpdf->ezText(utf8_decode_seguro($punto_llegada2), 8, array("leading" => 0, 'left' => 280));

        /* $this->cezpdf->ezText('LIMA',9, array("leading"=>10,'left'=>15));

          $this->cezpdf->ezText('LIMA',9, array("leading"=>0,'left'=>110));

          $this->cezpdf->ezText('ATE',9, array("leading"=>0,'left'=>205)); */

        /* $this->cezpdf->ezText(utf8_decode_seguro($departamento_cliente),9, array("leading"=>0,'left'=>305));

          $this->cezpdf->ezText(utf8_decode_seguro($provincia_cliente),9, array("leading"=>0,'left'=>400));

          $this->cezpdf->addText(520,630,9, $distrito_cliente); */

        $this->cezpdf->ezText(utf8_decode_seguro($razon_social . ($razon_social2 != '' ? '-' : '')), 8, array("leading" => 32, 'left' => 50));

        $this->cezpdf->ezText(utf8_decode_seguro($marca), 8, array("leading" => -2, 'left' => 325));

        $this->cezpdf->ezText(utf8_decode_seguro($placa), 8, array("leading" => 0, 'left' => 400));

        /* $this->cezpdf->ezText(utf8_decode_seguro($registro_mtc),9, array("leading"=>0,'left'=>495)); */

        $this->cezpdf->ezText(utf8_decode_seguro($razon_social2), 9, array("leading" => -3, 'left' => -10));

        $this->cezpdf->ezText(utf8_decode_seguro($ruc), 8, array("leading" => 15, 'left' => 15));

        $this->cezpdf->ezText($dni, 9, array("leading" => 0, 'left' => 165));

        $this->cezpdf->ezText(utf8_decode_seguro($nombre_conductor), 8, array("leading" => 0, 'left' => 365));

        $this->cezpdf->ezText(utf8_decode_seguro($licencia), 8, array("leading" => 0, 'left' => 480));


        $this->cezpdf->ezText('', '', array("leading" => 22));


        /* Detalle */

        $db_data = array();

        if (count($datos_detalle_guiarem) > 0) {

            foreach ($datos_detalle_guiarem as $indice => $valor) {

                $producto = $valor->PRODCTOP_Codigo;

                $unidad = $valor->UNDMED_Codigo;

                $costo = $valor->GUIAREMDETC_Costo;

                $venta = $valor->GUIAREMDETC_Venta;

                $peso = $valor->GUIAREMDETC_Peso;

                $descri = $valor->GUIAREMDETC_Descripcion;

                $descri = str_replace('\\', '', $descri);

                $datos_producto = $this->producto_model->obtener_producto($producto);

                $datos_unidad = $this->unidadmedida_model->obtener($unidad);

                $prod_nombre = $datos_producto[0]->PROD_Nombre;

                $prod_codigo = $datos_producto[0]->PROD_CodigoInterno;

                $prod_unidad = $datos_unidad[0]->UNDMED_Simbolo;

                $prod_cantidad = $valor->GUIAREMDETC_Cantidad;

                $db_data[] = array(

                    'col0' => $prod_cantidad,

                    'col1' => utf8_decode_seguro(substr($descri, 0, 45)),

                    'col2' => $prod_unidad,

                    'col3' => ''

                );

            }

        }

        $this->cezpdf->ezTable($db_data, '', '', array(

            'width' => 555,

            'showLines' => 0,

            'shaded' => 0,

            'showHeadings' => 0,

            'xPos' => 'center',

            'fontSize' => 9,

            'cols' => array(

                'col0' => array('width' => 30, 'justification' => 'center'),

                'col1' => array('width' => 390, 'justification' => 'left'),

                'col2' => array('width' => 80, 'justification' => 'center'),

                'col3' => array('width' => 35, 'justification' => 'center')

            )

        ));


        $this->cezpdf->addText(45, 97, 9, substr(utf8_decode_seguro($nombre_emprtrans), 0, 28));

        $this->cezpdf->addText(45, 84, 9, $ruc_emprtrans);

        /* if($referencia==8){

          $this->cezpdf->addText(59,56,9, 'x');

          $this->cezpdf->addText(92,53,9, $numero_ref);

          }

          elseif($referencia==9){

          $this->cezpdf->addText(59,42,9, 'x');

          $this->cezpdf->addText(92,41,9, $numero_ref);

          } */


        $posx = 0;

        $posy = 0;

        //3 venta sujeto a terceros no esta

        switch ($tipo_movimiento) {

            case 1:
                $posx = 307;

                $posy = 104;

                break;

            /* case 2:  $posx=307; $posy=95; break; */

            case 2:
                $posx = 307;

                $posy = 98;

                break;

            case 3:
                $posx = 307;

                $posy = 86;

                break;

            case 4:
                $posx = 307;

                $posy = 76;

                break;

            case 5:
                $posx = 307;

                $posy = 67;

                break;

            case 6:
                $posx = 307;

                $posy = 57;

                break;

            case 7:
                $posx = 307;

                $posy = 48;

                break;

            case 8:
                $posx = 307;

                $posy = 39;

                break;

            case 9:
                $posx = 420;

                $posy = 104;

                break;

            case 10:
                $posx = 420;

                $posy = 95;

                break;

            case 11:
                $posx = 420;

                $posy = 86;

                break;

            case 12:
                $posx = 420;

                $posy = 76;

                break;

            case 13:
                $posx = 420;

                $posy = 67;

                break;

            case 14:
                $posx = 420;

                $posy = 57;

                break;

            case 15:
                $posx = 420;

                $posy = 48;

                break;

            case 16:
                $posx = 420;

                $posy = 39;

                break;

        }

        $this->cezpdf->addText($posx - 140, $posy + 200, 10, 'x');

        if ($tipo_movimiento == 16)

            $this->cezpdf->addText(331, 39, 7, utf8_decode_seguro(substr($otro_motivo, 0, 19)));


        $cabecera = array('Content-Type' => 'application/pdf', 'Content-Disposition' => 'nama_file.pdf', 'Expires' => '0', 'Pragma' => 'cache', 'Cache-Control' => 'private');

        $this->cezpdf->ezStream($cabecera);

    }


    public function guiarem_ver_pdf_conmenbrete_formato6($codigo, $tipo_oper)
    {

        //$this->load->library('cezpdf');

        //$this->load->helper('pdf_helper');

        $datos_guiarem = $this->guiarem_model->obtener($codigo);

        $datos_detalle_guiarem = $this->guiaremdetalle_model->obtener2($codigo);

        $tipo_movimiento = $datos_guiarem[0]->TIPOMOVP_Codigo;

        $referencia = $datos_guiarem[0]->DOCUP_Codigo;

        $cliente = $datos_guiarem[0]->CLIP_Codigo;

        $numero_ref = $datos_guiarem[0]->GUIAREMC_NumeroRef;

        $serie = $datos_guiarem[0]->GUIAREMC_Serie;

        $numero = $datos_guiarem[0]->GUIAREMC_Numero;

        $fecha_traslado = mysql_to_human($datos_guiarem[0]->GUIAREMC_FechaTraslado);

        $observacion = $datos_guiarem[0]->GUIAREMC_Observacion;

        $marca = $datos_guiarem[0]->GUIAREMC_Marca;

        $placa = $datos_guiarem[0]->GUIAREMC_Placa;

        $registro_mtc = $datos_guiarem[0]->GUIAREMC_RegistroMTC;

        $certificado = $datos_guiarem[0]->GUIAREMC_Certificado;

        $licencia = $datos_guiarem[0]->GUIAREMC_Licencia;

        $nombre_conductor = $datos_guiarem[0]->GUIAREMC_NombreConductor;

        $punto_partida = $datos_guiarem[0]->GUIAREMC_PuntoPartida;

        $punto_llegada = $datos_guiarem[0]->GUIAREMC_PuntoLlegada;

        $empresa_transporte = $datos_guiarem[0]->EMPRP_Codigo;

        $fecha = mysql_to_human($datos_guiarem[0]->GUIAREMC_Fecha);

        $otro_motivo = $datos_guiarem[0]->GUIAREMC_OtroMotivo;


        $nombre_emprtrans = "";

        $ruc_emprtrans = "";

        if ($empresa_transporte != '') {

            $datos_emprtrans = $this->empresa_model->obtener_datosEmpresa($empresa_transporte);

            if (count($datos_emprtrans) > 0) {

                $ruc_emprtrans = $datos_emprtrans[0]->EMPRC_Ruc;

                $nombre_emprtrans = $datos_emprtrans[0]->EMPRC_RazonSocial;

            }

        }


        $datos_doc = $this->documento_model->obtener($referencia);

        $nombre_tipodoc = $datos_doc[0]->DOCUC_Descripcion;


        /* Datos del cliente */

        $datos_cliente = $this->cliente_model->obtener($cliente);

        $razon_social = utf8_decode($datos_cliente->nombre);

        $tipo_doc = ($datos_cliente->tipo == '0' ? 'D.N.1' : 'R.U.C.');

        $ruc = $datos_cliente->ruc;

        $dni = $datos_cliente->dni;

        $distrito_cliente = $datos_cliente->distrito;

        $provincia_cliente = $datos_cliente->provincia;

        $departamento_cliente = $datos_cliente->departamento;


        $punto_partida2 = '';

        if (strlen($punto_partida) > 50) {

            $punto_partida2 = substr($punto_partida, 50);

            $punto_partida = substr($punto_partida, 0, 50);

        }

        $punto_llegada2 = '';

        if (strlen($punto_llegada) > 48) {

            $punto_llegada2 = substr($punto_llegada, 48);

            $punto_llegada = substr($punto_llegada, 0, 48);

        }

        $razon_social2 = '';

        if (strlen($razon_social) > 52) {

            $razon_social2 = substr($razon_social, 52);

            $razon_social = substr($razon_social, 0, 52);

        }


        /* Cabecera */

        //prep_pdf();


        $this->cezpdf = new backgroundPDF('a4', 'portrait', 'image', array('img' => 'images/img_db/cyg_fondo_guiarem_2.jpg'));

        $this->cezpdf->ezText('', '', array("leading" => 57));

        $this->cezpdf->ezText($serie, 18, array("leading" => 22, 'left' => 320));

        $this->cezpdf->ezText($numero, 18, array("leading" => 0, 'left' => 425));


        $this->cezpdf->ezText('', '', array("leading" => 36));


        $this->cezpdf->ezText(substr($fecha, 0, 2) . " / ", 8, array("leading" => 16, 'left' => 45));

        $this->cezpdf->ezText(substr($fecha, 3, 2) . " / ", 8, array("leading" => 0, 'left' => 60));

        $this->cezpdf->ezText(substr($fecha, 8, 2), 8, array("leading" => 0, 'left' => 75));

        $this->cezpdf->ezText(substr($fecha_traslado, 0, 2) . " / ", 8, array("leading" => 0, 'left' => 285));

        $this->cezpdf->ezText(substr($fecha_traslado, 3, 2) . " / ", 8, array("leading" => 0, 'left' => 300));

        $this->cezpdf->ezText(substr($fecha_traslado, 8, 2), 8, array("leading" => 0, 'left' => 315));

        $this->cezpdf->ezText(utf8_decode_seguro($punto_partida . ($punto_partida2 != '' ? '-' : '')), 8, array("leading" => 30, 'left' => 30));

        $this->cezpdf->ezText(utf8_decode_seguro($punto_llegada . ($punto_llegada2 != '' ? '-' : '')), 8, array("leading" => 0, 'left' => 310));

        $this->cezpdf->ezText(utf8_decode_seguro($punto_partida2), 8, array("leading" => 13, 'left' => -10));

        $this->cezpdf->ezText(utf8_decode_seguro($punto_llegada2), 8, array("leading" => 0, 'left' => 280));

        /* $this->cezpdf->ezText(utf8_decode_seguro($departamento_cliente),9, array("leading"=>0,'left'=>305));

          $this->cezpdf->ezText(utf8_decode_seguro($provincia_cliente),9, array("leading"=>0,'left'=>400));

          $this->cezpdf->addText(520,630,9, $distrito_cliente); */


        $this->cezpdf->ezText('', '', array("leading" => 2));


        $this->cezpdf->ezText(utf8_decode_seguro($razon_social . ($razon_social2 != '' ? '-' : '')), 8, array("leading" => 32, 'left' => 60));

        $this->cezpdf->ezText(utf8_decode_seguro($marca), 8, array("leading" => -2, 'left' => 330));

        $this->cezpdf->ezText(utf8_decode_seguro($placa), 8, array("leading" => 0, 'left' => 400));

        /* $this->cezpdf->ezText(utf8_decode_seguro($registro_mtc),9, array("leading"=>0,'left'=>495)); */

        $this->cezpdf->ezText(utf8_decode_seguro($razon_social2), 9, array("leading" => -3, 'left' => -10));

        $this->cezpdf->ezText(utf8_decode_seguro($ruc), 8, array("leading" => 15, 'left' => 15));

        $this->cezpdf->ezText($dni, 9, array("leading" => 0, 'left' => 165));

        $this->cezpdf->ezText(utf8_decode_seguro($nombre_conductor), 8, array("leading" => 0, 'left' => 370));

        $this->cezpdf->ezText(utf8_decode_seguro($licencia), 8, array("leading" => 0, 'left' => 480));


        $this->cezpdf->ezText('', '', array("leading" => 22));


        /* Detalle */

        $db_data = array();

        if (count($datos_detalle_guiarem) > 0) {

            foreach ($datos_detalle_guiarem as $indice => $valor) {

                $producto = $valor->PRODCTOP_Codigo;

                $unidad = $valor->UNDMED_Codigo;

                $costo = $valor->GUIAREMDETC_Costo;

                $venta = $valor->GUIAREMDETC_Venta;

                $peso = $valor->GUIAREMDETC_Peso;

                $descri = $valor->GUIAREMDETC_Descripcion;

                $descri = str_replace('\\', '', $descri);

                $datos_producto = $this->producto_model->obtener_producto($producto);

                $datos_unidad = $this->unidadmedida_model->obtener($unidad);

                $prod_nombre = $datos_producto[0]->PROD_Nombre;

                $prod_codigo = $datos_producto[0]->PROD_CodigoInterno;

                $prod_unidad = $datos_unidad[0]->UNDMED_Simbolo;

                $prod_cantidad = $valor->GUIAREMDETC_Cantidad;

                $db_data[] = array(

                    'col0' => $prod_cantidad,

                    'col1' => $prod_unidad,

                    'col2' => utf8_decode_seguro(substr($descri, 0, 45)),

                    'col3' => ''

                );

            }

        }

        $this->cezpdf->ezTable($db_data, '', '', array(

            'width' => 555,

            'showLines' => 0,

            'shaded' => 0,

            'showHeadings' => 0,

            'xPos' => 'center',

            'fontSize' => 9,

            'cols' => array(

                'col0' => array('width' => 30, 'justification' => 'center'),

                'col1' => array('width' => 30, 'justification' => 'left'),

                'col2' => array('width' => 390, 'justification' => 'left'),

                'col3' => array('width' => 50, 'justification' => 'center')

            )

        ));


        $this->cezpdf->addText(45, 97, 9, substr(utf8_decode_seguro($nombre_emprtrans), 0, 28));

        $this->cezpdf->addText(45, 84, 9, $ruc_emprtrans);

        /* if($referencia==8){

          $this->cezpdf->addText(59,56,9, 'x');

          $this->cezpdf->addText(92,53,9, $numero_ref);

          }

          elseif($referencia==9){

          $this->cezpdf->addText(59,42,9, 'x');

          $this->cezpdf->addText(92,41,9, $numero_ref);

          } */


        $posx = 0;

        $posy = 0;

        //3 venta sujeto a terceros no esta

        switch ($tipo_movimiento) {

            case 1:
                $posx = 307;

                $posy = 104;

                break;

            /* case 2:  $posx=307; $posy=95; break; */

            case 2:
                $posx = 307;

                $posy = 98;

                break;

            case 3:
                $posx = 307;

                $posy = 86;

                break;

            case 4:
                $posx = 307;

                $posy = 76;

                break;

            case 5:
                $posx = 307;

                $posy = 67;

                break;

            case 6:
                $posx = 307;

                $posy = 57;

                break;

            case 7:
                $posx = 307;

                $posy = 48;

                break;

            case 8:
                $posx = 307;

                $posy = 39;

                break;

            case 9:
                $posx = 420;

                $posy = 104;

                break;

            case 10:
                $posx = 420;

                $posy = 95;

                break;

            case 11:
                $posx = 420;

                $posy = 86;

                break;

            case 12:
                $posx = 420;

                $posy = 76;

                break;

            case 13:
                $posx = 420;

                $posy = 67;

                break;

            case 14:
                $posx = 420;

                $posy = 57;

                break;

            case 15:
                $posx = 420;

                $posy = 48;

                break;

            case 16:
                $posx = 420;

                $posy = 39;

                break;

        }

        $this->cezpdf->addText($posx - 132, $posy + 215, 10, 'x');

        if ($tipo_movimiento == 16)

            $this->cezpdf->addText(331, 39, 7, utf8_decode_seguro(substr($otro_motivo, 0, 19)));


        $cabecera = array('Content-Type' => 'application/pdf', 'Content-Disposition' => 'nama_file.pdf', 'Expires' => '0', 'Pragma' => 'cache', 'Cache-Control' => 'private');

        $this->cezpdf->ezStream($cabecera);

    }


    public function guiarem_ver_pdf_conmenbrete_formato7($codigo, $tipo_oper)
    {

        //$this->load->library('cezpdf');

        //$this->load->helper('pdf_helper');

        $datos_guiarem = $this->guiarem_model->obtener($codigo);

        $datos_detalle_guiarem = $this->guiaremdetalle_model->obtener2($codigo);

        $tipo_movimiento = $datos_guiarem[0]->TIPOMOVP_Codigo;

        $referencia = $datos_guiarem[0]->DOCUP_Codigo;

        $cliente = $datos_guiarem[0]->CLIP_Codigo;

        $numero_ref = $datos_guiarem[0]->GUIAREMC_NumeroRef;

        $serie = $datos_guiarem[0]->GUIAREMC_Serie;

        $numero = $datos_guiarem[0]->GUIAREMC_Numero;

        $fecha_traslado = mysql_to_human($datos_guiarem[0]->GUIAREMC_FechaTraslado);

        $observacion = $datos_guiarem[0]->GUIAREMC_Observacion;

        $marca = $datos_guiarem[0]->GUIAREMC_Marca;

        $placa = $datos_guiarem[0]->GUIAREMC_Placa;

        $registro_mtc = $datos_guiarem[0]->GUIAREMC_RegistroMTC;

        $certificado = $datos_guiarem[0]->GUIAREMC_Certificado;

        $licencia = $datos_guiarem[0]->GUIAREMC_Licencia;

        $nombre_conductor = $datos_guiarem[0]->GUIAREMC_NombreConductor;

        $punto_partida = $datos_guiarem[0]->GUIAREMC_PuntoPartida;

        $punto_llegada = $datos_guiarem[0]->GUIAREMC_PuntoLlegada;

        $empresa_transporte = $datos_guiarem[0]->EMPRP_Codigo;

        $fecha = mysql_to_human($datos_guiarem[0]->GUIAREMC_Fecha);

        $otro_motivo = $datos_guiarem[0]->GUIAREMC_OtroMotivo;


        $nombre_emprtrans = "";

        $ruc_emprtrans = "";

        if ($empresa_transporte != '') {

            $datos_emprtrans = $this->empresa_model->obtener_datosEmpresa($empresa_transporte);

            if (count($datos_emprtrans) > 0) {

                $ruc_emprtrans = $datos_emprtrans[0]->EMPRC_Ruc;

                $nombre_emprtrans = $datos_emprtrans[0]->EMPRC_RazonSocial;

            }

        }


        $datos_doc = $this->documento_model->obtener($referencia);

        $nombre_tipodoc = $datos_doc[0]->DOCUC_Descripcion;


        /* Datos del cliente */

        $datos_cliente = $this->cliente_model->obtener($cliente);

        $razon_social = utf8_decode($datos_cliente->nombre);

        $tipo_doc = ($datos_cliente->tipo == '0' ? 'D.N.1' : 'R.U.C.');

        $ruc = $datos_cliente->ruc;

        $dni = $datos_cliente->dni;

        $distrito_cliente = $datos_cliente->distrito;

        $provincia_cliente = $datos_cliente->provincia;

        $departamento_cliente = $datos_cliente->departamento;

        $direccion = $datos_cliente->direccion;


        $punto_partida2 = '';

        if (strlen($punto_partida) > 50) {

            $punto_partida2 = substr($punto_partida, 50);

            $punto_partida = substr($punto_partida, 0, 50);

        }

        $punto_llegada2 = '';

        if (strlen($punto_llegada) > 48) {

            $punto_llegada2 = substr($punto_llegada, 48);

            $punto_llegada = substr($punto_llegada, 0, 48);

        }

        $razon_social2 = '';

        if (strlen($razon_social) > 52) {

            $razon_social2 = substr($razon_social, 52);

            $razon_social = substr($razon_social, 0, 52);

        }


        $direccion2 = '';

        if (strlen($direccion) > 48) {

            $direccion2 = substr($direccion, 48);

            $direccion = substr($direccion, 0, 48);

        }


        /* Cabecera */

        //prep_pdf();


        $this->cezpdf = new backgroundPDF('a4', 'portrait', 'image', array('img' => 'images/img_db/cyl_fondo_guiarem.jpg'));

        $this->cezpdf->ezText('', '', array("leading" => 75));

        $this->cezpdf->ezText($serie, 18, array("leading" => 22, 'left' => 310));

        $this->cezpdf->ezText($numero, 18, array("leading" => 0, 'left' => 415));


        $this->cezpdf->ezText('', '', array("leading" => 5));


        $this->cezpdf->ezText(substr($fecha, 0, 2) . "/", 10, array("leading" => 16, 'left' => 45));

        $this->cezpdf->ezText(substr($fecha, 3, 2) . "/", 10, array("leading" => 0, 'left' => 60));

        $this->cezpdf->ezText(substr($fecha, 8, 2), 10, array("leading" => 0, 'left' => 75));

        /* $this->cezpdf->ezText(substr($fecha_traslado,0,2)."/",10, array("leading"=>0,'left'=>285)); */

        $this->cezpdf->ezText(substr($fecha_traslado, 0, 2) . "/", 10, array("leading" => 0, 'left' => 200));

        $this->cezpdf->ezText(substr($fecha_traslado, 3, 2) . "/", 10, array("leading" => 0, 'left' => 215));

        $this->cezpdf->ezText(substr($fecha_traslado, 8, 2), 10, array("leading" => 0, 'left' => 230));


        $this->cezpdf->ezText(utf8_decode_seguro($razon_social . ($razon_social2 != '' ? '-' : '')), 8, array("leading" => 33, 'left' => 30));


        $this->cezpdf->ezText(utf8_decode_seguro($marca . " / "), 8, array("leading" => 0, 'left' => 380));

        $this->cezpdf->ezText(utf8_decode_seguro($placa), 8, array("leading" => 0, 'left' => 420));


        $this->cezpdf->ezText(utf8_decode_seguro($direccion), 8, array("leading" => 15, 'left' => 25));

        $this->cezpdf->ezText(utf8_decode_seguro($direccion2), 8, array("leading" => 13, 'left' => 25));


        $this->cezpdf->ezText(utf8_decode_seguro($certificado), 8, array("leading" => -13, 'left' => 390));


        $this->cezpdf->ezText(utf8_decode_seguro($ruc), 8, array("leading" => 13, 'left' => 190));


        $this->cezpdf->ezText(utf8_decode_seguro($licencia), 8, array("leading" => 0, 'left' => 370));


        /* $this->cezpdf->ezText(utf8_decode_seguro($registro_mtc),9, array("leading"=>0,'left'=>495)); */

        /* $this->cezpdf->ezText(utf8_decode_seguro($razon_social2),9, array("leading"=>-3,'left'=>-10));

          $this->cezpdf->ezText($dni,9, array("leading"=>0,'left'=>165));

          $this->cezpdf->ezText(utf8_decode_seguro($nombre_conductor),8, array("leading"=>0,'left'=>370)); */


        $this->cezpdf->ezText(utf8_decode_seguro($punto_partida . ($punto_partida2 != '' ? '-' : '')), 8, array("leading" => 22, 'left' => 55));

        $this->cezpdf->ezText(utf8_decode_seguro($punto_llegada . ($punto_llegada2 != '' ? '-' : '')), 8, array("leading" => 14, 'left' => 55));

        /* $this->cezpdf->ezText(utf8_decode_seguro($punto_partida2),8, array("leading"=>13,'left'=>-10));

          $this->cezpdf->ezText(utf8_decode_seguro($punto_llegada2),8, array("leading"=>0,'left'=>280)); */

        /* $this->cezpdf->ezText(utf8_decode_seguro($departamento_cliente),9, array("leading"=>0,'left'=>305));

          $this->cezpdf->ezText(utf8_decode_seguro($provincia_cliente),9, array("leading"=>0,'left'=>400));

          $this->cezpdf->addText(520,630,9, $distrito_cliente); */


        $this->cezpdf->ezText('', '', array("leading" => 2));


        $this->cezpdf->ezText('', '', array("leading" => 22));


        /* Detalle */

        $db_data = array();

        if (count($datos_detalle_guiarem) > 0) {

            foreach ($datos_detalle_guiarem as $indice => $valor) {

                $producto = $valor->PRODCTOP_Codigo;

                $unidad = $valor->UNDMED_Codigo;

                $costo = $valor->GUIAREMDETC_Costo;

                $venta = $valor->GUIAREMDETC_Venta;

                $peso = $valor->GUIAREMDETC_Peso;

                $descri = $valor->GUIAREMDETC_Descripcion;

                $descri = str_replace('\\', '', $descri);

                $datos_producto = $this->producto_model->obtener_producto($producto);

                $datos_unidad = $this->unidadmedida_model->obtener($unidad);

                $prod_nombre = $datos_producto[0]->PROD_Nombre;

                $prod_codigo = $datos_producto[0]->PROD_CodigoInterno;

                $prod_unidad = $datos_unidad[0]->UNDMED_Simbolo;

                $prod_cantidad = $valor->GUIAREMDETC_Cantidad;

                $db_data[] = array(

                    'col0' => $prod_cantidad,

                    'col2' => utf8_decode_seguro(substr($descri, 0, 45)),

                    'col3' => ''

                );

            }

        }

        $this->cezpdf->ezTable($db_data, '', '', array(

            'width' => 555,

            'showLines' => 0,

            'shaded' => 0,

            'showHeadings' => 0,

            'xPos' => 'center',

            'fontSize' => 9,

            'cols' => array(

                'col0' => array('width' => 50, 'justification' => 'center'),

                'col2' => array('width' => 390, 'justification' => 'left'),

                'col3' => array('width' => 130, 'justification' => 'center')

            )

        ));


        /* $this->cezpdf->addText(45,97,9, substr(utf8_decode_seguro($nombre_emprtrans),0,28));

          $this->cezpdf->addText(45,84,9, $ruc_emprtrans); */


        $posx = 0;

        $posy = 0;

        //3 venta sujeto a terceros no esta

        //echo $tipo_movimiento;exit;

        switch ($tipo_movimiento) {

            case 1:
                $posx = 307;

                $posy = 104;

                break;

            case 2:
                $posx = 307;

                $posy = 96;

                break;

            case 3:
                $posx = 307;

                $posy = 89;

                break;


            case 4:
                $posx = 440;

                $posy = 104;

                break;

            case 5:
                $posx = 440;

                $posy = 96;

                break;

            case 6:
                $posx = 440;

                $posy = 89;

                break;


            case 7:
                $posx = 600;

                $posy = 104;

                break;

            case 8:
                $posx = 600;

                $posy = 96;

                break;

            case 9:
                $posx = 600;

                $posy = 89;

                break;


            case 10:
                $posx = 723;

                $posy = 104;

                break;

            /* falta uno que es venta sujeto a terceros */

            case 11:
                $posx = 723;

                $posy = 89;

                break;

            case 12:
                $posx = 723;

                $posy = 80;

                break;


            /* OTROS */

            case 13:
                $posx = 307;

                $posy = 77;

                break;


            case 14:
                $posx = 420;

                $posy = 57;

                break;

            case 15:
                $posx = 420;

                $posy = 48;

                break;

            case 16:
                $posx = 420;

                $posy = 39;

                break;

        }

        $this->cezpdf->addText($posx - 205, $posy + 342, 10, 'x');

        if ($tipo_movimiento == 13)

            $this->cezpdf->addText(35, 420, 7, utf8_decode_seguro(substr($otro_motivo, 0, 19)));


        $cabecera = array('Content-Type' => 'application/pdf', 'Content-Disposition' => 'nama_file.pdf', 'Expires' => '0', 'Pragma' => 'cache', 'Cache-Control' => 'private');

        $this->cezpdf->ezStream($cabecera);

    }


    public function guiarem_ver_pdf_formato5($codigo, $tipo_oper)
    {

        //$this->load->library('cezpdf');

        //$this->load->helper('pdf_helper');

        $datos_guiarem = $this->guiarem_model->obtener($codigo);

        $datos_detalle_guiarem = $this->guiaremdetalle_model->obtener2($codigo);

        $tipo_movimiento = $datos_guiarem[0]->TIPOMOVP_Codigo;

        $referencia = $datos_guiarem[0]->DOCUP_Codigo;

        $cliente = $datos_guiarem[0]->CLIP_Codigo;

        $numero_ref = $datos_guiarem[0]->GUIAREMC_NumeroRef;

        $serie = $datos_guiarem[0]->GUIAREMC_Serie;

        $numero = $datos_guiarem[0]->GUIAREMC_Numero;

        $fecha_traslado = mysql_to_human($datos_guiarem[0]->GUIAREMC_FechaTraslado);

        $observacion = $datos_guiarem[0]->GUIAREMC_Observacion;

        $marca = $datos_guiarem[0]->GUIAREMC_Marca;

        $placa = $datos_guiarem[0]->GUIAREMC_Placa;

        $registro_mtc = $datos_guiarem[0]->GUIAREMC_RegistroMTC;

        $certificado = $datos_guiarem[0]->GUIAREMC_Certificado;

        $licencia = $datos_guiarem[0]->GUIAREMC_Licencia;

        $nombre_conductor = $datos_guiarem[0]->GUIAREMC_NombreConductor;

        $punto_partida = $datos_guiarem[0]->GUIAREMC_PuntoPartida;

        $punto_llegada = $datos_guiarem[0]->GUIAREMC_PuntoLlegada;

        $empresa_transporte = $datos_guiarem[0]->EMPRP_Codigo;

        $fecha = mysql_to_human($datos_guiarem[0]->GUIAREMC_Fecha);

        $otro_motivo = $datos_guiarem[0]->GUIAREMC_OtroMotivo;


        $nombre_emprtrans = "";

        $ruc_emprtrans = "";

        if ($empresa_transporte != '') {

            $datos_emprtrans = $this->empresa_model->obtener_datosEmpresa($empresa_transporte);

            if (count($datos_emprtrans) > 0) {

                $ruc_emprtrans = $datos_emprtrans[0]->EMPRC_Ruc;

                $nombre_emprtrans = $datos_emprtrans[0]->EMPRC_RazonSocial;

            }

        }


        $datos_doc = $this->documento_model->obtener($referencia);

        $nombre_tipodoc = $datos_doc[0]->DOCUC_Descripcion;


        /* Datos del cliente */

        $datos_cliente = $this->cliente_model->obtener($cliente);

        $razon_social = utf8_decode($datos_cliente->nombre);

        $tipo_doc = ($datos_cliente->tipo == '0' ? 'D.N.1' : 'R.U.C.');

        $ruc = $datos_cliente->ruc;

        $dni = $datos_cliente->dni;

        $distrito_cliente = $datos_cliente->distrito;

        $provincia_cliente = $datos_cliente->provincia;

        $departamento_cliente = $datos_cliente->departamento;


        $punto_partida2 = '';

        if (strlen($punto_partida) > 50) {

            $punto_partida2 = substr($punto_partida, 50);

            $punto_partida = substr($punto_partida, 0, 50);

        }

        $punto_llegada2 = '';

        if (strlen($punto_llegada) > 48) {

            $punto_llegada2 = substr($punto_llegada, 48);

            $punto_llegada = substr($punto_llegada, 0, 48);

        }

        $razon_social2 = '';

        if (strlen($razon_social) > 52) {

            $razon_social2 = substr($razon_social, 52);

            $razon_social = substr($razon_social, 0, 52);

        }


        /* Cabecera */

        //prep_pdf();


        $this->cezpdf = new backgroundPDF('a4');

        $this->cezpdf->ezText('', '', array("leading" => 70));

        /* $this->cezpdf->ezText($serie,18, array("leading"=>20,'left'=>320));

          $this->cezpdf->ezText($numero,18, array("leading"=>0,'left'=>425)); */

        $this->cezpdf->ezText('', '', array("leading" => 35));


        $this->cezpdf->ezText(substr($fecha, 0, 2) . " / ", 8, array("leading" => 15, 'left' => 70));

        $this->cezpdf->ezText(substr($fecha, 3, 2) . " / ", 8, array("leading" => 0, 'left' => 85));

        $this->cezpdf->ezText(substr($fecha, 8, 2), 8, array("leading" => 0, 'left' => 100));

        $this->cezpdf->ezText(substr($fecha_traslado, 0, 2) . " / ", 8, array("leading" => 0, 'left' => 300));

        $this->cezpdf->ezText(substr($fecha_traslado, 3, 2) . " / ", 8, array("leading" => 0, 'left' => 315));

        $this->cezpdf->ezText(substr($fecha_traslado, 8, 2), 8, array("leading" => 0, 'left' => 330));

        $this->cezpdf->ezText(utf8_decode_seguro($punto_partida . ($punto_partida2 != '' ? '-' : '')), 8, array("leading" => 30, 'left' => 40));

        $this->cezpdf->ezText(utf8_decode_seguro($punto_llegada . ($punto_llegada2 != '' ? '-' : '')), 8, array("leading" => 0, 'left' => 330));

        $this->cezpdf->ezText(utf8_decode_seguro($punto_partida2), 8, array("leading" => 13, 'left' => -10));

        $this->cezpdf->ezText(utf8_decode_seguro($punto_llegada2), 8, array("leading" => 0, 'left' => 290));

        /* $this->cezpdf->ezText('LIMA',9, array("leading"=>10,'left'=>15));

          $this->cezpdf->ezText('LIMA',9, array("leading"=>0,'left'=>110));

          $this->cezpdf->ezText('ATE',9, array("leading"=>0,'left'=>205)); */

        /* $this->cezpdf->ezText(utf8_decode_seguro($departamento_cliente),9, array("leading"=>0,'left'=>305));

          $this->cezpdf->ezText(utf8_decode_seguro($provincia_cliente),9, array("leading"=>0,'left'=>400));

          $this->cezpdf->addText(520,630,9, $distrito_cliente); */

        $this->cezpdf->ezText(utf8_decode_seguro($razon_social . ($razon_social2 != '' ? '-' : '')), 8, array("leading" => 32, 'left' => 70));

        $this->cezpdf->ezText(utf8_decode_seguro($marca), 8, array("leading" => 0, 'left' => 345));

        $this->cezpdf->ezText(utf8_decode_seguro($placa), 8, array("leading" => 0, 'left' => 420));

        /* $this->cezpdf->ezText(utf8_decode_seguro($registro_mtc),9, array("leading"=>0,'left'=>495)); */

        $this->cezpdf->ezText(utf8_decode_seguro($razon_social2), 9, array("leading" => -3, 'left' => -10));

        $this->cezpdf->ezText(utf8_decode_seguro($ruc), 8, array("leading" => 15, 'left' => 25));

        $this->cezpdf->ezText($dni, 9, array("leading" => 0, 'left' => 165));

        $this->cezpdf->ezText(utf8_decode_seguro($nombre_conductor), 8, array("leading" => 0, 'left' => 385));

        $this->cezpdf->ezText(utf8_decode_seguro($licencia), 8, array("leading" => 0, 'left' => 500));


        $this->cezpdf->ezText('', '', array("leading" => 22));


        /* Detalle */

        $db_data = array();

        if (count($datos_detalle_guiarem) > 0) {

            foreach ($datos_detalle_guiarem as $indice => $valor) {

                $producto = $valor->PRODCTOP_Codigo;

                $unidad = $valor->UNDMED_Codigo;

                $costo = $valor->GUIAREMDETC_Costo;

                $venta = $valor->GUIAREMDETC_Venta;

                $peso = $valor->GUIAREMDETC_Peso;

                $descri = $valor->GUIAREMDETC_Descripcion;

                $descri = str_replace('\\', '', $descri);

                $datos_producto = $this->producto_model->obtener_producto($producto);

                $datos_unidad = $this->unidadmedida_model->obtener($unidad);

                $prod_nombre = $datos_producto[0]->PROD_Nombre;

                $prod_codigo = $datos_producto[0]->PROD_CodigoInterno;

                $prod_unidad = $datos_unidad[0]->UNDMED_Simbolo;

                $prod_cantidad = $valor->GUIAREMDETC_Cantidad;

                $db_data[] = array(

                    'col4' => '',

                    'col0' => $prod_cantidad,

                    'col1' => utf8_decode_seguro(substr($descri, 0, 45)),

                    'col2' => $prod_unidad,

                    'col3' => ''

                );

            }

        }

        $this->cezpdf->ezTable($db_data, '', '', array(

            'width' => 555,

            'showLines' => 0,

            'shaded' => 0,

            'showHeadings' => 0,

            'xPos' => 'center',

            'fontSize' => 9,

            'cols' => array(

                'col4' => array('width' => 50, 'justification' => 'center'),

                'col0' => array('width' => 30, 'justification' => 'center'),

                'col1' => array('width' => 410, 'justification' => 'left'),

                'col2' => array('width' => 80, 'justification' => 'center'),

                'col3' => array('width' => 35, 'justification' => 'center')

            )

        ));


        /* $this->cezpdf->addText(45,97,9, substr(utf8_decode_seguro($nombre_emprtrans),0,28));

          $this->cezpdf->addText(45,84,9, $ruc_emprtrans); */

        /* if($referencia==8){

          $this->cezpdf->addText(59,56,9, 'x');

          $this->cezpdf->addText(92,53,9, $numero_ref);

          }

          elseif($referencia==9){

          $this->cezpdf->addText(59,42,9, 'x');

          $this->cezpdf->addText(92,41,9, $numero_ref);

          } */


        $posx = 0;

        $posy = 0;

        //3 venta sujeto a terceros no esta

        switch ($tipo_movimiento) {

            case 1:
                $posx = 307;

                $posy = 104;

                break;

            /* case 2:  $posx=307; $posy=95; break; */

            case 2:
                $posx = 307;

                $posy = 98;

                break;

            case 3:
                $posx = 307;

                $posy = 86;

                break;

            case 4:
                $posx = 307;

                $posy = 76;

                break;

            case 5:
                $posx = 307;

                $posy = 67;

                break;

            case 6:
                $posx = 307;

                $posy = 57;

                break;

            case 7:
                $posx = 307;

                $posy = 48;

                break;

            case 8:
                $posx = 307;

                $posy = 39;

                break;

            case 9:
                $posx = 420;

                $posy = 104;

                break;

            case 10:
                $posx = 420;

                $posy = 95;

                break;

            case 11:
                $posx = 420;

                $posy = 86;

                break;

            case 12:
                $posx = 420;

                $posy = 76;

                break;

            case 13:
                $posx = 420;

                $posy = 67;

                break;

            case 14:
                $posx = 420;

                $posy = 57;

                break;

            case 15:
                $posx = 420;

                $posy = 48;

                break;

            case 16:
                $posx = 420;

                $posy = 39;

                break;

        }

        $this->cezpdf->addText($posx - 120, $posy + 187, 10, 'x');

        if ($tipo_movimiento == 16)

            $this->cezpdf->addText(331, 39, 7, utf8_decode_seguro(substr($otro_motivo, 0, 19)));


        $cabecera = array('Content-Type' => 'application/pdf', 'Content-Disposition' => 'nama_file.pdf', 'Expires' => '0', 'Pragma' => 'cache', 'Cache-Control' => 'private');

        $this->cezpdf->ezStream($cabecera);

    }


    public function guiarem_ver_pdf_formato6($codigo, $tipo_oper)
    {

        //$this->load->library('cezpdf');

        //$this->load->helper('pdf_helper');

        $datos_guiarem = $this->guiarem_model->obtener($codigo);

        $datos_detalle_guiarem = $this->guiaremdetalle_model->obtener2($codigo);

        $tipo_movimiento = $datos_guiarem[0]->TIPOMOVP_Codigo;

        $referencia = $datos_guiarem[0]->DOCUP_Codigo;

        $cliente = $datos_guiarem[0]->CLIP_Codigo;

        $numero_ref = $datos_guiarem[0]->GUIAREMC_NumeroRef;

        $serie = $datos_guiarem[0]->GUIAREMC_Serie;

        $numero = $datos_guiarem[0]->GUIAREMC_Numero;

        $fecha_traslado = mysql_to_human($datos_guiarem[0]->GUIAREMC_FechaTraslado);

        $observacion = $datos_guiarem[0]->GUIAREMC_Observacion;

        $marca = $datos_guiarem[0]->GUIAREMC_Marca;

        $placa = $datos_guiarem[0]->GUIAREMC_Placa;

        $registro_mtc = $datos_guiarem[0]->GUIAREMC_RegistroMTC;

        $certificado = $datos_guiarem[0]->GUIAREMC_Certificado;

        $licencia = $datos_guiarem[0]->GUIAREMC_Licencia;

        $nombre_conductor = $datos_guiarem[0]->GUIAREMC_NombreConductor;

        $punto_partida = $datos_guiarem[0]->GUIAREMC_PuntoPartida;

        $punto_llegada = $datos_guiarem[0]->GUIAREMC_PuntoLlegada;

        $empresa_transporte = $datos_guiarem[0]->EMPRP_Codigo;

        $fecha = mysql_to_human($datos_guiarem[0]->GUIAREMC_Fecha);

        $otro_motivo = $datos_guiarem[0]->GUIAREMC_OtroMotivo;


        $nombre_emprtrans = "";

        $ruc_emprtrans = "";

        if ($empresa_transporte != '') {

            $datos_emprtrans = $this->empresa_model->obtener_datosEmpresa($empresa_transporte);

            if (count($datos_emprtrans) > 0) {

                $ruc_emprtrans = $datos_emprtrans[0]->EMPRC_Ruc;

                $nombre_emprtrans = $datos_emprtrans[0]->EMPRC_RazonSocial;

            }

        }


        $datos_doc = $this->documento_model->obtener($referencia);

        $nombre_tipodoc = $datos_doc[0]->DOCUC_Descripcion;


        /* Datos del cliente */

        $datos_cliente = $this->cliente_model->obtener($cliente);

        $razon_social = utf8_decode($datos_cliente->nombre);

        $tipo_doc = ($datos_cliente->tipo == '0' ? 'D.N.1' : 'R.U.C.');

        $ruc = $datos_cliente->ruc;

        $dni = $datos_cliente->dni;

        $distrito_cliente = $datos_cliente->distrito;

        $provincia_cliente = $datos_cliente->provincia;

        $departamento_cliente = $datos_cliente->departamento;


        $punto_partida2 = '';

        if (strlen($punto_partida) > 50) {

            $punto_partida2 = substr($punto_partida, 50);

            $punto_partida = substr($punto_partida, 0, 50);

        }

        $punto_llegada2 = '';

        if (strlen($punto_llegada) > 48) {

            $punto_llegada2 = substr($punto_llegada, 48);

            $punto_llegada = substr($punto_llegada, 0, 48);

        }

        $razon_social2 = '';

        if (strlen($razon_social) > 52) {

            $razon_social2 = substr($razon_social, 52);

            $razon_social = substr($razon_social, 0, 52);

        }


        /* Cabecera */

        //prep_pdf();


        $this->cezpdf = new backgroundPDF('a4');

        $this->cezpdf->ezText('', '', array("leading" => 73));

        /* $this->cezpdf->ezText($serie,18, array("leading"=>22,'left'=>320));

          $this->cezpdf->ezText($numero,18, array("leading"=>0,'left'=>425)); */


        $this->cezpdf->ezText('', '', array("leading" => 33));


        $this->cezpdf->ezText(substr($fecha, 0, 2) . " / ", 8, array("leading" => 16, 'left' => 65));

        $this->cezpdf->ezText(substr($fecha, 3, 2) . " / ", 8, array("leading" => 0, 'left' => 80));

        $this->cezpdf->ezText(substr($fecha, 8, 2), 8, array("leading" => 0, 'left' => 95));

        $this->cezpdf->ezText(substr($fecha_traslado, 0, 2) . " / ", 8, array("leading" => 0, 'left' => 305));

        $this->cezpdf->ezText(substr($fecha_traslado, 3, 2) . " / ", 8, array("leading" => 0, 'left' => 320));

        $this->cezpdf->ezText(substr($fecha_traslado, 8, 2), 8, array("leading" => 0, 'left' => 335));

        $this->cezpdf->ezText(utf8_decode_seguro($punto_partida . ($punto_partida2 != '' ? '-' : '')), 8, array("leading" => 30, 'left' => 30));

        $this->cezpdf->ezText(utf8_decode_seguro($punto_llegada . ($punto_llegada2 != '' ? '-' : '')), 8, array("leading" => 0, 'left' => 310));

        $this->cezpdf->ezText(utf8_decode_seguro($punto_partida2), 8, array("leading" => 13, 'left' => 10));

        $this->cezpdf->ezText(utf8_decode_seguro($punto_llegada2), 8, array("leading" => 0, 'left' => 300));

        /* $this->cezpdf->ezText(utf8_decode_seguro($departamento_cliente),9, array("leading"=>0,'left'=>305));

          $this->cezpdf->ezText(utf8_decode_seguro($provincia_cliente),9, array("leading"=>0,'left'=>400));

          $this->cezpdf->addText(520,630,9, $distrito_cliente); */


        $this->cezpdf->ezText('', '', array("leading" => 2));


        $this->cezpdf->ezText(utf8_decode_seguro($razon_social . ($razon_social2 != '' ? '-' : '')), 8, array("leading" => 32, 'left' => 60));

        $this->cezpdf->ezText(utf8_decode_seguro($marca), 8, array("leading" => -2, 'left' => 350));

        $this->cezpdf->ezText(utf8_decode_seguro($placa), 8, array("leading" => 0, 'left' => 420));

        /* $this->cezpdf->ezText(utf8_decode_seguro($registro_mtc),9, array("leading"=>0,'left'=>495)); */

        $this->cezpdf->ezText(utf8_decode_seguro($razon_social2), 9, array("leading" => -3, 'left' => -10));

        $this->cezpdf->ezText(utf8_decode_seguro($ruc), 8, array("leading" => 15, 'left' => 15));

        $this->cezpdf->ezText($dni, 9, array("leading" => 0, 'left' => 165));

        $this->cezpdf->ezText(utf8_decode_seguro($nombre_conductor), 8, array("leading" => 0, 'left' => 390));

        $this->cezpdf->ezText(utf8_decode_seguro($licencia), 8, array("leading" => 0, 'left' => 500));


        $this->cezpdf->ezText('', '', array("leading" => 28));


        /* Detalle */

        $db_data = array();

        if (count($datos_detalle_guiarem) > 0) {

            foreach ($datos_detalle_guiarem as $indice => $valor) {

                $producto = $valor->PRODCTOP_Codigo;

                $unidad = $valor->UNDMED_Codigo;

                $costo = $valor->GUIAREMDETC_Costo;

                $venta = $valor->GUIAREMDETC_Venta;

                $peso = $valor->GUIAREMDETC_Peso;

                $descri = $valor->GUIAREMDETC_Descripcion;

                $descri = str_replace('\\', '', $descri);

                $datos_producto = $this->producto_model->obtener_producto($producto);

                $datos_unidad = $this->unidadmedida_model->obtener($unidad);

                $prod_nombre = $datos_producto[0]->PROD_Nombre;

                $prod_codigo = $datos_producto[0]->PROD_CodigoInterno;

                $prod_unidad = $datos_unidad[0]->UNDMED_Simbolo;

                $prod_cantidad = $valor->GUIAREMDETC_Cantidad;

                $db_data[] = array(

                    'col0' => $prod_cantidad,

                    'col1' => $prod_unidad,

                    'col2' => utf8_decode_seguro(substr($descri, 0, 45)),

                    'col3' => ''

                );

            }

        }

        $this->cezpdf->ezTable($db_data, '', '', array(

            'width' => 555,

            'showLines' => 0,

            'shaded' => 0,

            'showHeadings' => 0,

            'xPos' => 'center',

            'fontSize' => 9,

            'cols' => array(

                'col0' => array('width' => 40, 'justification' => 'center'),

                'col1' => array('width' => 40, 'justification' => 'left'),

                'col2' => array('width' => 390, 'justification' => 'left'),

                'col3' => array('width' => 50, 'justification' => 'center')

            )

        ));


        /* $this->cezpdf->addText(45,97,9, substr(utf8_decode_seguro($nombre_emprtrans),0,28));

          $this->cezpdf->addText(45,84,9, $ruc_emprtrans); */


        $posx = 0;

        $posy = 0;

        //3 venta sujeto a terceros no esta

        switch ($tipo_movimiento) {

            case 1:
                $posx = 307;

                $posy = 104;

                break;

            /* case 2:  $posx=307; $posy=95; break; */

            case 2:
                $posx = 307;

                $posy = 98;

                break;

            case 3:
                $posx = 307;

                $posy = 86;

                break;

            case 4:
                $posx = 307;

                $posy = 76;

                break;

            case 5:
                $posx = 307;

                $posy = 67;

                break;

            case 6:
                $posx = 307;

                $posy = 57;

                break;

            case 7:
                $posx = 307;

                $posy = 48;

                break;

            case 8:
                $posx = 307;

                $posy = 39;

                break;

            case 9:
                $posx = 420;

                $posy = 104;

                break;

            case 10:
                $posx = 420;

                $posy = 95;

                break;

            case 11:
                $posx = 420;

                $posy = 86;

                break;

            case 12:
                $posx = 420;

                $posy = 76;

                break;

            case 13:
                $posx = 420;

                $posy = 67;

                break;

            case 14:
                $posx = 420;

                $posy = 57;

                break;

            case 15:
                $posx = 420;

                $posy = 48;

                break;

            case 16:
                $posx = 420;

                $posy = 39;

                break;

        }

        $this->cezpdf->addText($posx - 130, $posy + 215, 10, 'x');

        if ($tipo_movimiento == 16)

            $this->cezpdf->addText(331, 39, 7, utf8_decode_seguro(substr($otro_motivo, 0, 19)));


        $cabecera = array('Content-Type' => 'application/pdf', 'Content-Disposition' => 'nama_file.pdf', 'Expires' => '0', 'Pragma' => 'cache', 'Cache-Control' => 'private');

        $this->cezpdf->ezStream($cabecera);

    }


    public function guiarem_ver_pdf_formato7($codigo, $tipo_oper)
    {

        //$this->load->library('cezpdf');

        //$this->load->helper('pdf_helper');

        $datos_guiarem = $this->guiarem_model->obtener($codigo);

        $datos_detalle_guiarem = $this->guiaremdetalle_model->obtener2($codigo);

        $tipo_movimiento = $datos_guiarem[0]->TIPOMOVP_Codigo;

        $referencia = $datos_guiarem[0]->DOCUP_Codigo;

        $cliente = $datos_guiarem[0]->CLIP_Codigo;

        $numero_ref = $datos_guiarem[0]->GUIAREMC_NumeroRef;

        $serie = $datos_guiarem[0]->GUIAREMC_Serie;

        $numero = $datos_guiarem[0]->GUIAREMC_Numero;

        $fecha_traslado = mysql_to_human($datos_guiarem[0]->GUIAREMC_FechaTraslado);

        $observacion = $datos_guiarem[0]->GUIAREMC_Observacion;

        $marca = $datos_guiarem[0]->GUIAREMC_Marca;

        $placa = $datos_guiarem[0]->GUIAREMC_Placa;

        $registro_mtc = $datos_guiarem[0]->GUIAREMC_RegistroMTC;

        $certificado = $datos_guiarem[0]->GUIAREMC_Certificado;

        $licencia = $datos_guiarem[0]->GUIAREMC_Licencia;

        $nombre_conductor = $datos_guiarem[0]->GUIAREMC_NombreConductor;

        $punto_partida = $datos_guiarem[0]->GUIAREMC_PuntoPartida;

        $punto_llegada = $datos_guiarem[0]->GUIAREMC_PuntoLlegada;

        $empresa_transporte = $datos_guiarem[0]->EMPRP_Codigo;

        $fecha = mysql_to_human($datos_guiarem[0]->GUIAREMC_Fecha);

        $otro_motivo = $datos_guiarem[0]->GUIAREMC_OtroMotivo;


        $nombre_emprtrans = "";

        $ruc_emprtrans = "";

        if ($empresa_transporte != '') {

            $datos_emprtrans = $this->empresa_model->obtener_datosEmpresa($empresa_transporte);

            if (count($datos_emprtrans) > 0) {

                $ruc_emprtrans = $datos_emprtrans[0]->EMPRC_Ruc;

                $nombre_emprtrans = $datos_emprtrans[0]->EMPRC_RazonSocial;

            }

        }


        $datos_doc = $this->documento_model->obtener($referencia);

        $nombre_tipodoc = $datos_doc[0]->DOCUC_Descripcion;


        /* Datos del cliente */

        $datos_cliente = $this->cliente_model->obtener($cliente);

        $razon_social = utf8_decode($datos_cliente->nombre);

        $tipo_doc = ($datos_cliente->tipo == '0' ? 'D.N.1' : 'R.U.C.');

        $ruc = $datos_cliente->ruc;

        $dni = $datos_cliente->dni;

        $distrito_cliente = $datos_cliente->distrito;

        $provincia_cliente = $datos_cliente->provincia;

        $departamento_cliente = $datos_cliente->departamento;

        $direccion = $datos_cliente->direccion;


        $punto_partida2 = '';

        if (strlen($punto_partida) > 50) {

            $punto_partida2 = substr($punto_partida, 50);

            $punto_partida = substr($punto_partida, 0, 50);

        }

        $punto_llegada2 = '';

        if (strlen($punto_llegada) > 48) {

            $punto_llegada2 = substr($punto_llegada, 48);

            $punto_llegada = substr($punto_llegada, 0, 48);

        }

        $razon_social2 = '';

        if (strlen($razon_social) > 52) {

            $razon_social2 = substr($razon_social, 52);

            $razon_social = substr($razon_social, 0, 52);

        }


        $direccion2 = '';

        if (strlen($direccion) > 48) {

            $direccion2 = substr($direccion, 48);

            $direccion = substr($direccion, 0, 48);

        }


        /* Cabecera */

        //prep_pdf();


        $this->cezpdf = new backgroundPDF('a4');

        $this->cezpdf->ezText('', '', array("leading" => 75));

        /* $this->cezpdf->ezText($serie,18, array("leading"=>22,'left'=>310));

          $this->cezpdf->ezText($numero,18, array("leading"=>0,'left'=>415)); */


        $this->cezpdf->ezText('', '', array("leading" => 22));


        $this->cezpdf->ezText(substr($fecha, 0, 2) . "/", 10, array("leading" => 16, 'left' => 45));

        $this->cezpdf->ezText(substr($fecha, 3, 2) . "/", 10, array("leading" => 0, 'left' => 60));

        $this->cezpdf->ezText(substr($fecha, 8, 2), 10, array("leading" => 0, 'left' => 75));

        /* $this->cezpdf->ezText(substr($fecha_traslado,0,2)."/",10, array("leading"=>0,'left'=>285)); */

        $this->cezpdf->ezText(substr($fecha_traslado, 0, 2) . "/", 10, array("leading" => 0, 'left' => 200));

        $this->cezpdf->ezText(substr($fecha_traslado, 3, 2) . "/", 10, array("leading" => 0, 'left' => 215));

        $this->cezpdf->ezText(substr($fecha_traslado, 8, 2), 10, array("leading" => 0, 'left' => 230));


        $this->cezpdf->ezText(utf8_decode_seguro($razon_social . ($razon_social2 != '' ? '-' : '')), 8, array("leading" => 33, 'left' => 30));


        $this->cezpdf->ezText(utf8_decode_seguro($marca . " / "), 8, array("leading" => 0, 'left' => 400));

        $this->cezpdf->ezText(utf8_decode_seguro($placa), 8, array("leading" => 0, 'left' => 440));


        $this->cezpdf->ezText(utf8_decode_seguro($direccion), 8, array("leading" => 15, 'left' => 25));

        $this->cezpdf->ezText(utf8_decode_seguro($direccion2), 8, array("leading" => 13, 'left' => 25));


        $this->cezpdf->ezText(utf8_decode_seguro($certificado), 8, array("leading" => -13, 'left' => 410));


        $this->cezpdf->ezText(utf8_decode_seguro($ruc), 8, array("leading" => 13, 'left' => 190));


        $this->cezpdf->ezText(utf8_decode_seguro($licencia), 8, array("leading" => 0, 'left' => 390));


        /* $this->cezpdf->ezText(utf8_decode_seguro($registro_mtc),9, array("leading"=>0,'left'=>495)); */

        /* $this->cezpdf->ezText(utf8_decode_seguro($razon_social2),9, array("leading"=>-3,'left'=>-10));

          $this->cezpdf->ezText($dni,9, array("leading"=>0,'left'=>165));

          $this->cezpdf->ezText(utf8_decode_seguro($nombre_conductor),8, array("leading"=>0,'left'=>370)); */


        $this->cezpdf->ezText(utf8_decode_seguro($punto_partida . ($punto_partida2 != '' ? '-' : '')), 8, array("leading" => 22, 'left' => 55));

        $this->cezpdf->ezText(utf8_decode_seguro($punto_llegada . ($punto_llegada2 != '' ? '-' : '')), 8, array("leading" => 14, 'left' => 55));

        /* $this->cezpdf->ezText(utf8_decode_seguro($punto_partida2),8, array("leading"=>13,'left'=>-10));

          $this->cezpdf->ezText(utf8_decode_seguro($punto_llegada2),8, array("leading"=>0,'left'=>280)); */

        /* $this->cezpdf->ezText(utf8_decode_seguro($departamento_cliente),9, array("leading"=>0,'left'=>305));

          $this->cezpdf->ezText(utf8_decode_seguro($provincia_cliente),9, array("leading"=>0,'left'=>400));

          $this->cezpdf->addText(520,630,9, $distrito_cliente); */


        $this->cezpdf->ezText('', '', array("leading" => 2));


        $this->cezpdf->ezText('', '', array("leading" => 22));


        /* Detalle */

        $db_data = array();

        if (count($datos_detalle_guiarem) > 0) {

            foreach ($datos_detalle_guiarem as $indice => $valor) {

                $producto = $valor->PRODCTOP_Codigo;

                $unidad = $valor->UNDMED_Codigo;

                $costo = $valor->GUIAREMDETC_Costo;

                $venta = $valor->GUIAREMDETC_Venta;

                $peso = $valor->GUIAREMDETC_Peso;

                $descri = $valor->GUIAREMDETC_Descripcion;

                $descri = str_replace('\\', '', $descri);

                $datos_producto = $this->producto_model->obtener_producto($producto);

                $datos_unidad = $this->unidadmedida_model->obtener($unidad);

                $prod_nombre = $datos_producto[0]->PROD_Nombre;

                $prod_codigo = $datos_producto[0]->PROD_CodigoInterno;

                $prod_unidad = $datos_unidad[0]->UNDMED_Simbolo;

                $prod_cantidad = $valor->GUIAREMDETC_Cantidad;

                $db_data[] = array(

                    'col0' => $prod_cantidad,

                    'col2' => utf8_decode_seguro(substr($descri, 0, 45)),

                    'col3' => ''

                );

            }

        }

        $this->cezpdf->ezTable($db_data, '', '', array(

            'width' => 555,

            'showLines' => 0,

            'shaded' => 0,

            'showHeadings' => 0,

            'xPos' => 'center',

            'fontSize' => 9,

            'cols' => array(

                'col0' => array('width' => 50, 'justification' => 'center'),

                'col2' => array('width' => 390, 'justification' => 'left'),

                'col3' => array('width' => 130, 'justification' => 'center')

            )

        ));


        /* $this->cezpdf->addText(45,97,9, substr(utf8_decode_seguro($nombre_emprtrans),0,28));

          $this->cezpdf->addText(45,84,9, $ruc_emprtrans); */


        $posx = 0;

        $posy = 0;

        //3 venta sujeto a terceros no esta

        //echo $tipo_movimiento;exit;

        switch ($tipo_movimiento) {

            case 1:
                $posx = 307;

                $posy = 104;

                break;

            case 2:
                $posx = 307;

                $posy = 96;

                break;

            case 3:
                $posx = 307;

                $posy = 89;

                break;


            case 4:
                $posx = 440;

                $posy = 104;

                break;

            case 5:
                $posx = 440;

                $posy = 96;

                break;

            case 6:
                $posx = 440;

                $posy = 89;

                break;


            case 7:
                $posx = 600;

                $posy = 104;

                break;

            case 8:
                $posx = 600;

                $posy = 96;

                break;

            case 9:
                $posx = 600;

                $posy = 89;

                break;


            case 10:
                $posx = 723;

                $posy = 104;

                break;

            /* falta uno que es venta sujeto a terceros */

            case 11:
                $posx = 723;

                $posy = 89;

                break;

            case 12:
                $posx = 723;

                $posy = 80;

                break;


            /* OTROS */

            case 13:
                $posx = 307;

                $posy = 77;

                break;


            case 14:
                $posx = 420;

                $posy = 57;

                break;

            case 15:
                $posx = 420;

                $posy = 48;

                break;

            case 16:
                $posx = 420;

                $posy = 39;

                break;

        }

        $this->cezpdf->addText($posx - 205, $posy + 342, 10, 'x');

        if ($tipo_movimiento == 13)

            $this->cezpdf->addText(35, 420, 7, utf8_decode_seguro(substr($otro_motivo, 0, 19)));


        $cabecera = array('Content-Type' => 'application/pdf', 'Content-Disposition' => 'nama_file.pdf', 'Expires' => '0', 'Pragma' => 'cache', 'Cache-Control' => 'private');

        $this->cezpdf->ezStream($cabecera);

    }


    public function guiarem_ver_pdf_conmenbrete_formato8($codigo, $tipo_oper)
    {

        //$this->load->library('cezpdf');

        //$this->load->helper('pdf_helper');

        $datos_guiarem = $this->guiarem_model->obtener($codigo);

        $datos_detalle_guiarem = $this->guiaremdetalle_model->obtener2($codigo);

        $tipo_movimiento = $datos_guiarem[0]->TIPOMOVP_Codigo;

        $referencia = $datos_guiarem[0]->DOCUP_Codigo;

        $cliente = $datos_guiarem[0]->CLIP_Codigo;

        $numero_ref = $datos_guiarem[0]->GUIAREMC_NumeroRef;

        $serie = $datos_guiarem[0]->GUIAREMC_Serie;

        $numero = $datos_guiarem[0]->GUIAREMC_Numero;

        $fecha_traslado = mysql_to_human($datos_guiarem[0]->GUIAREMC_FechaTraslado);

        $observacion = $datos_guiarem[0]->GUIAREMC_Observacion;

        $marca = $datos_guiarem[0]->GUIAREMC_Marca;

        $placa = $datos_guiarem[0]->GUIAREMC_Placa;

        $registro_mtc = $datos_guiarem[0]->GUIAREMC_RegistroMTC;

        $certificado = $datos_guiarem[0]->GUIAREMC_Certificado;

        $licencia = $datos_guiarem[0]->GUIAREMC_Licencia;

        $nombre_conductor = $datos_guiarem[0]->GUIAREMC_NombreConductor;

        $punto_partida = $datos_guiarem[0]->GUIAREMC_PuntoPartida;

        $punto_llegada = $datos_guiarem[0]->GUIAREMC_PuntoLlegada;

        $empresa_transporte = $datos_guiarem[0]->EMPRP_Codigo;

        $fecha = mysql_to_human($datos_guiarem[0]->GUIAREMC_Fecha);

        $otro_motivo = $datos_guiarem[0]->GUIAREMC_OtroMotivo;


        $nombre_emprtrans = "";

        $ruc_emprtrans = "";

        if ($empresa_transporte != '') {

            $datos_emprtrans = $this->empresa_model->obtener_datosEmpresa($empresa_transporte);

            if (count($datos_emprtrans) > 0) {

                $ruc_emprtrans = $datos_emprtrans[0]->EMPRC_Ruc;

                $nombre_emprtrans = $datos_emprtrans[0]->EMPRC_RazonSocial;

            }

        }


        $datos_doc = $this->documento_model->obtener($referencia);

        $nombre_tipodoc = $datos_doc[0]->DOCUC_Descripcion;


        /* Datos del cliente */

        $datos_cliente = $this->cliente_model->obtener($cliente);

        $razon_social = utf8_decode($datos_cliente->nombre);

        $tipo_doc = ($datos_cliente->tipo == '0' ? 'D.N.1' : 'R.U.C.');

        $ruc = $datos_cliente->ruc;

        $dni = $datos_cliente->dni;

        $distrito_cliente = $datos_cliente->distrito;

        $provincia_cliente = $datos_cliente->provincia;

        $departamento_cliente = $datos_cliente->departamento;

        $direccion = $datos_cliente->direccion;


        $punto_partida2 = '';

        if (strlen($punto_partida) > 50) {

            $punto_partida2 = substr($punto_partida, 50);

            $punto_partida = substr($punto_partida, 0, 50);

        }

        $punto_llegada2 = '';

        if (strlen($punto_llegada) > 48) {

            $punto_llegada2 = substr($punto_llegada, 48);

            $punto_llegada = substr($punto_llegada, 0, 48);

        }

        $razon_social2 = '';

        if (strlen($razon_social) > 52) {

            $razon_social2 = substr($razon_social, 52);

            $razon_social = substr($razon_social, 0, 52);

        }


        $direccion2 = '';

        if (strlen($direccion) > 48) {

            $direccion2 = substr($direccion, 48);

            $direccion = substr($direccion, 0, 48);

        }


        /* Cabecera */

        //prep_pdf();


        $this->cezpdf = new backgroundPDF('a4', 'portrait', 'image', array('img' => 'images/img_db/famyserfe_guiarem.jpg'));

        $this->cezpdf->ezText('', '', array("leading" => 65));

        $this->cezpdf->ezText($serie, 18, array("leading" => 22, 'left' => 310));

        $this->cezpdf->ezText($numero, 18, array("leading" => 0, 'left' => 415));


        $this->cezpdf->ezText('', '', array("leading" => 6));


        /* $this->cezpdf->ezText(substr($fecha,0,2)."/",10, array("leading"=>16,'left'=>45));

          $this->cezpdf->ezText(substr($fecha,3,2)."/",10, array("leading"=>0,'left'=>60));

          $this->cezpdf->ezText(substr($fecha,8,2),10, array("leading"=>0,'left'=>75)); */

        //FECHA DE TRASLADO

        /* $this->cezpdf->ezText(substr($fecha_traslado,0,2)."/",10, array("leading"=>0,'left'=>200));

          $this->cezpdf->ezText(substr($fecha_traslado,3,2)."/",10, array("leading"=>0,'left'=>215));

          $this->cezpdf->ezText(substr($fecha_traslado,8,2),10, array("leading"=>0,'left'=>230)); */


        $this->cezpdf->ezText(utf8_decode_seguro($razon_social . ($razon_social2 != '' ? '-' : '')), 8, array("leading" => 33, 'left' => 30));


        $this->cezpdf->ezText(substr(utf8_decode_seguro($nombre_emprtrans), 0, 28), 8, array("leading" => 0, 'left' => 340));


        $this->cezpdf->ezText(utf8_decode_seguro($direccion), 8, array("leading" => 15, 'left' => 50));

        //$this->cezpdf->ezText(utf8_decode_seguro($direccion2),8, array("leading"=>13,'left'=>25));


        $this->cezpdf->ezText(utf8_decode_seguro($ruc), 8, array("leading" => 16, 'left' => 5));


        $this->cezpdf->ezText($ruc_emprtrans, 8, array("leading" => 0, 'left' => 310));

        $this->cezpdf->ezText(utf8_decode_seguro($placa), 8, array("leading" => 0, 'left' => 470));


        $this->cezpdf->ezText('', '', array("leading" => 17));


        $this->cezpdf->ezText(substr($fecha_traslado, 0, 2) . "/", 10, array("leading" => 0, 'left' => 10));

        $this->cezpdf->ezText(substr($fecha_traslado, 3, 2) . "/", 10, array("leading" => 0, 'left' => 25));

        $this->cezpdf->ezText(substr($fecha_traslado, 8, 2), 10, array("leading" => 0, 'left' => 40));


        $this->cezpdf->ezText(utf8_decode_seguro($licencia), 8, array("leading" => 0, 'left' => 320));

        $this->cezpdf->ezText(utf8_decode_seguro($numero_ref), 8, array("leading" => 0, 'left' => 440));


        $this->cezpdf->ezText('', '', array("leading" => 22));


        /* $this->cezpdf->ezText(utf8_decode_seguro($marca." / "),8, array("leading"=>15,'left'=>380));



          $this->cezpdf->ezText(utf8_decode_seguro($certificado),8, array("leading"=>-13,'left'=>420));-*



          /*$this->cezpdf->ezText(utf8_decode_seguro($registro_mtc),9, array("leading"=>0,'left'=>495)); */

        /* $this->cezpdf->ezText(utf8_decode_seguro($razon_social2),9, array("leading"=>-3,'left'=>-10));

          $this->cezpdf->ezText($dni,9, array("leading"=>0,'left'=>165));

          $this->cezpdf->ezText(utf8_decode_seguro($nombre_conductor),8, array("leading"=>0,'left'=>370)); */


        /*

          $this->cezpdf->ezText(utf8_decode_seguro($punto_partida.($punto_partida2!=''? '-':'')),8, array("leading"=>22,'left'=>55));

          $this->cezpdf->ezText(utf8_decode_seguro($punto_llegada.($punto_llegada2!=''? '-':'')),8, array("leading"=>14,'left'=>55));

         */


        $posx = 0;

        $posy = 0;

        //3 venta sujeto a terceros no esta

        //echo $tipo_movimiento;exit;

        switch ($tipo_movimiento) {

            case 1:
                $posx = 307;

                $posy = 104;

                break;

            case 2:
                $posx = 307;

                $posy = 96;

                break;

            case 3:
                $posx = 307;

                $posy = 89;

                break;


            case 4:
                $posx = 440;

                $posy = 104;

                break;

            case 5:
                $posx = 440;

                $posy = 96;

                break;

            case 6:
                $posx = 440;

                $posy = 89;

                break;


            case 7:
                $posx = 600;

                $posy = 104;

                break;

            case 8:
                $posx = 600;

                $posy = 96;

                break;

            case 9:
                $posx = 600;

                $posy = 89;

                break;


            case 10:
                $posx = 723;

                $posy = 104;

                break;

            /* falta uno que es venta sujeto a terceros */

            case 11:
                $posx = 723;

                $posy = 89;

                break;

            case 12:
                $posx = 723;

                $posy = 80;

                break;


            /* OTROS */

            case 13:
                $posx = 307;

                $posy = 77;

                break;


            case 14:
                $posx = 420;

                $posy = 57;

                break;

            case 15:
                $posx = 420;

                $posy = 48;

                break;

            case 16:
                $posx = 420;

                $posy = 39;

                break;

        }

        $this->cezpdf->addText($posx - 143, $posy + 504, 10, 'x');

        if ($tipo_movimiento == 13)

            $this->cezpdf->addText(35, 420, 7, utf8_decode_seguro(substr($otro_motivo, 0, 19)));


        $this->cezpdf->ezText('', '', array("leading" => 22));


        /* Detalle */

        $db_data = array();

        if (count($datos_detalle_guiarem) > 0) {

            foreach ($datos_detalle_guiarem as $indice => $valor) {

                $producto = $valor->PRODCTOP_Codigo;

                $unidad = $valor->UNDMED_Codigo;

                $costo = $valor->GUIAREMDETC_Costo;

                $venta = $valor->GUIAREMDETC_Venta;

                $peso = $valor->GUIAREMDETC_Peso;

                $descri = $valor->GUIAREMDETC_Descripcion;

                $descri = str_replace('\\', '', $descri);

                $datos_producto = $this->producto_model->obtener_producto($producto);

                $datos_unidad = $this->unidadmedida_model->obtener($unidad);

                $prod_nombre = $datos_producto[0]->PROD_Nombre;

                $prod_codigo = $datos_producto[0]->PROD_CodigoInterno;

                $prod_unidad = $datos_unidad[0]->UNDMED_Simbolo;

                $prod_cantidad = $valor->GUIAREMDETC_Cantidad;

                $db_data[] = array(

                    'col0' => $prod_cantidad,

                    'col2' => utf8_decode_seguro(substr($descri, 0, 45)),

                    'col3' => ''

                );

            }

        }

        $this->cezpdf->ezTable($db_data, '', '', array(

            'width' => 555,

            'showLines' => 0,

            'shaded' => 0,

            'showHeadings' => 0,

            'xPos' => 'center',

            'fontSize' => 9,

            'cols' => array(

                'col0' => array('width' => 50, 'justification' => 'center'),

                'col2' => array('width' => 390, 'justification' => 'left'),

                'col3' => array('width' => 130, 'justification' => 'center')

            )

        ));


        $cabecera = array('Content-Type' => 'application/pdf', 'Content-Disposition' => 'nama_file.pdf', 'Expires' => '0', 'Pragma' => 'cache', 'Cache-Control' => 'private');

        $this->cezpdf->ezStream($cabecera);

    }


    public function guiarem_ver_pdf_formato8_1($codigo, $tipo_oper)
    {

        //$this->load->library('cezpdf');

        //$this->load->helper('pdf_helper');

        $datos_guiarem = $this->guiarem_model->obtener($codigo);

        $datos_detalle_guiarem = $this->guiaremdetalle_model->obtener2($codigo);

        $tipo_movimiento = $datos_guiarem[0]->TIPOMOVP_Codigo;

        $referencia = $datos_guiarem[0]->DOCUP_Codigo;

        $cliente = $datos_guiarem[0]->CLIP_Codigo;

        $numero_ref = $datos_guiarem[0]->GUIAREMC_NumeroRef;

        $serie = $datos_guiarem[0]->GUIAREMC_Serie;

        $numero = $datos_guiarem[0]->GUIAREMC_Numero;

        $fecha_traslado = mysql_to_human($datos_guiarem[0]->GUIAREMC_FechaTraslado);

        $observacion = $datos_guiarem[0]->GUIAREMC_Observacion;

        $marca = $datos_guiarem[0]->GUIAREMC_Marca;

        $placa = $datos_guiarem[0]->GUIAREMC_Placa;

        $registro_mtc = $datos_guiarem[0]->GUIAREMC_RegistroMTC;

        $certificado = $datos_guiarem[0]->GUIAREMC_Certificado;

        $licencia = $datos_guiarem[0]->GUIAREMC_Licencia;

        $nombre_conductor = $datos_guiarem[0]->GUIAREMC_NombreConductor;

        $punto_partida = $datos_guiarem[0]->GUIAREMC_PuntoPartida;

        $punto_llegada = $datos_guiarem[0]->GUIAREMC_PuntoLlegada;

        $empresa_transporte = $datos_guiarem[0]->EMPRP_Codigo;

        $fecha = mysql_to_human($datos_guiarem[0]->GUIAREMC_Fecha);

        $otro_motivo = $datos_guiarem[0]->GUIAREMC_OtroMotivo;


        $nombre_emprtrans = "";

        $ruc_emprtrans = "";

        if ($empresa_transporte != '') {

            $datos_emprtrans = $this->empresa_model->obtener_datosEmpresa($empresa_transporte);

            if (count($datos_emprtrans) > 0) {

                $ruc_emprtrans = $datos_emprtrans[0]->EMPRC_Ruc;

                $nombre_emprtrans = $datos_emprtrans[0]->EMPRC_RazonSocial;

            }

        }


        $datos_doc = $this->documento_model->obtener($referencia);

        $nombre_tipodoc = $datos_doc[0]->DOCUC_Descripcion;


        /* Datos del cliente */

        $datos_cliente = $this->cliente_model->obtener($cliente);

        $razon_social = utf8_decode($datos_cliente->nombre);

        $tipo_doc = ($datos_cliente->tipo == '0' ? 'D.N.1' : 'R.U.C.');

        $ruc = $datos_cliente->ruc;

        $dni = $datos_cliente->dni;

        $distrito_cliente = $datos_cliente->distrito;

        $provincia_cliente = $datos_cliente->provincia;

        $departamento_cliente = $datos_cliente->departamento;

        $direccion = $datos_cliente->direccion;

        $punto_partida2 = '';

        if (strlen($punto_partida) > 50) {

            $punto_partida2 = substr($punto_partida, 50);

            $punto_partida = substr($punto_partida, 0, 50);

        }

        $punto_llegada2 = '';

        if (strlen($punto_llegada) > 48) {

            $punto_llegada2 = substr($punto_llegada, 48);

            $punto_llegada = substr($punto_llegada, 0, 48);

        }

        $razon_social2 = '';

        if (strlen($razon_social) > 52) {

            // $razon_social2=substr($razon_social,52);

            $razon_social = substr($razon_social, 0, 52);

        }


        $direccion2 = '';

        if (strlen($direccion) > 48) {

            $direccion2 = substr($direccion, 48);

            $direccion = substr($direccion, 0, 48);

        }

        //

        $data_confi = $this->compania_model->obtener_compania($this->somevar['compania']);

        $empresa_local = $this->empresa_model->obtener_datosEmpresa($data_confi[0]->EMPRP_Codigo);


        /* Cabecera */

        //prep_pdf();

// images/img_db/guiauno.jpg

        $this->cezpdf = new backgroundPDF('a4', 'portrait', 'image', array('img' => ''));

        $this->cezpdf->ezText('', '', array("leading" => 90));

        $this->cezpdf->ezText($serie, 18, array("leading" => -10, 'left' => 400)); //22 - 345

        $this->cezpdf->ezText($numero, 18, array("leading" => 0, 'left' => 450)); //0 -440

        $this->cezpdf->ezText(utf8_decode_seguro($empresa_local[0]->EMPRC_RazonSocial . ($empresa_local[0]->EMPRC_RazonSocial != '' ? '-' : '')), 8, array("leading" => 39, 'left' => 25));

        $this->cezpdf->ezText(utf8_decode_seguro($razon_social . ($razon_social != '' ? '-' : '')), 8, array("leading" => -1, 'left' => 300));

        $this->cezpdf->ezText(utf8_decode_seguro($punto_partida . ($punto_partida2 != '' ? '-' : '')), 8, array("leading" => 15, 'left' => 25));

        $this->cezpdf->ezText(utf8_decode_seguro($punto_llegada . ($punto_llegada2 != '' ? '-' : '')), 8, array("leading" => 0, 'left' => 290));

        // $this->cezpdf->ezText(utf8_decode_seguro($direccion),8, array("leading"=>15,'left'=>25));

        // $this->cezpdf->ezText(utf8_decode_seguro($direccion),8, array("leading"=>0,'left'=>300));

        $this->cezpdf->ezText(utf8_decode_seguro($empresa_local[0]->EMPRC_Ruc), 8, array("leading" => 16, 'left' => 25));

        $this->cezpdf->ezText(utf8_decode_seguro($ruc), 8, array("leading" => 0, 'left' => 300));

        $this->cezpdf->ezText(substr($fecha, 0, 2) . "/", 8, array("leading" => 10, 'left' => 60));

        $this->cezpdf->ezText(substr($fecha, 3, 2) . "/", 8, array("leading" => 0, 'left' => 80));

        $this->cezpdf->ezText(substr($fecha, 6, 4), 8, array("leading" => 0, 'left' => 100));

        // $this->cezpdf->ezText(utf8_decode_seguro($direccion),8, array("leading"=>15,'left'=>25));

        // $this->cezpdf->ezText(utf8_decode_seguro($direccion2),8, array("leading"=>0,'left'=>400));

        $fecha_normal = explode('/', $fecha_traslado);

        $this->cezpdf->ezText($fecha_normal[2], 8, array("leading" => 0, 'left' => 345));

        $this->cezpdf->ezText($fecha_normal[1] . '/', 8, array("leading" => 0, 'left' => 320));

        $this->cezpdf->ezText($fecha_normal[0] . '/', 8, array("leading" => 0, 'left' => 300));

        /* $this->cezpdf->ezText(substr($fecha,0,2)."/",10, array("leading"=>16,'left'=>45));

          $this->cezpdf->ezText(substr($fecha,3,2)."/",10, array("leading"=>0,'left'=>60));

          $this->cezpdf->ezText(substr($fecha,8,2),10, array("leading"=>0,'left'=>75)); */

        //FECHA DE TRASLADO

        /* $this->cezpdf->ezText(substr($fecha_traslado,0,2)."/",10, array("leading"=>0,'left'=>200));

          $this->cezpdf->ezText(substr($fecha_traslado,3,2)."/",10, array("leading"=>0,'left'=>215));

          $this->cezpdf->ezText(substr($fecha_traslado,8,2),10, array("leading"=>0,'left'=>230)); */

        //$this->cezpdf->ezText(utf8_decode_seguro($direccion2),8, array("leading"=>13,'left'=>25));

        /* $this->cezpdf->ezText(utf8_decode_seguro($marca." / "),8, array("leading"=>15,'left'=>380));

          $this->cezpdf->ezText(utf8_decode_seguro($certificado),8, array("leading"=>-13,'left'=>420));-*

          /*$this->cezpdf->ezText(utf8_decode_seguro($registro_mtc),9, array("leading"=>0,'left'=>495)); */

        /* $this->cezpdf->ezText(utf8_decode_seguro($razon_social2),9, array("leading"=>-3,'left'=>-10));

          $this->cezpdf->ezText($dni,9, array("leading"=>0,'left'=>165));

          $this->cezpdf->ezText(utf8_decode_seguro($nombre_conductor),8, array("leading"=>0,'left'=>370)); */

        /*

          $this->cezpdf->ezText(utf8_decode_seguro($punto_partida.($punto_partida2!=''? '-':'')),8, array("leading"=>22,'left'=>55));

          $this->cezpdf->ezText(utf8_decode_seguro($punto_llegada.($punto_llegada2!=''? '-':'')),8, array("leading"=>14,'left'=>55));

         */

        $this->cezpdf->ezText('', '', array("leading" => 28));

        $db_data = array();

        if (count($datos_detalle_guiarem) > 0) {

            foreach ($datos_detalle_guiarem as $indice => $valor) {

                $producto = $valor->PRODCTOP_Codigo;

                $unidad = $valor->UNDMED_Codigo;

                $costo = $valor->GUIAREMDETC_Costo;

                $venta = $valor->GUIAREMDETC_Venta;

                $peso = $valor->GUIAREMDETC_Peso;

                $descri = $valor->GUIAREMDETC_Descripcion;

                $descri = str_replace('\\', '', $descri);

                $datos_producto = $this->producto_model->obtener_producto($producto);

                $datos_unidad = $this->unidadmedida_model->obtener($unidad);

                $prod_nombre = $datos_producto[0]->PROD_Nombre;

                $prod_codigo = $datos_producto[0]->PROD_CodigoInterno;

                $prod_unidad = $datos_unidad[0]->UNDMED_Simbolo;

                $prod_cantidad = $valor->GUIAREMDETC_Cantidad;

                $db_data[] = array(

                    'col00' => '',

                    'col0' => $prod_cantidad,

                    'col2' => utf8_decode_seguro(substr($descri, 0, 45)),

                    'col4' => '12kg'

                );

            }

        }

        $this->cezpdf->ezTable($db_data, '', '', array(

            'width' => 700,

            'showLines' => 0,

            'shaded' => 0,

            'showHeadings' => 0,

            'xPos' => 'center',

            'fontSize' => 9,

            'cols' => array(

                'col00' => array('width' => 70, 'justification' => 'center'),

                'col0' => array('width' => 50, 'justification' => 'center'),

                'col2' => array('width' => 400, 'justification' => 'left'),

                'col4' => array('width' => 80, 'justification' => 'right')

            )

        ));

        //3 venta sujeto a terceros no esta

        //echo $tipo_movimiento;exit;

        $posx = 0;

        $posy = 0;


        switch ($tipo_movimiento) {

            case 1:
                $posx = 790;

                $posy = 358;

                break;

            case 2:
                $posx = 790;

                $posy = 358;

                break;

            case 3:
                $posx = 790;

                $posy = 358;

                break;


            case 4:
                $posx = 790;

                $posy = 358;

                break;

            case 5:
                $posx = 790;

                $posy = 358;

                break;

            case 6:
                $posx = 790;

                $posy = 358;

                break;


            case 7:
                $posx = 790;

                $posy = 358;

                break;

            case 8:
                $posx = 790;

                $posy = 358;

                break;

            case 9:
                $posx = 790;

                $posy = 358;

                break;


            case 10:
                $posx = 723;

                $posy = 104;

                break;

            /* falta uno que es venta sujeto a terceros */

            case 11:
                $posx = 723;

                $posy = 89;

                break;

            case 12:
                $posx = 723;

                $posy = 80;

                break;


            /* OTROS */

            case 13:
                $posx = 307;

                $posy = 77;

                break;


            case 14:
                $posx = 420;

                $posy = 57;

                break;

            case 15:
                $posx = 420;

                $posy = 48;

                break;

            case 16:
                $posx = 420;

                $posy = 39;

                break;

        }

        $this->cezpdf->addText($posx - 220, $posy + 335, 10, $tipo_movimiento);

        // $this->cezpdf->addText(500,700,10,'180kg');

        $this->cezpdf->ezText("120kg", 10, array("leading" => 499, 'left' => 508));

        if ($tipo_movimiento == 13)

            $this->cezpdf->addText(35, 420, 7, utf8_decode_seguro(substr($otro_motivo, 0, 19)));


        $this->cezpdf->ezText('', '', array("leading" => 22));


        /* Detalle */


        $cabecera = array('Content-Type' => 'application/pdf', 'Content-Disposition' => 'nama_file.pdf', 'Expires' => '0', 'Pragma' => 'cache', 'Cache-Control' => 'private');

        $this->cezpdf->ezStream($cabecera);

    }


    public function guiarem_ver_pdf_conmenbrete_formato8_1($codigo, $tipo_oper)
    {

        //$this->load->library('cezpdf');

        //$this->load->helper('pdf_helper');

        $datos_guiarem = $this->guiarem_model->obtener($codigo);

        $datos_detalle_guiarem = $this->guiaremdetalle_model->obtener2($codigo);

        $tipo_movimiento = $datos_guiarem[0]->TIPOMOVP_Codigo;

        $referencia = $datos_guiarem[0]->DOCUP_Codigo;

        $cliente = $datos_guiarem[0]->CLIP_Codigo;

        $numero_ref = $datos_guiarem[0]->GUIAREMC_NumeroRef;

        $serie = $datos_guiarem[0]->GUIAREMC_Serie;

        $numero = $datos_guiarem[0]->GUIAREMC_Numero;

        $fecha_traslado = mysql_to_human($datos_guiarem[0]->GUIAREMC_FechaTraslado);

        $observacion = $datos_guiarem[0]->GUIAREMC_Observacion;

        $marca = $datos_guiarem[0]->GUIAREMC_Marca;

        $placa = $datos_guiarem[0]->GUIAREMC_Placa;

        $registro_mtc = $datos_guiarem[0]->GUIAREMC_RegistroMTC;

        $certificado = $datos_guiarem[0]->GUIAREMC_Certificado;

        $licencia = $datos_guiarem[0]->GUIAREMC_Licencia;

        $nombre_conductor = $datos_guiarem[0]->GUIAREMC_NombreConductor;

        $punto_partida = $datos_guiarem[0]->GUIAREMC_PuntoPartida;

        $punto_llegada = $datos_guiarem[0]->GUIAREMC_PuntoLlegada;

        $empresa_transporte = $datos_guiarem[0]->EMPRP_Codigo;

        $fecha = mysql_to_human($datos_guiarem[0]->GUIAREMC_Fecha);

        $otro_motivo = $datos_guiarem[0]->GUIAREMC_OtroMotivo;


        $nombre_emprtrans = "";

        $ruc_emprtrans = "";

        if ($empresa_transporte != '') {

            $datos_emprtrans = $this->empresa_model->obtener_datosEmpresa($empresa_transporte);

            if (count($datos_emprtrans) > 0) {

                $ruc_emprtrans = $datos_emprtrans[0]->EMPRC_Ruc;

                $nombre_emprtrans = $datos_emprtrans[0]->EMPRC_RazonSocial;

            }

        }


        $datos_doc = $this->documento_model->obtener($referencia);

        $nombre_tipodoc = $datos_doc[0]->DOCUC_Descripcion;


        /* Datos del cliente */

        $datos_cliente = $this->cliente_model->obtener($cliente);

        $razon_social = utf8_decode($datos_cliente->nombre);

        $tipo_doc = ($datos_cliente->tipo == '0' ? 'D.N.1' : 'R.U.C.');

        $ruc = $datos_cliente->ruc;

        $dni = $datos_cliente->dni;

        $distrito_cliente = $datos_cliente->distrito;

        $provincia_cliente = $datos_cliente->provincia;

        $departamento_cliente = $datos_cliente->departamento;

        $direccion = $datos_cliente->direccion;

        $punto_partida2 = '';

        if (strlen($punto_partida) > 50) {

            $punto_partida2 = substr($punto_partida, 50);

            $punto_partida = substr($punto_partida, 0, 50);

        }

        $punto_llegada2 = '';

        if (strlen($punto_llegada) > 48) {

            $punto_llegada2 = substr($punto_llegada, 48);

            $punto_llegada = substr($punto_llegada, 0, 48);

        }

        $razon_social2 = '';

        if (strlen($razon_social) > 52) {

            // $razon_social2=substr($razon_social,52);

            $razon_social = substr($razon_social, 0, 52);

        }


        $direccion2 = '';

        if (strlen($direccion) > 48) {

            $direccion2 = substr($direccion, 48);

            $direccion = substr($direccion, 0, 48);

        }

        //

        $data_confi = $this->compania_model->obtener_compania($this->somevar['compania']);

        $empresa_local = $this->empresa_model->obtener_datosEmpresa($data_confi[0]->EMPRP_Codigo);


        /* Cabecera */

        //prep_pdf();

// images/img_db/guiaremision.jpg

        $this->cezpdf = new backgroundPDF('a4', 'portrait', 'image', array('img' => 'images/img_db/guiauno.jpg'));

        $this->cezpdf->ezText('', '', array("leading" => 90));

        $this->cezpdf->ezText($serie, 18, array("leading" => -10, 'left' => 400)); //22 - 345

        $this->cezpdf->ezText($numero, 18, array("leading" => 0, 'left' => 450)); //0 -440


        $this->cezpdf->ezText(utf8_decode_seguro($empresa_local[0]->EMPRC_RazonSocial . ($empresa_local[0]->EMPRC_RazonSocial != '' ? '-' : '')), 8, array("leading" => 39, 'left' => 25));

        $this->cezpdf->ezText(utf8_decode_seguro($razon_social . ($razon_social != '' ? '-' : '')), 8, array("leading" => -1, 'left' => 300));

        $this->cezpdf->ezText(utf8_decode_seguro($punto_partida . ($punto_partida2 != '' ? '-' : '')), 8, array("leading" => 15, 'left' => 25));

        $this->cezpdf->ezText(utf8_decode_seguro($punto_llegada . ($punto_llegada2 != '' ? '-' : '')), 8, array("leading" => 0, 'left' => 290));

        // $this->cezpdf->ezText(utf8_decode_seguro($direccion),8, array("leading"=>15,'left'=>25));

        // $this->cezpdf->ezText(utf8_decode_seguro($direccion),8, array("leading"=>0,'left'=>300));

        $this->cezpdf->ezText(utf8_decode_seguro($empresa_local[0]->EMPRC_Ruc), 8, array("leading" => 16, 'left' => 25));

        $this->cezpdf->ezText(utf8_decode_seguro($ruc), 8, array("leading" => 0, 'left' => 300));

        $this->cezpdf->ezText(substr($fecha, 0, 2) . "/", 8, array("leading" => 10, 'left' => 60));

        $this->cezpdf->ezText(substr($fecha, 3, 2) . "/", 8, array("leading" => 0, 'left' => 80));

        $this->cezpdf->ezText(substr($fecha, 8, 2), 8, array("leading" => 0, 'left' => 100));

        // $this->cezpdf->ezText(utf8_decode_seguro($direccion),8, array("leading"=>15,'left'=>25));

        // $this->cezpdf->ezText(utf8_decode_seguro($direccion2),8, array("leading"=>0,'left'=>400));

        $fecha_normal = explode('/', $fecha_traslado);

        $this->cezpdf->ezText($fecha_normal[2], 8, array("leading" => 0, 'left' => 345));

        $this->cezpdf->ezText($fecha_normal[1] . '/', 8, array("leading" => 0, 'left' => 320));

        $this->cezpdf->ezText($fecha_normal[0] . '/', 8, array("leading" => 0, 'left' => 300));

        /* $this->cezpdf->ezText(substr($fecha,0,2)."/",10, array("leading"=>16,'left'=>45));

          $this->cezpdf->ezText(substr($fecha,3,2)."/",10, array("leading"=>0,'left'=>60));

          $this->cezpdf->ezText(substr($fecha,8,2),10, array("leading"=>0,'left'=>75)); */

        //FECHA DE TRASLADO

        /* $this->cezpdf->ezText(substr($fecha_traslado,0,2)."/",10, array("leading"=>0,'left'=>200));

          $this->cezpdf->ezText(substr($fecha_traslado,3,2)."/",10, array("leading"=>0,'left'=>215));

          $this->cezpdf->ezText(substr($fecha_traslado,8,2),10, array("leading"=>0,'left'=>230)); */

        //$this->cezpdf->ezText(utf8_decode_seguro($direccion2),8, array("leading"=>13,'left'=>25));

        /* $this->cezpdf->ezText(utf8_decode_seguro($marca." / "),8, array("leading"=>15,'left'=>380));

          $this->cezpdf->ezText(utf8_decode_seguro($certificado),8, array("leading"=>-13,'left'=>420));-*

          /*$this->cezpdf->ezText(utf8_decode_seguro($registro_mtc),9, array("leading"=>0,'left'=>495)); */

        /* $this->cezpdf->ezText(utf8_decode_seguro($razon_social2),9, array("leading"=>-3,'left'=>-10));

          $this->cezpdf->ezText($dni,9, array("leading"=>0,'left'=>165));

          $this->cezpdf->ezText(utf8_decode_seguro($nombre_conductor),8, array("leading"=>0,'left'=>370)); */

        $this->cezpdf->ezText('', '', array("leading" => 28));

        $db_data = array();

        if (count($datos_detalle_guiarem) > 0) {

            foreach ($datos_detalle_guiarem as $indice => $valor) {

                $producto = $valor->PRODCTOP_Codigo;

                $unidad = $valor->UNDMED_Codigo;

                $costo = $valor->GUIAREMDETC_Costo;

                $venta = $valor->GUIAREMDETC_Venta;

                $peso = $valor->GUIAREMDETC_Peso;

                $descri = $valor->GUIAREMDETC_Descripcion;

                $descri = str_replace('\\', '', $descri);

                $datos_producto = $this->producto_model->obtener_producto($producto);

                $datos_unidad = $this->unidadmedida_model->obtener($unidad);

                $prod_nombre = $datos_producto[0]->PROD_Nombre;

                $prod_codigo = $datos_producto[0]->PROD_CodigoInterno;

                $prod_unidad = $datos_unidad[0]->UNDMED_Simbolo;

                $prod_cantidad = $valor->GUIAREMDETC_Cantidad;

                $db_data[] = array(

                    'col00' => '',

                    'col0' => $prod_cantidad,

                    'col2' => utf8_decode_seguro(substr($descri, 0, 45)),

                    'col4' => '12kg'

                );

            }

        }

        $this->cezpdf->ezTable($db_data, '', '', array(

            'width' => 700,

            'showLines' => 0,

            'shaded' => 0,

            'showHeadings' => 0,

            'xPos' => 'center',

            'fontSize' => 9,

            'cols' => array(

                'col00' => array('width' => 70, 'justification' => 'center'),

                'col0' => array('width' => 50, 'justification' => 'center'),

                'col2' => array('width' => 400, 'justification' => 'left'),

                'col4' => array('width' => 80, 'justification' => 'right')

            )

        ));

        //3 venta sujeto a terceros no esta

        //echo $tipo_movimiento;exit;

        $posx = 0;

        $posy = 0;


        switch ($tipo_movimiento) {

            case 1:
                $posx = 790;

                $posy = 358;

                break;

            case 2:
                $posx = 790;

                $posy = 358;

                break;

            case 3:
                $posx = 790;

                $posy = 358;

                break;


            case 4:
                $posx = 790;

                $posy = 358;

                break;

            case 5:
                $posx = 790;

                $posy = 358;

                break;

            case 6:
                $posx = 790;

                $posy = 358;

                break;


            case 7:
                $posx = 790;

                $posy = 358;

                break;

            case 8:
                $posx = 790;

                $posy = 358;

                break;

            case 9:
                $posx = 790;

                $posy = 358;

                break;


            case 10:
                $posx = 723;

                $posy = 104;

                break;

            /* falta uno que es venta sujeto a terceros */

            case 11:
                $posx = 723;

                $posy = 89;

                break;

            case 12:
                $posx = 723;

                $posy = 80;

                break;


            /* OTROS */

            case 13:
                $posx = 307;

                $posy = 77;

                break;


            case 14:
                $posx = 420;

                $posy = 57;

                break;

            case 15:
                $posx = 420;

                $posy = 48;

                break;

            case 16:
                $posx = 420;

                $posy = 39;

                break;

        }

        $this->cezpdf->addText($posx - 220, $posy + 335, 10, $tipo_movimiento);

        // $this->cezpdf->addText(500,700,10,'180kg');

        $this->cezpdf->ezText("120kg", 10, array("leading" => 499, 'left' => 508));

        if ($tipo_movimiento == 13)

            $this->cezpdf->addText(35, 420, 7, utf8_decode_seguro(substr($otro_motivo, 0, 19)));


        $this->cezpdf->ezText('', '', array("leading" => 22));


        /* Detalle */


        $cabecera = array('Content-Type' => 'application/pdf', 'Content-Disposition' => 'nama_file.pdf', 'Expires' => '0', 'Pragma' => 'cache', 'Cache-Control' => 'private');

        $this->cezpdf->ezStream($cabecera);

    }


	/**obtenemos la lista de guiaremision creadas por cliente o proveedor pero no ewstan asociadas a un comprobante **/
    public function ventana_muestra_guiarem($tipo_oper, $codigo = '', $select = '', $tipo_doc = '', $almacen = '', $comprobante = '',$tipoMoneda='')
    {
        //$this->output->enable_profiler(TRUE);
        $cliente = '';
        $nombre_cliente = '';
        $ruc_cliente = '';
        $proveedor = '';
        $nombre_proveedor = '';
        $ruc_proveedor = '';
        $almacen_id = $almacen;
        if ($tipo_oper == 'V') {
            $cliente = $codigo;
            $datos_cliente = $this->cliente_model->obtener($cliente);
            if ($datos_cliente) {
                $nombre_cliente = $datos_cliente->nombre;
                $ruc_cliente = $datos_cliente->ruc;
            }
        } else {
            $proveedor = $codigo;
            $datos_proveedor = $this->proveedor_model->obtener($proveedor);
            if ($datos_proveedor) {
                $nombre_proveedor = $datos_proveedor->nombre;
                $ruc_proveedor = $datos_proveedor->ruc;
            }
        }
        $filter = new stdClass();
        $filter->cliente = $cliente;
        $filter->proveedor = $proveedor;
        $filter->tipoMoneda=$tipoMoneda;
        $filter->codigoAlmacen=$almacen_id;
        $lista_guiarem = $this->guiarem_model->buscar_no_asociados($tipo_oper, $filter);
        $lista = array();
        foreach ($lista_guiarem as $indice => $value) {
            $ver = "<a href='javascript:;' onclick='ver_detalle_documento(" . $value->GUIAREMP_Codigo . ")'><img src='" . base_url() . "images/ver.png' width='16' height='16' border='0' title='Ver Detalles'></a>";
			$ir = "<a href='javascript:;' onclick='seleccionar_guiarem(" . $value->GUIAREMP_Codigo . "," . $value->GUIAREMC_Serie . "," . $value->GUIAREMC_Numero . ")' ><img src='" . base_url() . "images/ir.png' width='16' height='16' border='0' title='Guia de remision " . $value->GUIAREMC_Serie . " - " . $value->GUIAREMC_Numero . "' /></a>";
			$lista[] = array(mysql_to_human($value->GUIAREMC_Fecha), $value->GUIAREMC_Serie, $value->GUIAREMC_Numero, $value->numdoc, $value->nombre, $value->MONED_Simbolo . ' ' . number_format($value->GUIAREMC_total), $ver, $ir);
        }
        $data['lista'] = $lista;
        $data['cliente'] = $cliente;
        $data['nombre_cliente'] = $nombre_cliente;
        $data['ruc_cliente'] = $ruc_cliente;
        $data['proveedor'] = $proveedor;
        $data['nombre_proveedor'] = $nombre_proveedor;
        $data['ruc_proveedor'] = $ruc_proveedor;
        $data['almacen'] = $almacen_id;
        $data['comprobante'] = $comprobante;
        $data['tipo_oper'] = $tipo_oper;
        $data['tipo_doc'] = $tipo_doc;
        $data['form_open'] = form_open(base_url() . "index.php/almacen/producto/ventana_muestra_guiarem", array("name" => "frmGuiarem", "id" => "frmGuiarem"));
		$data['form_close'] = form_close();
        $data['form_hidden'] = form_hidden(array("base_url" => base_url()));
        $this->load->view('almacen/ventana_muestra_guiarem', $data);
    }

///
//gcbq
    public function ventana_muestra_recurrentes($tipo_oper, $codigo = '', $formato = 'SELECT_ITEM', $docu_orig = '', $almacen = "", $comprobante = '')
    {
        $cliente = '';
        $nombre_cliente = '';
        $ruc_cliente = '';
        $proveedor = '';
        $nombre_proveedor = '';
        $ruc_proveedor = '';
        $almacen_id = $almacen;
        if ($tipo_oper == 'V') {
            $cliente = $codigo;
            $datos_cliente = $this->cliente_model->obtener($cliente);
            if ($datos_cliente) {
                $nombre_cliente = $datos_cliente->nombre;
                $ruc_cliente = $datos_cliente->ruc;
            }
            $filter = new stdClass();
            $filter->cliente = $cliente;
        } else {
            $proveedor = $codigo;
            $datos_proveedor = $this->proveedor_model->obtener($proveedor);
            if ($datos_proveedor) {
                $nombre_proveedor = $datos_proveedor->nombre;
                $ruc_proveedor = $datos_proveedor->ruc;
            }
            $filter = new stdClass();
            $filter->proveedor = $proveedor;
        }


        $lista_guiarem = $this->guiarem_model->buscar($tipo_oper, $filter);
        $lista = array();
        foreach ($lista_guiarem as $indice => $value) {
            $ver = "<a href='javascript:;' onclick='ver_detalle_documento_recu(" . $value->GUIAREMP_Codigo . ")'><img src='" . base_url() . "images/ver.png' width='16' height='16' border='0' title='Ver Detalles'></a>";
			$ir = "<a href='javascript:;' onclick='seleccionar_guiarem_recu(" . $value->GUIAREMP_Codigo . "," . $value->GUIAREMC_Serie . "," . $value->GUIAREMC_Numero . ")' ><img src='" . base_url() . "images/ir.png' width='16' height='16' border='0' title='Guia de remision " . $value->GUIAREMC_Serie . " - " . $value->GUIAREMC_Numero . "' /></a>";
			$lista[] = array(mysql_to_human($value->GUIAREMC_Fecha), $value->GUIAREMC_Serie, $value->GUIAREMC_Numero, $value->numdoc, $value->nombre, $value->MONED_Simbolo . ' ' . number_format($value->GUIAREMC_total), $ver, $ir);
		}


        $data['lista'] = $lista;
        $data['cliente'] = $cliente;
        $data['nombre_cliente'] = $nombre_cliente;
        $data['ruc_cliente'] = $ruc_cliente;
        $data['proveedor'] = $proveedor;
        $data['nombre_proveedor'] = $nombre_proveedor;
        $data['ruc_proveedor'] = $ruc_proveedor;
        $data['almacen'] = $almacen_id;
        $data['tipo_oper'] = $tipo_oper;
        $data['comprobante'] = $comprobante;
        $data['form_open'] = form_open(base_url() . "index.php/ventas/comprobante/ventana_muestra_comprobante", array("name" => "frmGuiarem", "id" => "frmGuiarem"));
		$data['form_close'] = form_close();
        $data['form_hidden'] = form_hidden(array("base_url" => base_url()));
        $this->load->view('ventas/ventana_muestra_comprobante', $data);
        // $this->load->view('almacen/ventana_muestra_guiarem', $data);

    }

	public function getOrderNumeroSerie($numero){
 
                $cantidad=strlen($numero);

                if($cantidad==1){
                    $dato ="00000$numero";
                }
                if($cantidad==2){
                     $dato ="0000$numero";
                }
                if($cantidad==3){
                    $dato ="000$numero";
                }
                if($cantidad==4){
                    $dato= "00$numero";
                }
                if($cantidad==5){
                    $dato ="0$numero";
                }
                if($cantidad==6){
                    $dato ="$numero";
                }
                return $dato;
	}


}

?>