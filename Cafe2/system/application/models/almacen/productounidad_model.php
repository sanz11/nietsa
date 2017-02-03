<?php
class Productounidad_model extends Model
{
    public function  __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->somevar['compania'] = $this->session->userdata('compania');
    }
 
    public function buscar($filter)
    {
        if(isset($filter->UNDMED_Codigo) && $filter->UNDMED_Codigo!="")
            $this->db->where('UNDMED_Codigo',$filter->UNDMED_Codigo);
        
        if(isset($filter->PROD_Codigo) && $filter->PROD_Codigo!="")
            $this->db->where('PROD_Codigo',$filter->PROD_Codigo);
        
        $query = $this->db->get('cji_productounidad');
        if($query->num_rows>0){
            foreach($query->result() as $fila){
                    $data[] = $fila;
            }
            return $data;
        }
    }
    public function obtener($producto_id,$unidad_id)
    {
        $where = array("PROD_Codigo"=>$producto_id,"UNDMED_Codigo"=>$unidad_id,"PRODUNIC_flagEstado"=>1);
        $query = $this->db->where($where)->get("cji_productounidad");
        if($query->num_rows>0){
            return $query->row();
        }
    }



    ////aumentado stv
    public function obtenerprincipal($producto_id)
    {
        $where = array("PROD_Codigo"=>$producto_id,"PRODUNIC_FlagPrincipal"=>1,"PRODUNIC_flagEstado"=>1);
        $query = $this->db->where($where)->get("cji_productounidad");
        if($query->num_rows>0){
            return $query->row();
        }
    }
    ////////////
    
    
    
    public function insertar(stdClass $filtros = null) {
    	$this->db->insert("cji_productounidad", (array) $filtros);
    }
    

}
?>