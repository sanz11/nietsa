<?php
class Notacreditodetalle_model extends Model{
    var $somevar;
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('date');
        $this->somevar ['compania'] = $this->session->userdata('compania');
        $this->somevar ['user']  = $this->session->userdata('user');
        $this->somevar['hoy']       = mdate("%Y-%m-%d %h:%i:%s",time());
    }
    public function listar($comprobante)
    {
        $where = array("CRED_Codigo"=>$comprobante,"CREDET_FlagEstado"=>"1");
        $query = $this->db->order_by('CREDET_Codigo')->where($where)->get('cji_creditodetalle');
        if($query->num_rows>0){
            foreach($query->result() as $fila){
                $data[] = $fila;
            }
            return $data;
        }
    }
    public function insertar($filter=null)
    {
		
        $this->db->insert('cji_creditodetalle',(array)$filter);
		
    }
     public function modificar($comprobante_detalle,$filter=null)
    {
        $where = array("CREDET_Codigo"=>$comprobante_detalle);
        $this->db->where($where);
        $this->db->update('cji_creditodetalle',(array)$filter);
    }
    public function eliminar($comprobante_detalle)
    {
        $data      = array("CREDET_FlagEstado"=>'0');
        $where = array("CREDET_Codigo"=>$comprobante_detalle);
        $this->db->where($where);
        $this->db->update('cji_creditodetalle',$data);
    }
    
    public function reporte_ganancia($producto, $f_ini, $f_fin, $companias='')
    {       $where = array('c.CRED_Fecha >='=>$f_ini,'c.CRED_Fecha <='=>$f_fin, 'c.CRED_TipoOperacion'=>'V', 'd.CREDET_FlagEstado'=>'1');
            if($producto!='')
                $where['d.PROD_Codigo']=$producto;
            
            $companias=is_array($companias) ? $companias :  array($this->somevar['compania']);
            
            $query = $this->db->where($where)
                              ->where_in('c.COMPP_Codigo', $companias)
                              ->join('cji_credito c', 'c.CRED_Codigo = d.CRED_Codigo', 'left')
                              ->join('cji_producto p', 'p.PROD_Codigo = d.PROD_Codigo', 'left')
                              ->join('cji_moneda m', 'm.MONED_Codigo = c.MONED_Codigo', 'left')
                              ->join('cji_compania co', 'co.COMPP_Codigo = c.COMPP_Codigo', 'left')
                              ->join('cji_emprestablecimiento ee', 'ee.EESTABP_Codigo = co.EESTABP_Codigo', 'left')
                              ->select('d.*, m.MONED_Simbolo, c.CRED_Fecha, c.COMPP_Codigo, ee.EESTABC_Descripcion, p.PROD_Nombre')->from('cji_creditodetalle d')->get();
            if($query->num_rows>0)
                return $query->result();
            else
                return array();
        
    }
    
}
?>