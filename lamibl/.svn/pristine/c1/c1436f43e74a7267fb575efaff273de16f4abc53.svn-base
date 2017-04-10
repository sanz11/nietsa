<?php
class Tipodocumento_model extends Model{
     var $somevar;
	function __construct(){
		parent::__construct();
		$this->load->database();
        $this->load->helper('date');
        $this->somevar ['compania'] = $this->session->userdata('compania');
        $this->somevar['hoy']              = mdate("%Y-%m-%d %h:%i:%s",time());
	}
	function listar_tipo_documento(){
		$query = $this->db->order_by('TIPOCC_Inciales')->where('TIPOCC_FlagEstado','1')->get('cji_tipdocumento');
		if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;		
		}
	}
	function obtener_tipoDocumento($tipo){
		$query = $this->db->where('TIPDOCP_Codigo',$tipo)->get('cji_tipdocumento');
		if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;		
		}		
	}
}
?>