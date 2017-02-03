<?php
class TipoCaja extends Controller{
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
        $this->load->helper('json');
		$this->load->model('tesoreria/tipocaja_model');
		
		$this->load->model('tesoreria/flujocaja_model');
		$this->load->model('tesoreria/cuentaspago_model');
		$this->load->model('tesoreria/pago_model');
		$this->load->model('maestros/moneda_model');
		$this->load->model('maestros/tipocambio_model');
		$this->load->model('maestros/formapago_model');
		$this->load->model('compras/proveedor_model');
		$this->load->model('ventas/cliente_model');
		$this->load->model('compras/proveedor_model');
		$this->load->model('ventas/notacredito_model');
		date_default_timezone_set("America/Lima");
		$this->somevar['compania'] = $this->session->userdata('compania');
	}
	
	public function index(){
		$this->load->view('seguridad/inicio');
		$this->load->library('layout', 'layout');
	}
	
	public  function  tipocajas( $j = '0', $limpia = ''){
		unset($_SESSION['serie']);
		$this->load->library('layout', 'layout');
		if ($limpia == 1) {		
			$this->session->unset_userdata('fechai');
			$this->session->unset_userdata('fechaf');			
			$this->session->unset_userdata('txtTipo');
			$this->session->unset_userdata('txtCodigoT');	

		}
		$filter = new stdClass();
		if (count($_POST) > 0) {
			$filter->fechai = $this->input->post('fechai');
			$filter->fechaf = $this->input->post('fechaf');		
			$filter->txtTipo = $this->input->post('txtTipo');
			$filter->txtCodigoT = $this->input->post('txtCodigoT');		
			$this->session->set_userdata(array('fechai' => $filter->fechai, 'fechaf' => $filter->fechaf, 'txtTipo' => $filter->txtTipo,'txtCodigoT'=>$filter->txtCodigoT));
		} else {
			$filter->fechai = $this->session->userdata('fechai');
			$filter->fechaf = $this->session->userdata('fechaf');	
			$filter->txtTipo = $this->session->userdata('txtTipo');
			$filter->txtCodigoT = $this->session->userdata('txtCodigoT');
			
			}
		$data['fechai'] = $filter->fechai;
		$data['fechaf'] = $filter->fechaf;		
		$data['txtTipo'] = $filter->txtTipo;
		$data['txtCodigoT'] = $filter->txtCodigoT;				
		$conf['base_url'] = site_url('tesoreria/tipocaja/tipocajas');		
		$data['registros'] =count($this->tipocaja_model->tipocaja_listar_buscar($filter));//count($this->cuentas_model->listar(, '', '', $filter, $cond_pago, $comprobante, 1));
		$conf['per_page'] = 20;
		$conf['num_links'] = 3;
		 $conf['first_link'] = "&lt;&lt;";
        $conf['last_link'] = "&gt;&gt;";
		//$conf['total_rows'] = $data['registros'];
		$conf['uri_segment'] = 5;
		//$offset = (int)$this->uri->segment(5);
		$conf['total_rows'] = $data['registros'];
		$offset = (int)$this->uri->segment(4);
		$listado_tipocaja =$this->tipocaja_model->tipocaja_listar_buscar($filter, $conf['per_page'], $offset);
		$item = $j + 1;
		$lista = array();
		//echo "<pre>";
		if (count($listado_tipocaja) > 0) {
			foreach ($listado_tipocaja as $indice => $valor) {
				$codigo = $valor->tipCa_codigo;
				$tipo_descripcion=$valor->tipCa_Descripcion;
				$abreviatura=$valor->tipCa_Abreviaturas;
				$tip_Caja=$valor->tipCa_Tipo;
				$usu_registro=$valor->UsuarioRegistro;
				$usu_modifi=$valor->UsuarioModificado;
				$fechaMod=$valor->tipCa_fechaModificacion;
				$fechaReg=$valor->tipCa_FechaRegsitro;
				$compania=$valor->COMPP_Codigo;
				$estado=$valor->tipCa_FlagEstado;

if($estado=="1"){
	$editar = "<a href='javascript:;' onclick='tipocaja_editar(" . $valor->tipCa_codigo . ")' target='_parent'><img src='" . base_url() . "images/modificar.png' width='16' height='16' border='0' </a>";

	$ver="<a href='#' id='vercaja".$indice."' onclick='getOptenerModal(".$codigo.','.$indice.")'  target='_parent'><img src='" . base_url() . "images/ver.png' width='16' height='16' border='0' </a>";// = "<a 
$eliminar ="<a href='javascript:;' onclick='tipocaja_Eliminar(" . $valor->tipCa_codigo . ")' target='_parent'><img src='" . base_url() . "images/eliminar.png' width='16' height='16' border='0' </a>";
				
$estados ="<a href='javascript:;'  target='_parent'><img src='" . base_url() . "images/active.png' width='16' height='16' border='0' </a>";					
}else{
$estados ="<a href='javascript:;' target='_parent'><img src='" . base_url() . "images/inactive.png' width='16' height='16' border='0' </a>";

$editar = "";
$ver="";
$eliminar ="";
				
				
}

				//= "<a href='javascript:;' onclick='comprobante_ver_pdf_conmenbrete(" . $codigo." )' target='_parent'><img src='" . base_url() . "images/pdf.png' width='16' height='16' border='0' title='Ver PDF'></a>";
		$lista[] = array($item++, $tipo_descripcion, $abreviatura,$tip_Caja , $usu_registro, $usu_modifi, $fechaMod, $fechaReg, $compania,$estado, $editar, $ver, $eliminar,$estados);
				
			}
		}
		
		//print_r($listado_cuentas);
		
		$data['titulo_tabla'] = "TIPO DE CAJA";
		$data['titulo_busqueda'] = "BUSCAR TIPO DE CAJA ";
		$data['tipo_caja'] = "";
		$data['lista'] = $lista;
		$data['oculto'] = form_hidden(array('base_url' => base_url()));
		$this->pagination->initialize($conf);
		$data['paginacion'] = $this->pagination->create_links();
		$this->layout->view('tesoreria/tipoCajaIndex', $data);
	}
public function tipocaja_nuevo() {
	//
	    
        //
        $this->load->library('layout', 'layout');
        $codigo = "";
        $this->session->unset_userdata('estado_pago2');
        $data['form_open'] = form_open(base_url() . 'index.php/tesoreria/tipocaja/tipocaja_grabar', array("name" => "frmtipocaja", "id" => "frmtipocaja"));
        $data['form_close'] = form_close();   
        $data['titulo'] = "REGISTRAR TIPO CAJA";
   
     $data["codigocaja"] ="";
	 $data["tipo_descripcion"]="";
	 $data["abreviatura"] =	"";
	 $data["tip_Caja"]= "";
	 $data["usu_registro"]=$this->session->userdata('nombre_persona');
	 $data["usu_modifi"]= "";
	 $data["fechaMod"]= "";
	 $data["fechaReg"]=mysql_to_human(mdate("%Y-%m-%d ", time()));
	 $data["compania"]= $this->session->userdata('compania');
	 $data["estado"]= "1";
        //$data['alerta'] = $this->seleccionar_alerta();

        $data['oculto'] = form_hidden(array('codigo' => $codigo, 'base_url' => base_url()));
        $this->layout->view('tesoreria/tipocaja_nuevo', $data);
    }

    public function tipocaja_grabar() {
        $datos = array();
        if ($this->input->post('txtDescrip') == ''){
            exit('{"result":"error", "campo":"txtDescrip"}');
        } 
        if ( $this->input->post('txtAbreviatura') == ''){
            exit('{"result":"error", "campo":"txtAbreviatura"}');
        }
        if ( $this->input->post('txtTipocaja') == '::Seleccione::'){
            exit('{"result":"error", "campo":"txtTipocaja"}');
        } 
                
        $filter = new stdClass();
        $filter->tipCa_Descripcion = $this->input->post('txtDescrip');
        $filter->tipCa_FechaRegsitro = human_to_mysql($this->input->post('fecha'));      
        $filter->UsuarioRegistro = $this->input->post('txtusuarioR');
        $filter->tipCa_Tipo = $this->input->post('txtTipocaja');
        $filter->tipCa_Abreviaturas = $this->input->post('txtAbreviatura');
        $filter->COMPP_Codigo = $this->input->post('txtCompania');
        $filter->tipCa_FlagEstado = $this->input->post('txtEstado');
       
      $presupuesto= $this->tipocaja_model->insert_tipocaja($filter);
    exit('{"result":"ok", "codigo":"' . $presupuesto . '"}');
    }

public function tipocaja_editar($codigo){
	$this->load->library('layout', 'layout');
	     
        $this->session->unset_userdata('estado_pago2');
        $data['form_open'] = form_open(base_url() . 'index.php/tesoreria/tipocaja/tipocaja_modificar', array("name" => "frmtipocaja", "id" => "frmtipocaja"));
        $data['form_close'] = form_close();
$obtenertipocaja=$this->tipocaja_model->getTipocaja($codigo);
if (count($obtenertipocaja)>0) {

foreach ($obtenertipocaja as $key => $value) {
	            $codigocaja = $value->tipCa_codigo;
				$tipo_descripcion=$value->tipCa_Descripcion;
				$abreviatura=$value->tipCa_Abreviaturas;
				$tip_Caja=$value->tipCa_Tipo;
				$usu_registro=$value->UsuarioRegistro;
				$usu_modifi=$value->UsuarioModificado;
				$fechaMod=$value->tipCa_fechaModificacion;
				$fechaReg=$value->tipCa_FechaRegsitro;
				$compania=$value->COMPP_Codigo;
				$estado=$value->tipCa_FlagEstado;
    }    
 }       
     $data["codigocaja"] =$codigocaja ;
	 $data["tipo_descripcion"]=$tipo_descripcion;
	 $data["abreviatura"] =	$abreviatura;
	 $data["tip_Caja"]= $tip_Caja;
	 $data["usu_registro"]=$usu_registro;
	 $data["usu_modifi"]= $usu_modifi;
	 $data["fechaMod"]= $fechaMod;
	 $data["fechaReg"]=mysql_to_human($fechaReg);
	 $data["compania"]= $compania;
	 $data["estado"]= $estado;
        $data['titulo'] = "REGISTRAR PAGOS";
        $data['tipo_caja'] ="" ;
        //$data['alerta'] = $this->seleccionar_alerta();

        $data['oculto'] = form_hidden(array('codigo' => $codigo, 'base_url' => base_url()));
        $this->layout->view('tesoreria/tipocaja_nuevo', $data);	
}	
	public function tipocaja_modificar(){
		$datos = array();
        if ($this->input->post('txtDescrip') == ''){
            exit('{"result":"error", "campo":"txtDescrip"}');
        }
        if ( $this->input->post('fecha') == ''){
            exit('{"result":"error", "campo":"fecha"}');
        } 
        if ( $this->input->post('txtAbreviatura') == ''){
            exit('{"result":"error", "campo":"txtAbreviatura"}');
        }
        if ( $this->input->post('txtTipocaja') == '::Seleccione::'){
            exit('{"result":"error", "campo":"txtTipocaja"}');
        } 
        $filter = new stdClass();
        $codigo=$this->input->post("txtcodigo");
        $filter->tipCa_Descripcion = $this->input->post('txtDescrip');
        //$filter->tipCa_FechaRegsitro = human_to_mysql($this->input->post('fecha'));   
        $filter->tipCa_fechaModificacion = human_to_mysql($this->input->post('fecha'));
        $filter->UsuarioModificado = $this->input->post('txtusuarioR');
        $filter->tipCa_Tipo = $this->input->post('txtTipocaja');
        $filter->tipCa_Abreviaturas = $this->input->post('txtAbreviatura');
        $filter->COMPP_Codigo = $this->input->post('txtCompania');
        $filter->tipCa_FlagEstado = $this->input->post('txtEstado');
        $this->tipocaja_model->tipocaja_modificar($codigo,$filter);
     exit('{"result":"ok", "codigo":"' . $codigo . '"}');  
	}

public function JSON_listarTipoCaja($codigo){
	$lista_detalles = array();
	$obtenertipocaja=$this->tipocaja_model->getTipocaja($codigo);
if (count($obtenertipocaja)>0) {

foreach ($obtenertipocaja as $key => $value) {
    $objeto = new stdClass();
    $objeto->tipCa_codigo = $value->tipCa_codigo;
	$objeto->tipCa_Descripcion=$value->tipCa_Descripcion;
	$objeto->tipCa_Abreviaturas=$value->tipCa_Abreviaturas;
	$objeto->tipCa_Tipo=$value->tipCa_Tipo;
	$objeto->UsuarioRegistro=$value->UsuarioRegistro;
	$objeto->UsuarioModificado=$value->UsuarioModificado;
	$objeto->tipCa_fechaModificacion=$value->tipCa_fechaModificacion;
	$objeto->tipCa_FechaRegsitro=$value->tipCa_FechaRegsitro;
	$objeto->COMPP_Codigo=$value->COMPP_Codigo;
	$objeto->tipCa_FlagEstado=$value->tipCa_FlagEstado;
	$lista_detalles[] = ($objeto);
}
    $resultado[] = array();
    $resultado = json_encode($lista_detalles,JSON_NUMERIC_CHECK);
    echo  $resultado;
}
}//final del metodo

public function JSON_ActualizarTipoCaja($codigo){
	$this->tipocaja_model->getActualizarTipoCaja($codigo);
}

}