<?php
class Banco_Model extends Model
{
    protected $_name = "cji_banco";
    public function  __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    public function listar()
    {   $where = array("BANC_FlagEstado"=>"1");
        
        $query = $this->db->order_by('BANC_Nombre')
                ->get('cji_banco');
        if($query->num_rows>0){
          return $query->result();
        }
    }
    
    public function obtener($banco)
    {
        $query = $this->db->where('BANP_Codigo',$banco)->get('cji_banco');
        if($query->num_rows>0){
            foreach($query->result() as $fila){
                $data[] = $fila;
            }
            return $data;
        }
    }
    
   
}
?>