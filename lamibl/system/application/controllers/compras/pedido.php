<?php
class Pedido extends Controller{
    public function __construct()
    {
        parent::Controller();
        $this->load->model('compras/cotizacion_model');
        $this->load->model('compras/proveedor_model');
        $this->load->model('maestros/persona_model');
        $this->load->model('maestros/documento_model');
        $this->load->model('maestros/empresa_model');
        $this->load->model('maestros/proyecto_model');
		$this->load->model('maestros/emprcontacto_model');
        $this->load->model('maestros/formapago_model');
        $this->load->model('maestros/condicionentrega_model');
        $this->load->model('compras/pedido_model');
        $this->load->model('compras/pedidodetalle_model');
        $this->load->model('maestros/centrocosto_model');
        $this->load->model('maestros/moneda_model');
        $this->load->model('almacen/producto_model');
        $this->load->model('almacen/unidadmedida_model');
        $this->load->model('almacen/almacen_model');
        $this->load->model('seguridad/usuario_model');
        $this->load->model('compras/presupuesto_model');
		$this->load->model('ventas/cliente_model');
        $this->load->helper('json');
        $this->load->library('html');
        $this->load->library('table');
        $this->load->library('layout','layout');
        $this->load->library('pagination');
        $this->load->helper('form');
		 $this->somevar['compania'] = $this->session->userdata('compania');
        $this->somevar['user'] = $this->session->userdata('user');
        $this->somevar['rol'] = $this->session->userdata('rol');
        $this->somevar['url'] = $_SERVER['REQUEST_URI'];
        $this->somevar['hoy']       = mdate("%Y-%m-%d",time());
        date_default_timezone_set("America/Lima");

    }
    public function index()
    {
        $this->layout->view('seguridad/inicio');    
    }
    //holas
        public function pedidos($j=0){
        	

        	$filter = new stdClass();
        	if (count($_POST) > 0) {
        		$filter->fechai = $this->input->post('fechai');
        		$filter->fechaf = $this->input->post('fechaf');
        		$filter->numero = $this->input->post('txtNumDoc');
        		$filter->cliente = $this->input->post('cliente');
        		$filter->ruc_cliente = $this->input->post('ruc_cliente');
        		$filter->nombre_cliente = $this->input->post('nombre_cliente');
        	
        	} else {
        		$filter->fechai = "";
        		$filter->fechaf = "";
        		$filter->numero = "";
        		$filter->cliente = "";
        		$filter->ruc_cliente = "";
        		$filter->nombre_cliente = "";
        	}
        	$data['numdoc'] = $filter->numero;
        	$data['fechai'] = $filter->fechai;
        	$data['fechaf'] = $filter->fechaf;
        	$data['cliente'] = $filter->cliente;
        	$data['ruc_cliente'] = $filter->ruc_cliente;
        	$data['nombre_cliente'] = $filter->nombre_cliente;
            
            
            $data['titulo_tabla']    = "RELACÓN DE PEDIDOS / REQUERIMIENTOS";
            $data['registros']  = count($this->pedido_model->listar_pedidos_todos($filter));
            $data['action'] = base_url()."index.php/compras/pedido/pedidos";
            $conf['base_url']   = site_url('maestros/compras/pedidos/');
            $conf['total_rows'] = $data['registros'];
            $conf['per_page']   = 50;
            $conf['num_links']  = 3;
            $conf['next_link'] = "&gt;";
            $conf['prev_link'] = "&lt;";
            $conf['first_link'] = "&lt;&lt;";
            $conf['last_link']  = "&gt;&gt;";
            $conf['uri_segment'] = 4;
            $this->pagination->initialize($conf);
            $data['paginacion'] = $this->pagination->create_links();
            $listado_pedidos = $this->pedido_model->listar_pedidos_todos($filter,$conf['per_page'],$j);
            $item            = $j+1;
            $lista           = array();
        if(count($listado_pedidos)>0){
                foreach($listado_pedidos as $indice=>$valor){
                    $codigo   = $valor->PEDIP_Codigo;
                   $numero  =  $this->getOrderNumero($valor->PEDIC_Numero);
                   $serie  =  $this->getOrderSerie($valor->PEDIC_Serie);
					$relacion  = $valor->PEDIC_EstadoPresupuesto;
					$codigocliente   = $valor->CLIP_Codigo;//
					$numeropresupuesto = $valor->PRESUC_Serie."-".$valor->PRESUC_Numero;//
					$buscarcliente = $this->cliente_model->obtener_datosCliente($codigocliente);
					$nombrededos = " ";
					foreach ($buscarcliente as $indice2=>$valor2){
						$tipopersona = $valor2->CLIC_TipoPersona;
							
						if($tipopersona == 1){
							$codigoempresa = $valor2->EMPRP_Codigo;
							$buscarempresa = $this->cliente_model->obtener_datosCliente2($codigoempresa);
							foreach ($buscarempresa as $indice3 => $valor3){
									$nombrededos = $valor3->EMPRC_RazonSocial;
							}
						}else{
							$codigopersona = $valor2->PERSP_Codigo;
							$buscarpersona = $this->cliente_model->obtener_datosCliente3($codigopersona);
							foreach ($buscarpersona as $indice4 => $valor4){
								$nombre = $valor4->PERSC_Nombre;
								$ap =$valor4->PERSC_ApellidoPaterno;
								$am =$valor4->PERSC_ApellidoMaterno;
								$nombrededos = $nombre." ".$ap." ".$am;
							}
						}
					}
						
                    $codigoproyecto   = $valor->PROYP_Codigo;
					$buscarproyecto = $this->proyecto_model->obtener_NAMEProyecto($codigoproyecto);
					$nombreproyecto = "";
					if(count($buscarproyecto) >0){
						foreach ($buscarproyecto as $indice1=>$valor1){
							$nombreproyecto = $valor1->PROYC_Nombre;	
						}
					}
					
// 					$nombreproyecto=   ;
					$ConversorDeNumero=1;
					$imp = 1;
					$tipo_oper2='"V"';
					
                    $editar         = "<a href='javascript:;' onclick='editar_pedido(".$codigo.")'><img src='".base_url()."images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
					$eliminar       = "<a href='javascript:;' onclick='eliminar_pedido(".$codigo.")'><img src='".base_url()."images/eliminar.png' width='16' height='16' border='0' title='Eliminar'></a>";
                                        $ver2 = "<a href='javascript:;' onclick='comprobante_ver_pdf_conmenbrete(" . $codigo .",".$ConversorDeNumero.",0,".$tipo_oper2.")'  target='_parent'><img src='" . base_url() . "images/imprimir.png' width='16' height='16' border='0' title='Ver PDF'></a>";
					
					$ver = "<a href='javascript:;' onclick='comprobante_ver_pdf_conmenbrete(" . $codigo .",".$ConversorDeNumero.",".$imp.",".$tipo_oper2.")'  target='_parent'><img src='" . base_url() . "images/pdf.png' width='16' height='16' border='0' title='Ver PDF'></a>";
					
                    $lista[]        = array($item,$serie,$this->getOrderNumeroSerie($numero),$nombrededos,$nombreproyecto,$editar,$ver,$eliminar,$relacion,$numeropresupuesto,$ver2);
                    $item++;
                }
            }
         
          $data['lista'] = $lista;
          $this->layout->view("compras/pedido_index",$data);
    }

   public function nuevo_pedido($tipo_oper='C')
    {
		  $compania = $this->somevar['compania'];
		 $comp_confi = $this->companiaconfiguracion_model->obtener($compania);
        $combo = '';

        $combomoneda="";
        $listadomoneda = $this->moneda_model->listartipomoneda();
        if(count($listadomoneda) > 0){
        	foreach($listadomoneda as $indices=>$valorm){
        		$codigom   = $valorm->moned_codigo;
        		$descripcionm   = $valorm->moned_descripcion;
        		$combomoneda .= '<option value="'.$codigom.'">'.$descripcionm.'</option>';
        	}
        }
		 $accion = "insertar";
        $modo = "insertar";
		 $codigo = "";
        $data = array();
        $hoy = date("Y-m-d");
		$data['contiene_igv'] = (($comp_confi[0]->COMPCONFIC_PrecioContieneIgv == '1') ? true : false);
        
         $data['cboContacto'] = form_dropdown("contacto", array('' => ':: Seleccione ::'), "", " class='comboGrande'  id='contacto'");
		 $data['cboObra'] = form_dropdown("obra", array('' => ':: Seleccione ::'), "", " class='comboGrande'  id='obra' ' ");//onchange='buscar_contacto()
		$data['fechai'] = form_input(array("name" => "fechai", "id" => "fechai", "class" => "cajaPequena", "readonly" => "readonly", "maxlength" => "10", "value" => "$hoy"));
        $document = $this->pedido_model->traerNumeroDoc();
		$docum = $this->pedido_model->traerSerieDoc();
        $data['numero'] = "";
		 $data['serie'] = "" ;
		 $data['tipo_oper'] = $tipo_oper;
        $data['cliente'] = "";
        $data['ruc_cliente'] = "";
		$data['modo'] = "";
        $data['id'] = "";
        $data['nombre_cliente'] = "";
		 $data['descuento'] = "0";
		 $data['preciototal'] = "0";
		 $data['descuentotal'] = "0";
		 $data['igvtotal'] = "0";
		 $data['importetotal'] = "0";
		 $data['detalle_pedido'] = array();
		 $oculto = form_hidden(array('accion' => $accion, 'codigo' => $codigo, 'empresa' => '', 'persona' => '', 'modo' => $modo, 'base_url' => base_url(), 'tipo_oper' => $tipo_oper, 'contiene_igv' => ($data['contiene_igv'] == true ? '1' : '0')));
        
        $data['oculto'] = $oculto;
		 
      $data['igv'] = $comp_confi[0]->COMPCONFIC_Igv;
        $data['contacto'] = "";
        $data['modo'] = 'insertar';
		$data['num_refe'] = '';
        $data['compania'] = $this->somevar['compania'];
        $data['combomoneda'] = $combomoneda;
        $data['importebruto'] ="";
       $data['codigo'] ='';
        $data["serie_numero_orden"]="";
        $compania = $this->somevar['compania'];
        $cofiguracion_datos = $this->configuracion_model->obtener_numero_documento($compania, 1);
        $data['serie_suger'] = $cofiguracion_datos[0]->CONFIC_Serie;
        $data['numero_suger'] = $this->getOrderNumeroSerie($cofiguracion_datos[0]->CONFIC_Numero + 1);
        $data['vventa'] ="";
        $data['titulo'] = "REGISTRAR PEDIDOS / REQUERIMIENTOS";
        $data['array_detalle'] = array();
        $this->layout->view("compras/pedido_nuevo",$data);
    }

 
    
   public function editar_pedido($pedido,$j='0'){
   	$data['modo'] = 'modificar';
   	$data['titulo'] = "EDITAR PEDIDO";
   	 $data['codigo'] ='';
   $data['numero_suger'] ='';
     $data['serie_suger'] ='';
        $datos_pedido = $this->pedido_model->obtener_pedido($pedido);
        $data['id'] = "";
       
        $codigopedido = $datos_pedido[0]->PEDIP_Codigo;
        $numero=$datos_pedido[0]->PEDIC_Numero;
        $serie= $datos_pedido[0]->PEDIC_Serie;
        $data['numero'] = $numero;
        $data['serie'] = $serie;
        $data['igv'] = $datos_pedido[0]->PEDIC_IGV;
        $tipo_oper='C';
        $data['tipo_oper'] = $tipo_oper;
        $data['descuento'] = $datos_pedido[0]->PEDIC_Descuento100;
        $data['importetotal'] = "0";
        $compania = $this->somevar['compania'];
        $comp_confi = $this->companiaconfiguracion_model->obtener($compania);
        $data['contiene_igv'] = (($comp_confi[0]->COMPCONFIC_PrecioContieneIgv == '1') ? true : false);
        $data['compania'] = $this->somevar['compania'];
        
        $codigomoneda = $datos_pedido[0]->MONED_Codigo;
        $data['combomoneda'] =  $this->OPTION_generador($this->moneda_model->listartipomoneda(), 'moned_codigo','moned_descripcion',$codigomoneda);
        
        $codigocliente = $datos_pedido[0]->CLIP_Codigo;
        $codigoproyecto = $datos_pedido[0]->PROYP_Codigo;
        
        if($codigoproyecto != 0){
        	$listaproyecto = $this->proyecto_model->seleccionar($codigocliente);
        	$data['cboObra'] = form_dropdown("obra",$listaproyecto,$codigoproyecto, " class='comboGrande'  id='obra' ");
        }else{
        	$data['cboObra'] = form_dropdown("obra", array('' => ':: Seleccione ::'), "", " class='comboGrande'  id='obra'");
        }
        
        
        $contacto = $datos_pedido[0]->ECONP_Contacto;
        if($contacto != 0){
        	$listacontacto = $this->proyecto_model->seleccionarcontacto($contacto);
        	$data['cboContacto'] = form_dropdown("contacto", $listacontacto, $contacto, " class='comboGrande'  id='contacto'");
        }else{
        	$data['cboContacto'] = form_dropdown("contacto", array('' => ':: Seleccione ::'), "", " class='comboGrande'  id='contacto'");
        }
       
        $fecha_hora = explode(" ", $datos_pedido[0]->PEDIC_FechaRegistro);
        $data['hora'] = $fecha_hora[1];
        $data['fechai'] = form_input(array("name" => "fechai", "id" => "fechai", "class" => "cajaPequena", "readonly" => "readonly", "maxlength" => "10", "value" => "$fecha_hora[0]"));
        
        $datos_cliente = $this->cliente_model->obtener($datos_pedido[0]->CLIP_Codigo);
                $nombre_cliente = $datos_cliente->nombre;
                $ruc_cliente = $datos_cliente->ruc;
            $data['ruc_cliente'] = $ruc_cliente;
            $data['nombre_cliente'] = $nombre_cliente;
            $data['cliente'] =$codigocliente;
            
            
            $accion = "";
            $modo = "modificar";
            $oculto = form_hidden(array('accion' => $accion, 'codigo' => $codigopedido, 'empresa' => '', 'persona' => '', 'modo' => $modo, 'base_url' => base_url(), 'tipo_oper' => $tipo_oper, 'contiene_igv' => ($data['contiene_igv'] == true ? '1' : '0'))); 
            $data['oculto'] = $oculto;
           
        
            $data['importebruto'] = $datos_pedido[0]->PEDIC_ImporteBruto;
            $data['descuentotal'] = $datos_pedido[0]->PEDIC_DescuentoTotal;
            $data['vventa'] = $datos_pedido[0]->PEDIC_ValorVenta;
            $data['igvtotal'] = $datos_pedido[0]->PEDIC_IGVTotal;
            $data['preciototal'] = $datos_pedido[0]->PEDIC_PrecioTotal;

        $detalle_pedido = $this->obtener_detalle_lista($codigopedido);
        $data['detalle_pedido'] = $detalle_pedido;
        $this->load->view("compras/pedido_nuevo",$data);
    }

   public function modificar_pedido(){
   	$pedido = $this->input->post('codigo');
   	
   	$filter = new stdClass();
   	$filter->PEDIC_Numero = $this->input->post('numero');
   	$filter->PEDIC_Serie = $this->input->post('serie');
   	$filter->CLIP_Codigo =$this->input->post('cliente');
       // $fecha = $this->input->post('fechai');
   	$filter->ECONP_Contacto = $this->input->post('contacto');
   	$filter->PROYP_Codigo = $this->input->post('obra');
   	$filter->MONED_Codigo = $this->input->post('moneda');
   	
   	$filter->PEDIC_ImporteBruto =$this->input->post('importebruto');
   	$filter->PEDIC_DescuentoTotal =$this->input->post('descuentotal');
   	$filter->PEDIC_ValorVenta =$this->input->post('vventa');
   	$filter->PEDIC_IGVTotal =$this->input->post('igvtotal');
   	$filter->PEDIC_PrecioTotal =$this->input->post('preciototal');
   	$filter->PEDIC_descuento100 = $this->input->post('descuento');
        
    $this->pedido_model->modificar_pedido($pedido,$filter);
    
    //detalle
    $prodcodigo = $this->input->post('prodcodigo');
    $proddescuento = $this->input->post('proddescuento');
    $produnidad = $this->input->post('produnidad');
    $prodcantidad = $this->input->post('prodcantidad');
    $prodpu = $this->input->post('prodpu');
    $prodprecio = $this->input->post('prodprecio');
    $prodigv = $this->input->post('prodigv');
    $prodimporte = $this->input->post('prodimporte');
    $prodpu_conigv = $this->input->post('prodpu_conigv');
    
    $detaccion = $this->input->post('detaccion');
    $detacodi = $this->input->post('detacodi');
    //$prodigv100 = $this->input->post('prodigv100');
    $proddescuento100 = $this->input->post('proddescuento100');
    $proddescri = $this->input->post('proddescri');
    $pedido = $this->input->post('codigo');
    
    if (is_array($detacodi)) {
    	foreach ($detacodi as $indice => $valor) {
    		$detalle_accion = $detaccion[$indice];
    	
    		$filter = new stdClass();
    		$filter->PEDIP_Codigo = $pedido;
    		$filter->PROD_Codigo = $prodcodigo[$indice];
    		if ($produnidad[$indice] == '' || $produnidad[$indice] == "null")
    			$produnidad[$indice] = NULL;
    			//if ($flagBS[$indice] == 'B')
    			$filter->UNDMED_Codigo = $produnidad[$indice];
    			$filter->PEDIDETC_Cantidad = $prodcantidad[$indice];
    			//if ($tipo_docu != 'B') {
    			$filter->PEDIDETC_PSIGV = $prodpu[$indice];
    			$filter->PEDIDETC_Precio = $prodprecio[$indice];
    			$filter->PEDIDETC_Descuento = $proddescuento[$indice];
    			$filter->PEDIDETC_PSIGV = $prodigv[$indice];
    			/* } else {
    			 $filter->PRESDEC_Subtotal_ConIgv = $prodprecio_conigv[$indice];
    			 $filter->PRESDEC_Descuento_ConIgv = $proddescuento_conigv[$indice];
    			 } */
    			$filter->PEDIDETC_Importe = $prodimporte[$indice];
    			$filter->PEDIDETC_PCIGV = $prodpu_conigv[$indice];
    			$filter->PEDIDETC_Descuento100 = $proddescuento100[$indice];
    			//$filter->PRESDEC_Igv100 = $prodigv100[$indice];
    			//$filter->PRESDEC_Descripcion = strtoupper($proddescri[$indice]);
    			//$filter->PRESDEC_Observacion = "";
    			
    
    			if ($detalle_accion == 'n') {
    				$this->pedidodetalle_model->insertar($filter);
    			} elseif ($detalle_accion == 'm') {
    				$this->pedidodetalle_model->modificar($valor, $filter);
    			} elseif ($detalle_accion == 'e') {
    				$this->pedidodetalle_model->eliminar($valor);
    			}
    	}
    }
    exit('{"result":"ok", "codigo":"' . $pedido . '"}');
    }
   public function busqueda_personas()
    {
        $ruc      = $this->input->post('ruc');
        $nombre  = $this->input->post('nombre');
        $telefono = $this->input->post('telefono');
                $filter=new stdClass();
                $filter->nombre=$nombre;
        $data['n']                  = $this->input->post('n');
        $data['resultado_personas'] = $this->persona_model->buscar_personas($filter);
        $this->load->view('compras/busqueda_personas',$data);
    }
   public function JSON_busca_persona_xdoc($tipo, $numero){
            $datos_persona = $this->persona_model->busca_xnumeroDoc($tipo, $numero);  //Esta funcion me devuelde el registro de la empresa
            
            $resultado = '[]';
            if(count($datos_persona)>0){
                $dpto_domicilio = "15";
                $prov_domicilio = "01";
                $dist_domicilio = "00";             
                $ubigeo_domicilio = $datos_persona[0]->UBIGP_Domicilio;
                if($ubigeo_domicilio!='000000' && $ubigeo_domicilio!=''){
                    $dpto_domicilio = substr($ubigeo_domicilio,0,2);
                    $prov_domicilio = substr($ubigeo_domicilio,2,2);
                    $dist_domicilio = substr($ubigeo_domicilio,4,2);    
                }
                $ubig_naci = $datos_persona[0]->UBIGP_LugarNacimiento;
                $ubignom = '';
                if($ubig_naci!='000000' && $ubig_naci!=''){
                    $temp =  $this->ubigeo_model->obtener_ubigeo($ubig_naci);
                    if(count($temp)>0)
                        $ubignom=$temp[0]->UBIGC_Descripcion;
                }
                
                $resultado   = '[{"codigo":"'.$datos_persona[0]->PERSP_Codigo.
                                '","nombre":"'.$datos_persona[0]->PERSC_Nombre.
                                '","apepat":"'.$datos_persona[0]->PERSC_ApellidoPaterno.
                                '","apemat":"'.$datos_persona[0]->PERSC_ApellidoMaterno.
                                '","ubignom":"'.$ubignom.
                                '","ubigcod":"'.$datos_persona[0]->UBIGP_LugarNacimiento.
                                '","sexo":"'.$datos_persona[0]->PERSC_Sexo.
                                '","estadocivil":"'.$datos_persona[0]->ESTCP_EstadoCivil.
                                '","nacionalidad":"'.$datos_persona[0]->NACP_Nacionalidad.
                                '","ruc":"'.$datos_persona[0]->PERSC_Ruc.
                                '","departamento":"'.$dpto_domicilio.
                                '","provincia":"'.$prov_domicilio.
                                '","distrito":"'.$dist_domicilio.
                                '","direccion":"'.$datos_persona[0]->PERSC_Direccion.
                                '","telefono":"'.$datos_persona[0]->PERSC_Telefono.
                                '","movil":"'.$datos_persona[0]->PERSC_Movil.
                                '","fax":"'.$datos_persona[0]->PERSC_Fax.
                                '","correo":"'.$datos_persona[0]->PERSC_Email.
                                '","paginaweb":"'.$datos_persona[0]->PERSC_Web.
                                '","ctactesoles":"'.$datos_persona[0]->PERSC_CtaCteSoles.
                                '","ctactedolares":"'.$datos_persona[0]->PERSC_CtaCteDolares.'"}]';
            }
            echo $resultado;
        }

   public function eliminar_persona(){
            $persona = $this->input->post('persona');

            $this->persona_model->eliminar_persona($persona);
    }
   public function seleccionar_estadoCivil($indSel){
            $array_dist = $this->estadocivil_model->listar_estadoCivil();
            $arreglo = array();
            foreach($array_dist as $indice=>$valor){
                    $indice1   = $valor->ESTCP_Codigo;
                    $valor1    = $valor->ESTCC_Descripcion;
                    $arreglo[$indice1] = $valor1;
            }
            $resultado = $this->html->optionHTML($arreglo,$indSel,array('0','::Seleccione::'));
            return $resultado;
    }
   public function seleccionar_nacionalidad($indSel=''){
            $array_dist = $this->nacionalidad_model->listar_nacionalidad();
            $arreglo = array();
            foreach($array_dist as $indice=>$valor){
                    $indice1   = $valor->NACP_Codigo;
                    $valor1    = $valor->NACC_Descripcion;
                    $arreglo[$indice1] = $valor1;
            }
            $resultado = $this->html->optionHTML($arreglo,$indSel,array('','::Seleccione::'));
            return $resultado;
    }
    /*public function insertar_areaEmpresa($nombre_area){
            $this->empresa_model->insertar_areaEmpresa($area,$empresa,$descripcion);

    }*/
   public function seleccionar_departamento($indDefault=''){
            $array_dpto = $this->ubigeo_model->listar_departamentos();
            $arreglo = array();
            if(count($array_dpto)>0){
                    foreach($array_dpto as $indice=>$valor){
                            $indice1   = $valor->UBIGC_CodDpto;
                            $valor1    = $valor->UBIGC_Descripcion;
                            $arreglo[$indice1] = $valor1;
                    }
            }
            $resultado = $this->html->optionHTML($arreglo,$indDefault,array('00','::Seleccione::'));
            return $resultado;
    }
   public function seleccionar_provincia($departamento,$indDefault=''){
            $array_prov = $this->ubigeo_model->listar_provincias($departamento);
            $arreglo = array();
            if(count($array_prov)>0){
                    foreach($array_prov as $indice=>$valor){
                            $indice1   = $valor->UBIGC_CodProv;
                            $valor1    = $valor->UBIGC_Descripcion;
                            $arreglo[$indice1] = $valor1;
                    }
            }
            $resultado = $this->html->optionHTML($arreglo,$indDefault,array('00','::Seleccione::'));
            return $resultado;
    }
   public function seleccionar_distritos($departamento,$provincia,$indDefault=''){
            $array_dist = $this->ubigeo_model->listar_distritos($departamento,$provincia);
            $arreglo = array();
            if(count($array_dist)>0){
                    foreach($array_dist as $indice=>$valor){
                            $indice1   = $valor->UBIGC_CodDist;
                            $valor1    = $valor->UBIGC_Descripcion;
                            $arreglo[$indice1] = $valor1;
                    }
            }
            $resultado = $this->html->optionHTML($arreglo,$indDefault,array('00','::Seleccione::'));
            return $resultado;
    }
   public function seleccionar_tipodocumento($indDefault=''){
            $array_dist = $this->tipodocumento_model->listar_tipo_documento();
            $arreglo = array();
            if(count($array_dist)>0){
                    foreach($array_dist as $indice=>$valor){
                            $indice1   = $valor->TIPDOCP_Codigo;
                            $valor1    = $valor->TIPOCC_Inciales;
                            $arreglo[$indice1] = $valor1;
                    }
            }
            $resultado = $this->html->optionHTML($arreglo,$indDefault,array('0','::Seleccione::'));
            return $resultado;
    }

   public function ver_persona($persona)
    {

            $datos                = $this->persona_model->obtener_datosPersona($persona);
            $tipo_doc             = $datos[0]->PERSC_TipoDocIdentidad;
            $estado_civil         = $datos[0]->ESTCP_EstadoCivil;
            $nacionalidad         = $datos[0]->NACP_Nacionalidad;
            $nacimiento           = $datos[0]->UBIGP_LugarNacimiento;
            $sexo                 = $datos[0]->PERSC_Sexo;
            $ubigeo_domicilio     = $datos[0]->UBIGP_Domicilio;
            $datos_nacionalidad   = $this->nacionalidad_model->obtener_nacionalidad($nacionalidad);
            $datos_nacimiento     = $this->ubigeo_model->obtener_ubigeo($nacimiento);
            $datos_ubigeoDom_dpto = $this->ubigeo_model->obtener_ubigeo_dpto($ubigeo_domicilio);
            $datos_ubigeoDom_prov = $this->ubigeo_model->obtener_ubigeo_prov($ubigeo_domicilio);
            $datos_ubigeoDom_dist = $this->ubigeo_model->obtener_ubigeo($ubigeo_domicilio);
            $datos_doc            = $this->tipodocumento_model->obtener_tipoDocumento($tipo_doc);
            $datos_estado_civil   = $this->estadocivil_model->obtener_estadoCivil($estado_civil);
            $data['nacionalidad'] = $datos_nacionalidad[0]->NACC_Descripcion;
            $data['nacimiento']   = $datos_nacimiento[0]->UBIGC_Descripcion;
            $data['tipo_doc']     = $datos_doc[0]->TIPOCC_Inciales;
            $data['estado_civil'] = $datos_estado_civil[0]->ESTCC_Descripcion;
            $data['sexo']         = $sexo==0?'MASCULINO':'FEMENINO';
            $data['telefono']     = $datos[0]->PERSC_Telefono;
            $data['movil']        = $datos[0]->PERSC_Movil;
            $data['fax']          = $datos[0]->PERSC_Fax;
            $data['email']        = $datos[0]->PERSC_Email;
            $data['web']          = $datos[0]->PERSC_Web;
            $data['direccion']    = $datos[0]->PERSC_Direccion;
            $data['dpto']         = $datos_ubigeoDom_dpto[0]->UBIGC_Descripcion;
            $data['prov']         = $datos_ubigeoDom_prov[0]->UBIGC_Descripcion;
            $data['dist']         = $datos_ubigeoDom_dist[0]->UBIGC_Descripcion;


        $data['datos']  = $datos;
        $data['titulo'] = "VER PERSONA";

        $this->load->view('maestros/persona_ver',$data);
    }
   public function JSON_datos_persona($persona){
        $datos_persona = $this->persona_model->obtener_datosPersona($persona);
        $result=array();
        if(count($datos_persona)>0)
            $result=$datos_persona[0];
        echo json_encode($result);
   }
   
    public function eliminar_pedido(){
        $pedido = $this->input->post('pedido');
        //primero busca si no esta amarrado a un presupuesto
        $presupuesto = $this->presupuesto_model->buscar_presu_x_pedido($pedido);
        if(count($presupuesto) == 0){
            $this->pedido_model->eliminar_pedido($pedido);
            $this->pedido_model->eliminar_producto_pedido2($pedido);
        }else{
            echo "Tiene este pedido amarrados a un presupuesto";
        }
    }
    
    public function obtener_detalle_presupuesto($pedido){
        $detalle_pedido = $this->pedidodetalle_model->listar($pedido);
        $array_detallepedido = array();
        foreach($detalle_pedido as $indice=>$value){
            $pedido     = $value->PEDIP_Codigo;
            $producto   = $value->PROD_Codigo;
            $unidad     = $value->UNDMED_Codigo;
            $cantidad   = $value->PEDIDETC_Cantidad;
            $des_producto = $this->producto_model->obtener_producto($producto);
            $nombre_unidad = $this->unidadmedida_model->obtener($unidad);
            
            $objeto = new stdClass();
            $objeto->cod_pedido     = $pedido;
            $objeto->cod_producto   = $producto;
            $objeto->des_producto   = $des_producto[0]->PROD_Nombre;
            $objeto->unidad         = $unidad;
            $objeto->nombre_unidad  = $nombre_unidad[0]->UNDMED_Simbolo;
            $objeto->cantidad       = $cantidad;
            $objeto->detalle        = $value->PEDIDETP_Detalle;
            $array_detallepedido[] = $objeto;
        }
        $resultado = json_encode($array_detallepedido);
        echo $resultado;
    }
    
	public function obtener_detalle_lista($codigopedido){
		    $listado_detalle = $this->pedidodetalle_model->listar($codigopedido);
		    $lista_detalles = array();
		    if(count($listado_detalle)>0){
			    foreach($listado_detalle as $key=>$value){
			    	$productocodigo   = $value->PROD_Codigo;
			    	$productobusca   = $this->producto_model->obtener_producto($productocodigo);
			    	$codigousuario = $productobusca[0]->PROD_CodigoUsuario;
			    	$nombre = $productobusca[0]->PROD_Nombre;
			    	$cantidad = $value->PEDIDETC_Cantidad;
			    	$codigounidad = $value->UNDMED_Codigo;
			    	$unidadbusca     = $this->unidadmedida_model->obtener($codigounidad);
			    	$unidaddescripcion     = $unidadbusca[0]->UNDMED_Descripcion;
			    	$pu_CIGV =  $value->PEDIDETC_PCIGV;
			    	$pu_SIGV =$value->PEDIDETC_PSIGV;
			    	$descuento = $value->PEDIDETC_Descuento;
			    	$descuento100 = $value->PEDIDETC_Descuento100;
			    	$PRECIO = $value->PEDIDETC_Precio;
			    	$codigo = $value->PEDIDETP_Codigo;
			    	$IGV =$value->PEDIDETC_IGV;
			    	$IMPORTE = $value->PEDIDETC_Importe;
			    	
			    	$objeto = new stdClass();
			    	$objeto->PROD_Codigo = $productocodigo;
			    	$objeto->PROD_CodigoUsuario = $codigousuario;
			    	$objeto->PROD_Nombre = $nombre;
			    	$objeto->PEDIDETC_Cantidad = $cantidad;
			    	$objeto->UNDMED_Descripcion = $unidaddescripcion;
			    	$objeto->PEDIDETC_PCIGV = $pu_CIGV;
			    	$objeto->PEDIDETC_PSIGV = $pu_SIGV;
			    	$objeto->PEDIDETC_Precio = $PRECIO;
			    	$objeto->PEDIDETC_Descuento = $descuento;
			    	$objeto->PEDIDETC_Descuento100 = $descuento100;
			    	$objeto->PEDIDETC_IGV = $IGV;
			    	$objeto->PEDIDETP_Codigo = $codigo;
			    	$objeto->PEDIDETC_Importe = $IMPORTE;
			    	$lista_detalles[] = $objeto;
			    }
		    }
		    return $lista_detalles;
		
	}
	public function contacto(){
		$codigo = $this->input->post('codigoempre');
		$respuesta = $this->pedido_model->contactos($codigo);
			
		echo json_encode($respuesta);
	
	}
	public function obra(){
	
		$codigo = $this->input->post('codigoempre');
		$respuesta = $this->pedido_model->obras($codigo);
			
		echo json_encode($respuesta);
	
	}
	
	public function seleccionar_centrocosto($indDefault=''){
		$array_dist = $this->centrocosto_model->listar_centros_costo();
		$arreglo = array();
		if(count($array_dist)>0){
			foreach($array_dist as $indice=>$valor){
				$indice1   = $valor->CENCOSP_Codigo;
				$valor1    = $valor->CENCOSC_Descripcion;
				$arreglo[$indice1] = $valor1;
			}
		}
		$resultado = $this->html->optionHTML($arreglo,$indDefault,array('0','::Seleccione::'));
		return $resultado;
	}
	
	public function insertar_pedido(){
		$serie = $this->input->post('serie');
		$numero = $this->input->post('numero');
		$fechasistema = $this->input->post('fechai');
		$moneda = $this->input->post('moneda');
		$obra = $this->input->post('obra');
		$cliente = $this->input->post('cliente');
		$contacto = $this->input->post('contacto');
		$igvpp = $this->input->post('igv');
		$importebruto = $this->input->post('importebruto');
		$descuentotal = $this->input->post('descuentotal');
		$vventa = $this->input->post('vventa');
		$igvtotal = $this->input->post('igvtotal');
		$preciototal= $this->input->post('preciototal');
		$descuento100 = $this->input->post('descuento');
	
	
		$cod_pedido = $this->pedido_model->insertar_pedido($serie,$numero,$fechasistema,$moneda,$obra,$cliente,$contacto,$igvpp,$importebruto,$descuentotal,$vventa,$igvtotal,$preciototal,$descuento100);
	
		$prodcodigo = $this->input->post('prodcodigo');
		$prodcantidad = $this->input->post('prodcantidad');
		$produnidad = $this->input->post('produnidad');
		$ppcigv = $this->input->post('prodpu_conigv');
		$ppsigv = $this->input->post('prodpu');
		$precio = $this->input->post('prodprecio');
		$proddescuento100 = $this->input->post('proddescuento100');
		$proddescuento = $this->input->post('proddescuento');
		$igv =  $this->input->post('prodigv');
		$importe = $this->input->post('prodimporte');
	
    $compania = $this->somevar['compania'];
    $configuracion_datos = $this->configuracion_model->obtener_numero_documento($compania, 1);
        $numero_predt = $this->pedido_model->ultimo_numero();
        $numero = $numero_predt[0]->PEDIC_Numero;
        $num = $configuracion_datos[0]->CONFIC_Numero + 1;
        $filter->PEDIC_Numero = $numero + 1;
        $numero = $this->input->post('numero');
         $filter->PEDIC_Numero = $this->input->post('numero');
         
         if ($this->input->post('serie') != '' && $this->input->post('serie') != '0') {
            $filter->PRESUC_Serie = $this->input->post('serie');
         }
         $this->configuracion_model->update_numero_pedido($this->input->post('numero'), $this->somevar['compania']);

		//         $eliminado        = $this->input->post('eliminado');
		$fecha = date('Y-m-d h:i:s');
		if(count($prodcodigo) > 0){
			foreach($prodcodigo as $indice => $value){
				//                 $eseliminado = $eliminado[$indice];
				//                 if($eseliminado != 'si'){
				$filterDP = new stdClass();
	
				$filterDP->PEDIP_Codigo = $cod_pedido;
				$filterDP->PROD_Codigo = $prodcodigo[$indice];
				$filterDP->UNDMED_Codigo = $produnidad[$indice];
				$filterDP->PEDIDETC_Cantidad = $prodcantidad[$indice];
				$filterDP->PEDIDETC_PCIGV = $ppcigv[$indice];
				$filterDP->PEDIDETC_PSIGV = $ppsigv[$indice];
				$filterDP->PEDIDETC_Precio  = $precio[$indice];
				$filterDP->PEDIDETC_Descuento100 = $proddescuento100[$indice];
				$filterDP->PEDIDETC_Descuento = $proddescuento[$indice];
				$filterDP->PEDIDETC_IGV = $igv[$indice];
				$filterDP->PEDIDETC_Importe = $importe[$indice];
				$filterDP->PEDIDETC_FechaRegistro =   $fecha;
				$filterDP->PEDIDETC_FlagEstado = "1";
				$this->pedidodetalle_model->insertar_varios($filterDP);
				//                 }
			}
		}
	
	}
	
	public function obtener_persona($persona)
	{
		$datos_persona = $this->persona_model->obtener_datosPersona($persona);
		echo json_encode($datos_persona);
	}
	
	public function buscar_personas($j='0'){
		$filter = new stdClass();
		$filter->PERSC_NumeroDocIdentidad = $this->input->post('txtNumDoc');;
		$filter->nombre = $this->input->post('txtNombre');
		$filter->PERSC_Telefono = $this->input->post('txtTelefono');
	
		$data['numdoc']    = $filter->PERSC_NumeroDocIdentidad;
		$data['nombre']    = $filter->nombre;
		$data['telefono']  = $filter->PERSC_Telefono;
		$data['titulo_tabla']    = "RESULTADO DE BÃšSQUEDA DE PERSONAS";
	
		$data['registros']  = count($this->persona_model->buscar_personas($filter));
		$data['action'] = base_url()."index.php/maestros/persona/buscar_personas";
		$conf['base_url'] = site_url('maestros/persona/buscar_personas/');
		$conf['total_rows'] = $data['registros'];
		$conf['per_page']   = 10;
		$conf['num_links']  = 3;
		$conf['next_link'] = "&gt;";
		$conf['prev_link'] = "&lt;";
		$conf['first_link'] = "&lt;&lt;";
		$conf['last_link']  = "&gt;&gt;";
		$conf['uri_segment'] = 4;
		$this->pagination->initialize($conf);
		$data['paginacion'] = $this->pagination->create_links();
		$listado_personas = $this->persona_model->buscar_personas($filter, $conf['per_page'],$j);
		$item            = $j+1;
		$lista           = array();
		if(count($listado_personas)>0){
			foreach($listado_personas as $indice=>$valor){
				$persona   = $valor->PERSP_Codigo;
				$ruc            = $valor->PERSC_NumeroDocIdentidad;
				$nombres   = $valor->PERSC_Nombre;
				$telefono       = $valor->PERSC_Telefono;
				$movil          = $valor->PERSC_Movil;
				$editar         = "<a href='#' onclick='editar_persona(".$persona.")'><img src='".base_url()."images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
				$ver            = "<a href='#' onclick='ver_persona(".$persona.")'><img src='".base_url()."images/ver.png' width='16' height='16' border='0' title='Modificar'></a>";
				$eliminar       = "<a href='#' onclick='eliminar_persona(".$persona.")'><img src='".base_url()."images/eliminar.png' width='16' height='16' border='0' title='Modificar'></a>";
				$lista[]        = array($item,$ruc,$nombres,$telefono,$movil,$editar,$ver,$eliminar);
				$item++;
			}
		}
		$data['lista'] = $lista;
		$this->layout->view("maestros/persona_index",$data);
	
	}
	public function getOrderNumero($numero){
	
                 $dato ="";
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
	public function getOrderSerie($numero){
	
                $dato ="";
		$cantidad=strlen($numero);
	
		if($cantidad==1){
			$dato ="00$numero";
		}
		if($cantidad==2){
			$dato ="0$numero";
		}
		if($cantidad==3){
			$dato ="$numero";
		}
		return $dato;
	}
	
	
	public function obtenercontacto_obra(){
		
		$codigoobra = $this->input->post('codigo');
		$result = array();
		
		if($codigoobra!=null && count(trim($codigoobra))>0){
			$obten_cont = $this->proyecto_model->obtenerContacto($codigoobra);
			if($obten_cont !=null && count($obten_cont)){
				foreach ($obten_cont as $indice => $valor){
		
					$codigo = $valor->EMPRP_Codigo;
					$nombre = $valor->EMPRC_RazonSocial;

					$result[] = array("codigo" => $codigo , "nombre" => $nombre  );
		
				}
			}
		}
		echo json_encode($result);
		
		
	}
    public function getOrderNumeroSerie($numero) {
        $cantidad = strlen($numero);
        if ($cantidad == 1) {
            $dato = "00000$numero";
        }
        if ($cantidad == 2) {
            $dato = "0000$numero";
        }
        if ($cantidad == 3) {
            $dato = "000$numero";
        }
        if ($cantidad == 4) {
            $dato = "00$numero";
        }
        if ($cantidad == 5) {
            $dato = "0$numero";
        }
        if ($cantidad == 6) {
            $dato = "$numero";
        }
        return $dato;
    }
	
	public function registro_pedido_pdf($fechai, $fechaf, $numero, $cliente)
	{
	
		$fi = explode("-",$fechai);
		$ff = explode("-",$fechaf);
		$fechain = $fi[2].'/'.$fi[1].'/'.$fi[0];
		$fechafin = $ff[2].'/'.$ff[1].'/'.$ff[0];
		if($fechain=="//" || $fechafin=="//"){
			$fechain = "--";
			$fechafin = "--";
		}
	
		$this->load->library('cezpdf');
		$this->load->helper('pdf_helper');
		//prep_pdf();
		$this->cezpdf = new Cezpdf('a4');
		$datacreator = array(
				'Title' => 'Estadillo de ',
				'Name' => 'Estadillo de ',
				'Author' => 'Vicente Producciones',
				'Subject' => 'PDF con Tablas',
				'Creator' => 'info@vicenteproducciones.com',
				'Producer' => 'http://www.vicenteproducciones.com'
		);
	
		$this->cezpdf->addInfo($datacreator);
		$this->cezpdf->selectFont(APPPATH . 'libraries/fonts/Helvetica.afm');
		$delta = 20;
	
	
		
		$titulo="RELACION DE PEDIDOS";
		$fonttitle = array("leading" => 30, "left" => 150);
		$fontespacio = array("leading" => 10, "left" => 100);
		$fontdataright = array("leading" => 10, "left" => 370);
		
		$hoy = date("d-m-Y");
		$this->cezpdf->ezText($titulo, 17, $fonttitle);
		$this->cezpdf->ezText("", 17, $fontespacio);
		$this->cezpdf->ezText("FECHA DE REPORTE: ".$hoy, 8, $fontdataright);
		$this->cezpdf->ezText("", 17, $fontespacio);
	
	
		$db_data = array();
	
	
		$listado_pedido = $this->pedido_model->listar_pedido_pdf($fechain, $fechafin, $numero, $cliente);
	
	
		if (count($listado_pedido) > 0) {
			foreach ($listado_pedido as $indice => $valor) {
				$fecha = $valor->FECHA;
			
				
				$serie =  $this->getOrderSerie($valor->PEDIC_Serie);
				$numero =  $this->getOrderNumero($valor->PEDIC_Numero);
				//cliente
				$codigocliente   = $valor->CLIP_Codigo;//
				$buscarcliente = $this->cliente_model->obtener_datosCliente($codigocliente);
				foreach ($buscarcliente as $indice2=>$valor2){
					$tipopersona = $valor2->CLIC_TipoPersona;
				
					if($tipopersona == 1){
						$codigoempresa = $valor2->EMPRP_Codigo;
						$buscarempresa = $this->cliente_model->obtener_datosCliente2($codigoempresa);
						foreach ($buscarempresa as $indice3 => $valor3){
							$nombrededos = $valor3->EMPRC_RazonSocial;
						}
					}else{
						$codigopersona = $valor2->PERSP_Codigo;
						$buscarpersona = $this->cliente_model->obtener_datosCliente3($codigopersona);
						foreach ($buscarpersona as $indice4 => $valor4){
							$nombre = $valor4->PERSC_Nombre;
							$ap =$valor4->PERSC_ApellidoPaterno;
							$am =$valor4->PERSC_ApellidoMaterno;
							$nombrededos = $nombre." ".$ap." ".$am;
						}
					}
				}
				
				//fin cliente
				
				$numeropresupuesto = $valor->PRESUC_Serie."-".$valor->PRESUC_Numero;//
				
				$total = $valor->MONED_Simbolo.$valor->PEDIC_PrecioTotal;
				$Stotal+= $valor->PEDIC_PrecioTotal;
	
				$db_data[] = array(
						'cols1' => $indice + 1,
						'cols2' => $fecha,
						'cols3' => $serie,//
						'cols4' => $numero,//
						'cols5' => $nombrededos,//
						'cols6' => $numeropresupuesto,//presu
						'cols7' => $total
				);
			}
		}
	
	
	
	
		$col_names = array(
				'cols1' => '<b>ITEM</b>',
				'cols2' => '<b>FECHA</b>',
				'cols3' => '<b>SERIE</b>',
				'cols4' => '<b>NUMERO</b>',
				'cols5' => '<b>RAZON SOCIAL</b>',
				'cols6' => '<b>PRESUPUESTO</b>',
				'cols7' => '<b>TOTAL</b>'
		);
	
		$this->cezpdf->ezTable($db_data, $col_names, '', array(
				'width' => 600,
				'showLines' => 1,
				'shaded' => 1,
				'showHeadings' => 1,
				'xPos' => 'center',
				'fontSize' => 8,
				'cols' => array(
						'cols1' => array('width' => 30, 'justification' => 'center'),
						'cols2' => array('width' => 60, 'justification' => 'center'),
						'cols3' => array('width' => 40, 'justification' => 'center'),
						'cols4' => array('width' => 50, 'justification' => 'center'),
						'cols5' => array('width' => 160, 'justification' => 'center'),
						'cols6' => array('width' => 75, 'justification' => 'center'),
						'cols7' => array('width' => 60, 'justification' => 'center')
				)
		));
		$this->cezpdf->ezText('TOTAL:   '. $valor->MONED_Simbolo.number_format($Stotal,2), '8', array("leading" => 15, 'left' => 410));
	
	
		$cabecera = array('Content-Type' => 'application/pdf', 'Content-Disposition' => $codificacion . '.pdf', 'Expires' => '0', 'Pragma' => 'cache', 'Cache-Control' => 'private');
	
		ob_end_clean();
	
		$this->cezpdf->ezStream($cabecera);
	}
	


}

?>