<?php

class Tipocambio_Model extends Model {

    protected $_name = "cji_tipocambio";

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->somevar['compania'] = $this->session->userdata('compania');
        date_default_timezone_set("America/Lima");
    }

    public function cambioxdia($fecha_dia) {
        $this->db->where("TIPCAMC_Fecha", "$fecha_dia");
        $query = $this->db->get('cji_tipocambio');
        if ($query->num_rows > 0) {
            return $query->result();
        }
    }

    public function obtener_tdcxfactura($fecha) {
        $this->db->select('TIPCAMC_FactorConversion')->where("TIPCAMC_Fecha", "$fecha");
        $query = $this->db->get('cji_tipocambio');
        if ($query->num_rows > 0) {
            return $query->result();
        }
    }

    public function listar($fecha = '', $number_items = '', $offset = '') {
        if ($fecha != '')
            $this->db->where('TIPCAMC_Fecha', $fecha);
        $this->db->where('TIPCAMC_FlagEstado', 1);
        $this->db->order_by('TIPCAMC_Fecha', 'desc');
        $this->db->group_by('TIPCAMC_Fecha');
        $query = $this->db->get('cji_tipocambio', $number_items, $offset);

        if ($query->num_rows > 0) {
            return $query->result();
        }
    }

    public function obtener($id) {
        $where = array("cji_tipocambio" => $id);
        $query = $this->db->where($where)->get('cji_tipocambio', 1);
        if ($query->num_rows > 0) {
            return $query->result();
        }
    }

    public function obtener2($moneda_id) {
        $where = array("TIPCAMC_MonedaOrigen" => 1, "TIPCAMC_MonedaDestino" => $moneda_id, "TIPCAMC_FlagEstado" => 1);
        $query = $this->db->order_by("TIPCAMP_Codigo", "desc")->where($where)->get('cji_tipocambio', 1);
        if ($query->num_rows > 0) {
            return $query->row();
        }
    }

    public function insertar(stdClass $filter = null) {
        $this->db->insert("cji_tipocambio", (array) $filter);
    }

    public function eliminar_varios(stdClass $filter = null) {
		 $where =NULL;
        if (isset($filter->TIPCAMC_Fecha) && $filter->TIPCAMC_Fecha != ""){
            $where = array("TIPCAMC_Fecha" => $filter->TIPCAMC_Fecha);
        }
		if($where!=NULL){
			$this->db->delete('cji_tipocambio', $where);
		}
       
    
	}

    public function buscar($filter, $number_items = '', $offset = '') {
        if (isset($filter->TIPCAMC_Fecha) && $filter->TIPCAMC_Fecha != "")
            $this->db->where('TIPCAMC_Fecha', $filter->TIPCAMC_Fecha);

        if (isset($filter->TIPCAMC_MonedaDestino) && $filter->TIPCAMC_MonedaDestino != "")
            $this->db->where('TIPCAMC_MonedaDestino', $filter->TIPCAMC_MonedaDestino);

        $query = $this->db->where('COMPP_Codigo', $this->somevar['compania'])
                ->where('TIPCAMC_FlagEstado', '1')
                ->order_by('TIPCAMC_Fecha', 'desc')
                ->get('cji_tipocambio', $number_items, $offset);
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    //PARA EL CASO DE LAS FECHAS VALIDAS DE NUESTRO TIPO DE CAMBIO
    public function obtener_x_fecha($fecha = "") {
        if ($fecha != '')
            $this->db->where('TIPCAMC_Fecha', $fecha);
        $this->db->where('TIPCAMC_FlagEstado', 1);
        $this->db->order_by('TIPCAMC_Fecha', 'desc');
        $this->db->group_by('TIPCAMC_Fecha');
        $query = $this->db->get('cji_tipocambio');
        if ($query->num_rows > 0) {
            return $query->result();
        }
    }

    public function obtener_tdc_dolar($fecha) {
        $query = $this->db->where('TIPCAMC_Fecha', "$fecha")->get('cji_tipocambio');
        if ($query->num_rows > 0) {
            return $query->result();
        }
    }  
	public function tdc_dolar_faltan_ingresar() {
	
        $query = $this->db->where('TIPCAMC_FactorConversion', "0.00")->get('cji_tipocambio');
        
		if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
				
    }
	public function tdc_dolar_ult() {

		$this->db->order_by('TIPCAMC_Fecha', 'desc');
		$this->db->limit('1');
        $query = $this->db->get('cji_tipocambio');
        if ($query->num_rows > 0) {
            return $query->result();
        }
		
		
    }


}

?>