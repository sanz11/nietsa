<?php
class Lote_Model extends Model
{
    protected $_name = "cji_lote";
    protected $_hoy;
    public function  __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->somevar['compania'] = $this->session->userdata('compania');
        $this->_hoy                = date("%Y-%m-%d %h:%i:%s",time());
    }
    public function seleccionar($default="")
    {
        $nombre_defecto = $default==""?":: Seleccione ::":$default;
        $arreglo = array(''=>$nombre_defecto);
        foreach($this->listar() as $indice=>$valor)
        {
            $indice1   = $valor->LOTP_Codigo;
            $valor1    = substr($valor->LOTC_FechaRegistro, 0,10);
            $arreglo[$indice1] = $valor1;
        }
        return $arreglo;
    }
    public function listar($prodcuto)
    {   $where = array('LOTC_FlagEstado'=>'1', 'PROD_Codigo'=>$prodcuto);
        $query = $this->db->order_by('LOTC_FechaRegistro', 'DESC')->join('cji_guiain g', 'g.GUIAINP_Codigo=l.GUIAINP_Codigo')->select('l.*, g.PROVP_Codigo, g.ALMAP_Codigo, g.GUIAINC_Fecha')->where($where)->get('cji_lote l');
        if($query->num_rows>0){
           return $query->result();
        }
        else
            return array();
    }
    public function buscar($producto, $proveedor, $fechaIni, $fechaFin)
    {   $where = array('LOTC_FlagEstado'=>'1', 'PROD_Codigo'=>$producto);
        if($proveedor!='')
            $where['g.PROVP_Codigo']=$proveedor;
        if($fechaIni!='' && $fechaFin!=''){
            $where['g.GUIAINC_Fecha >=']=$fechaIni;
            $where['g.GUIAINC_Fecha <=']=$fechaFin;
        }
        $query = $this->db->order_by('LOTC_FechaRegistro', 'DESC')->join('cji_guiain g', 'g.GUIAINP_Codigo=l.GUIAINP_Codigo')->select('l.*, g.PROVP_Codigo, g.ALMAP_Codigo, g.GUIAINC_Fecha')->where($where)->get('cji_lote l');
        if($query->num_rows>0){
           return $query->result();
        }
        else
            return array();
    }
    public function listar_lotes_recientes($producto, $dias_atras, $cantidad='')
    {   $where = array('l.LOTC_FlagEstado'=>'1', 'PROD_Codigo'=>$producto);
        $cantidad = $cantidad==='' ? $cantidad : 0;
        
        $query = $this->db->order_by('LOTC_FechaRegistro')
                          ->join('cji_guiain g', 'g.GUIAINP_Codigo=l.GUIAINP_Codigo')
                          ->select('l.*, g.PROVP_Codigo, g.ALMAP_Codigo, g.GUIAINC_Fecha')
                          ->where($where)
                          ->where('g.GUIAINC_Fecha>DATE_ADD(CURDATE(), INTERVAL -'.$dias_atras.' DAY)')
                          ->get('cji_lote l');
        if($query->num_rows>0){
            $result=$query->result();
            foreach($result as $indice=>$valor){
                if($valor->LOTC_Cantidad<=$cantidad)
                    unset($result[$indice]);
            }
            return $result;
        }
        else
            return array();
    }
    public function listar_lotes_recientes_ultimos($fecha_ini, $cant_minima)
    {   $where = array('l.LOTC_FlagEstado'=>'1', 'g.GUIAINC_Fecha >='=>$fecha_ini, 'l.LOTC_Cantidad >='=>$cant_minima);
        
        $query = $this->db->order_by('p.PROD_Nombre')
                          ->join('cji_guiain g', 'g.GUIAINP_Codigo=l.GUIAINP_Codigo')
                          ->join('cji_producto p', 'p.PROD_Codigo=l.PROD_Codigo')
                          ->select('p.PROD_Codigo, p.PROD_CodigoInterno, p.PROD_Nombre, p.PROD_UltimoCosto')
                          ->where($where)
                          ->group_by('p.PROD_Codigo, p.PROD_CodigoInterno, p.PROD_Nombre, p.PROD_UltimoCosto')  
                          ->get('cji_lote l');
        if($query->num_rows>0){
           return $query->result();
        }
        else
            return array();
    }
    public function obtener($id)
    {
        $where = array("LOTP_Codigo"=>$id);
        $query = $this->db->where($where)->get('cji_lote');
        if($query->num_rows>0){
          return $query->row();
        }
    }
	
	public function obtener2($codprod)
    {
        $where = array("PROD_Codigo"=>$codprod);
        $query = $this->db->where($where)->get('cji_lote');
        if($query->num_rows>0){
				foreach($query ->result() as $fila){
					$data[]=$fila;
				}
				
          return $data;
        }
    }
    public function insertar(stdClass $filter = null)
    {
        $this->db->insert("cji_lote",(array)$filter);
        return $this->db->insert_id();
    }
    public function modificar($id,$filter)
    {
        $this->db->where("LOTP_Codigo",$id);
        $this->db->update("cji_lote",(array)$filter);
    }
    public function eliminar($id)
    {
         $this->db->where("LOTP_Codigo",$id);
        $this->db->delete('cji_lote',array('LOTC_Cantidad' =>0));
    }
	//busqueda
	public function obtener_x_guia($prod_codigo,$guia)
    {
	  $where = array('LOTC_FlagEstado'=>'1', 'PROD_Codigo'=>$prod_codigo,'GUIAINP_Codigo'=>$guia);
        $query = $this->db->where($where)->get('cji_lote');
        if($query->num_rows>0){
           return $query->result();
        }
        else
            return array();
    }
	

    // LUIS 05/12/2012: La cantidad original del lote debería mantenerse, la cantidad actual solo la debe controlar la tabla almaprolote
    /*public function aumentar($lote_id,$cantidad)
    {
        $datos_lote = $this->obtener($lote_id);
        $cantidad_inicial = $datos_lote->LOTC_Cantidad;
        $filter3 = new stdClass();
        $filter3->LOTC_Cantidad = $cantidad_inicial+$cantidad;
        $filter3->LOTC_FechaModificacion = $this->_hoy;
        $this->lote_model->modificar($lote_id,$filter3);
    }
    public function disminuir($lote_id,$cantidad)
    {
        $datos_lote = $this->obtener($lote_id);
        $cantidad_inicial = $datos_lote->LOTC_Cantidad;
        $filter3 = new stdClass();
        $filter3->LOTC_Cantidad = $cantidad_inicial-$cantidad;
        $filter3->LOTC_FechaModificacion = $this->_hoy;
        $this->lote_model->modificar($lote_id,$filter3);
    }*/
}
?>