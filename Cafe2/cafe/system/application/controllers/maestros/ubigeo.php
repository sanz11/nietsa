<?php
class Ubigeo extends Controller{
	public function __construct(){
		parent::Controller();
		$this->load->helper('form');
		$this->load->library('form_validation');	
		$this->load->library('html');
        $this->load->model('maestros/ubigeo_model');
		$this->load->library('layout','layout');  
	}
	public function index(){
		$this->layout->view('seguridad/inicio');	
	}
	function formulario_ubigeo($ubigeo){
		if($ubigeo=='000000') $ubigeo="150100";
		$departamento = substr($ubigeo,0,2);
		$provincia    = substr($ubigeo,2,2);
		$distrito     = substr($ubigeo,4,2);
		$data['cbo_dpto'] = $this->seleccionar_departamento($departamento);	
		$data['cbo_prov'] = $this->seleccionar_provincia($departamento,$provincia);
		$data['cbo_dist'] = $this->seleccionar_distritos($departamento,$provincia,$distrito);	
		$this->load->view('maestros/formulario_ubigeo',$data);
	}
	function formulario_ubigeo_complementario($ubigeo,$seccion,$nro_fila){
		$departamento = substr($ubigeo,0,2);
		$provincia    = substr($ubigeo,2,2);
		$distrito     = substr($ubigeo,4,2);
		$data['seccion']  = $seccion;
		$data['nro_fila']  = $nro_fila;
		$data['cbo_dpto'] = $this->seleccionar_departamento($departamento);	
		$data['cbo_prov'] = $this->seleccionar_provincia($departamento,$provincia);
		$data['cbo_dist'] = $this->seleccionar_distritos($departamento,$provincia,$distrito);	
		$this->load->view('maestros/formulario_ubigeo_complementario',$data);
	}	
	function cargar_ubigeo($departamento,$provincia=''){
		$cbo_dpto = $this->seleccionar_departamento($departamento);	
		$cbo_prov = $this->seleccionar_provincia($departamento,$provincia);
		$cbo_dist = $this->seleccionar_distritos($departamento,$provincia,'');	
		$fila     = "<select id='cboDepartamento' name='cboDepartamento' class='comboMedio' onchange='cargar_provincia(this);'>";
        $fila    .= $cbo_dpto;
		$fila    .= "</select>&nbsp;&nbsp;";
		$fila    .= "Provincia&nbsp;&nbsp;";
		$fila    .= "<select id='cboProvincia' name='cboProvincia' class='comboMedio' onchange='cargar_distrito(this);'>";
		$fila    .= $cbo_prov;
		$fila    .= "</select>&nbsp;&nbsp;";
		$fila    .= "Distrito&nbsp;&nbsp;";
        $fila    .= "<select id='cboDistrito' name='cboDistrito' class='comboMedio'>";
		$fila    .= $cbo_dist;
		$fila    .= "</select>";		
        echo $fila;                            
	}	
	function seleccionar_departamento($indDefault=''){
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
	function seleccionar_provincia($departamento,$indDefault=''){
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
	function seleccionar_distritos($departamento,$provincia,$indDefault=''){
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
}
?>