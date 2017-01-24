<?php
class Estadocivil_model extends Model{
     var $somevar;
	function __construct(){
		parent::__construct();
		$this->load->database();
        $this->load->helper('date');
        $this->somevar ['compania'] = $this->session->userdata('compania');
        $this->somevar['hoy']              = mdate("%Y-%m-%d %h:%i:%s",time());
	}
	function listar_estadoCivil(){
		$query = $this->db->order_by('ESTCC_Descripcion')->where_not_in('ESTCP_Codigo','0')->where('ESTCC_FlagEstado','1')->get('cji_estadocivil');
		if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;		
		}		
	}
	function obtener_estadoCivil($codigo){
		$query = $this->db->where('ESTCP_Codigo',$codigo)->get('cji_estadocivil');
		if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;		
		}		
	}
}
?>