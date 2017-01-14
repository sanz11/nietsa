<?php
class Guiaremdetalle_Model extends Model
{
    protected $_name = "cji_guiaremdetalle";
     public function  __construct()
     {
        parent::__construct();
        $this->load->database();
        $this->somevar ['compania'] = $this->session->userdata('compania');
        $this->somevar ['usuario']  = $this->session->userdata('user');
     }
     public function listar($guiarem, $number_items='',$offset='')
     {
        $where = array("GUIAREMP_Codigo"=>$guiarem, "GUIAREMDETC_FlagEstado"=>1);
        $query = $this->db->order_by('GUIAREMDETP_Codigo')->where($where)->get('cji_guiaremdetalle',$number_items,$offset);
        if($query->num_rows>0){
                return $query->result();
        }
     }
     public function obtener($id)
     {
        $where = array("GUIAREMDETP_Codigo"=>$id,"GUIAREMDETC_FlagEstado"=>"1");
        $query = $this->db->where($where)->get('cji_guiaremdetalle',1);
        if($query->num_rows>0){
          return $query->result();
        }
     }
     public function obtener2($guiarem_id)
     {
        $where = array("GUIAREMP_Codigo"=>$guiarem_id,"GUIAREMDETC_FlagEstado"=>"1");
        $query = $this->db->where($where)->order_by('GUIAREMDETP_Codigo')->get('cji_guiaremdetalle');
        if($query->num_rows>0){
          return $query->result();
        }
     }
	 
    public function insertar(stdClass $filter = null)
    {
        $this->db->insert("cji_guiaremdetalle",(array)$filter);
    }
     public function modificar($id,$filter)
     {
        $this->db->where("GUIAREMDETP_Codigo",$id);
        $this->db->update("cji_guiaremdetalle",(array)$filter);
     }
     public function eliminarDetalle($id){
           $data  = array("GUIAREMDETC_FlagEstado"=>'0');
    $this->db->where('GUIAREMDETP_Codigo',$id);
    $this->db->update('cji_guiaremdetalle',$data);

        
     }
     public function eliminar($id)
     {
         $this->db->delete('cji_guiaremdetalle', array('GUIAREMDETP_Codigo' => $id));
     }
     public function eliminar2($id)
     {
         $this->db->delete('cji_guiaremdetalle', array('GUIAREMP_Codigo' => $id));
     }
}
?>