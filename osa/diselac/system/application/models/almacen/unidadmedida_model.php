<?php
class Unidadmedida_model extends model{
    var $somevar;
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('date');
        $this->somevar ['compania'] = $this->session->userdata('compania');
        $this->somevar['hoy']              = mdate("%Y-%m-%d %h:%i:%s",time());
    }
    public function seleccionar()
    {
        $arreglo = array(''=>':: Seleccione ::');
        foreach($this->listar() as $indice=>$valor)
        {
            $indice1   = $valor->UNDMED_Codigo;
            $valor1    = $valor->UNDMED_Descripcion;
            $arreglo[$indice1] = $valor1;
        }
        return $arreglo;
    }
    public function listar($number_items='',$offset='')
    {
        $query = $this->db->order_by('UNDMED_Descripcion')->where('UNDMED_FlagEstado','1')->get('cji_unidadmedida',$number_items,$offset);
        if($query->num_rows>0){
            foreach($query->result() as $fila){
                $data[] = $fila;
            }
            return $data;
        }
    }
    public function obtener($unidad)
    {
        $query = $this->db->where("UNDMED_Codigo",$unidad)->get("cji_unidadmedida");
        if($query->num_rows>0){
            foreach($query->result() as $fila){
                $data[] = $fila;
            }
            return $data;
        }
    }
    public function insertar(stdClass $filter = null)
    {
        $this->db->insert("cji_unidadmedida",(array)$filter);
    }
    public function modificar($id,$filter)
    {
        $this->db->where("UNDMED_Codigo",$id);
        $this->db->update("cji_unidadmedida",(array)$filter);
    }
    public function eliminar($id)
    {
        $this->db->delete('cji_unidadmedida',array('UNDMED_Codigo' => $id));
    }
    public function buscar($filter,$number_items='',$offset='')
    {
        $this->db->where("UNDMED_FlagEstado",1);
        if(isset($filter->UNDMED_Descripcion) && $filter->UNDMED_Descripcion!='')
            $this->db->like('UNDMED_Descripcion',$filter->UNDMED_Descripcion,'right');
        if(isset($filter->UNDMED_Simbolo) && $filter->UNDMED_Simbolo!='')
            $this->db->like('UNDMED_Simbolo',$filter->UNDMED_Simbolo,'right');
        $query = $this->db->get('cji_unidadmedida',$number_items,$offset);
        if($query->num_rows>0){
            return $query->result();
        }
    }
}
?>