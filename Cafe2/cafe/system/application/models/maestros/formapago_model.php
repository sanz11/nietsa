<?php
class Formapago_Model extends Model
{
    protected $_name = "cji_formapago";
    public function  __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function seleccionar()
    {
        $arreglo = array(''=>':: Seleccione ::');
        foreach($this->listar() as $indice=>$valor)
        {
            $indice1   = $valor->FORPAP_Codigo;
            $valor1    = $valor->FORPAC_Descripcion;
            $arreglo[$indice1] = $valor1;
        }
        return $arreglo;
    }
     public function listar($number_items='',$offset='')
     {
        $where = array("FORPAC_FlagEstado"=>1);
        $query = $this->db->order_by('FORPAC_Descripcion')->where($where)->where_not_in('FORPAP_Codigo','0')->get('cji_formapago',$number_items,$offset);
        if($query->num_rows>0){
                return $query->result();
        }
     }
     public function obtener($id)
     {
        $where = array("FORPAP_Codigo"=>$id);
        $query = $this->db->order_by('FORPAC_Descripcion')->where($where)->get('cji_formapago',1);
        if($query->num_rows>0){
          return $query->result();
        }
     }
     public function obtener2($id)
     {
        $where = array("FORPAP_Codigo"=>$id);
        $query = $this->db->order_by('FORPAC_Descripcion')->where($where)->get('cji_formapago',1);
        if($query->num_rows>0){
            foreach($query->result() as $fila){
                    $data[] = $fila;
            }
            return $data;
        }
     }
    public function insertar(stdClass $filter = null)
    {
        $this->db->insert("cji_formapago",(array)$filter);
    }
    public function modificar($id,$filter)
    {
        $this->db->where("FORPAP_Codigo",$id);
        $this->db->update("cji_formapago",(array)$filter);
    }
    public function eliminar($id)
    {
        $this->db->delete('cji_formapago', array('FORPAP_Codigo' => $id));
    }
    public function buscar($filter,$number_items='',$offset='')
    {
        $this->db->where("FORPAC_FlagEstado",1);
        if(isset($filter->FORPAC_Descripcion) && $filter->FORPAC_Descripcion!='')
            $this->db->like('FORPAC_Descripcion',$filter->FORPAC_Descripcion,'right');
        $query = $this->db->get('cji_formapago',$number_items,$offset);
        if($query->num_rows>0){
                return $query->result();
        }
    }
}
?>