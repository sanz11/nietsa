<?php
 //ini_set('error_reporting', 1); 

include("system/application/libraries/pchart/pData.php");
include("system/application/libraries/pchart/pChart.php");
//include("system/application/libraries/cezpdf.php");
//include("system/application/libraries/class.backgroundpdf.php");
//include("system/application/libraries/lib_fecha_letras.php");
//include("system/application/controller/maestros/configuracionimpresion");

class Comprobantealterno extends Controller{

  public function __construct(){
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
        $this->load->model('ventas/comprobante_model');
        $this->load->model('ventas/comprobantedetalle_model');
        $this->load->model('ventas/cliente_model');
        $this->load->model('ventas/presupuesto_model');
        $this->load->model('almacen/producto_model');
        $this->load->model('almacen/almacen_model');
        $this->load->model('almacen/unidadmedida_model');
        $this->load->model('almacen/guiarem_model');
        $this->load->model('almacen/guiasa_model');
        $this->load->model('almacen/guiasadetalle_model');
        $this->load->model('almacen/guiain_model');
        $this->load->model('almacen/guiaindetalle_model');
        $this->load->model('almacen/Serie_model');
        $this->load->model('almacen/seriedocumento_model');
        $this->load->model('maestros/documento_model');
        $this->load->model('maestros/empresa_model');
        $this->load->model('maestros/tipocambio_model');
        $this->load->model('maestros/persona_model');
        $this->load->model('maestros/moneda_model');
        $this->load->model('maestros/formapago_model');
        $this->load->model('maestros/condicionentrega_model');
        $this->load->model('maestros/configuracion_model');
        $this->load->model('seguridad/usuario_model');
        $this->load->model('maestros/companiaconfiguracion_model');
        $this->load->model('maestros/directivo_model');
        $this->load->model('maestros/tipocambio_model');
        $this->load->model('configuracion_model');
        
        $this->somevar['compania'] = $this->session->userdata('compania');
        $this->somevar['user'] = $this->session->userdata('user');
        $this->somevar['rol'] = $this->session->userdata('rol');
        $this->somevar['url'] = $_SERVER['REQUEST_URI'];
        date_default_timezone_set("America/Lima");
    }
   public function index(){
        $this->load->view('seguridad/inicio');
        $this->load->library('layout', 'layout');
    }
    public function alterno($tipo_oper = '', $tipo_docu = '', $j = '0'){
        $this->load->library('layout', 'layout');
        $data['compania'] = $this->somevar['compania'];
        $tipo_oper = $this->uri->segment(4);
        $tipo_docu = $this->uri->segment(5);
        $ver2 = "";
        
        $this->load->library('layout', 'layout');
        
        $data['action'] = 'index.php/ventas/comprobante/comprobantes/' . $tipo_oper . '/' . $tipo_docu;
        
        
        $conf['base_url'] = site_url('ventas/comprobante/comprobantes/' . $tipo_oper . '/' . $tipo_docu);
        $registros = $this->comprobante_model->contar_comprobantes($tipo_oper, $tipo_docu, NULL, '', '');
        $conf['per_page'] = 15;
        $conf['num_links'] = 3;
        $conf['first_link'] = "&lt;&lt;";
        $conf['last_link'] = "&gt;&gt;";
        $conf['total_rows'] = $registros;
        $conf['uri_segment'] = 6;
        $offset = (int)$this->uri->segment(6);
        
        $listaGuiaremAsociados=$this->comprobante_model->listar_comprobantealterna();
         $data['registros']=count($listaGuiaremAsociados);
        $item = $j + 1;
        $contadoVacios = 1;
        $lista = array();
        if (count($listaGuiaremAsociados) > 0) {
            foreach ($listaGuiaremAsociados as $indice => $valor) {
                        $codigo = $valor->CCA_Codigo;
                        $fecha = $valor->CCA_FechaRegistro;
                        $serie = $valor->CCA_Serie;
                        $numero = $valor->CCA_Numero;
                        $codigocliente = $valor->CLIP_Codigo;
                        $buscarcliente = $this->comprobante_model->obtener_clienteempresa($codigocliente);
                        $nombrecliente = "";
                        foreach ($buscarcliente as $indice1 => $valor1){
                            $nombrecliente = $valor1->EMPRC_RazonSocial;
                        }
                        
                      $editar = "<a href='javascript:;' onclick='editar_comprobantealterno(" . $codigo . ")' target='_parent'><img src='" . base_url() . "images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
                        $ver2 = "<a href='javascript:;' onclick='ver_pdf_conmenbretealterno_antiguo(" . $codigo .",8,1)'  target='_parent'><img src='" . base_url() . "images/pdf.png' width='16' height='16' border='0' title='Ver PDF'></a>";
                        
                                    
                        $eliminar = "<a href='javascript:;' onclick='eliminar_comprobantealterno(" . $codigo . ")' target='_parent'><img src='" . base_url() . "images/eliminar.png' width='16' height='16' border='0' title='Eliminar'></a>";

$ver = "<a href='javascript:;' onclick='ver_pdf_conmenbretealterno_antiguo1(" . $codigo . ")' target='_parent'><img src='" . base_url() . "images/icono_imprimir.png' width='16' height='16' border='0' title='Imprimir'></a>";
                        
                    $lista[] = array($item++, $fecha, $serie,$this->getOrderNumeroSerie($numero), $nombrecliente ,$editar, $ver2, $ver, $eliminar);

            }
        }
        $data['titulo_busqueda'] = "BUSCAR comprobante alterno ";
        $data['lista'] = $lista;
        $this->pagination->initialize($conf);
        $data['paginacion'] = $this->pagination->create_links();
        $detalle_comprobante = $this->obtener_lista_detalles($codigo);
        
        
        
        $this->layout->view('ventas/comprobanteindex_alterno',$data);
    }


     public function comprobantenuevo_alterno(){
     		 $compania = $this->somevar['compania'];
            $this->load->library('layout', 'layout');
            $comp_confi = $this->companiaconfiguracion_model->obtener($compania);
             $data['contiene_igv'] = (($comp_confi[0]->COMPCONFIC_PrecioContieneIgv == '1') ? true : false);
            //$oculto = form_hidden(array('codigo' => $codigo, 'base_url' => base_url(), 'tipo_oper' => $tipo_oper, 'tipo_docu' => $tipo_docu, 'contiene_igv' => ($data['contiene_igv'] == true ? '1' : '0')));
              $data['serie'] = "";
        $data['numero'] = "";
             $data['cliente'] = "";
             $data['codigo']= "";
              $data['tipo_docu'] = "";
            $data['tipo_oper'] = "";
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
            $data['ordencompra'] = "";
            $data['presupuesto_codigo'] ="";
            $data['dRef'] = "";
            $data['guiarem_codigo'] = "";
            $data['docurefe_codigo'] = "";
            $data['estado'] = "2";
            $data['numeroAutomatico'] = 1;
            $data['isProvieneCanje'] =false;
            
            $data['modo_impresion'] = "1";



            $compania = $this->somevar['compania'];
            $data['compania'] = $compania;
            $data['cboVendedor'] = $this->OPTION_generador($this->directivo_model->listar_directivo($this->session->userdata('empresa'), '4'), 'DIREP_Codigo', array('PERSC_ApellidoPaterno', 'PERSC_ApellidoMaterno', 'PERSC_Nombre'), '', array('', '::Seleccione::'), ' ');
            $data['cboMoneda'] = $this->OPTION_generador($this->moneda_model->listar(), 'MONED_Codigo', 'MONED_Descripcion', '1');
            $lista_almacen = $this->almacen_model->seleccionar();
            $data['cboAlmacen'] = form_dropdown("almacen", $lista_almacen, obtener_val_x_defecto($lista_almacen), " class='comboMedio' style='width:50%;' id='almacen'");
            $data['cmbVendedor']=$this->select_cmbVendedor($this->session->set_userdata('codUsuario'));
            $comp_confi = $this->companiaconfiguracion_model->obtener($compania);
            $data['igv'] = $comp_confi[0]->COMPCONFIC_Igv;
            $cambio_dia = $this->tipocambio_model->obtener_tdc_dolar(date('Y-m-d'));
            $data['tdc'] = $cambio_dia[0]->TIPCAMC_FactorConversion;

            
            $this->layout->view('ventas/comprobantenuevo_alterno', $data);
        }
    	public function comprobanteeditar_alterno($codigo){
    		$this->load->library('layout', 'layout');

        $comp_confi = $this->companiaconfiguracion_model->obtener($this->somevar['compania']);
        $datos_comprobante = $this->comprobante_model->obtener_comprobantealterna($codigo);
        $serie = $datos_comprobante[0]->CCA_Serie;
        $numero = $datos_comprobante[0]->CCA_Numero;
        $cliente = $datos_comprobante[0]->CLIP_Codigo;
        $proveedor = "";
        $forma_pago = $datos_comprobante[0]->FORPAP_Codigo;
        $moneda = $datos_comprobante[0]->MONED_Codigo;
        $subtotal = $datos_comprobante[0]->CCA_SubTotal;
        $descuento = $datos_comprobante[0]->CCA_Descuento;
        $igv = $datos_comprobante[0]->CCA_IGVTotal;
        $total = $datos_comprobante[0]->CCA_PrecioTotal;
        $subtotal_conigv = "";
        $descuento_conigv = "";
        $igv100 = "";
        $descuento100 = "";
       // $guiarem_codigo = $datos_comprobante[0]->CPC_GuiaRemCodigo;
       // $docurefe_codigo = $datos_comprobante[0]->CPC_DocuRefeCodigo;
        $observacion = $datos_comprobante[0]->CCA_Obervacion;//$datos_comprobante[0]->CCA_Observacion
        $modo_impresion = "";
        $estado = $datos_comprobante[0]->CCA_Flag;
        $fecha = mysql_to_human($datos_comprobante[0]->CCA_FechaRegistro);
        $vendedor = $datos_comprobante[0]->CCA_Vendedor;
        $tdc = $datos_comprobante[0]->CCA_TDC;
        $data['numeroAutomatico'] = "";
        $data['cmbVendedor']=$this->select_cmbVendedor($vendedor);
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
       
       
        $lista_almacen = $this->almacen_model->seleccionar();
        $data['cboAlmacen'] = form_dropdown("almacen", $lista_almacen, obtener_val_x_defecto($lista_almacen), " class='comboMedio' style='width:125px;' id='almacen'");
       
        $data['cboFormaPago'] = $this->OPTION_generador($this->formapago_model->listar(), 'FORPAP_Codigo', 'FORPAC_Descripcion', $forma_pago);
        $data['cboMoneda'] = $this->OPTION_generador($this->moneda_model->listar(), 'MONED_Codigo', 'MONED_Descripcion', $moneda);
        $data['cboVendedor'] = $this->OPTION_generador($this->directivo_model->listar_directivo($this->session->userdata('empresa'), '4'), 'DIREP_Codigo', array('PERSC_ApellidoPaterno', 'PERSC_ApellidoMaterno', 'PERSC_Nombre'), $vendedor, array('', '::Seleccione::'), ' ');
        $data['serie'] = $serie;
        $data['numero'] = $numero;
        $data['tdc'] = $tdc;
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
        $data['observacion'] = $observacion;
        $data['contiene_igv'] = (($comp_confi[0]->COMPCONFIC_PrecioContieneIgv == '1') ? true : false);
        //$oculto = form_hidden(array('codigo' => $codigo, 'base_url' => base_url(), 'tipo_oper' => $tipo_oper, 'tipo_docu' => $tipo_docu, 'contiene_igv' => ($data['contiene_igv'] == true ? '1' : '0')));
        $data['titulo'] = "EDITAR ";
        $data['formulario'] = "frmComprobante";
       // $data['oculto'] = $oculto;
        $data['url_action'] = base_url() . "index.php/ventas/comprobante/comprobante_modificar";
		$data['igv'] = $comp_confi[0]->COMPCONFIC_Igv;
		$data['tipo_docu']=	"F";
		$data['tipo_oper']=	"v";
         $detalle_comprobante = $this->obtener_lista_detalles($codigo);
		
		$data['detalle_comprobante'] = $detalle_comprobante;
		$this->layout->view('ventas/comprobantenuevo_alterno', $data);
    	}

public function comprobantemodificar_alterno(){
            $filter = new stdClass();
            
            $serie = $this->input->post('serie');
            $numero = $this->input->post('numero');
            $igv = $this->input->post('igv');
            $codigoCliente = $this->input->post('cliente');
            $codigoMoneda = $this->input->post('moneda');
            $tdc = $this->input->post('tdc');
            $codigoVendedor = $this->input->post('cmbVendedor');
            $codigoAlmacen = $this->input->post('almacen');
            $subTotal = $this->input->post('preciototal');
            $descuento = $this->input->post('descuentotal');
            $igvTotal = $this->input->post('igvtotal');
            $precioTotal = $this->input->post('importetotal');
            $observacion = $this->input->post('observacion');
            $codigo = $this->input->post('codigo');
            $filter->CCA_Numero =$numero;
            $filter->CCA_Serie =$serie;
            $filter->CCA_IGV =$igv;
            $filter->CLIP_Codigo =$codigoCliente;
            $filter->MONED_Codigo =$codigoMoneda;
            $filter->CCA_TDC =$tdc;
            $filter->PERSP_Codigo =$codigoVendedor;
            $filter->COMPP_Codigo =$codigoAlmacen;
            $filter->CCA_Obervacion =$observacion;
            $filter->CCA_SubTotal =$subTotal;
            $filter->CCA_Descuento =$descuento;
            $filter->CCA_IGVTotal =$igvTotal;
            $filter->CCA_PrecioTotal =$precioTotal;
            $filter->CCA_Flag = "1";
            $filter->CCA_FechaRegistro =date("Y-m-d H:i:s");
            
            $codigoComprobanteAlterno = $this->comprobante_model->modificar_comprobantealterno($codigo, $filter);
            
            
            $filter1 = new stdClass();
            
            $prodcodigo = $this->input->post('prodcodigo');
            $unidmedi = $this->input->post('produnidad');
            $prodcantidad = $this->input->post('prodcantidad');
            $prodpu_conigv = $this->input->post('prodpu_conigv');
            $prodpu = $this->input->post('prodpu');
            $prodprecio = $this->input->post('prodprecio');
            $detaccion = $this->input->post('detaccion');
            $detacodi = $this->input->post('detacodi');


//                      echo "<script>alert('count(prodcodigo)  : ".count($prodcodigo) ."')</script>";
                    
            if(is_array($detacodi)>0){
            	foreach ($detacodi as $i => $value) {
            		
                    $filter1->PROD_Codigo = $prodcodigo[$i];
                    $filter1->UNDMED_Codigo = $unidmedi[$i]; 
                    $filter1->CDA_Cantidad = $prodcantidad[$i];
                    $filter1->CDA_PUC_IGV = $prodpu_conigv[$i];
                    $filter1->CDA_PUS_IGV = $prodpu[$i];
                    $filter1->CDA_PrecioPorProducto = $prodprecio[$i]; 
                    $filter1->CDA_Flag = "1";
                    $filter1->CDA_FechaRegistro = date("Y-m-d H:i:s");
                    if($detaccion[$i]=="m"){
 					$this->comprobante_model->obtener_comprobantealterno($value,$filter1);
                    }elseif($detaccion[$i]=="n"){
                    	$filter1->CCA_Codigo = $codigo;
                    	$this->comprobante_model->guardarcomalternodetalle($filter1);
                    }elseif($detaccion[$i]=="e"){
                    	$this->comprobante_model->eliminaralternodetalle1($value);
                    }
            	}
            }
               
            
        }

        public function comprobantegrabar_alterno(){
            $filter = new stdClass();
            
            $serie = $this->input->post('serie');
            $numero = $this->input->post('numero');
            $igv = $this->input->post('igv');
            $codigoCliente = $this->input->post('cliente');
            $codigoMoneda = $this->input->post('moneda');
            $tdc = $this->input->post('tdc');
            $codigoVendedor = $this->input->post('cmbVendedor');
            $codigoAlmacen = $this->input->post('almacen');
            $subTotal = $this->input->post('preciototal');
            $descuento = $this->input->post('descuentotal');
            $igvTotal = $this->input->post('igvtotal');
            $precioTotal = $this->input->post('importetotal');
            $observacion = $this->input->post('observacion');
            
            $filter->CCA_Numero =$numero;
            $filter->CCA_Serie =$serie;
            $filter->CCA_IGV =$igv;
            $filter->CLIP_Codigo =$codigoCliente;
            $filter->MONED_Codigo =$codigoMoneda;
            $filter->CCA_TDC =$tdc;
            $filter->PERSP_Codigo =$codigoVendedor;
            $filter->COMPP_Codigo =$codigoAlmacen;
            $filter->CCA_Obervacion =$observacion;
            $filter->CCA_SubTotal =$subTotal;
            $filter->CCA_Descuento =$descuento;
            $filter->CCA_IGVTotal =$igvTotal;
            $filter->CCA_PrecioTotal =$precioTotal;
            $filter->CCA_Flag = "1";
            $filter->CCA_FechaRegistro =date("Y-m-d H:i:s");
            
            $codigoComprobanteAlterno = $this->comprobante_model->guardarcomproalterno($filter);
            
            
            $filter1 = new stdClass();
            
            $prodcodigo = $this->input->post('prodcodigo');
            $unidmedi = $this->input->post('produnidad');
            $prodcantidad = $this->input->post('prodcantidad');
            $prodpu_conigv = $this->input->post('prodpu_conigv');
            $prodpu = $this->input->post('prodpu');
            $prodprecio = $this->input->post('prodprecio');

//                      echo "<script>alert('count(prodcodigo)  : ".count($prodcodigo) ."')</script>";
                    
            
                for ($i=0;$i<count($prodcodigo);$i++){
                    $filter1->CCA_Codigo = $codigoComprobanteAlterno;
                    $filter1->PROD_Codigo = $prodcodigo[$i];
                    $filter1->UNDMED_Codigo = $unidmedi[$i]; 
                    $filter1->CDA_Cantidad = $prodcantidad[$i];
                    $filter1->CDA_PUC_IGV = $prodpu_conigv[$i];
                    $filter1->CDA_PUS_IGV = $prodpu[$i];
                    $filter1->CDA_PrecioPorProducto = $prodprecio[$i]; 
                    $filter1->CDA_Flag = "1";
                    $filter1->CDA_FechaRegistro = date("Y-m-d H:i:s");
                    
                    $this->comprobante_model->guardarcomalternodetalle($filter1);
                }
            
        }


    public function obtener_lista_detalles($codigo)
    {
        $detalle = $this->comprobantedetalle_model->listar_detallealterno($codigo);
        $lista_detalles = array();
        if (count($detalle) > 0) {
            foreach ($detalle as $indice => $valor) {
                $detacodi = $valor->CDA_Codigo;
                $producto = $valor->PROD_Codigo;
                $unidad = $valor->UNDMED_Codigo;
                $cantidad = $valor->CDA_Cantidad;
                $pu = "" ;//$valor->CPDEC_Pu
                $subtotal = "";
                $igv = "";
                $descuento = "";
                $total = $valor->CDA_PrecioPorProducto;
                $pu_conigv = "";//$valor->CPDEC_Pu_ConIgv
                $subtotal_conigv = $valor->CDA_PUC_IGV;
                $descuento_conigv = $valor->CDA_PUS_IGV;
                $descuento100 = "";
                $igv100 = "";
                $observacion = "";
                $datos_producto = $this->producto_model->obtener_producto($producto);
                $flagBS = $datos_producto[0]->PROD_FlagBienServicio;
                $datos_unidad = $this->unidadmedida_model->obtener($unidad);
                $GenInd ="" ;//$valor->CPDEC_GenInd
                $costo = "";//$valor->CPDEC_Costo
                $almacenProducto="";// $valor->ALMAP_Codigo
                $codigoGuiaremAsociadaDetalle="";// $valor->GUIAREMP_Codigo;
                
                $nombre_producto = $datos_producto[0]->PROD_Nombre;//($valor->CPDEC_Descripcion != '' ? $valor->CPDEC_Descripcion : $datos_producto[0]->PROD_Nombre)
                //$nombre_producto = str_replace('\\', '', $nombre_producto);
                $codigo_interno = $datos_producto[0]->PROD_CodigoUsuario;
                $codigo_usuario = $datos_producto[0]->PROD_CodigoUsuario;
                $nombre_unidad = is_array($datos_unidad) ? $datos_unidad[0]->UNDMED_Descripcion : 'SERV';

                $objeto = new stdClass();
                $objeto->CPDEP_Codigo = $detacodi;
                $objeto->flagBS = $flagBS;
                $objeto->PROD_Codigo = $producto;
                $objeto->PROD_CodigoInterno = $codigo_interno;
                $objeto->PROD_CodigoUsuario = $codigo_usuario;
                $objeto->UNDMED_Codigo = $unidad;
                $objeto->UNDMED_Simbolo = $nombre_unidad;
                $objeto->CPDEC_GenInd = $GenInd;
                $objeto->CPDEC_Costo = $costo;
                $objeto->PROD_Nombre = $nombre_producto;
                $objeto->CPDEC_Cantidad = $cantidad;
                $objeto->CPDEC_Pu = $descuento_conigv;
                $objeto->CPDEC_Subtotal = $subtotal;
                $objeto->CPDEC_Descuento = $descuento;
                $objeto->CPDEC_Igv = $igv;
                $objeto->CPDEC_Total = $total;
                $objeto->CPDEC_Pu_ConIgv = $subtotal_conigv;
                $objeto->CPDEC_Subtotal_ConIgv = $subtotal_conigv;
                $objeto->CPDEC_Descuento_ConIgv = $descuento_conigv;
                $objeto->CPDEC_Descuento100 = $descuento100;
                $objeto->CPDEC_Igv100 = $igv100;
                $objeto->CPDEC_Observacion = $observacion;
                $objeto->ALMAP_Codigo =$almacenProducto;
                $objeto->GUIAREMP_Codigo =$codigoGuiaremAsociadaDetalle;
                $lista_detalles[] = $objeto;
            }
        }
        return $lista_detalles;
    }
     public function comprobante_eliminaralterno(){
        $codigo = $this->input->post('codigo');
        $this->comprobante_model->comprobante_eliminaralterno($codigo);
    }
    public function select_cmbVendedor($index){
    $array_dist= $this->comprobante_model->select_cmbVendedor();
    $arreglo = array();
    foreach ($array_dist as $indice => $valor) {
        $indice1 = $valor->PERSP_Codigo;
        $valor1 = $valor->PERSC_Nombre." ".$valor->PERSC_ApellidoPaterno;
        $arreglo[$indice1] = $valor1;
        }
        $resultado = $this->html->optionHTML($arreglo, $index, array('', '::Seleccione::'));
        return $resultado;
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