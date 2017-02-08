<?php
class Cargo_model extends Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
        $this->load->helper('date');
        $this->somevar ['compania'] = $this->session->userdata('compania');
         $this->somevar ['usuario']    = $this->session->userdata('usuario');
        $this->somevar['hoy']              = mdate("%Y-%m-%d %h:%i:%s",time());
	}
	public function listar_cargos($number_items='',$offset='')
	{
         $compania = $this->somevar['compania'];
         $where = array("COMPP_Codigo"=>$compania,"CARGC_FlagEstado"=>"1");
		$query = $this->db->order_by('CARGC_Descripcion')->where_not_in('CARGP_Codigo','0')->where($where)->get('cji_cargo',$number_items,$offset);
		if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;
		}
	}
	public function obtener_cargo($cargo)
	{
		$query = $this->db->where('CARGP_Codigo',$cargo)->get('cji_cargo');
		if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;
		}
	}
	public function insertar_cargo($descripcion)
	{
         $compania = $this->somevar['compania'];
		$nombre = strtoupper($descripcion);
		$data = array(
                                "CARGC_Descripcion"=>$nombre,
                                "COMPP_Codigo"=>$compania
                                );
		$this->db->insert("cji_cargo",$data);
	}
	public function modificar_cargo($cargo,$nombre)
	{
		$nombre = strtoupper($nombre);
		$data  = array("CARGC_Descripcion"=>$nombre);
		$this->db->where("CARGP_Codigo",$cargo);
		$this->db->update('cji_cargo',$data);
	}
	public function eliminar_cargo($cargo)
	{
		$where = array("CARGP_Codigo"=>$cargo);
		$this->db->delete('cji_cargo',$where);
	}
	public function buscar_cargos($filter,$number_items='',$offset='')
	{
            $this->db->where('COMPP_Codigo',$this->somevar['compania']);
            if(isset($filter->nombre_cargo) && $filter->nombre_cargo!='')
                $this->db->like('CARGC_Descripcion',$filter->nombre_cargo,'both');
            $this->db->where_not_in('CARGP_Codigo','0');
            $query = $this->db->get('cji_cargo',$number_items,$offset);
            
            if($query->num_rows>0){
                foreach($query->result() as $fila){
                        $data[] = $fila;
                }
                return $data;
            }
	}
}
?>