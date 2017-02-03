<?php
// ini_set('error_reporting', 1);


class State extends Controller {

	public function __construct() {
		parent::Controller();
		$this->load->helper('form');
		$this->load->helper('date');
		$this->load->library('form_validation');
		$this->load->model('maestros/documento_model');
		$this->load->model('maestros/state_model');
		$this->load->library('html');
		$this->load->library('pagination');
		$this->load->library('layout','layout');
		$this->somevar ['compania'] = $this->session->userdata('compania');
		$this->somevar['hoy']       = mdate("%Y-%m-%d %h:%i:%s",time());
		$this->somevar ['user'] = $this->session->userdata('user');

	}

	public function index() {
		$this->layout->view('seguridad/inicio');
	}

	public function state_index($j='0'){
		$data['txtCargo']   = "";
		$data['cboDocumento'] = $this->OPTION_generador($this->documento_model->listar(), 'DOCUP_Codigo','DOCUC_Descripcion','13');

		$conf['per_page']   = 10;
		$conf['num_links']  = 3;
		$conf['next_link'] = "&gt;";
		$conf['prev_link'] = "&lt;";
		$conf['first_link'] = "&lt;&lt;";
		$conf['last_link']  = "&gt;&gt;";
		$conf['uri_segment'] = 4;
		$offset             = (int)$this->uri->segment(4);
		$this->pagination->initialize($conf);
		$data['paginacion'] = $this->pagination->create_links();
		$lista_estados      = $this->state_model->listar_estados($conf['per_page'],$offset);
		$item               = $j+1;
		$lista               = array();
		if(count($lista_estados)>0){
			foreach($lista_estados as $indice=>$valor){
				$codigo = $valor->STATE_Codigo;
				$estado = $valor->STATE_Estado;
				// 				$color = $valor->STATE_Color;
				$descripcion = $valor->STATE_Descripcion;
				$documentocodigo = $valor->DOCUP_Codigo;

				$buscaDocumento = $this->documento_model->obtener($documentocodigo);
				$descripdocumento =$buscaDocumento[0]->DOCUC_Descripcion;

				$eliminar       = "<a href='#' onclick='eliminar_state(".$codigo.")'><img src='".base_url()."images/eliminar.png' width='16' height='16' border='0' title='Eliminar'></a>";
				$lista[]        = array($item++,$estado,$descripdocumento,$descripcion,$eliminar);
			}
		}
		$data['titulo_busqueda'] = "BUSCAR AREA";
		$data['lista']      = $lista;

		$this->layout->view('maestros/state_index',$data);
	}

	public function state_nuevo($nombreColor){
// 		echo "<script>alert('nombrecolor : ".$nombreColor."')</script>";
		$filter = new stdClass();
		$filter->STATE_Estado = $this->input->post('txtEstado');
		$filter->STATE_Descripcion = $this->input->post('txtdescripcion');
		$filter->DOCUP_Codigo = $this->input->post('cbodocumento');
		$filter->STATE_Color = $nombreColor;
		$this->state_model->insertar_state($filter);
	}


	public function state_eliminar(){
		$codigo = $this->input->post('codigo');

		$this->state_model->eliminar_state($codigo);
	}


	public function reportefinal_index(){
		
		$data['txtCargo']   = "";
		$data['cboDocumento'] = $this->OPTION_generador($this->documento_model->listar(), 'DOCUP_Codigo','DOCUC_Descripcion','13');



		$this->layout->view('maestros/reportefinal_index',$data);
	}

	public function guardar_reportefinal(){
		$fechaRegistro = mdate("%Y-%m-%d ", time());
		
		$txtreportefinal = $this->input->post('reportefinal');
		$txtdescripcion = $this->input->post('descripcion');
		$txtcbodocumento = $this->input->post('cbodocumento');
		$filter = new stdClass();

		$filter->REPORFIN_Nombre = $txtreportefinal;
		$filter->REPORFIN_Descripcion = $txtdescripcion;
		$filter->DOCUP_Codigo = $txtcbodocumento;
		$filter->REPORFIN_FechaRegistro = $fechaRegistro;
		$filter->REPORFIN_FlagEstado = "1";

		$this->state_model->guardar_reportefinal($filter);
		$result = array();

		$listado_reportefinal = $this->state_model->buscar_reportefinal();
		if($listado_reportefinal !=null && count($listado_reportefinal)){
			foreach($listado_reportefinal as $indice=>$valor){
				$nombre = $valor->REPORFIN_Nombre;
				$documento = $valor->DOCUP_Codigo;
				$descripcion =	$valor->REPORFIN_Descripcion;
				$result[] = array("nombre" => $nombre , "documento" => $documento , "descripcion" => $descripcion );

			}
		}

		echo json_encode($result);
	}




}

?>