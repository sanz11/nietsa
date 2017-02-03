<?php
class Productoproveedor_Model extends Model
{
    protected $_name = "cji_productoproveedor";
    public function  __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->somevar['compania'] = $this->session->userdata('compania');
    }
    public function listar_proveedores($producto_id)
    {
        $where = array('PRODPROVC_FlagEstado'=>'1','PROD_Codigo'=>$producto_id);
        $this->db->select('*');
        $this->db->from('cji_productoproveedor');
        $this->db->join('cji_proveedor','cji_proveedor.PROVP_Codigo=cji_productoproveedor.PROVP_Codigo');
        $this->db->where($where);
        $query = $this->db->get();
        if($query->num_rows>0){
          return $query->result();
        }
    }
    public function listar_productos($proveedor_id)
    {
        $where = array('PRODPROVC_FlagEstado'=>'1','PROVP_Codigo'=>$proveedor_id);
        $this->db->select('*');
        $this->db->from('cji_productoproveedor');
        $this->db->join('cji_producto','cji_producto.PROD_Codigo=cji_productoproveedor.PROD_Codigo');
        $this->db->where($where);
        $query = $this->db->get();
        if($query->num_rows>0){
          return $query->result();
        }
    }
    public function obtener($producto_id,$proveedor_id)
    {
        $where = array("PRODPROVC_FlagEstado"=>"1","PROD_Codigo"=>$producto_id,"PROVP_Codigo"=>$proveedor_id);
        $query = $this->db->where($where)->get('cji_productoproveedor');
        if($query->num_rows>0){
          return $query->row();
        }
    }
    public function insertar(stdClass $filter = null)
    {
        $this->db->insert("cji_productoproveedor",(array)$filter);
    }
    public function modificar($id,$filter)
    {
        $this->db->where("PRODPROVP_Codigo",$id);
        $this->db->update("cji_productoproveedor",(array)$filter);
    }
    public function eliminar($id)
    {
        $this->db->delete('cji_productoproveedor',array('PRODPROVP_Codigo' => $id));
    }
    public function eliminar_proveedores($producto)
    {
        $this->db->delete('cji_productoproveedor',array('PROD_Codigo' => $producto));
    }
}
?>