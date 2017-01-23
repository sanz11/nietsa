<?php
ini_set('error_reporting', 1);  //bloq stv  pa q al inicio no cargue con error el pdf en firefox

include("system/application/libraries/pchart/pData.php");
include("system/application/libraries/pchart/pChart.php");
include("system/application/libraries/cezpdf.php");
include("system/application/libraries/class.backgroundpdf.php");

class Notacredito extends Controller
{

    public function __construct()
    {
        parent::Controller();
        $this->load->helper('form');
        $this->load->helper('date');
        $this->load->helper('util');
        $this->load->helper('utf_helper');
        $this->load->helper('my_permiso');
        $this->load->helper('my_almacen');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('html');
        $this->load->model('compras/cotizacion_model');
        $this->load->model('compras/pedido_model');
        $this->load->model('compras/proveedor_model');
        $this->load->model('compras/ocompra_model');
        $this->load->model('maestros/documento_model');
        $this->load->model('ventas/notacredito_model');
        $this->load->model('ventas/notacreditodetalle_model');
        $this->load->model('ventas/cliente_model');
        $this->load->model('ventas/presupuesto_model');
        $this->load->model('almacen/producto_model');
        $this->load->model('almacen/almacen_model');
        $this->load->model('almacen/unidadmedida_model');
        $this->load->model('almacen/guiarem_model');
        $this->load->model('almacen/guiasa_model');
        $this->load->model('almacen/guiasadetalle_model');
        $this->load->model('maestros/empresa_model');
        $this->load->model('maestros/tipocambio_model');
        $this->load->model('maestros/persona_model');
        $this->load->model('maestros/moneda_model');
        $this->load->model('maestros/formapago_model');
        $this->load->model('maestros/condicionentrega_model');
        $this->load->model('seguridad/usuario_model');
        $this->load->model('maestros/companiaconfiguracion_model');
        $this->load->model('maestros/directivo_model');
        $this->load->model('maestros/tipocambio_model');
        $this->load->model('configuracion_model');

        $this->somevar['compania'] = $this->session->userdata('compania');
        $this->somevar['user'] = $this->session->userdata('user');
        $this->somevar['rol'] = $this->session->userdata('rol');
        $this->somevar['url'] = $_SERVER['REQUEST_URI'];
        date_default_timezone_set('America/Lima');
    }

    public function index()
    {
        $this->load->view('seguridad/inicio');
        $this->load->library('layout', 'layout');
    }

    public function detalle_comprobante()
    {
        $comprobante = $this->input->post('comprobante');
        $detalleComprobante = $this->notacredito_model->cargarDetalleComprobante($comprobante);
        $data = array();
        if ($detalleComprobante == NULL) {
            $data = NULL;
        } else {
            $data = $detalleComprobante;
        }

        echo json_encode($data);

    }

    public function obtener_detalle_comprobante($comprobante)
    {
        $detalle = $this->notacreditodetalle_model->listar($comprobante);
        $lista_detalles = array();
        $datos_presupuesto = $this->notacredito_model->obtener_comprobante($comprobante);
        $formapago = $datos_presupuesto[0]->FORPAP_Codigo;
        $moneda = $datos_presupuesto[0]->MONED_Codigo;
        $serie = $datos_presupuesto[0]->CRED_Serie;
        $numero = $datos_presupuesto[0]->CRED_Numero;
        $codigo_usuario = $datos_presupuesto[0]->USUA_Codigo;;

        if (isset($datos_presupuesto[0]->CLIP_Codigo)) {
            $cliente = $datos_presupuesto[0]->CLIP_Codigo;
            $temp = $this->obtener_datos_cliente($cliente);
        } else {
            $proveedor = $datos_presupuesto[0]->PROVP_Codigo;
            $temp = $this->obtener_datos_proveedor($proveedor);
        }

        $tipo_doc = $datos_presupuesto[0]->CRED_TipoDocumento;

        $ruc = $temp['numdoc'];
        $razon_social = $temp['nombre'];

        if (count($detalle) > 0) {
            foreach ($detalle as $indice => $valor) {
                $detpresup = $valor->CREDET_Codigo;
                $producto = $valor->PROD_Codigo;
                $unidad_medida = $valor->UNDMED_Codigo;
                $cantidad = $valor->CREDET_Cantidad;
                $igv100 = round($valor->CREDET_Igv100, 2);
                $pu = round((($tipo_doc == 'F') ? $valor->CREDET_Pu : $valor->CREDET_Pu_ConIgv - ($valor->CREDET_Pu_ConIgv * $igv100 / 100)), 2);
                $subtotal = round((($tipo_doc == 'F') ? $valor->CREDET_Subtotal : $pu * $cantidad), 2);
                $igv = round($valor->CREDET_Igv, 2);
                $descuento = round($valor->CREDET_Descuento, 2);
                $total = round((($tipo_doc == 'F') ? $valor->CREDET_Total : $subtotal), 2);
                $pu_conigv = round($valor->CREDET_Pu_ConIgv, 2);
                $subtotal_conigv = round($valor->CREDET_Subtotal_ConIgv, 2);
                $descuento_conigv = round($valor->CREDET_Descuento_ConIgv, 2);
                $observacion = $valor->CREDET_Observacion;

                $datos_producto = $this->producto_model->obtener_producto($producto);
                $codigo_interno = $datos_producto[0]->PROD_CodigoInterno;
                $nombre_producto = ($valor->CREDET_Descripcion != '' ? $valor->CREDET_Descripcion : $datos_producto[0]->PROD_Nombre);
                $nombre_producto = str_replace('"', "''", $nombre_producto);
                $flagGenInd = $datos_producto[0]->PROD_GenericoIndividual;
                $costo = $datos_producto[0]->PROD_CostoPromedio;
                $datos_umedida = $this->unidadmedida_model->obtener($unidad_medida);
                $nombre_unidad = $datos_umedida[0]->UNDMED_Descripcion;


                $objeto = new stdClass();
                $objeto->CREDET_Codigo = $detpresup;
                $objeto->PROD_Codigo = $producto;
                $objeto->PROD_CodigoInterno = $codigo_interno;
                $objeto->UNDMED_Codigo = $unidad_medida;
                $objeto->UNDMED_Descripcion = $nombre_unidad;
                $objeto->PROD_Nombre = $nombre_producto;
                $objeto->PROD_GenericoIndividual = $flagGenInd;
                $objeto->PROD_CostoPromedio = $costo;
                $objeto->CREDET_Cantidad = $cantidad;
                $objeto->CREDET_Pu = $pu;
                $objeto->CREDET_Subtotal = $subtotal;
                $objeto->CREDET_Descuento = $descuento;
                $objeto->CREDET_Igv = $igv;
                $objeto->CREDET_Total = $total;
                $objeto->CREDET_Pu_ConIgv = $pu_conigv;
                $objeto->CREDET_Subtotal_ConIgv = $subtotal_conigv;
                $objeto->CREDET_Descuento_ConIgv = $descuento_conigv;
                $objeto->Ruc = $ruc;
                $objeto->RazonSocial = $razon_social;

                if (isset($datos_presupuesto[0]->CLIP_Codigo))
                    $objeto->CLIP_Codigo = $cliente;
                else
                    $objeto->PROVP_Codigo = $proveedor;

                $objeto->MONED_Codigo = $moneda;
                $objeto->FORPAP_Codigo = $formapago;
                $objeto->PRESUC_Serie = $serie;
                $objeto->PRESUC_Numero = $numero;
                $objeto->PRESUC_CodigoUsuario = $codigo_usuario;

                $lista_detalles[] = $objeto;
            }
        } else {
            $objeto = new stdClass();
            $objeto->CPDEP_Codigo = '';
            $objeto->Ruc = $ruc;
            $objeto->RazonSocial = $razon_social;
            $objeto->CLIP_Codigo = $cliente;
            $objeto->MONED_Codigo = $moneda;
            $objeto->FORPAP_Codigo = $formapago;
            $objeto->PRESUC_Numero = $numero;
            $objeto->PRESUC_CodigoUsuario = '15';
            $lista_detalles[] = $objeto;
        }
        $resultado = json_encode($lista_detalles);

        echo $resultado;
    }

    public function comprobantes($tipo_oper = 'V', $j = '0', $limpia = '')
    {

        $this->load->library('layout', 'layout');
        $data['compania'] = $this->somevar['compania'];
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

        $data['registros'] = count($this->notacredito_model->buscar_comprobantes($tipo_oper, $filter));
        $conf['base_url'] = site_url('ventas/notacredito/comprobantes/' . $tipo_oper);
        $conf['per_page'] = 50;
        $conf['num_links'] = 3;
        $conf['first_link'] = "&lt;&lt;";
        $conf['last_link'] = "&gt;&gt;";
        $conf['total_rows'] = $data['registros'];
        $conf['uri_segment'] = 6;
        $offset = (int)$this->uri->segment(6);
        $listado_comprobantes = $this->notacredito_model->buscar_comprobantes($tipo_oper, $filter, $conf['per_page'], $offset);
        $item = $j + 1;
        $lista = array();
        if (count($listado_comprobantes) > 0) {
            foreach ($listado_comprobantes as $indice => $valor) {
                $codigo = $valor->CRED_Codigo;
                $fecha = mysql_to_human($valor->CRED_Fecha);
                $serie = $valor->CRED_Serie;
                $numero = $valor->CRED_Numero;
                $guiarem_codigo = $valor->CRED_GuiaRemCodigo;
                $docurefe_codigo = $valor->CRED_DocuRefeCodigo;
                $nombre = $valor->nombre;
                $total = $valor->MONED_Simbolo . ' ' . number_format($valor->CRED_total, 2);
                $estado = $valor->CRED_FlagEstado;
                $estado_programacion = $valor->CRED_Flag;
                $docInicio = $valor->CRED_TipoDocumento_inicio;
                $docFin = $valor->CRED_TipoDocumento_fin;
                $compInicio = $valor->CRED_ComproInicio;
                $compFin = $valor->CRED_ComproFin;
                $carga = "";
                if($compFin == NULL || $compFin == "NULL" || $compFin == ""){
                    $carga = "<div style='background-color: #004488; padding: 3px; text-align: center; color: #f1f1f1' >GENERADA</div>";
                }else{
                    $carga = "<div style='background-color: #880000; padding: 3px; text-align: center; color: #f1f1f1' >COBRADA</div>";
                }
                $numero_inicio = $valor->CRED_NumeroInicio;
                $numero_fin = $valor->CRED_NumeroFin;

                if ($estado == '1') {
                    if($estado_programacion == '1') {
                        $img_estado = "<a href='#' ><img src='" . base_url() . "images/active.png'  alt='Activo' title='Activo' /></a>";
                    }else {
                        $img_estado = "<img src='" . base_url() . "images/active.png'  alt='Activo' title='Activo' />";
                    }
                } elseif ($estado == '0') {
                    $img_estado = "<img src='" . base_url() . "images/inactive.png' alt='Anulado' title='Anulado' />";
                } else {
                    $img_estado = "<img src='" . base_url() . "images/complete.png' style='width: 16px' alt='Anulado' title='Canjeado' />";
                }


                if ($this->somevar['rol'] == '4') { // Rol Administrador
                    if($estado_programacion == '1') {
                        $editar = "<a href='javascript:;' onclick='editar_comprobante(" . $codigo . ")' target='_parent'><img src='" . base_url() . "images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
                    }else{
                        $editar = "<img src='".base_url()."images/icono_aprobar.png' alt='GENERADA' />";
                    }
                }
                else {
                    $editar = "";
                }
                // Imprimir
                $ver = "<a href='javascript:;' onclick='comprobante_ver_pdf_conmenbrete(0," . $codigo . ")' target='_parent'><img src='" . base_url() . "images/icono_imprimir.png' width='16' height='16' border='0' title='Imprimir'></a>";
                // PDF
                $ver2 = "<a href='javascript:;' onclick='comprobante_ver_pdf_conmenbrete(1," . $codigo . ")' target='_parent'><img src='" . base_url() . "images/pdf.png' width='16' height='16' border='0' title='Ver PDF'></a>";
                
                // Eliminar
                $eliminar = "<a href='javascript:;' onclick='eliminar_comprobante(" . $codigo . ")' target='_parent'><img src='" . base_url() . "images/eliminar.png' width='16' height='16' border='0' title='Eliminar'></a>";

                if ($tipo_oper == 'V') {
                    $lista[] = array($item++, $fecha, $serie, $numero, $guiarem_codigo, $docurefe_codigo, $nombre, $total, $img_estado, $editar, $ver, $ver2, $carga, $docInicio, $compInicio, $docFin, $compFin, $numero_inicio, $numero_fin, $codigo);
                }
                else {
                    $lista[] = array($item++, $fecha, $serie, $numero, $guiarem_codigo, $docurefe_codigo, $nombre, $total, $img_estado, $editar, $ver, $ver2, $carga, $docInicio, $compInicio, $docFin, $compFin, $numero_inicio, $numero_fin, $codigo);
                }
            }
        }
        $data['titulo_tabla'] = "RELACIÃ“N DE " . strtoupper($this->obtener_tipo_documento("F")) . "S";
        $data['titulo_busqueda'] = "BUSCAR " . strtoupper($this->obtener_tipo_documento("F"));
        $data['tipo_oper'] = $tipo_oper;
        $data['tipo_docu'] = "F";
        $data['lista'] = $lista;
        $data['oculto'] = form_hidden(array('base_url' => base_url(), 'tipo_oper' => $tipo_oper, "tipo_docu" => "F"));
        $this->pagination->initialize($conf);
        $data['paginacion'] = $this->pagination->create_links();
        $this->layout->view('ventas/notacredito_index', $data);
    }

    /**
     * Aqui se crear una nota de credito ya sea para V(clientes) o C(proveedores)
     * Las notas tiene un origen y fin
     * Una nota de credito es un credito que esta vinculado a una factura, boleta o comprobante aunque no es necesario(independiente)
     * Las nota reemplaza el dinero real por un dinero que solo se podra gastar en productos que se venden
     * Las notas obligatoriamente al final de su estado deven ser vinculadas a una Factura, Boleta o Comprobante
     * @param string $tipo_oper
     * @param string $tipo_docu
     * @see comprobante($tipo_oper, $tipo_docu, $j, $limpia)
     */
    public function comprobante_nueva($tipo_oper = 'V', $tipo_docu = 'F')
    {

        $this->load->library('layout', 'layout');
        unset($_SESSION['serie']);
        $comp_confi = $this->companiaconfiguracion_model->obtener($this->somevar['compania']);
        $data['compania'] = $this->somevar['compania'];
        $compania = $data['compania'];
        $codigo = "";
        $data['codigo'] = $codigo;
        $data['contiene_igv'] = (($comp_confi[0]->COMPCONFIC_PrecioContieneIgv == '1') ? true : false);
        $oculto = form_hidden(array('codigo' => $codigo, 'base_url' => base_url(), 'tipo_oper' => $tipo_oper, 'tipo_docu' => $tipo_docu, 'contiene_igv' => ($data['contiene_igv'] == true ? '1' : '0')));
        $data['url_action'] = base_url() . "index.php/ventas/notacredito/comprobante_insertar";
        $data['titulo'] = "REGISTRAR " . strtoupper($this->obtener_tipo_documento($tipo_docu));
        $data['tipo_docu'] = $tipo_docu;
        $data['tipo_oper'] = $tipo_oper;
        $data['formulario'] = "frmComprobante";
        $data['oculto'] = $oculto;
        $lista_almacen = $this->almacen_model->seleccionar();
        $data['cboAlmacen'] = form_dropdown("almacen", $lista_almacen, obtener_val_x_defecto($lista_almacen), " class='comboMedio' style='width:200px;' id='almacen'");


        $data['cboMoneda'] = $this->OPTION_generador($this->moneda_model->listar(), 'MONED_Codigo', 'MONED_Descripcion', '1');
        //$data['cboFormaPago'] = $this->OPTION_generador($this->formapago_model->listar(), 'FORPAP_Codigo', 'FORPAC_Descripcion', '2');
        //$data['cboPresupuesto'] = $this->OPTION_generador($this->presupuesto_model->listar_presupuestos_nocomprobante_cualquiera($tipo_oper, $tipo_docu), 'PRESUP_Codigo', array('PRESUC_Numero', 'nombre'), '', array('', '::Seleccione::'), ' / ');
        $data['cboOrdencompra'] = $this->OPTION_generador($this->ocompra_model->listar_ocompras_nocomprobante($tipo_oper), 'OCOMP_Codigo', array('OCOMC_Numero', 'nombre'), '', array('', '::Seleccione::'), ' - ');
        $data['cboGuiaRemision'] = $this->OPTION_generador($this->guiarem_model->listar_guiarem_nocomprobante($tipo_oper), 'GUIAREMP_Codigo', array('codigo', 'nombre'), '', array('', '::Seleccione::'), ' / ');
        $data['cboVendedor'] = $this->OPTION_generador($this->directivo_model->listar_directivo($this->session->userdata('empresa'), '4'), 'DIREP_Codigo', array('PERSC_ApellidoPaterno', 'PERSC_ApellidoMaterno', 'PERSC_Nombre'), '', array('', '::Seleccione::'), ' ');
        //$data['tdc'] = $this->tipocambio_model->obtener_tdc_dolar(date('Y-m-d'));
        date_default_timezone_set("America/Lima");
        $cambio_dia = $this->tipocambio_model->obtener_tdc_dolar(date('Y-m-d'));

        if (count($cambio_dia) > 0) {
            $data['tdc'] = $cambio_dia[0]->TIPCAMC_FactorConversion;
        } else {
            $data['tdc'] = '';
        }
        $data['serie'] = '';
        $data['numero'] = '';
        if ($tipo_oper == 'V') {
            $temp = $this->obtener_serie_numero($tipo_docu);
        }

        $data['numserref'] = "";
        $data['numdocref'] = "";
        $data['cliente'] = "";
        $data['ruc_cliente'] = "";
        $data['nombre_cliente'] = "";
        $data['proveedor'] = "";
        $data['ruc_proveedor'] = "";
        $data['nombre_proveedor'] = "";
        $data['detalle_comprobante'] = array();
        $data['observacion'] = "";
        $data['focus'] = "";
        $data['pedido'] = "";
        $data['descuento'] = "0";
        $data['igv'] = $comp_confi[0]->COMPCONFIC_Igv;
        $data['hidden'] = "";
        $data['preciototal'] = "";
        $data['descuentotal'] = "";
        $data['igvtotal'] = "";
        $data['importetotal'] = "";
        $data['preciototal_conigv'] = "";
        $data['descuentotal_conigv'] = "";
        $data['hidden'] = "";
        $data['observacion'] = "";
        $data['guiarem_codigo'] = "";
        $data['docurefe_codigo'] = "";
        $data['estado'] = "1";

        $data['modo_impresion'] = "1";
        if ($tipo_docu != 'B') {
            if (FORMATO_IMPRESION == 1)
                $data['modo_impresion'] = "2";
            else
                $data['modo_impresion'] = "1";
        }
        $data['hoy'] = mysql_to_human(mdate("%Y-%m-%d ", time()));
        $atributos = array('width' => 700, 'height' => 450, 'scrollbars' => 'yes', 'status' => 'yes', 'resizable' => 'yes', 'screenx' => '0', 'screeny' => '0');
        $contenido = "<img height='16' width='16' src='" . base_url() . "images/ver.png' title='Buscar Cliente' border='0'>";
        $data['vercliente'] = anchor_popup('ventas/cliente/ventana_busqueda_cliente', $contenido, $atributos, 'linkVerCliente');
        $data['verproveedor'] = anchor_popup('compras/proveedor/ventana_busqueda_proveedor', $contenido, $atributos, 'linkVerProveedor');
        $data['verproducto'] = anchor_popup('almacen/producto/ventana_busqueda_producto', $contenido, $atributos, 'linkVerProducto');


        //obtengo las series de la configuracion
        if ($tipo_docu == 'F') {//nota de credito
            $tipo = 11;
        }
        if ($tipo_docu == 'B') {//nota de debito
            $tipo = 12;
        }

        $cofiguracion_datos = $this->configuracion_model->obtener_numero_documento($compania, $tipo);
        $cofiguracion_datos[0]->CONFIC_Serie;
        $cofiguracion_datos[0]->CONFIC_Numero;
        $data['serie_suger_b'] = $cofiguracion_datos[0]->CONFIC_Serie;
        $data['numero_suger_b'] = $cofiguracion_datos[0]->CONFIC_Numero + 1;
        $data['serie_suger_f'] = $cofiguracion_datos[0]->CONFIC_Serie;
        $data['numero_suger_f'] = $cofiguracion_datos[0]->CONFIC_Numero + 1;

        $this->layout->view('ventas/notacredito_nueva', $data);
    }

    public function ventana_muestra_notadecredito($tipo_oper = 'V', $codigo = '', $formato = 'SELECT_ITEM', $docu_orig = '', $almacen = "", $comprobante = '')
    {
        //$this->output->enable_profiler(TRUE);
        $cliente = '';
        $nombre_cliente = '';
        $ruc_cliente = '';
        $proveedor = '';
        $nombre_proveedor = '';
        $ruc_proveedor = '';
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

        $lista_comprobante = $this->notacredito_model->buscar_comprobantes_asoc($tipo_oper, $docu_orig, $filter);

        $lista = array();
        $tipoDocumento = 0;
        foreach ($lista_comprobante as $indice => $value) {
            $ver = "<a href='javascript:;' onclick='ver_detalle_documento(" . $value->CPP_Codigo . ")'><img src='" . base_url() . "images/ver.png' width='16' height='16' border='0' title='Ver Detalles'></a>";
            $select = '';
                if ($value->CPC_TipoDocumento == 'F') {
                    $tipoDocumento = 1; // Factura
                }
                else if ($value->CPC_TipoDocumento == 'B') {
                    $tipoDocumento = 2;
                }
                else if ($value->CPC_TipoDocumento == 'N'){
                    $tipoDocumento = 3;
                }
                else {
                    $tipoDocumento = 0;
                }
                $select = "<a href='javascript:;' onclick='select_comprobante(" . $value->CPP_Codigo . ", " . $value->CPC_Serie . ", " . $value->CPC_Numero . ", " . $tipoDocumento . ")' ><img src='" . base_url() . "images/ir.png' width='16' height='16' border='0' title='Seleccionar Comprobantee'></a>";
            $lista[] = array(mysql_to_human($value->CPC_Fecha), $value->CPC_Serie, $value->CPC_Numero, $value->numdoc, $value->nombre, $value->MONED_Simbolo . ' ' . number_format($value->CPC_total), $ver, $select);

        }
        $data['lista'] = $lista;
        $data['cliente'] = $cliente;
        $data['nombre_cliente'] = $nombre_cliente;
        $data['ruc_cliente'] = $ruc_cliente;
        $data['proveedor'] = $proveedor;
        $data['nombre_proveedor'] = $nombre_proveedor;
        $data['ruc_proveedor'] = $ruc_proveedor;
        $data['almacen'] = $almacen;
        $data['comprobante'] = $comprobante;
        $data['tipo_oper'] = $tipo_oper;
        $data['docu_orig'] = $docu_orig;
        $data['formato'] = $formato;
        $data['form_open'] = form_open(base_url() . "index.php/ventas/notacredito/ventana_muestra_notadecredito", array("name" => "frmComprobante", "id" => "frmComprobante"));
        $data['form_close'] = form_close();
        $data['form_hidden'] = form_hidden(array("base_url" => base_url(), "docu_orig" => $docu_orig, "formato" => $formato));

        $this->load->view('ventas/ventana_muestra_notadecredito', $data);
    }


    public function comprobante_insertar()
    {
        $mensaje = array();

        if ($this->input->post('serie') == '')
            $mensaje = array(
                'mensaje' => 'SERIE',
                'descripcion' => 'NO TIENE SERIE LA NOTA'
            );
        if ($this->input->post('numero') == '')
            $mensaje = array(
                'mensaje' => 'NUMERO',
                'descripcion' => 'NO TIENE NUMERO LA NOTA'
            );
        if ($this->input->post('observacion') == '')
            $mensaje = array(
                'mensaje' => 'Observacion',
                'descripcion' => 'NO TIENE OBSERVACION LA NOTA'
            );

        $tipo_oper = $this->input->post('tipo_oper'); // V o C

        $docuOrigen = $this->input->post('origenDocumento'); // Origen => 0:No tiene, 1: Factura, 2:Boleta, 3:Comprobante

        if($docuOrigen == 0 || $docuOrigen == '0') {
            $docuOrigen = "A";
        }else if ($docuOrigen == 1 || $docuOrigen == "1") {
            $docuOrigen = "F";
        } else if ($docuOrigen == 2 || $docuOrigen == "2") {
            $docuOrigen = "B";
        } else if ($docuOrigen == 3 || $docuOrigen == "3") {
            $docuOrigen = "N";
        }else{
            $docuOrigen = "A";
        }

        $tipo_docu = $this->input->post('tipo_docu');
        $compania = $this->somevar['compania'];

        $numero = $this->input->post('numero');

        if ($tipo_oper == 'V') {
            if ($tipo_docu == 'F') {//nota de credito
                $tipo = 11;
            }
            if ($tipo_docu == 'B') {//nota de debito
                $tipo = 12;
            }

            $this->configuracion_model->modificar_configuracion($compania, $tipo, $numero);

        }

        $filter = new stdClass();
        $filter->CRED_FlagEstado = $this->input->post('estado');

        if ($tipo_oper == 'V') {
            $filter->CLIP_Codigo = $this->input->post('cliente');
        } else {
            $filter->PROVP_Codigo = $this->input->post('proveedor');
        }

        $filter->CRED_TipoOperacion = $tipo_oper;

        $filter->CRED_TipoDocumento_inicio = $docuOrigen;

        if ($docuOrigen == "A") { // Valido si existe un comprobante
            $filter->CRED_NumeroInicio = "------";
        }else{
            $filter->CRED_ComproInicio = $this->input->post('guiaReferente');
            $numInicio = $this->input->post('idNumero');
            $serInicio = $this->input->post('idSerie');
            $filter->CRED_NumeroInicio = $serInicio . " - " . $numInicio;
        }

        $filter->CRED_Flag = 1;
        $filter->COMPP_Codigo = $compania;
        $filter->CRED_Serie = $this->input->post('serie');
        $filter->CRED_Numero = $numero;
        $filter->USUA_Codigo = $this->somevar['user'];
        $filter->MONED_Codigo = $this->input->post('moneda');
        $filter->CRED_subtotal = $this->input->post('preciototal');
        $filter->CRED_descuento = $this->input->post('descuentotal');
        $filter->CRED_igv = $this->input->post('igvtotal');
        $filter->CRED_total = $this->input->post('importetotal');
        $filter->CRED_descuento100 = $this->input->post('descuento');
        $filter->CRED_igv100 = $this->input->post('igv');
        $filter->CRED_Observacion = strtoupper($this->input->post('observacion'));
        $filter->CRED_Fecha = human_to_mysql($this->input->post('fecha'));
        $filter->CRED_TDC = $this->input->post('tdc');
        $filter->CRED_FechaRegistro = date('Y-m-d H:i:s');
        $filter->CRED_FlagEstado = 1;
        $filter->CRED_TipoNota = "N"; // Importante

        $nota = $this->notacredito_model->insertar_notaCredito($filter);

        if($nota == NULL) {
            $mensaje = array(
                'mensaje' => 'NOTA',
                'descripcion' => 'NO SE PUDO INSERTAR CORRECTAMENTE LA NOTA'
            );
        }else{

            // TODO - INSERTAR CJI_NOTADETALLE

            $prodcodigo = $this->input->post('prodcodigo');
            $prodcantidad = $this->input->post('prodcantidad');
            $prodpu = $this->input->post('prodpu');
            $prodprecio = $this->input->post('prodprecio');
            $proddescuento = $this->input->post('proddescuento');
            $prodigv = $this->input->post('prodigv');
            $prodimporte = $this->input->post('prodimporte');
            $prodpu_conigv = $this->input->post('prodpu_conigv');
            $produnidad = $this->input->post('produnidad');
            $flagGenInd = $this->input->post('flagGenIndDet');
            $detaccion = $this->input->post('detaccion');
            $proddescuento100 = $this->input->post('proddescuento100');
            $prodigv100 = $this->input->post('prodigv100');
            $prodcosto = $this->input->post('prodcosto');
            $proddescri = $this->input->post('proddescri');

            $detalles = 0;
            $totalProductos = count($prodcodigo);

            if ($totalProductos > 0) {
                foreach ($prodcodigo as $indice => $valor) {
                    $filter = new stdClass();
                    $filter->CRED_Codigo = $nota;
                    $filter->PROD_Codigo = $prodcodigo[$indice];
                    $filter->UNDMED_Codigo = $produnidad[$indice];
                    $filter->CREDET_Cantidad = $prodcantidad[$indice];
                    $filter->CREDET_Pu = $prodpu[$indice];
                    $filter->CREDET_Subtotal = $prodprecio[$indice];
                    $filter->CREDET_Descuento = $proddescuento[$indice];
                    $filter->CREDET_Igv = $prodigv[$indice];
                    $filter->CREDET_Total = $prodimporte[$indice];
                    $filter->CREDET_Pu_ConIgv = $prodpu_conigv[$indice];
                    $filter->CREDET_Igv100 = $prodigv100[$indice];
                    $filter->CREDET_Descuento100 = $proddescuento100[$indice];
                    $filter->CREDET_Costo = $prodcosto[$indice];
                    $filter->CREDET_Descripcion = strtoupper($proddescri[$indice]);
                    $filter->CREDET_Observacion = "";
                    $filter->CREDET_FlagEstado = 1;
                    $notadetalle = $this->notacreditodetalle_model->insertar($filter);

                    if($notadetalle){
                        $detalles++;
                    }
                }
            }

            if($totalProductos != $detalles){
                $mensaje = array(
                    'mensaje' => 'NOTA DETALLE',
                    'descripcion' => 'NO SE PUDO INSERTAR TODOS LOS PRODUCTOS EN LA NOTA, Productos insertados['.$detalles.']'
                );
            }else{

                $mensaje = array(
                    'mensaje' => 'SUCCESS',
                    'descripcion' => 'SE REGISTRO CORRECTAMENTE LA NOTA DE CREDITO'
                );

            }

        }

        echo json_encode($mensaje);

    }

    public function comprobante_editar($codigo, $tipo_oper = 'V', $tipo_docu = 'F')
    {
        $this->load->library('layout', 'layout');
        unset($_SESSION['serie']);
        $comp_confi = $this->companiaconfiguracion_model->obtener($this->somevar['compania']);
        $data['compania'] = $this->somevar['compania'];

        $datos_comprobante = $this->notacredito_model->obtener_comprobante($codigo);
        $presupuesto = $datos_comprobante[0]->PRESUP_Codigo;
        $ordencompra = $datos_comprobante[0]->OCOMP_Codigo;
        $guiaremision = $datos_comprobante[0]->GUIAREMP_Codigo;
        $serie = $datos_comprobante[0]->CRED_Serie;
        $numero = $datos_comprobante[0]->CRED_Numero;
        $cliente = $datos_comprobante[0]->CLIP_Codigo;
        $proveedor = $datos_comprobante[0]->PROVP_Codigo;
        $forma_pago = $datos_comprobante[0]->FORPAP_Codigo;
        $moneda = $datos_comprobante[0]->MONED_Codigo;
        $subtotal = $datos_comprobante[0]->CRED_subtotal;
        $descuento = $datos_comprobante[0]->CRED_descuento;
        $igv = $datos_comprobante[0]->CRED_igv;
        $total = $datos_comprobante[0]->CRED_total;
        $subtotal_conigv = $datos_comprobante[0]->CRED_subtotal_conigv;
        $descuento_conigv = $datos_comprobante[0]->CRED_descuento_conigv;
        $igv100 = $datos_comprobante[0]->CRED_igv100;
        $descuento100 = $datos_comprobante[0]->CRED_descuento100;
        $guiarem_codigo = $datos_comprobante[0]->CRED_GuiaRemCodigo;
        $docurefe_codigo = $datos_comprobante[0]->CRED_DocuRefeCodigo;
        $observacion = $datos_comprobante[0]->CRED_Observacion;
        $modo_impresion = $datos_comprobante[0]->CRED_ModoImpresion;
        $estado = $datos_comprobante[0]->CRED_FlagEstado;
        $fecha = mysql_to_human($datos_comprobante[0]->CRED_Fecha);
        $vendedor = $datos_comprobante[0]->CRED_Vendedor;
        $tdc = $datos_comprobante[0]->CRED_TDC;
        $tipodoc_ref = $datos_comprobante[0]->DOCUP_Codigo;
        $num_serdoc_ref = $datos_comprobante[0]->CRED_NumeroRef;
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
        $data['codigo'] = $codigo;
        $data['tipo_docu'] = $tipo_docu;
        $data['tipo_oper'] = $tipo_oper;
        $lista_almacen = $this->almacen_model->seleccionar();
        $data['cboAlmacen'] = form_dropdown("almacen", $lista_almacen, obtener_val_x_defecto($lista_almacen), " class='comboMedio' style='width:125px;' id='almacen'");
        $data['cboPresupuesto'] = $this->OPTION_generador($this->presupuesto_model->listar_presupuestos_nocomprobante($tipo_oper, $tipo_docu, $codigo), 'PRESUP_Codigo', array('PRESUC_Numero', 'nombre'), $presupuesto, array('', '::Seleccione::'), ' / ');
        $data['cboOrdencompra'] = $this->OPTION_generador($this->ocompra_model->listar_ocompras_nocomprobante($tipo_oper, $codigo), 'OCOMP_Codigo', array('OCOMC_Numero', 'nombre'), $ordencompra, array('', '::Seleccione::'), ' / ');
        $data['cboGuiaRemision'] = $this->OPTION_generador($this->guiarem_model->listar_guiarem_nocomprobante($tipo_oper, $codigo), 'GUIAREMP_Codigo', array('codigo', 'nombre'), $guiaremision, array('', '::Seleccione::'), ' / ');
        $data['cboFormaPago'] = $this->OPTION_generador($this->formapago_model->listar(), 'FORPAP_Codigo', 'FORPAC_Descripcion', $forma_pago);
        $data['cboMoneda'] = $this->OPTION_generador($this->moneda_model->listar(), 'MONED_Codigo', 'MONED_Descripcion', $moneda);
        $data['cboVendedor'] = $this->OPTION_generador($this->directivo_model->listar_directivo($this->session->userdata('empresa'), '4'), 'DIREP_Codigo', array('PERSC_ApellidoPaterno', 'PERSC_ApellidoMaterno', 'PERSC_Nombre'), $vendedor, array('', '::Seleccione::'), ' ');
        $data['serie'] = $serie;
        $data['numero'] = $numero;

        //$data['doc_ref'] = $tipodoc_ref;
        $data['doc_ref'] = $this->OPTION_generador($this->documento_model->listar('1'), 'DOCUP_Codigo', 'DOCUC_Descripcion', $tipodoc_ref);
        //$array_sernum_ref = explode(' - ', $num_serdoc_ref);
        $data['numserref'] = $serie;
        $data['numdocref'] = $numero;

        $data['descuento'] = $descuento100;
        $data['igv'] = $igv100;
        $data['preciototal'] = $subtotal;
        $data['descuentotal'] = $descuento;
        $data['igvtotal'] = $igv;
        $data['importetotal'] = $total;
        $data['preciototal_conigv'] = $subtotal_conigv;
        $data['descuentotal_conigv'] = $descuento_conigv;
        $data['cliente'] = $cliente;
        $data['ruc_cliente'] = $ruc_cliente;
        $data['nombre_cliente'] = $nombre_cliente;
        $data['proveedor'] = $proveedor;
        $data['ruc_proveedor'] = $ruc_proveedor;
        $data['nombre_proveedor'] = $nombre_proveedor;
        $data['contiene_igv'] = (($comp_confi[0]->COMPCONFIC_PrecioContieneIgv == '1') ? true : false);
        $oculto = form_hidden(array('codigo' => $codigo, 'base_url' => base_url(), 'tipo_oper' => $tipo_oper, 'tipo_docu' => $tipo_docu, 'contiene_igv' => ($data['contiene_igv'] == true ? '1' : '0')));
        $data['titulo'] = "EDITAR " . strtoupper($this->obtener_tipo_documento($tipo_docu));
        $data['tipo_docu'] = $tipo_docu;
        $data['formulario'] = "frmComprobante";
        $data['oculto'] = $oculto;
        $data['url_action'] = base_url() . "index.php/ventas/notacredito/comprobante_modificar";
        $atributos = array('width' => 700, 'height' => 450, 'scrollbars' => 'yes', 'status' => 'yes', 'resizable' => 'yes', 'screenx' => '0', 'screeny' => '0');
        $contenido = "<img height='16' width='16' src='" . base_url() . "images/ver.png' title='Buscar Cliente' border='0'>";
        $data['vercliente'] = anchor_popup('ventas/cliente/ventana_busqueda_cliente', $contenido, $atributos, 'linkVerCliente');
        $data['verproveedor'] = anchor_popup('compras/proveedor/ventana_busqueda_proveedor', $contenido, $atributos, 'linkVerProveedor');
        $data['verproducto'] = anchor_popup('almacen/producto/ventana_busqueda_producto', $contenido, $atributos, 'linkVerProducto');
        $data['hoy'] = $fecha;
        $data['guiarem_codigo'] = $guiarem_codigo;
        $data['docurefe_codigo'] = $docurefe_codigo;
        $data['observacion'] = $observacion;
        $data['estado'] = $estado;
        $data['hidden'] = "";
        $data['focus'] = "";
        $data['modo_impresion'] = $modo_impresion;
        $data['serie_suger'] = "";
        $data['numero_suger'] = "";
        $data['tdc'] = $tdc;
        $detalle_comprobante = $this->obtener_lista_detalles($codigo);

        $data['detalle_comprobante'] = $detalle_comprobante;
        $this->layout->view('ventas/notacredito_nueva', $data);
    }

    public function comprobante_modificar()
    {

        if ($this->input->post('serie') == '')
            exit('{"result":"error", "campo":"serie"}');
        if ($this->input->post('numero') == '')
            exit('{"result":"error", "campo":"numero"}');
        if ($this->input->post('tipo_oper') == 'V' && $this->input->post('cliente') == '')
            exit('{"result":"error", "campo":"ruc_cliente"}');
        if ($this->input->post('tipo_oper') == 'C' && $this->input->post('proveedor') == '')
            exit('{"result":"error", "campo":"ruc_proveedor}');
        if ($this->input->post('moneda') == '0' || $this->input->post('moneda') == '')
            exit('{"result":"error", "campo":"moneda}');
        if ($this->input->post('estado') == '0' && $this->input->post('observacion') == '')
            exit('{"result":"error", "campo":"observacion"}');

        $codigo = $this->input->post('codigo');
        $tipo_oper = $this->input->post('tipo_oper');
        $tipo_docu = $this->input->post('tipo_docu');

        $filter = new stdClass();
        $filter->FORPAP_Codigo = NULL;
        /* if ($this->input->post('forma_pago') != '' && $this->input->post('forma_pago') != '0')
          $filter->FORPAP_Codigo = $this->input->post('forma_pago'); */
        $filter->FORPAP_Codigo = $this->input->post('forma_pago');
        $filter->CRED_Observacion = strtoupper($this->input->post('observacion'));
        $filter->CRED_Fecha = human_to_mysql($this->input->post('fecha'));
        $filter->CRED_Numero = $this->input->post('numero');
        $filter->CRED_Serie = $this->input->post('serie');
        $filter->MONED_Codigo = $this->input->post('moneda');
        $filter->CRED_descuento100 = $this->input->post('descuento');
        $filter->CRED_igv100 = $this->input->post('igv');
        $filter->DOCUP_Codigo = $this->input->post('doc_ref');
        $filter->CRED_NumeroRef = $this->input->post('numserref') . ' - ' . $this->input->post('numdocref');
        if ($tipo_oper == 'V')
            $filter->CLIP_Codigo = $this->input->post('cliente');
        else
            $filter->PROVP_Codigo = $this->input->post('proveedor');
        $filter->PRESUP_Codigo = NULL;
        if ($this->input->post('presupuesto') != '' && $this->input->post('presupuesto') != '0')
            $filter->PRESUP_Codigo = $this->input->post('presupuesto');
        $filter->OCOMP_Codigo = NULL;
        if ($this->input->post('ordencompra') != '' && $this->input->post('ordencompra') != '0')
            $filter->OCOMP_Codigo = $this->input->post('ordencompra');
        $filter->GUIAREMP_Codigo = NULL;
        if ($this->input->post('guiaremision') != '' && $this->input->post('guiaremision') != '0')
            $filter->GUIAREMP_Codigo = $this->input->post('guiaremision');
        $filter->CRED_GuiaRemCodigo = strtoupper($this->input->post('guiaremision_codigo'));
        $filter->CRED_DocuRefeCodigo = strtoupper($this->input->post('docurefe_codigo'));
        $filter->CRED_FlagEstado = $this->input->post('estado');
        $filter->CRED_ModoImpresion = '1';
        if ($this->input->post('modo_impresion') != '0' && $this->input->post('modo_impresion') != '')
            $filter->CRED_ModoImpresion = $this->input->post('modo_impresion');
        if ($tipo_docu != 'B') {
            $filter->CRED_subtotal = $this->input->post('preciototal');
            $filter->CRED_descuento = $this->input->post('descuentotal');
            $filter->CRED_igv = $this->input->post('igvtotal');
        } else {
            $filter->CRED_subtotal_conigv = $this->input->post('preciototal_conigv');
            $filter->CRED_descuento_conigv = $this->input->post('descuentotal_conigv');
        }
        $filter->CRED_total = $this->input->post('importetotal');
        $filter->CRED_Vendedor = NULL;
        if ($this->input->post('vendedor') != '')
            $filter->CRED_Vendedor = $this->input->post('vendedor');

        $this->notacredito_model->modificar_comprobante($codigo, $filter);

        $prodcodigo = $this->input->post('prodcodigo');
        $flagBS = $this->input->post('flagBS');
        $prodcantidad = $this->input->post('prodcantidad');
        if ($tipo_docu != 'B') {
            $prodpu = $this->input->post('prodpu');
            $prodprecio = $this->input->post('prodprecio');
            $proddescuento = $this->input->post('proddescuento');
            $prodigv = $this->input->post('prodigv');
        } else {
            $prodprecio_conigv = $this->input->post('prodprecio_conigv');
            $proddescuento_conigv = $this->input->post('proddescuento_conigv');
        }
        $prodimporte = $this->input->post('prodimporte');
        $prodpu_conigv = $this->input->post('prodpu_conigv');
        $produnidad = $this->input->post('produnidad');
        $detaccion = $this->input->post('detaccion');
        $detacodi = $this->input->post('detacodi');
        $prodigv100 = $this->input->post('prodigv100');
        $proddescuento100 = $this->input->post('proddescuento100');
        $prodcosto = $this->input->post('prodcosto');
        $proddescri = $this->input->post('proddescri');

        if (is_array($detacodi) > 0) {
            foreach ($detacodi as $indice => $valor) {
                $detalle_accion = $detaccion[$indice];

                $filter = new stdClass();
                $filter->CRED_Codigo = $codigo;
                $filter->PROD_Codigo = $prodcodigo[$indice];
                if ($flagBS[$indice] == 'B')
                    $filter->UNDMED_Codigo = $produnidad[$indice];
                $filter->CREDET_Cantidad = $prodcantidad[$indice];
                if ($tipo_docu != 'B') {
                    $filter->CREDET_Pu = $prodpu[$indice];
                    $filter->CREDET_Subtotal = $prodprecio[$indice];
                    $filter->CREDET_Descuento = $proddescuento[$indice];
                    $filter->CREDET_Igv = $prodigv[$indice];
                } else {
                    $filter->CREDET_Subtotal_ConIgv = $prodprecio_conigv[$indice];
                    $filter->CREDET_Descuento_ConIgv = $proddescuento_conigv[$indice];
                }
                $filter->CREDET_Total = $prodimporte[$indice];
                $filter->CREDET_Pu_ConIgv = $prodpu_conigv[$indice];
                $filter->CREDET_Descuento100 = $proddescuento100[$indice];
                $filter->CREDET_Igv100 = $prodigv100[$indice];
                if ($tipo_oper == 'V')
                    $filter->CREDET_Costo = $prodcosto[$indice];
                $filter->CREDET_Descripcion = strtoupper($proddescri[$indice]);
                $filter->CREDET_Observacion = "";


                if ($detalle_accion == 'n') {
                    $this->notacreditodetalle_model->insertar($filter);
                } elseif ($detalle_accion == 'm') {
                    $this->notacreditodetalle_model->modificar($valor, $filter);
                } elseif ($detalle_accion == 'e') {
                    $this->notacreditodetalle_model->eliminar($valor);
                }
            }
        }
        exit('{"result":"ok", "codigo":"' . $codigo . '"}');
    }

    public function comprobante_eliminar()
    {
        $this->load->library('layout', 'layout');

        $comprobante = $this->input->post('comprobante');
        $this->comprobante_model->eliminar_comprobante($comprobante);
    }

    public function comprobante_buscar()
    {

    }

    function obtener_datos_cliente($cliente, $tipo_docu = 'F')
    {
        $datos_cliente = $this->cliente_model->obtener_datosCliente($cliente);
        $empresa = $datos_cliente[0]->EMPRP_Codigo;
        $persona = $datos_cliente[0]->PERSP_Codigo;
        $tipo = $datos_cliente[0]->CLIC_TipoPersona;
        if ($tipo == 0) {
            $datos_persona = $this->persona_model->obtener_datosPersona($persona);
            $nombre = $datos_persona[0]->PERSC_Nombre . " " . $datos_persona[0]->PERSC_ApellidoPaterno . " " . $datos_persona[0]->PERSC_ApellidoMaterno;
            if ($tipo_docu != 'B')
                $numdoc = $datos_persona[0]->PERSC_Ruc;
            else
                $numdoc = $datos_persona[0]->PERSC_NumeroDocIdentidad;
            $direccion = $datos_persona[0]->PERSC_Direccion;
        } elseif ($tipo == 1) {
            $datos_empresa = $this->empresa_model->obtener_datosEmpresa($empresa);
            $nombre = $datos_empresa[0]->EMPRC_RazonSocial;
            $numdoc = $datos_empresa[0]->EMPRC_Ruc;
            $emp_direccion = $this->empresa_model->obtener_establecimientosEmpresa_principal($empresa);
            $direccion = $emp_direccion[0]->EESTAC_Direccion;
        }

        return array('numdoc' => $numdoc, 'nombre' => $nombre, 'direccion' => $direccion);
    }

    function obtener_datos_proveedor($proveedor, $tipo_docu = 'F')
    {
        $datos = $this->proveedor_model->obtener_datosProveedor($proveedor);

        //$datos_cliente = $this->cliente_model->obtener_datosCliente($proveedor);
        $empresa = $datos[0]->EMPRP_Codigo;
        $persona = $datos[0]->PERSP_Codigo;
        $tipo = $datos[0]->PROVC_TipoPersona;
        if ($tipo == 0) {
            $datos_persona = $this->persona_model->obtener_datosPersona($persona);
            $nombre = $datos_persona[0]->PERSC_Nombre . " " . $datos_persona[0]->PERSC_ApellidoPaterno . " " . $datos_persona[0]->PERSC_ApellidoMaterno;
            if ($tipo_docu != 'B')
                $numdoc = $datos_persona[0]->PERSC_Ruc;
            else
                $numdoc = $datos_persona[0]->PERSC_NumeroDocIdentidad;
            $direccion = $datos_persona[0]->PERSC_Direccion;
        } elseif ($tipo == 1) {
            $datos_empresa = $this->empresa_model->obtener_datosEmpresa($empresa);
            $nombre = $datos_empresa[0]->EMPRC_RazonSocial;
            $numdoc = $datos_empresa[0]->EMPRC_Ruc;
            $emp_direccion = $this->empresa_model->obtener_establecimientosEmpresa_principal($empresa);
            $direccion = $emp_direccion[0]->EESTAC_Direccion;
        }

        return array('numdoc' => $numdoc, 'nombre' => $nombre, 'direccion' => $direccion);
    }


    public function obtener_lista_detalles($codigo)
    {
        $detalle = $this->notacreditodetalle_model->listar($codigo);
        $lista_detalles = array();
        if (count($detalle) > 0) {
            foreach ($detalle as $indice => $valor) {
                $detacodi = $valor->CREDET_Codigo;
                $producto = $valor->PROD_Codigo;
                //echo $producto;exit;
                $unidad = $valor->UNDMED_Codigo;
                $cantidad = $valor->CREDET_Cantidad;
                $pu = $valor->CREDET_Pu;
                $subtotal = $valor->CREDET_Subtotal;
                $igv = $valor->CREDET_Igv;
                $descuento = $valor->CREDET_Descuento;
                $total = $valor->CREDET_Total;
                $pu_conigv = $valor->CREDET_Pu_ConIgv;
                $subtotal_conigv = $valor->CREDET_Subtotal_ConIgv;
                $descuento_conigv = $valor->CREDET_Descuento_ConIgv;
                $descuento100 = $valor->CREDET_Descuento100;
                $igv100 = $valor->CREDET_Igv100;
                $observacion = $valor->CREDET_Observacion;
                $datos_producto = $this->producto_model->obtener_producto($producto);
                $flagBS = $datos_producto[0]->PROD_FlagBienServicio;
                $datos_unidad = $this->unidadmedida_model->obtener($unidad);
                $GenInd = $valor->CREDET_GenInd;
                $costo = $valor->CREDET_Costo;
                $nombre_producto = ($valor->CREDET_Descripcion != '' ? $valor->CREDET_Descripcion : $datos_producto[0]->PROD_Nombre);
                $nombre_producto = str_replace('\\', '', $nombre_producto);
                $codigo_interno = $datos_producto[0]->PROD_CodigoInterno;
                $codigo_usuario = $datos_producto[0]->PROD_CodigoUsuario;
                $nombre_unidad = is_array($datos_unidad) ? $datos_unidad[0]->UNDMED_Simbolo : '';

                $objeto = new stdClass();
                $objeto->CREDET_Codigo = $detacodi;
                $objeto->flagBS = $flagBS;
                $objeto->PROD_Codigo = $producto;
                $objeto->PROD_CodigoInterno = $codigo_interno;
                $objeto->PROD_CodigoUsuario = $codigo_usuario;
                $objeto->UNDMED_Codigo = $unidad;
                $objeto->UNDMED_Simbolo = $nombre_unidad;
                $objeto->CREDET_GenInd = $GenInd;
                $objeto->CREDET_Costo = $costo;
                $objeto->PROD_Nombre = $nombre_producto;
                $objeto->CREDET_Cantidad = $cantidad;
                $objeto->CREDET_Pu = $pu;
                $objeto->CREDET_Subtotal = $subtotal;
                $objeto->CREDET_Descuento = $descuento;
                $objeto->CREDET_Igv = $igv;
                $objeto->CREDET_Total = $total;
                $objeto->CREDET_Pu_ConIgv = $pu_conigv;
                $objeto->CREDET_Subtotal_ConIgv = $subtotal_conigv;
                $objeto->CREDET_Descuento_ConIgv = $descuento_conigv;
                $objeto->CREDET_Descuento100 = $descuento100;
                $objeto->CREDET_Igv100 = $igv100;
                $objeto->CREDET_Observacion = $observacion;
                $lista_detalles[] = $objeto;
            }
        }
        return $lista_detalles;
    }


    //gcbq
    public function obtener_detalle_notadecredito($comprobante, $tipo_oper = 'V', $almacen = "")
    {
        $detalle = $this->notacreditodetalle_model->listar($comprobante);
        $lista_detalles = array();
        if (count($detalle) > 0) {
            foreach ($detalle as $indice => $valor) {
                $detacodi = $valor->CREDET_Codigo;
                $producto = $valor->PROD_Codigo;
                //echo $producto;exit;
                $unidad = $valor->UNDMED_Codigo;
                $cantidad = $valor->CREDET_Cantidad;
                $pu = $valor->CREDET_Pu;
                $subtotal = $valor->CREDET_Subtotal;
                $igv = $valor->CREDET_Igv;
                $descuento = $valor->CREDET_Descuento;
                $total = $valor->CREDET_Total;
                $pu_conigv = $valor->CREDET_Pu_ConIgv;
                $subtotal_conigv = $valor->CREDET_Subtotal_ConIgv;
                $descuento_conigv = $valor->CREDET_Descuento_ConIgv;
                $descuento100 = $valor->CREDET_Descuento100;
                $igv100 = $valor->CREDET_Igv100;
                $observacion = $valor->CREDET_Observacion;
                $datos_producto = $this->producto_model->obtener_producto($producto);
                $flagBS = $datos_producto[0]->PROD_FlagBienServicio;
                $datos_unidad = $this->unidadmedida_model->obtener($unidad);
                $GenInd = $valor->CREDET_GenInd;
                $costo = $valor->CREDET_Costo;
                $nombre_producto = ($valor->CREDET_Descripcion != '' ? $valor->CREDET_Descripcion : $datos_producto[0]->PROD_Nombre);
                $nombre_producto = str_replace('\\', '', $nombre_producto);
                $codigo_interno = $datos_producto[0]->PROD_CodigoInterno;
                $codigo_usuario = $datos_producto[0]->PROD_CodigoUsuario;
                $nombre_unidad = is_array($datos_unidad) ? $datos_unidad[0]->UNDMED_Simbolo : '';

                $objeto = new stdClass();
                $objeto->CREDET_Codigo = $detacodi;
                $objeto->flagBS = $flagBS;
                $objeto->PROD_Codigo = $producto;
                $objeto->PROD_CodigoInterno = $codigo_interno;
                $objeto->PROD_CodigoUsuario = $codigo_usuario;
                $objeto->UNDMED_Codigo = $unidad;
                $objeto->UNDMED_Simbolo = $nombre_unidad;
                $objeto->CREDET_GenInd = $GenInd;
                $objeto->CREDET_Costo = $costo;
                $objeto->PROD_Nombre = $nombre_producto;
                $objeto->CREDET_Cantidad = $cantidad;
                $objeto->CREDET_Pu = $pu;
                $objeto->CREDET_Subtotal = $subtotal;
                $objeto->CREDET_Descuento = $descuento;
                $objeto->CREDET_Igv = $igv;
                $objeto->CREDET_Total = $total;
                $objeto->CREDET_Pu_ConIgv = $pu_conigv;
                $objeto->CREDET_Subtotal_ConIgv = $subtotal_conigv;
                $objeto->CREDET_Descuento_ConIgv = $descuento_conigv;
                $objeto->CREDET_Descuento100 = $descuento100;
                $objeto->CREDET_Igv100 = $igv100;
                $objeto->CREDET_Observacion = $observacion;
                $lista_detalles[] = $objeto;
            }
        }
        $resultado = json_encode($lista_detalles);
        echo $resultado;
    }


    /**
     * Fondo
     *  0 : Imprimir
     *  1 : PDF
     *  Codigo, el comprobante seleccionado
     *  Tipo_docu, Factura, Boleta o Comprobante
     * @param int $fondo
     * @param $codigo
     * @param string $tipo_docu
     */
    public function comprobante_ver_pdf_conmenbrete($fondo = 1, $codigo, $tipo_docu = 'F')
    {
        switch (FORMATO_IMPRESION) {
            case 1: //Formato para ferresat
                $this->comprobante_ver_pdf_conmenbrete_formato1($codigo, $fondo);
                break;
            default:
                $this->comprobante_ver_pdf_conmenbrete_formato1($codigo, $tipo_docu);
                break;
        }
    }

    public function comprobante_ver_html($codigo, $tipo_docu = 'F')
    {


        if ($tipo_docu != 'B') {
            $this->formatos_de_impresion_F($codigo, $tipo_docu);
        } else {
            $this->formatos_de_impresion_B($codigo, $tipo_docu);
        }
    }

    /**
     * Fondo
     *  0 : Imprimir
     *  1 : PDF
     * @param int $fondo
     * @param $codigo
     * @param string $tipo_docu
     */
    public function comprobante_ver_pdf_conmenbrete_formato1($codigo, $fondo = 1)
    {

        $datos_notacredito = $this->notacredito_model->obtener_comprobante($codigo);
        $tp = $datos_notacredito[0]->CRED_TipoOperacion;
        $serie = $datos_notacredito[0]->CRED_Serie;
        $numero = $datos_notacredito[0]->CRED_Numero;
        $cliente_id = $datos_notacredito[0]->CLIP_Codigo;
        $formapago_id = $datos_notacredito[0]->FORPAP_Codigo;
        $usuario_id = $datos_notacredito[0]->USUA_Codigo;
        $fecha = $datos_notacredito[0]->CRED_Fecha;
        $ref = $datos_notacredito[0]->CRED_NumeroRef;
        $igv = $datos_notacredito[0]->CRED_igv;
        $observacion = $datos_notacredito[0]->CRED_Observacion;
        $descuento = $datos_notacredito[0]->CRED_descuento;
        $subtotal = $datos_notacredito[0]->CRED_subtotal;
        $total = $datos_notacredito[0]->CRED_total;
        $moneda_id = $datos_notacredito[0]->MONED_Codigo;
        $datos_moneda = $this->moneda_model->obtener($moneda_id);
        $moneda_nombre = (count($datos_moneda) > 0 ? $datos_moneda[0]->MONED_Descripcion : 'NUEVOS SOLES');
        $moneda_sim = $datos_moneda[0]->MONED_Simbolo;
        $proveedor_id = $datos_notacredito[0]->PROVP_Codigo;
        $datos_usuarios = $this->usuario_model->obtener2($usuario_id);
        $usuario_nom = $datos_usuarios[0]->PERSC_Nombre . " " . $datos_usuarios[0]->PERSC_ApellidoPaterno;
        $datos_formapago = $this->formapago_model->obtener2($formapago_id);
        $formapago_desc = $datos_formapago[0]->FORPAC_Descripcion;

        if ($tp == 'V') {
            $datos_cliente = $this->cliente_model->obtener_datosCliente($cliente_id);
            $tipo_cliente = $datos_cliente[0]->CLIC_TipoPersona;
            $empresa_id = $datos_cliente[0]->EMPRP_Codigo;
            $persona_id = $datos_cliente[0]->PERSP_Codigo;
            if ($tipo_cliente == 1) {
                $datos_empresa = $this->empresa_model->obtener_datosEmpresa($empresa_id);
                $nombre_cliente = $datos_empresa[0]->EMPRC_RazonSocial;
                $doc = $datos_empresa[0]->EMPRC_Ruc;
                $datos_direccion = $this->empresa_model->obtener_establecimientosEmpresa_principal($empresa_id);
                $direccion = $datos_direccion[0]->EESTAC_Direccion;
            } else {
                $datos_persona = $this->persona_model->obtener_datosPersona($persona_id);
                $nombre_cliente = $datos_persona[0]->PERSC_Nombre . " " . $datos_persona[0]->PERSC_ApellidoPaterno;
                $doc = $datos_persona[0]->PERSC_Ruc;
                $direccion = $datos_persona[0]->PERSC_Direccion;
            }
        } else {
            $datos_proveedor = $this->proveedor_model->obtener($proveedor_id);
            $tipo_cliente = $datos_proveedor->PROVC_TipoPersona;
            /*$nombre_cliente = $datos_proveedor->nombre;
            $doc = $datos_proveedor->ruc;*/
            if ($tipo_cliente == 1) {
                $nombre_cliente = $datos_proveedor->nombre;
                $doc = $datos_proveedor->ruc;
                $direccion = $datos_proveedor->direccion;
                $telefono = $datos_proveedor->telefono;
                $fax = $datos_proveedor->fax;
            } else {
                $nombre_cliente = $datos_proveedor->nombre;
                $doc = $datos_proveedor->ruc;
                $direccion = $datos_proveedor->direccion;
                $telefono = $datos_proveedor->telefono;
                $fax = $datos_proveedor->fax;

            }


        }
        $detalle_notacredito = $this->notacreditodetalle_model->listar($codigo);
        $this->cezpdf = new Cezpdf('a4');
        if ($fondo == 1) {
            if ($tp == 'V')
                $this->cezpdf = new backgroundPDF('a4', 'portrait', 'image', array('img' => 'images/img_db/notacredito.jpg'));
            else
                $this->cezpdf = new backgroundPDF('a4', 'portrait', 'image', array('img' => 'images/img_db/notacredito.jpg'));
        }
        //0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000
        //**************************************************************************

//********************

        if ($tp == 'V') {
            if ($fondo == 0) {
                $posiciongeneralx = 0;
                $posiciongeneraly = 0;
                $i = 575;
                $importe = 0;
                foreach ($detalle_notacredito as $indice => $valor) {
                    $producto_id = $valor->PROD_Codigo;
                    $cantidad = $valor->CREDET_Cantidad;
                    $unidad = $valor->UNDMED_Codigo;
                    $datos_unidad = $this->unidadmedida_model->obtener($unidad);
                    $prod_unidad = $datos_unidad[0]->UNDMED_Descripcion;
                    $pu = $valor->CREDET_Pu_ConIgv;
                    $total1 = $valor->CREDET_Total;
                    $importe = $importe + $total1;
                    $datos_producto = $this->producto_model->obtener_producto($producto_id);
                    $cod_interno = $datos_producto[0]->PROD_CodigoUsuario;
                    $producto_nom = $datos_producto[0]->PROD_Nombre;


                    //$this->cezpdf->addText(5, $i, 9, $cod_interno);
                   /* $this->cezpdf->addTextWrap(30 + $posiciongeneralx, $i + $posiciongeneraly, 40, 9, $cantidad, 'right');
                    //unidad
                    $this->cezpdf->addText(75 + $posiciongeneralx, $i + $posiciongeneraly, 8, 'UNIDAD');

                    $this->cezpdf->addText(125 + $posiciongeneralx, $i + $posiciongeneraly, 9, substr($producto_nom, 0, 45));
                    $this->cezpdf->addText(425 + $posiciongeneralx, $i + $posiciongeneraly, 9, $moneda_sim);
                    $this->cezpdf->addTextWrap(438 + $posiciongeneralx, $i + $posiciongeneraly, 45, 9, number_format($pu, 2), 'right');
                    $this->cezpdf->addText(493 + $posiciongeneralx, $i + $posiciongeneraly, 9, $moneda_sim);
                    $this->cezpdf->addTextWrap(510 + $posiciongeneralx, $i + $posiciongeneraly, 50, 9, number_format($total1, 2), 'right');
                    $i -= 16.8;*/
// NOTA_CREDITO VENTA IMPRIMIR DESCRIPCION
                   // $this->cezpdf->addText(100, $i+20, 9, $cod_interno);
                    $this->cezpdf->addTextWrap(10, $i+30, 40, 9, $cantidad, 'right');
                    //unidad
                    //$this->cezpdf->addText(30, $i+20, 8, utf8_decode_seguro($unidad));

                    $this->cezpdf->addTextWrap(120, $i+30,200, 9, substr($producto_nom, 0, 45));
                    $this->cezpdf->addText(400, $i+30, 9, $moneda_sim);
                    $this->cezpdf->addTextWrap(415, $i+30, 45, 9, number_format($pu, 2), 'right');
                    $this->cezpdf->addText(495, $i+30, 9, $moneda_sim);
                    $this->cezpdf->addTextWrap(490, $i+30, 50, 9, number_format($total1, 2), 'right');
                    $i -= 16.8;

                }

                /*if ($fondo == 1) {
                    $this->cezpdf->addText(410, 634, 16, $serie);
                    $this->cezpdf->addText(460, 634, 16, $numero);
                }*/

                $dia = date('d', strtotime($fecha));
                $mes = date('m', strtotime($fecha));
                $anio = date('y', strtotime($fecha));


                switch ($mes) {
                    case 1:
                        $mes = 'ENERO';
                        break;
                    case 2:
                        $mes = 'FEBRERO';
                        break;
                    case 3:
                        $mes = 'MARZO';
                        break;
                    case 4:
                        $mes = 'ABRIL';
                        break;
                    case 5:
                        $mes = 'MAYO';
                        break;
                    case 6:
                        $mes = 'JUNIO';
                        break;
                    case 7:
                        $mes = 'JULIO';
                        break;
                    case 8:
                        $mes = 'AGOSTO';
                        break;
                    case 9:
                        $mes = 'SEPTIEMBRE';
                        break;
                    case 10:
                        $mes = 'OCTUBRE';
                        break;
                    case 11:
                        $mes = 'NOVIEMBRE';
                        break;
                    case 12:
                        $mes = 'DICIEMBRE';
                        break;

                    default:
                        break;
                }
//NOTA_CREDITO VENTA IMPRIMIR
                    $this->cezpdf->addText(420, 710, 16, $serie.'-');
                    $this->cezpdf->addText(480, 710, 16, $numero);

                //$valornombreproducto=strlen($observacion);
                $nombacortado = substr($observacion, 0, 25);
                $posicion1 = strrpos($nombacortado, ' ');
                $linea1 = substr($observacion, 0, $posicion1);
                $this->cezpdf->addText(133 + $posiciongeneralx, 450 + $posiciongeneraly, 8, strtoupper(utf8_decode_seguro($linea1)));

                $nombacortado1 = substr($observacion, $posicion1, 25);
                $posicion2 = strrpos($nombacortado1, ' ');
                $linea2 = substr($observacion, $posicion1, $posicion2);
                $this->cezpdf->addText(133 + $posiciongeneralx, 437 + $posiciongeneraly, 8, strtoupper(utf8_decode_seguro($linea2)));

                $nombacortado2 = substr($observacion, $posicion2, 25);

                $this->cezpdf->addText(133 + $posiciongeneralx, 425 + $posiciongeneraly, 8, strtoupper(utf8_decode_seguro($nombacortado2)));


                //$this->cezpdf->addText(95 + $posiciongeneralx, 683 + $posiciongeneraly, 9, $nombre_cliente);

                $this->cezpdf->addText(80 + $posiciongeneralx, 713 + $posiciongeneraly, 7, $nombre_cliente);
                $this->cezpdf->addText(125 + $posiciongeneralx, 670 + $posiciongeneraly, 7, $dia.' - ');
                $this->cezpdf->addText(145 + $posiciongeneralx, 670 + $posiciongeneraly,7, $mes.' - ');
                $this->cezpdf->addText(190 + $posiciongeneralx, 670 + $posiciongeneraly, 7, $anio);
                $this->cezpdf->addText(70 + $posiciongeneralx,692 + $posiciongeneraly, 8, $doc);
                /*$this->cezpdf->addText(95 + $posiciongeneralx, 683 + $posiciongeneraly, 9, $nombre_cliente);
                $this->cezpdf->addText(75 + $posiciongeneralx, 700 + $posiciongeneraly, 9, $dia);
                $this->cezpdf->addText(100 + $posiciongeneralx, 700 + $posiciongeneraly, 9, $mes);
                $this->cezpdf->addText(155 + $posiciongeneralx, 700 + $posiciongeneraly, 9, '20' . $anio);*/
               // $this->cezpdf->addText(450 + $posiciongeneralx, 639 + $posiciongeneraly, 9, $dia . ' ' . $mes . ' 20' . $anio);
               // $this->cezpdf->addText(85 + $posiciongeneralx, 668 + $posiciongeneraly, 9, $doc);

              //  $this->cezpdf->addText(434 + $posiciongeneralx, 461 + $posiciongeneraly, 9, '18');
                 $this->cezpdf->addText(30 + $posiciongeneralx, 657+ $posiciongeneraly, 8, substr($direccion, 0, 58));
                $this->cezpdf->addText(450 + $posiciongeneralx, 657 + $posiciongeneraly, 11, $ref);
               /* $this->cezpdf->addText(310 + $posiciongeneralx, 450 + $posiciongeneraly, 9, $moneda_sim);
                $this->cezpdf->addTextWrap(328 + $posiciongeneralx, 450 + $posiciongeneraly, 55, 9, $subtotal, 'right');
                $this->cezpdf->addText(400 + $posiciongeneralx, 450 + $posiciongeneraly, 9, $moneda_sim);
                $this->cezpdf->addTextWrap(418 + $posiciongeneralx, 450 + $posiciongeneraly, 55, 9, $igv, 'right');
                $this->cezpdf->addText(490 + $posiciongeneralx, 450 + $posiciongeneraly, 9, $moneda_sim);
                $this->cezpdf->addTextWrap(508 + $posiciongeneralx, 450 + $posiciongeneraly, 55, 9, number_format($importe, 2), 'right');
*/

//imprimir venta notacretido precio

                $this->cezpdf->addText(500, 443, 9, $moneda_sim);
                $this->cezpdf->addTextWrap(490, 443, 55, 9, $subtotal, 'right');
                $this->cezpdf->addText(500, 460, 9, $moneda_sim);
                $this->cezpdf->addTextWrap(490, 460, 55, 9, $igv, 'right');
                $this->cezpdf->addText(500, 425, 9, $moneda_sim);
                $this->cezpdf->addTextWrap(490, 425, 55, 9, number_format($importe, 2), 'right');
                //$this->cezpdf->addText(56,490, 9, strtoupper(num2letras(round($importe, 2))) . ' ' . $moneda_nombre . ' ');
                //$this->cezpdf->addText(146,482, 9, "S. E. u O.   ");
//---------------------------------------------------------------------------------------------------------------		


            } elseif ($fondo == 1) {

                $i = 600;
                $y = 30;
                $importe = 0;
                foreach ($detalle_notacredito as $indice => $valor) {
                    $producto_id = $valor->PROD_Codigo;
                    $cantidad = $valor->CREDET_Cantidad;
                  //  $unidad = $valor->UNDMED_Descripcion;

                    $pu = $valor->CREDET_Pu_ConIgv;
                    $total1 = $valor->CREDET_Total;
                    $importe = $importe + $total1;
                    $datos_producto = $this->producto_model->obtener_producto($producto_id);
                    $cod_interno = $datos_producto[0]->PROD_CodigoUsuario;
                    $producto_nom = $datos_producto[0]->PROD_Nombre;
                    
                    $dato_productoUnidad = $this->producto_model->obtener_unidad($producto_id);
                    $unidad = $dato_productoUnidad[0]->UNDMED_Descripcion;
                    
                    $this->cezpdf->addTextWrap($y+25, $i+30, 40, 9, $cantidad, 'right');
                    $this->cezpdf->addTextWrap($y+80, $i+30,200, 7, substr($unidad, 0, 45));
//                     $this->cezpdf->addText(30, $i+20, 8, utf8_decode_seguro());
                    $this->cezpdf->addTextWrap($y+180, $i+30,200, 9, substr($producto_nom, 0, 45));
                    $this->cezpdf->addTextWrap($y+110, $i+30,200, 8, substr($cod_interno, 0, 45));
                    $this->cezpdf->addText($y+420, $i+30, 9, $moneda_sim);
                    $this->cezpdf->addTextWrap($y+415, $i+30, 45, 9, number_format($pu, 2), 'right');
                    $this->cezpdf->addText($y+500, $i+30, 9, $moneda_sim);
                    $this->cezpdf->addTextWrap($y+490, $i+30, 50, 9, number_format($total1, 2), 'right');
                    $i -= 16.8;
                }
//---------------------------------------------------------------------------------------------------------------
                if ($fondo == 1) {

                    $this->cezpdf->addText(420, 734, 22, $serie.' - ');
                    $this->cezpdf->addText(485, 734, 22, $numero);
                }

                $dia = date('d', strtotime($fecha));
                $mes = date('m', strtotime($fecha));
                $anio = date('y', strtotime($fecha));


                switch ($mes) {
                    case 1:
                        $mes = 'ENERO';
                        break;
                    case 2:
                        $mes = 'FEBRERO';
                        break;
                    case 3:
                        $mes = 'MARZO';
                        break;
                    case 4:
                        $mes = 'ABRIL';
                        break;
                    case 5:
                        $mes = 'MAYO';
                        break;
                    case 6:
                        $mes = 'JUNIO';
                        break;
                    case 7:
                        $mes = 'JULIO';
                        break;
                    case 8:
                        $mes = 'AGOSTO';
                        break;
                    case 9:
                        $mes = 'SEPTIEMBRE';
                        break;
                    case 10:
                        $mes = 'OCTUBRE';
                        break;
                    case 11:
                        $mes = 'NOVIEMBRE';
                        break;
                    case 12:
                        $mes = 'DICIEMBRE';
                        break;

                    default:
                        break;
                }

//VENTA NOTA_CREDITO PDF INICIA
                $this->cezpdf->addText(110 + $posiciongeneralx, 705 + $posiciongeneraly, 7, $nombre_cliente);
                $this->cezpdf->addText(120 + $posiciongeneralx, 693+ $posiciongeneraly, 7, substr($direccion, 0, 58));
                $this->cezpdf->addText(250 + $posiciongeneralx, 680 + $posiciongeneraly, 7, $dia.' - ');
                $this->cezpdf->addText(270 + $posiciongeneralx, 680 + $posiciongeneraly,7, $mes.' - ');
                $this->cezpdf->addText(300 + $posiciongeneralx, 680 + $posiciongeneraly, 7, $anio);
                $this->cezpdf->addText(100 + $posiciongeneralx,680 + $posiciongeneraly, 10, $doc);

                //$this->cezpdf->addText(480, 554, 9, $doc);
                $this->cezpdf->addText(450, 657, 11, $ref);

                $this->cezpdf->addText(300, 140, 9, $moneda_sim);
                $this->cezpdf->addTextWrap(290, 140, 55, 9, $subtotal, 'right');
                $this->cezpdf->addText(400, 140, 9, $moneda_sim);
                $this->cezpdf->addTextWrap(390, 140, 55, 9, $igv, 'right');
                $this->cezpdf->addText(500, 140, 9, $moneda_sim);
                $this->cezpdf->addTextWrap(490, 140, 55, 9, number_format($importe, 2), 'right');
                //------------------------------------------------------------------------------------------------------------------------
            }
            /**ACA TERMINA LA VENTA**/
        } else {
        	if ($fondo == 0) {
        		$posiciongeneralx = 0;
        		$posiciongeneraly = 0;
        		$i = 575;
        		$importe = 0;
        		foreach ($detalle_notacredito as $indice => $valor) {
        			$producto_id = $valor->PROD_Codigo;
        			$cantidad = $valor->CREDET_Cantidad;
        			$unidad = $valor->UNDMED_Codigo;
        			$datos_unidad = $this->unidadmedida_model->obtener($unidad);
        			$prod_unidad = $datos_unidad[0]->UNDMED_Descripcion;
        			$pu = $valor->CREDET_Pu_ConIgv;
        			$total1 = $valor->CREDET_Total;
        			$importe = $importe + $total1;
        			$datos_producto = $this->producto_model->obtener_producto($producto_id);
        			$cod_interno = $datos_producto[0]->PROD_CodigoUsuario;
        			$producto_nom = $datos_producto[0]->PROD_Nombre;
        	
        	
        			//$this->cezpdf->addText(5, $i, 9, $cod_interno);
        			/* $this->cezpdf->addTextWrap(30 + $posiciongeneralx, $i + $posiciongeneraly, 40, 9, $cantidad, 'right');
        			 //unidad
        			 $this->cezpdf->addText(75 + $posiciongeneralx, $i + $posiciongeneraly, 8, 'UNIDAD');
        	
        			 $this->cezpdf->addText(125 + $posiciongeneralx, $i + $posiciongeneraly, 9, substr($producto_nom, 0, 45));
        			 $this->cezpdf->addText(425 + $posiciongeneralx, $i + $posiciongeneraly, 9, $moneda_sim);
        			 $this->cezpdf->addTextWrap(438 + $posiciongeneralx, $i + $posiciongeneraly, 45, 9, number_format($pu, 2), 'right');
        			 $this->cezpdf->addText(493 + $posiciongeneralx, $i + $posiciongeneraly, 9, $moneda_sim);
        			 $this->cezpdf->addTextWrap(510 + $posiciongeneralx, $i + $posiciongeneraly, 50, 9, number_format($total1, 2), 'right');
        			 $i -= 16.8;*/
        			// NOTA_CREDITO VENTA IMPRIMIR DESCRIPCION
        			// $this->cezpdf->addText(100, $i+20, 9, $cod_interno);
        			$this->cezpdf->addTextWrap(10, $i+30, 40, 9, $cantidad, 'right');
        			//unidad
        			//$this->cezpdf->addText(30, $i+20, 8, utf8_decode_seguro($unidad));
        	
        			$this->cezpdf->addTextWrap(120, $i+30,200, 9, substr($producto_nom, 0, 45));
        			$this->cezpdf->addText(400, $i+30, 9, $moneda_sim);
        			$this->cezpdf->addTextWrap(415, $i+30, 45, 9, number_format($pu, 2), 'right');
        			$this->cezpdf->addText(495, $i+30, 9, $moneda_sim);
        			$this->cezpdf->addTextWrap(490, $i+30, 50, 9, number_format($total1, 2), 'right');
        			$i -= 16.8;
        	
        		}
        	
        		/*if ($fondo == 1) {
        		 $this->cezpdf->addText(410, 634, 16, $serie);
        		 $this->cezpdf->addText(460, 634, 16, $numero);
        		 }*/
        	
        		$dia = date('d', strtotime($fecha));
        		$mes = date('m', strtotime($fecha));
        		$anio = date('y', strtotime($fecha));
        	
        	
        		switch ($mes) {
        			case 1:
        				$mes = 'ENERO';
        				break;
        			case 2:
        				$mes = 'FEBRERO';
        				break;
        			case 3:
        				$mes = 'MARZO';
        				break;
        			case 4:
        				$mes = 'ABRIL';
        				break;
        			case 5:
        				$mes = 'MAYO';
        				break;
        			case 6:
        				$mes = 'JUNIO';
        				break;
        			case 7:
        				$mes = 'JULIO';
        				break;
        			case 8:
        				$mes = 'AGOSTO';
        				break;
        			case 9:
        				$mes = 'SEPTIEMBRE';
        				break;
        			case 10:
        				$mes = 'OCTUBRE';
        				break;
        			case 11:
        				$mes = 'NOVIEMBRE';
        				break;
        			case 12:
        				$mes = 'DICIEMBRE';
        				break;
        	
        			default:
        				break;
        		}
        		//NOTA_CREDITO VENTA IMPRIMIR
        		$this->cezpdf->addText(420, 710, 16, $serie.'-');
        		$this->cezpdf->addText(480, 710, 16, $numero);
        	
        		//$valornombreproducto=strlen($observacion);
        		$nombacortado = substr($observacion, 0, 25);
        		$posicion1 = strrpos($nombacortado, ' ');
        		$linea1 = substr($observacion, 0, $posicion1);
        		$this->cezpdf->addText(133 + $posiciongeneralx, 450 + $posiciongeneraly, 8, strtoupper(utf8_decode_seguro($linea1)));
        	
        		$nombacortado1 = substr($observacion, $posicion1, 25);
        		$posicion2 = strrpos($nombacortado1, ' ');
        		$linea2 = substr($observacion, $posicion1, $posicion2);
        		$this->cezpdf->addText(133 + $posiciongeneralx, 437 + $posiciongeneraly, 8, strtoupper(utf8_decode_seguro($linea2)));
        	
        		$nombacortado2 = substr($observacion, $posicion2, 25);
        	
        		$this->cezpdf->addText(133 + $posiciongeneralx, 425 + $posiciongeneraly, 8, strtoupper(utf8_decode_seguro($nombacortado2)));
        	
        	
        		//$this->cezpdf->addText(95 + $posiciongeneralx, 683 + $posiciongeneraly, 9, $nombre_cliente);
        	
        		$this->cezpdf->addText(80 + $posiciongeneralx, 713 + $posiciongeneraly, 7, $nombre_cliente);
        		$this->cezpdf->addText(125 + $posiciongeneralx, 670 + $posiciongeneraly, 7, $dia.' - ');
        		$this->cezpdf->addText(145 + $posiciongeneralx, 670 + $posiciongeneraly,7, $mes.' - ');
        		$this->cezpdf->addText(190 + $posiciongeneralx, 670 + $posiciongeneraly, 7, $anio);
        		$this->cezpdf->addText(70 + $posiciongeneralx,692 + $posiciongeneraly, 8, $doc);
        		/*$this->cezpdf->addText(95 + $posiciongeneralx, 683 + $posiciongeneraly, 9, $nombre_cliente);
        		 $this->cezpdf->addText(75 + $posiciongeneralx, 700 + $posiciongeneraly, 9, $dia);
        		 $this->cezpdf->addText(100 + $posiciongeneralx, 700 + $posiciongeneraly, 9, $mes);
        		 $this->cezpdf->addText(155 + $posiciongeneralx, 700 + $posiciongeneraly, 9, '20' . $anio);*/
        		// $this->cezpdf->addText(450 + $posiciongeneralx, 639 + $posiciongeneraly, 9, $dia . ' ' . $mes . ' 20' . $anio);
        		// $this->cezpdf->addText(85 + $posiciongeneralx, 668 + $posiciongeneraly, 9, $doc);
        	
        		//  $this->cezpdf->addText(434 + $posiciongeneralx, 461 + $posiciongeneraly, 9, '18');
        		$this->cezpdf->addText(30 + $posiciongeneralx, 657+ $posiciongeneraly, 8, substr($direccion, 0, 58));
        		$this->cezpdf->addText(450 + $posiciongeneralx, 657 + $posiciongeneraly, 11, $ref);
        		/* $this->cezpdf->addText(310 + $posiciongeneralx, 450 + $posiciongeneraly, 9, $moneda_sim);
        		 $this->cezpdf->addTextWrap(328 + $posiciongeneralx, 450 + $posiciongeneraly, 55, 9, $subtotal, 'right');
        		 $this->cezpdf->addText(400 + $posiciongeneralx, 450 + $posiciongeneraly, 9, $moneda_sim);
        		 $this->cezpdf->addTextWrap(418 + $posiciongeneralx, 450 + $posiciongeneraly, 55, 9, $igv, 'right');
        		 $this->cezpdf->addText(490 + $posiciongeneralx, 450 + $posiciongeneraly, 9, $moneda_sim);
        		 $this->cezpdf->addTextWrap(508 + $posiciongeneralx, 450 + $posiciongeneraly, 55, 9, number_format($importe, 2), 'right');
        		 */
        	
        		//imprimir venta notacretido precio
        	
        		$this->cezpdf->addText(500, 443, 9, $moneda_sim);
        		$this->cezpdf->addTextWrap(490, 443, 55, 9, $subtotal, 'right');
        		$this->cezpdf->addText(500, 460, 9, $moneda_sim);
        		$this->cezpdf->addTextWrap(490, 460, 55, 9, $igv, 'right');
        		$this->cezpdf->addText(500, 425, 9, $moneda_sim);
        		$this->cezpdf->addTextWrap(490, 425, 55, 9, number_format($importe, 2), 'right');
        		//$this->cezpdf->addText(56,490, 9, strtoupper(num2letras(round($importe, 2))) . ' ' . $moneda_nombre . ' ');
        		//$this->cezpdf->addText(146,482, 9, "S. E. u O.   ");
        		//---------------------------------------------------------------------------------------------------------------
        	
        	
        	} elseif ($fondo == 1) {
        	
        		$i = 600;
        		$y = 30;
        		$importe = 0;
        		foreach ($detalle_notacredito as $indice => $valor) {
        			$producto_id = $valor->PROD_Codigo;
        			$cantidad = $valor->CREDET_Cantidad;
        			//  $unidad = $valor->UNDMED_Descripcion;
        	
        			$pu = $valor->CREDET_Pu_ConIgv;
        			$total1 = $valor->CREDET_Total;
        			$importe = $importe + $total1;
        			$datos_producto = $this->producto_model->obtener_producto($producto_id);
        			$cod_interno = $datos_producto[0]->PROD_CodigoUsuario;
        			$producto_nom = $datos_producto[0]->PROD_Nombre;
        	
        			$dato_productoUnidad = $this->producto_model->obtener_unidad($producto_id);
        			$unidad = $dato_productoUnidad[0]->UNDMED_Descripcion;
        	
        			$this->cezpdf->addTextWrap($y+25, $i+30, 40, 9, $cantidad, 'right');
        			$this->cezpdf->addTextWrap($y+80, $i+30,200, 7, substr($unidad, 0, 45));
        			//                     $this->cezpdf->addText(30, $i+20, 8, utf8_decode_seguro());
        			$this->cezpdf->addTextWrap($y+180, $i+30,200, 9, substr($producto_nom, 0, 45));
        			$this->cezpdf->addTextWrap($y+110, $i+30,200, 8, substr($cod_interno, 0, 45));
        			$this->cezpdf->addText($y+415, $i+30, 9, $moneda_sim);
        			$this->cezpdf->addTextWrap($y+425, $i+30, 45, 9, number_format($pu, 2), 'right');
        			$this->cezpdf->addText($y+487, $i+30, 9, $moneda_sim);
        			$this->cezpdf->addTextWrap($y+495, $i+30, 50, 9, number_format($total1, 2), 'right');
        			$i -= 16.8;
        		}
        		//---------------------------------------------------------------------------------------------------------------
        		if ($fondo == 1) {
        	
        			$this->cezpdf->addText(420, 734, 22, $serie.' - ');
        			$this->cezpdf->addText(485, 734, 22, $numero);
        		}
        	
        		$dia = date('d', strtotime($fecha));
        		$mes = date('m', strtotime($fecha));
        		$anio = date('y', strtotime($fecha));
        	
        	
        		switch ($mes) {
        			case 1:
        				$mes = 'ENERO';
        				break;
        			case 2:
        				$mes = 'FEBRERO';
        				break;
        			case 3:
        				$mes = 'MARZO';
        				break;
        			case 4:
        				$mes = 'ABRIL';
        				break;
        			case 5:
        				$mes = 'MAYO';
        				break;
        			case 6:
        				$mes = 'JUNIO';
        				break;
        			case 7:
        				$mes = 'JULIO';
        				break;
        			case 8:
        				$mes = 'AGOSTO';
        				break;
        			case 9:
        				$mes = 'SEPTIEMBRE';
        				break;
        			case 10:
        				$mes = 'OCTUBRE';
        				break;
        			case 11:
        				$mes = 'NOVIEMBRE';
        				break;
        			case 12:
        				$mes = 'DICIEMBRE';
        				break;
        	
        			default:
        				break;
        		}
        	
        		//VENTA NOTA_CREDITO PDF INICIA
        		$this->cezpdf->addText(110 + $posiciongeneralx, 705 + $posiciongeneraly, 7, $nombre_cliente);
        		$this->cezpdf->addText(120 + $posiciongeneralx, 693+ $posiciongeneraly, 7, substr($direccion, 0, 58));
        		$this->cezpdf->addText(250 + $posiciongeneralx, 680 + $posiciongeneraly, 7, $dia.' - ');
        		$this->cezpdf->addText(270 + $posiciongeneralx, 680 + $posiciongeneraly,7, $mes.' - ');
        		$this->cezpdf->addText(300 + $posiciongeneralx, 680 + $posiciongeneraly, 7, $anio);
        		$this->cezpdf->addText(100 + $posiciongeneralx,680 + $posiciongeneraly, 10, $doc);
        	
        		//$this->cezpdf->addText(480, 554, 9, $doc);
        		$this->cezpdf->addText(450, 657, 11, $ref);
        	
        		$this->cezpdf->addText(290, 140, 9, $moneda_sim);
        		$this->cezpdf->addTextWrap(290, 140, 55, 9, $subtotal, 'right');
        		$this->cezpdf->addText(390, 140, 9, $moneda_sim);
        		$this->cezpdf->addTextWrap(390, 140, 55, 9, $igv, 'right');
        		$this->cezpdf->addText(485, 140, 9, $moneda_sim);
        		$this->cezpdf->addTextWrap(490, 140, 55, 9, number_format($importe, 2), 'right');
        		//------------------------------------------------------------------------------------------------------------------------
        	}

        }


        /*
        $this->cezpdf->addText(50, 696, 9, $nombre_cliente);
        $this->cezpdf->addText(390, 690, 10, $dia);
        $this->cezpdf->addText(430, 690, 10, $mes);
        $this->cezpdf->addText(544, 690, 10, $anio);
        $this->cezpdf->addText(60, 666, 9, $doc);
        $this->cezpdf->addText(60, 681, 9, substr($direccion, 0, 58));
        $this->cezpdf->addText(285, 650, 11, $ref);
        $this->cezpdf->addText(510, 468, 9, $moneda_sim . ' ' . $subtotal);
        $this->cezpdf->addText(510, 451, 9, $moneda_sim . ' ' . $igv);
        $this->cezpdf->addText(510, 434, 9, $moneda_sim . ' ' . number_format($importe, 2));
        */

        $cabecera = array('Content-Type' => 'application/pdf', 'Content-Disposition' => 'nama_file.pdf', 'Expires' => '0', 'Pragma' => 'cache', 'Cache-Control' => 'private');
        $this->cezpdf->ezStream($cabecera);

//**************************************************************************
    }

    /* Auxiliares */

    public function obtener_tipo_documento($tipo)
    {
        $tiponom = 'factura';
        switch ($tipo) {
            case 'F':
                $tiponom = 'Nota Credito';
                break;
            case 'B':
                $tiponom = 'boleta';
                break;
            case 'N':
                $tiponom = 'comprobante';
                break;
        }
        return $tiponom;
    }

    public function obtener_serie_numero($tipo_docu)
    {
        $data['numero'] = '';
        $data['serie'] = '';
        switch ($tipo_docu) {
            case 'F':
                $codtipodocu = '8';
                break;
            case 'B':
                $codtipodocu = '9';
                break;
            case 'N':
                $codtipodocu = '14';
                break;
            default:
                $codtipodocu = '0';
                break;
        }
        $datos_configuracion = $this->configuracion_model->obtener_numero_documento($this->somevar['compania'], $codtipodocu);

        if (count($datos_configuracion) > 0) {
            $data['serie'] = $datos_configuracion[0]->CONFIC_Serie;
            $data['numero'] = $datos_configuracion[0]->CONFIC_Numero + 1;
        }
        return $data;
    }

    public function reportes()
    {
        $anio = $this->comprobante_model->anios_para_reportes('V');
        $combo = '<select id="anioVenta" name="anioVenta">';
        $combo .= '<option value="0">Seleccione...</option>';
        foreach ($anio as $key => $value) {
            $combo .= '<option value="' . $value->anio . '">' . $value->anio . '</option>';
        }
        $combo .= '</select>';

        $combo2 = '<select id="anioVenta2" name="anioVenta2">';
        $combo2 .= '<option value="0">Seleccione...</option>';
        foreach ($anio as $key => $value) {
            $combo2 .= '<option value="' . $value->anio . '">' . $value->anio . '</option>';
        }
        $combo2 .= '</select>';

        $combo3 = '<select id="anioVenta3" name="anioVenta3">';
        $combo3 .= '<option value="0">Seleccione...</option>';
        foreach ($anio as $key => $value) {
            $combo3 .= '<option value="' . $value->anio . '">' . $value->anio . '</option>';
        }
        $combo3 .= '</select>';

        $combo4 = '<select id="anioVenta4" name="anioVenta4">';
        $combo4 .= '<option value="0">Seleccione...</option>';
        foreach ($anio as $key => $value) {
            $combo4 .= '<option value="' . $value->anio . '">' . $value->anio . '</option>';
        }
        $combo4 .= '</select>';

        $data['fechai'] = form_input(array("name" => "fechai", "id" => "fechai", "class" => "cajaPequena", "readonly" => "readonly", "maxlength" => "10", "value" => ""));
        $data['fechaf'] = form_input(array("name" => "fechaf", "id" => "fechaf", "class" => "cajaPequena", "readonly" => "readonly", "maxlength" => "10", "value" => ""));
        $atributos = array('width' => 600, 'height' => 400, 'scrollbars' => 'yes', 'status' => 'yes', 'resizable' => 'yes', 'screenx' => '0', 'screeny' => '0');
        $contenido = "<img height='16' width='16' src='" . base_url() . "images/ver.png' title='Buscar' border='0'>";
        $data['verproveedor'] = anchor_popup('compras/proveedor/ventana_busqueda_proveedor', $contenido, $atributos);
        $data['verproducto'] = anchor_popup('almacen/producto/ventana_busqueda_producto', $contenido, $atributos);
        $this->load->library('layout', 'layout');
        $data['titulo'] = "REPORTES DE VENTAS";
        $data['combo'] = $combo;
        $data['combo2'] = $combo2;
        $data['combo3'] = $combo3;
        $data['combo4'] = $combo4;
        $this->layout->view('ventas/comprobante_reporte', $data);
    }

    public function estadisticas()
    {
        /* Imagen 1 */
        $listado = $this->comprobante_model->reporte_ocompra_5_clie_mas_importantes();

        if (count($listado) == 0) { // Esto significa que no hay ordenes de compra por tando no muestros ningun reporte
            echo '<h3>Ha ocurrido un problema</h3>
                      <span style="color:#ff0000">No se ha encontrado Ã“rdenes de Venta</span>';
            exit;
        }
        $temp1 = array(0, 0, 0, 0, 0);
        $temp2 = array('Vacio', 'Vacio', 'Vacio', 'Vacio', 'Vacio');
        foreach ($listado as $item => $reg) {
            $temp1[$item] = $reg->total;
            if (strlen($reg->nombre) > 30)
                $temp2[$item] = substr($reg->nombre, 0, 28) . '... S/.' . $reg->total;
            else
                $temp2[$item] = $reg->nombre . ' S/.' . $reg->total;
        }


        $DataSet = new pData;
        $DataSet->AddPoint($temp1, "Serie1");
        $DataSet->AddPoint($temp2, "Serie2");
        $DataSet->AddAllSeries();
        $DataSet->SetAbsciseLabelSerie("Serie2");

        // Initialise the graph  
        $Test = new pChart(600, 200);
        $Test->drawFilledRoundedRectangle(7, 7, 593, 193, 5, 240, 240, 240);
        $Test->drawRoundedRectangle(5, 5, 595, 195, 5, 230, 230, 230);

        // Draw the pie chart  
        $Test->setFontProperties("system/application/libraries/pchart/Fonts/tahoma.ttf", 8);
        $Test->drawPieGraph($DataSet->GetData(), $DataSet->GetDataDescription(), 150, 90, 110, PIE_PERCENTAGE, TRUE, 50, 20, 5);
        $Test->drawPieLegend(310, 15, $DataSet->GetData(), $DataSet->GetDataDescription(), 250, 250, 250);

        $Test->Render("images/img_dinamic/imagen1.png");
        echo '<h3>1. Los 5 clientes mÃ¡s importantes</h3>
               SegÃºn el monto (S/.) histÃ³rico Ã³rdenes de venta<br />
               <img style="margin-bottom:20px;" src="' . base_url() . 'images/img_dinamic/imagen1.png" alt="Imagen 1" />';

        /* Imagen 2 */
        $listado = $this->comprobante_model->reporte_oventa_monto_x_mes();
        $reg = $listado[0];

        // Dataset definition   
        $DataSet = new pData;
        $DataSet->AddPoint(array($reg->enero, $reg->febrero, $reg->marzo, $reg->abril, $reg->mayo, $reg->junio, $reg->julio, $reg->agosto, $reg->setiembre, $reg->octubre, $reg->noviembre, $reg->diciembre), "Serie1");
        $DataSet->AddPoint(array("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"), "Serie2");
        $DataSet->AddAllSeries();
        $DataSet->SetAbsciseLabelSerie();
        $DataSet->SetAbsciseLabelSerie("Serie2");
        $DataSet->SetYAxisName("Monto (S/.)");
        $DataSet->SetXAxisName("Meses");

        // Initialise the graph  
        $Test = new pChart(600, 240);
        $Test->setFontProperties("system/application/libraries/pchart/Fonts/tahoma.ttf", 8);
        $Test->setGraphArea(70, 30, 580, 200);
        $Test->drawFilledRoundedRectangle(7, 7, 593, 223, 5, 240, 240, 240);
        $Test->drawRoundedRectangle(5, 5, 595, 225, 5, 230, 230, 230);
        $Test->drawGraphArea(255, 255, 255, TRUE);
        $Test->drawScale($DataSet->GetData(), $DataSet->GetDataDescription(), SCALE_NORMAL, 150, 150, 150, TRUE, 0, 2, TRUE);
        $Test->drawGrid(4, TRUE, 230, 230, 230, 50);

        // Draw the 0 line  
        $Test->setFontProperties("Fonts/tahoma.ttf", 6);
        $Test->drawTreshold(0, 143, 55, 72, TRUE, TRUE);

        // Draw the bar graph  
        $Test->drawBarGraph($DataSet->GetData(), $DataSet->GetDataDescription(), TRUE);

        // Finish the graph  
        $Test->setFontProperties("Fonts/tahoma.ttf", 8);
        $Test->setFontProperties("Fonts/tahoma.ttf", 10);
        $Test->Render("images/img_dinamic/imagen2.png");
        echo '<h3>2. Montos (S/.) de Ã³rdenes de venta segÃºn mes</h3>
               Considerando el presente aÃ±o<br />
               <img style="margin-bottom:20px;" src="' . base_url() . 'images/img_dinamic/imagen2.png" alt="Imagen 2" />';


        /* Imagen 3 */
        $listado = $this->comprobante_model->reporte_oventa_cantidad_x_mes();
        $reg = $listado[0];

        $DataSet = new pData;
        $DataSet->AddPoint(array($reg->enero, $reg->febrero, $reg->marzo, $reg->abril, $reg->mayo, $reg->junio, $reg->julio, $reg->agosto, $reg->setiembre, $reg->octubre, $reg->noviembre, $reg->diciembre), "Serie1");
        $DataSet->AddPoint(array("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"), "Serie2");
        $DataSet->AddAllSeries();
        $DataSet->RemoveSerie("Serie2");
        $DataSet->SetAbsciseLabelSerie("Serie2");
        $DataSet->SetYAxisName("Cantidad de O. de Venta");
        $DataSet->SetXAxisName("Meses");


        // Initialise the graph  
        $Test = new pChart(600, 230);
        $Test->drawGraphAreaGradient(132, 153, 172, 50, TARGET_BACKGROUND);
        $Test->setFontProperties("system/application/libraries/pchart/Fonts/tahoma.ttf", 8);
        $Test->setGraphArea(60, 20, 585, 180);
        $Test->drawGraphArea(213, 217, 221, FALSE);
        $Test->drawScale($DataSet->GetData(), $DataSet->GetDataDescription(), SCALE_NORMAL, 213, 217, 221, TRUE, 0, 2);
        $Test->drawGraphAreaGradient(162, 183, 202, 50);
        $Test->drawGrid(4, TRUE, 230, 230, 230, 20);

        // Draw the line chart  
        $Test->drawLineGraph($DataSet->GetData(), $DataSet->GetDataDescription());
        $Test->drawPlotGraph($DataSet->GetData(), $DataSet->GetDataDescription(), 2);

        // Draw the legend  
        $Test->setFontProperties("Fonts/tahoma.ttf", 8);

        // Render the picture  
        $Test->Render("images/img_dinamic/imagen3.png");
        echo '<h3>3. Cantidades de Ã³rdenes de venta segÃºn mes</h3>
               Considerando el presente aÃ±o<br />
               <img style="margin-top:5px; margin-bottom:20px;" src="' . base_url() . 'images/img_dinamic/imagen3.png" alt="Imagen 3" />';

        /* Imagen 4 => COMPRAS */
        //$listado=$this->ocompra_model->reporte_ocompra_monto_x_mes(); 
        $listado = $this->ocompra_model->reporte_comparativo_compras_ventas('V');
        $reg = $listado[0];

        // Dataset definition   
        $DataSet = new pData;
        $DataSet->AddPoint(array($reg->enero, $reg->febrero, $reg->marzo, $reg->abril, $reg->mayo, $reg->junio, $reg->julio, $reg->agosto, $reg->setiembre, $reg->octubre, $reg->noviembre, $reg->diciembre), "Serie1");
        $DataSet->AddPoint(array("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"), "Serie2");
        $DataSet->AddAllSeries();
        $DataSet->SetAbsciseLabelSerie();
        $DataSet->SetAbsciseLabelSerie("Serie2");
        $DataSet->SetYAxisName("Monto (S/.)");
        $DataSet->SetXAxisName("Meses");

        // Initialise the graph  
        $Test = new pChart(600, 240);
        $Test->setFontProperties("system/application/libraries/pchart/Fonts/tahoma.ttf", 8);
        $Test->setGraphArea(70, 30, 580, 200);
        $Test->drawFilledRoundedRectangle(7, 7, 593, 223, 5, 240, 240, 240);
        $Test->drawRoundedRectangle(5, 5, 595, 225, 5, 230, 230, 230);
        $Test->drawGraphArea(255, 255, 255, TRUE);
        $Test->drawScale($DataSet->GetData(), $DataSet->GetDataDescription(), SCALE_NORMAL, 150, 150, 150, TRUE, 0, 2, TRUE);
        $Test->drawGrid(4, TRUE, 230, 230, 230, 50);

        // Draw the 0 line  
        $Test->setFontProperties("Fonts/tahoma.ttf", 6);
        $Test->drawTreshold(0, 143, 55, 72, TRUE, TRUE);

        // Draw the bar graph  
        $Test->drawBarGraph($DataSet->GetData(), $DataSet->GetDataDescription(), TRUE);

        // Finish the graph  
        $Test->setFontProperties("Fonts/tahoma.ttf", 8);
        $Test->setFontProperties("Fonts/tahoma.ttf", 10);
        $Test->Render("images/img_dinamic/imagen4.png");
        echo '<h3>4. Ventas</h3>
               Considerando las ventas en el presente aÃ±o<br />
			   <img style="margin-top:5px; margin-bottom:20px;" src="' . base_url() . 'images/img_dinamic/imagen4.png" alt="Imagen 4" />
			   <br />';
        /* Imagen 5 => VENTAS */
        /* $listado=$this->ocompra_model->reporte_comparativo_compras_ventas('V'); 
          $reg=$listado[0];

          // Dataset definition
          $DataSet = new pData;
          $DataSet->AddPoint(array($reg->enero,$reg->febrero,$reg->marzo,$reg->abril,$reg->mayo, $reg->junio,$reg->julio,$reg->agosto,$reg->setiembre,$reg->octubre,$reg->noviembre,$reg->diciembre),"Serie1");
          $DataSet->AddPoint(array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Set","Oct","Nov","Dic"),"Serie2");
          $DataSet->AddAllSeries();
          $DataSet->SetAbsciseLabelSerie();
          $DataSet->SetAbsciseLabelSerie("Serie2");
          $DataSet->SetYAxisName("Monto (S/.)");
          $DataSet->SetXAxisName("Meses");

          // Initialise the graph
          $Test = new pChart(600,240);
          $Test->setFontProperties("system/application/libraries/pchart/Fonts/tahoma.ttf",8);
          $Test->setGraphArea(70,30,580,200);
          $Test->drawFilledRoundedRectangle(7,7,593,223,5,240,240,240);
          $Test->drawRoundedRectangle(5,5,595,225,5,230,230,230);
          $Test->drawGraphArea(255,255,255,TRUE);
          $Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_NORMAL,150,150,150,TRUE,0,2,TRUE);
          $Test->drawGrid(4,TRUE,230,230,230,50);

          // Draw the 0 line
          $Test->setFontProperties("Fonts/tahoma.ttf",6);
          $Test->drawTreshold(0,143,55,72,TRUE,TRUE);

          // Draw the bar graph
          $Test->drawBarGraph($DataSet->GetData(),$DataSet->GetDataDescription(),TRUE);

          // Finish the graph
          $Test->setFontProperties("Fonts/tahoma.ttf",8);
          $Test->setFontProperties("Fonts/tahoma.ttf",10);
          $Test->Render("images/img_dinamic/imagen5.png");
          echo 'Considerando las ventas en el presente aÃ±o<br />
          <img style="margin-top:5px; margin-bottom:20px;" src="'.base_url().'images/img_dinamic/imagen5.png" alt="Imagen 5" />'; */
    }

    public function ver_reporte_pdf($params)
    {
        $temp = (explode('_', $params));
        $fechai = $temp[0];
        $fechaf = $temp[1];
        $proveedor = $temp[2];
        $producto = $temp[3];
        $aprobado = $temp[4];
        $ingreso = $temp[5];

        $usuario = $this->usuario_model->obtener($this->somevar['user']);
        $persona = $this->persona_model->obtener_datosPersona($usuario->PERSP_Codigo);
        $fechahoy = date('d/m/Y');
        $listado = $this->comprobante_model->buscar_comprobante_venta($fechai, $fechaf, $proveedor, $producto, $aprobado, $ingreso);

        if ($fechai != '') {
            $temp = explode('-', $fechai);
            $fechai = $temp[2] . '/' . $temp[1] . '/' . $temp[0];
        }
        if ($fechaf != '') {
            $temp = explode('-', $fechaf);
            $fechaf = $temp[2] . '/' . $temp[1] . '/' . $temp[0];
        }
        $nomprovee = '';
        if ($proveedor != '') {
            $temp = $this->cliente_model->obtener_datosCliente($proveedor);
            if ($temp[0]->CLIC_TipoPersona == '0') {
                $temp = $this->persona_model->obtener_datosPersona($temp[0]->PERSP_Codigo);
                $nomprovee = $temp[0]->PERSC_Nombre . ' ' . $temp[0]->PERSC_ApellidoPaterno . ' ' . $temp[0]->PERSC_ApellidoMaterno;
            } else {
                $temp = $this->empresa_model->obtener_datosEmpresa($temp[0]->EMPRP_Codigo);
                $nomprovee = $temp[0]->EMPRC_RazonSocial;
            }
        }
        $nomprod = '';
        if ($producto != '') {
            $temp = $this->producto_model->obtener_producto($producto);
            $nomprod = $temp[0]->PROD_Nombre;
        }
        $nomaprob = '';
        if ($aprobado == '0')
            $nomaprob = 'Pendente';
        elseif ($aprobado == '1')
            $nomaprob = 'Aprobado';
        elseif ($aprobado == '2')
            $nomaprob = 'Desaprobado';

        $nomingre = '';
        if ($ingreso == '0')
            $nomingre = 'Pendiente';
        elseif ($ingreso == '1')
            $nomingre = 'Si';
        //$this->load->library('cezpdf');
        //$this->load->helper('pdf_helper');
        //prep_pdf();
        $this->cezpdf = new Cezpdf('a4');

        /* Cabecera */
        $delta = 20;
        $options = array("leading" => 15, "left" => 0);
        $this->cezpdf->ezText('Usuario:  ' . $persona[0]->PERSC_Nombre . ' ' . $persona[0]->PERSC_ApellidoPaterno . ' ' . $persona[0]->PERSC_ApellidoMaterno . '       Fecha: ' . $fechahoy, 7, $options);
        $this->cezpdf->ezText("", '', $options);
        $this->cezpdf->ezText("", '', $options);
        $this->cezpdf->ezText('REPORTE DE ORDENES DE VENTA', 17, $options);
        if (($fechai != '' && $fechaf != '') || $proveedor != '' || $producto != '' || $aprobado != '' || $ingreso != '') {
            $this->cezpdf->ezText('Filtros aplicados', 10, $options);
            if ($fechai != '' && $fechaf != '')
                $this->cezpdf->ezText('       - Fecha inicio: ' . $fechai . '   Fecha fin: ' . $fechaf, '', $options);
            if ($proveedor != '')
                $this->cezpdf->ezText('       - Cliente:  ' . $nomprovee, '', $options);
            if ($producto != '')
                $this->cezpdf->ezText('       - Producto:    ' . $nomprod, '', $options);
            if ($aprobado != '')
                $this->cezpdf->ezText('       - Aprobacion:   ' . $nomaprob, '', $options);
            if ($ingreso != '')
                $this->cezpdf->ezText('       - Ingreso:         ' . $nomingre, '', $options);
        }

        $this->cezpdf->ezText('', '', $options);

        $confi = $this->configuracion_model->obtener_configuracion($this->somevar['compania']);
        $serie = '';
        foreach ($confi as $key => $value) {
            if ($value->DOCUP_Codigo == 15) {
                $serie = $value->CONFIC_Serie;
            }
        }

        /* Listado */

        foreach ($listado as $indice => $valor) {
            $db_data[] = array(
                'col1' => $indice + 1,
                'col2' => $valor->fecha,
                'col3' => $serie,
                'col4' => $valor->OCOMC_Numero,
                'col5' => $valor->cotizacion,
                'col6' => $valor->nombre,
                'col7' => $valor->MONED_Simbolo . ' ' . number_format($valor->OCOMC_total, 2),
                'col8' => $valor->aprobado,
                'col9' => $valor->ingreso
            );
        }

        $col_names = array(
            'col1' => 'Itm',
            'col2' => 'Fecha',
            'col3' => 'SERIE',
            'col4' => 'NRO',
            'col5' => 'COTIZACION',
            'col6' => 'RAZON SOCIAL',
            'col7' => 'TOTAL',
            'col8' => 'C.INGRESO',
            'col9' => 'APROBACION'
        );

        $this->cezpdf->ezTable($db_data, $col_names, '', array(
            'width' => 555,
            'showLines' => 1,
            'shaded' => 0,
            'showHeadings' => 1,
            'xPos' => 'center',
            'fontSize' => 7,
            'cols' => array(
                'col1' => array('width' => 25, 'justification' => 'center'),
                'col2' => array('width' => 50, 'justification' => 'center'),
                'col3' => array('width' => 30, 'justification' => 'center'),
                'col4' => array('width' => 30, 'justification' => 'center'),
                'col5' => array('width' => 55, 'justification' => 'center'),
                'col6' => array('width' => 200),
                'col7' => array('width' => 50, 'justification' => 'center'),
                'col8' => array('width' => 50, 'justification' => 'center'),
                'col9' => array('width' => 60, 'justification' => 'center')
            )
        ));


        $cabecera = array('Content-Type' => 'application/pdf', 'Content-Disposition' => 'nama_file.pdf', 'Expires' => '0', 'Pragma' => 'cache', 'Cache-Control' => 'private');
        $this->cezpdf->ezStream($cabecera);
    }

    public function ver_reporte_pdf_ventas($anio)
    {
        $usuario = $this->usuario_model->obtener($this->somevar['user']);
        $persona = $this->persona_model->obtener_datosPersona($usuario->PERSP_Codigo);
        $fechahoy = date('d/m/Y');
        //$this->load->library('cezpdf');
        //$this->load->helper('pdf_helper');
        //prep_pdf();
        $this->cezpdf = new Cezpdf('a4');

        /* Cabecera */
        $delta = 20;

        $listado = $this->comprobante_model->buscar_comprobante_venta_2($anio);

        $confi = $this->configuracion_model->obtener_configuracion($this->somevar['compania']);
        $serie = '';
        foreach ($confi as $key => $value) {
            if ($value->DOCUP_Codigo == 15) {
                $serie = $value->CONFIC_Serie;
            }
        }

        /* Listado */
        $sum = 0;
        foreach ($listado as $key => $value) {
            $sum += $value->CPC_total;
            $db_data[] = array(
                'col1' => $key + 1,
                'col2' => substr($value->CPC_FechaRegistro, 0, 10),
                'col3' => $serie,
                'col4' => $value->CPC_Numero,
                'col6' => $value->CPC_subtotal,
                'col7' => $value->CPC_igv,
                'col8' => $value->CPC_total
            );
        }

        $col_names = array(
            'col1' => 'Itm',
            'col2' => 'Fecha',
            'col3' => 'SERIE',
            'col4' => 'NRO',
            'col6' => 'VALOR DE VENTA',
            'col7' => 'I.G.V. 18%',
            'col8' => 'TOTAL',
        );

        $db_data[] = array(
            'col1' => "",
            'col2' => "",
            'col3' => "",
            'col4' => "",
            'col5' => "",
            'col6' => "",
            'col7' => "TOTAL",
            'col8' => $sum,
            'col9' => ""
        );

        $this->cezpdf->ezTable($db_data, $col_names, '', array(
            'width' => 555,
            'showLines' => 1,
            'shaded' => 0,
            'showHeadings' => 1,
            'xPos' => 'center',
            'fontSize' => 7,
            'cols' => array(
                'col1' => array('width' => 25, 'justification' => 'center'),
                'col2' => array('width' => 50, 'justification' => 'center'),
                'col3' => array('width' => 50, 'justification' => 'center'),
                'col4' => array('width' => 30, 'justification' => 'center'),
                'col6' => array('width' => 50),
                'col7' => array('width' => 50, 'justification' => 'center'),
                'col8' => array('width' => 50, 'justification' => 'center'),
                'col9' => array('width' => 60, 'justification' => 'center')
            )
        ));

        $cabecera = array('Content-Type' => 'application/pdf', 'Content-Disposition' => 'nama_file.pdf', 'Expires' => '0', 'Pragma' => 'cache', 'Cache-Control' => 'private');
        $this->cezpdf->ezStream($cabecera);
    }

    public function ver_reporte_pdf_commpras($anio)
    {
        $usuario = $this->usuario_model->obtener($this->somevar['user']);
        $persona = $this->persona_model->obtener_datosPersona($usuario->PERSP_Codigo);
        $fechahoy = date('d/m/Y');
        //$this->load->library('cezpdf');
        //$this->load->helper('pdf_helper');
        //prep_pdf();
        $this->cezpdf = new Cezpdf('a4');

        /* Cabecera */
        $delta = 20;

        $listado = $this->comprobante_model->buscar_comprobante_compras($anio);

        $confi = $this->configuracion_model->obtener_configuracion($this->somevar['compania']);
        $serie = '';
        foreach ($confi as $key => $value) {
            if ($value->DOCUP_Codigo == 15) {
                $serie = $value->CONFIC_Serie;
            }
        }

        /* Listado */
        $sum = 0;
        foreach ($listado as $key => $value) {
            $sum += $value->CPC_total;
            $db_data[] = array(
                'col1' => $key + 1,
                'col2' => substr($value->CPC_FechaRegistro, 0, 10),
                'col3' => $serie,
                'col4' => $value->CPC_Numero,
                'col6' => $value->CPC_subtotal,
                'col7' => $value->CPC_igv,
                'col8' => $value->CPC_total
            );
        }

        $col_names = array(
            'col1' => 'Itm',
            'col2' => 'Fecha',
            'col3' => 'SERIE',
            'col4' => 'NRO',
            'col6' => 'VALOR DE VENTA',
            'col7' => 'I.G.V. 18%',
            'col8' => 'TOTAL',
        );

        $db_data[] = array(
            'col1' => "",
            'col2' => "",
            'col3' => "",
            'col4' => "",
            'col5' => "",
            'col6' => "",
            'col7' => "TOTAL",
            'col8' => $sum,
            'col9' => ""
        );

        $this->cezpdf->ezTable($db_data, $col_names, '', array(
            'width' => 555,
            'showLines' => 1,
            'shaded' => 0,
            'showHeadings' => 1,
            'xPos' => 'center',
            'fontSize' => 7,
            'cols' => array(
                'col1' => array('width' => 25, 'justification' => 'center'),
                'col2' => array('width' => 50, 'justification' => 'center'),
                'col3' => array('width' => 50, 'justification' => 'center'),
                'col4' => array('width' => 30, 'justification' => 'center'),
                'col6' => array('width' => 50),
                'col7' => array('width' => 50, 'justification' => 'center'),
                'col8' => array('width' => 50, 'justification' => 'center'),
                'col9' => array('width' => 60, 'justification' => 'center')
            )
        ));

        $cabecera = array('Content-Type' => 'application/pdf', 'Content-Disposition' => 'nama_file.pdf', 'Expires' => '0', 'Pragma' => 'cache', 'Cache-Control' => 'private');
        $this->cezpdf->ezStream($cabecera);
    }

    public function estadisticas_compras_ventas($tipo, $anio)
    {
        $usuario = $this->usuario_model->obtener($this->somevar['user']);
        $persona = $this->persona_model->obtener_datosPersona($usuario->PERSP_Codigo);
        $fechahoy = date('d/m/Y');
        //$this->load->library('cezpdf');
        //$this->load->helper('pdf_helper');
        //prep_pdf();
        $this->cezpdf = new Cezpdf('a4');

        /* Cabecera */
        $delta = 20;
        $r = '';
        if ($tipo == "C") {
            $r = ' COMPRAS';
        } else {
            $r = ' VENTAS';
        }
        $options = array("leading" => 15, "left" => 0);
        $this->cezpdf->ezText('Usuario:  ' . $persona[0]->PERSC_Nombre . ' ' . $persona[0]->PERSC_ApellidoPaterno . ' ' . $persona[0]->PERSC_ApellidoMaterno . '       Fecha: ' . $fechahoy, 7, $options);
        $this->cezpdf->ezText("", '', $options);
        $this->cezpdf->ezText("", '', $options);
        $this->cezpdf->ezText('ESTADISTICAS DE' . $r . ' ANUALES', 17, $options);
        $this->cezpdf->ezText('', '', $options);

        //$listado = $this->comprobante_model->buscar_comprobante_compras();
        $listado = $this->comprobante_model->estadisticas_compras_ventas($tipo, $anio);

        $confi = $this->configuracion_model->obtener_configuracion($this->somevar['compania']);
        $serie = '';
        foreach ($confi as $key => $value) {
            if ($value->DOCUP_Codigo == 15) {
                $serie = $value->CONFIC_Serie;
            }
        }

        /* Listado */
        $datos_generales = '';
        $en = $fe = $ma = $ab = $may = $ju = $jul = $ag = $se = $oc = $no = $di = 0;
        $s_en = $s_fe = $s_ma = $s_ab = $s_may = $s_ju = $s_jul = $s_ag = $s_se = $s_oc = $s_no = $s_di = 0;
        foreach ($listado as $key => $value) {
            if ($value->EMPRC_RazonSocial != "") {
                $datos_generales = $value->EMPRC_RazonSocial;
            } else {
                $datos_generales = $value->PERSC_Nombre;
            }

            if ($value->mes == 1) {
                $en = $value->monto;
                $s_en += $value->monto;
            } else if ($value->mes == 2) {
                $fe = $value->monto;
                $s_fe += $value->monto;
            } else if ($value->mes == 3) {
                $ma = $value->monto;
                $s_ma += $value->monto;
            } else if ($value->mes == 4) {
                $ab = $value->monto;
                $s_ab += $value->monto;
            } else if ($value->mes == 5) {
                $may = $value->monto;
                $s_may += $value->monto;
            } else if ($value->mes == 6) {
                $ju = $value->monto;
                $s_ju += $value->monto;
            } else if ($value->mes == 7) {
                $jul = $value->monto;
                $s_jul += $value->monto;
            } else if ($value->mes == 8) {
                $ag = $value->monto;
                $s_ag += $value->monto;
            } else if ($value->mes == 9) {
                $se = $value->monto;
                $s_se += $value->monto;
            } else if ($value->mes == 10) {
                $oc = $value->monto;
                $s_oc += $value->monto;
            } else if ($value->mes == 11) {
                $no = $value->monto;
                $s_no += $value->monto;
            } else if ($value->mes == 12) {
                $di = $value->monto;
                $s_di += $value->monto;
            }

            /* switch($value->mes){
              case 1 : $en = $value->monto;
              case 2 : $fe = $value->monto;
              case 3 : $ma = $value->monto;
              case 4 : $ab = $value->monto;
              case 5 : $may = $value->monto;
              case 6 : $ju = $value->monto;
              case 7 : $jul = $value->monto;
              case 8 : $ag = $value->monto;
              case 9 : $se = $value->monto;
              case 10 : $oc = $value->monto;
              case 11 : $no = $value->monto;
              case 12 : $di = $value->monto;
              } */

            $db_data[] = array(
                'col1' => $datos_generales,
                'col2' => $en,
                'col3' => $fe,
                'col4' => $ma,
                'col5' => $ab,
                'col6' => $may,
                'col7' => $ju,
                'col8' => $jul,
                'col9' => $ag,
                'col10' => $se,
                'col11' => $oc,
                'col12' => $no,
                'col13' => $di
            );
            $en = $fe = $ma = $ab = $may = $ju = $jul = $ag = $se = $oc = $no = $di = 0;
        }

        $db_data[] = array(
            'col1' => "TOTAL",
            'col2' => $s_en,
            'col3' => $s_fe,
            'col4' => $s_ma,
            'col5' => $s_ab,
            'col6' => $s_may,
            'col7' => $s_ju,
            'col8' => $s_jul,
            'col9' => $s_ag,
            'col10' => $s_se,
            'col11' => $s_oc,
            'col12' => $s_no,
            'col13' => $s_di
        );

        $col_names = array(
            'col1' => 'CLIENTES',
            'col2' => 'ENERO',
            'col3' => 'FEBRERO',
            'col4' => 'MARZO',
            'col5' => 'ABRIL',
            'col6' => 'MAYO',
            'col7' => 'JUNIO',
            'col8' => 'JULIO',
            'col9' => 'AGOSTO',
            'col10' => 'SETIE.',
            'col11' => 'OCTU.',
            'col12' => 'NOVIE.',
            'col13' => 'DICIE.',
        );

        $this->cezpdf->ezTable($db_data, $col_names, '', array(
            'width' => 555,
            'showLines' => 1,
            'shaded' => 0,
            'showHeadings' => 1,
            'xPos' => 'center',
            'fontSize' => 7,
            'cols' => array(
                'col1' => array('width' => 80, 'justification' => 'center'),
                'col2' => array('width' => 40, 'justification' => 'center'),
                'col3' => array('width' => 40, 'justification' => 'center'),
                'col4' => array('width' => 40, 'justification' => 'center'),
                'col5' => array('width' => 40, 'justification' => 'center'),
                'col6' => array('width' => 40, 'justification' => 'center'),
                'col7' => array('width' => 40, 'justification' => 'center'),
                'col8' => array('width' => 40, 'justification' => 'center'),
                'col9' => array('width' => 40, 'justification' => 'center'),
                'col10' => array('width' => 40, 'justification' => 'center'),
                'col11' => array('width' => 40, 'justification' => 'center'),
                'col12' => array('width' => 40, 'justification' => 'center'),
                'col13' => array('width' => 40, 'justification' => 'center')
            )
        ));

        $cabecera = array('Content-Type' => 'application/pdf', 'Content-Disposition' => 'nama_file.pdf', 'Expires' => '0', 'Pragma' => 'cache', 'Cache-Control' => 'private');
        $this->cezpdf->ezStream($cabecera);
    }

    private function meses($anio)
    {
        switch ($anio) {
            case 1 :
                return "ENERO";
            case 2 :
                return "FEBRERO";
            case 3 :
                return "MARZO";
            case 4 :
                return "ABRIL";
            case 5 :
                return "MAYO";
            case 6 :
                return "JUNIO";
            case 7 :
                return "JULIO";
            case 8 :
                return "AGOSTO";
            case 9 :
                return "SETIEMBRE";
            case 10 :
                return "OCTUBRE";
            case 11 :
                return "NOVIEMBRE";
            case 12 :
                return "DICIEMBRE";
        }
    }

    public function estadisticas_compras_ventas_mensual($tipo, $anio, $mes)
    {
        $usuario = $this->usuario_model->obtener($this->somevar['user']);
        $persona = $this->persona_model->obtener_datosPersona($usuario->PERSP_Codigo);
        $fechahoy = date('d/m/Y');
        //$this->load->library('cezpdf');
        //$this->load->helper('pdf_helper');
        //prep_pdf();
        $this->cezpdf = new Cezpdf('a4');

        /* Cabecera */
        $delta = 20;

        //$listado = $this->comprobante_model->buscar_comprobante_compras();
        $listado = $this->comprobante_model->estadisticas_compras_ventas_mensual($tipo, $anio, $mes);
        $r = '';
        if ($tipo == "C") {
            $r = ' COMPRAS';
        } else {
            $r = ' VENTAS';
        }
        $options = array("leading" => 15, "left" => 0);
        $this->cezpdf->ezText('Usuario:  ' . $persona[0]->PERSC_Nombre . ' ' . $persona[0]->PERSC_ApellidoPaterno . ' ' . $persona[0]->PERSC_ApellidoMaterno . '       Fecha: ' . $fechahoy, 7, $options);
        $this->cezpdf->ezText("", '', $options);
        $this->cezpdf->ezText("", '', $options);
        $this->cezpdf->ezText('ESTADISTICAS DE' . $r, 17, $options);
        $this->cezpdf->ezText('', '', $options);

        /* Listado */
        $datos_generales = '';
        $ruc_dni = '';
        foreach ($listado as $key => $value) {
            if ($value->EMPRC_RazonSocial != "") {
                $datos_generales = $value->EMPRC_RazonSocial;
            } else {
                $datos_generales = $value->PERSC_Nombre;
            }
            if ($value->EMPRC_Ruc != "") {
                $ruc_dni = $value->EMPRC_Ruc;
            } else {
                $ruc_dni = $value->PERSC_NumeroDocIdentidad;
            }

            $db_data[] = array(
                'col1' => $this->meses($value->mes),
                'col2' => substr($value->CPC_FechaRegistro, 0, 10),
                'col3' => $datos_generales,
                'col4' => $ruc_dni,
                'col5' => $value->CPC_subtotal,
                'col6' => $value->CPC_igv,
                'col7' => $value->monto
            );
        }
        $col_names = array(
            'col1' => 'MES',
            'col2' => 'FECHA',
            'col3' => 'NOMBRE / RAZON SOCIAL',
            'col4' => 'DNI / RUC',
            'col5' => 'VALOR DE VENTA',
            'col6' => 'IGV',
            'col7' => 'TOTAL',
        );

        $this->cezpdf->ezTable($db_data, $col_names, '', array(
            'width' => 555,
            'showLines' => 1,
            'shaded' => 0,
            'showHeadings' => 1,
            'xPos' => 'center',
            'fontSize' => 7,
            'cols' => array(
                'col1' => array('width' => 70, 'justification' => 'center'),
                'col2' => array('width' => 60, 'justification' => 'center'),
                'col3' => array('width' => 150, 'justification' => 'center'),
                'col4' => array('width' => 100, 'justification' => 'center'),
                'col5' => array('width' => 60, 'justification' => 'center'),
                'col6' => array('width' => 60, 'justification' => 'center'),
                'col7' => array('width' => 60, 'justification' => 'center')
            )
        ));

        $cabecera = array('Content-Type' => 'application/pdf', 'Content-Disposition' => 'nama_file.pdf', 'Expires' => '0', 'Pragma' => 'cache', 'Cache-Control' => 'private');
        $this->cezpdf->ezStream($cabecera);
    }

    public function formatos_de_impresion_F($codigo, $tipo_docu)
    {


        $datos_comprobante = $this->comprobante_model->obtener_comprobante($codigo);
        $presupuesto = $datos_comprobante[0]->PRESUP_Codigo;
        $serie = $datos_comprobante[0]->CPC_Serie;
        $numero = $datos_comprobante[0]->CPC_Numero;
        $cliente = $datos_comprobante[0]->CLIP_Codigo;
        $subtotal = $datos_comprobante[0]->CPC_subtotal;
        $descuento = $datos_comprobante[0]->CPC_descuento;
        $igv = $datos_comprobante[0]->CPC_igv;
        $igv100 = $datos_comprobante[0]->CPC_igv100;
        $descuento100 = $datos_comprobante[0]->CPC_descuento100;
        $total = $datos_comprobante[0]->CPC_total;
        $observacion = $datos_comprobante[0]->CPC_Observacion;
        $usuario = $datos_comprobante[0]->USUA_Codigo;
        $fecha = mysql_to_human($datos_comprobante[0]->CPC_Fecha);
        $fecha_formato = $datos_comprobante[0]->CPC_Fecha;
        $dia = substr($fecha, 0, 2);
        $mes = substr($fecha, 3, 2);
        $anio = substr($fecha, 6, 4);
        $mess = $this->meses($mes);
        $fecha_pie = $dia . '/ ' . $mes . '/ ' . $anio;
        $vendedor = $datos_comprobante[0]->USUA_Codigo;
        $datos_cliente = $this->cliente_model->obtener_datosCliente($cliente);
        $empresa = $datos_cliente[0]->EMPRP_Codigo;
        $persona = $datos_cliente[0]->PERSP_Codigo;
        $tipo = $datos_cliente[0]->CLIC_TipoPersona;
        $tipo_docu = $datos_comprobante[0]->CPC_TipoDocumento;
        $guiarem_codigo = $datos_comprobante[0]->CPC_GuiaRemCodigo;
        $docurefe_codigo = $datos_comprobante[0]->CPC_DocuRefeCodigo;
        //<formade pago>
        $codigo_forma_pago = $datos_comprobante[0]->FORPAP_Codigo;
        $cond_pago = 'NO DEFINIDO';
        if (strlen(trim($codigo_forma_pago)) > 0) {
            $forma_pago = $this->formapago_model->obtener($codigo_forma_pago);
            if (count($forma_pago) > 0) {
                $cond_pago = $forma_pago[0]->FORPAC_Descripcion;
            }
        }
        //</formade pago>
        $datos_moneda = $this->moneda_model->obtener($datos_comprobante[0]->MONED_Codigo);
        $moneda_nombre = (count($datos_moneda) > 0 ? $datos_moneda[0]->MONED_Descripcion : 'NUEVOS SOLES');
        $moneda_simbolo = (count($datos_moneda) > 0 ? $datos_moneda[0]->MONED_Simbolo : 'S/.');
        $temp = $this->usuario_model->obtener($vendedor);
        $temp = $this->persona_model->obtener_datosPersona($temp->PERSP_Codigo);
        //$vendedor        = $temp[0]->PERSC_Nombre.' '.$temp[0]->PERSC_ApellidoPaterno.' '.$temp[0]->PERSC_ApellidoMaterno;
        $vendedor = substr($temp[0]->PERSC_Nombre, 0, 1) . '. ' . $temp[0]->PERSC_ApellidoPaterno;
        if ($tipo == 0) {
            $datos_persona = $this->persona_model->obtener_datosPersona($persona);
            $nombre_cliente = $datos_persona[0]->PERSC_Nombre . " " . $datos_persona[0]->PERSC_ApellidoPaterno . " " . $datos_persona[0]->PERSC_ApellidoMaterno;
            $ruc = $datos_persona[0]->PERSC_Ruc;
            $telefono = $datos_persona[0]->PERSC_Telefono;
            $movil = $datos_persona[0]->PERSC_Movil;
            $direccion = $datos_persona[0]->PERSC_Direccion;
            $fax = $datos_persona[0]->PERSC_Fax;
        } elseif ($tipo == 1) {
            $datos_empresa = $this->empresa_model->obtener_datosEmpresa($empresa);
            $nombre_cliente = $datos_empresa[0]->EMPRC_RazonSocial;
            $ruc = $datos_empresa[0]->EMPRC_Ruc;
            $telefono = $datos_empresa[0]->EMPRC_Telefono;
            $movil = $datos_empresa[0]->EMPRC_Movil;
            $fax = $datos_empresa[0]->EMPRC_Fax;
            $emp_direccion = $this->empresa_model->obtener_establecimientosEmpresa_principal($empresa);
            if ($emp_direccion) {
                $direccion = $emp_direccion[0]->EESTAC_Direccion;
            } else
                $direccion = "";
        }
        $data['seniores'] = utf8_decode_seguro($nombre_cliente);
        if (isset($direccion)) {
            $data['direccion'] = utf8_decode_seguro($direccion);
        } else {
            $data['direccion'] = '';
        }
        $data['ruc'] = utf8_decode_seguro($ruc);
        $data['vendedor'] = $vendedor;
        $data['numero_guia_remision'] = utf8_decode_seguro($guiarem_codigo);
        $data['fecha'] = utf8_decode_seguro($fecha);
        //<tipo de cambio>
        $data['serie'] = $serie;
        $data['numero'] = $numero;
        $data['elmes'] = $mes;
        $data['dia'] = $dia;
        $data['mes'] = $mess;
        $data['fecha_pie'] = $fecha_pie;
        $data['anio'] = $anio;
        $data['documento_referencia'] = utf8_decode_seguro($docurefe_codigo);
        $data['serie_numero'] = $serie . '-&nbsp;&nbsp;' . $numero;
        $detalle_comprobante = $this->obtener_lista_detalles($codigo);
        /* Listado de detalles */
        $db_data = array();
        foreach ($detalle_comprobante as $indice => $valor) {


            if ($valor->CREDET_Pu_ConIgv != '')
                $pu_conigv = $valor->CREDET_Pu_ConIgv;
            else
                $pu_conigv = $valor->CPDEC_Pu + $valor->CPDEC_Pu * $valor->CPDEC_Igv100 / 100;
            $db_data[] = array(
                'item_numero' => $indice + 1,
                'item_cantidad' => $valor->CREDET_Cantidad,
                'item_unidad' => $valor->UNDMED_Simbolo,
                'item_codigo' => $valor->PROD_CodigoUsuario,
                'item_descripcion' => utf8_decode_seguro($valor->PROD_Nombre, true),
                'item_precio_unitario' => number_format($pu_conigv, 2),
                'item_importe' => number_format($valor->CREDET_Total, 2)
            );
        }
        $fecha_formato = $datos_comprobante[0]->CPC_Fecha;
        $lista = $this->obtener_tipo_de_cambio($fecha_formato);
        if (count($lista) > 0) {
            $valido_fecha = explode('-', $lista[0]->TIPCAMC_Fecha);
            $anio_v = $valido_fecha[0];
            $mes_v = $valido_fecha[1];
            $dia_v = $valido_fecha[2];
            $valido_fecha = $dia_v . ' /' . $mes_v . ' /' . $anio_v;
            $data['valido_fecha'] = $valido_fecha;
            $data['factor_de_conversion'] = $lista[0]->TIPCAMC_FactorConversion;
        } else {
            $data['valido_fecha'] = 'NO PRESENTA';
            $data['factor_de_conversion'] = 'NO EXISTE';
        }
        $data['lista_items'] = $db_data;
        $data['cond_pago'] = $cond_pago;
        $son = strtoupper(num2letras(round($total, 2))) . ' ' . $moneda_nombre;
        $data['igv100'] = $igv100;
        $data['total_texto'] = $son;
        $data['total_bruto'] = $moneda_simbolo . ' ' . number_format($total, 2);
        $data['igv'] = $moneda_simbolo . ' ' . number_format($igv, 2);
        $data['subtotal'] = $moneda_simbolo . ' ' . number_format(($total - $igv), 2);
        $data['total'] = $moneda_simbolo . ' ' . number_format($total, 2);
        $data['descuento'] = $moneda_simbolo . ' ' . number_format($descuento, 2);
        $this->load->view('ventas/comprobante_ver_html', $data);
    }

    public function formatos_de_impresion_B($codigo, $tipo_docu)
    {
        $datos_comprobante = $this->comprobante_model->obtener_comprobante($codigo);
        $presupuesto = $datos_comprobante[0]->PRESUP_Codigo;
        $serie = $datos_comprobante[0]->CPC_Serie;
        $numero = $datos_comprobante[0]->CPC_Numero;
        $cliente = $datos_comprobante[0]->CLIP_Codigo;
        $subtotal = $datos_comprobante[0]->CPC_subtotal;
        $descuento = $datos_comprobante[0]->CPC_descuento;
        $igv = $datos_comprobante[0]->CPC_igv;
        $igv100 = $datos_comprobante[0]->CPC_igv100;
        $descuento100 = $datos_comprobante[0]->CPC_descuento100;
        $total = $datos_comprobante[0]->CPC_total;
        $observacion = $datos_comprobante[0]->CPC_Observacion;
        $usuario = $datos_comprobante[0]->USUA_Codigo;
        $fecha = mysql_to_human($datos_comprobante[0]->CPC_Fecha);
        $dia = substr($fecha, 0, 2);
        $mes = substr($fecha, 3, 2);
        $anio = substr($fecha, 6, 4);
        $data['mes_numero'] = $mes;
        $mess = $this->meses($mes);
        $fecha_pie = $dia . '/ ' . $mes . '/ ' . $anio;
        $vendedor = $datos_comprobante[0]->USUA_Codigo;
        $datos_cliente = $this->cliente_model->obtener_datosCliente($cliente);
        $empresa = $datos_cliente[0]->EMPRP_Codigo;
        $persona = $datos_cliente[0]->PERSP_Codigo;
        $tipo = $datos_cliente[0]->CLIC_TipoPersona;
        $tipo_docu = $datos_comprobante[0]->CPC_TipoDocumento;
        $guiarem_codigo = $datos_comprobante[0]->CPC_GuiaRemCodigo;
        $docurefe_codigo = $datos_comprobante[0]->CPC_DocuRefeCodigo;
        $datos_moneda = $this->moneda_model->obtener($datos_comprobante[0]->MONED_Codigo);
        $moneda_nombre = (count($datos_moneda) > 0 ? $datos_moneda[0]->MONED_Descripcion : 'NUEVOS SOLES');
        $moneda_simbolo = (count($datos_moneda) > 0 ? $datos_moneda[0]->MONED_Simbolo : 'S/.');
        $temp = $this->usuario_model->obtener($vendedor);
        $temp = $this->persona_model->obtener_datosPersona($temp->PERSP_Codigo);
        //$vendedor        = $temp[0]->PERSC_Nombre.' '.$temp[0]->PERSC_ApellidoPaterno.' '.$temp[0]->PERSC_ApellidoMaterno;
        $vendedor = substr($temp[0]->PERSC_Nombre, 0, 1) . '. ' . $temp[0]->PERSC_ApellidoPaterno;
        if ($tipo == 0) {
            $datos_persona = $this->persona_model->obtener_datosPersona($persona);
            $nombre_cliente = $datos_persona[0]->PERSC_Nombre . " " . $datos_persona[0]->PERSC_ApellidoPaterno . " " . $datos_persona[0]->PERSC_ApellidoMaterno;
            $ruc = $datos_persona[0]->PERSC_Ruc;
            $telefono = $datos_persona[0]->PERSC_Telefono;
            $movil = $datos_persona[0]->PERSC_Movil;
            $direccion = $datos_persona[0]->PERSC_Direccion;
            $fax = $datos_persona[0]->PERSC_Fax;
        } elseif ($tipo == 1) {
            $datos_empresa = $this->empresa_model->obtener_datosEmpresa($empresa);
            $nombre_cliente = $datos_empresa[0]->EMPRC_RazonSocial;
            $ruc = $datos_empresa[0]->EMPRC_Ruc;
            $telefono = $datos_empresa[0]->EMPRC_Telefono;
            $movil = $datos_empresa[0]->EMPRC_Movil;
            $fax = $datos_empresa[0]->EMPRC_Fax;
            $emp_direccion = $this->empresa_model->obtener_establecimientosEmpresa_principal($empresa);
            if ($emp_direccion)
                $direccion = $emp_direccion[0]->EESTAC_Direccion;
            else {
                $direccion = "DESCONOCIDO";
            }
        }
        //<tipo de cambio>
        $fecha_formato = $datos_comprobante[0]->CPC_Fecha;
        $lista = $this->obtener_tipo_de_cambio($fecha_formato);
        if (count($lista) > 0) {
            $valido_fecha = explode('-', $lista[0]->TIPCAMC_Fecha);
            $anio_v = $valido_fecha[0];
            $mes_v = $valido_fecha[1];
            $dia_v = $valido_fecha[2];
            $valido_fecha = $dia_v . ' /' . $mes_v . ' /' . $anio_v;
            $data['valido_fecha'] = $valido_fecha;
            $data['factor_de_conversion'] = $lista[0]->TIPCAMC_FactorConversion;
        } else {
            $data['valido_fecha'] = 'NO PRESENTA';
            $data['factor_de_conversion'] = 'NO EXISTE';
        }
        $data['seniores'] = utf8_decode_seguro($nombre_cliente);
        $data['direccion'] = utf8_decode_seguro($direccion);
        $data['ruc'] = utf8_decode_seguro($ruc);
        $data['vendedor'] = $vendedor;
        $data['numero_guia_remision'] = utf8_decode_seguro($guiarem_codigo);
        $data['fecha'] = utf8_decode_seguro($fecha);
        $data['serie'] = $serie;
        $data['numero'] = $numero;
        $data['dia'] = $dia;
        $data['mes'] = $mess;
        $data['descuento'] = $descuento;
        $data['serie_numero'] = $serie . '-&nbsp;&nbsp;' . $numero;
        $data['anio'] = $anio;
        $data['documento_referencia'] = utf8_decode_seguro($docurefe_codigo);
        $data['fecha_pie'] = $fecha_pie;
        $detalle_comprobante = $this->obtener_lista_detalles($codigo);
        /* Listado de detalles */
        $db_data = array();
        foreach ($detalle_comprobante as $indice => $valor) {
            if ($valor->CPDEC_Pu_ConIgv != '')
                $pu_conigv = $valor->CPDEC_Pu_ConIgv;
            else
                $pu_conigv = $valor->CPDEC_Pu + $valor->CPDEC_Pu * $valor->CPDEC_Igv100 / 100;
            $db_data[] = array(
                'item_numero' => $indice + 1,
                'item_cantidad' => $valor->CPDEC_Cantidad,
                'item_unidad' => $valor->UNDMED_Simbolo,
                'item_codigo' => $valor->PROD_CodigoUsuario,
                'item_descripcion' => utf8_decode_seguro($valor->PROD_Nombre, true),
                'item_precio_unitario' => number_format($pu_conigv, 2),
                'item_importe' => number_format($valor->CPDEC_Total, 2)
            );
        }
        $data['lista_items'] = $db_data;
        $data['lista_items'] = $db_data;
        $son = 'SON : ' . strtoupper(num2letras(round($total, 2))) . ' ' . $moneda_nombre;
        $data['total_texto'] = $son;
        $data['total_bruto'] = $moneda_simbolo . ' ' . number_format($total, 2);
        $data['igv'] = $moneda_simbolo . ' ' . number_format($igv, 2);
        $data['subtotal'] = $moneda_simbolo . ' ' . number_format(($total - $igv), 2);
        $data['total'] = $moneda_simbolo . ' ' . number_format($total, 2);
        $data['descuento'] = $moneda_simbolo . ' ' . number_format($descuento, 2);
        $this->load->view('ventas/boleta_ver_html', $data);
    }

    public function obtener_tipo_de_cambio($fecha_comprobante)
    {
        return $this->tipocambio_model->obtener_x_fecha($fecha_comprobante);
    }

}

?>