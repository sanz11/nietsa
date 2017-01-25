<?php
class Menu_model extends Model{
     var $somevar;
	function __construct(){
		parent::__construct();
		$this->load->database();
        $this->load->helper('date');
        $this->somevar ['compania'] = $this->session->userdata('compania');
        $this->somevar['hoy']              = mdate("%Y-%m-%d %h:%i:%s",time());
	}
	function obtener_datosMenu($menu){
		$query = $this->db->where('MENU_Codigo',$menu)->get('cji_menu');
		if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;		
		}			
	}
	
	public function obtener_x_url($url){
		$query = $this->db->where('MENU_Url',$url)->get('cji_menu');
		if($query->num_rows>0){
			foreach($query->result() as $fila){
				$data[] = $fila;
			}
			return $data;		
		}
	}

}
?>