<?php
class Tipocodigo_model extends Model{
     var $somevar;
	function __construct(){
		parent::__construct();
		$this->load->database();
        $this->load->helper('date');
        $this->somevar ['compania'] = $this->session->userdata('compania');
        $this->somevar['hoy']              = mdate("%Y-%m-%d %h:%i:%s",time());
	}
	function listar_tipo_codigo(){
		$query = $this->db->order_by('TIPCOD_Inciales')->where('TIPCOD_FlagEstado','1')->get('cji_tipocodigo');
		if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;		
		}
	}
	function obtener_tipoDocumento($tipo){
		$query = $this->db->where('TIPCOD_Codigo',$tipo)->get('cji_tipocodigo');
		if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;		
		}		
	}
}
?>