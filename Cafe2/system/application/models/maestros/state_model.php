<?php

class State_model extends Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('date');
		$this->somevar ['compania'] = $this->session->userdata('compania');
		$this->somevar ['usuario']  = $this->session->userdata('usuario');
		$this->somevar['hoy']       = mdate("%Y-%m-%d %h:%i:%s",time());
	}

	public function listar_estados($number_items='',$offset='')
	{
		$sql = "select * from cji_estate where STATE_Flag = 1 order by STATE_FechaRegistro ASC";
		$query = $this->db->query($sql);
		if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;
		}
	}

	public function insertar_state($filter)
	{

		$data = array(
				"STATE_Estado"        => $filter -> STATE_Estado,
				"DOCUP_Codigo" 	  => $filter -> DOCUP_Codigo,
				"STATE_Color" => $filter -> STATE_Color,
				"STATE_Descripcion"     => $filter -> STATE_Descripcion,
				"STATE_Flag" => '1'
		);
		$this->db->insert("cji_estate",$data);
		return $this->db->insert_id();
	}

	public function eliminar_state($codigo)
	{
		$data  = array("STATE_Flag"=>'0');
		$where = array("STATE_Codigo"=>$codigo);
		$this->db->where($where);
		$this->db->update('cji_estate',$data);

	}
	public function listar_estadosCotizacion($codigo){
		$this->db->select('STATE_Codigo,STATE_Estado,DOCUP_Codigo');
		$where = array('STATE_Flag' =>'1','DOCUP_Codigo'=>$codigo);
		$query = $this->db->where($where)->get('cji_estate');
		if ($query->num_rows > 0) {
			foreach ($query->result() as $fila) {
				$data[] = $fila;
			}
			return $data;
		}
	}

	public function buscarcolor($filter){
		$sql = "select * from cji_estate where STATE_Flag = 1 and STATE_Codigo=$filter";
		$query = $this->db->query($sql);
		if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;
		}
	}

	public function guardar_reportefinal($filter=null){
		$this->db->insert("cji_reportefinal",(array)$filter);
		return $this->db->insert_id();
	}

	public function buscar_reportefinal(){
		$sql = "select * from cji_reportefinal where REPORFIN_FlagEstado = 1";
		$query = $this->db->query($sql);
		if($query->num_rows > 0){
			foreach ($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;
		}
	}


}
?>