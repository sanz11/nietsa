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
    
    public function EliminarTransaccionales(){
    	$this->db->truncate('cji_cotizacion');
    	$this->db->truncate('cji_cotizaciondetalle');
    	$this->db->truncate('cji_comprobante');
    	$this->db->truncate('cji_comprobantedetalle');
    	$this->db->truncate('cji_guiarem');
    	$this->db->truncate('cji_guiaremdetalle');
    	$this->db->truncate('cji_guiasa');
    	$this->db->truncate('cji_guiasadetalle');
    	$this->db->truncate('cji_guiain');
    	$this->db->truncate('cji_guiaindetalle');
    	$this->db->truncate('cji_guiatrans');
    	$this->db->truncate('cji_guiatransdetalle');
    	$this->db->truncate('cji_ordencompra');
    	$this->db->truncate('cji_ocompradetalle');
    	$this->db->truncate('cji_presupuesto');
    	$this->db->truncate('cji_presupuestodetalle');
    	$this->db->truncate('cji_nota');
    	$this->db->truncate('cji_notadetalle');
    	$this->db->truncate('cji_cuentas');
    	$this->db->truncate('cji_cuentasempresas');
    	$this->db->truncate('cji_cuentaspago');
    	$this->db->truncate('cji_pago');
    	$this->db->truncate('cji_kardex');
    	$this->db->truncate('cji_inventario');
    	$this->db->truncate('cji_inventariodetalle');
    	$this->db->truncate('cji_letra');
    }
    
    
    
}
?>