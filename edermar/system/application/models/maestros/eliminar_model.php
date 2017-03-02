<?php
class Eliminar_model extends Model
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
  
    public function Agregar_Tabla($ordAdj)
    {
    	$sql="$ordAdj";  	
    	$this->db->query($sql);
    	
    //	$this->db->insert("cji_usuario", $ordAdj);
    	 
    	
    }
    
    public function Eliminar_Tabla($ordAdj){
    	$sql="$ordAdj";
    	$this->db->query($sql);
    }
    
    public function EliminarTransaccionales($filtros){
    	
    	$sql="$filtros";
    	$this->db->query($sql);
    	
    	
    }
    
    
    
}
?>