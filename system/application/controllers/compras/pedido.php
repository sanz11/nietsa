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
		$this->load->model('maestros/formapago_model');
		$this->load->model('maestros/condicionentrega_model');
		$this->load->model('compras/pedido_model');
		$this->load->model('maestros/centrocosto_model');
		$this->load->model('maestros/moneda_model');
		$this->load->model('almacen/producto_model');
		$this->load->model('almacen/unidadmedida_model');
		$this->load->model('almacen/almacen_model');
		$this->load->model('seguridad/usuario_model');
		$this->load->model('compras/presupuesto_model');
        $this->load->helper('json');
        $this->load->library('html');
        $this->load->library('table');
        $this->load->library('layout','layout');
        $this->load->library('pagination');

	}
	public function index()
	{
		$this->layout->view('seguridad/inicio');	
	}
        public function pedidos($j=0){
            $data['numdoc'] = "";
            $data['nombre'] = "";
            $data['telefono']  = "";
            $data['titulo_tabla']    = "RELACIÓN DE PEDIDOS";
            $data['registros']  = count($this->pedido_model->listar_pedidos_todos());
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
            $listado_pedidos = $this->pedido_model->listar_pedidos_todos($conf['per_page'],$j);
            $item            = $j+1;
            $lista           = array();
		if(count($listado_pedidos)>0){
				foreach($listado_pedidos as $indice=>$valor){
					$codigo   = $valor->PEDIP_Codigo;
					$numero   = $valor->PEDIC_Numero;
					$centro_costo = $valor->CENCOSC_Descripcion;
					$observacion = $valor->PEDIC_Observacion;
					$estado = $valor->PEDIC_FlagEstado;
					$img_estado = ($estado=='1' ? "<img src='".base_url()."images/active.png' alt='Activo' title='Activo' />" : "<img src='".base_url()."images/inactive.png' alt='Anulado' title='Anulado' />") ;
					$editar         = "<a href='javascript:;' onclick='editar_pedido(".$codigo.")'><img src='".base_url()."images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
					$ver            = "<a href='javascript:;' onclick='ver_pedido(".$codigo.")'><img src='".base_url()."images/ver.png' width='16' height='16' border='0' title='Modificar'></a>";
					$ver = '';
					$eliminar       = "<a href='javascript:;' onclick='eliminar_pedido(".$codigo.")'><img src='".base_url()."images/eliminar.png' width='16' height='16' border='0' title='Modificar'></a>";
					$lista[]        = array($item,$numero,$observacion,$centro_costo,$img_estado,$editar,$ver,$eliminar);
					$item++;
				}
			}
          $data['lista'] = $lista;
          $this->layout->view("compras/pedido_index",$data);
	}

	public function nuevo_pedido()
	{
		$combo = '';
		$listado_tipo_doc = $this->documento_model->listar();
		if(count($listado_tipo_doc) > 0){
			foreach($listado_tipo_doc as $indice=>$valor){
				$codigo   = $valor->DOCUP_Codigo;
				$descripcion   = $valor->DOCUC_Descripcion;
				//$lista[]        = array($codigo,$descripcion);
				$combo .= '<option value="'.$codigo.'">'.$descripcion.'</option>';
			}
		}
		$data = array();
		$data['centro_costo'] = $this->seleccionar_centrocosto();
		$data['numero_documento'] = 0;
		$data['observacion'] = '';
		$data['datos'] = '';
		$data['id'] = '';
		$data['responsable_value'] = '';
		$data['modo'] = 'insertar';
		$data['tipo_pedido'] = '';
		$data['num_refe'] = '';
		$data['combo'] = $combo;
		$data['titulo'] = "REGISTRAR PEDIDOs";
		$this->load->view("compras/pedido_nuevo",$data);
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

        $centro_costo = $this->input->post('centro_costo');
        $numero_documento = $this->input->post('numero_documento');
        $observacion = $this->input->post('observacion');
        $tipo_pedido = $this->input->post('tipo_pedido');
		$tipo_documento = $this->input->post('tipo_documento');
		$num_refe = $this->input->post('num_refe');
        
        $this->pedido_model->insertar_pedido($centro_costo,$numero_documento,$observacion,$tipo_pedido,$tipo_documento,$num_refe);
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
        $data['titulo_tabla']    = "RESULTADO DE BÚSQUEDA DE PERSONAS";

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
    
   public function editar_pedido($pedido){

		$datos_pedido = $this->pedido_model->obtener_pedido($pedido);
		$data['centro_costo'] = $this->seleccionar_centrocosto('1');
		$data['numero_documento'] = $datos_pedido[0]->PEDIC_Numero;
		$data['observacion'] = $datos_pedido[0]->PEDIC_Observacion;
		$data['tipo_pedido'] = $datos_pedido[0]->PEDIC_Tipo;
		
		$combo = '';
		$listado_tipo_doc = $this->documento_model->listar();
		if(count($listado_tipo_doc) > 0){
			foreach($listado_tipo_doc as $indice=>$valor){
				$codigo   = $valor->DOCUP_Codigo;
				$descripcion   = $valor->DOCUC_Descripcion;
				//$lista[]        = array($codigo,$descripcion);
				if($codigo == $datos_pedido[0]->DOCUP_Codigo){
					$combo .= '<option value="'.$codigo.'" selected="selected" >'.$descripcion.'</option>';
				}else{
					$combo .= '<option value="'.$codigo.'">'.$descripcion.'</option>';
				}
			}
		}
		
		$data['tipo_documento'] = $datos_pedido[0]->DOCUP_Codigo;
		$data['num_refe'] = $datos_pedido[0]->PEDIC_NumRefe;
		$data['datos'] = '';
		$data['id'] = $pedido;
		$data['modo'] = 'modificar';
		$data['combo'] = $combo;
		$data['titulo'] = "EDITAR PEDIDO";
		$this->load->view("compras/pedido_nuevo",$data);
	}

   public function modificar_pedido(){
    $pedido = $this->input->post('id');
    $centro_costo = $this->input->post('centro_costo');
    $numero_documento = $this->input->post('numero_documento');
    $observacion = $this->input->post('observacion');
    $tipo_pedido = $this->input->post('tipo_pedido');
    $tipo_documento = $this->input->post('tipo_documento');
    $num_refe = $this->input->post('num_refe');
	$this->pedido_model->modificar_pedido($pedido,$centro_costo,$numero_documento,$observacion,$tipo_pedido,$tipo_documento,$num_refe);
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
		}else{
			echo "Tiene este pedido amarrados a un presupuesto";
		}
	}

}
?>