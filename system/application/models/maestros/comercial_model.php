<?php
class Comercial_model extends Model
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
	public function listar_comerciales($number_items='',$offset='')
	{
         //$compania = $this->somevar['compania'];"COMPP_Codigo"=>$compania,
         $where = array("SECCOMC_FlagEstado"=>"1");
		$query = $this->db->order_by('SECCOMC_Descripcion')->where_not_in('SECCOMP_Codigo','0')->where($where)->get('cji_sectorcomercial',$number_items,$offset);
		if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;
		}
	}
	public function obtener_comercial($comercial)
	{
		$query = $this->db->where('SECCOMP_Codigo',$comercial)->get('cji_sectorcomercial');
		if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;
		}
	}
	public function insertar_comercial($descripcion)
	{
         $compania = $this->somevar['compania'];
		$nombre = strtoupper($descripcion);
		$data = array(
                                "SECCOMC_Descripcion"=>$nombre,
                                "COMPP_Codigo"=>$compania
                                );
		$this->db->insert("cji_sectorcomercial",$data);
	}
	public function modificar_comercial($comercial,$nombre)
	{
		$nombre = strtoupper($nombre);
		$data  = array("SECCOMC_Descripcion"=>$nombre);
		$this->db->where("SECCOMP_Codigo",$comercial);
		$this->db->update('cji_sectorcomercial',$data);
	}
	public function eliminar_comercial($comercial)
	{
		$where = array("SECCOMP_Codigo"=>$comercial);
		$this->db->delete('cji_sectorcomercial',$where);
	}
	public function buscar_comerciales($filter,$number_items='',$offset='')
	{
            $this->db->where('COMPP_Codigo',$this->somevar['compania']);
            if(isset($filter->nombre_comercial) && $filter->nombre_comercial!='')
                $this->db->like('SECCOMC_Descripcion',$filter->nombre_comercial,'both');
            $this->db->where_not_in('SECCOMP_Codigo','0');
            $query = $this->db->get('cji_sectorcomercial',$number_items,$offset);
            
            if($query->num_rows>0){
                foreach($query->result() as $fila){
                        $data[] = $fila;
                }
                return $data;
            }
	}
}
?>