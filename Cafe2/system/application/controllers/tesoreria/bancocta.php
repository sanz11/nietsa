<?php
class Bancocta extends controller
{
    public function __construct()
    {
        parent::Controller();
        $this->load->helper('html');
        $this->load->helper('url');
        $this->load->library('pagination');
        $this->load->library('html');
        $this->load->library('form_validation');
        $this->load->model('tesoreria/bancocta_model');        
        $this->somevar['compania'] = $this->session->userdata('compania');
    }
    public function JSON_listar($banco)
    {
        $lista_cta=$this->bancocta_model->listar($banco);
        echo json_encode($lista_cta);
			
    }
  
}
?>