<?php
class Tipocliente extends controller
{
    public function __construct()
    {
        parent::Controller();
        $this->load->model('ventas/tipocliente_model');
        $this->load->helper('form','url');
        $this->load->library('pagination');
        $this->load->library('form_validation');
        $this->somevar['compania'] = $this->session->userdata('compania');
    }
    
    public function listar($j='0')
    {
        $this->load->library('layout', 'layout');
        $data['txtAlmacen'] = "";
        $data['registros']  = count($this->tipocliente_model->listar());
        $conf['base_url']   = site_url('ventas/tipocliente/listar/');
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
        $listado            = $this->tipocliente_model->listar($conf['per_page'],$offset);
        $item               = $j+1;
        $lista              = array();
        if(count($listado)>0){
            foreach($listado as $indice=>$valor)
            {
                $codigo         = $valor->TIPCLIP_Codigo;
                $editar         = "<a href='#' onclick='editar_tipocliente(".$codigo.")'><img src='".base_url()."images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
                $ver            = "<a href='#' onclick='ver_tipocliente(".$codigo.")'><img src='".base_url()."images/ver.png' width='16' height='16' border='0' title='Ver'></a>";
                $eliminar       = "<a href='#' onclick='eliminar_tipocliente(".$codigo.")'><img src='".base_url()."images/eliminar.png' width='16' height='16' border='0' title='Eliminar'></a>";
                $lista[]        = array(
                                    $item++,
                                    $valor->TIPCLIC_Descripcion,
                                    $editar,
                                    $ver,
                                    $eliminar
                                  );
            }
        }
        $data['lista']           = $lista;
        $data['titulo_busqueda'] = "BUSCAR CATEGORÍAS DE CLIENTES";
        $data['nombre_tipocliente']  = form_input(array( 'name'  => 'nombre_tipocliente','id' => 'nombre_tipocliente','value' => '','maxlength' => '100','class' => 'cajaMedia'));
        $data['form_open']       = form_open(base_url().'index.php/ventas/tipocliente/buscar',array("name"=>"form_busquedaTipoCliente","id"=>"form_busquedaTipoCliente"));
        $data['form_close']      = form_close();
        $data['titulo_tabla']    = "Relaci&oacute;n DE CATEGORÍAS DE CLIENTES";
        $data['oculto']          = form_hidden(array('accion'=>"",'codigo'=>"",'modo'=>"insertar",'base_url'=>base_url()));	
        $this->layout->view('ventas/tipocliente_index',$data);
			
    }
    public function nuevo()
    {
        $this->load->library('layout', 'layout');
        $lblDescripcion     = form_label("Nombre de la Categoría","NombreCategoria");
        $nombre_tipocliente = form_input(array( 'name'  => 'descripcion','id' => 'descripcion','value' => '','maxlength' => '100','class' => 'cajaMedia'));
        $data['titulo']     = "REGISTRAR CATEGORÍA DE CLIENTE";
        $data['form_open']  = form_open(base_url().'index.php/ventas/tipocliente/grabar',array("name"=>"frmTipoCliente","id"=>"frmTipoCliente"));
        $data['form_close'] = form_close();
        $data['campos']     = array($lblDescripcion);
        $data['valores']    = array($nombre_tipocliente);
        $data['oculto']     = form_hidden(array('codigo'=>"",'base_url'=>base_url(),'tipocliente_id'=>''));
        $data['onload']	    = "onload=\"$('#descripcion').focus();\"";
        $this->layout->view('ventas/tipocliente_nuevo',$data);
    }
    public function editar($id)
    {
        $this->load->library('layout', 'layout');
        $oTipoCliente           = $this->tipocliente_model->obtener($id);
        $lblDescripcion         = form_label("Nombre de la Categoría","NombreCategoria");
        $nombre_tipocliente     = form_input(array( 'name'  => 'descripcion','id' => 'descripcion','value' => $oTipoCliente[0]->TIPCLIC_Descripcion,'maxlength' => '100','class' => 'cajaMedia'));
        $data['form_open']      = form_open(base_url().'index.php/ventas/tipocliente/grabar',array("name"=>"frmTipoCliente","id"=>"frmTipoCliente"));
        $data['campos']         = array($lblDescripcion);
        $data['valores']        = array($nombre_tipocliente);
        $data['oculto']         = form_hidden(array('codigo'=>"",'base_url'=>base_url(),'tipocliente_id'=>$id));
        $data['form_hidden']    = form_hidden("base_url",base_url());
        $data['form_close']     = form_close();
        $data['tipocliente_id'] = form_hidden("tipocliente_id",$id);
        $data['titulo']  = "Editar CATEGORÍA DE CLIENTE";
        $this->layout->view('ventas/tipocliente_nuevo',$data);
    }
    public function grabar()
    {
        $this->form_validation->set_rules('descripcion','Nombre de categoría','required');
        if($this->form_validation->run() == FALSE){
            $this->nuevo();
        }
        else{
            $descripcion  = $this->input->post("descripcion");
            $tipocliente_id   = $this->input->post("tipocliente_id");
            $filter = new stdClass();
            $filter->TIPCLIC_Descripcion = strtoupper($descripcion);
            if(isset($tipocliente_id) && $tipocliente_id>0){
              $this->tipocliente_model->modificar($tipocliente_id,$filter);
            }
            else{
               $filter->COMPP_Codigo = $this->somevar['compania'];
               $this->tipocliente_model->insertar($filter);
            }
            header("location:".base_url()."index.php/ventas/tipocliente/listar");header("location:".base_url()."index.php/ventas/tipocliente/listar");
        }
    }
    public function eliminar($id)
    {
        //$id = $this->input->post('tipocliente');
        $var = $this->tipocliente_model->eliminar($id);
        if($var)
        {
            header("location:".base_url()."index.php/ventas/tipocliente/listar");
        }
    }
    public function ver($codigo)
    {
        $this->load->library('layout', 'layout');
        $datos_tipocliente     = $this->tipocliente_model->obtener($codigo);
        $nombre_tipocliente    = $datos_tipocliente[0]->TIPCLIC_Descripcion;
        $data['nombre_tipocliente']     = $nombre_tipocliente;
        $data['titulo']        = "VER CATEGORÍA DE CLIENTE";
        $data['oculto']        = form_hidden(array('base_url'=>base_url()));
        $this->layout->view('ventas/tipocliente_ver',$data);
    }
    public function buscar($j=0)
    {
        $this->load->library('layout','layout');
        $nombre_tipocliente     = $this->input->post('nombre_tipocliente');
        $filter = new stdClass();
        $filter->TIPCLIC_Descripcion = $nombre_tipocliente;
        $data['registros']      = count($this->tipocliente_model->buscar($filter));
        $conf['base_url']       = site_url('ventas/tipocliente/buscar/');
        $conf['per_page']       = 10;
        $conf['num_links']      = 3;
        $conf['first_link']     = "&lt;&lt;";
        $conf['last_link']      = "&gt;&gt;";
        $conf['total_rows']     = $data['registros'];
        $offset                 = (int)$this->uri->segment(4);
        $listado                = $this->tipocliente_model->buscar($filter,$conf['per_page'],$offset);
        $item                   = $j+1;
        $lista                  = array();
        if(count($listado)>0){
            foreach($listado as $indice=>$valor)
            {
                $codigo         = $valor->TIPCLIP_Codigo;
                $editar         = "<a href='#' onclick='editar_tipocliente(".$codigo.")'><img src='".base_url()."images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
                $ver            = "<a href='#' onclick='ver_tipocliente(".$codigo.")'><img src='".base_url()."images/ver.png' width='16' height='16' border='0' title='Ver'></a>";
                $eliminar       = "<a href='#' onclick='eliminar_tipocliente(".$codigo.")'><img src='".base_url()."images/eliminar.png' width='16' height='16' border='0' title='Eliminar'></a>";
                $lista[]        = array($item++,$valor->TIPCLIC_Descripcion,$editar,$ver,$eliminar);
            }
        }
        $data['titulo_tabla']       = "RESULTADO DE BUSQUEDA de CATEGORÍAS";
        $data['titulo_busqueda']    = "BUSCAR CATEGORÍAS DE CLIENTES";
        $data['nombre_tipocliente'] = form_input(array( 'name'  => 'nombre_tipocliente','id' => 'nombre_tipocliente','value' => $nombre_tipocliente,'maxlength' => '100','class' => 'cajaMedia'));
        $data['form_open']          = form_open(base_url().'index.php/ventas/tipocliente/buscar',array("name"=>"form_busquedaTipoCliente","id"=>"form_busquedaTipoCliente"));
        $data['form_close']         = form_close();
        $data['lista']              = $lista;
        $data['oculto']             = form_hidden(array('base_url'=>base_url()));
        $this->pagination->initialize($conf);
        $data['paginacion'] = $this->pagination->create_links();
        $this->layout->view('ventas/tipocliente_index',$data);
    }
}
?>