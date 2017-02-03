<?php
class Unidadmedida extends controller
{
    public function __construct()
    {
        parent::Controller();
        $this->load->model('almacen/unidadmedida_model');
        $this->load->helper('form','url');
        $this->load->library('pagination');
        $this->load->library('form_validation');
        $this->somevar['compania'] = $this->session->userdata('compania');
    }
    public function listar($j='0')
    {
        $this->load->library('layout', 'layout');
        $data['registros']  = count($this->unidadmedida_model->listar());
        $conf['base_url']   = site_url('almacen/unidadmedida/listar/');
        $conf['total_rows'] = $data['registros'];
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
        $listado            = $this->unidadmedida_model->listar($conf['per_page'],$offset);
        $item               = $j+1;
        foreach($listado as $indice=>$valor)
        {
            $codigo         = $valor->UNDMED_Codigo;
            $editar         = "<a href='#' onclick='editar_unidadmedida(".$codigo.")'><img src='".base_url()."images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
            $ver            = "<a href='#' onclick='ver_unidadmedida(".$codigo.")'><img src='".base_url()."images/ver.png' width='16' height='16' border='0' title='Modificar'></a>";
            $eliminar       = "<a href='#' onclick='eliminar_unidadmedida(".$codigo.")'><img src='".base_url()."images/eliminar.png' width='16' height='16' border='0' title='Modificar'></a>";
            $lista[]        = array($item++,$valor->UNDMED_Descripcion,$valor->UNDMED_Simbolo,$editar,$ver,$eliminar);
        }
        $data['lista']           = $lista;
        $data['titulo_busqueda'] = "BUSCAR UNIDAD MEDIDA";
        $data['nombre_unidadmedida'] = form_input(array( 'name'  => 'nombre_unidadmedida','id' => 'nombre_unidadmedida','value' => '','maxlength' => '100','class' => 'cajaMedia'));
        $data['simbolo']         = form_input(array( 'name'  => 'simbolo','id' => 'simbolo','value' => '','maxlength' => '100','class' => 'cajaMedia'));
        $data['form_open']       = form_open(base_url().'index.php/almacen/unidadmedida/buscar',array("name"=>"form_busquedaUnidadmedida","id"=>"form_busquedaUnidadmedida"));
        $data['form_close']      = form_close();
        $data['titulo_tabla']    = "Relaci&oacute;n UNIDAD DE MEDIDAS";
        $data['oculto']          = form_hidden(array('accion'=>"",'codigo'=>"",'modo'=>"insertar",'base_url'=>base_url()));	
        $this->layout->view('almacen/unidadmedida_index',$data);
			
    }
    public function nueva()
    {
        $this->load->library('layout', 'layout');
        $lblDescripcion     = form_label("Nombre Unidad","Nombre Unidad de medida");
        $lblSimbolo         = form_label('Simbolo','Simbolo');
        $nombre_unidadmedida     = form_input(array( 'name'  => 'nombre_unidadmedida','id' => 'nombre_unidadmedida','value' => '','maxlength' => '100','class' => 'cajaMedia'));
        $simbolo            = form_input(array( 'name'  => 'simbolo','id' => 'simbolo','value' => '','maxlength' => '100','class' => 'cajaMedia'));
        $data['titulo']     = "REGISTRAR UNIDAD DE MEDIDA";
        $data['form_open']  = form_open(base_url().'index.php/almacen/unidadmedida/grabar',array("name"=>"frmUnidadmedida","id"=>"frmUnidadmedida"));
        $data['form_close'] = form_close();
        $data['campos']     = array($lblDescripcion,$lblSimbolo);
        $data['valores']    = array($nombre_unidadmedida,$simbolo);
        $data['oculto']     = form_hidden(array('codigo'=>"",'base_url'=>base_url(),'unidadmedida_id'=>''));
        $data['onload']	    = "onload=\"$('#nombres').focus();\"";
        $this->layout->view('almacen/unidadmedida_nueva',$data);
    }
    public function editar($id)
    {
        $this->load->library('layout', 'layout');
        $oUnidadmedida          = $this->unidadmedida_model->obtener($id);
        $lblDescripcion         = form_label("Nombre Unidad","Nombre Unidad de medida");
        $lblSimbolo             = form_label("Simbolo","Simbolo");
        $nombre_unidadmedida    = form_input(array( 'name'  => 'nombre_unidadmedida','id' => 'nombre_unidadmedida','value' => $oUnidadmedida[0]->UNDMED_Descripcion,'maxlength' => '100','class' => 'cajaMedia'));
        $simbolo                = form_input(array( 'name'  => 'simbolo','id' => 'simbolo','value' => $oUnidadmedida[0]->UNDMED_Simbolo,'maxlength' => '100','class' => 'cajaMedia'));
        $data['form_open']      = form_open(base_url().'index.php/almacen/unidadmedida/grabar/',array("name"=>"frmUnidadmedida","id"=>"frmUnidadmedida"));
        $data['campos']         = array($lblDescripcion,$lblSimbolo);
        $data['valores']        = array($nombre_unidadmedida,$simbolo);
        $data['oculto']         = form_hidden(array('codigo'=>"",'base_url'=>base_url(),'unidadmedida_id'=>$id));
        $data['form_hidden']    = form_hidden("base_url",base_url());
        $data['form_close']     = form_close();
        $data['unidadmedida_id']= form_hidden("unidadmedida_id",$id);
        $data['titulo']  = "EDITAR UNIDAD MEDIDA";
        $this->layout->view('almacen/unidadmedida_nueva',$data);
    }
    public function grabar()
    {
        $this->form_validation->set_rules('nombre_unidadmedida','Nombre de unidad medida','required');
        $this->form_validation->set_rules('simbolo','Simbolo','required');
        if($this->form_validation->run() == FALSE){
            $this->nueva();
        }
        else{
            $nombre_unidadmedida  = $this->input->post("nombre_unidadmedida");
            $simbolo = $this->input->post("simbolo");
            $unidadmedida_id = $this->input->post("unidadmedida_id");
            $filter = new stdClass();
            $filter->UNDMED_Descripcion = strtoupper($nombre_unidadmedida);
            $filter->UNDMED_Simbolo     = $simbolo;
            if(isset($unidadmedida_id) && $unidadmedida_id>0){
              $this->unidadmedida_model->modificar($unidadmedida_id,$filter);
            }
            else{
               $this->unidadmedida_model->insertar($filter);
            }
            header("location:".base_url()."index.php/almacen/unidadmedida/listar");
        }
    }
    public function eliminar()
    {
        $id = $this->input->post('unidadmedida');
        $this->unidadmedida_model->eliminar($id);
    }
    public function ver($codigo)
    {
        $this->load->library('layout', 'layout');
        $datos_umedida         = $this->unidadmedida_model->obtener($codigo);
        $nombre_umedida        = $datos_umedida[0]->UNDMED_Descripcion;
        $simbolo               = $datos_umedida[0]->UNDMED_Simbolo;
        $data['nombre_unidadmedida']     = $nombre_umedida;
        $data['simbolo']       = $simbolo;
        $data['titulo']        = "VER UNIDAD MEDIDA";
        $data['oculto']        = form_hidden(array('base_url'=>base_url()));
        $this->layout->view('almacen/unidadmedida_ver',$data);
    }
    public function buscar($j=0)
    {
        $this->load->library('layout','layout');
        $nombre_unidadmedida    = $this->input->post('nombre_unidadmedida');
        $simbolo                = $this->input->post('simbolo');
        $filter = new stdClass();
        $filter->UNDMED_Descripcion = $nombre_unidadmedida;
        $filter->UNDMED_Simbolo     = $simbolo;
        $data['registros']      = count($this->unidadmedida_model->buscar($filter));
        $conf['base_url']       = site_url('maestros/unidadmedida/buscar/');
        $conf['total_rows']     = $data['registros'];
        $conf['per_page']       = 10;
        $conf['num_links']      = 3;
        $conf['first_link']     = "&lt;&lt;";
        $conf['last_link']      = "&gt;&gt;";
        $offset                 = (int)$this->uri->segment(4);
        $listado                = $this->unidadmedida_model->buscar($filter,$conf['per_page'],$offset);
        $item                   = $j+1;
        $lista                  = array();
        if(count($listado)>0){
            foreach($listado as $indice=>$valor){
                $codigo       = $valor->UNDMED_Codigo;
                $editar       = "<a href='#' onclick='editar_unidadmedida(".$codigo.")' target='_parent'><img src='".base_url()."images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
                $ver          = "<a href='#' onclick='ver_unidadmedida(".$codigo.")' target='_parent'><img src='".base_url()."images/ver.png' width='16' height='16' border='0' title='Modificar'></a>";
                $eliminar     = "<a href='#' onclick='eliminar_unidadmedida(".$codigo.")' target='_parent'><img src='".base_url()."images/eliminar.png' width='16' height='16' border='0' title='Modificar'></a>";
                $lista[]      = array($item++,$valor->UNDMED_Descripcion,$valor->UNDMED_Simbolo,$editar,$ver,$eliminar);
            }
        }
        $data['titulo_tabla']    = "RESULTADO DE BUSQUEDA de UNIDADES DE MEDIDA";
        $data['titulo_busqueda'] = "BUSCAR UNIDAD MEDIDA";
        $data['nombre_unidadmedida'] = form_input(array( 'name'  => 'nombre_unidadmedida','id' => 'nombre_unidadmedida','value' => $nombre_unidadmedida,'maxlength' => '100','class' => 'cajaMedia'));
        $data['simbolo']         = form_input(array( 'name'  => 'simbolo','id' => 'simbolo','value' => $simbolo,'maxlength' => '100','class' => 'cajaMedia'));
        $data['form_open']       = form_open(base_url().'index.php/almacen/unidadmedida/buscar',array("name"=>"form_busquedaUnidadmedida","id"=>"form_busquedaUnidadmedida"));
        $data['form_close']      = form_close();
        $data['lista']           = $lista;
        $data['oculto']          = form_hidden(array('base_url'=>base_url()));
        $this->pagination->initialize($conf);
        $data['paginacion'] = $this->pagination->create_links();
        $this->layout->view('almacen/unidadmedida_index',$data);
    }
}
?>