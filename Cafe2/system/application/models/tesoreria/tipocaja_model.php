<?php

class Tipocaja_model extends Model {

    var $somevar;

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('date');
        $this->somevar ['compania'] = $this->session->userdata('compania');
        $this->somevar['hoy'] = mdate("%Y-%m-%d %h:%i:%s", time());
    }
    public function insert_tipocaja($filter = null){
    	$this->db->insert("cji_tipocaja", (array) $filter);
        $tipocaja = $this->db->insert_id();
        return $tipocaja;
    }
    public function tipocaja_listar_buscar($filter, $number_items = '', $offset = '') {
        $compania = $this->somevar['compania'];
        
        $where = '';
       if(isset($filter->txtCodigoT) && $filter->txtCodigoT=="1"){
            $where.='and tipCa_Tipo= 1';
        }
        if(isset($filter->txtCodigoT) && $filter->txtCodigoT=="2"){
            $where.='and tipCa_Tipo= 2';
        }
        if(isset($filter->txtCodigoT) && $filter->txtCodigoT=="3"){
           $where.='and tipCa_Tipo= 1 or tipCa_Tipo= 2'; 
        }
        if (isset($filter->fechai) && $filter->fechai != '' && isset($filter->fechaf) && $filter->fechaf != ''){
        $where = ' and tipCa_FechaRegsitro BETWEEN "' . human_to_mysql($filter->fechai) . '" AND "' . human_to_mysql($filter->fechaf) . '"';
        }
      
       /* if (isset($filter->cliente) && $filter->cliente != '')
            $where.=' and cc.CLIP_Codigo=' . $filter->cliente;

        if (isset($filter->producto) && $filter->producto != '')
            $where.=' and p.PROYP_Codigo=' . $filter->producto;
        $limit = "";*/
        $limit = "";
        if ((string) $offset != '' && $number_items != ''){
            $limit = 'LIMIT ' . $offset . ',' . $number_items;
        }

        $sql = "SELECT tipCa_codigo,tipCa_Descripcion,	tipCa_Abreviaturas,tipCa_Tipo,UsuarioRegistro,UsuarioModificado,tipCa_fechaModificacion,tipCa_FechaRegsitro,COMPP_Codigo,tipCa_FlagEstado
                FROM  cji_tipocaja
                WHERE COMPP_Codigo =" . $compania . " " . $where . "".
                " GROUP BY  tipCa_codigo "." 
               
                  ORDER BY  tipCa_codigo desc " . $limit . "

                ";
        $query = $this->db->query($sql);
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
        return array();
    }
 public function getTipocaja($codigo){
 	 $where = array('tipCa_codigo' => $codigo);
        $query = $this->db->where($where)->get('cji_tipocaja');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
 }
 
 public function obtenerTipocaja($codigo){
 	$where = array('tipCa_codigo' => $codigo);
 	$query = $this->db->where($where)->get('cji_tipocaja');
 	if ($query->num_rows > 0) {
 		foreach ($query->result() as $fila) {
 			$data[] = $fila;
 		}
 		return $data;
 	}
 }
 public function tipocaja_modificar($codigo, $filter=null){
        $where = array("tipCa_codigo"=>$codigo);
        $this->db->where($where);
        $this->db->update('cji_tipocaja',(array)$filter);
   
 }
 public function getActualizarTipoCaja($codigo){
  
     $data  = array("tipCa_FlagEstado"=>'0');
    $this->db->where('tipCa_codigo',$codigo);
    $this->db->update('cji_tipocaja',$data);
 }

}

?>