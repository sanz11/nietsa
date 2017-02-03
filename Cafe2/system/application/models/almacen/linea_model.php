<?php
class Linea_Model extends Model
{
    protected $_name = "cji_linea";
    public function  __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function seleccionar()
    {
        $arreglo = array('0'=>':: Seleccione ::');
        if(count($this->listar())>0){
            foreach($this->listar() as $indice=>$valor)
            {
                $indice1   = $valor->LINP_Codigo;
                $valor1    = $valor->LINC_Descripcion;
                $arreglo[$indice1] = $valor1;
            }
        }
        return $arreglo;
    }
     public function listar($number_items='',$offset='')
     {
        $where = array("LINC_FlagEstado"=>1,"LINP_Codigo !="=>0);
        $query = $this->db->order_by('LINC_Descripcion')->where($where)->get($this->_name,$number_items,$offset);
        if($query->num_rows>0){
                return $query->result();
        }
     }	 
     public function obtener($id)
     {
        $where = array("LINP_Codigo"=>$id);
        $query = $this->db->order_by('LINC_Descripcion')->where($where)->get($this->_name,1);
        if($query->num_rows>0){
          return $query->result();
        }
     }
    public function insertar(stdClass $filter = null)
    {
        $this->db->insert($this->_name,(array)$filter);
    }
    public function modificar($id,$filter)
    {
        $this->db->where("LINP_Codigo",$id);
        $this->db->update($this->_name,(array)$filter);
    }
    public function eliminar($id)
    {
        $this->db->delete($this->_name, array('LINP_Codigo' => $id));
    }
    public function buscar($filter,$number_items='',$offset='')
    {
        $where = array("LINC_FlagEstado"=>1,"LINP_Codigo !="=>0);
        $this->db->where($where);
        if(isset($filter->LINC_Descripcion) && $filter->LINC_Descripcion!='')
            $this->db->like('LINC_Descripcion',$filter->LINC_Descripcion,'right');
        $query = $this->db->get($this->_name,$number_items,$offset);
        if($query->num_rows>0){
                return $query->result();
        }
    }
}
?>