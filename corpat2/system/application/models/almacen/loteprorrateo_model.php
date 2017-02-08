<?php
class Loteprorrateo_Model extends Model
{
    protected $_name = "cji_loteprorrateo";
    protected $_hoy;
    public function  __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->somevar['compania'] = $this->session->userdata('compania');
        $this->_hoy                = date("%Y-%m-%d %h:%i:%s",time());
    }
 
    public function listar($lote)
    {   $where = array('LOTPROC_FlagEstado'=>'1', 'LOTP_Codigo'=>$lote);
        $query = $this->db->order_by('LOTPROC_FechaRegistro', 'DESC')->where($where)->get('cji_loteprorrateo');
        if($query->num_rows>0){
           //return $query->result();
           foreach($query->result() as $fila){
               $tipo='';
               switch($fila->LOTPROC_Tipo){
                    case 1 : $tipo='CON EL MISMO PRODUCTO'; break;
                    case 2 : $tipo='CON OTRO MISMO PRODUCTO'; break;
                    case 3 : $tipo='CON NOTA DE CREDITO'; break;
                    case 4 : $tipo='CON DEPOSITO'; break;
               }
               $fila->LOTPROC_TipoDesc=$tipo;
               $data[] = $fila;
            }
            return $data;
        }
        else
            return array();
    }
    
    public function obtener($id)
    {
        $where = array("LOTPROP_Codigo"=>$id);
        $query = $this->db->where($where)->get('cji_loteprorrateo');
        if($query->num_rows>0){
          return $query->row();
        }
            
    }
    
    public function insertar(stdClass $filter = null)
    {
        $this->db->insert("cji_loteprorrateo",(array)$filter);
        return $this->db->insert_id();
    }
    
}
?>