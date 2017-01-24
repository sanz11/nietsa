<?php
class Nacionalidad_model extends Model{
     var $somevar;
	function __construct(){
		parent::__construct();
		$this->load->database();
        $this->load->helper('date');
        $this->somevar ['compania'] = $this->session->userdata('compania');
        $this->somevar['hoy']              = mdate("%Y-%m-%d %h:%i:%s",time());
	}
	function listar_nacionalidad(){
		$query = $this->db->order_by('NACC_Descripcion')->where('NACC_FlagEstado','1')->get('cji_nacionalidad');
		if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;		
		}	
	}
	function obtener_nacionalidad($codigo){
		$query = $this->db->where('NACP_Codigo',$codigo)->get('cji_nacionalidad');
		if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;		
		}		
	}
}
?>