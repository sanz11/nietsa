<?php
ini_set('error_reporting', 1);
include("system/application/libraries/cezpdf.php");
include("system/application/libraries/class.backgroundpdf.php");

class Cuentas extends controller
{

    public function __construct()
    {
        parent::Controller();
        $this->load->helper('pago');
        $this->load->helper('date');
        $this->load->helper('html');
        $this->load->helper('url');
        $this->load->library('pagination');
        $this->load->library('html');
        $this->load->library('form_validation');

        $this->load->model('tesoreria/cuentas_model');

        $this->load->model('tesoreria/flujocaja_model');
        $this->load->model('tesoreria/cuentaspago_model');
        $this->load->model('tesoreria/pago_model');
        $this->load->model('tesoreria/movimiento_model');
        $this->load->model('maestros/moneda_model');
        $this->load->model('maestros/tipocambio_model');
        $this->load->model('maestros/formapago_model');
        $this->load->model('compras/proveedor_model');
        $this->load->model('ventas/cliente_model');
        $this->load->model('compras/proveedor_model');
        $this->load->model('ventas/notacredito_model');
        date_default_timezone_set("America/Lima");
        $this->somevar['compania'] = $this->session->userdata('compania');
        $this->somevar['hoy']       = mdate("%Y-%m-%d %h:%i:%s",time());
        $this->somevar ['user'] = $this->session->userdata('user');
    }

    public function listar($tipo_cuenta = '1', $j = '0', $limpia = '')
    {
        unset($_SESSION['serie']);
        $this->load->library('layout', 'layout');
        if ($limpia == 1) {

            $this->session->unset_userdata('fechai');
            $this->session->unset_userdata('fechaf');
            $this->session->unset_userdata('serie');
            $this->session->unset_userdata('numero');
            $this->session->unset_userdata('estado_pago');
            $this->session->unset_userdata('comprobante');
            $this->session->unset_userdata('proveedor');
            $this->session->unset_userdata('ruc_proveedor');

            $this->session->unset_userdata('estado_pago');
            $this->session->unset_userdata('comprobante');

            $this->session->unset_userdata('nombre_proveedor');
            $this->session->unset_userdata('producto');
            $this->session->unset_userdata('codproducto');
            $this->session->unset_userdata('nombre_producto');
            $this->session->unset_userdata('monedalista');
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
            //modifica
            $comprobante = $this->input->post('comprobante');
            $cond_pago = $this->input->post('estado_pago');

            $filter->proveedor = $this->input->post('proveedor');
            $filter->ruc_proveedor = $this->input->post('ruc_proveedor');
            $filter->nombre_proveedor = $this->input->post('nombre_proveedor');
            $filter->producto = $this->input->post('producto');
            $filter->codproducto = $this->input->post('codproducto');
            $filter->MONED_Codigo = $this->input->post('monedalista');
            $filter->nombre_producto = $this->input->post('nombre_producto');
            $this->session->set_userdata(array('fechai' => $filter->fechai, 'fechaf' => $filter->fechaf, 'serie' => $filter->serie, 'numero' => $filter->numero, 'cliente' => $filter->cliente, 'ruc_cliente' => $filter->ruc_cliente, 'nombre_cliente' => $filter->nombre_cliente, 'proveedor' => $filter->proveedor, 'ruc_proveedor' => $filter->ruc_proveedor, 'nombre_proveedor' => $filter->nombre_proveedor, 'producto' => $filter->producto, 'codproducto' => $filter->codproducto, 'nombre_producto' => $filter->nombre_producto));
        } else {
            $filter->fechai = $this->session->userdata('fechai');
            $filter->fechaf = $this->session->userdata('fechaf');
            $filter->serie = $this->session->userdata('serie');
            $filter->numero = $this->session->userdata('numero');
            $filter->cliente = '';
            $filter->ruc_cliente = '';
            $filter->nombre_cliente = '';
            $cond_pago = $this->session->userdata('estado_pago');
            $comprobante = $this->session->userdata('comprobante');
            $filter->proveedor = '';
            $filter->ruc_proveedor = '';
            $filter->nombre_proveedor = '';
            $filter->producto = '';
            $filter->codproducto = '';
            $filter->nombre_producto = '';
            $filter->MONED_Codigo = $this->session->userdata('monedalista');

        }
        //var_dump($filter->cliente);
        $data['cboestadopago'] = $cond_pago;
        //$data['cboTipoDoc'] = $this->OPTION_generador($this->cuentas_model->tipodoc_get(), 'DOCUP_Codigo', 'DOCUC_Descripcion');
        $data['cboTipoDoc'] = $comprobante;
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
        $data['monedalista'] = $filter->MONED_Codigo;


        $conf['base_url'] = site_url('tesoreria/cuentas/listar/' . $tipo_cuenta . '/');

        $data['registros'] = count($this->cuentas_model->listar($tipo_cuenta, '', '', $filter, $cond_pago, $comprobante, 1));
        $conf['per_page'] = 20;
        $conf['num_links'] = 3;
        $conf['first_link'] = "&lt;&lt;";
        $conf['last_link'] = "&gt;&gt;";
        //$conf['total_rows'] = $data['registros'];
        $conf['uri_segment'] = 5;
        $offset = (int)$this->uri->segment(5);
        $conf['total_rows'] = $data['registros'];
        $listado_cuentas = $this->cuentas_model->listar($tipo_cuenta, $conf['per_page'], $offset, $filter, $cond_pago, $comprobante, 1);

        // $listado_productos = $this->producto_model->listar_productos($flagBS, "1", "", "1", $conf['per_page'], $offset);
        $item = $j + 1;
        $lista = array();
        //echo "<pre>";
        if (count($listado_cuentas) > 0) {
            foreach ($listado_cuentas as $indice => $valor) {
                $codigo = $valor->CUE_CodDocumento;
                switch ($valor->DOCUP_Codigo) {
                    case '8':
                        $tipo_docu = 'F';
                        $tipo_docu_nomb = 'Factura';
                        break;
                    case '9':
                        $tipo_docu = 'B';
                        $tipo_docu_nomb = 'Boleta';
                        break;
                    case '14':
                        $tipo_docu = 'N';
                        $tipo_docu_nomb = 'Comprobante';
                        break;
                    default:
                        $tipo_docu = '';
                        $codtipodocu = '';
                        break;
                }
                $fecha = mysql_to_human($valor->CUE_FechaOper);
                $serie = $valor->CPC_Serie;
                $numero = $valor->CPC_Numero;
                $temp = $this->obtener_nombre_numdoc(($tipo_cuenta == '1' ? 'CLIENTE' : 'PROVEEDOR'), ($tipo_cuenta == '1' ? $valor->CLIP_Codigo : $valor->PROVP_Codigo));
                $ruc = $temp['numdoc'];
                $nombre = $temp['nombre'];
                $total_formato = $valor->MONED_Simbolo . ' ' . number_format($valor->CUE_Monto, 2);
                $listado_pagos = $this->cuentaspago_model->listar($valor->CUE_Codigo);
                //print_r($listado_pagos);
                if($listado_pagos == NULL){
                    $avance = 0;
                }else {
                    $avance = $this->pago_model->sumar_pagos($listado_pagos, $valor->MONED_Codigo);
                }
                $saldo = $valor->CUE_Monto - $avance;
                $estado_formato = obtener_estado_formato($valor->CUE_Monto, $avance);
                $saldo = $valor->MONED_Simbolo . ' ' . number_format($saldo, 2);
                $editar = "<a href='javascript:;' onclick='ver_pagos(" . $valor->CUE_Codigo . ")' target='_parent'><img src='" . base_url() . "images/dolar.png' width='16' height='16' border='0' title='" . ($tipo_cuenta == '1' ? 'Cobros' : 'Pagos') . " Realizados'></a>";
                $ver = "<a href='javascript:;' onclick='ver_comprobante_pdf(" . $codigo . ", \"" . $tipo_docu . "\")' target='_parent'><img src='" . base_url() . "images/icono_imprimir.png' width='16' height='16' border='0' title='Imprimir'></a>";
                $ver2 = "<a href='javascript:;' onclick='comprobante_ver_pdf_conmenbrete(" . $codigo . ", \"" . $tipo_docu . "\",$tipo_cuenta)' target='_parent'><img src='" . base_url() . "images/pdf.png' width='16' height='16' border='0' title='Ver PDF'></a>";

                $lista[] = array($item++, $tipo_docu_nomb, $serie, $numero, $fecha, $nombre, $total_formato, $saldo, $estado_formato, $editar, $ver, $ver2);
            }
        }

        //print_r($listado_cuentas);

        $data['titulo_tabla'] = "CUENTAS POR " . ($tipo_cuenta == '1' ? 'COBRAR' : 'PAGAR');
        $data['titulo_busqueda'] = "BUSCAR CUENTAS POR " . ($tipo_cuenta == '1' ? 'COBRAR' : 'PAGAR');
        $data['tipo_cuenta'] = $tipo_cuenta;
        $data['lista'] = $lista;
        $data['oculto'] = form_hidden(array('base_url' => base_url(), 'tipo_cuenta' => $tipo_cuenta));
        $this->pagination->initialize($conf);
        $data['paginacion'] = $this->pagination->create_links();
        $this->layout->view('tesoreria/cuentas_index', $data);
    }

    public function nuevo($tipo_cuenta = '1')
    {
        $this->load->library('layout', 'layout');
        $codigo = "";
        $this->session->unset_userdata('estado_pago2');
        $data['form_open'] = form_open(base_url() . 'index.php/tesoreria/cuentas/grabar', array("name" => "frmCuenta", "id" => "frmCuenta"));
        $data['form_close'] = form_close();

        $filter = new stdClass();
        $filter->TIPCAMC_Fecha = date('Y-m-d', time());
        $filter->TIPCAMC_MonedaDestino = '2';
        $temp = $this->tipocambio_model->buscar($filter);
        $data['tdc'] = count($temp) > 0 ? $temp[0]->TIPCAMC_FactorConversion : '';

        $data['detalle_cuentas'] = array();

        $data['cboMoneda'] = $this->OPTION_generador($this->moneda_model->listar(), 'MONED_Codigo', 'MONED_Descripcion', '1');

        $data['titulo'] = "REGISTRAR PAGOS";
        $data['tipo_cuenta'] = $tipo_cuenta;
        $data['alerta'] = $this->seleccionar_alerta();

        $data['oculto'] = form_hidden(array('codigo' => $codigo, 'base_url' => base_url(), 'tipo_cuenta' => $tipo_cuenta));
        
        $data['cmbCaja'] = $this->OPTION_generador($this->movimiento_model->listCajatotal(), 'CAJA_Codigo','CAJA_Nombre','');
        $this->layout->view('tesoreria/cuentas_pago', $data);
    }

    public function grabar()
    {
    	    				/**********CAJA_MOVIMIENTO************/
    	$filterres = new stdClass();
    	$filtero = new stdClass();
    	$usuario =$this->somevar['user'];
    	$fechaRegistro = mdate("%Y-%m-%d ", time());
    						/**********CAJA_MOVIMIENTO***********/
    	
        $datos = array();
        if ($this->input->post('tipo_cuenta') == '1' && $this->input->post('cliente') == '')
            exit('{"result":"error", "campo":"ruc_cliente"}');
        if ($this->input->post('tipo_cuenta') == '2' && $this->input->post('proveedor') == '')
            exit('{"result":"error", "campo":"ruc_proveedor"}');
        if ($this->input->post('monto') == '' || $this->input->post('monto') == '0')
            exit('{"result":"error", "campo":"monto"}');
        if ($this->input->post('forma_pago') == '2' && $this->input->post('banco') == '')
            exit('{"result":"error", "campo":"banco"}');
        if ($this->input->post('forma_pago') == '2' && $this->input->post('ctacte') == '')
            exit('{"result":"error", "campo":"ctacte"}');
        if ($this->input->post('forma_pago') == '3' && $this->input->post('nroCheque') == '')
            exit('{"result":"error", "campo":"nroCheque"}');
        if ($this->input->post('forma_pago') == '3' && $this->input->post('fechaEmi') == '')
            exit('{"result":"error", "campo":"fechaEmi"}');
        if ($this->input->post('forma_pago') == '3' && $this->input->post('fechaVenc') == '')
            exit('{"result":"error", "campo":"fechaVenc"}');
        if ($this->input->post('forma_pago') == '4' && $this->input->post('factura') == '')
            exit('{"result":"error", "campo":"factura"}');
        // NOTA DE CREDITO
        if ($this->input->post('forma_pago') == '5' && $this->input->post('codigoNota') == '0')
            exit('{"result":"error", "campo":"notaCredito"}');
        if ($this->input->post('forma_pago') == '6' && $this->input->post('obsDesc') == '')
            exit('{"result":"error", "campo":"obsDesc"}');

        $filter = new stdClass();
        $filter->PAGC_TipoCuenta = $this->input->post('tipo_cuenta');
        $filter->PAGC_FechaOper = human_to_mysql($this->input->post('fecha'));
        if ($this->input->post('tipo_cuenta') == '1')
            $filter->CLIP_Codigo = $this->input->post('cliente');
        else
            $filter->PROVP_Codigo = $this->input->post('proveedor');
        $filter->PAGC_TDC = $this->input->post('tdc');
        $filter->PAGC_Monto = $this->input->post('monto');
        $filter->MONED_Codigo = $this->input->post('moneda');
        $filter->PAGC_FormaPago = $this->input->post('forma_pago');
        if ($filter->PAGC_FormaPago == '2' && $this->input->post('banco') != '')
            $filter->PAGC_DepoNro = $this->input->post('forma_pago');
        if ($filter->PAGC_FormaPago == '2' && $this->input->post('ctacte') != '')
            $filter->PAGC_DepoCta = $this->input->post('ctacte');
        if ($filter->PAGC_FormaPago == '3' && $this->input->post('nroCheque') != '')
            $filter->nroCheque = $this->input->post('nroCheque');
        if ($filter->PAGC_FormaPago == '3' && $this->input->post('fechaEmi') != '')
            $filter->fechaEmi = human_to_mysql($this->input->post('fechaEmi'));
        if ($filter->PAGC_FormaPago == '3' && $this->input->post('fechaVenc') != '')
            $filter->fechaVenc = human_to_mysql($this->input->post('fechaVenc'));
        if ($filter->PAGC_FormaPago == '4' && $this->input->post('factura') != '')
            $filter->PAGC_Factura = $this->input->post('factura');
        if ($filter->PAGC_FormaPago == '5' && $this->input->post('codigoNota') != '')
            $filter->PAGC_NotaCredito = $this->input->post('codigoNota');
        if ($filter->PAGC_FormaPago == '6' && $this->input->post('obsDesc') != '')
            $filter->PAGC_DescObs = $this->input->post('obsDesc');
        if ($this->input->post('observacion') != '')
            $filter->PAGC_Obs = $this->input->post('observacion');
        $filter->PAGC_Saldo = $this->input->post('saldo');
        $filter->COMPP_Codigo = $this->somevar['compania'];
        $comprobanteAfectado = $this->input->post('nota_codDocumento1');

        /*********************/
        $MovimientoDineros = $this->input->post('tipo_cuenta');
        
        if($MovimientoDineros == 1){
        	$GiradorBeneficiario = "G";
        	$codigo = $this->input->post('cliente');
        	$filterres->CLIP_Codigo=$codigo; //CLIENTE
        
        
        }else{
        	$GiradorBeneficiario = "B";
        	$codigo = $this->input->post('proveedor');
        	$filterres->PROVP_Codigo=$codigo; // PORVEEDOR
        }
         
        //     			echo "<script>alert('Proveedor  y Cliente : ".$codigo."')</script>";
         
        $codigobuscarcaja = $this->movimiento_model->buscar_cajamovimiento($codigo,$GiradorBeneficiario);
        	
        if($codigobuscarcaja !=0){
        	echo "<script>alert('no guardar por que ya existe')</script>";
        }else{
        	/***** CJI_RESPONSABLEMOVIMIENTO ******/
        	$filterres->RESPNMOV_TipBenefi = $GiradorBeneficiario;
        	$fechaIngreso =  human_to_mysql($this->input->post('fecha'));
        	$filterres->RESPNMOV_FechaIngreso = $fechaIngreso;
        	$filterres->RESPNMOV_CodigoUsuario = $usuario;
        	$filterres->RESPNMOV_FlagEstado = "1";
        	$codigomovimiento = $this->movimiento_model->insertar_responsablevimiento($filterres);
        
        
        	/***** CJI_CAJAMOVIMIENTO ****/
        	$filtero->RESPMOV_Codigo = $codigomovimiento;
        
        	if($MovimientoDineros == 1){ // BENEFICIARIO
        		$filtero->CAJAMOV_MovDinero = 2;
        			
        		$filtero->CAJAMOV_TipoRespo = 40;
        		$filtero->CAJA_Codigo = $this->input->post("idcajadiaria");
        		$filtero->CUNTCONTBL_Codigo_B = 0;
        			
        		$filtero->CUENT_Codigo_B = $this->input->post("idcuentacaja");
        			
        		//     						$filtero->MONED_Codigo_B = $TipoMoneda_B[$indice]; VERIFICAR
        			
        		$filtero->CAJAMOV_Monto_B = 0;
        
        		$filtero->CAJAMOV_FormaPago_B = $this->input->post("forma_pago");
        
        		$filtero->CAJAMOV_FechaSistema = $fechaIngreso;
        		$filtero->CAJAMOV_CodigoUsuario = $usuario;
        	}else{ //2 = GIRADOR
        		$filtero->CAJAMOV_MovDinero = 1;
        		$filtero->CAJAMOV_TipoRespo = 30;
        		$filtero->CAJA_Codigo = $this->input->post("idcajadiaria");
        		$filtero->CUNTCONTBL_Codigo_G = 0;
        			
        		$filtero->CUENT_Codigo_G = $this->input->post("idcuentacaja");
        			
        		//     						$filtero->MONED_Codigo_G =
        			
        		$filtero->CAJAMOV_Monto_G = 0;
        
        		$filtero->CAJAMOV_FormaPago_G = $this->input->post("forma_pago");
        
        		$filtero->CAJAMOV_FechaSistema = $fechaIngreso;
        		$filtero->CAJAMOV_CodigoUsuario = $usuario;
        	}
        	$codigoCajaMovimiento = $this->movimiento_model->insertar_cajamovimiento($filtero);
        }
        /*************************/
        //$pago_cajamov = $filter->CAJAMOV_Codigo = $codigoCajaMovimiento;
        $cod_pago = $this->pago_model->insertar($filter, $this->input->post('tipo_cuenta'), $this->input->post('forma_pago'), $this->somevar['compania']);

        $listado_cuentas = $this->cuentas_model->buscar($this->input->post('tipo_cuenta'), ($this->input->post('tipo_cuenta') == '1' ? $this->input->post('cliente') : $this->input->post('proveedor')));

        if ($this->input->post('posiciones_pagos')) {
            $posiciones = $this->input->post('posiciones_pagos');
            foreach ($posiciones as $valor) {
                foreach ($listado_cuentas as $cambiar) {
                    if ($cambiar->CUE_CodDocumento == $valor) {
                        $nuevaposicion[] = $cambiar;
                    }
                }
            }
            $listado_cuentas = $nuevaposicion;
        }

        $resultado = array();
        $monto = $this->input->post('monto');

        $codigoCuenta = NULL;
        $codigoDocumento = NULL;
        $codigoEscojido = FALSE;

        if (is_array($listado_cuentas)) {
            foreach ($listado_cuentas as $cuenta) {
                if ($monto == 0)
                    break;
                $listado_pagos = $this->cuentaspago_model->listar($cuenta->CUE_Codigo, '');
                $avance = $this->pago_model->sumar_pagos($listado_pagos, $this->input->post('moneda'));
                $total = cambiar_moneda($cuenta->CUE_Monto, $this->input->post('tdc'), $cuenta->MONED_Codigo, $this->input->post('moneda'));
                $saldo = $total - $avance;
                $lista_moneda = $this->moneda_model->obtener($this->input->post('moneda'));

                if ($monto > $saldo) {
                    $pago = $saldo;
                    $monto -= $saldo;
                    $avance = $total;
                } else {
                    $pago = $monto;
                    $avance += $monto;
                    $monto = 0;
                }

                $filter = new stdClass();
                $filter->CUE_Codigo = $cuenta->CUE_Codigo;
                if($codigoEscojido == FALSE) {
                    $codigoCuenta = $cuenta->CUE_Codigo;
                    $codigoDocumento = $cuenta->CUE_CodDocumento;
                    $codigoEscojido = TRUE;
                }
                $filter->PAGP_Codigo = $cod_pago;
                $filter->CPAGC_TDC = $this->input->post('tdc');
                $filter->CPAGC_Monto = $pago;
                $filter->MONED_Codigo = $this->input->post('moneda');

                $cod_cuentaspago = $this->cuentaspago_model->insertar($filter);

                $this->cuentas_model->modificar_estado($cuenta->CUE_Codigo, ($avance == $total ? 'C' : 'A'));
            }
        }

        $insertNotaCredito = FALSE;
        if ($this->input->post('forma_pago') == '5' && $this->input->post('codigoNota') != '0') {
            $datosComprobante = $this->notacredito_model->buscarComprobante_nota($codigoDocumento);
            if($datosComprobante != NULL){
                $insertNotaCredito = $this->notacredito_model->modificar_notaCredito($datosComprobante, $this->input->post('codigoNota'));
            }
        }

        $datos = array(
        	'cod_cajamov' => $pago_cajamov,
            'comprobanteAfectado' => $comprobanteAfectado."ABEL",
            'cod_pago' => $cod_pago,
            'cod_cuentaspago' => $cod_cuentaspago,
            'nota' => $insertNotaCredito,
            'result' => "ok"
        );

        echo json_encode($datos);

    }

    public function ventana_muestra_notaCredito_cliente($cliente){

        if($cliente == "" || $cliente <= 0 || $cliente == NULL){
            echo "Error en levantar la nota de credito. " . "<a href='".base_url().'index.php/tesoreria/cuentas/nuevo/1'."' >Click Aqui</a>";
        }else {
            $data['cliente'] = $cliente;
            $datosCliente = $this->cliente_model->obtener($cliente);
            $data['datosCliente'] = $datosCliente;
            // Notas de credito => return NULL O array
            $notaCredito = $this->cuentas_model->buscar_notas_credito_cliente($cliente);
            $data['notas'] = $notaCredito;
            $this->load->view('tesoreria/ventana_muestra_notacredito', $data);
        }
    }

    public function ventana_muestra_notaCredito_proveedor($proveedor){

        if($proveedor == "" || $proveedor <= 0 || $proveedor == NULL){
            echo "Error en levantar la nota de credito. " . "<a href='".base_url().'index.php/tesoreria/cuentas/nuevo/1'."' >Click Aqui</a>";
        }else {
            $data['cliente'] = $proveedor;
            $datosCliente = $this->proveedor_model->obtener_proveedor_info($proveedor);
            $data['datosCliente'] = $datosCliente;
            // Notas de credito => return NULL O array
            $notaCredito = $this->cuentas_model->buscar_notas_credito_proveedor($proveedor);
            $data['notas'] = $notaCredito;
            $this->load->view('tesoreria/ventana_muestra_notacredito', $data);
        }
    }

    public function JSON_cuentas_pendientes()
    {
        $tipo_cuenta = $this->input->post('tipo_cuenta');
        $codigo = $this->input->post('codigo');
        $monto = $this->input->post('monto');
        $moneda = $this->input->post('moneda');
        $tdc = $this->input->post('tdc');
        $aplica_pago = $this->input->post('aplica_pago');
        $posiciones = 0;
        $order = $this->input->post('order');
        $estado = array('V', 'A');
        $listado_cuentas = $this->cuentas_model->buscar($tipo_cuenta, $codigo, $estado, '', '', $order);
        //ordenar array segun otro array gcbq
        if ($order == '') {
            $posiciones = $this->input->post('posiciones');
            if ($posiciones) {
                foreach ($posiciones as $valor) {
                    foreach ($listado_cuentas as $cambiar) {
                        if ($cambiar->CUE_CodDocumento == $valor) {
                            $nuevaposicion[] = $cambiar;
                        }
                    }
                }
                $listado_cuentas = $nuevaposicion;
            }
        }
        //

        $resultado = array();
        if (is_array($listado_cuentas)) {
            foreach ($listado_cuentas as $indice => $cuenta) {
                $temp = $this->obtener_nombre_numdoc(($tipo_cuenta == '1' ? 'CLIENTE' : 'PROVEEDOR'), $codigo);
                $ruc = $temp['numdoc'];
                $nombre = $temp['nombre'];
                $listado_pagos = $this->cuentaspago_model->listar($cuenta->CUE_Codigo);
                $avance = $this->pago_model->sumar_pagos($listado_pagos, $moneda);
                $total = cambiar_moneda($cuenta->CUE_Monto, $tdc, $cuenta->MONED_Codigo, $moneda);
                $saldo = $total - $avance;
                $lista_moneda = $this->moneda_model->obtener($moneda);
                $cod_documento = $cuenta->CUE_CodDocumento;
                $serie = $cuenta->CPC_Serie;
                $numero = $cuenta->CPC_Numero;
                $tipo_doc = $cuenta->CPC_TipoDocumento;
                $desc_cod = "";
                if ($tipo_doc == 'F')
                    $desc_cod = 'FACTURA';
                else if ($tipo_doc == 'B')
                    $desc_cod = 'BOLETA';
                if ($aplica_pago == '1') {
                    if ($monto > $saldo) {
                        $monto -= $saldo;
                        $avance = $total;
                    } else {
                        $avance += $monto;
                        $monto = 0;
                    }
                    $saldo = $total - $avance;
                }
                $resultado[] = array('fecha' => mysql_to_human($cuenta->CUE_FechaOper),
                    "ruc" => $ruc, "nombre" => $nombre, "moneda" => $lista_moneda[0]->MONED_Simbolo . $order,
                    "total" => number_format($total, 4), "avance" => number_format($avance, 4),
                    "saldo" => number_format($saldo, 4), "saldo_total" => number_format($monto, 4),
                    "serie" => $serie, "numero" => $numero, "tipo_doc" => $tipo_doc, 'desc_doc' => $desc_cod,
                    "cod_documento" => $cod_documento, "total_int" => (double)$total, "avance_int" => (double)$avance,
                    "saldo_int" => (double)$saldo, "saldo_total_int" => (double)$monto);
            }
        }
        $opcional = count($resultado);
        if($opcional > 0) {
            echo json_encode($resultado);
        }else{
            $error = array(
                'errores' => 'warning'
            );

            echo json_encode($error);
        }
    }

    public function JSON_notas_credito_pendientes($tipo_cuenta, $codigo)
    {

        $listado_cuentas = $this->cuentas_model->buscar_notas_credito($tipo_cuenta, $codigo);
        if ($listado_cuentas != NULL) {
            echo json_encode($listado_cuentas);
        }else{
            $errores = array(
                'warning' => 'Sin notas',
            );
            echo json_encode($errores);
        }
    }

    function obtener_nombre_numdoc($tipo, $codigo)
    {
        $nombre = '';
        $numdoc = '';
        //echo $codigo."<br/>";
        if ($tipo == 'CLIENTE') {
            $datos_cliente = $this->cliente_model->obtener($codigo);
            if ($datos_cliente) {
                $nombre = $datos_cliente->nombre;
                $numdoc = $datos_cliente->ruc;
            }
        } else if ($tipo == 'PROVEEDOR') {
            $datos_proveedor = $this->proveedor_model->obtener($codigo);

            if ($datos_proveedor) {

                $nombre = $datos_proveedor->nombre;
                $numdoc = $datos_proveedor->ruc;
            }
        }
        //echo $nombre."_______".$numdoc."<br/>";
        return array('numdoc' => $numdoc, 'nombre' => $nombre);
    }

    public function seleccionar_alerta($indDefault = '')
    {
        $array_dist = $this->cuentas_model->listar_alertas();
        $arreglo = array();
        if (count($array_dist) > 0) {
            foreach ($array_dist as $indice => $valor) {
                $indice1 = $valor->BANP_Codigo;
                $valor1 = $valor->BANC_Nombre;
                $arreglo[$indice1] = $valor1;
            }
        }
        $resultado = $this->html->optionHTML($arreglo, $indDefault, array('', '.::SELECCIONE::.'));
        return $resultado;
    }

    public function generarPdfCuentas($tipo_cuenta,
                                      $codigo,
                                      $monto,
                                      $moneda,
                                      $tdc,
                                      $aplica_pago,
                                      $order, $nombre_cliente)
    {


        $posiciones = 0;
        $estado = array('V', 'A');
        $listado_cuentas = $this->cuentas_model->buscar($tipo_cuenta, $codigo, $estado, '', '', $order);
        //ordenar array segun otro array gcbq
        if ($order == '') {
            if ($this->input->post('posiciones')) {
                $posiciones = $this->input->post('posiciones');
                foreach ($posiciones as $valor) {
                    foreach ($listado_cuentas as $cambiar) {
                        if ($cambiar->CUE_CodDocumento == $valor) {
                            $nuevaposicion[] = $cambiar;
                        }
                    }
                }
                $listado_cuentas = $nuevaposicion;
            }
        }
        //

        $total1 = 0;
        $avance1 = 0;
        $saldo1 = 0;

        $this->load->library('cezpdf');
        $this->load->helper('pdf_helper');
        $this->cezpdf = new Cezpdf('a4', 'portrait');
        $resultado = array();
        $db_data = array();
        if (is_array($listado_cuentas)) {
            foreach ($listado_cuentas as $indice => $cuenta) {
                $temp = $this->obtener_nombre_numdoc(($tipo_cuenta == '1' ? 'CLIENTE' : 'PROVEEDOR'), $codigo);
                $ruc = $temp['numdoc'];
                $nombre = $temp['nombre'];
                $listado_pagos = $this->cuentaspago_model->listar($cuenta->CUE_Codigo);
                $avance = $this->pago_model->sumar_pagos($listado_pagos, $moneda);
                $total = cambiar_moneda($cuenta->CUE_Monto, $tdc, $cuenta->MONED_Codigo, $moneda);
                $saldo = $total - $avance;
                $lista_moneda = $this->moneda_model->obtener($moneda);
                $cod_documento = $cuenta->CUE_CodDocumento;
                $serie = $cuenta->CPC_Serie;
                $numero = $cuenta->CPC_Numero;
                $tipo_doc = $cuenta->CPC_TipoDocumento;
                $desc_cod = "";
                if ($tipo_doc == 'F')
                    $desc_cod = 'FACTURA';
                else if ($tipo_doc == 'B')
                    $desc_cod = 'BOLETA';
                if ($aplica_pago == '1') {
                    if ($monto > $saldo) {
                        $monto -= $saldo;
                        $avance = $total;
                    } else {
                        $avance += $monto;
                        $monto = 0;
                    }
                    $saldo = $total - $avance;
                }


                $total1 = $total1 + $total;
                $avance1 = $avance1 + $avance;
                $saldo1 = $saldo1 + $saldo;


                $db_data[] = array(
                    'cols1' => $indice + 1,
                    'cols2' => mysql_to_human($cuenta->CUE_FechaOper),
                    'cols3' => $desc_cod,
                    'cols4' => $serie . "-" . $numero,
                    'cols5' => $lista_moneda[0]->MONED_Simbolo,
                    'cols6' => $total,
                    'cols7' => $avance,
                    'cols8' => $saldo

                );


            }
            $db_data[] = array(
                'cols1' => '',
                'cols2' => '',
                'cols3' => 'Total',
                'cols4' => '',
                'cols5' => '',
                'cols6' => $total1,
                'cols7' => $avance1,
                'cols8' => $saldo1

            );

        }

        /* Cabecera */
        $this->cezpdf->ezText("Translogint EIRL", 10, array("leading" => 10, "left" => 40));
        $this->cezpdf->ezText('', '', array('leading' => 10));

        /* Datos del cliente */
        $this->cezpdf->ezText("Cliente: " . $ruc . " " . $nombre_cliente, 10, array("leading" => 10, "left" => 40));

        $this->cezpdf->ezText('', '', array('leading' => 10));
        /* Listado de detalles */

        $col_names = array(
            'cols1' => 'Item',
            'cols2' => 'Fecha',
            'cols3' => 'Comprobante',
            'cols4' => 'Serie / Numero.',
            'cols5' => 'Moneda.',
            'cols6' => 'Avance.',
            'cols7' => 'Saldo',
            'cols8' => 'Estado'

        );

        $this->cezpdf->ezTable($db_data, $col_names, '', array(
            'width' => 750,
            'showLines' => 1,
            'shaded' => 0,
            'showHeadings' => 1,
            'xPos' => 'center',
            'fontSize' => 8,
            'cols' => array(
                'cols1' => array('width' => 30, 'justification' => 'center'),
                'cols2' => array('width' => 70, 'justification' => 'left'),
                'cols3' => array('width' => 70, 'justification' => 'left'),
                'cols4' => array('width' => 40, 'justification' => 'left'),
                'cols5' => array('width' => 40, 'justification' => 'left'),
                'cols6' => array('width' => 50, 'justification' => 'right'),
                'cols7' => array('width' => 60, 'justification' => 'right'),
                'cols8' => array('width' => 60, 'justification' => 'right')
            )
        ));
        /* Totales */

        $cabecera = array('Content-Type' => 'application/pdf', 'Content-Disposition' => 'nama_file.pdf', 'Expires' => '0', 'Pragma' => 'cache', 'Cache-Control' => 'private');
        $this->cezpdf->ezStream($cabecera);


    }
    
    
    public function obtenerBancosProveedor(){
    	$codigoproveedor = $this->input->post('codigoproveedor');
    	$result = array();
    	if($codigoproveedor!=null && count(trim($codigoproveedor))>0){
    			$tipoProveedor = $this->movimiento_model->comboBancoTipoProveedor($codigoproveedor);
    			foreach ($tipoProveedor as $indice => $valor){
    				$tipoProveedor = $valor-> PROVC_TipoPersona;
    			}//1=EMPRESA , 0=PERSONA
    			if($tipoProveedor  != 1){
    				$SeleccionBanco = $this->movimiento_model->comboBancoProveedorNatural($codigoproveedor);
    			}
    			 
    			if($tipoProveedor  == 1){
    				$SeleccionBanco = $this->movimiento_model->comboBancoProveedor($codigoproveedor);
    			}
    		if($SeleccionBanco !=null && count($SeleccionBanco)){
    			foreach($SeleccionBanco as $indice=>$valor){
    				$banconombre		= $valor->BANC_Nombre;
    				$bancocodigo =	$valor->BANP_Codigo;
    				$cajacodigo =	$valor->CAJA_Codigo;
    				$result[] = array("banconombre" => $banconombre , "bancocodigo" => $bancocodigo , "cajacodigo" => $cajacodigo  );
    
    			}
    		}
    	}
    	echo json_encode($result);
    }
    
    public function obtenerBancosCliente(){
    	$codigoCliente = $this->input->post('codigoCliente');
    	//     		echo "<script>alert('codiugo de provedodr  : ".$codigoproveedor."')</script>";
    	 
    	$result = array();
    
    	if($codigoCliente!=null && count(trim($codigoCliente))>0){
    
    		$tipoCLiente = $this->movimiento_model->comboBancoTipoCliente($codigoCliente);
    		foreach ($tipoCLiente as $indice => $valor){
    			$tipoCLiente = $valor-> CLIC_TipoPersona;
    		}//1=EMPRESA , 0=PERSONA
    		if($tipoCLiente  != 1){
    			$SeleccionBanco = $this->movimiento_model->comboBancoClienteNatural($codigoCliente);
    		}
    		
    		if($tipoCLiente  == 1){
    			$SeleccionBanco = $this->movimiento_model->comboBanco($codigoCliente);
    		}
    
    		if($SeleccionBanco !=null && count($SeleccionBanco)){
    			foreach($SeleccionBanco as $indice=>$valor){
    				$banconombre		= $valor->BANC_Nombre;
    				$bancocodigo =	$valor->BANP_Codigo;
    				$cajacodigo =	$valor->CAJA_Codigo;
    				$result[] = array("banconombre" => $banconombre , "bancocodigo" => $bancocodigo , "cajacodigo" => $cajacodigo  );
    
    			}
    		}
    	}
    	echo json_encode($result);
    }


   public function obtenerCuentasProveedor(){
   	$tipo_cuenta = $this->input->post('tipo_cuenta');
   	$codigopersona = $this->input->post('codigopersona');
   	$codigobanco = $this->input->post('codigobanco');
   	
   	$result = array();
   	
   	if($codigobanco != null && count(trim($codigobanco))>0){
//    		echo "<script>alert('tipo_cuenta   :  ".$tipo_cuenta."')</script>";
   		if($tipo_cuenta == 1){
   			$sleccionCuentaCliente = $this->movimiento_model->SeleccionarCuentaCliente($codigobanco,$codigopersona);
   			$separado_por_comas = serialize($sleccionCuentaCliente);
   			//      			echo "<script>alert('aber   ".$separado_por_comas."')</script>";
   			if($separado_por_comas != "N;"){
   				$SeleccionCuenta = $this->movimiento_model->comboCuentaClienteNatural($codigobanco,$codigopersona);
   			
   			}else{
   				$SeleccionCuenta = $this->movimiento_model->comboCuenta($codigobanco,$codigopersona);
   			
   			}
   		}else{
   			$sleccionCuentaProveedor = $this->movimiento_model->SeleccionarCuentaProveedor($codigobanco,$codigopersona); // ESTO BUSCA al proveedor empresa
   			$separado_por_comas = serialize($sleccionCuentaProveedor);
   			//     			    			echo "<script>alert('aber   ".$separado_por_comas."')</script>";
   			if($separado_por_comas != "N;"){
   				/**Aca esta la empresa**/
   				$SeleccionCuenta = $this->movimiento_model->comboCuentaProve($codigobanco,$codigopersona);
   			}else{
   				/**Aca esta la Persona**/
   				$SeleccionCuenta = $this->movimiento_model->comboCuentaProveedorNatural($codigobanco,$codigopersona);
   			}
   		}
   		
   		
   			
   			 
   		if(count($SeleccionCuenta) != null){
   			foreach ($SeleccionCuenta as $indice => $valor){
   				$nombre = $valor->CUENT_NumeroEmpresa;
   				$codigo = $valor->CUENT_Codigo;
   				$result[] = array("nombrecuenta" => $nombre , "codigocuenta" => $codigo);
   		
   			}
   		}
   	}
   	echo json_encode($result);
   }
   
   
  
   
   
   public function buscarDatosDeCuenta(){
   	$nombreCuentas = $this->input->post('nombrecuentas');
   	$result = array();
	
   	$listado_cajas = $this->movimiento_model->obtener_cajadiaria($nombreCuentas);
   	if($listado_cajas !=null && count($listado_cajas)){
   		foreach($listado_cajas as $indice=>$valor){
   			$codigomoneda = $valor->moned_codigo;
   			if($codigomoneda == 1){
   				$generalmoneda= "<img src='".base_url()."images/dollar.png' width='25' height='25' border='0' style='margin-bottom:-4%' title='dolar'>";
   			}else{
   				$generalmoneda= "<img src='".base_url()."images/soles.png' width='25' height='25' border='0' style='margin-bottom:-4%' title='Soles'>";
   			}
   			$result[] = array("monedadescripcion" => $generalmoneda);
   	
   		}
   	}
   	echo json_encode($result);
   }
   
   public function buscarBancosDeCaja(){
   	$idnombrecaja = $this->input->post('idcajadiaria');
   	$result = array();
   	if($idnombrecaja!=null && count(trim($idnombrecaja))>0){
   		$listado_bancos = $this->movimiento_model->buscar_bancos_caja($idnombrecaja);
   		if($listado_bancos !=null && count($listado_bancos)){
   			foreach($listado_bancos as $indice=>$valor){
   				$banconombre		= $valor->BANC_Nombre;
   				$bancocodigo =	$valor->BANP_Codigo;
   				$cajacodigo =	$valor->CAJA_Codigo;
   				$result[] = array("banconombre" => $banconombre , "bancocodigo" => $bancocodigo , "cajacodigo" => $cajacodigo  );
   	
   			}
   		}
   	}
   	echo json_encode($result);
   }
   
   
   public function obtenerCuentasCaja(){
   	$codigocaja = $this->input->post('idcajadiaria');
   	$codigobanco = $this->input->post('idbancoscaja');
   
   	$result = array();   
   	if($codigocaja!=null && count(trim($codigocaja))>0){
   		$listado_cajas = $this->movimiento_model->buscar_caja_codigo($codigocaja,$codigobanco);
   		if($listado_cajas !=null && count($listado_cajas)){
   			foreach($listado_cajas as $indice=>$valor){
   				$numerocaja 		= $valor->CUENT_NumeroEmpresa;
   				$cuentaempresas =	$valor->CUENT_Codigo;
   				$result[] = array("numerocaja" => $numerocaja , "codigo" => $cuentaempresas  );
   
   			}
   		}
   	}
   	echo json_encode($result);
   }
   
   
   public function obtenerDatosCuentaCaja(){
   	$nombrecuentacaja = $this->input->post('nombrecuentas');
   	$result = array();
   	if($nombrecuentacaja!=null && count(trim($nombrecuentacaja))>0){
   		$listado_cajas = $this->movimiento_model->obtener_cajadiaria($nombrecuentacaja);
   		if($listado_cajas !=null && count($listado_cajas)){
   			foreach($listado_cajas as $indice=>$valor){
   				$codigomoneda = $valor->moned_codigo;
   				if($codigomoneda == 1){
//    					$generalmoneda = "$";
   					$generalmoneda= "<img src='".base_url()."images/dollar.png' width='25' height='25' border='0' style='margin-bottom:-4%' title='dolar'>";
   					
   				}else{
//    					$general = "S/.";
   					$generalmoneda= "<img src='".base_url()."images/soles.png' width='25' height='25' border='0' style='margin-bottom:-4%' title='Soles'>";
   				}
   				$monedadescripcion =	$valor->MONED_Descripcion;
   				$result[] = array("monedadescripcion" => $generalmoneda);
   	
   			}
   		}
   	}
   	echo json_encode($result);
   }
   
   
}

?>