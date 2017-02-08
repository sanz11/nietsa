<?php
class Cuentaspago_Model extends Model
{
    protected $_name = "cji_cuentaspago";
    public function  __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->somevar ['compania']   = $this->session->userdata('compania');
    }
    
    public function listar($cuenta)
    {   $where = array("CUE_Codigo"=>$cuenta, "CPAGC_FlagEstado"=>'1');
        
        $query = $this->db
                        ->where($where)
                        ->join('cji_pago', 'cji_pago.PAGP_Codigo = cji_cuentaspago.PAGP_Codigo', 'left')
                        ->join('cji_moneda', 'cji_moneda.MONED_Codigo = cji_cuentaspago.MONED_Codigo', 'left')
                        ->select('cji_cuentaspago.*, cji_pago.PAGC_FechaOper, cji_pago.PAGC_Monto, cji_pago.PAGC_FormaPago, cji_pago.PAGC_Obs, cji_moneda.MONED_Simbolo')
                        ->get('cji_cuentaspago');
        if($query->num_rows>0)
            return $query->result();
        else
            return array();
    }
    
    public function listar_pago($pago)
    {   $where = array("cji_cuentaspago.PAGP_Codigo"=>$pago, "CPAGC_FlagEstado"=>'1');
        
        $query = $this->db
                        ->where($where)
                        ->join('cji_pago', 'cji_pago.PAGP_Codigo = cji_cuentaspago.PAGP_Codigo', 'left')
                        ->join('cji_moneda', 'cji_moneda.MONED_Codigo = cji_cuentaspago.MONED_Codigo', 'left')
                        ->join('cji_cuentas c', 'c.CUE_Codigo = cji_cuentaspago.CUE_Codigo', 'left')
                        ->join('cji_moneda m2', 'm2.MONED_Codigo = c.MONED_Codigo', 'left')
                        ->select('cji_cuentaspago.*, cji_pago.PAGC_FechaOper, cji_pago.PAGC_Monto, cji_pago.PAGC_FormaPago, cji_pago.PAGC_Obs, cji_moneda.MONED_Simbolo, c.CUE_FechaOper, m2.MONED_Simbolo MONED_Simbolo2, c.CUE_Monto')
                        ->get('cji_cuentaspago');
        if($query->num_rows>0){
          return $query->result();
        }
    }
    
    public function buscar_x_fechas($f_ini,$f_fin, $tipo_cuenta, $companias=''){
            $where = array('p.PAGC_FechaOper >='=>$f_ini,'p.PAGC_FechaOper <='=>$f_fin, 'p.PAGC_TipoCuenta'=>$tipo_cuenta, 'p.PAGC_FlagEstado'=>'1');
            $companias=is_array($companias) ? $companias :  array($this->somevar['compania']);
            
            $query = $this->db->where($where)
                              ->where_in('c.COMPP_Codigo', $companias)
                              ->join('cji_pago p', 'p.PAGP_Codigo = cp.PAGP_Codigo', 'left')
                              ->join('cji_moneda m', 'm.MONED_Codigo = p.MONED_Codigo', 'left')
                              ->join('cji_cuentas c', 'c.CUE_Codigo = cp.CUE_Codigo', 'left')
                              ->join('cji_moneda m2', 'm2.MONED_Codigo = c.MONED_Codigo', 'left')
                              ->select('p.*, m.MONED_Simbolo, c.CUE_FechaOper, m2.MONED_Simbolo MONED_Simbolo2, c.CUE_Monto, cp.CPAGC_Monto')->from('cji_cuentaspago cp')->get();
            if($query->num_rows>0)
                return $query->result();
            else
                return array();
    }
    
    public function insertar(stdClass $filter = null)
    {        
        $this->db->insert("cji_cuentaspago",(array)$filter);
        $id = $this->db->insert_id();
        return $id;
    }
    public function anular($cuentaspago){
        $data  = array("CPAGC_FlagEstado"=>'0');
        $this->db->where("CPAGP_Codigo",$cuentaspago);
        $this->db->update('cji_cuentaspago ',$data);
    }
   
   
}
?>