<?php
class Pedidodetalle_model extends Model{
    var $somevar;
	protected $_name = 'cji_pedidodetalle';
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('date');
        $this->somevar ['compania'] = $this->session->userdata('compania');
        $this->somevar ['user']  = $this->session->userdata('user');
        $this->somevar['hoy']       = mdate("%Y-%m-%d %h:%i:%s",time());
    }
	public function listar($cod_pedido)
    {
        $where = array("PEDIP_Codigo"=>$cod_pedido,"PEDIDETC_FlagEstado"=>"1");
        $query = $this->db->order_by('PEDIDETP_Codigo')->where($where)->get($this->_name);
        if($query->num_rows>0){
            foreach($query->result() as $fila){
                $data[] = $fila;
            }
            return $data;
        }
    }
	
    public function insertar($filter=null)
    {
        $this->db->insert($this->_name,(array)$filter);
    }
	public function insertar_varios($filter=null,$cod_pedido){
		$filter->PEDIP_Codigo = $cod_pedido;
        $this->db->insert($this->_name,(array)$filter);
    }
     public function modificar($presupuesto_detalle,$filter=null)
    {
        $where = array("PRESDEP_Codigo"=>$presupuesto_detalle);
        $this->db->where($where);
        $this->db->update($this->_name,(array)$filter);
    }
    public function eliminar($presupuesto_detalle)
    {
        $data      = array("PRESDEC_FlagEstado"=>'0');
        $where = array("PRESDEP_Codigo"=>$presupuesto_detalle);
        $this->db->where($where);
        $this->db->update($this->_name,$data);
    }
	
	public function eliminar_x_pedido($cod_pedido){
        $where = array("PEDIP_Codigo"=>$cod_pedido);
        $this->db->where($where);
        $this->db->delete($this->_name,$data);
	}
    
}
?>