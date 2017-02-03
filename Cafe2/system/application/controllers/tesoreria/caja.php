<?php
class Caja extends Controller{
    public function __construct(){
            parent::Controller();
    $this->load->helper('form');
    $this->load->helper('date');
    $this->load->model('maestros/proyecto_model');
    $this->load->model('maestros/directivo_model');
    $this->load->model('maestros/compania_model');
    $this->load->model('maestros/persona_model');
    $this->load->model('maestros/moneda_model');
    $this->load->model('tesoreria/banco_model');
    $this->load->model('tesoreria/caja_model');
    $this->load->model('tesoreria/tipocaja_model');
    $this->load->model('ventas/cliente_model');
    $this->load->model('seguridad/usuario_model');
    $this->load->library('html');
    $this->load->library('pagination');
    $this->load->library('layout','layout');
    $this->somevar ['compania'] = $this->session->userdata('compania');
    $this->somevar['hoy']       = mdate("%Y-%m-%d %h:%i:%s",time());
    }
    
    public function index(){
       $this->layout->view('seguridad/inicio');	
    }
    
    public function cajas($j='0'){
    	$filter = new stdClass();
    	$data['action'] 		= base_url()."index.php/tesoreria/caja/buscar_cajas";
    	$filter->CAJA_Nombre 	= $this->input->post('nombres');
    	$data['nombres']    	= $filter->CAJA_Nombre;
    	$data['titulo_tabla']   = "RESULTADO DE BUSQUEDA DE CAJAS";
    	$conf['per_page']  		= 10;
    	$conf['num_links']  	= 3;
    	$conf['next_link'] 		= "&gt;";
    	$conf['prev_link'] 		= "&lt;";
    	$conf['first_link'] 	= "&lt;&lt;";
    	$conf['last_link']  	= "&gt;&gt;";
    	$conf['uri_segment'] 	= 4;
    	$this->pagination->initialize($conf);
    	$data['paginacion'] 	= $this->pagination->create_links();
    	$listado_cajas 			= $this->caja_model->listar_cajas($conf['per_page'],$j);
    	$item        = $j+1;
    	$lista           = array();
    	if(count($listado_cajas)>0){
    		foreach($listado_cajas as $indice=>$valor){
    			$codigo        = $valor->CAJA_Codigo;
    			$nombre        = $valor->CAJA_Nombre;
    			$tipoCaja      = $valor->tipCa_codigo;
    			$tipo	       = $valor->CAJA_tipo;
    			if($tipo == 0){
    				$tipoNombre = "CAJA";
    			}elseif ($tipo == 1){
    				$tipoNombre = "BANCO";
    			}
    			if($tipoCaja != null){
    				$datosTipCaja = $this->tipocaja_model->obtenerTipocaja($tipoCaja);
    				$nombTipCaja = $datosTipCaja[0]->tipCa_Descripcion;
    			}
    			
    			$editar         = "<a href='javascript:;' onclick='editar_caja(".$codigo.")'><img src='".base_url()."images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
    			$ver            = "<a href='javascript:;' onclick='ver_caja(".$codigo.")'><img src='".base_url()."images/ver.png' width='16' height='16' border='0' title='Ver'></a>";
    			$eliminar       = "<a href='javascript:;' onclick='eliminar_caja(".$codigo.")'><img src='".base_url()."images/eliminar.png' width='16' height='16' border='0' title='Eliminar'></a>";
    			$listamultiple       = "<a href='javascript:;' onclick='listamultiple_caja(".$codigo.")'><img src='".base_url()."images/listagrupal.png' width='16' height='16' border='0' title='ListaMultiple'></a>";
    			$lista[]        = array($item,$nombre,$nombTipCaja,$tipoNombre,$editar,$ver,$eliminar,$listamultiple);
    			$item++;
    		}
    	}
    	$data['lista'] 		= $lista;
        $this->layout->view("tesoreria/caja_index",$data);
    }
    public function ver_caja($caja)
    {
    	 
    	$datos   					 = $this->caja_model->obtener_datosCaja($caja);
    	$data['nombres']             = $datos[0]->CAJA_Nombre;
    	$tipoCaja        		 	 = $datos[0]->tipCa_codigo;
    	if($tipoCaja != null){
    		$datosTipoCaja			 = $this->caja_model->obtener_datosTipoCaja($tipoCaja);
    		$data['tipoCaja']		 = $datosTipoCaja[0]->tipCa_Descripcion;
    	}
    	$data['observaciones']= $datos[0]->CAJA_Observaciones;
    	$data['datos']  			 = $datos;
    	$data['titulo'] 			 = "VER CAJA";
    	$this->load->view('tesoreria/caja_ver',$data);
    }
	
    public function listamultiple_caja($caja)
    {
    
    	$datos   					 = $this->caja_model->obtener_datosCaja($caja);
    	$data['codigo']				 = $datos[0]->CAJA_Codigo;
    	$data['nombres']             = $datos[0]->CAJA_Nombre;
    	$tipoCaja        		 	 = $datos[0]->tipCa_codigo;
    	if($tipoCaja != null){
    		$datosTipoCaja			 = $this->caja_model->obtener_datosTipoCaja($tipoCaja);
    		$data['tipoCaja']		 = $datosTipoCaja[0]->tipCa_Descripcion;
    	}
    	$data['observaciones']= $datos[0]->CAJA_Observaciones;
    	$data['datos']  			 = $datos;
//     	$data['titulo'] 			 = "VER CAJA";
    	$this->load->view('tesoreria/movimiento_index',$data);
    }
    
    public function eliminar_caja($caja){
    	$caja = $this->input->post('caja');
    	$this->caja_model->eliminar_caja($caja);
    }
    public function nueva_caja(){
    	$data['modo']  			= "insertar";
    	$objeto 				= new stdClass();
    	$objeto->id     		= "";
    	$data['datos'] 			= $objeto;
    	$data['titulo'] 		= "REGISTRAR CAJA";
    	$data['display'] 		= "";
    	$data['nombreCaja'] 	= "";
    	$data['numeroCaja'] 	= "";
    	$data['tipo_caja'] 		= "0";
    	$data['checkedCaja'] 	= "checked='checked'";
    	$data['checkedBan'] 	= "";
    	$data['url_action'] 	= base_url() . "index.php/tesoreria/caja/insertar_cuenta";
    	$compania 				= $this->session->userdata('compania');
    	$Datoscuenta  = $this->caja_model->obtener_datosCuenta_banco($compania);
    	if(is_array($Datoscuenta)){
    		foreach ($Datoscuenta as $indice => $valor){
    			    $bancoCodigo  = $valor->BANP_Codigo;
    				if($bancoCodigo != null){
    					$objetos[]= $bancoCodigo;
    				}
    			
    		}
    	}

    	$data['cboCuentas'] 	= $this->OPTION_generador($this->caja_model->listar_cuenta($compania), 'CUENT_Codigo', 'CUENT_NumeroEmpresa', '');
    	$data['cboTipCaja'] 	= $this->OPTION_generador($this->caja_model->listar_tipoCaja(), 'tipCa_codigo', 'tipCa_Descripcion', '');
    	$data['cboBancos'] 		= $this->OPTION_generador($this->banco_model->listar_banco($objetos), 'BANP_Codigo', 'BANC_Nombre', '');
//        $data['cboResponsable'] = $this->OPTION_generador($this->usuario_model->listar_usuarios(), 'USUA_Codigo','PERSC_Nombre','');
       $data['cboResponsable'] = $this->OPTION_generador($this->directivo_model->combo_directivos(), 'DIREP_Codigo','PERSC_Nombre','');
       $data['sectorista'] 	= "";
    	$data['telefono'] 		= "";
    	$data['direccion'] 		= "";
    	$data['sobregiro'] 		= "";
    	$data['cboMoneda'] 		= $this->OPTION_generador($this->moneda_model->listar(), 'MONED_Codigo', 'MONED_Descripcion', '');
    	$data['limiteRetiro'] 	= "";
    	$data['observaciones'] 	= "";
    	$data['descripcion'] 	= "";
    	$data['serie'] 			= "";
    	$data['serieNumero'] 	= "";
    	$data['detalle_cuenta'] = array();
    	$data['detalle_chequera'] = array();
    	$this->load->view("tesoreria/caja_nuevo",$data);
    }
    
    public function insertar_cuenta(){
    	/** INSERTAR DATOS DE CAJA **/
    	$nombreCaja 	= $this ->input -> post('nombreCaja');
    	$cboTipCaja		= $this ->input -> post('cboTipCaja');
    	$tipo_caja  	= $this ->input -> post('tipo_caja');
    	$cboResponsable = $this ->input -> post('cboResponsable');
    	$observaciones  = $this ->input -> post('observaciones');
    	$caja 			= $this->caja_model->insertar_datosCaja($nombreCaja,$cboTipCaja,$tipo_caja,$cboResponsable,$observaciones);
    	
    	/** INSERTAR DATOS DE  CAJA CUENTA**/
    	$cuentaCodigo  		 = $this ->input -> post('cuentaCodigo');
    	$cboCuentas    		 = $this ->input -> post('cboCuentas');
    	$cboTipoCaja 	   	 = $this ->input -> post('tipoCaja');
    	$limiteRetiro		 = $this ->input -> post('limiteRetiro');
    	$cuentaaccion  	 	 = $this ->input -> post('cuentaaccion');
    	if(is_array($cuentaCodigo)){
    		foreach ($cuentaCodigo as $indice => $valor){
    			if($valor != $cuentaCodigo){
    				$filter = new stdClass();
    				$filter ->CUENT_Codigo 	  = $cboCuentas[$indice];
    				$filter ->TIPOING_Codigo  = $cboTipoCaja[$indice];
    				$filter ->CAJCUENT_LIMITE = $limiteRetiro[$indice];
    				$filter ->CAJA_Codigo     = $caja;
    				if ($cuentaaccion[$indice] != 'e') {
    					$this->caja_model->insertar_cuenta($filter);
    				}
    			}
    		}
    	}
    	/** INSERTAR DATOS DE  CAJA CHEQUERA**/
    	$chequeraCodigo   = $this ->input -> post('chequeraCodigo');
    	$descripcion      = $this ->input -> post('descripcion');
    	$cboSerie 	      = $this ->input -> post('cboSerie');
    	$chequeaccion     = $this ->input -> post('chequeaccion');
    	if(is_array($chequeraCodigo)){
    		foreach ($chequeraCodigo as $indice => $valor){
    			if($valor != $chequeraCodigo){
    				$filter = new stdClass();
    				$filter ->CAJCHEK_Descripcion  = $descripcion[$indice];
    				$filter ->CAJA_Codigo 	  	   = $caja;
    				$filter ->CHEK_Codigo 	  	   = $cboSerie[$indice];
    				if ($chequeaccion[$indice] != 'e') {
    					$this->caja_model->insertar_chekera($filter);
    				}
    			}
    		}
       }
       $this->cajas();    
    }
    
    public function editar_caja($caja){
    	
    	$data['modo']	 = "modificar";
    	$data['id']	  	 = $this->input->post('id');
    	$data['titulo']  = "MODIFICAR CAJA";
    	$data['display'] = "";
    	$datos_caja      = $this->caja_model->obtener_datosCaja($caja);
    	$codigoCaja		 = $datos_caja[0]->CAJA_Codigo;
    	$cboTipCaja		 = $datos_caja[0]->tipCa_codigo;
    	$nombreCaja   	 = $datos_caja[0]->CAJA_Nombre;
    	$cboResponsable  = $datos_caja[0]->CODIGO_Directorio;
    	//echo "<script>alert('EditarCara : ".$cboResponsable."')</script>";
    	$observaciones   = $datos_caja[0]->CAJA_Observaciones;    	
    	$objeto                 = new stdClass();
    	$objeto->id             = $datos_caja[0]->CAJA_Codigo;
    	$data['datos']    		= $objeto;
    	$data['nombreCaja']   	= $nombreCaja;
//     	$data['cboResponsable'] = $this->OPTION_generador($this->usuario_model->listar_usuarios(), 'USUA_Codigo','PERSC_Nombre',$datos_caja[0]->USUA_Codigo);
    	$data['cboResponsable'] = $this->OPTION_generador($this->directivo_model->combo_directivos(), 'DIREP_Codigo','PERSC_Nombre',$datos_caja[0]->CODIGO_Directorio);
    	$data['cboTipCaja'] 	= $this->OPTION_generador($this->caja_model->listar_tipoCaja(), 'tipCa_codigo', 'tipCa_Descripcion', $datos_caja[0]->tipCa_codigo);
    	$data['observaciones']  = $observaciones;    	
    	$compania 				= $this->session->userdata('compania');
    	$Datoscuenta  = $this->caja_model->obtener_datosCuenta_banco($compania);
    	if(is_array($Datoscuenta)){
    		foreach ($Datoscuenta as $indice => $valor){
    			//if($valor != $Datoscuenta){
    				$bancoCodigo  = $valor->BANP_Codigo;
    				if($bancoCodigo != null){
    					$objetos[]= $bancoCodigo;
    			//	}
    			}
    		}
    	}
    	$data['cboBancos'] 		= $this->OPTION_generador($this->banco_model->listar_banco($objetos), 'BANP_Codigo', 'BANC_Nombre', '');
    	$data['limiteRetiro'] 	= "";
    	$data['descripcion'] 	= "";
    	
    	/** OBTENER DATOS DE CAJA CUENTA **/
    	$detalle_cuenta 	  		= $this->listar_detalle_cuenta($caja);
    	$data['detalle_cuenta']     = $detalle_cuenta;
    	//$data['detalle_cuenta'] = $this->caja_model->obtener_cuenta_caja2($caja);
    	/** OBTENER DATOS DE CHEQUERA CUENTA **/
    	$detalle_chequera 	  		= $this->listar_detalle_chequera($caja);
    	$data['detalle_chequera']     = $detalle_chequera;
    	
    	
    	$this->load->view("tesoreria/caja_nuevo",$data);

		
    }
    
    public function modificar_caja()
    {
    	/** MODIFICAR DATOS DE CAJA **/
    	$codigo             = $this ->input -> post('caja');
    	$nombreCaja 		= $this ->input -> post('nombreCaja');
    	$cboTipCaja			= $this ->input -> post('cboTipCaja');
    	$tipo_caja  		= $this ->input -> post('tipo_caja');
    	$cboResponsable 	= $this ->input -> post('cboResponsable');
    	$observaciones  	= $this ->input -> post('observaciones');
    	$caja 				= $this->caja_model->modificar_datosCaja($codigo,$nombreCaja,$cboTipCaja,$tipo_caja,$cboResponsable,$observaciones);
    	
    	/** MODIFICAR DATOS DE CUENTA **/
    	$cuentaCodigo  		 = $this ->input -> post('cuentaCodigo');
    	$cboCuentas    		 = $this ->input -> post('cboCuentas');
    	$cboTipoCaja 	   	 = $this ->input -> post('tipoCaja');
    	$limiteRetiro		 = $this ->input -> post('limiteRetiro');
    	$cuentaaccion  	 	 = $this ->input -> post('cuentaaccion');
    	if(is_array($cuentaCodigo)){
    		foreach ($cuentaCodigo as $indice => $valor){
    			if($valor != $cuentaCodigo){
    				$detalle_accion = $cuentaaccion[$indice];
    				$filter = new stdClass();
    				$filter ->CUENT_Codigo 	  = $cboCuentas[$indice];
    				$filter ->TIPOING_Codigo  = $cboTipoCaja[$indice];
    				$filter ->CAJCUENT_LIMITE = $limiteRetiro[$indice];
    				$filter ->CAJA_Codigo     = $codigo;
    				    				
    				if ($detalle_accion == 'n') {
    					$this->caja_model->insertar_cuenta($filter);
    				} elseif ($detalle_accion == 'm') {
    					$this->caja_model->modificar_cuenta($valor, $filter);
    				} elseif ($detalle_accion == 'e') {
    					$this->caja_model->eliminar_cuenta($valor);
    				}
    			}
    		}
    	}
    	
    	/** MODIFICAR DATOS DE  CHEQUERA**/
    	$chequeraCodigo   = $this ->input -> post('chequeraCodigo');
    	$descripcion      = $this ->input -> post('descripcion');
    	$cboSerie 	      = $this ->input -> post('cboSerie');
    	$chequeaccion     = $this ->input -> post('chequeaccion');
    	if(is_array($chequeraCodigo)){
    		foreach ($chequeraCodigo as $indice => $valor){
    			if($valor != $chequeraCodigo){
    				$detalle_accion = $chequeaccion[$indice];
    				$filter = new stdClass();
    				$filter ->CAJCHEK_Descripcion  = $descripcion[$indice];
    				$filter ->CAJA_Codigo 	  	   = $codigo;
    				$filter ->CHEK_Codigo 	  	   = $cboSerie[$indice];
    				
    				if ($detalle_accion == 'n') {
    					$this->caja_model->insertar_chekera($filter);
    				} elseif ($detalle_accion == 'm') {
    					$this->caja_model->modificar_chekera($valor, $filter);
    				} elseif ($detalle_accion == 'e') {
    					$this->caja_model->eliminar_chekera($valor);
    				}
    				
    			}
    		}
    	}
    	
    	
    	
    }
    
    public function listar_detalle_cuenta($caja){
    	$detalle = $this->caja_model->obtener_cuenta_caja($caja);
    	$lista_detalles = array();
    	if (count($detalle) > 0) {
    		foreach ($detalle as $indice => $valor) {
    			$cajaCuentaCodigo 	  = $valor->CAJCUENT_Codigo;
    			$cboCuentas			  = $valor->CUENT_Codigo;
    			$limiteRetiro		  = $valor->CAJCUENT_LIMITE;
    			$tipoCaja			  = $valor->TIPOING_Codigo;
                $caja_Codigo          = $valor->CAJA_Codigo;

    			if($tipoCaja == 1){
    				$tipoNombre = "INGRESO";
    			}elseif ($tipoCaja == 2){
    				$tipoNombre = "SALIDA";
    			}
    		if($cboCuentas != null){
    				$Datoscuenta  = $this->caja_model->obtener_datosCuenta($cboCuentas);
    				$bancoCodigo  = $Datoscuenta[0]->BANP_Codigo;
    				$numroCuenta  = $Datoscuenta[0]->CUENT_NumeroEmpresa;
    				$tipCuenta	  = $Datoscuenta[0]->CUENT_TipoCuenta;
    				if($bancoCodigo != null){
    					$datosBanco   = $this->banco_model->obtener($bancoCodigo);
    					$bancoNombre  = $datosBanco[0]->BANC_Nombre;
    				}
    				if($tipCuenta == 1){
    					$tipCuentaNombre = "AHORROS";
    				}elseif ($tipCuenta == 2){
    					$tipCuentaNombre = "CORRIENTE";
    				}
    				$moneda		  = $Datoscuenta[0]->MONED_Codigo;
    				if($moneda != null){
    					$datosMoneda  = $this->moneda_model->obtener($moneda);
    					$monedaNombre = $datosMoneda[0]->MONED_Descripcion;
    				}
    			}
    			
      $objeto = new stdClass();
                $objeto->CAJCUENT_Codigo     = $cajaCuentaCodigo;
                $objeto->BANP_Codigo         = $bancoCodigo;
                $objeto->CUENT_Codigo        = $cboCuentas;
                $objeto->CUENT_NumeroEmpresa = $numroCuenta;
                $objeto->CUENT_TipoCuenta    = $tipCuenta;
                $objeto->CUENT_TipoCuenta    = $tipCuentaNombre;
                $objeto->MONED_Codigo        = $moneda;
                $objeto->MONED_Descripcion   = $monedaNombre;
                $objeto->CAJCUENT_LIMITE     = $limiteRetiro;
                $objeto->TIPOING_Codigo      = $tipoCaja;
                $objeto->TIPOING_Codigo      = $tipoNombre;
                $objeto->BANC_Nombre         = $bancoNombre;
                $objeto->TIPOING_C           = $tipoCaja;
                $objeto->CAJA_Codigo         =$caja_Codigo;
                $lista_detalles[] = $objeto;
    			
    		}

    	}

    	return $lista_detalles;
    }
    
    public function listar_detalle_chequera($caja) {
    	$detalle = $this->caja_model->obtener_cuenta_chequera($caja);
    	$lista_detalles = array();
    	if (count($detalle) > 0) {
    		foreach ($detalle as $indice => $valor) {
    			$chequeraCuentaCodigo 	  = $valor->CAJCHEK_Codigo;
    			$descripcion		  	  = $valor->CAJCHEK_Descripcion;
    			$cboSerie		  	  	  = $valor->CHEK_Codigo;
    			if($cboSerie != null){
    				$Datoschequera  = $this->caja_model->obtener_chequeraCodigo($cboSerie);
    				$serieChequera  = $Datoschequera[0]->SERIP_Codigo;
    				$numroSerie     = $Datoschequera[0]->CHEK_Numero;
    				$serie 			= $serieChequera."-".$numroSerie;
    			}
    			if($caja != null){
    				$cuentaCaja  = $this->caja_model->obtener_cuenta_caja($caja);
    				$cuenta		  = $cuentaCaja[0]->CUENT_Codigo;
    				if($cuenta != null){
    					$Datoscuenta  = $this->caja_model->obtener_datosCuenta($cuenta);
    					$bancoCodigo  = $Datoscuenta[0]->BANP_Codigo;
    					$numroCuenta  = $Datoscuenta[0]->CUENT_NumeroEmpresa;
    				}
    				
    			}
    			
    			if($bancoCodigo != null){
    				$datosBanco   = $this->banco_model->obtener($bancoCodigo);
    				$bancoNombre  = $datosBanco[0]->BANC_Nombre;
    			}
    
    			$objeto = new stdClass();
    			$objeto->CAJCHEK_Codigo	 	 = $chequeraCuentaCodigo;
    			$objeto->CUENT_Codigo 		 = $cuenta;
    			$objeto->CAJCHEK_Descripcion = $descripcion;
    			$objeto->BANP_Codigo 		 = $bancoCodigo;
    			$objeto->BANC_Nombre		 = $bancoNombre;
    			$objeto->CUENT_NumeroEmpresa = $numroCuenta;
    			$objeto->SERIP_Codigo        = $serieChequera;
    			$objeto->CHEK_Numero		 = $numroSerie;
    			$objeto->CHEK_Codigo		 = $cboSerie;
				$objeto->SERIP_Codigo		 = $serie;
    			$lista_detalles[] = $objeto;
    		}
    	}
    	return $lista_detalles;
    }
    
    public function cargar_cuenta($banco){
    	$cboCuentas = $this->seleccionar_cuenta_banco($banco);
    	$fila  ="<select id='cboCuentas' name='cboCuentas' class='comboMedio'>";
    	//$fila .="<option value=''> ::Seleccione:: </option>";
    	$fila .= $cboCuentas;
    	$fila .= "</select>";
    	echo $fila;
    }
   //////////////////////////////////////////////////////////////// 
    public function cargarCuentaEmpresa($codigoD,$index){
    $cboCuentas = $this->seleccionar_cuenta_banco($codigoD,$index);
    $fila  ="<select id='cboCuentas' name='cboCuentas' class='comboMedio'>";
        //$fila .="<option value=''> ::Seleccione:: </option>";
    $fila .= $cboCuentas;
    $fila .= "</select>";
    echo $fila;
     
    }
    public function cargarCuentaBanco($codigo){

    }
    public function cargar_cuentaCheque($banco){
    	$cboCuentaCheque = $this->seleccionar_cuenta_banco($banco);
    	$fila  = "<select id='cboCuentaCheque' name='cboCuentaCheque' class='comboMedio' onchange='cargar_serieCuenta(this);'>";
    	//$fila .="<option value=''> ::Seleccione:: </option>";
    	$fila .=$cboCuentaCheque;
    	$fila .= "</select>";
    	echo $fila;
    }
    
    public function cargar_datosCuenta($cuenta){
    	$Datoscuenta  = $this->caja_model->obtener_datosCuenta($cuenta);
    	$tipCuenta	  = $Datoscuenta[0]->CUENT_TipoCuenta;
    	$moneda		  = $Datoscuenta[0]->MONED_Codigo;
    	if($tipCuenta == 1){
    		$nomTipCuenta = "AHORRO";
    	}elseif ($tipCuenta == 2){
    		$nomTipCuenta = "CORRIENTE";
    	}
    	$DatosMoneda  = $this->moneda_model->obtener($moneda);
    	$monedaNom	  = $DatosMoneda[0]->MONED_Descripcion;
    	$fila	      = "<input name='tipCuenta' type='text' class='cajaGeneral' disabled	id='tipCuenta' maxlength='150' value='$nomTipCuenta'>";
    	$fila	      .= "&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;Moneda&nbsp; &nbsp;&nbsp;";
    	$fila	      .= "<input name='monedaCuenta' type='text' class='cajaGeneral' disabled id='monedaCuenta' maxlength='150' value='$monedaNom'>";
    	echo $fila;


    }
    
 	public function cargar_serie($serie){
    	$cboSerie = $this->caja_model->obtener_numeroSerie($serie);
    	$numero   = $numeroSerie[0]->CHEK_Numero;
    	$fila     = "<input name='serieNumero' type='text' class='cajaGeneral'  disabled id='serieNumero' maxlength='150' value='$numero'>";
    	echo $fila;
                      						  
    }
    
    public function cargar_serieCuenta($cuenta){
    	$cboSerie  = $this->seleccionar_chequera($cuenta);
    	$fila = "<select id='cboSerie' name='cboSerie' class='comboMedio'>";
    	///$fila .="<option value=''> ::Seleccione:: </option>";
    	$fila .= $cboSerie;
    	$fila .= "</select>";
    	echo $fila;
    	
    }
    
    public function cargar_banco($banco){
    	$cboBancoCuenta = $this->seleccionar_banco_cuenta($banco);
    	$fila 			= "<select id='cboBancoCuenta' name='cboBancoCuenta' class='comboMedio'>";
    	//$fila 		   .="<option value=''> ::Seleccione:: </option>";
    	$fila 		   .=  $cboBancoCuenta; 
    	$fila 		   .= "</select>";
    	echo $fila;
    }
    
    public function cargar_chequera($cuenta){
    	$cboSerie  = $this->seleccionar_chequera($cuenta);
    	$fila  = "<select id='cboSerie' name='cboSerie' class='comboMedio'>";
    	//$fila .="<option value=''> ::Seleccione:: </option>";
    	$fila .= $cboSerie;
    	$fila .= "</select>";
    	echo $fila;
    }
    
    public function seleccionar_chequera($cuenta){
    	$chequera = $this->caja_model->listar_chequera($cuenta);
    	$arreglo = array();
    	if(count($chequera)>0){
    		foreach($chequera as $indice=>$valor){
    			$indice1   = $valor->CHEK_Codigo;
    			$valor1    = $valor->SERIP_Codigo;
    			$valor2    = $valor->CHEK_Numero;
    			$arreglo[$indice1] = $valor1."-".$valor2;
    		}
    	}
    	$resultado = $this->html->optionHTML($arreglo,array('00','::Seleccione::'));
    	return $resultado;
    }
	
    public function cargar_tabla_cuenta($cuenta){
    	if($cuenta != null){
    		$Datoscuenta  = $this->caja_model->obtener_datosCuenta($cuenta);
    		$monedaCodigo = $Datoscuenta[0]->MONED_Codigo;
    		$bancoCodigo  = $Datoscuenta[0]->BANP_Codigo;
    		$compania = $this->session->userdata('compania');
    		$cboCuentas   = $this->seleccionar_cuenta($compania);
    		$cbo_banco 	  = $this->seleccionar_banco($bancoCodigo);
    		$cbo_moneda   = $this->seleccionar_moneda($monedaCodigo);
    		$fila	      = "<tr>";
    		$fila	      .= "<td>Bancos</td>";
    		$fila	      .= "<td>";
    		$fila     	  .= "<select id='cboBancos' name='cboBancos' class='comboMedio'>";
    		$fila 		  .="<option value=''> ::Seleccione:: </option>";
    		$fila    	  .= $cbo_banco;
    		$fila    	  .= "</select>&nbsp;&nbsp;";
    		$fila	      .= "</td>";
    		$fila	      .= "<td>Moneda</td>";
    		$fila	      .= "<td>";
    		$fila    	  .= "<select id='cboMoneda' name='cboMoneda' class='comboMedio'>";
    		$fila    	  .= $cbo_moneda;
    		$fila    	  .= "</select>&nbsp;&nbsp;";
    		$fila	      .= "</td>";
    		$fila	      .= "</tr>";
    		echo $fila;
    	}
    	
    }

    public function seleccionar_cuenta($compania){
    	$cuenta = $this->caja_model->listar_cuenta($compania);
    	$arreglo = array();
    	if(count($cuenta)>0){
    		foreach($cuenta as $indice=>$valor){
    			$indice1   = $valor->CUENT_Codigo;
    			$valor1    = $valor->CUENT_NumeroEmpresa;
    			$arreglo[$indice1] = $valor1;
    		}
    	}
    	$resultado = $this->html->optionHTML($arreglo,array('00','::Seleccione::'));
    	return $resultado;
    }
    
    public function seleccionar_cuenta_banco($banco="",$index=""){
    	$cuenta = $this->caja_model->listar_cuenta_banco($banco);
    	$arreglo = array();
    	if(count($cuenta)>0){
    		foreach($cuenta as $indice=>$valor){
    			$indice1   = $valor->CUENT_Codigo;
    			$valor1    = $valor->CUENT_NumeroEmpresa;
    			$arreglo[$indice1] = $valor1;
    		}
    	}
    	$resultado = $this->html->optionHTML($arreglo,$index,array('00','::Seleccione::'));
    	return $resultado;
    }
    
    public function seleccionar_banco($cuenta){
    	$bancos = $this->caja_model->listar_banco_cuenta($cuenta);
    	$arreglo = array();
    	if(count($bancos)>0){
    		foreach($bancos as $indice=>$valor){
    			$indice1   = $valor->BANP_Codigo;
    			$valor1    = $valor->BANC_Nombre;
    			$arreglo[$indice1] = $valor1;
    		}
    	}
    	$resultado = $this->html->optionHTML($arreglo,array('00','::Seleccione::'));
    	return $resultado;
    }
    
    public function seleccionar_banco_cuenta($banco){
    	$bancos = $this->caja_model->listar_banco_cuenta($banco);
    	$arreglo = array();
    	if(count($bancos)>0){
    		foreach($bancos as $indice=>$valor){
    			$indice1   = $valor->BANP_Codigo;
    			$valor1    = $valor->BANC_Nombre;
    			$arreglo[$indice1] = $valor1;
    		}
    	}
    	$resultado = $this->html->optionHTML($arreglo,array('00','::Seleccione::'));
    	return $resultado;
    }
    public function seleccionar_CuentaEmpresa($codigo,$indSel=''){
    $array_area = $this->caja_model->getCajaDetalleCuentaEmpresa($codigo);
        $arreglo = array();
        foreach($array_area as $indice=>$valor){
                $indice1   = $valor->CUENT_Codigo;
                $valor1    = $valor->CUENT_NumeroEmpresa;
                $arreglo[$indice1] = $valor1;
        }
        $resultado = $this->html->optionHTML($arreglo,$indSel,array('00','::Seleccione::'));
        return $resultado;
    }
    
    public function seleccionar_moneda($cuenta){
    	$moneda = $this->caja_model->listar_moneda_cuenta($cuenta);
    	$arreglo = array();
    	if(count($moneda)>0){
    		foreach($moneda as $indice=>$valor){
    			$indice1   = $valor->MONED_Codigo;
    			$valor1    = $valor->MONED_Descripcion;
    			$arreglo[$indice1] = $valor1;
    		}
    	}
    	$resultado = $this->html->optionHTML($arreglo,array('00','::Seleccione::'));
    	return $resultado;
    }


}       
?>